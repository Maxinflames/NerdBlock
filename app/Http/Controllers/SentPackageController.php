<?php

namespace App\Http\Controllers;

use App\sentpackage;

use Illuminate\Http\Request;

class SentPackageController extends Controller
{
    //
    public function index()
    {
        return view('sentpackage.index');
    }

    public function show(/**Post $post**/)
    {
        return view('sentpackage.show');
    }
    
    public function create()
    {
        return view('sentpackage.create');
    }

    public function edit(/**Post $post**/)
    {
        return view('sentpackage.edit');
    }

    // Likely will be given no functionality
    public function delete(/**Post $post**/)
    {

    }

    public function search()
    {

    }

    public function store()
    {

    }

    public function update()
    {

    }

    // Likely will be given no functionality
    public function destroy()
    {

    }
}
