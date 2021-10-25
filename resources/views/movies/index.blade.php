<x-guest-layout>

    <!--
    <div class="container mx-auto grid my-4">
        <div>
            <button class="border bg-green-400 border-green-800 rounded py-2 px-4 font-semibold hover:bg-green-500">Új film</button>
        </div>
    </div>
    -->
    <div class="container mx-auto px-4 p-12">
        <div class="px-12 tracking-wider uppercase text-black text-xl font-extrabold">
            <h2>Elérhető filmek</h2>
        </div>
    </div>

    <div class="px-2 container md:mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 justify-items-center">
        @forelse ($movies as $movie)
            <!-- EGY DB FILM -->
                <div class="w-8/12 mt-8">
                        <a href="{{route('movies.show', $movie)}}">
                            <img class="hover:opacity-75 transition ease-in-out duration-1" src="{{$movie->image}}" alt="{{$movie->title}}" srcset="">
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
            <!-- EGY DB FILM -->
        @empty
            <p>Nincsenek filmek jelenleg az adatbázisban.</p>
        @endforelse

    </div>

    <div>
        {{ $movies->links() }}
    </div>
</x-guest-layout>
