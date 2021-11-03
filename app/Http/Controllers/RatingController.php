<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ratings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $slug, $id)
    {

        $data = $request->validate([
            'rating' => 'required |numeric|min:1|max:5',
            'comment' => 'max:255',
        ], [
            'rating.required' => 'Értékelés megadása kötelező.',
            'rating.min' => 'Az értékelés 1-5-ig terjed.',
            'rating.max' => 'Az értékelés 1-5-ig terjed.'
        ]);

        $data['user_id'] = Auth::id();

        $data['movie_id'] =  $id;

        $rating = Rating::create($data);

        $request->session()->flash('rating_created', $rating->id);

        return redirect()->route('movies.show', $rating->movie_id);
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
    public function edit($movie_id, $id)
    {
        return view('ratings.edit', compact('movie_id', 'id'));
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
        $data = $request->validate([
            'rating' => 'required |numeric|min:1|max:5',
            'comment' => 'max:255',
        ], [
            'rating.required' => 'Értékelés megadása kötelező.',
            'rating.min' => 'Az értékelés 1-5-ig terjed.',
            'rating.max' => 'Az értékelés 1-5-ig terjed.'
        ]);

        $data['user_id'] = Auth::id();

        $movie_id = Rating::find($id)->movie_id;

        $data['movie_id'] =  $movie_id;

        Rating::find($id)->update($data);

        $request->session()->flash('rating_edited', $id);

        return redirect()->route('movies.show', $movie_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Rating $rating)
    {

        if (!$rating->user_id || Auth::id() !== intval($rating->user_id)) {
            return abort(403);
        }

        $this->authorize('delete', $rating);

        $id = $rating->id;
        $movie_id = $rating->movie_id;

        if (!$rating->delete()) {
            return abort(500);
        }

        $request->session()->flash('rating_deleted', $id);

        return redirect()->route('movies.show', $movie_id);

    }


}
