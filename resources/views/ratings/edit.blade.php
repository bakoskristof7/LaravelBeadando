<x-guest-layout>
    <div class="container mx-auto mt-16 p-4 border-gray-300 border rounded justify-center items-center">
        <form method="post" action="{{url('update/'.$id)}}">
            @csrf

            <div class="text-center">
                <h1 class="mx-auto font-extrabold text-3xl">Film értékelés módosítása :</h1>
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
                        value="{{\App\Models\Rating::find($id)->rating}}"

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
                    />{{\App\Models\Rating::find($id)->comment}}</textarea>
                </div>
            </div>

            <div class="mt-8 w-56 mx-auto">
                <button type="submit" class="mt-6 bg-red-500 hover:bg-red-700 text-gray-100 font-semibold px-2 py-1 text-xl border-red-800 border rounded">Értékelés módosítása</button>
            </div>
        </form>
    </div>
</x-guest-layout>
