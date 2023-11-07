<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    
    <form action="{{ route('admin.user') }}" method="GET">
        <div class="flex flex-col md:flex-row md:justify-between bg-white p-4 rounded-lg justify-center">
            <label for="search-user" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>

            <select id="type" name="type" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-gray-900 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600 mr-2">
                <option value="">All Users</option>
                <option value="employee" @if(request('type') == 'employee') selected @endif>Employee</option>
                <option value="student" @if(request('type') == 'student') selected @endif>Student</option>
            </select>

            <div class="relative w-full md:w-1/2 mt-3 md:mt-0">
                <input type="search" id="search-user" name="search" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border-r-gray-50 border-r-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-r-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Search for name or email" value="{{ request('search') }}">
                <button type="submit" class="absolute top-0 right-0 p-2.5 text-sm font-medium h-full text-white bg-blue-600 rounded-r-lg border border-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </div>
        </div>
    </form>

    <div class="max-w-7xl mt-3 mx-auto space-y-6">
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
                        <th scope="col" class="px-6 py-3">
                            {{ __('Type') }}
                        </th>
                        {{-- <th scope="col" class="px-6 py-3">
                            <span class="sr-only">{{ __('Actions') }}</span>
                        </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
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
                                {{ ($user->verification && $user->verification->status === 'verified' ? $user->verification->campus_id : 'Not Verified') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium mr-2 px-2.5 py-0.5 rounded-full {{ ($user->is_admin) ? 'bg-blue-100 text-blue-800  dark:bg-blue-900 dark:text-blue-300' : 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-300' }}">{{ ($user->is_admin) ? 'Admin' : 'Regular User' }}</span>
                            </td>
                            {{-- <td class="px-6 py-4 text-right">
                                <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __('Edit') }}</a>
                            </td> --}}
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
        </div>
        {{ $users->links() }}
    </div>
</x-app-layout>
