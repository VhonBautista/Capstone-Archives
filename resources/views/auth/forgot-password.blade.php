<x-guest-layout>
    <div class="p-6 space-y-4 md:space-y-6 sm:p-4">
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('password.email') }}">
            @csrf

            <div>
                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('Enter your email') }}" required autofocus value="{{ old('email') }}">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                {{ __('Email Password Reset Link') }}
            </button>
            
            <div class="text-center">
                <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                    {{ __('Go back to') }} <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">{{ __('Sign in') }}</a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
