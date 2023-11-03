<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ucfirst($user->type) . __(' ID Number Verification') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Please take a moment to verify your ') . $user->type . __(' ID number for authentication purposes. Verifying your ') . $user->type . __(' ID number means you are associated with Pangasinan State University (PSU) and grants you access to additional features and functionalities.') }}
        </p>
    </header>

    <form method="post" action="{{ !$user->verification ? route('profile.verify') : ($user->verification->status === 'rejected' ? route('profile.reassess') : '') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="identification" :value="__('Account Identification Type')" />
            <input type="text" name="identification" id="identification" class="bg-gray-50 mt-1 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize" disabled value="{{ $user->type }}">
        </div>
        
        @if($user->verification && $user->verification->status === 'rejected')
            <hr>
            <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-bold">{{ __('Verification Unsuccessful!') }}</span> {{ __('Please ensure you provide an existing and correct ') . ucfirst($user->type) . __(' ID number.') }}
                </div>
            </div>
        @endif

        <div>
            <x-input-label for="identification" :value="ucfirst($user->type) . __(' ID Number')" />
            <input type="text" name="campus_id" id="campus-id" class="bg-gray-50 mt-1 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('Enter your ') . $user->type . __(' ID number') }}" value="{{ $user->verification ? $user->verification->campus_id : old('campus_id') }}" {{ $user->verification && ($user->verification->status === 'verified' || $user->verification->status === 'sent') ? 'disabled' : '' }}>
            @if(!$user->verification || $user->verification->status === 'rejected')
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">{{ __('Please provide your ') . $user->type . __(' ID number. Please use the format 00-XX-0000 where (0) represents a number while (X) represents characters.') }}</p>
            @endif
            <x-input-error :messages="$errors->get('campus_id')" class="mt-1" />
        </div>

        @if(!$user->verification || $user->verification->status === 'rejected')
            <div class="flex items-center gap-4">
                <button type="submit" class="w-44 text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">{{!$user->verification ? __('Verify') :  __('Send Again') }}</button>
            </div>
        @endif

        @if($user->verification && $user->verification->status === 'sent')
            <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-bold">{{ __('Verification Sent!') }}</span> {{ __('Thank you for providing your ') . $user->type . __(' ID number. Kindly allow the admin some time to process the verification for your ') . $user->type . __(' account.') }}
                </div>
            </div>
        @endif

        @if($user->verification && $user->verification->status === 'verified')
            <div class="flex items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-bold">{{ __('Congratulations!') }}</span> {{ __('Your ') . $user->type . __(' ID number has been successfully verified. You now have full access to your employee account. Thank you for your cooperation.') }}
                </div>
            </div>
        @endif

    </form>
</section>
