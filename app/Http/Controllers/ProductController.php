<?php

namespace App\Http\Controllers;

use App\Models\cr;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sharingpage.product');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(id $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(id $id)
    {
        return view('admin.product.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, id $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(id $id)
    {
        //
    }
}
