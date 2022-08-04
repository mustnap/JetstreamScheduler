<tr>
    <td class=" ">
        <div class="bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider center-content w-0.5 center-content py-0.5 px-2">
            {{ $user->name }}
        </div>
    </td>

    @for ($i = 1; $i <= $colNum; $i++) <td class=" ">
        <div class="custom-control custom-checkbox flex justify-center py-1">
            <input name="dayoff[{{ $user->id }}][date_scheduled][{{ $dates[$i -1]}}]" type="checkbox" class="custom-control-input items-center px-1 py-1  @if($daysNamePerMonth[$i-1] =='S') text-red-600  @else text-green-600  @endif " id="check-{{ $user->id }}-{{ $dates[$i -1]}}" aria-describedby="group_id" value="{{$dates[$i -1]}}" @isset($user->scheduledays ) @if(in_array($dates[$i -1], $user->scheduledays->pluck('date_scheduled')->toArray() )) checked @endif @endisset disabled>
        </div>
        </td>
        @endfor

</tr>