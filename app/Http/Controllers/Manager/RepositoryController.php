<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Product;
use App\Repository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepositoryController extends Controller
{
    //
    public function index(){
        $user = Auth::user();
        $user = User::find($user->id);
        $repositories = $user->repositories;   // display all repositories for the owner
        return view('manager.Repository.index')->with(['repositories'=>$repositories]);
    }
    public function addProductForm($id){
        $repository = Repository::find($id);
        return view('manager.Repository.add_product_form')->with('repository',$repository);
    }
    public function storeProduct(Request $request){
        // query to check if product exist so we update the quantity column or if not we create new record
        $product = Product::where('repository_id',$request->repo_id)->where('details',$request->details)->first();
        if($product)  // found it
            {
            $new_quantity = $product->quantity + $request->quantity;
            $new_price = $request->price;
            $product->update([
                'quantity' => $new_quantity,
                'price' => $new_price,
            ]);
            }
        else{
        Product::create(
            [
                'repository_id'=>$request->repo_id,
                'details'=>$request->details,
                'price'=>$request->price,
                'quantity'=>$request->quantity,
            ]
            );
        }
        return back()->with('success','تمت الاضافة بنجاح');
    }
    
    public function showProducts($id){
        $repository = Repository::find($id);
        $products = $repository->products;
        return view('manager.Repository.show_products')->with(['products'=>$products]);
    }
}
