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


    @if (Session::has('rating_created'))
        <div class="container mx-auto px-18 my-4">
            <div class="border px-12 bg-green-500 text-white font-semibold py-2">
                A(z) {{ Session::get('rating_created') }}. azonosítószámú értékelésed sikeresen létrehozva!
            </div>
        </div>
    @endif

    @if (Session::has('rating_deleted'))
        <div class="container mx-auto px-18 my-4">
            <div class="border px-12 bg-green-500 text-white font-semibold py-2">
                A(z) {{ Session::get('rating_deleted') }}. azonosítószámú értékelésed sikeresen ki lett törölve!
            </div>
        </div>
    @endif


    @if (Session::has('rating_edited'))
        <div class="container mx-auto px-18 my-4">
            <div class="mx-4 border px-12 bg-green-500 text-white font-semibold py-2">
                <p>A(z) {{ Session::get('rating_edited') }}. azonosítószámú értékelésed sikeresen módosítva!</p>
            </div>
        </div>
    @endif

    <div class="container mx-auto px-4 justify-center">

        @auth
            @if (!$movie->ratings_enabled)
                <p class="mt-2 border-gray-400 text-red-600 font-semibold">Az értékelések már nem engedélyezettek ennél a filmnél.</p>
            @else
            <div class="mt-4">
                @if (Auth::user()->ratings->contains('movie_id',$movie->id))
                    <a  href="{{url('edit' .'/'. $movie->id .'/'. Auth::user()->ratings->where('movie_id', $movie->id)->first()->id)}}"
                        class="bg-blue-500 hover:bg-blue-700 px-2 py-1 text-white mr-2">
                        <i class="fas fa-edit"></i> Értékelésem módosítása
                    </a>

                        <button class="bg-red-500 hover:bg-red-700 px-2 py-1 text-white">
                            <form method="POST" action="{{ route('ratings.destroy', Auth::user()->ratings->where('movie_id', $movie->id)->first()->id) }}" id="rating-destroy-form">
                                @method('DELETE')
                                @csrf
                                <a
                                    href="#"
                                    onclick="event.preventDefault(); document.querySelector('#rating-destroy-form').submit();"
                                >
                                    <i class="far fa-trash-alt"></i> Értékelésem törlése
                                </a>
                            </form>
                        </button>

                    @else
                <!-- ÉRTÉKELÉS HOZZÁADÁSA FORM -->
                   <!-- <a href="{{route('ratings.create')}}"" class="border my-4 p-2 bg-red-700 rounded text-white font-semibold hover:bg-red-500">Értékelés létrehozása</a> -->
                    <div class="container mx-auto mt-16 p-4 border-gray-300 border rounded justify-center items-center">
                        <form method="post" action="{{url('store/'.Str::slug($movie->title).'/'.$movie->id)}}">
                            @csrf

                            <div class="text-center">
                                <h1 class="mx-auto font-extrabold text-3xl">Film értékelése :</h1>
                            </div>

                            <div class="items-center justify-center">
                                <div class="mx-auto w-1/2  mt-8">
                                    <label for="rating" class=" text-semibold">Értékelés *</label>
                                    <input
                                        class="block mt-1 border-gray-400 w-full focus:border-gray-800 rounded"
                                        type="number"
                                        name="rating"
                                        id="rating"
                                        min="1"
                                        max="5"
                                        value="{{old('rating')}}"

                                    />
                                    @error('rating')
                                        <p class="text-red-600">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="mx-auto w-1/2 mt-8">
                                    <label for="comment" class=" text-semibold">Megjegyzés</label>
                                    <textarea
                                        class="block mt-1 border-gray-400 w-full focus:border-gray-800 rounded h-48"
                                        type="te"
                                        name="comment"
                                        id="comment"
                                        maxlength="255"
                                    />{{old('comment')}}</textarea>
                                </div>
                            </div>

                            <div class="mt-8 w-56 mx-auto">
                                <button type="submit" class="mt-6 bg-red-500 hover:bg-red-700 text-gray-100 font-semibold px-2 py-1 text-xl border-red-800 border rounded">Értékelés létrehozása</button>
                            </div>
                        </form>
                    </div>
                   @endif
                <!-- ÉRTÉKELÉS HOZZÁADÁSA FORM -->
            </div>
            @endif
        @endauth

        @forelse ($movie->ratings->sortByDesc('created_at') as $rating)
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
                        {{$rating->created_at}}
                    </span>
                </div>
            </div>
            <!-- EGY KOMMENT -->
        @empty
            <p class="mt-2 border-gray-400">Még nincsenek értékelések.</p>
        @endforelse
    </div>


</x-guest-layout>
