<x-guest-layout>
    <div>
        <div class="container mx-auto p-4 border-gray-300 border rounded justify-center items-center">
            <form method="post" action="{{route('movies.store')}}" enctype="multipart/form-data">
                @csrf

                <div class="text-center">
                    <h1 class="mx-auto font-extrabold text-3xl tracking-wider uppercase">Film létrehozása</h1>
                </div>

                <div class="items-center justify-center">
                    <div class="mx-auto w-1/2  mt-8">
                        <label for="title" class=" font-semibold">Film címe</label>
                        <input
                            class="block mt-1 border-gray-400 w-full focus:border-gray-800 rounded"
                            type="text"
                            name="title"
                            id="title"
                            value="{{old('title')}}"
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
                            value="{{old('director')}}"
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
                            value="{{old('year')}}"
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
                        />{{old('description')}}</textarea>
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
                            value="{{old('length')}}"
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

                <div class="mt-8 w-56 mx-auto">
                    <button type="submit" class="mt-6 bg-red-500 hover:bg-red-700 text-gray-100 font-semibold px-2 py-1 text-xl border-red-800 border rounded">Film létrehozása</button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

