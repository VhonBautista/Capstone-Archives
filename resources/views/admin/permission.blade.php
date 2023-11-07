<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Permissions') }}
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
    
    <form action="{{ route('admin.permission') }}" method="GET">
        <div class="flex flex-col md:flex-row md:justify-between bg-white p-4 rounded-lg justify-center">
            <label for="search-moderator" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>

            <button data-modal-target="moderator-modal" data-modal-toggle="moderator-modal" class="block text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 text-center dark:bg-blue-600 dark:hover:bg-blue-600 dark:focus:ring-blue-800" type="button">
                {{ __('Add Moderator') }}
            </button>

            <div class="relative w-full md:w-1/2 mt-3 md:mt-0">
                <input type="search" id="search-moderator" name="search" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border-r-gray-50 border-r-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-r-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Search for name or email" value="{{ request('search') }}">
                <button type="submit" class="absolute top-0 right-0 p-2.5 text-sm font-medium h-full text-white bg-blue-600 rounded-r-lg border border-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </div>
        </div>
    </form>

    <div id="moderator-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{ __('Assign New Moderator') }}
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="moderator-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">{{ __('Close Modal') }}</span>
                    </button>
                </div>

                <div class="px-6 py-4 space-y-6">
                    <form action="{{ route('permission.add') }}" id="permission-form" method="POST">
                        @csrf

                        <x-input-label :value="__('Select Employee')" />
                        <select id="employee" name="employee" class="bg-gray-50 mt-1 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" selected>{{ __('Select an employee') }}</option>
                            @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->lastname }}, {{ $employee->firstname }} {{ $employee->middlename }}</option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300 mb-3" id="file_input_help">{{ __('Please choose an employee before continuing.') }}</p>
                        
                        <x-input-label :value="__('Set Permissions')" />
                        <ul class="items-center w-full text-sm font-medium mt-1 text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="requests-checkbox-list" name="requests" value="1" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="requests-checkbox-list" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Requests') }}</label>
                                </div>
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="capstones-checkbox-list" name="capstones" value="1" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="capstones-checkbox-list" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Capstones') }}</label>
                                </div>
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="approvals-checkbox-list" name="approvals" value="1" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="approvals-checkbox-list" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Approvals') }}</label>
                                </div>
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="users-checkbox-list" name="users" value="1" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="users-checkbox-list" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Users') }}</label>
                                </div>
                            </li>
                            <li class="w-full dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="verifications-checkbox-list" name="verifications" value="1" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="verifications-checkbox-list" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Verifications') }}</label>
                                </div>
                            </li>
                        </ul>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">{{ __('You can modify this user\'s permissions at a later time.') }}</p>
                        
                        <div class="flex items-center justify-end py-6 space-x-2 rounded-b">
                            <button data-modal-hide="moderator-modal" type="submit" id="submit-btn" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-600 dark:focus:ring-blue-700">{{ __('Add Moderator') }}</button>
    
                            <button data-modal-hide="moderator-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">{{ __('Cancel') }}</button>
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
                            {{ __('Name') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Email') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                           {{ __('Permissions') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">{{ __('Actions') }}</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $user)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $user->lastname }}, {{ $user->firstname }} {{ $user->middlename }}
                            </th>
                            <td class="px-6 py-4">
                                {{ ucfirst($user->email) }}
                            </td>
                            <td class="px-6 py-4"> 
                                <div class="flex">
                                    <div class="flex items-center mr-4">
                                        <input type="checkbox" {{ $user->role->manage_request ? 'checked' : '' }} data-id="{{ $user->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" disabled>
                                        <label class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Requests') }}</label>
                                    </div>
                                    <div class="flex items-center mr-4">
                                        <input type="checkbox" {{ $user->role->manage_create && $user->role->manage_update && $user->role->manage_delete ? 'checked' : '' }} data-id="{{ $user->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" disabled>
                                        <label class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Capstones') }}</label>
                                    </div>
                                    <div class="flex items-center mr-4">
                                        <input type="checkbox" {{ $user->role->manage_approval ? 'checked' : '' }} data-id="{{ $user->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" disabled>
                                        <label class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Approvals') }}</label>
                                    </div>
                                    <div class="flex items-center mr-4">
                                        <input type="checkbox" {{ $user->role->manage_user ? 'checked' : '' }} data-id="{{ $user->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" disabled>
                                        <label class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Users') }}</label>
                                    </div>
                                    <div class="flex items-center mr-4">
                                        <input type="checkbox" {{ $user->role->manage_verification ? 'checked' : '' }} data-id="{{ $user->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" disabled>
                                        <label class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Verifications') }}</label>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <button data-modal-target="permission-modal" data-id="{{ $user->role->id }}" data-modal-toggle="permission-modal" class="edit-permission-btn inline focus:ring-4 focus:outline-none focus:ring-grey-300 py-2.5 text-center dark:focus:ring-grey-800" type="button">
                                    <svg class="w-5 h-5 text-gray-400 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M18 7.5h-.423l-.452-1.09.3-.3a1.5 1.5 0 0 0 0-2.121L16.01 2.575a1.5 1.5 0 0 0-2.121 0l-.3.3-1.089-.452V2A1.5 1.5 0 0 0 11 .5H9A1.5 1.5 0 0 0 7.5 2v.423l-1.09.452-.3-.3a1.5 1.5 0 0 0-2.121 0L2.576 3.99a1.5 1.5 0 0 0 0 2.121l.3.3L2.423 7.5H2A1.5 1.5 0 0 0 .5 9v2A1.5 1.5 0 0 0 2 12.5h.423l.452 1.09-.3.3a1.5 1.5 0 0 0 0 2.121l1.415 1.413a1.5 1.5 0 0 0 2.121 0l.3-.3 1.09.452V18A1.5 1.5 0 0 0 9 19.5h2a1.5 1.5 0 0 0 1.5-1.5v-.423l1.09-.452.3.3a1.5 1.5 0 0 0 2.121 0l1.415-1.414a1.5 1.5 0 0 0 0-2.121l-.3-.3.452-1.09H18a1.5 1.5 0 0 0 1.5-1.5V9A1.5 1.5 0 0 0 18 7.5Zm-8 6a3.5 3.5 0 1 1 0-7 3.5 3.5 0 0 1 0 7Z"/>
                                      </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td colspan="4" class="px-6 py-4 text-center">
                                <div class="p-4 text-sm">
                                    {{ __('There are no records') }}
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $roles->links() }}
    </div>

    <div id="permission-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{ __('Manage Moderator Permissions') }}
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="permission-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">{{ __('Close Modal') }}</span>
                    </button>
                </div>

                <div class="px-6 py-4 space-y-6">
                    <form action="{{ route('permission.update') }}" method="POST">
                        @csrf
                        @method('patch')

                        <input type="hidden" id="permission-id" name="permission_id" value="">

                        <x-input-label :value="__('Moderator Name')" />
                        <input type="text" name="name" id="moderator" class="mb-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" disabled>
                        
                        <x-input-label :value="__('Set Permissions')" />
                        <ul class="items-center w-full text-sm font-medium mt-1 text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="requests-checkbox" name="requests" value="1" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="requests-checkbox" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Requests') }}</label>
                                </div>
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="capstones-checkbox" name="capstones" value="1" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="capstones-checkbox" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Capstones') }}</label>
                                </div>
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="approvals-checkbox" name="approvals" value="1" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="approvals-checkbox" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Approvals') }}</label>
                                </div>
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="users-checkbox" name="users" value="1" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="users-checkbox" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Users') }}</label>
                                </div>
                            </li>
                            <li class="w-full dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="verifications-checkbox" name="verifications" value="1" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="verifications-checkbox" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Verifications') }}</label>
                                </div>
                            </li>
                        </ul>

                        <div class="flex items-center justify-between pt-6 pb-4 rounded-b flex-col sm:flex-row">
                            <button type="button" data-modal-target="demote-modal" data-modal-toggle="demote-modal"  class="w-full md:w-auto text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-600 dark:focus:ring-red-700 mb-2 sm:mb-0">
                                {{ __('Remove as Moderator') }}
                            </button>
                        
                            <div class="flex flex-col md:flex-row items-center w-full md:w-auto">
                                <button data-modal-hide="permission-modal" type="submit" class="w-full md:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-600 dark:focus:ring-blue-700 mb-2 sm:mb-0">
                                    {{ __('Update Permission') }}
                                </button>
                        
                                <button data-modal-hide="permission-modal" type="button" class="w-full md:w-auto text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 mt-0 sm:ml-2">
                                    {{ __('Cancel') }}
                                </button>
                            </div>
                        </div>                                              
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div id="demote-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="demote-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    
                    <h3 id="modal-title" class="mb-3 text-2xl font-bold text-gray-700 dark:text-gray-200">{{ __('Remove as Moderator') }}</h3>
                    <h3 id="modal-desc" class="mb-5 text-md font-normal text-gray-500 dark:text-gray-400">{{ __('Are you sure you want to demote this user from the System Moderator role and revoke their permissions?') }}</h3>

                    <form action="" id="destroy-form" method="POST" class="inline-flex">
                        @csrf
                        @method('delete')

                        <button id="modal-btn" data-modal-hide="verification-modal" type="submit" class="ml-3 text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            {{ __('Demote') }}
                        </button>
                    </form>  

                    <button data-modal-hide="demote-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">{{ __('Cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
  
    @section('scripts')
        <script>
            $(document).ready(function() {
                function updateButtonStyle() {
                    if ($('#employee').val() !== "") {
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

                $('#employee').on('change', function() {
                    updateButtonStyle();
                });

                $('.edit-permission-btn').click(function() {
                    var roleId = $(this).data('id'); 
                    $('#permission-id').val('');
                    $('#moderator').val('');
                    $('#requests-checkbox').prop('checked', false);
                    $('#capstones-checkbox').prop('checked', false);
                    $('#approvals-checkbox').prop('checked', false);
                    $('#users-checkbox').prop('checked', false);
                    $('#verifications-checkbox').prop('checked', false);

                    $('#destroy-form').attr('action', `{{ url('user/permission/delete') }}/${roleId}`);

                    $.ajax({
                        url: "{{ route('permission.edit', '') }}" + '/' + roleId ,
                        type: 'GET',
                        success: function(data) {
                            $('#permission-id').val(data.id);
                            $('#moderator').val(data.user.firstname + ' ' + data.user.lastname);
                            $('#requests-checkbox').prop('checked', data.manage_request == 1);
                            $('#capstones-checkbox').prop('checked', data.manage_create == 1 && data.manage_update == 1 && data.manage_delete == 1);
                            $('#approvals-checkbox').prop('checked', data.manage_approval == 1);
                            $('#users-checkbox').prop('checked', data.manage_user == 1);
                            $('#verifications-checkbox').prop('checked', data.manage_verification == 1);
                        },
                    });
                });
            });
        </script>
    @endsection
</x-app-layout>
