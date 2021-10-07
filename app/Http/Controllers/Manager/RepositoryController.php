<?php

namespace App\Http\Controllers\Manager;

use App\Action;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Imports\ProductsImport;
use App\Imports\ProductsImportSpecial;
use App\Product;
use App\Record;
use App\Repository;
use App\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class RepositoryController extends Controller
{
    //
    public function index($id){
        $repository = Repository::find($id);
        return view('manager.Repository.index')->with(['repository'=>$repository]);
    }
    public function addProductForm($id){
        $repository = Repository::find($id);
        $types = Type::all();
        return view('manager.Repository.add_product_form')->with('repository',$repository)->with('types',$types);
    }


    public function storeProduct(Request $request){
        $totalPrice=0;
        $count = count($request->barcode);    // number of records
        for($i=0;$i<$count;$i++){
            if($request->barcode[$i]){
             // query to check if product exist so we update the quantity column or if not we create new record
            $product = Product::where('repository_id',$request->repo_id)->where('barcode',$request->barcode[$i])->first();
            if($product)  // found it
            {
            if($product->stored == true)
            $new_quantity = $product->quantity + $request->quantity[$i];
            else
            $new_quantity = 0;   // we give zero quantity for unstored products
            $new_price = $request->price[$i];
            $new_cost_price = $request->cost_price[$i];
            $new_stored = true;
            if($request->stored[$i] == 'no')
                $new_stored = false;
            $product->update([
                'quantity' => $new_quantity,
                'cost_price' => $new_cost_price,
                'price' => $new_price,
                'stored' => $new_stored,
            ]);
            $totalPrice+=$request->total_price[$i];
            }
        else{
            if($request->type) // special product
            {
                // check if accept min for this record
                if(in_array($i,$request->acceptmin))
                    $acceptmin = 1; // yes
                    else
                    $acceptmin = 0; //no
                $stored = true;
                if($request->stored[$i] == 'no')
                    $stored = false;
            if($stored)
            Product::create(
                [
                    'repository_id'=>$request->repo_id,
                    'type_id'=>$request->type[$i],
                    'barcode' => $request->barcode[$i],
                    'name_ar'=>$request->name[$i],
                    'name_en'=>$request->details[$i],
                    'quantity'=>$request->quantity[$i],
                    'cost_price'=>$request->cost_price[$i],
                    'price'=>$request->price[$i],
                    'accept_min' => $acceptmin,
                    'stored' => $stored,
                ]
                );
                else
                Product::create(
                    [
                        'repository_id'=>$request->repo_id,
                        'type_id'=>$request->type[$i],
                        'barcode' => $request->barcode[$i],
                        'name_ar'=>$request->name[$i],
                        'name_en'=>$request->details[$i],
                        'quantity'=>0,
                        'cost_price'=>$request->cost_price[$i],
                        'price'=>$request->price[$i],
                        'accept_min' => $acceptmin,
                        'stored' => $stored,
                    ]
                    );
                $totalPrice+=$request->total_price[$i];
            }
            else  // original product
            {
                $stored = true;
                if($request->stored[$i] == 'no')
                    $stored = false;
            if($stored)
            Product::create(
                [
                    'repository_id'=>$request->repo_id,
                    'barcode' => $request->barcode[$i],
                    'name_ar'=>$request->name[$i],
                    'name_en'=>$request->details[$i],
                    'quantity'=>$request->quantity[$i],
                    'cost_price'=>$request->cost_price[$i],
                    'price'=>$request->price[$i],
                    'stored' => $stored,
                ]
                );
            else
            Product::create(
                [
                    'repository_id'=>$request->repo_id,
                    'barcode' => $request->barcode[$i],
                    'name_ar'=>$request->name[$i],
                    'name_en'=>$request->details[$i],
                    'quantity'=>0,
                    'cost_price'=>$request->cost_price[$i],
                    'price'=>$request->price[$i],
                    'stored' => $stored,
                ]
                );
            $totalPrice+=$request->total_price[$i];
            }
        }
    }
        }
         // register record of this process
         $action = Action::where('name_ar','اضافة مخزون')->first();
         $info = array('target'=>'product','total_price'=>$totalPrice);  // تسجيل اجمالي قيمة المدخلات
         Record::create([
             'repository_id' => $request->repo_id,
             'user_id' => Auth::user()->id,
             'action_id' => $action->id,
             'note' => serialize($info),
         ]);
        return back()->with('success',__('alerts.add_success_by_total_price').$totalPrice);
    }
    
    /*public function showProducts($id){
        $repository = Repository::find($id);
        $products = $repository->products;
        return view('manager.Repository.show_products')->with(['products'=>$products]);
    }*/

    public function showProducts($id){
        $repository = Repository::find($id);
        //$products = $repository->productsAsc()->paginate(15);
        $products = $repository->products()->orderBy('updated_at','DESC')->paginate(15);
        return view('manager.Repository.show_products')->with(['products'=>$products,'repository'=>$repository]);
    }

    public function filterProducts(Request $request,$id){
        $repository = Repository::find($id);
        $arr = array('isStored'=>$request->isStored);
        $stored = 'unknown';
        $isStored = true;
        if($request->isStored == 'no')
            $isStored = false;
        if($request->isStored == 'all')
            $stored = 'all';
        if($stored == 'all'){
            $products = $repository->products()->orderBy('updated_at','DESC')->paginate(15);
            return view('manager.Repository.show_products')->with(['products'=>$products->appends($arr),'repository'=>$repository]);
        }
        else{
            $products = $repository->products()->where('stored',$isStored)->orderBy('updated_at','DESC')->paginate(15);
            return view('manager.Repository.show_products')->with(['products'=>$products->appends($arr),'repository'=>$repository]);
        }
    }

    public function importExcelForm($id){
        $repository = Repository::find($id);
        $types = Type::all();
        return view('manager.Repository.import_excel')->with(['repository'=>$repository , 'types' => $types]);    // i need repo id to put it as hidden input in the form  << its bad to put it as hidden input but the best way to put it in the action in form route
    }

    public function importExcel(Request $request,$id){
        $repository = Repository::find($id);
        $file = $request->file('excel')->store('import/'.$repository->id.'excel');  // its better to store it then import it in database for the cases of very large files
        //Excel::import(new ProductsImport($id),$file);
        if($repository->isSpecial())
        (new ProductsImportSpecial($id))->import($file);
        else
        (new ProductsImport($id))->import($file);
        return back()->with('success',__('alerts.file_import_success'));
    }

    public function getProductAjax($repo_id,$barcode){
        $product = Product::where('repository_id',$repo_id)->where('barcode',$barcode)->get(); // first record test
        return response($product);
    }

    public function getTypeNameAjax($type_id){
        $type = Type::find($type_id);
        return response($type);
    }

    public function editProductForm(Request $request){    // we use form input hidden to use id and not passing it into url
        $product = Product::find($request->product_id);
        $repository = Repository::find($request->repository_id); // i need repo in next page
        $types = Type::all();
        return view('manager.Repository.edit_product')->with(['product'=>$product,'repository'=>$repository,'types' => $types]);
    }

    public function updateProduct(Request $request){
        $product = Product::find($request->product_id);
        $repository = $product->repository;
        // check if we change the barcode and its equal to specific barcode so we cancel the updating proccess
        if($request->barcode != $request->old_barcode){
            $temp = Product::where('repository_id',$repository->id)->where('barcode',$request->barcode)->first();
            if($temp)
                return redirect(route('repository.index',$repository->id))->with('fail','هذا الباركود محجوز لمنتج سابق');
        }
        if($request->type){   // special form
            $stored = true;
            if($request->acceptmin)
                $acceptmin = 1;
            else
                $acceptmin=0;
            if($request->stored == 'no')
                {
                $stored = false;
                $request->quantity = 0;
                }
            $product->update([
                'type_id' => $request->type,
                'barcode' => $request->barcode,
                'name_ar' => $request->name,
                'name_en' => $request->details,
                'cost_price' => $request->cost_price,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'accept_min' => $acceptmin,
                'stored' => $stored,
            ]);
        }
        else // original form
         $product->update([
            'barcode' => $request->barcode,
            'name_ar' => $request->name,
            'name_en' => $request->details,
            'cost_price' => $request->cost_price,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);

        // register record of this process
        $action = Action::where('name_ar','تعديل منتج')->first();
        $info = array('target'=>'product','id'=>$product->id);
        Record::create([
            'repository_id' => $repository->id,
            'user_id' => Auth::user()->id,
            'action_id' => $action->id,
            'note' => serialize($info),
        ]);
        return redirect(route('repository.index',$repository->id))->with('editProductSuccess',__('alerts.product_edit_success').$product->name);
    }

    public function deleteProduct(Request $request){
        $product = Product::find($request->product_id);
        $repository = $product->repository;
        $product->delete();
        return redirect(route('repository.index',$repository->id))->with('deleteProductSuccess',__('alerts.product_delete_success'));
    }

    public function checkBarcodeAjax(Request $request,$id){
        $repository = Repository::find($id);
        if($request->barcode != $request->old_barcode){
            $temp = Product::where('repository_id',$repository->id)->where('barcode',$request->barcode)->first();
            if($temp)
                {
                    $status = 'error';
                    return response($status);
                }
            else{
                $status = 'success';
                return response($status);
            }
        }
        else{
            $status = 'success';
            return response($status);
        }
    }
}
