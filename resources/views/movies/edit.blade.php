<x-guest-layout>
    <div>
        <div class="container mx-auto p-4 border-gray-300 border rounded justify-center items-center">
            <form method="post" action="{{route('movies.update', $movie)}}" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="text-center">
                    <h1 class="mx-auto font-extrabold text-3xl tracking-wider uppercase">Film módosítása</h1>
                </div>

                <div class="items-center justify-center">
                    <div class="mx-auto w-1/2  mt-8">
                        <label for="title" class=" font-semibold">Film címe</label>
                        <input
                            class="block mt-1 border-gray-400 w-full focus:border-gray-800 rounded"
                            type="text"
                            name="title"
                            id="title"
                            value="{{$movie->title}}"
                        />
                        @error('title')
                            <p class="text-red-600">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="mx-auto w-1/2  mt-8">
                        <label for="director" class=" font-semibold">Rendező</label>
                        <input
                            class="block mt-1 border-gray-400 w-full focus:border-gray-800 rounded"
                            type="text"
                            name="director"
                            id="director"
                            value="{{$movie->director}}"
                        />
                        @error('director')
                            <p class="text-red-600">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="mx-auto w-1/2  mt-8">
                        <label for="year" class=" font-semibold">Év</label>
                        <input
                            class="block mt-1 border-gray-400 w-full focus:border-gray-800 rounded"
                            type="number"
                            name="year"
                            id="year"
                            value="{{$movie->year}}"
                        />
                        @error('year')
                            <p class="text-red-600">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="mx-auto w-1/2 mt-8">
                        <label for="description" class=" font-semibold">Film leírása</label>
                        <textarea
                            class="block mt-1 border-gray-400 w-full focus:border-gray-800 rounded h-48"
                            name="description"
                            id="description"
                            maxlength="512"
                        />{{$movie->description}}</textarea>
                    @error('description')
                        <p class="text-red-600">{{ $message }}</p>
                    @enderror
                    </div>

                    <div class="mx-auto w-1/2  mt-8">
                        <label for="length" class=" font-semibold">Film hossza (seconds)</label>
                        <input
                            class="block mt-1 border-gray-400 w-full focus:border-gray-800 rounded"
                            type="number"
                            name="length"
                            id="length"
                            value="{{$movie->length}}"
                        />
                        @error('length')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mx-auto w-1/2  mt-8">
                        <label for="image" class="block font-semibold text-gray-700">Film képe</label>
                        <input type="file" class="mt-4" id="image" name="image">
                        @error('image')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                </div>

                @if ($movie->image)
                    <div class="mx-auto w-1/2 mt-8">
                        <img class="hover:opacity-75 transition ease-in-out duration-1" src="{{asset($movie->image ? 'storage/movie_images/'. $movie->image  : 'img/movie.png') }}" alt="{{$movie->title}}" srcset="">

                        <div class="flex my-2 p-2 justify-items-center">
                            <label for="image" class="block text-lg font-semibold text-gray-700 mt-4">Jelenlegi kép -</label>
                            <input type="checkbox" name="delete_image" id="delete_image" class="mt-6 mx-2 p-3"> <label for="delete_image" class="font-bold text-lg mt-4"> Kép eltávolítása</label>
                        </div>
                    </div>
                @else
                    <div class="mx-auto w-1/2 mt-8">
                        <p class="font-bold text-xl text-white bg-red-600 p-2">Jelenleg nincs kép beállítva a filmhez.</p>
                    </div>
                @endif


                <div class="mt-8 w-56 mx-auto">
                    <button type="submit" class="mt-6 bg-red-500 hover:bg-red-700 text-gray-100 font-semibold px-2 py-1 text-xl border-red-800 border rounded">Film módosítása</button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

