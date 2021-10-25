<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->truncate();
        DB::table('movies')->truncate();
        DB::table('ratings')->truncate();

        $this->call(UserSeeder::class);
        $this->call(MovieSeeder::class);
        $this->call(RatingSeeder::class);

        //Adatbázis kapcsolatok

        //Movie 1 - N Rating
        //User 1 - N Rating
        $movies = Movie::all();
        $users = User::all();

        Rating::all()->each(function ($rating) use (&$movies, &$users){
                    if ($users->isNotEmpty() && $movies->isNotEmpty()){
                        $randomUser = $users->random();
                        $randomMovie = $movies->random();

                        while ($randomUser->ratings->contains('movie_id',$randomMovie->id)) {
                            $randomUser = $users->random();
                            $randomMovie = $movies->random();
                        }

                        $rating->user()->associate($randomUser);
                        $rating->movie()->associate($randomMovie);
                        $rating->save();

                    }
        });



    }
}
