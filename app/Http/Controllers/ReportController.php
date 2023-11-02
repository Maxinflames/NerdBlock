<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\genre;
use App\client;
use App\subscription;
use Session;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    //
    public function index()
    {
        return view('report.index');
    }

    public function show(/**Post $post**/)
    {

    }
    
    public function create(genre $genre)
    {
       
    }

    public function edit(/**Post $post**/)
    {

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
