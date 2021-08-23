<?php

namespace App\Http\Controllers\Manager;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\Product;
use App\Repository;
use App\SavedRecipe;
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

    
   

    public function createSpecialInvoiceForm(Request $request,$id){
        $repository = Repository::find($id);
        // check if phone not inserted = make new invoice clicked in index
        if(!$request->phone){
            return view('manager.Sales.create_special_invoice')->with(['repository'=>$repository]);
        }
        $new = true;
        $name_generated = false;
        // get the owner of this repository to get customer archive from other sub repositories
        $users = $repository->users;
        foreach($users as $user)
            if($user->hasRole('مالك-مخزن'))
                $owner = $user;
        $sub_repositories = $owner->repositories()->where('category_id',2)->get();  // كل الافرع من النوع محل خاص

        // search for customer if exists before or create new one
        foreach($sub_repositories as $repository){
            $customer = Customer::whereHas("repositories", function($q) use ($repository){ $q->where("repositories.id",$repository->id ); })->where('phone',$request->phone)->first();
            if($customer)
                break;
        }
        
        if($customer) // customer exists before
            {
                $new = false;
                $customer_name = $customer->name;
                $prev_invoices = $customer->invoices;
                // check if customer has saved recipe
                $saved_recipe = $customer->savedRecipes()->get();
                //return $saved_recipe;
                if($saved_recipe && $saved_recipe->count()>0){
                    //$saved_recipe = $saved_recipe->pluck('recipe');
                    //$saved_recipe = unserialize($saved_recipe[0]);
                }
                 // code generate
                do{
                    $characters = '0123456789';
                    $charactersLength = strlen($characters);
                    $code = '';
                    for ($i = 0; $i < 8; $i++)
                    $code .= $characters[rand(0, $charactersLength - 1)];
                    // check if code exist in this repository before
                    $invoice = Invoice::where('repository_id',$repository->id)->where('code',$code)->first();
                    }
                    while($invoice);   // if the code exists before we generate new code
                $date = now();  // invoice date
                $repository = Repository::find($id);
                return view('manager.Sales.create_special_invoice')->with([
                    'repository'=>$repository,'customer_name'=>$customer_name,'phone'=>$request->phone,
                    'code' => $code,
                    'date' => $date,
                    'invoices' => $prev_invoices,
                    'saved_recipes' => $saved_recipe,
                    'new' => $new,
                    'name_generated' => $name_generated,
                    ]);
                    } // end customer exists before
        else{ // not exists before
        // check if customer name inserted
        if($request->name){
            $customer_name = $request->name;
        }
        else{ 
        // customer name generate
        $customer_name = 'customer-';
        do{
            $name_generated = true;
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $code = '';
            for ($i = 0; $i < 5; $i++)
            $code .= $characters[rand(0, $charactersLength - 1)];
            $customer_name .= $code;
            // check if name exist in this repository before
            $customer = Customer::whereHas("repositories", function($q) use ($repository){ $q->where("repositories.id",$repository->id ); })->where('name',$customer_name)->first();
            }
            while($customer);   // if the name exists before we generate new name
        } // end else
        // code generate
        do{
            $characters = '0123456789';
            $charactersLength = strlen($characters);
            $code = '';
            for ($i = 0; $i < 8; $i++)
            $code .= $characters[rand(0, $charactersLength - 1)];
            // check if code exist in this repository before
            $invoice = Invoice::where('repository_id',$repository->id)->where('code',$code)->first();
            }
            while($invoice);   // if the code exists before we generate new code
            $date = now();  // invoice date
            $repository = Repository::find($id);
            return view('manager.Sales.create_special_invoice')->with([
                'repository'=>$repository,'customer_name'=>$customer_name,'phone'=>$request->phone,
                'code' => $code,
                'date' => $date,
                'new' => $new,
                'name_generated' => $name_generated,
                ]);
    } // end customer not exists


       
    }

    
   
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
        // code generate
        do{
            $characters = '0123456789';
            $charactersLength = strlen($characters);
            $code = '';
            for ($i = 0; $i < 8; $i++)
            $code .= $characters[rand(0, $charactersLength - 1)];
            // check if code exist in this repository before
            $invoice = Invoice::where('repository_id',$repository->id)->where('code',$code)->first();
            }
            while($invoice);   // if the code exists before we generate new code
        $date = now();  // invoice date
        // tax
        $increment =($repository->tax * $invoice_total_price) / 100;
        $final_total_price = $invoice_total_price + $increment;
        return view('manager.Sales.show_invoice_beforePrint')->with([
            'repository'=>$repository,
            'products'=>$products,
            //'quantities' => $quantities,
            'invoice_total_price' => $invoice_total_price,
            'code' => $code,
            'date' => $date,
            'final_total_price' => $final_total_price,
            ]);
    }

  
    public function sell(Request $request , $id){
        $repository = Repository::find($id);
        $count = count($request->barcode);
    if($request->delivered){    // delivered invoice
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
    }
  else {   // hanging invoice
        for($i=0;$i<$count;$i++){   // check all the quantities before any sell process
            $product = Product::where('repository_id',$repository->id)->where('barcode',$request->barcode[$i])->get();
            // check all the quantities if <= the stored quantity of stored products
            if($product[0]->quantity<$request->del[$i])
              return back()->with('fail','الكمية أكبر من المتوفر للقطعة'.'  '.$product[0]->name);
        }    
        for($i=0;$i<$count;$i++){
            $product = Product::where('repository_id',$repository->id)->where('barcode',$request->barcode[$i])->get();
            foreach($product as $prod)
            $new_quantity = $prod->quantity - $request->del[$i];
            $prod->update(
                [
                    'quantity' => $new_quantity,
                ]
                );
        }
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
        if($request->delivered){  // delivered
        for($i=0;$i<$count;$i++){
            $record = array("barcode"=>$request->barcode[$i],"name_ar"=>$request->name[$i],"name_en"=>$request->details[$i],"cost_price"=>$request->cost_price[$i],"price"=>$request->price[$i],"quantity"=>$request->quantity[$i],"delivered"=>$request->quantity[$i]);
            $details[]=$record;
        }
        $details = serialize($details);
        }
        else{  // hanging
            for($i=0;$i<$count;$i++){
                $record = array("barcode"=>$request->barcode[$i],"name_ar"=>$request->name[$i],"name_en"=>$request->details[$i],"cost_price"=>$request->cost_price[$i],"price"=>$request->price[$i],"quantity"=>$request->quantity[$i],"delivered"=>$request->del[$i]);
                $details[]=$record;
            }
            $details = serialize($details);
        }
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
                'code' => $request->code,
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

    

    public function sellSpecialInvoice(Request $request , $id){
        // make sure we determine customer
        if(!$request->customer_phone || !$request->customer_name)
            return back()->with('failCustomer',__('alerts.input_customer_num'));
         // cash and card must have at least one of them a value
         /*if(!$request->cashVal && !$request->cardVal)
            return back()->with('failPayment','عملية الدفع غير صحيحة');*/
        $repository = Repository::find($id);
        $count = count($request->barcode);
        $count2 = count( $request->del);
        $delivered = true;
        // check if hanging or delivered
        if($count == $count2) // delivered
        {
                for($i=0;$i<$count;$i++){   // check all the quantities before any sell process
                    if($request->barcode[$i]){
                        $product = Product::where('repository_id',$repository->id)->where('barcode',$request->barcode[$i])->get();
                        // check all the quantities if <= the stored quantity of stored products
                        if($product){
                            // check all records for this barcode for quantity because the repeated values is available
                            $sum_quantity = 0;
                        for($j=0;$j<$count;$j++){
                            if($request->barcode[$j]){
                                if(strcmp($request->barcode[$j],$request->barcode[$i])==0)
                                    $sum_quantity = $sum_quantity + $request->quantity[$j];
                            }
                            if($product[0]->quantity<$sum_quantity){
                                //return 'كمية غير متوفرة فواتير مستلمة';
                                return back()->with('fail',__('alerts.amount_bigger_than_available').'  '.$product[0]->name);
                                }
                        }
                        if($product[0]->quantity<$request->quantity[$i]){
                        //return 'كمية غير متوفرة فواتير مستلمة';
                        return back()->with('fail',__('alerts.amount_bigger_than_available').'  '.$product[0]->name);
                        }

                        }
                    }    
                    
                } 
                for($i=0;$i<$count;$i++){
                    if($request->barcode[$i]){
                        $product = Product::where('repository_id',$repository->id)->where('barcode',$request->barcode[$i])->get();
                        if($product){
                        foreach($product as $prod)
                        $new_quantity = $prod->quantity - $request->quantity[$i];
                        $prod->update(
                            [
                                'quantity' => $new_quantity,
                            ]
                            );
                        }
                    }
                }   
        }  
        else // hanging
        {
            $delivered = false;
            for($i=0;$i<$count;$i++){   // check all the quantities before any sell process
                if($request->barcode[$i]){
                $product = Product::where('repository_id',$repository->id)->where('barcode',$request->barcode[$i])->get();
                // check if del this item
                if(in_array($i,$request->del)) // delivered
                if($product){
                    // check all records for this barcode for quantity because the repeated values is available
                    $sum_quantity = 0;
                for($j=0;$j<$count;$j++){
                    if($request->barcode[$j]){
                        if(strcmp($request->barcode[$j],$request->barcode[$i])==0 && in_array($j,$request->del)) // is this item delivered for quantity 
                            $sum_quantity = $sum_quantity + $request->quantity[$j];
                    }
                    if($product[0]->quantity<$sum_quantity){
                        //return 'كمية غير متوفرة فواتير معلقة';
                        return back()->with('fail',__('alerts.amount_bigger_than_available').'  '.$product[0]->name);
                        }
                }
                if($product[0]->quantity<$request->quantity[$i]){
                //return 'كمية غير متوفرة فواتير معلقة';
                return back()->with('fail',__('alerts.amount_bigger_than_available').'  '.$product[0]->name);
                }
                }
                }
            }    
            for($i=0;$i<$count;$i++){
                if($request->barcode[$i]){
                $product = Product::where('repository_id',$repository->id)->where('barcode',$request->barcode[$i])->get();
                if($product){
                if(in_array($i,$request->del)){ // delivered this item
                foreach($product as $prod)
                $new_quantity = $prod->quantity - $request->quantity[$i];
                $prod->update(
                    [
                        'quantity' => $new_quantity,
                    ]
                    );
                }
                }
                }
            }
            
        }
        // update repository balance
        $repository->update(
            [
                'cash_balance' => $repository->cash_balance + $request->cashVal,
                'card_balance' => $repository->card_balance + $request->cardVal,
                'stc_balance' => $repository->stc_balance + $request->stcVal,
                'balance' => $repository->balance + $request->cashVal,
            ]
            );
        // update month statistics
        $statistic = $repository->statistic;
        $statistic->update([
            'm_in_cash_balance' => $statistic->m_in_cash_balance + $request->cashVal,
            'm_in_card_balance' => $statistic->m_in_card_balance + $request->cardVal,
            'm_in_stc_balance' => $statistic->m_in_stc_balance + $request->stcVal,
        ]);
        // store invoice in DB
        // store details as array of arrays
        $details = array(array());    // each array store details for one record (one product)
        if($delivered){  // delivered
        for($i=0;$i<$count;$i++){
            if($request->barcode[$i]){
            $record = array("barcode"=>$request->barcode[$i],"name_ar"=>$request->name[$i],"name_en"=>$request->details[$i],"cost_price"=>$request->cost_price[$i],"price"=>$request->price[$i],"quantity"=>$request->quantity[$i],"delivered"=>$request->quantity[$i]);
            $details[]=$record;
            }
        }
        $details = serialize($details);
        }
        else{  // hanging
            for($i=0;$i<$count;$i++){
                if(in_array($i,$request->del)) // delivered Item
                {
                if($request->barcode[$i]){
                $record = array("barcode"=>$request->barcode[$i],"name_ar"=>$request->name[$i],"name_en"=>$request->details[$i],"cost_price"=>$request->cost_price[$i],"price"=>$request->price[$i],"quantity"=>$request->quantity[$i],"delivered"=>$request->quantity[$i]);
                $details[]=$record;
                }
                }
                else{  // hanging Item
                    if($request->barcode[$i]){
                    $record = array("barcode"=>$request->barcode[$i],"name_ar"=>$request->name[$i],"name_en"=>$request->details[$i],"cost_price"=>$request->cost_price[$i],"price"=>$request->price[$i],"quantity"=>$request->quantity[$i],"delivered"=>0);
                    $details[]=$record;
                    }
                }
            }
            $details = serialize($details);
        }
        if($delivered){
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
        if($request->stc){
            $stc = true;
        }
        else{
            $stc = false;
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
        if(!$request->stcVal){
            $stcVal = 0;
        }
        else{
            $stcVal = $request->stcVal;
        }
        
        if($request->recipe_radio == 0){  // BASIC RECIPE
        $recipe = array('add_r'=>$request->add_r,'axis_r'=>$request->axis_r,'cyl_r'=>$request->cyl_r,'sph_r'=>$request->sph_r,
                        'add_l'=>$request->add_l,'axis_l'=>$request->axis_l,'cyl_l'=>$request->cyl_l,'sph_l'=>$request->sph_l,
                        'ipd'=>$request->ipdval,);
        }
        else{  // additional recipe
            $recipe = array('name'=>$request->recipe_name[$request->recipe_radio-1],'add_r'=>$request->add_r_arr[$request->recipe_radio-1],'axis_r'=>$request->axis_r_arr[$request->recipe_radio-1],'cyl_r'=>$request->cyl_r_arr[$request->recipe_radio-1],'sph_r'=>$request->sph_r_arr[$request->recipe_radio-1],
                        'add_l'=>$request->add_l_arr[$request->recipe_radio-1],'axis_l'=>$request->axis_l_arr[$request->recipe_radio-1],'cyl_l'=>$request->cyl_l_arr[$request->recipe_radio-1],'sph_l'=>$request->sph_l_arr[$request->recipe_radio-1],
                        'ipd'=>$request->ipdval_arr[$request->recipe_radio-1],);
        }
        $recipe = serialize($recipe);

        // get the owner of this repository to get customer archive from other sub repositories
        $users = $repository->users;
        foreach($users as $user)
            if($user->hasRole('مالك-مخزن'))
                $owner = $user;
        $sub_repositories = $owner->repositories()->where('category_id',2)->get();  // كل الافرع من النوع محل خاص

        // search for customer if exists before or create new one
        foreach($sub_repositories as $repository){
            $customer = Customer::whereHas("repositories", function($q) use ($repository){ $q->where("repositories.id",$repository->id ); })->where('phone',$request->customer_phone)->first();
            if($customer)
                break;
        }
        $repository = Repository::find($id); // this repo
        if($customer){ // exists
            // check if this customer exist (in this sub repo)
            //$c = $customer->whereHas("repositories", function($q) use ($repository){ $q->where("repositories.id",$repository->id ); })->get();
            //if($c->count()>0){
                $customers = $repository->customers;  // customers of this sub repo
                if($customers->contains('id',$customer->id)){  // the customer exist in this sub repo before
                $customer->update(
                    [
                        'points' => $customer->points + 1,
                    ]
                    );
            }
            else{
                $repository->customers()->attach($customer->id);  // pivot table
                $customer->update(
                    [
                        'points' => $customer->points + 1,
                    ]
                    );
            }
        } 
        else{ // not exists before
        $customer = Customer::create(
            [
                'name' => $request->customer_name,
                'phone' => $request->customer_phone,
                'points' => 1,
            ]
            );
        $repository->customers()->attach($customer->id);  // pivot table
        }

        $remaining_amount = $request->total_price - ($cashVal + $cardVal + $stcVal); // for printing
        // calculate the discount by changing price
      $discount_by_change_price = 0;
      for($i=0;$i<$count;$i++){
        if($request->barcode[$i]){
            $product = Product::where('repository_id',$repository->id)->where('barcode',$request->barcode[$i])->get();
            if($product){
            foreach($product as $prod){
                $discount_by_change_price = $discount_by_change_price + (($prod->price - $request->price[$i]) * $request->quantity[$i]);
            }
            }
        }   
      }
        $discounting = $request->discountVal + $request->discount_by_value + $discount_by_change_price;
       $invoice = Invoice::create(
            [
                'repository_id' => $id,
                'user_id' => Auth::user()->id,
                'customer_id' => $customer->id,
                'code' => $request->code,
                'details' => $details,
                'recipe' => $recipe,
                'total_price' => $request->total_price,
                'discount' => $discounting,
                'cash_check' => $cash,
                'card_check' => $card,
                'stc_check' => $stc,
                'cash_amount' => $cashVal,
                'card_amount' => $cardVal,
                'stc_amount' => $stcVal,
                'tax' => $request->taxprint,
                'tax_code' => $repository->tax_code,
                'status' => $status,
                'phone' => $request->customer_phone,
                'created_at' => $request->date,
                'note' => $request->note,
            ]
            );
            
            
           /* // archive the recipe after sell proccess
            $saved = $customer->savedRecipes;
            if($saved->count()>0){
                $saved[0]->update([
                    'repository_id' => $repository->id,  // update recipe to newest sub repo
                    'user_id' => Auth::user()->id,
                    'recipe' => $recipe,
                ]);
            }
            else{
                SavedRecipe::create([
                    'repository_id' => $id,
                    'customer_id' => $customer->id,
                    'user_id' => Auth::user()->id,
                    'recipe' => $recipe,
                ]);
            } */

            // we should determin the sell proccess on which recipe are doing by radio check value
            if($request->recipe_radio == 0){  // the basic recipe
                $saved = $customer->savedRecipes()->where('name',null)->first();
                if($saved){
                    $saved->update([
                        'repository_id' => $repository->id,  // update recipe to newest sub repo
                        'user_id' => Auth::user()->id,
                        'recipe' => $recipe,
                    ]);
                }
                else{
                    SavedRecipe::create([
                        'repository_id' => $id,
                        'customer_id' => $customer->id,
                        'user_id' => Auth::user()->id,
                        'recipe' => $recipe,
                    ]);
                }
                
            }
            else{  // additional recipe
                $saved = $customer->savedRecipes()->where('name',$request->recipe_name[$request->recipe_radio-1])->first();
                if($saved){
                    $saved->update([
                        'repository_id' => $repository->id,  // update recipe to newest sub repo
                        'user_id' => Auth::user()->id,
                        'name' => $request->recipe_name[$request->recipe_radio-1],
                        'recipe' => $recipe,
                    ]);
                }
                else{
                    SavedRecipe::create([
                        'repository_id' => $id,
                        'customer_id' => $customer->id,
                        'user_id' => Auth::user()->id,
                        'name' => $request->recipe_name[$request->recipe_radio-1],
                        'recipe' => $recipe,
                    ]);
                }
            }

       // prepare to send data to print page
       $records = array(array());
       $temp=0;
       for($i=0;$i<$count;$i++){   
        if($request->barcode[$i] && $request->price[$i]){
            //return $request->del;
            if(in_array($i,$request->del))
                $del = 'نعم';
                else
                $del = 'لا';
        $records[]=array('barcode'=>$request->barcode[$i],'name_ar'=>$request->name[$i],'name_en'=>$request->details[$i],'cost_price'=>$request->cost_price[$i],'price'=>$request->price[$i],'quantity'=>$request->quantity[$i],'del'=>$del);
        }
      }

      $id = Auth::user()->id;
      $employee = User::find($id);
      $recipe_print = unserialize($recipe);
      // check if recipe values 0 so we dont print the recipe
      $is_recipe_null = false;
      if($recipe_print['add_r']=='0' && $recipe_print['axis_r']=='0' && $recipe_print['cyl_r']=='0' && $recipe_print['sph_r']=='0' && $recipe_print['add_l']=='0' && $recipe_print['axis_l']=='0' && $recipe_print['cyl_l']=='0' && $recipe_print['sph_l']=='0' && $recipe_print['ipd']=='0' )
        $is_recipe_null = true;
      
      return view('manager.Sales.print_special_invoice')->with([
          'records'=>$records,'num'=>count($records),'sum'=>$request->sum,'tax'=>$request->taxprint,'total_price'=>$request->total_price,
          'cash'=>$cashVal,'card'=>$cardVal,'stc'=>$stcVal,'repo_id'=>$repository->id,
          'discount' => $discounting,
          'date'=>$request->date,'repository' => $repository,
          'customer' => $customer,'employee'=>$employee,'note'=>$request->note,'remaining_amount'=>$remaining_amount,'invoice'=>$invoice,
          'recipe' => $recipe_print, 'is_recipe_null' => $is_recipe_null,
        ]);   // to print the invoice
    }

    public function showPending($id){
        $repository = Repository::find($id);
        $invoices = $repository->invoices()->where('status','pending')->orderBy('created_at','DESC')->paginate(20);
        //return view('manager.Sales.show_pending_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
        return view('manager.Reports.show_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
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
                    // get customer
                    $customer = $invoice->customer;
                    // check if delivered quantity <= quantity in store // new 6-8-2021
                    $count = count($request->barcode);
                    for($i=0;$i<$count;$i++){ 
                        if($request->barcode[$i]){
                            $product = Product::where('repository_id',$repository->id)->where('barcode',$request->barcode[$i])->get();
                            // check all the quantities if <= the stored quantity of stored products
                            if($product){
                                // check all records for this barcode for quantity because the repeated values is available
                                $sum_quantity = 0;
                            for($j=0;$j<$count;$j++){
                                if($request->barcode[$j]){
                                    if(strcmp($request->barcode[$j],$request->barcode[$i])==0)
                                        $sum_quantity = $sum_quantity + $request->quantity[$j];
                                        //return $sum_quantity;
                                }
                                if($product[0]->quantity<$sum_quantity){
                                    return back()->with('fail',__('alerts.amount_bigger_than_available').'  '.$product[0]->name);
                                    }
                            }
                            if($product[0]->quantity<$request->quantity[$i]){
                            return back()->with('fail',__('alerts.amount_bigger_than_available').'  '.$product[0]->name);
                            }
            
                            }
                        }    
                        
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
                    if($request->stc){
                        $stc = true;
                    }
                    else{
                        $stc = false;
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
                    if(!$request->stcVal){
                        $stcVal = 0;
                    }
                    else{
                        $stcVal = $request->stcVal;
                    }
                    // edit all delivered items to be equal to quantity
                    $array = unserialize($invoice->details);
                    for($i=1;$i<count($array);$i++){
                        $array[$i]['delivered'] = $array[$i]['quantity'];
                    }
                    $array = serialize($array);
                    $invoice->update(
                        [
                            'user_id' => Auth::user()->id,
                            'details' => $array,
                            'cash_check' => $cash,
                            'card_check' => $card,
                            'stc_check' => $stc,
                            'cash_amount' => $invoice->cash_amount + $cashVal,
                            'card_amount' => $invoice->card_amount + $cardVal,
                            'stc_amount' => $invoice->stc_amount + $stcVal,
                            'status' => 'delivered',
                            'created_at' => $request->date,
                            'transform' => 'p-d',
                            'daily_report_check' => false,
                            'monthly_report_check' => false,
                            'note' => $request->note,
                        ]
                        );
                        $employee = $invoice->user;
                        // add money to repository safe
                        $repository->update(
                            [
                                'cash_balance' => $repository->cash_balance + $request->cashVal,
                                'card_balance' => $repository->card_balance + $request->cardVal,
                                'stc_balance' => $repository->stc_balance + $request->stcVal,
                                'balance' => $repository->balance + $request->cashVal,
                            ]
                            );
                            // update month statistics
                            $statistic = $repository->statistic;
                            $statistic->update([
                                'm_in_cash_balance' => $statistic->m_in_cash_balance + $request->cashVal,
                                'm_in_card_balance' => $statistic->m_in_card_balance + $request->cardVal,
                                'm_in_stc_balance' => $statistic->m_in_stc_balance + $request->stcVal,
                            ]);
                        // delete the delivered products from repository
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
                        // prepare to send data to print page
                        $records = array(array());
                        for($i=0;$i<$count;$i++){   
                            if($request->barcode[$i] && $request->price[$i]){
                                $del = 'نعم'; // always yes
                            $records[]=array('barcode'=>$request->barcode[$i],'name_ar'=>$request->name_ar[$i],'price'=>$request->price[$i],'quantity'=>$request->quan[$i],'must_del'=>$request->quantity[$i],'del'=>$del);
                            }
                        }
                        $complete_invoice = true; // to check in blade if we sell invoice for first time or we are completing an invoice
                        $recipe = unserialize($invoice->recipe);
                        return view('manager.Sales.print_special_invoice')->with([
                            'records'=>$records,'num'=>count($records),'total_price'=>$request->total_price,
                            'extra_price'=>$request->extra_price,'cash'=>$cashVal,'card'=>$cardVal,'stc'=>$stcVal,'repo_id'=>$repository->id
                            ,'date'=>$request->date,'repository' => $repository,
                            'customer' => $customer,'employee'=>$employee,'complete_invoice'=>$complete_invoice,'invoice'=>$invoice,'note'=>$request->note,
                            'recipe' => $recipe,
                        ]);   // to print the invoice
                            } 

    public function saveSpecialInvoice(Request $request , $id){
        // make sure we determine customer
        if(!$request->customer_phone_s || !$request->customer_name_s)
            return back()->with('failCustomer',__('alerts.input_customer_num'));
        $repository = Repository::find($id);
        // check if customer exist in system before
        $customer = Customer::whereHas("repositories", function($q) use ($repository){ $q->where("repositories.id",$repository->id ); })->where('phone',$request->customer_phone_s)->first();
        $recipe = array('add_r'=>$request->add_rs,'axis_r'=>$request->axis_rs,'cyl_r'=>$request->cyl_rs,'sph_r'=>$request->sph_rs,
        'add_l'=>$request->add_ls,'axis_l'=>$request->axis_ls,'cyl_l'=>$request->cyl_ls,'sph_l'=>$request->sph_ls,
        'ipd'=>$request->ipdvals,);
        $recipe = serialize($recipe);
        if($customer){ // exist
           /* // check if this customer has already saved recipe so he cant save new one
            $saved = $customer->savedRecipes()->count();
            if($saved>0)
                return back()->with('hasSavedRecipeAlready','هذا الزبون يملك وصفة محفوظة مسبقا يجب استكمالها');
                */

            // check if this customer has already saved recipe so we update his recipe
            $saved = $customer->savedRecipes;
            if($saved->count()>0){
                $saved[0]->update([
                    'user_id' => Auth::user()->id,
                    'recipe' => $recipe,
                ]);
            }
            else{
                SavedRecipe::create([
                    'repository_id' => $repository->id,
                    'customer_id' => $customer->id,
                    'user_id' => Auth::user()->id,
                    'recipe' => $recipe,
                ]);
            }
        }
        else{ // not exist
            $customer = Customer::create([
                'name' => $request->customer_name_s,
                'phone' => $request->customer_phone_s,
                'points' => 0,
            ]);
            $repository->customers()->attach($customer->id); // pivot table
            SavedRecipe::create([
                'repository_id' => $repository->id,
                'customer_id' => $customer->id,
                'user_id' => Auth::user()->id,
                'recipe' => $recipe,
            ]);
        }
        return redirect(route('create.special.invoice',$repository->id))->with('saveSuccess',__('alerts.prescription_saved_success'));
    }

    public function retrieveIndex(Request $request , $id){
        $repository = Repository::find($id);
        $invoices = Invoice::where('repository_id',$repository->id)
        ->where('status','!=','retrieved')
        ->where(function($query) use ($request) {
            $query->where('phone', $request->search)
                  ->orWhere('code', $request->search); })->orderBy('created_at','DESC')->paginate(10);
        return view('manager.Sales.retrieve_invoice')->with(['invoices'=>$invoices,'repository'=>$repository]);
    }

      

    public function retrieveInvoice(Request $request,$id){
        $invoice = Invoice::find($id);
        //$repository = Repository::find($request->repo_id);
        $repository = $invoice->repository;
        $cash_retrieved = $invoice->cash_amount + $invoice->card_amount + $invoice->stc_amount;
        if($cash_retrieved > $repository->balance)
            return back()->with('fail',__('alerts.failed_retrieve_money_cashier_not_enough'));
        $records = unserialize($invoice->details); // array of arrays
        //foreach($records as $record)
        for($i=1;$i<count($records);$i++)
        {
            //return $records[$i];
            $product = Product::where('repository_id',$repository->id)->where('barcode',$records[$i]['barcode'])->first();
            $new_quantity = $product->quantity + floatval($records[$i]['delivered']);
            $product->update([   // retrieve the products to stock
                'quantity' => $new_quantity,
            ]);
        }
        // give the money back to the customer
        // !? for now we will do the back money just from cash for all cash and card and stc !?
        //if($invoice->daily_report_check==true){  // the invoice from another day so cash not affected
        if($invoice->dailyReports->count()>0){
        $repository->update([
            'balance' => $repository->balance - $cash_retrieved,
        ]);
        }
        else{
            $repository->update([
                'cash_balance' => $repository->cash_balance - $cash_retrieved,
                'balance' => $repository->balance - $cash_retrieved,
            ]);
        }
        // update month statistics
        $statistic = $repository->statistic;
        $statistic->update([
            'm_in_cash_balance' => $statistic->m_in_cash_balance - $cash_retrieved,
        ]);
        if($invoice->status=='delivered')
            $transform = 'd-r';
            else
            $transform = 'p-r';
        // change invoice status
        $invoice->update([
            'status' => 'retrieved',
            'created_at' => now(),
            'transform' => $transform,
            'daily_report_check' => false,
            'monthly_report_check' => false,
            'note' => $request->note,
        ]);
        return redirect(route('sales.index'))->with('retrievedSuccess',__('alerts.purchase_retrieve_success'));
    } 

    public function changePayment($id){   // form
        $invoice = Invoice::find($id);
        $repository = $invoice->repository;
        return view('manager.Sales.change_invoice_payment')->with(['invoice'=>$invoice,'repository'=>$repository]);
    }

    /*public function makeChangePayment(Request $request , $id){
        $invoice = Invoice::find($id);
        if($invoice->status == 'pending'){
            if($request->cash + $request->card + $request->stc > $invoice->total_price)
            return back()->with('fail','المبلغ المدفوع أكبر من قيمة الفاتورة');
        }
        elseif($invoice->status == 'delivered'){
            if($request->cash + $request->card + $request->stc != $invoice->total_price)
                return back()->with('fail','المبلغ المدفوع يجب أن يساوي القيمة الاجمالية للفاتورة');
        }
        $repository = $invoice->repository;
        $invoice->update([
            'cash_amount' => $request->cash,
            'card_amount' => $request->card,
            'stc_amount' => $request->stc,
        ]);
        // update repository balance
        $repository->update(
            [
                'cash_balance' => $repository->cash_balance + ($request->cash - $request->old_cash),
                'card_balance' => $repository->card_balance + ($request->card - $request->old_card),
                'stc_balance' => $repository->stc_balance + ($request->stc - $request->old_stc),
                'balance' => $repository->balance + ($request->cash - $request->old_cash),
            ]
            );
        // update month statistics
        $statistic = $repository->statistic;
        $statistic->update([
            'm_in_cash_balance' => $statistic->m_in_cash_balance + ($request->cash - $request->old_cash),
            'm_in_card_balance' => $statistic->m_in_card_balance + ($request->card - $request->old_card),
            'm_in_stc_balance' => $statistic->m_in_stc_balance + ($request->stc - $request->old_stc),
        ]);

        return back()->with('success')->with('success','تم التعديل بنجاح');
    }*/
    public function makeChangePayment(Request $request , $id){   // we must pay the same money value of the old payment but we change the methods of pay as we want
        $invoice = Invoice::find($id);
        if($request->cash + $request->card + $request->stc != $request->old_cash + $request->old_card + $request->old_stc)
            return back()->with('fail',__('alerts.payed_money_notequal_to_old'));
        $repository = $invoice->repository;
        $invoice->update([
            'cash_amount' => $request->cash,
            'card_amount' => $request->card,
            'stc_amount' => $request->stc,
        ]);
        // update repository balance
        $repository->update(
            [
                'cash_balance' => $repository->cash_balance + ($request->cash - $request->old_cash),
                'card_balance' => $repository->card_balance + ($request->card - $request->old_card),
                'stc_balance' => $repository->stc_balance + ($request->stc - $request->old_stc),
                'balance' => $repository->balance + ($request->cash - $request->old_cash),
            ]
            );
        // update month statistics
        $statistic = $repository->statistic;
        $statistic->update([
            'm_in_cash_balance' => $statistic->m_in_cash_balance + ($request->cash - $request->old_cash),
            'm_in_card_balance' => $statistic->m_in_card_balance + ($request->card - $request->old_card),
            'm_in_stc_balance' => $statistic->m_in_stc_balance + ($request->stc - $request->old_stc),
        ]);

        return back()->with('success')->with('success',__('alerts.edit_success'));
    }

    public function deleteInvoice($id){
        $invoice = Invoice::find($id);
        $repository = $invoice->repository;
        $records = unserialize($invoice->details); // array of arrays
        for($i=1;$i<count($records);$i++)
        {
            $product = Product::where('repository_id',$repository->id)->where('barcode',$records[$i]['barcode'])->first();
            $new_quantity = $product->quantity + floatval($records[$i]['delivered']);
            $product->update([   // retrieve the products to stock
                'quantity' => $new_quantity,
            ]);
        }
        if($invoice->status == 'delivered')
            $transform = 'd-x';
        if($invoice->status == 'pending')
            $transform = 'p-x';
        $invoice->update([
            'status' => 'deleted',
            'transform' => $transform,
            'created_at' => now(),
        ]);

        // back money
        $repository->update([
            'cash_balance' => $repository->cash_balance - $invoice->cash_amount,
            'card_balance' => $repository->card_balance - $invoice->card_amount,
            'stc_balance' => $repository->stc_balance - $invoice->stc_amount,
            'balance' => $repository->balance - $invoice->cash_amount,
        ]);
        // update month statistics
        $statistic = $repository->statistic;
        $statistic->update([
            'm_in_cash_balance' => $statistic->m_in_cash_balance - $invoice->cash_amount,
            'm_in_card_balance' => $statistic->m_in_card_balance - $invoice->card_amount,
            'm_in_stc_balance' => $statistic->m_in_stc_balance - $invoice->stc_amount,
        ]);

        return back()->with('success',__('alerts.delete_success'));
    }
}
