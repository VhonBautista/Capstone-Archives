<x-app-layout>
    @section('top-scripts')
    <script>
        function openVerificationModal(verificationId, action, campusId) {
            const modal = document.getElementById('verification-modal');
            const form = modal.querySelector('form');
            const modalTitle = document.getElementById('modal-title');
            const modalDesc = document.getElementById('modal-desc');
            const modalBtn = document.getElementById('modal-btn');
    
            form.action = action === 'accept' 
                ? `{{ url('verification/accept') }}/${verificationId}`
                : `{{ url('verification/reject') }}/${verificationId}`;
    
            if (action === 'accept') {
                modalTitle.textContent = 'Verify User';
                modalDesc.textContent = 'By pressing confirm, you confirm that the provided ID \'' + campusId + '\' is a valid Pangasinan State University ID and currently exists.';
                modalBtn.textContent = 'Confirm';
                modalBtn.classList.remove('bg-red-600', 'hover:bg-red-700', 'focus:ring-red-300', 'dark:bg-red-600', 'dark:hover:bg-red-700', 'dark:focus:ring-red-800');
                modalBtn.classList.add('bg-green-600', 'hover:bg-green-700', 'focus:ring-green-300', 'dark:bg-green-600', 'dark:hover:bg-green-700', 'dark:focus:ring-green-800');
            } else {
                modalTitle.textContent = 'Reject User';
                modalDesc.textContent = 'By pressing reject, you confirm that the provided ID \'' + campusId + '\' is NOT a valid Pangasinan State University ID or does not currently exist.';
                modalBtn.textContent = 'Reject';
                modalBtn.classList.remove('bg-green-600', 'hover:bg-green-700', 'focus:ring-green-300', 'dark:bg-green-600', 'dark:hover:bg-green-700', 'dark:focus:ring-green-800');
                modalBtn.classList.add('bg-red-600', 'hover:bg-red-700', 'focus:ring-red-300', 'dark:bg-red-600', 'dark:hover:bg-red-700', 'dark:focus:ring-red-800');
            }
        }
    </script>
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Verifications') }}
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
    
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Name') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Email') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Identification') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Gender') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Campus ID') }}
                        </th>
                        <th>
                            <span class="sr-only">{{ __('Actions') }}</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($verifications as $user)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $user->lastname }}, {{ $user->firstname }} {{ $user->middlename }}
                            </th>
                            <td class="px-6 py-4">
                                {{ ucfirst($user->email) }}
                            </td>
                            <td class="px-6 py-4 capitalize">
                                {{ $user->type }}
                            </td>
                            <td class="px-6 py-4 capitalize">
                                {{ $user->gender }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $user->verification->campus_id }}
                            </td>   
                            <td class="px-6 py-4 flex flex-row text-center">
                                <button onclick="openVerificationModal('{{ $user->verification->id }}', 'accept', '{{ $user->verification->campus_id }}')" data-modal-target="verification-modal" data-modal-toggle="verification-modal" class="mx-1 inline text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-600 dark:focus:ring-green-800" type="button">
                                    {{ __('Verify') }}
                                </button>

                                <button onclick="openVerificationModal('{{ $user->verification->id }}', 'reject', '{{ $user->verification->campus_id }}')" data-modal-target="verification-modal" data-modal-toggle="verification-modal" class="mx-1 inline text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-600 dark:focus:ring-red-700" type="button">
                                    {{ __('Reject') }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td colspan="6" class="px-6 py-4 text-center">
                                <div class="p-4 text-sm">
                                    {{ __('There are no new records') }}
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div id="verification-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="verification-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">{{ __('Close Modal') }}</span>
                        </button>
                        <div class="p-6 text-center">
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            <h3 id="modal-title" class="mb-3 text-2xl font-bold text-gray-700 dark:text-gray-200"></h3>
                            <h3 id="modal-desc" class="mb-5 text-md font-normal text-gray-500 dark:text-gray-400"></h3>

                            <form action="" method="POST" class="inline-flex">
                                @csrf
                                @method('patch')

                                <button id="modal-btn" data-modal-hide="verification-modal" type="submit" class="ml-3 text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"></button>
                            </form>  

                            <button data-modal-hide="verification-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">{{ __('Cancel') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ $verifications->links() }}
    </div>
</x-app-layout>