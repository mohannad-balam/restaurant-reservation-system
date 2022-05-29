<x-guest-layout>
    <div class="mt-4 text-center">
        <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-blue-500">
            MAKE RESERVATION</h2>
    </div>
    <div class="container w-full px-5 py-6 mx-auto">
        <div class="flex items-center min-h-screen bg-gray-900 rounded-xl">
            <div class="flex-1 h-full max-w-4xl mx-auto bg-white rounded-lg shadow-xl">
                <div class="flex flex-col md:flex-row rounded-lg">
                    <div class="h-32 md:h-auto md:w-1/2 rounded-lg">
                        <img class="object-cover w-full h-full rounded-lg"
                            src="https://cdn.pixabay.com/photo/2021/02/08/07/39/chef-5993951_960_720.jpg" alt="img" />
                    </div>
                    <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2 bg-gray-700 rounded-md">
                        <div class="w-full">
                            <h3 class="mb-4 text-xl font-bold text-green-600">Make Reservation</h3>

                            <div class="w-full bg-gray-200 rounded-full">
                                <div
                                    class="w-f p-1 text-xs font-medium leading-none text-center text-blue-100 bg-green-600 rounded-full">
                                    Step 2</div>
                            </div>

                            <form method="POST" action="{{ route('reservations.store.step.two') }}">
                                @csrf
                                <div class="mb-6">
                                    <label for="table_id"
                                        class="block m-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tables</label>
                                    <div class="mt-1">
                                        <select id=table_id" name="table_id"
                                            class="form-multiselect block w-1/2 mt-1 rounded-lg h-10">
                                            @foreach ($tables as $table)
                                                <option value="{{ $table->id }}">{{ $table->name }}
                                                    ({{ $table->guest_number }} Seats)
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @error('table_id')
                                    <div class="text-sm text-red-400">{{ $message }}</div>
                                @enderror

                                <div class="mt-6 p-4 flex justify-between">
                                    <a href="{{ route('reservations.step.one') }}" class="px-6 py-2 bg-yellow-500 hover:bg-yellow-700 rounded-lg text-sm text-white">Previous</a>
                                    <button type="submit"
                                    class="px-6 py-2 bg-green-500 hover:bg-green-700 rounded-lg text-sm text-white">Make
                                    Reservation</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-guest-layout>
