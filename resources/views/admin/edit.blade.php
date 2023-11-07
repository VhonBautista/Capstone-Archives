<x-app-layout>
    <x-slot name="header">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li>
                    <div class="flex items-center">
                    <a href="{{ route('admin.capstone') }}" class="text-sm font-medium text-gray-500 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">{{ __('Capstones') }}</a></a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('capstone.view', $capstone->id) }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">{{ $capstone->title }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 font-semibold text-lg text-gray-700 dark:text-gray-400">{{ __('Edit') }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    @if (session('message'))
    <div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div class="ml-3 text-sm font-medium">
            {{ session('message') }}
        </div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
    @endif

    <div class="p-8 bg-white rounded-lg">
        <form action="{{ route('capstone.update') }}" method="POST" id="add-capstone-form"> 
            @csrf
            @method('patch')
            
            <input type="hidden" name="capstone_id" value="{{ $capstone->id }}">

            <div class="grid gap-4 sm:grid-cols-4 sm:gap-4">
                <div class="sm:col-span-4">
                    <p class="mt-1 mb-2 text-lg font-bold text-gray-800 dark:text-gray-200">{{ __('Capstone Details') }}</p>
                    <hr>
                </div>
                <div class="sm:col-span-2">
                    <x-input-label :value="__('Title')" />
                    <input type="text" name="title" id="title" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter the title of the capstone" value="{{ old('title', $capstone->title) }}">
                    <x-input-error :messages="$errors->get('title')" class="mt-1" />
                </div>
                <div class="sm:col-span-2">
                    <x-input-label :value="__('Date Published')" />
                    <input type="date" name="date" id="date" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ old('date', $capstone->year_published) }}">
                    <x-input-error :messages="$errors->get('date')" class="mt-1" />
                </div>
                <div class="sm:col-span-2">
                    <x-input-label :value="__('Type')" />
                    <select id="add-type" name="type" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="">{{ __('Select category') }}</option>
                        <option value="web" @if($capstone->type == 'web') selected @endif>{{ __('Web') }}</option>
                        <option value="mobile" @if($capstone->type == 'mobile') selected @endif>{{ __('Mobile') }}</option>
                        <option value="desktop" @if($capstone->type == 'desktop') selected @endif>{{ __('Desktop') }}</option>
                        <option value="game" @if($capstone->type == 'game') selected @endif>{{ __('Game') }}</option>
                        <option value="pos" @if($capstone->type == 'pos') selected @endif>{{ __('Point of Sale') }}</option>
                        <option value="others" @if($capstone->type == 'others') selected @endif>{{ __('Others') }}</option>
                    </select>
                    <x-input-error :messages="$errors->get('type')" class="mt-1" />
                </div>
                <div class="sm:col-span-2">
                    <x-input-label :value="__('Adviser')" />
                    <input type="text" name="adviser" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter the name of the adviser." value="{{ old('adviser', $capstone->adviser) }}">
                    <x-input-error :messages="$errors->get('adviser')" class="mt-1" />
                </div>
                <div class="sm:col-span-4">
                    <p class="mt-1 mb-2 text-lg font-bold text-gray-800 dark:text-gray-200">{{ __('Additional Details') }}</p>
                    <hr>
                </div>
                <div class="sm:col-span-2">
                    <x-input-label :value="__('Authors')" />
                    <textarea rows="2" name="authors" class="mt-1 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Provide the names of the authors.">{{ old('authors', $capstone->authors) }}</textarea>
                    <x-input-error :messages="$errors->get('authors')" class="mt-1" />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">{{ __('Please separate author and panel names with commas \',\'.') }}</p>
                </div>
                <div class="sm:col-span-2">
                    <x-input-label :value="__('Panels')" />
                    <textarea rows="2" name="panels" class="mt-1 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Provide the names of the panels.">{{ old('panels', $capstone->panels) }}</textarea>
                    <x-input-error :messages="$errors->get('panels')" class="mt-1" />
                </div>
                <div class="sm:col-span-4">
                    <x-input-label :value="__('Description')" />
                    <textarea name="description" rows="5" class="mt-1 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Provide a description for the capstone project">{{ old('description', $capstone->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                </div>
            </div>

            <div class="flex items-center justify-between pt-6 pb-4 rounded-b flex-col sm:flex-row">
                <div class="flex flex-col md:flex-row items-center w-full md:w-auto">
                    <button type="button" data-id="{{ $capstone->id }}" data-modal-target="delete-modal" data-modal-toggle="delete-modal"  class="delete-capstone-btn w-full md:w-auto text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-600 dark:focus:ring-red-700 mb-2 sm:mb-0">
                        {{ __('Delete Capstone') }}
                    </button>

                    <button type="button" data-modal-target="files-modal" data-modal-toggle="files-modal" class="w-full mb-2 md:mb-auto md:w-auto text-white bg-primary-600 hover:bg-primary-500 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-primary-200 text-sm font-medium px-5 py-2.5 hover:text-white focus:z-10 dark:bg-primary-700 dark:text-white dark:border-primary-500 dark:hover:text-white dark:hover:bg-primary-600 dark:focus:ring-primary-600 mt-0 sm:ml-2 text-center">
                        {{ __('Manage PDF & Images') }}
                    </button>
                </div>

                <div class="flex flex-col md:flex-row items-center w-full md:w-auto">
                    <button type="submit" class="w-full mb-2 md:mb-auto md:w-auto text-white bg-primary-600 hover:bg-primary-500 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-primary-200 text-sm font-medium px-5 py-2.5 hover:text-white focus:z-10 dark:bg-primary-700 dark:text-white dark:border-primary-500 dark:hover:text-white dark:hover:bg-primary-600 dark:focus:ring-primary-600 mt-0 sm:ml-2 text-center">
                        {{ __('Update Capstone') }}
                    </button>
            
                    <a href="{{ route('admin.capstone') }}" class="w-full md:w-auto text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 mt-0 sm:ml-2 text-center">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </div> 
        </form>

        <div id="files-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-4xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            {{ __('Manage PDF & Images') }}
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="files-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">{{ __('Close Modal') }}</span>
                        </button>
                    </div>  
    
                    <div class="grid gap-4 sm:grid-cols-4 mx-6 md:mx-12 my-4 sm:gap-12">
                        <div class="sm:col-span-2">
                            <p class="mt-1 mb-2 text-lg font-bold text-gray-800 dark:text-gray-200">{{ __('Preview') }}</p>
                            <hr class="mb-7">
                            <div class="grid gap-4 sm:grid-cols-2 sm:gap-4">
                                <div class="sm:col-span-2">
                                    @if($capstone->images->count() > 0)
                                        @if($capstone->images->count() > 1)
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
                                            <figure class="max-w-lg h-auto flex flex-col items-center">
                                                <img class="h-auto md:h-64 max-w-full rounded-lg" src="{{ asset($capstone->images[0]->img_path) }}" alt="image description">
                                                <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">{{ $capstone->title }}</figcaption>
                                            </figure>
                                        @endif
                                    @endif
                                </div>
                                <div class="sm:col-span-2">
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
                        </div>
                        <div class="sm:col-span-2">
                            <p class="mt-1 mb-2 text-lg font-bold text-gray-800 dark:text-gray-200">{{ __('Update Capstone Files') }}</p>
                            <hr>
                            <p class="mt-1 mb-6 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">{{ __('Please be aware that updating files will overwrite the existing ones for this capstone. Ensure you have a backup before proceeding with the update.') }}</p>
                            <div class="grid gap-4 sm:grid-cols-2 sm:gap-4">
                                <div class="sm:col-span-2">
                                    <form action="{{ route('update.images') }}" method="POST" id="update-images-form" enctype="multipart/form-data">
                                        @csrf
                                        @method('patch')
                                        
                                        <input type="hidden" name="id" value="{{ $capstone->id }}">
                
                                        <x-input-label :value="__('Update Approval Sheet & Front Cover')" />
                                        <hr class="mt-1 mb-3">
                                        <input class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" name="images[]" type="file" accept="image/*" multiple>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">{{ __('Upload images (jpeg, png, jpg, gif) with a maximum size of 2MB.') }}</p>

                                        <div class="flex justify-end w-full">
                                            <button type="submit" id="submit-btn-img" class="w-full md:w-auto m-l-auto mt-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-600 dark:focus:ring-blue-700">{{ __('Update Images') }}</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="sm:col-span-2">
                                    <form action="{{ route('update.pdf') }}" method="POST" id="update-pdf-form" enctype="multipart/form-data">
                                        @csrf
                                        @method('patch')
                                        
                                        <input type="hidden" name="id" value="{{ $capstone->id }}">

                                        <x-input-label :value="__('Update Capstone PDF')" />
                                        <hr class="mt-1 mb-3">
                                        <input class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" name="pdf" type="file" accept=".pdf">
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">{{ __('Upload PDF with a maximum size of 10MB.') }}</p>
                                        <x-input-error :messages="$errors->get('pdf')" class="mt-1" />

                                        <div class="flex justify-end w-full">
                                            <button type="submit" id="submit-btn-pdf" class="w-full md:w-auto m-l-auto mt-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-600 dark:focus:ring-blue-700">{{ __('Update PDF') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button data-modal-hide="files-modal" type="button" class="w-full md:w-auto text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">{{ __('Cancel') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="delete-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="delete-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-6 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        
                        <h3 id="modal-title" class="mb-3 text-2xl font-bold text-gray-700 dark:text-gray-200">{{ __('Delete Capstone') }}</h3>
                        <h3 id="modal-desc" class="mb-5 text-md font-normal text-gray-500 dark:text-gray-400">{{ __('Are you sure you want to delete this capstone? This action will permanently remove it from the database. Please ensure you have a backup in case of any unintended loss of data.') }}</h3>
    
                        <form action="" id="destroy-form" method="POST" class="inline-flex">
                            @csrf
                            @method('delete')
    
                            <button id="modal-btn" data-modal-hide="delete-modal" type="submit" class="ml-3 text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                {{ __('Delete') }}
                            </button>
                        </form>  
    
                        <button data-modal-hide="delete-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">{{ __('Cancel') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
        $(document).ready(function() {
            $('.delete-capstone-btn').click(function() {
                var capstoneId = $(this).data('id'); 

                $('#destroy-form').attr('action', `{{ url('capstone/delete') }}/${capstoneId}`);
            });

            function updateImageButtonStyle() {
                if ($('#update-images-form input[type="file"]').get(0).files.length > 0) {
                    $('#submit-btn-img').text('Update');
                    $('#submit-btn-img').prop('disabled', false);
                    $('#submit-btn-img').removeClass('bg-blue-400 dark:bg-blue-500 cursor-not-allowed');
                    $('#submit-btn-img').addClass('bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300');
                } else {
                    $('#submit-btn-img').text('Select Images First');
                    $('#submit-btn-img').prop('disabled', true);
                    $('#submit-btn-img').removeClass('bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300');
                    $('#submit-btn-img').addClass('bg-blue-400 dark:bg-blue-500 cursor-not-allowed');
                }
            }

            function updatePDFButtonStyle() {
                if ($('#update-pdf-form input[type="file"]').get(0).files.length > 0) {
                    $('#submit-btn-pdf').text('Update');
                    $('#submit-btn-pdf').prop('disabled', false);
                    $('#submit-btn-pdf').removeClass('bg-blue-400 dark:bg-blue-500 cursor-not-allowed');
                    $('#submit-btn-pdf').addClass('bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300');
                } else {
                    $('#submit-btn-pdf').text('Select PDF File First');
                    $('#submit-btn-pdf').prop('disabled', true);
                    $('#submit-btn-pdf').removeClass('bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300');
                    $('#submit-btn-pdf').addClass('bg-blue-400 dark:bg-blue-500 cursor-not-allowed');
                }
            }

            updateImageButtonStyle();
            updatePDFButtonStyle();

            $('#update-images-form input[type="file"]').on('change', function() {
                updateImageButtonStyle();
            });

            $('#update-pdf-form input[type="file"]').on('change', function() {
                updatePDFButtonStyle();
            });
        });
        </script>
    @endsection
</x-app-layout>
