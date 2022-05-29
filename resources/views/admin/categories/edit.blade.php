<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex m-2 p-4">
                <a href="{{ route('admin.categories.index') }}"
                    class="px-6 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">Go Back</a>
            </div>
            <div class="m-6 p-8 bg-slate-700 rounded-lg">

                <form enctype="multipart/form-data" method="POST"
                    action="{{ route('admin.categories.update', $category->id) }}">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Name</label>
                        <input type="text" id="name" name="name" value="{{ $category->name }}"
                            class="block w-1/2 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-400 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    @error('name')
                        <div class="text-sm text-red-400">{{ $message }}</div>
                    @enderror

                    <label class="block mt-5 mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                        for="image">Upload
                        a picture for the category</label>
                    <div>
                        <img class="w-42 h-36 rounded-lg" src="{{ asset('categories/' . $category->image) }}">
                    </div>
                    <div>
                        <input
                            class="block w-1/2 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer mb-4 bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            aria-describedby="user_avatar_help" id="image" type="file" name="image">
                    </div>
                    <div class="mb-6">
                        <label for="description"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Description</label>
                        <input type="text" id="description" name="description" value="{{ $category->description }}"
                            class="block w-3/4 p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-md focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-400 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    @error('desciption')
                        <div class="text-sm text-red-400">{{ $message }}</div>
                    @enderror

                    <button type="submit"
                        class="px-6 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-sm text-white">Update</button>
                </form>
            </div>

        </div>
    </div>
</x-admin-layout>
