@php
    use Carbon\Carbon;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Capstones') }}
        </h2>
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
    
    <form action="{{ route('admin.capstone') }}" method="GET">
        <div class="flex flex-col md:flex-row md:justify-between bg-white p-4 rounded-lg justify-center">
            <label for="search-capstone" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>

            <button data-modal-target="capstone-modal" data-modal-toggle="capstone-modal" class="block text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 text-center dark:bg-blue-600 dark:hover:bg-blue-600 dark:focus:ring-blue-800" type="button">
                {{ __('Add Capstone') }}
            </button>

            <div class="flex w-full md:w-[70%] mt-3 md:mt-0 justify-end">
                <select id="type" name="type" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-gray-900 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600 mr-2">
                    <option value="">All Capstones</option>
                    <option value="web" @if(request('type') == 'web') selected @endif>Web</option>
                    <option value="mobile" @if(request('type') == 'mobile') selected @endif>Mobile</option>
                    <option value="desktop" @if(request('type') == 'desktop') selected @endif>Desktop</option>
                    <option value="game" @if(request('type') == 'game') selected @endif>Game</option>
                    <option value="pos" @if(request('type') == 'pos') selected @endif>Point of Sale</option>
                    <option value="others" @if(request('type') == 'others') selected @endif>Others</option>
                </select>
    
                <div class="relative w-full md:w-1/2 mt-3 md:mt-0">
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

    <div id="capstone-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{ __('Add New Capstone') }}
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="capstone-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">{{ __('Close Modal') }}</span>
                    </button>
                </div>  

                <div class="px-6 py-4 space-y-6">
                    <form action="{{ route('capstone.add') }}" method="POST" id="add-capstone-form" enctype="multipart/form-data">
                        @csrf

                        <div class="grid gap-4 sm:grid-cols-4 sm:gap-4">
                            <div class="sm:col-span-4">
                                <p class="mt-1 mb-2 text-lg font-bold text-gray-800 dark:text-gray-200">{{ __('Capstone Details') }}</p>
                                <hr>
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label :value="__('Title')" />
                                <input type="text" name="title" id="title" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter the title of the capstone" value="{{ old('title') }}">
                                <x-input-error :messages="$errors->get('title')" class="mt-1" />
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label :value="__('Date Published')" />
                                <input type="date" name="date" id="date" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ old('date') }}">
                                <x-input-error :messages="$errors->get('date')" class="mt-1" />
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label :value="__('Type')" />
                                <select id="add-type" name="type" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option value="" selected>{{ __('Select category') }}</option>
                                    <option value="web">{{ __('Web') }}</option>
                                    <option value="mobile">{{ __('Mobile') }}</option>
                                    <option value="desktop">{{ __('Desktop') }}</option>
                                    <option value="game">{{ __('Game') }}</option>
                                    <option value="pos">{{ __('Point of Sale') }}</option>
                                    <option value="others">{{ __('Others') }}</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-1" />
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label :value="__('Adviser')" />
                                <input type="text" name="adviser" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter the name of the adviser." value="{{ old('adviser') }}">
                                <x-input-error :messages="$errors->get('adviser')" class="mt-1" />
                            </div>
                            <div class="sm:col-span-4">
                                <p class="mt-1 mb-2 text-lg font-bold text-gray-800 dark:text-gray-200">{{ __('Capstone Files') }}</p>
                                <hr>
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label :value="__('Upload Approval Sheet & Front Cover')" />
                                <input class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" name="images[]" type="file" accept="image/*" multiple>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">{{ __('Upload images (jpeg, png, jpg, gif) with a maximum size of 2MB.') }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label :value="__('Upload Capstone PDF')" />
                                <input class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" name="pdf" type="file" accept=".pdf">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">{{ __('This is optional, you can upload a PDF file for this capstone at a later time. Upload PDF with a maximum size of 10MB.') }}</p>
                                <x-input-error :messages="$errors->get('pdf')" class="mt-1" />
                            </div>
                            <div class="sm:col-span-4">
                                <p class="mt-1 mb-2 text-lg font-bold text-gray-800 dark:text-gray-200">{{ __('Additional Details') }}</p>
                                <hr>
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label :value="__('Authors')" />
                                <textarea rows="2" name="authors" class="mt-1 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Provide the names of the authors.">{{ old('authors') }}</textarea>
                                <x-input-error :messages="$errors->get('authors')" class="mt-1" />
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">{{ __('Please separate author and panel names with commas \',\'.') }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label :value="__('Panels')" />
                                <textarea rows="2" name="panels" class="mt-1 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Provide the names of the panels.">{{ old('panels') }}</textarea>
                                <x-input-error :messages="$errors->get('panels')" class="mt-1" />
                            </div>
                            <div class="sm:col-span-4">
                                <x-input-label :value="__('Description')" />
                                <textarea name="description" rows="5" class="mt-1 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Provide a description for the capstone project">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-1" />
                            </div>
                        </div>
                        <div class="flex items-center inline-flex w-full justify-end py-6 space-x-2 rounded-b">
                            <button data-modal-hide="capstone-modal" type="submit" id="submit-btn" class=" text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-600 dark:focus:ring-blue-700">{{ __('Add Capstone') }}</button>
    
                            <button data-modal-hide="capstone-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">{{ __('Cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mt-4 mx-auto space-y-6">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Title') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Authors') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                           {{ __('Type') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                           {{ __('Date Published') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                           {{ __('Views') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                           {{ __('Saves') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">{{ __('Actions') }}</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($capstones as $capstone)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <a href="{{ route('capstone.view', $capstone->id) }}" data-tooltip-target="tooltip-default" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $capstone->title }}</a>
                                <div id="tooltip-default" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    {{ __('Click to view') }}
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </th>
                            <td class="px-6 py-4 capitalize">
                                {{ $capstone->authors }}
                            </td>
                            <td class="px-6 py-4 capitalize">
                                {{ $capstone->type }}
                            </td>
                            <td class="px-6 py-4 font-bold">
                                {{ Carbon::parse($capstone->year_published)->format('M j, Y') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $capstone->view_count }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $capstone->saved_count }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('capstone.edit', $capstone->id) }}" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                    <svg class="w-3.5 h-3.5 text-white-800 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                        <path d="M12.687 14.408a3.01 3.01 0 0 1-1.533.821l-3.566.713a3 3 0 0 1-3.53-3.53l.713-3.566a3.01 3.01 0 0 1 .821-1.533L10.905 2H2.167A2.169 2.169 0 0 0 0 4.167v11.666A2.169 2.169 0 0 0 2.167 18h11.666A2.169 2.169 0 0 0 16 15.833V11.1l-3.313 3.308Zm5.53-9.065.546-.546a2.518 2.518 0 0 0 0-3.56 2.576 2.576 0 0 0-3.559 0l-.547.547 3.56 3.56Z"/>
                                        <path d="M13.243 3.2 7.359 9.081a.5.5 0 0 0-.136.256L6.51 12.9a.5.5 0 0 0 .59.59l3.566-.713a.5.5 0 0 0 .255-.136L16.8 6.757 13.243 3.2Z"/>
                                    </svg>
                                    {{ __('Edit') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td colspan="6" class="px-6 py-4 text-center">
                                <div class="p-4 text-sm">
                                    {{ __('There are no records') }}
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $capstones->links() }}
    </div>

    @section('scripts')
        <script>
           $(document).ready(function() {
                function checkFields() {
                    var allFilled = true;
                    $('#add-capstone-form input[type="text"], #add-capstone-form input[type="date"], #add-capstone-form textarea').each(function() {
                        if ($(this).val() == "") {
                            allFilled = false;
                            return false;
                        }
                    });
                    return allFilled && ($('#add-capstone-form input[type="file"]').get(0).files.length > 0);
                }

                function updateButtonStyle() {
                    if (checkFields() && $('#add-type').val() !== "") {
                        $('#submit-btn').prop('disabled', false);
                        $('#submit-btn').removeClass('bg-blue-400 dark:bg-blue-500 cursor-not-allowed');
                        $('#submit-btn').addClass('bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300');
                    } else {
                        $('#submit-btn').prop('disabled', true);
                        $('#submit-btn').removeClass('bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300');
                        $('#submit-btn').addClass('bg-blue-400 dark:bg-blue-500 cursor-not-allowed');
                    }
                }

                updateButtonStyle();

                $('#add-capstone-form input, #add-capstone-form textarea').on('input change', function() {
                    updateButtonStyle();
                });

                $('#add-type').on('change', function() {
                    updateButtonStyle();
                });

                $('#add-capstone-form input[type="file"]').on('change', function() {
                    updateButtonStyle();
                });
            });
        </script>
    @endsection
</x-app-layout>
