<x-guest-layout>

    <div class="container mx-auto px-4 p-12">
        <div class="pr-12 pl-10 tracking-wider uppercase text-black text-2xl font-extrabold">
            <h2>Top 10 film</h2>
        </div>
    </div>

    <div class="container mx-auto p-4">
        <ul>
            @forelse ($moviesByDesc as $movie)
                <ul class="border-b border-gray-400 flex">
                    <li class="flex p-2">
                        <span class="font-extrabold text-2xl text-purple-400 ">
                            #{{$loop->iteration}}.
                        </span>
                        <div class="mx-4 p-2">
                            <a href="{{route('movies.show', $movie)}}">
                                <img class="hover:opacity-75 transition ease-in-out duration-1 object-none h-48" src="{{$movie->image}}" alt="{{$movie->title}}" srcset="">
                            </a>
                        </div>
                        <div class="justify-center">
                            <div>
                                <a href="{{route('movies.show', $movie)}}">
                                    <h2 class="text-lg font-semibold hover:text-gray-400">
                                        {{$movie->title}}
                                    </h2>
                                </a>
                            </div>
                            <div class="py-2 text-gray-500 text-sm flex">
                                <span class=""> <i class="fas fa-star text-yellow-500"></i> {{$movie->ratings->avg('rating');}}</span>
                                <span class="mx-2">|</span>
                                <span>{{$movie->year}}</span>
                                <span class="mx-2">|</span>
                                <span>{{gmdate("H:i:s", $movie->length)}}</span>
                            </div>

                            <p class="pt-1">
                                {!! nl2br(e($movie->description)) !!}
                            </p>

                            <div class="mt-8">
                                <h3 class="font-bold"> Rendező: <cite class="font-light">{{$movie->director}}</cite></h3>
                            </div>
                        </div>
                    </li>
                </ul>
            @empty
                <p>Nincs megjelenítendő film.</p>
            @endforelse
        </ul>
    </div>
</x-guest-layout>
