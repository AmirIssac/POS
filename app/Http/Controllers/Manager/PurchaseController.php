<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Purchase;
use App\PurchaseProduct;
use App\PurchaseRecord;
use App\Repository;
use App\Supplier;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    //
    public function index(){
        $user = Auth::user();
        $user = User::find($user->id);
        $repositories = $user->repositories;   // display all repositories for the owner|worker
        return view('manager.Purchases.index')->with(['repositories'=>$repositories]);    
    }

    public function add($id){
        $repository = Repository::find($id);
        // code generate
        do{
            $characters = '0123456789';
            $charactersLength = strlen($characters);
            $code = '';
            for ($i = 0; $i < 8; $i++)
            $code .= $characters[rand(0, $charactersLength - 1)];
            // check if code exist in this repository before
            $purchase = Purchase::where('repository_id',$repository->id)->where('code',$code)->first();
            }
            while($purchase);   // if the code exists before we generate new code
            //$suppliers = $repository->suppliers;
            $suppliers = Supplier::whereHas("repositories", function($q) use ($repository){ $q->where("repositories.id",$repository->id ); })->get();
            return view('manager.Purchases.add')->with(['repository'=>$repository,'code'=>$code,'suppliers'=>$suppliers]);
    }

    public function addSupplier($id){
        $repository = Repository::find($id);
        return view('manager.Purchases.add_supplier')->with(['repository'=>$repository]);
    }

    public function storeSupplier(Request $request,$id){
        $repository = Repository::find($id);
        $supplier = Supplier::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'account_num' => $request->account_num,
        ]);
        $repository->suppliers()->attach($supplier->id);  // pivot table

        return redirect(route('purchases.index'))->with('success','تم اضافة مورد جديد بنجاح');
    }

    public function showSuppliers($id){
        $repository = Repository::find($id);
        $suppliers = $repository->suppliers()->paginate(20);
        return view('manager.Purchases.show_suppliers')->with(['repository'=>$repository,'suppliers'=>$suppliers]);
    }

    public function editSupplierForm(Request $request){
        $supplier = Supplier::find($request->supplier_id);
        $repository = Repository::find($request->repository_id); // i need repo in next page
        return view('manager.Purchases.edit_supplier')->with(['supplier'=>$supplier,'repository'=>$repository]);
    }

    public function updateSupplier(Request $request){
        $supplier = Supplier::find($request->supplier_id);
        $supplier->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'account_num' => $request->account_num,
        ]);
        return redirect(route('purchases.index'))->with('success','تم تعديل بيانات المورد بنجاح');
    }

    public function deleteSupplier(Request $request){
        $supplier = Supplier::find($request->supplier_id);
        $supplier->delete();
        return redirect(route('purchases.index'))->with('success','تم حذف بيانات المورد بنجاح');
    }

    public function storePurchase(Request $request , $id){

        $validated = $request->validate([
            'supplier_id' => 'required',
        ]);

        $repository = Repository::find($id);
        $statistic = $repository->statistic;
        if($request->pay=='later')
            $payment = 'later';
        else // cash has two options
            {
                if($request->cash_option=='cashier'){
                    $payment = 'cashier';
                    $repository->update([
                    'balance' => $repository->balance - $request->sum,
                    ]);
                    $statistic->update([
                        'd_out_cashier' => $statistic->d_out_cashier + $request->sum,
                    ]);
                }
                else{
                    $payment = 'external';
                    $statistic->update([
                        'd_out_external' => $statistic->d_out_external + $request->sum,
                    ]);
                    }
            }
        $purchase = Purchase::create([
            'repository_id' => $repository->id,
            'user_id' => Auth::id(),
            'supplier_id' => $request->supplier_id,
            'code' => $request->code,
            'supplier_invoice_num' => $request->supplier_invoice_num,
            'total_price' => $request->sum,
            'payment' =>  $payment,
            'daily_report_check' => false,
        ]);
        $count = count($request->barcode);
        for($i=0;$i<$count;$i++){
            if($request->barcode[$i]){  // record exist (inserted)
                 PurchaseRecord::create([
                    'purchase_id' => $purchase->id,
                    'barcode' => $request->barcode[$i],
                    'name' => $request->name[$i],
                    'quantity' => $request->quantity[$i],
                    'price' => $request->price[$i],
                ]);
            }
        }
        return back()->with('success','تم انشاء فاتورة مشتريات بنجاح');
    }

    public function showPurchases($id){
        $repository = Repository::find($id);
        $purchases = $repository->purchases()->orderBy('created_at','DESC')->paginate(10);
        $suppliers = $repository->suppliers;
        return view('manager.Purchases.show_purchases')->with(['repository'=>$repository,'purchases'=>$purchases,'suppliers'=>$suppliers]);
    }

    public function showPurchaseDetails($id){
        $purchase = Purchase::find($id);
        return view('manager.Purchases.purchase_details')->with(['purchase'=>$purchase]);
    }

    /*public function showPurchaseRetrieveDetails($id){
        $purchase = Purchase::find($id);
        $retrieve = true;
        return view('manager.Purchases.purchase_details')->with(['purchase'=>$purchase,'retrieve'=>$retrieve]);
    }*/

    public function productsForm($id){
        $repository = Repository::find($id);
        return view('manager.Purchases.products_form')->with(['repository'=>$repository]);
    }

    public function storeProducts(Request $request , $id){
        $repository = Repository::find($id);
        $totalPrice=0;
        $count = count($request->barcode);    // number of records
        for($i=0;$i<$count;$i++){
            if($request->barcode[$i]){
             // query to check if product exist so we update the quantity column or if not we create new record
            $product = PurchaseProduct::where('repository_id',$repository->id)->where('barcode',$request->barcode[$i])->first();
            if($product)  // found it
            {
            $new_price = $request->price[$i];
            $product->update([
                'price' => $new_price,
            ]);
            }
        else{
            
            PurchaseProduct::create(
                [
                    'repository_id'=>$repository->id,
                    'barcode' => $request->barcode[$i],
                    'name_ar'=>$request->name[$i],
                    'name_en'=>$request->details[$i],
                    'price'=>$request->price[$i],
                ]
                );
        }
    }
        }
        return back()->with('success','   تمت الإضافة بنجاح     ');
    }

    public function getProductAjax($repo_id,$barcode){
        $product = PurchaseProduct::where('repository_id',$repo_id)->where('barcode',$barcode)->get(); // first record test
        return response($product);
    }

    /*public function showLaterPurchases($id){
        $repository = Repository::find($id);
        $purchases = $repository->purchases()->where('payment','later')->orderBy('created_at','DESC')->paginate(10);
        return view('manager.Purchases.later_purchases')->with(['repository'=>$repository,'purchases'=>$purchases]);
    }*/
    public function showLaterPurchases($id){
        $repository = Repository::find($id);
        $purchases = $repository->purchases()->where('status', '!=' , 'retrieved')->where('payment','later')->orderBy('created_at','DESC')->paginate(10);
        return view('manager.Purchases.show_purchases')->with(['repository'=>$repository,'purchases'=>$purchases]);
    }

    public function payLaterPurchase(Request $request , $id){
        $purchase = Purchase::find($id);
        $repository = $purchase->repository;
        $statistic = $repository->statistic;
        if($request->payment=='cashier'){
            // check first if cashier has this amount of money
            if($repository->balance >= $purchase->total_price){
                $payment = 'cashier';
                $repository->update([
                    'balance' => $repository->balance - $purchase->total_price,
                ]);
            $statistic->update([
                'd_out_cashier' => $statistic->d_out_cashier + $purchase->total_price,
            ]);
            }
            else
                return back()->with('fail','المبلغ المتوافر في الدرج أقل من المبلغ الاجمالي');
        }
        else{
            $payment = 'external';
            $statistic->update([
                'd_out_external' => $statistic->d_out_external + $purchase->total_price,
            ]);
        }
        $purchase->update([
            'payment' => $payment,
            'daily_report_check' => false,
        ]);
        return redirect(route('purchases.index'))->with('success','تم تسديد الفاتورة بنجاح');
    }

   /* public function retrieveIndex(Request $request,$id){
        $repository = Repository::find($id);
        $supplier = $repository->suppliers()->where('name',$request->search)->first();
        if($supplier){
        $purchases = Purchase::where('repository_id',$repository->id)
        ->where('status','!=','retrieved')
                  ->where('supplier_id',$supplier->id)->orderBy('created_at','DESC')->paginate(10);
        }
        else{
        $purchases = Purchase::where('repository_id',$repository->id)
        ->where('status','!=','retrieved')
        ->where(function($query) use ($request) {
            $query->where('code', $request->search)
                  ->orWhere('supplier_invoice_num', $request->search)
                  ; })->orderBy('created_at','DESC')->paginate(10);
        }
        $retrieve = true; // to check in blade and display retrieve button
        return view('manager.Purchases.show_purchases')->with(['purchases'=>$purchases,'retrieve'=>$retrieve]);
    } */

    public function retrieve($id){
        $purchase = Purchase::find($id);
        $repository = $purchase->repository;
        $purchase->update([
            'user_id' => Auth::user()->id,
            'status' => 'retrieved',
            'daily_report_check' => false,
        ]);
        //retrieve money if payment was by cashier
        if($purchase->payment == 'cashier')
        $repository->update([
            'balance' => $repository->balance + $purchase->total_price,
        ]);
        return back()->with('success','تم استرجاع الفاتورة بنجاح');
    }

    public function searchByDate(Request $request , $id){
        $repository = Repository::find($id);
        $purchases = $repository->purchases()->whereDate('created_at',$request->dateSearch)->orWhereDate('updated_at',$request->dateSearch)->paginate(10);
        return view('manager.Purchases.show_purchases')->with(['purchases'=>$purchases,'repository'=>$repository]);
    }

    public function search(Request $request , $id){
        $repository = Repository::find($id);
        /*$supplier = $repository->suppliers()->where('name',$request->search)->first();
        if($supplier){
        $purchases = Purchase::where('repository_id',$repository->id)
                  ->where('supplier_id',$supplier->id)->orderBy('updated_at','DESC')->paginate(10);
        }
        else{*/
        $purchases = Purchase::where('repository_id',$repository->id)
        ->where('code',$request->search)->orderBy('updated_at','DESC')->paginate(10);
        return view('manager.Purchases.show_purchases')->with(['purchases'=>$purchases,'repository'=>$repository]);
    }

    public function searchBySupplier(Request $request , $id){
        $repository = Repository::find($id);
        $suppliers = $repository->suppliers; // to send to blade filter
        $supplier = $repository->suppliers()->where('supplier_id',$request->supplier)->first();
        if($request->later){  // for search by highest suppliers we should pay in the dashboard and should not be retrieved
            $purchases = Purchase::where('repository_id',$repository->id)
            ->where('supplier_id',$supplier->id)->where('payment','later')->where('status','!=','retrieved')->orderBy('updated_at','DESC')->paginate(10);
        }
        else{
        $purchases = Purchase::where('repository_id',$repository->id)
                  ->where('supplier_id',$supplier->id)->orderBy('updated_at','DESC')->paginate(10);
        }
        return view('manager.Purchases.show_purchases')->with(['purchases'=>$purchases,'repository'=>$repository,'suppliers'=>$suppliers]);

    }
}
