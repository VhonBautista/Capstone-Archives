@php
    use Carbon\Carbon;
@endphp

<x-app-layout>
    @section('top-scripts')
    <script>
        function openApprovalModal(capstoneId, action, title) {
            const modal = document.getElementById('approval-modal');
            const form = modal.querySelector('form');
            const modalTitle = document.getElementById('modal-title');
            const modalDesc = document.getElementById('modal-desc');
            const modalBtn = document.getElementById('modal-btn');
    
            form.action = action === 'approve' 
                ? `{{ url('approval/approve') }}/${capstoneId}`
                : `{{ url('approval/reject') }}/${capstoneId}`;
    
            if (action === 'approve') {
                modalTitle.textContent = 'Approve Capstone Request';
                modalDesc.textContent = 'By pressing confirm, you acknowledge that the capstone titled \'' + title + '\' has met all the necessary requirements.';
                modalBtn.textContent = 'Confirm';
                modalBtn.classList.remove('bg-red-600', 'hover:bg-red-700', 'focus:ring-red-300', 'dark:bg-red-600', 'dark:hover:bg-red-700', 'dark:focus:ring-red-800');
                modalBtn.classList.add('bg-green-600', 'hover:bg-green-700', 'focus:ring-green-300', 'dark:bg-green-600', 'dark:hover:bg-green-700', 'dark:focus:ring-green-800');
            } else {
                modalTitle.textContent = 'Reject Capstone Request';
                modalDesc.textContent = 'By pressing reject, you confirm that the capstone titled \'' + title + '\' has NOT met all the necessary requirements.';
                modalBtn.textContent = 'Reject';
                modalBtn.classList.remove('bg-green-600', 'hover:bg-green-700', 'focus:ring-green-300', 'dark:bg-green-600', 'dark:hover:bg-green-700', 'dark:focus:ring-green-800');
                modalBtn.classList.add('bg-red-600', 'hover:bg-red-700', 'focus:ring-red-300', 'dark:bg-red-600', 'dark:hover:bg-red-700', 'dark:focus:ring-red-800');
            }
        }
    </script>
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Approvals') }}
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
                           {{ __('Images') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                           {{ __('PDF') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">{{ __('Actions') }}</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($approvals as $capstone)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <a href="{{ route('approval.preview', $capstone->id) }}" data-tooltip-target="tooltip-default" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $capstone->title }}</a>
                                <div id="tooltip-default" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    {{ __('Click to preview') }}
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
                                {!! $capstone->images ? 'Yes' : 'No' !!}
                            </td>
                            <td class="px-6 py-4">
                                {!! $capstone->pdf_name ? 'Yes' : 'No' !!}
                            </td>
                            <td class="px-6 py-4 flex flex-row text-center">
                                <button onclick="openApprovalModal('{{ $capstone->id }}', 'approve', '{{ $capstone->title }}')" data-modal-target="approval-modal" data-modal-toggle="approval-modal" class="mx-1 inline text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-600 dark:focus:ring-green-800" type="button">
                                    {{ __('Approve') }}
                                </button>

                                <button onclick="openApprovalModal('{{ $capstone->id }}', 'reject', '{{ $capstone->title }}')" data-modal-target="approval-modal" data-modal-toggle="approval-modal" class="mx-1 inline text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-600 dark:focus:ring-red-700" type="button">
                                    {{ __('Reject') }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td colspan="7" class="px-6 py-4 text-center">
                                <div class="p-4 text-sm">
                                    {{ __('There are no records') }}
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div id="approval-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="approval-modal">
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

                                <button id="modal-btn" data-modal-hide="approval-modal" type="submit" class="ml-3 text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"></button>
                            </form>  

                            <button data-modal-hide="approval-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">{{ __('Cancel') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ $approvals->links() }}
    </div>
</x-app-layout>