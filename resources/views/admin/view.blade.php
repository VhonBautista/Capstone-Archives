@php
    use Carbon\Carbon;
@endphp

<x-app-layout>
    <x-slot name="header">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li>
                    <div class="flex items-center">
                    <a href="{{ route('admin.approval') }}" class="text-sm font-medium text-gray-500 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">{{ __('Approvals') }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 font-semibold text-lg text-gray-700 dark:text-gray-400">{{ $capstone->title }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <div class="grid bg-white rounded-xl gap-2 px-0 md:px-6 py-12 pr-0 md:pr-20 sm:grid-cols-4 sm:gap-12">
        <div class="sm:col-span-2">
            @if($capstone->images->count() > 0)
                @if($capstone->images->count() > 1)
                    <p class="mb-3 pl-6 text-md font-bold invisible mt-[-80px] md:mt-0 md:visible text-gray-800 dark:text-gray-200">{{ __('Approval & Front Cover') }}</p>
                    <div id="gallery" class="relative w-full" data-carousel="static">
                        <div class="relative h-auto overflow-hidden rounded-lg md:h-64">
                            @foreach($capstone->images as $image)
                                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                    <img src="{{ asset($image->img_path) }}" class="absolute block max-w-full h-auto -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="">
                                </div>
                            @endforeach
                        </div>

                        <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-black/50 dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                <svg class="w-4 h-4 text-black/50 dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                </svg>
                                <span class="sr-only">Previous</span>
                            </span>
                        </button>
                        <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-black/50 dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                <svg class="w-4 h-4 text-black/50 dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="sr-only">Next</span>
                            </span>
                        </button>
                    </div>
                @else
                    <p class="mb-3 pl-6 text-md font-bold text-gray-800 dark:text-gray-200">{{ __('Approval & Front Cover') }}</p>
                    <figure class="max-w-lg h-auto flex flex-col items-center">
                        <img class="h-auto max-w-full rounded-lg" src="{{ asset($capstone->images[0]->img_path) }}" alt="image description">
                        <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">{{ $capstone->title }}</figcaption>
                    </figure>
                @endif
            @endif
            <div class="px-6 pt-4">
                <p class="text-md font-bold text-gray-800 dark:text-gray-200">{{ __('Capstone PDF File') }}</p>
                @if($capstone->pdf_name)
                <a href="{{ route('capstone.download', $capstone->pdf_name) }}" class="text-white bg-blue-700 w-full my-4 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="w-3.5 h-3.5 text-white-800 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/>
                        <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                    </svg>
                    {{ __('Download Capstone PDF')}}
                </a>
                @else
                <button type="button" class="text-white bg-blue-400 w-full my-4 dark:bg-blue-500 cursor-not-allowed font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center " disabled>
                    {{ __('PDF Download Unavailable for this Capstone')}}
                </button>
                @endif
            </div>
        </div>

        <div class="sm:col-span-2 px-8 md:p-0">
            <p class="mb-5 uppercase text-3xl md:text-5xl font-bold text-gray-900 dark:text-gray-100">{{ $capstone->title }}</p>
            <hr class="my-2">
            @if($capstone->status === 'inactive')
                <form action="{{ route('approval.approve', $capstone->id) }}" method="POST">
                    @csrf
                    @method('patch')
                    
                    <button class="w-full mb-3 mt-3 inline text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-600 dark:focus:ring-green-800" type="submit">
                        {{ __('Approve') }}
                    </button>
                </form>  

                <form action="{{ route('approval.reject', $capstone->id) }}" method="POST">
                    @csrf
                    @method('patch')
                    
                    <button class="w-full mb-3 inline text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-600 dark:focus:ring-red-700" type="submit">
                        {{ __('Reject') }}
                    </button>
                </form>
            @endif
            
            <hr class="mt-1">
            <p class="mb-2 mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('Authors: ') . $capstone->authors }}</p>
            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">{{ __('Panels: ') . $capstone->panels }}</p>
            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">{{ __('Adviser: ') . $capstone->adviser }}</p>
            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">{{ __('Date Published: ') . Carbon::parse($capstone->year_published)->format('M j, Y') }}</p>
            <p class="mb-6 capitalize text-sm text-gray-500 dark:text-gray-400">{{ __('Capstone Type: ') . $capstone->type }}</p>
            
            <p class="mb-3 text-xl font-bold text-gray-800 dark:text-gray-200">{{ __('Description') }}</p>
            <hr class="mt-1">
            <p class="mb-3 mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $capstone->description }}</p>
        </div>
    </div>
</x-app-layout>
