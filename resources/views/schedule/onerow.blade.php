<tr>
    <td class="bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider center-content w-0.5 center-content py-0.5 px-2">
        {{ $onedate->format('D j M Y') }}
    </td>
    @foreach($grouplist as $group)
    <td class="px-0.5 py-1 whitespace-nowrap text-sm text-gray-900">

        @foreach($schedulesArr[$onedate->toDateString()] as $oneSched)
        @if($oneSched->for_group_id == $group->id )
        {{ $oneSched->user->name  }}
        @endif
        @endforeach


    </td>
    @endforeach

    <td class="px-0.5 py-1 whitespace-nowrap text-xs font-medium text-center">
        <a href="{{ route('schedule.show', $grouplist->first()->id ) }}" class="text-blue-600 hover:text-blue-900 mb-2 mr-2">View</a>
        <a href="{{ route('schedule.edit', $grouplist->first()->id ) }}" class="text-indigo-600 hover:text-indigo-900 mb-2 mr-2">Edit</a>
        <form class="inline-block" action="{{ route('schedule.destroy', $grouplist->first()->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="submit" class="text-red-600 hover:text-red-900 mb-2 mr-2" value="Delete">
        </form>
    </td>
</tr>