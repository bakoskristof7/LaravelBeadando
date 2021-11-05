<x-guest-layout>

    @auth
        @if (Auth::user()->is_admin)
                <div class="container mx-auto px-16 pt-14">
                    <div>
                        <a href="{{route('movies.create')}}" class="border bg-green-400 border-green-800 rounded py-4 px-6 font-semibold hover:bg-green-500">Új film</a>
                    </div>
                </div>
        @endif
    @endauth

    <div class="container mx-auto px-4 p-12">
        <div class="px-12 tracking-wider uppercase text-black text-xl font-extrabold">
            <h2>Elérhető filmek</h2>
        </div>
    </div>

    <div class="px-2 container md:mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 justify-items-center">
        @forelse ($movies as $movie)
            <!-- EGY DB FILM -->
            @if ($movie->deleted_at === null || (Auth::check() && Auth::user()->is_admin))
                <div class="w-8/12 mt-8 {{$movie->deleted_at ? 'bg-red-600 border-red-800' : ''}}">
                        <a href="{{route('movies.show', $movie->id)}}">
                            <img class="hover:opacity-75 transition ease-in-out duration-1 w-64 h-80 {{$movie->deleted_at ? 'bg-red-600 border-red-800 opacity-50' : ''}}" src="{{asset($movie->image ? 'storage/movie_images/'. $movie->image  : 'img/movie.png') }}" alt="{{$movie->title}}" srcset="">
                        </a>
                    <div class="pt-2 border border-gray-200 bg-white">
                        <div class="text-center font-semibold py-2">
                            <a href="{{route('movies.show', $movie)}}">{{$movie->title}}</a>
                        </div>
                        <div class="items-center text-center py-2 text-gray-500 text-sm">
                            <span class="ml-1">
                                @if ($movie->ratings->avg('rating') == null)
                                    <i class="fas fa-star text-gray-500 hover:text-black"> </i>
                                @else
                                    <i class="fas fa-star text-yellow-500"></i> {{$movie->ratings->avg('rating')}}
                                @endif
                            </span>
                            <span class="mx-2">|</span>
                            <span>{{$movie->year}}</span>
                        </div>
                        <div class="items-center text-center py-2 text-gray-500 text-sm">
                            <span>{{gmdate("H:i:s", $movie->length)}}</span>
                        </div>
                    </div>
                </div>
            @endif
            <!-- EGY DB FILM -->
        @empty
            <p>Nincsenek filmek jelenleg az adatbázisban.</p>
        @endforelse

    </div>

    <div class="bg-gray-300 mt-4 border border-t-2 pt-4">
        {{ $movies->links() }}
    </div>
</x-guest-layout>
