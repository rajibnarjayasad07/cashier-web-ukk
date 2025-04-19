<?php

namespace App\Http\Controllers;

use App\Models\id;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sharingpage.transaction');
    }

    /**
     * Show the form for ideating a new resource.
     */
    public function create()
    {
        return view('cashier.transaction.add');
    }

    /**
     * Store a newly ideated resource in storage.
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
        //
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
