<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex m-2 p-4">
                <a href="{{ route('admin.tables.index') }}"
                    class="px-6 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">Go Back</a>
            </div>
            <div class="m-6 p-8 bg-slate-700 rounded-lg">

                <form method="POST" action="{{ route('admin.tables.update', $table->id) }}">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Name</label>
                        <input type="text" id="name" name="name" value="{{ $table->name }}"
                            class="block w-1/2 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-400 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    @error('name')
                        <div class="text-sm text-red-400">{{ $message }}</div>
                    @enderror

                    <div>
                        <label for="guest_number"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Guest Numbers</label>
                        <input type="number" id="guest_number" min="0" max="8" step="1" name="guest_number" value="{{ $table->guest_number }}"
                            class="block w-1/2 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-400 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    @error('guest_number')
                        <div class="text-sm text-red-400">{{ $message }}</div>
                    @enderror

                    <div class="mb-6">
                        <label for="status"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Status</label>
                        <div class="mt-1">
                            <select id=status" name="status" class="form-multiselect block w-1/2 mt-1 rounded-lg">
                                @foreach (App\Enums\TableStatus::cases() as $status)
                                <option value="{{ $status->value }}" @selected($table->status->value == $status->value)>{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @error('status')
                        <div class="text-sm text-red-400">{{ $message }}</div>
                    @enderror

                    <div class="mb-6">
                        <label for="location"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Location</label>
                        <div class="mt-1">
                            <select id="location" name="location" class="form-multiselect block w-1/2 mt-1 rounded-lg">
                                @foreach (App\Enums\TableLocation::cases() as $location)
                                    <option value="{{ $location->value }}" @selected($table->location->value == $location->value)>{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @error('location')
                        <div class="text-sm text-red-400">{{ $message }}</div>
                    @enderror

                    <button type="submit"
                        class="px-6 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-sm text-white">Update</button>
                </form>

            </div>

        </div>
    </div>
</x-admin-layout>
