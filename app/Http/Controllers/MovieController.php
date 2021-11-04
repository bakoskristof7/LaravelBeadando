<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        if (Auth::user()->is_admin) {
            $movies = Movie::withTrashed()->paginate(10);
        } else {
            $movies = Movie::all();
        }
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
        $data = $request->validate([
            'title' => 'required | max:255',
            'director' => 'required | max:128',
            'year' => 'required | integer | min: 1870 | max:'. date('Y'),
            'description' => 'nullable | max : 512',
            'length' =>'required | integer',
            'image' => 'nullable|file|mimes:jpg,png|max:2048'

        ], [
            'title.required' => 'A cím megadása kötelező',
            'title.max' => 'A cím hossza maximum 255 karakter',

            'director.required' => 'A rendező megadása kötelező',
            'director.max' => 'A rendező hossza maximum 255 karakter',

            'year.required' => 'Az év megadása kötelező',
            'year.integer' => 'Az év legyen egész szám',
            'year.min' => 'Az év értéke minimum 1870',
            'year.max' => 'Az év értéke maximum '. date('Y'),

            'description.max' => 'A leírás hossza maximum 512 karakter',

            'length.required' => 'A film hosszának megadása kötelező',
            'length.integer' => 'A film hossza legyen egész szám',

            'image.mimes' => 'Csak a jpg és png fájltípusok elfogadottak',
            'image.max' => 'A kép mérete maximum 2MB'

        ]);


        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $data['image'] = $file->hashName();
            Storage::disk('public')->put('movie_images/' . $data['image'], $file->get());
        }

        $movie = Movie::create($data);

        $request->session()->flash('movie_created', true);

        return redirect()->route('movies.show', $movie);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($movie_id)
    {
        $ratings = Rating::all();
        $users = User::all();
        $movie = Movie::withTrashed()->find($movie_id);

        return view('movies.show', compact('movie', 'ratings', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($movie_id)
    {
        $movie = Movie::withTrashed()->find($movie_id);
        return view('movies.edit', compact('movie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $movie_id)
    {

        $movie = Movie::withTrashed()->find($movie_id);

        $data = $request->validate([
            'title' => 'required | max:255',
            'director' => 'required | max:128',
            'year' => 'required | integer | min: 1870 | max:'. date('Y'),
            'description' => 'nullable | max : 512',
            'length' =>'required | integer',
            'image' => 'nullable|file|mimes:jpg,png|max:2048'

        ], [
            'title.required' => 'A cím megadása kötelező',
            'title.max' => 'A cím hossza maximum 255 karakter',

            'director.required' => 'A rendező megadása kötelező',
            'director.max' => 'A rendező hossza maximum 255 karakter',

            'year.required' => 'Az év megadása kötelező',
            'year.integer' => 'Az év legyen egész szám',
            'year.min' => 'Az év értéke minimum 1870',
            'year.max' => 'Az év értéke maximum '. date('Y'),

            'description.max' => 'A leírás hossza maximum 512 karakter',

            'length.required' => 'A film hosszának megadása kötelező',
            'length.integer' => 'A film hossza legyen egész szám',

            'image.mimes' => 'Csak a jpg és png fájltípusok elfogadottak',
            'image.max' => 'A kép mérete maximum 2MB'

        ]);

        $data['delete_image'] = false;

        if ($request->has('delete_image')){
            $data['delete_image'] = true;
            Storage::disk('public')->delete('movie_images/' . $movie->image);
            $data['image'] = null;
        } else {
            $data['image'] = $movie->image;
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $data['image'] = $file->hashName();

            if ($movie->image) {
                Storage::disk('public')->delete('movie_images/' . $movie->image);
            }

            Storage::disk('public')->put('movie_images/' . $data['image'], $file->get());
        }

        $movie->update($data);

        $request->session()->flash('movie_edited', true);

        return redirect()->route('movies.show', $movie->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie, Request $request)
    {
        if (Auth::user()->is_admin === 0) {
            return abort(403);
        }

        $this->authorize('delete', $movie);

        $deleted = $movie->delete();

        $request->session()->flash('movie_soft_deleted', $deleted);

        return redirect()->route('movies.show', $movie->id);
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

    public function restore($movie_id, Request $request){
        $movie = Movie::withTrashed()->find($movie_id);
        $movie = $movie->restore();

        $request->session()->flash('movie_restored', true);

        return redirect()->route('movies.show', $movie_id);
    }

}
