@php
    $user = auth()->user();
@endphp

<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center text-xl font-semibold text-gray-900 dark:text-white">
                        <img class="w-7 h-7 mr-2" src="https://upload.wikimedia.org/wikipedia/en/7/75/Pangasinan_State_University_logo.png" alt="logo">
                        {{ __('PSU Capstone Archives') }}
                    </a>
                </div>

                <div class="hidden sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Collections') }}
                    </x-nav-link>
                </div>
                
                <div class="hidden sm:-my-px sm:ml-4 sm:flex">
                    <x-nav-link :href="route('favorite')" :active="request()->routeIs('favorite')">
                        {{ __('Favorites') }}
                    </x-nav-link>
                </div>

                <div class="hidden sm:-my-px sm:ml-4 sm:flex">
                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        {{ __('Settings') }}
                    </x-nav-link>
                </div>
            </div>

            <div id="capstone-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-4xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{ __('Upload Capstone') }}
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="capstone-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">{{ __('Close Modal') }}</span>
                            </button>
                        </div>  
        
                        <div class="px-6 py-4 space-y-6">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">{{ __('Note: Uploading a capstone project requires approval from the admin, which may take some time. To prevent rejection, ensure that all required materials are provided and complete.') }}</p>

                            <form action="{{ route('capstone.request') }}" method="POST" id="upload-capstone-form" enctype="multipart/form-data">
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
                                        <input class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" name="images[]" id="images" type="file" accept="image/*" multiple>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">{{ __('Upload images (jpeg, png, jpg, gif) with a maximum size of 2MB.') }}</p>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <x-input-label :value="__('Upload Capstone PDF')" />
                                        <input class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" name="pdf" id="pdf" type="file" accept=".pdf">
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">{{ __('Upload PDF with a maximum size of 10MB.') }}</p>
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
                                    <button data-modal-hide="capstone-modal" type="submit" id="submit-btn" class=" text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-600 dark:focus:ring-blue-700">{{ __('Send Capstone Request') }}</button>
            
                                    <button data-modal-hide="capstone-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">{{ __('Cancel') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <button data-modal-target="capstone-modal" data-modal-toggle="capstone-modal" class="block text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 text-center dark:bg-blue-600 dark:hover:bg-blue-600 dark:focus:ring-blue-800" type="button">
                    {{ __('Upload Capstone') }}
                </button>

                <p class="text-gray-300 text-xl font-normal mx-4">|</p>

                <button id="dropdownNotificationButton" data-dropdown-toggle="dropdownNotification" class="inline-flex items-center text-sm font-medium text-center text-gray-500 hover:text-gray-900 focus:outline-none dark:hover:text-white dark:text-gray-400 mr-2" type="button" data-dropdown-offset-distance="26">
                    @if ($user->unreadNotifications->isNotEmpty())
                    <div class="relative flex">
                        <div class="relative inline-flex w-3 h-3 bg-red-500 border-2 border-white rounded-full -top-2 left-5 dark:border-gray-900"></div>
                    </div>
                    @endif

                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 14 20">
                        <path d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z"/>
                    </svg>
                </button>

                <div id="dropdownNotification" class="z-20 hidden w-full max-w-sm bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-800 dark:divide-gray-700" aria-labelledby="dropdownNotificationButton">
                    <div class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-lg bg-gray-50 dark:bg-gray-800 dark:text-white">
                        {{ __('Notifications') }}
                    </div>
                    <div class="divide-y divide-gray-100 dark:divide-gray-700 max-h-[300px] overflow-y-auto">
                        @forelse($user->unreadNotifications as $notification)
                            <a href="@if($notification->data['type'] !== 'Capstone Rejected') {{ url($notification->data['url']) }} @else # @endif"
                            @if($notification->data['type'] === 'Capstone Rejected')
                                data-modal-target="capstone-modal" data-modal-toggle="capstone-modal"
                            @endif
                            @if($notification->data['type'] === 'Capstone Rejected')  @else href="{{ url($notification->data['url']) }}" @endif class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 mark-as-read" data-id="{{ $notification->id }}">
                                <div class="w-full pl-3">
                                    <div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400"><span class="font-semibold text-gray-900 dark:text-white">{{ $notification->data['title'] }}</span> {{ $notification->data['message'] }}</div>
                                    <span class="{{ $notification->data['color'] }} text-xs font-medium mr-2 px-2.5 py-0.5 rounded">{{ $notification->data['type'] }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="flex justify-center items-center w-full h-full">
                                <div class="p-4 text-sm">
                                    {{ __('There are no new notifications') }}
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div>
                    <button type="button" class="flex text-sm ml-2 bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user" data-dropdown-offset-distance="20">
                        <span class="sr-only">Open user menu</span>
                        <!-- todo: user profile if possible -->
                            @if(!$user->avatar)
                                @if($user->gender === 'female')
                                    <img class="w-8 h-8 rounded-full" src="https://cdn4.iconfinder.com/data/icons/avatars-21/512/avatar-circle-human-female-5-512.png" alt="user photo">
                                @else
                                    <img class="w-8 h-8 rounded-full" src="https://cdn3.iconfinder.com/data/icons/avatars-round-flat/33/man5-512.png">
                                @endif
                            @else
                                <!-- Profile image path -->
                                <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
                            @endif
                        <!-- todo: end -->
                    </button>
                </div>
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
                    <div class="px-4 py-3" role="none">
                        <p class="text-sm text-gray-900 dark:text-white" role="none">
                        {{ $user->firstname }} {{ $user->lastname }}
                        </p>
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                        {{ $user->email }}
                        </p>
                    </div>
                    <ul class="py-1" role="none">
                        <li>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">{{ __('Settings') }}</a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" onclick="event.preventDefault(); this.closest('form').submit();" role="menuitem">{{ __('Sign out') }}</a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 px-4 space-y-1">
            <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}</div>
            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
        </div>

        <div class="pt-2 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="space-y-1">
                <x-responsive-nav-link :href="route('home')">
                    <button data-modal-target="capstone-modal" data-modal-toggle="capstone-modal" class="w-full block text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 text-center dark:bg-blue-600 dark:hover:bg-blue-600 dark:focus:ring-blue-800" type="button">
                        {{ __('Upload Capstone') }}
                    </button>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('home')">
                    {{ __('Collections') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('favorite')">
                    {{ __('Favorites') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Settings') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Sign out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

@section('scripts')
<script>
   $(document).ready(function() {
        function checkFields() {
            var allFilled = true;
            $('#upload-capstone-form input[type="text"], #upload-capstone-form input[type="date"], #upload-capstone-form textarea').each(function() {
                if ($(this).val() == "") {
                    allFilled = false;
                    return false;
                }
            });
            return allFilled && ($('#images').get(0).files.length > 0) && ($('#pdf').get(0).files.length > 0);
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

        $('#upload-capstone-form input, #upload-capstone-form textarea').on('input change', function() {
            updateButtonStyle();
        });

        $('#add-type').on('change', function() {
            updateButtonStyle();
        });

        $('#images').on('change', function() {
            updateButtonStyle();
        });

        $('#pdf').on('change', function() {
            updateButtonStyle();
        });
    });
</script>
@endsection