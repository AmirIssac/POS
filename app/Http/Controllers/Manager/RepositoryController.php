<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Imports\ProductsImport;
use App\Imports\ProductsImportSpecial;
use App\Product;
use App\Repository;
use App\Type;
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
            if($request->barcode[$i]){
             // query to check if product exist so we update the quantity column or if not we create new record
            $product = Product::where('repository_id',$request->repo_id)->where('barcode',$request->barcode[$i])->first();
            if($product)  // found it
            {
            $new_quantity = $product->quantity + $request->quantity[$i];
            $new_price = $request->price[$i];
            $new_cost_price = $request->cost_price[$i];
            $product->update([
                'quantity' => $new_quantity,
                'cost_price' => $new_cost_price,
                'price' => $new_price,
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
                ]
                );
            }
            else  // original product
            Product::create(
                [
                    'repository_id'=>$request->repo_id,
                    'barcode' => $request->barcode[$i],
                    'name_ar'=>$request->name[$i],
                    'name_en'=>$request->details[$i],
                    'quantity'=>$request->quantity[$i],
                    'cost_price'=>$request->cost_price[$i],
                    'price'=>$request->price[$i],
                ]
                );
            $totalPrice+=$request->total_price[$i];
        }
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
        return view('manager.Repository.show_products')->with(['products'=>$products,'repository'=>$repository]);
    }

    public function importExcelForm($id){
        $repository = Repository::find($id);
        return view('manager.Repository.import_excel')->with('repository',$repository);    // i need repo id to put it as hidden input in the form  << its bad to put it as hidden input but the best way to put it in the action in form route
    }

    public function importExcel(Request $request,$id){
        $repository = Repository::find($id);
        $file = $request->file('excel')->store('import/'.$repository->id.'excel');  // its better to store it then import it in database for the cases of very large files
        //Excel::import(new ProductsImport($id),$file);
        if($repository->isSpecial())
        (new ProductsImportSpecial($id))->import($file);
        else
        (new ProductsImport($id))->import($file);
        return back()->with('success','تم استيراد الملف بنجاح');
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
        return view('manager.Repository.edit_product')->with(['product'=>$product,'repository'=>$repository]);
    }

    public function updateProduct(Request $request){
        $product = Product::find($request->product_id);
        if($request->type){   // special form
            if($request->acceptmin)
                $acceptmin = 1;
            else
                $acceptmin=0;
            $product->update([
                'type_id' => $request->type,
                'barcode' => $request->barcode,
                'name_ar' => $request->name,
                'name_en' => $request->details,
                'cost_price' => $request->cost_price,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'accept_min' => $acceptmin,
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
        return redirect(route('repository.index'))->with('editProductSuccess',' تم تعديل المنتج '.$product->name.' بنجاح ');
    }

    public function deleteProduct(Request $request){
        $product = Product::find($request->product_id);
        $product->delete();
        return redirect(route('repository.index'))->with('deleteProductSuccess','تم حذف المنتج بنجاح');
    }
}
