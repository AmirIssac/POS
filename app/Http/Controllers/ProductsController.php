<?php

namespace App\Http\Controllers;

use App\Type;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    //
    public function index(){
        return view('dashboard.Products.index');
    }

    public function show(){
        $types = Type::paginate(10);
        return view('dashboard.Products.products')->with(['types'=>$types]);
    }

    public function storeType(Request $request){
            Type::create([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
            ]);
            return back()->with('success','تم اضافة النوع بنجاح');
    }
}
