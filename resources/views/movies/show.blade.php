<x-guest-layout>

    <div class="border-b border-gray-400 w-screen">
        <div class="container mx-auto px-4 py-16 flex">
            <img src="{{$movie->image}}" alt="{{$movie->title}}" class="w-96">
            <div class="relative ml-24">
                <h2 class="text-4xl font-semibold">{{$movie->title}}</h2>

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
                <div class="absolute bottom-0 left-0 text-sm text-gray-500">
                    <span class="block pb-1">Hozzáadva: {{$movie->created_at->format('Y. m. d. - H:m:s')}}</span>
                    <span class="">Utoljára szerkesztve: {{$movie->updated_at->format('Y. m. d. - H:m:s')}}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 justify-center">

        @auth
            @if (!$movie->ratings_enabled)
                <p class="mt-2 border-gray-400 text-red-600 font-semibold">Az értékelések már nem engedélyezettek ennél a filmnél.</p>
            @else
            <div class="mt-4">
                <a href="{{route('ratings.create')}}" class="border my-4 p-2 bg-red-700 rounded text-white font-semibold hover:bg-red-500">Értékelés létrehozása</a>
            </div>
            @endif
        @endauth

        @forelse ($movie->ratings->sortBy('created_at') as $rating)
            <!-- EGY KOMMENT -->
            <div class="border border-gray-400 w-full p-4 mt-6">
                <span class="text-xl font-semibold mb-2">
                    {{$users->find($rating->user_id)->name}}
                </span>
                <div class="mb-2">
                    <span class="text-sm"> <i class="fas fa-star text-yellow-500"></i> {{$rating->rating}}</span>
                </div>
                <p class="mt-2 border-gray-400">{{$rating->comment}}</p>
                <div class="mt-2">
                    <span class="text-xs">
                        {{$rating->updated_at}}
                    </span>
                </div>
            </div>
            <!-- EGY KOMMENT -->
        @empty
            <p class="mt-2 border-gray-400">Még nincsenek értékelések.</p>
        @endforelse
    </div>


</x-guest-layout>
