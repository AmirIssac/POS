<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Imports\ProductsImport;
use App\Product;
use App\Repository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class RepositoryController extends Controller
{
    //
    public function index(){
        $user = Auth::user();
        $user = User::find($user->id);
        $repositories = $user->repositories;   // display all repositories for the owner|worker
        return view('manager.Repository.index')->with(['repositories'=>$repositories]);
    }
    public function addProductForm($id){
        $repository = Repository::find($id);
        return view('manager.Repository.add_product_form')->with('repository',$repository);
    }


    public function storeProduct(Request $request){
        $totalPrice=0;
        $count = count($request->barcode);    // number of records
        for($i=0;$i<$count;$i++){
             // query to check if product exist so we update the quantity column or if not we create new record
            $product = Product::where('repository_id',$request->repo_id)->where('barcode',$request->barcode[$i])->first();
            if($product)  // found it
            {
            $new_quantity = $product->quantity + $request->quantity[$i];
            $new_price = $request->price[$i];
            $product->update([
                'quantity' => $new_quantity,
                'price' => $new_price,
            ]);
            $totalPrice+=$request->total_price[$i];
            }
        else{
            Product::create(
                [
                    'repository_id'=>$request->repo_id,
                    'barcode' => $request->barcode[$i],
                    'name'=>$request->name[$i],
                    'details'=>$request->details[$i],
                    'quantity'=>$request->quantity[$i],
                    'price'=>$request->price[$i],
                ]
                );
            $totalPrice+=$request->total_price[$i];
        }

        }
        return back()->with('success','   تمت الإضافة بنجاح بمبلغ إجمالي   '.$totalPrice);
    }
    
    /*public function showProducts($id){
        $repository = Repository::find($id);
        $products = $repository->products;
        return view('manager.Repository.show_products')->with(['products'=>$products]);
    }*/

    public function showProducts($id){
        $repository = Repository::find($id);
        $products = $repository->productsAsc()->paginate(15);
        return view('manager.Repository.show_products')->with(['products'=>$products]);
    }

    public function importExcelForm($id){
        $repository = Repository::find($id);
        return view('manager.Repository.import_excel')->with('repository',$repository);    // i need repo id to put it as hidden input in the form  << its bad to put it as hidden input but the best way to put it in the action in form route
    }

    public function importExcel(Request $request,$id){
        //$repository = Repository::find($id);
        $file = $request->file('excel')->store('import/excel');  // its better to store it then import it in database for the cases of very large files
        //Excel::import(new ProductsImport($id),$file);
        (new ProductsImport($id))->import($file);
        return back()->with('success','تم استيراد الملف بنجاح');
    }
}
