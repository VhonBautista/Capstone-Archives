@php
    use Carbon\Carbon;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Favorites') }}
        </h2>
    </x-slot>
    
    <form action="{{ route('favorite') }}" method="GET">
        <div class="flex flex-col md:flex-row md:justify-between bg-white p-4 rounded-lg justify-center">
            <label for="search-capstone" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <select id="type" name="type" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-gray-900 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600 mr-2">
                <option value="">All Capstones</option>
                <option value="web" @if(request('type') == 'web') selected @endif>Web</option>
                <option value="mobile" @if(request('type') == 'mobile') selected @endif>Mobile</option>
                <option value="desktop" @if(request('type') == 'desktop') selected @endif>Desktop</option>
                <option value="game" @if(request('type') == 'game') selected @endif>Game</option>
                <option value="pos" @if(request('type') == 'pos') selected @endif>Point of Sale</option>
                <option value="others" @if(request('type') == 'others') selected @endif>Others</option>
            </select>

            <div class="flex w-full md:w-1/2 mt-3 md:mt-0 justify-end">
                <div class="relative w-full md:w-full mt-3 md:mt-0">
                    <input type="search" id="search-capstone" name="search" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border-r-gray-50 border-r-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-r-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Search for title, authors, or year published" value="{{ request('search') }}">
                    <button type="submit" class="absolute top-0 right-0 p-2.5 text-sm font-medium h-full text-white bg-blue-600 rounded-r-lg border border-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                </div>
            </div>
        </div>
    </form>

    <div class="max-w-7xl flex g-2 flex-wrap justify-start mt-4 mx-auto">
        @forelse($favorites as $capstone)       
            <div class="max-w-[300px] mx-3 my-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <a href="{{ route('capstone.view', $capstone->id) }}">
                    @if($capstone->images->count() > 0)
                        <img class="w-full h-32 object-cover object-center rounded-t-lg" src="{{ asset($capstone->images[0]->img_path) }}" alt="image description">
                    @else
                        <div class="flex items-center justify-center w-full h-32 bg-gray-300 rounded-t-lg sm:w-sm dark:bg-gray-700">
                            <svg class="w-10 h-10 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"/>
                            </svg>
                        </div>
                    @endif
                </a>
                <div class="p-5">
                    <a href="{{ route('capstone.view', $capstone->id) }}">
                        <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $capstone->title . __(' ') . Carbon::parse($capstone->year_published)->format('(Y)') }}</h5>
                    </a>
                    <p class="mb-2 font-normal text-xs text-gray-700 dark:text-gray-400">{{ __('Authors: ') . $capstone->authors }}</p>
                    <hr>
                    <p class="mb-3 mt-2 font-normal text-xs text-gray-700 dark:text-gray-400">{{ Str::limit($capstone->description, 90, '...') }}</p>
                    <div class="inline-flex justify-between w-full">
                        <a href="{{ route('capstone.view', $capstone->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            {{ __('View Details') }}
                            <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </a>
                        <span class="inline-flex items-center bg-blue-100 text-blue-800 text-sm uppercase font-bold mr-2 px-5 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ $capstone->type }}</span>
                    </div>
                </div>
            </div>        
        @empty
            <div class="p-4 text-center w-full mt-12 text-sm">
                {{ __('No capstones found') }}
            </div>
        @endforelse

    </div>
    {{ $favorites->links() }}
</x-app-layout>
