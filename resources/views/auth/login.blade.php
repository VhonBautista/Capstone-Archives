<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="p-6 space-y-4 md:space-y-6 sm:p-4">
        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Sign in to your account
        </h1>
        <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('Enter your email') }}" required autofocus value="{{ old('email') }}">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <div>
                <input type="password" name="password" id="password" placeholder="{{ __('Enter your password') }}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-start ms-1">
                    <div class="flex items-center h-5">
                        <input id="remember_me" aria-describedby="remember_me" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" name="remember">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="remember_me" class="text-gray-500 dark:text-gray-300">{{ __('Remember me') }}</label>
                    </div>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">{{ __('Forgot your password?') }}</a>
                @endif
            </div>

            <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                {{ __('Sign In') }}
            </button>
            
            <div class="text-center">
                <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                    {{ __('Don\'t have an account yet?') }} <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">{{ __('Sign up') }}</a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
