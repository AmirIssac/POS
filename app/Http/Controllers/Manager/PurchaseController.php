<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Purchase;
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
}
