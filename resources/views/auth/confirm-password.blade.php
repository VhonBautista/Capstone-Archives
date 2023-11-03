<x-guest-layout>
    <div class="p-6 space-y-4 md:space-y-6 sm:p-4">
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>
        
        <form class="space-y-4 md:space-y-6"  method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div>
                <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('Enter your password') }}" required autofocus>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>
            
            <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                {{ __('Confirm') }}
            </button>
        </form>
    </div>
</x-guest-layout>
