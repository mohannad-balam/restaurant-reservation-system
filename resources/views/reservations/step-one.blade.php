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
                                    class="w-1/2 p-1 text-xs font-medium leading-none text-center text-blue-100 bg-green-600 rounded-full">
                                    Step 1</div>
                            </div>

                            <form method="POST" action="{{ route('reservations.store.step.one') }}">
                                @csrf
                                <div>
                                    <label for="first_name" class="block m-2 text-sm font-medium text-gray-50">First
                                        Name</label>
                                    <input type="text" id="first_name" name="first_name"
                                        value="{{ $reservation->first_name ?? '' }}"
                                        class="block w-1/2 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-400 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                                @error('first_name')
                                    <div class="text-sm text-red-400">{{ $message }}</div>
                                @enderror

                                <div>
                                    <label for="last_name" class="block m-2 text-sm font-medium text-gray-50">Last
                                        Name</label>
                                    <input type="text" id="last_name" name="last_name"
                                        value="{{ $reservation->last_name ?? '' }}"
                                        class="block w-1/2 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-400 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                                @error('last_name')
                                    <div class="text-sm text-red-400">{{ $message }}</div>
                                @enderror

                                <div>
                                    <label for="email"
                                        class="block m-2 text-sm font-medium text-gray-50">E-mail</label>
                                    <input type="email" id="email" name="email"
                                        value="{{ $reservation->email ?? '' }}"
                                        class="block w-3/4 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-400 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                                @error('email')
                                    <div class="text-sm text-red-400">{{ $message }}</div>
                                @enderror

                                <div>
                                    <label for="tel_number" class="block m-2 text-sm font-medium text-gray-50">Phone
                                        Number</label>
                                    <input type="text" id="tel_number" name="tel_number"
                                        value="{{ $reservation->tel_number ?? '' }}"
                                        class="block w-3/4 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-400 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                                @error('tel_number')
                                    <div class="text-sm text-red-400">{{ $message }}</div>
                                @enderror

                                <div>
                                    <label for="res_date" class="block m-2 text-sm font-medium text-gray-50">Resrvation
                                        Date</label>
                                    <input type="datetime-local" id="res_date" name="res_date"
                                        min="{{ $min_date->format('Y-m-d\TH:i:s') }}"
                                        max="{{ $max_date->format('Y-m-d\TH:i:s') }}"
                                        value="{{ $reservation ? $reservation->res_date->format('Y-m-d\TH:i:s') : '' }}"
                                        class="block w-1/2 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-400 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                                @error('res_date')
                                    <div class="text-sm text-red-400">{{ $message }}</div>
                                @enderror

                                <div>
                                    <label for="guest_number" class="block m-2 text-sm font-medium text-gray-50">Guest
                                        Numbers</label>
                                    <input type="number" id="guest_number" min="0" max="8" step="1" name="guest_number"
                                        value="{{ $reservation->guest_number ?? '' }}"
                                        class="block w-1/2 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-400 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                                @error('guest_number')
                                    <div class="text-sm text-red-400">{{ $message }}</div>
                                @enderror
                                <div class="mt-6 p-4 flex justify-end">
                                    <button type="submit"
                                        class="px-6 py-2 bg-green-500 hover:bg-green-700 rounded-lg text-sm text-white">Next</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-guest-layout>
