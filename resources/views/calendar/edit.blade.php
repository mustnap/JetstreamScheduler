<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calendar Edit (Day-Off requested)') }}
        </h2>
    </x-slot>
    <div>
        <div class="max-w-6xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="flex">
                <div class="block mb-8">
                    <a href="{{ route('calendar.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Do something</a>
                </div>
                <div class="block mb-8">
                    <a href="{{ route('calendar.create') }}" class="bg-red-500 hover:bg-red-700 text-white text-center py-2 px-4 rounded">Lock Calendar</a>
                </div>
            </div>

            <h4 class="text-3xl font-normal leading-normal mt-0 mb-2 text-pink-800">
                Month: {{ $monthName }} - {{ $year }} (Day-Off)
            </h4>
            <nav aria-label="navigation">
                <ul class="pagination">
                    <a href="{{ route('calendar.ym', [$prevyear, $prevmonth])  }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Previous</span>
                        <!-- Heroicon name: solid/chevron-left -->
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="{{ route('calendar.ym', [$nextyear, $nextmonth]) }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Next</span>
                        <!-- Heroicon name: solid/chevron-right -->
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </ul>
            </nav>

            <form method="POST" action="{{ route('calendar.ym-patch', [$year, $month]) }}">
                @csrf
                @method('PATCH')
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 w-full">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider center-content w-0.5">
                                                UserId / Dates
                                            </th>

                                            @for ($i = 1; $i <= $colNum; $i++) <th scope="col" width="20" class="px-1 py-1 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider center-content w-0.5">
                                                {{ $i }}</th>
                                                @endfor
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <td class="divide-x divide-gray-200">
                                            <div class="bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider center-content w-0.5 center-content py-0.5 px-2">
                                                Day
                                            </div>
                                        </td>

                                        @for ($i = 1; $i <= $colNum; $i++) <td>
                                            <div class=" @if($daysNamePerMonth[$i-1] =='S') bg-blue-200  @else bg-gray-100  @endif  text-center text-xs font-medium text-gray-500 uppercase">
                                                <span> {{ $daysNamePerMonth[$i-1] }} </span>
                                            </div>
                                            </td>
                                            @endfor

                                            @foreach ($calendarusers as $user)
                                            @include('calendar/onerow', [$user, $colNum, $dates])
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{ $calendarusers->links()  }}
                <button type="submit" class="bg-blue-500 hover:bg-green-700 text-white font-bold py-2 px-4 mt-3 rounded">Submit</button>
            </form>

        </div>
    </div>
</x-app-layout>
Dashboard