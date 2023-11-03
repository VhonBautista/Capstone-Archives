<x-guest-layout>
    <div class="p-6 space-y-4 md:space-y-6 sm:p-4">
        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Create an account
        </h1>
        <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <div class="grid grid-cols-5 gap-2">
                    <div class="col-span-2">
                        <input type="text" name="lastname" id="lastname" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('Last Name') }}" required autofocus value="{{ old('lastname') }}">
                    </div>
                    <div class="col-span-2">
                        <input type="text" name="firstname" id="firstname" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('First Name') }}" required value="{{ old('firstname') }}">
                    </div>
                    <div class="col-span-1">
                        <input type="text" name="middlename" id="middlename" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('Initial') }}" value="{{ old('middlename') }}">
                    </div>
                </div>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">{{ __('Using an initial is entirely up to you and not required.') }}</p>
                <x-input-error :messages="$errors->get('lastname')" class="mt-1" />
                <x-input-error :messages="$errors->get('firstname')" class="mt-1" />
                <x-input-error :messages="$errors->get('middlename')" class="mt-1" />
            </div>

            <hr class="border-t border-gray-300 dark:border-gray-700">
            
            <div>
                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('Enter your email') }}" required value="{{ old('email') }}">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <div>
                <input type="password" name="password" id="password" placeholder="{{ __('Enter your password') }}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">{{ __('Your password must be at least 8 characters long.') }}</p>
            </div>

            <div>
                <input type="password" name="password_confirmation" id="confirm-password" placeholder="{{ __('Confirm password') }}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <hr class="border-t border-gray-300 dark:border-gray-700">

            <div>
                <h3 class="mb-2 text-gray-900 dark:text-white">Biological Sex</h3>
                <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="horizontal-list-radio-male" type="radio" value="male" name="biological" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" required>
                            <label for="horizontal-list-radio-male" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Male') }}</label>
                        </div>
                    </li>
                    <li class="w-full dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="horizontal-list-radio-female" type="radio" value="female" name="biological" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" required>
                            <label for="horizontal-list-radio-female" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Female') }}</label>
                        </div>
                    </li>
                </ul>
                <x-input-error :messages="$errors->get('biological')" class="mt-1" />
            </div>

            <div>
                <h3 class="mb-2 text-gray-900 dark:text-white">Identification</h3>
                <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="horizontal-list-radio-student" type="radio" value="student" name="identification" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" required>
                            <label for="horizontal-list-radio-student" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Student') }}</label>
                        </div>
                    </li>
                    <li class="w-full dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="horizontal-list-radio-employee" type="radio" value="employee" name="identification" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" required>
                            <label for="horizontal-list-radio-employee" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Employee') }}</label>
                        </div>
                    </li>
                </ul>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">{{ __('Please choose the correct form of identification. You\'ll need to verify it later in the system with your campus ID.') }}</p>
                <x-input-error :messages="$errors->get('identification')" class="mt-1" />
            </div>

            <div class="flex items-start ms-1">
                <div class="flex items-center h-5">
                    <input id="terms" aria-describedby="terms" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" required>
                </div>
                <div class="ml-3 text-sm">
                    <label for="terms" class="font-light text-gray-500 dark:text-gray-300">{{ __('I accept the') }} <a class="font-medium text-primary-600 hover:underline dark:text-primary-500" href="#">{{ __('Terms and Conditions') }}</a></label>
                </div>
            </div>

            <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                {{ __('Create Account') }}
            </button>

            <div class="text-center">
                <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                    Already have an account? <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">{{ __('Sign in') }}</a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
