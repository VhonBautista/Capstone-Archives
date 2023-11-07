@php
    use Carbon\Carbon;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Logs') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Name') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Action') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Details') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Time') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Date') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $log->user->firstname }} {{ $log->user->middlename }} {{ $log->user->lastname }}
                            </th>
                            <td class="px-6 py-4 capitalize">
                                @switch($log->actions)
                                    @case('created')
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ $log->actions }}</span>
                                        @break

                                    @case('verified')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{ $log->actions }}</span>
                                        @break
                            
                                    @case('rejected')
                                    @case('deleted')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">{{ $log->actions }}</span>
                                        @break
                            
                                    @case('updated')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">{{ $log->actions }}</span>
                                        @break
                            
                                    @default
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ $log->actions }}</span>
                                @endswitch
                            </td>                            
                            <td class="px-6 py-4">
                                {{ $log->details }}
                            </td>
                            <td class="px-6 py-4">
                                {{ Carbon::parse($log->created_at)->format('g:i A') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ Carbon::parse($log->created_at)->format('M j, Y') }}
                            </td> 
                        </tr>
                    @empty
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td colspan="6" class="px-6 py-4 text-center">
                                <div class="p-4 text-sm">
                                    {{ __('No activity records found') }}
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $logs->links() }}
    </div>
</x-app-layout>
