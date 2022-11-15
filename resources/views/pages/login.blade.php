@extends('layouts.layout-main')
@section('content')
    <div class="container mb-20 max-w-screen-xs">
        <div class="w-full rounded-lg border border-gray-200 bg-white p-4 shadow-md sm:p-6 md:p-8">
            <form action="/login" method="post" class="space-y-6">
                <h5 class="text-center text-2xl font-medium text-gray-900">Login</h5>
                @if (session()->has('loginError'))
                    <div id="alert-2" class="mb-4 flex rounded-lg bg-red-100 p-4 dark:bg-red-200" role="alert">
                        <svg aria-hidden="true" class="h-5 w-5 flex-shrink-0 text-red-700 dark:text-red-800"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Info</span>
                        <div class="ml-3 text-sm font-medium text-red-700 dark:text-red-800">
                            {{ session('loginError') }}
                        </div>
                        <button type="button"
                            class="-mx-1.5 -my-1.5 ml-auto inline-flex h-8 w-8 rounded-lg bg-red-100 p-1.5 text-red-500 hover:bg-red-200 focus:ring-2 focus:ring-red-400 dark:bg-red-200 dark:text-red-600 dark:hover:bg-red-300"
                            data-dismiss-target="#alert-2" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                @endif
                @if (session()->has('success'))
                    <div id="alert-3" class="mb-4 flex rounded-lg bg-green-100 p-4 dark:bg-green-200" role="alert">
                        <svg aria-hidden="true" class="h-5 w-5 flex-shrink-0 text-green-700 dark:text-green-800"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Info</span>
                        <div class="ml-3 text-sm font-medium text-green-700 dark:text-green-800">
                            {{ session('success') }}
                        </div>
                        <button type="button"
                            class="-mx-1.5 -my-1.5 ml-auto inline-flex h-8 w-8 rounded-lg bg-green-100 p-1.5 text-green-500 hover:bg-green-200 focus:ring-2 focus:ring-green-400 dark:bg-green-200 dark:text-green-600 dark:hover:bg-green-300"
                            data-dismiss-target="#alert-3" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg aria-hidden="true" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                @endif

                @csrf
                <div>
                    <label for="username" class="ml-2 mb-2 block text-sm font-medium text-gray-900">username</label>
                    <input type="text" name="username" id="username"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-slate-500 focus:ring-slate-500"
                        placeholder="username" autofocus required>
                    @error('username')
                        <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="ml-2 mb-2 block text-sm font-medium text-gray-900">Password</label>
                    <input type="password" name="password" id="password"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-slate-500 focus:ring-slate-500"
                        placeholder="Password" required>
                </div>
                <button type="submit"
                    class="w-full rounded-lg bg-[#f53b16] px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-[#f53b16] focus:outline-none focus:ring-4 focus:ring-red-300">Login</button>
            </form>
        </div>
    </div>
@endsection
