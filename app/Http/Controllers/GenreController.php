<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\genre;
use Session;

class GenreController extends Controller
{

    //
    public function index()
    {
        $genres = genre::all();
        return view('genre.index', compact('genres'));
    }
    
    public function create()
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A')
            {
                return view('genre.create');
            }
        }
        return redirect('/');
    }

    public function edit(genre $genre)
    {
        if(Session::has('active_user'))
        {
            if (session()->get('user_type') == 'A')
            {
                return view('genre.edit', compact('genre'));
            }
        }
        return redirect('/');
    }

    // Likely will be given no functionality
    public function delete(/**Post $post**/)
    {

    }

    public function search()
    {
        // Takes given id, 
        $text = request('search_text');

        $genres = genre::select(['genre.*'])
        ->where('genre_title', 'like', '%' . $text . '%')
        ->orwhere('genre_description', 'like', '%' . $text . '%')
        ->get();

        $count = genre::select(['genre.*'])
        ->where('genre_title', 'like', '%' . $text . '%')
        ->orwhere('genre_description', 'like', '%' . $text . '%')
        ->count();

        // If the post exists that is equal to Id, redirect to the view page
        if ($count != 0) {

            return view('genre.index', compact('genres'));
        }

        // Otherwise, redirect back to user index, with a server variable status initialized 
        else {
            session()->put('search_error', 'No matches found!');
            return redirect('/catalogue');
        }
    }

    public function store()
    {
        $this->validate(request(), [
            'genre_title' => 'required|string|max:50',
            'genre_description' => 'required|string|max:255',
        ]);

        genre::create([
            'genre_title' => request('genre_title'),
            'genre_description' => request('genre_description'),
        ]);
        return redirect('/catalogue');
    }

    public function update()
    {
        $this->validate(request(), [
            'genre_title' => 'required|string|max:50',
            'genre_description' => 'required|string|max:255',
        ]);
        
        genre::where('genre_id', request('genre_id'))->update([
            'genre_title' => request('genre_title'),
            'genre_description' => request('genre_description'),
        ]);

        return redirect('/catalogue');
    }

    // Likely will be given no functionality
    public function destroy()
    {

    }
}
