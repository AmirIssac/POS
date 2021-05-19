<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\Product;
use App\Repository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellController extends Controller
{
    public function index(){
        $user = Auth::user();
        $user = User::find($user->id);
        $repositories = $user->repositories;   // display all repositories for the owner
        return view('manager.Sales.index')->with(['repositories'=>$repositories]);
    }

    public function createInvoiceForm($id){
        $repository = Repository::find($id);
        return view('manager.Sales.create_invoice')->with('repository',$repository);
    }

    /*public function invoiceDetails(Request $request , $id){
        $repository = Repository::find($id);
        $count = count($request->barcode);    // number of records
        $products = collect(new Product());
        $quantities=array();  // store the quantities by right order of course
        $invoice_total_price = 0 ;
        for($i=0;$i<$count;$i++){
            $product = Product::where('repository_id',$repository->id)->where('barcode',$request->barcode[$i])->get();
            //return $product;
            // check if product not exist that mean one of the barcode inserted is wrong
            if($product->isEmpty())
            return back()->with('fail','هنالك خطأ بإدخال الباركود الرجاء التأكد من صحة الإدخال');
            // check all the quantities if <= the stored quantity of stored products
            if($product[0]->quantity<$request->quantity[$i])
              return back()->with('fail','الكمية أكبر من المتوفر للقطعة'.'  '.$product[0]->name);
            $quantities[]=$request->quantity[$i];
            $products = $products->toBase()->merge($product);   // collections sum
            foreach($product as $pro)    // we need to use foreach because we deal with collection
            $price = $pro->price * $request->quantity[$i];
            $invoice_total_price += $price ;
        }
        return view('manager.Sales.show_invoice_beforePrint')->with([
            'repository'=>$repository,
            'products'=>$products,
            'quantities' => $quantities,
            'invoice_total_price' => $invoice_total_price,
            ]);
    }*/
   /* public function invoiceDetails(Request $request , $id){
        $repository = Repository::find($id);
        $count = count($request->barcode);    // number of records
        $products = collect(new Product());
        $invoice_total_price = 0 ;
        for($i=0;$i<$count;$i++){
            $product = Product::where('repository_id',$repository->id)->where('barcode',$request->barcode[$i])->get();
            // check if product not exist that mean one of the barcode inserted is wrong
            if($product->isEmpty())
            return back()->with('fail','هنالك خطأ بإدخال الباركود الرجاء التأكد من صحة الإدخال');
            // check all the quantities if <= the stored quantity of stored products
            if($product[0]->quantity<$request->quantity[$i])
              return back()->with('fail','الكمية أكبر من المتوفر للقطعة'.'  '.$product[0]->name);
            // check if product taked before so we dont craete new record to not make the invoice big we just add quantity
            if($products->contains('barcode',$product[0]->barcode)){
                $p = $request->quantity[$i];
                $products->where('barcode', $product[0]->barcode)->map(function ($item, $key) use ($p){    // we use map to change value in collection
                     $item->quantity = $item->quantity + $p;
                }); 
                $price = $product[0]->price * $request->quantity[$i];
                $invoice_total_price += $price ;
                continue;
            }
            $product[0]->quantity = $request->quantity[$i];
            $products = $products->toBase()->merge($product);   // collections sum
            foreach($product as $pro)    // we need to use foreach because we deal with collection
            $price = $pro->price * $request->quantity[$i];
            $invoice_total_price += $price ;
        }
        $date = now();  // invoice date
        return view('manager.Sales.show_invoice_beforePrint')->with([
            'repository'=>$repository,
            'products'=>$products,
            //'quantities' => $quantities,
            'invoice_total_price' => $invoice_total_price,
            'date' => $date,
            ]);
    } */

    public function invoiceDetails(Request $request , $id){
        $repository = Repository::find($id);
        //return $request->barcode;
        $count = count($request->barcode);    // number of records
        $products = collect(new Product());
        $invoice_total_price = 0 ;
        for($i=0;$i<$count;$i++){
            if(!$request->barcode[$i])    // null record
            continue;
            $product = Product::where('repository_id',$repository->id)->where('barcode',$request->barcode[$i])->get();
            // check if product not exist that mean one of the barcode inserted is wrong
            if($product->isEmpty())
            return back()->with('fail','هنالك خطأ بإدخال الباركود الرجاء التأكد من صحة الإدخال');
            // check all the quantities if <= the stored quantity of stored products
            if($product[0]->quantity<$request->quantity[$i])
              return back()->with('fail','الكمية أكبر من المتوفر للقطعة'.'  '.$product[0]->name);
            // check if product taked before so we dont craete new record to not make the invoice big we just add quantity
            if($products->contains('barcode',$product[0]->barcode)){
                $p = $request->quantity[$i];
                $products->where('barcode', $product[0]->barcode)->map(function ($item, $key) use ($p){    // we use map to change value in collection
                     $item->quantity = $item->quantity + $p;
                }); 
                $price = $product[0]->price * $request->quantity[$i];
                $invoice_total_price += $price ;
                continue;
            }
            $product[0]->quantity = $request->quantity[$i];
            $products = $products->toBase()->merge($product);   // collections sum
            foreach($product as $pro)    // we need to use foreach because we deal with collection
            $price = $pro->price * $request->quantity[$i];
            $invoice_total_price += $price ;
        }
        $date = now();  // invoice date
        return view('manager.Sales.show_invoice_beforePrint')->with([
            'repository'=>$repository,
            'products'=>$products,
            //'quantities' => $quantities,
            'invoice_total_price' => $invoice_total_price,
            'date' => $date,
            ]);
    }

    public function sell(Request $request , $id){
        $repository = Repository::find($id);
        $count = count($request->barcode);
        for($i=0;$i<$count;$i++){   // check all the quantities before any sell process
            $product = Product::where('repository_id',$repository->id)->where('barcode',$request->barcode[$i])->get();
            // check all the quantities if <= the stored quantity of stored products
            if($product[0]->quantity<$request->quantity[$i])
              return back()->with('fail','الكمية أكبر من المتوفر للقطعة'.'  '.$product[0]->name);
        }    
        for($i=0;$i<$count;$i++){
            $product = Product::where('repository_id',$repository->id)->where('barcode',$request->barcode[$i])->get();
            foreach($product as $prod)
            $new_quantity = $prod->quantity - $request->quantity[$i];
            $prod->update(
                [
                    'quantity' => $new_quantity,
                ]
                );
        }
        // update repository balance
        $repository->update(
            [
                'cash_balance' => $repository->cash_balance + $request->cashVal,
                'card_balance' => $repository->card_balance + $request->cardVal,
            ]
            );
        // store invoice in DB
        // store details as array of arrays
        $details = array(array());    // each array store details for on record (one product)
        for($i=0;$i<$count;$i++){
            $record = array("name"=>$request->name[$i],"detail"=>$request->details[$i],"price"=>$request->price[$i],"quantity"=>$request->quantity[$i]);
            $details[]=$record;
        }
        $details = serialize($details);
        if($request->delivered){
            $status = "delivered";
        }
        else{
            $status = "pending";
        }
        if($request->cash){
            $cash = true;
        }
        else{
            $cash = false;
        }       
        if($request->card){
            $card = true;
        }
        else{
            $card = false;
        } 
        if(!$request->cashVal){
            $cashVal = 0;
        }
        else{
            $cashVal = $request->cashVal;
        }
        if(!$request->cardVal){
            $cardVal = 0;
        }
        else{
            $cardVal = $request->cardVal;
        }
        Invoice::create(
            [
                'repository_id' => $repository->id,
                'user_id' => Auth::user()->id,
                'details' => $details,
                'total_price' => $request->total_price,
                'cash_check' => $cash,
                'card_check' => $card,
                'cash_amount' => $cashVal,
                'card_amount' => $cardVal,
                'status' => $status,
                'phone' => $request->phone,
                'created_at' => $request->date,
            ]
            );
        return redirect(route('create.invoice',$repository->id))->with('sellSuccess','تمت عملية البيع بنجاح');
    }

    public function showPending($id){
        $repository = Repository::find($id);
        $invoices = $repository->invoices()->where('status','pending')->paginate(5);
        return view('manager.Sales.show_pending_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
    }

    public function completeInvoiceForm($id){
        $invoice = Invoice::find($id);
        $repository = $invoice->repository;
        $date = now();  // invoice date
        return view('manager.Sales.complete_invoice')->with('invoice',$invoice)->with('repository',$repository)->with('date',$date);
    }

    public function completeInvoice(Request $request , $id){
        $invoice = Invoice::find($id);
        $repository = $invoice->repository;

        if($request->cash){
            $cash = true;
        }
        else{
            $cash = false;
        }       
        if($request->card){
            $card = true;
        }
        else{
            $card = false;
        } 
        if(!$request->cashVal){
            $cashVal = 0;
        }
        else{
            $cashVal = $request->cashVal;
        }
        if(!$request->cardVal){
            $cardVal = 0;
        }
        else{
            $cardVal = $request->cardVal;
        }
        $invoice->update(
            [
                'user_id' => Auth::user()->id,
                'cash_check' => $cash,
                'card_check' => $card,
                'cash_amount' => $invoice->cash_amount + $cashVal,
                'card_amount' => $invoice->card_amount + $cardVal,
                'status' => 'delivered',
                'created_at' => $request->date,
            ]
            );
            // add money to repository safe
            $repository->update(
                [
                    'cash_balance' => $repository->cash_balance + $request->cashVal,
                    'card_balance' => $repository->card_balance + $request->cardVal,
                ]
                );
                
                return redirect()->route('show.pending',[$repository->id])->with('completeSuccess','تمت عملية استكمال الفاتورة بنجاح');
    }
}
