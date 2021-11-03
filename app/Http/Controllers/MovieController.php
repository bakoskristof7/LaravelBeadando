<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store', 'destroy', 'update', 'edit']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::paginate(10);
        $ratings = Rating::all();
        return view('movies.index', compact('movies', 'ratings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('movies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(Movie $movie)
    {
        $ratings = Rating::all();
        $users = User::all();
        return view('movies.show', compact('movie', 'ratings', 'users'));
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

    public function toplist()
    {
        $users = User::all();
        $movies = Movie::all();

        $moviesByDesc = $movies->sortByDesc(function ($movie) {
            return $movie->ratings->avg('rating');
        });

        $moviesByDesc = $moviesByDesc->take(6);

        return view('movies.toplist', compact('moviesByDesc'));
    }

}
