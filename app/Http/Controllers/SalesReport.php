<?php

namespace App\Http\Controllers;
use App\Models\UserModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class SalesReport extends Controller
{
    
    public function index()
    {
        $user=UserModel::get();
        $product_name=ProductModel::get();
        return view('salesreport.index',compact('user','product_name'));
    }

   
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        //
    }
}
