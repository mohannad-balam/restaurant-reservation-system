<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex m-2 p-4">
                <a href="{{ route('admin.reservations.index') }}"
                    class="px-6 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">Go Back</a>
            </div>
            <div class="m-6 p-8 bg-slate-700 rounded-lg">

                <form method="POST" action="{{ route('admin.reservations.store') }}">
                    @csrf
                    <div>
                        <label for="first_name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">First Name</label>
                        <input type="text" id="first_name" name="first_name"
                            class="block w-1/2 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-400 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    @error('first_name')
                        <div class="text-sm text-red-400">{{ $message }}</div>
                    @enderror

                    <div>
                        <label for="last_name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Last Name</label>
                        <input type="text" id="last_name" name="last_name"
                            class="block w-1/2 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-400 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    @error('last_name')
                        <div class="text-sm text-red-400">{{ $message }}</div>
                    @enderror

                    <div>
                        <label for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">E-mail</label>
                        <input type="email" id="email" name="email"
                            class="block w-1/2 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-400 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    @error('email')
                        <div class="text-sm text-red-400">{{ $message }}</div>
                    @enderror

                    <div>
                        <label for="tel_number"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Phone Number</label>
                        <input type="text" id="tel_number" name="tel_number"
                            class="block w-1/2 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-400 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    @error('tel_number')
                        <div class="text-sm text-red-400">{{ $message }}</div>
                    @enderror

                    <div>
                        <label for="res_date"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Resrvation Date</label>
                        <input type="datetime-local" id="res_date" name="res_date"
                            class="block w-1/2 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-400 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    @error('res_date')
                        <div class="text-sm text-red-400">{{ $message }}</div>
                    @enderror

                    <div>
                        <label for="guest_number"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Guest Numbers</label>
                        <input type="number" id="guest_number" min="0" max="8" step="1" name="guest_number"
                            class="block w-1/2 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-400 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    @error('guest_number')
                        <div class="text-sm text-red-400">{{ $message }}</div>
                    @enderror

                    <div class="mb-6">
                        <label for="table_id"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tables</label>
                        <div class="mt-1">
                            <select id=table_id" name="table_id" class="form-multiselect block w-1/2 mt-1 rounded-lg">
                                @foreach ($tables as $table)
                                    <option value="{{ $table->id }}">{{ $table->name }} ({{ $table->guest_number }} Seats)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @error('table_id')
                        <div class="text-sm text-red-400">{{ $message }}</div>
                    @enderror

                    <button type="submit"
                        class="px-6 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-sm text-white">Make Reservation</button>
                </form>

            </div>

        </div>
    </div>
</x-admin-layout>
