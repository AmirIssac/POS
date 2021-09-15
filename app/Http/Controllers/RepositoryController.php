<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Repository;
use App\RepositoryCategory;
use App\Setting;
use App\Statistics;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RepositoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repositories = Repository::all();
        return view('dashboard.Repositories.index')->with('repositories',$repositories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = RepositoryCategory::all();
        $branches = Branch::all();
        // generate code for the new company   {{4 cells}}
        $branchesCount = Branch::all()->count();
        $branchesCount++;
        $code = str_pad($branchesCount, 4, '0', STR_PAD_LEFT);
        return view('dashboard.Repositories.add')->with(['categories'=>$categories,'branches'=>$branches,
                    'code' => $code,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'branch_id' => 'required',
        ];
    
        $customMessages = [
            'required' => __('settings.you_must_chose_branch'),
        ];
    
        $this->validate($request, $rules, $customMessages);
        if($request->branch_id == 'new'){  // new company/branch
            $branch = Branch::create([
                'company_code' => $request->company_code,
                'name' => $request->branch_name,
            ]);
            $repository = Repository::create([
                    'branch_id' => $branch->id,
                    'name' => $request->repositoryName,
                    'name_en' => $request->repositoryName_en,
                    'address' => $request->address,
                    'category_id'=>$request->category_id,
                ]);
        }
        else{  // repository attached to specific branch/company
            $repository = Repository::create([
                'branch_id' => $request->branch_id,
                'name' => $request->repositoryName,
                'name_en' => $request->repositoryName_en,
                'address' => $request->address,
                'category_id'=>$request->category_id,
            ]);
        }
        // open statistic record for this repository  (one-to-one relatioship)
        Statistics::create([
            'repository_id' => $repository->id,
        ]);
        Setting::create([
            'repository_id' => $repository->id,
        ]);
        if(!$request->exist){      // owner not exist before
       $user = User::create([
            'name' => $request->ownerName,
            'email' => $request->owneremail,
            'password' => Hash::make($request->ownerpassword),
            'phone' => $request->ownerphone,
        ]);
        if($request->category_id==1)
        $user->assignRole('مالك-مخزن');
        if($request->category_id==2)
        $user->assignRole('مالك-مخزن');
        $repository->users()->attach($user->id); //pivot table insert
       }
       else{    // owner exist before
        $user = User::where('email',$request->existemail)->get();
        $repository->users()->attach($user[0]->id);
       }
        return back()->with('success','تمت الاضافة بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    
}
