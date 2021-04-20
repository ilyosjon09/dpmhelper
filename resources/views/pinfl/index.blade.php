<x-guest-layout>
    @php
    $icons = [
    'attached' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>',
    'not-attached' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>'

    ];
    @endphp
    <div class="bg-white max-w-screen-lg mx-auto m-4 p-4 shadow-lg rounded-md">
        <form action="{{ url('/') }}" method="GET">
            <div>
                <select class="p-2 w-full rounded-md shadow-inset border-gray-300 mt-4" name="region" id="region"
                    name="region">
                    @foreach ($regions as $region_id => $region)
                    <option @if(old('region')==$region_id) selected @endif value="{{ $region_id }}">{{ $region }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-between space-x-3">
                <input type="text" id="name" name="name"
                    class="border w-full rounded-md shadow-inset border-gray-300 p-2 mt-4" placeholder="Исми"
                    @if(old('name')) value="{{ old('name') }}" @endif>
                <input type="text" name="middle_name" id="middle_name"
                    class="border w-full rounded-md shadow-inset border-gray-300 p-2 mt-4" placeholder="Ота исми"
                    @if(old('middle_name')) value="{{ old('middle_name') }}" @endif>
                <input name="birth_date" autocomplete="off" type="text" id="birth_date"
                    class="border w-full rounded-md shadow-inset border-gray-300 p-2 mt-4" placeholder="Туғилган санаси"
                    @if(old('birth_date')) value="{{ old('birth_date') }}" @endif>
            </div>
            <div>
                <button
                    class="px-4 py-2 shadow-md mt-4 rounded-md bg-gradient-to-t from-blue-700 to-blue-500 text-white"
                    type="submit">Қидириш</button>
            </div>
        </form>
        <div class="text-right">
            Жами: <span class="font-bold">{{ $pinfls->total() }}</span> та (<span class="font-bold">{{ $attached }}</span> та бириктирилган)
        </div>
        <table class="w-full mt-4 text-sm">
            <thead class="border-b-2">
                <tr class="text-left bg-gray-100">
                    <th class="p-2">Фамилияси</th>
                    <th class="p-2">Исми</th>
                    <th class="p-2">Отасининг исми</th>
                    <th class="p-2">Туғилган санаси</th>
                    <th class="p-2">Туғилган жойи</th>
                    <th class="p-2">ПИНФЛ бириктирилган</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pinfls as $pinfl)
                <tr class="@if($loop->even) bg-gray-50 @endif">
                    <td class="border-b p-2">{{ $pinfl->surname_cyr }}</td>
                    <td class="border-b p-2">{{ $pinfl->name_cyr }}</td>
                    <td class="border-b p-2">{{ $pinfl->middlename_cyr }}</td>
                    <td class="border-b p-2">{{ $pinfl->birth_date }}</td>
                    <td class="border-b p-2">{{ str_replace('АНДИЖОН ВИЛОЯТИ ','',$pinfl->birth_place) }}</td>
                    <td class="border-b w-8 p-2 text-center">
                        <form action="{{url('/toggle-attach')}}" method="POST">
                            @csrf
                            @if($pinfl->attached)
                            <input type="hidden" name="id" value="{{ $pinfl->id }}">
                            <input type="hidden" name="attached" value="0">
                            <button class="text-green-400 hover:text-green-600 hover:bg-green-50 border rounded-md px-2 py-px">{!! $icons['attached'] !!}</button>
                            @else
                            <input type="hidden" name="id" value="{{ $pinfl->id }}">
                            <input type="hidden" name="attached" value="1">
                            <button class="text-red-400 hover:text-red-600 hover:bg-red-50 border rounded-md px-2 py-px">{!! $icons['not-attached'] !!}</button>
                            @endif
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $pinfls->onEachSide(2)->links() }}
        </div>
    </div>
</x-guest-layout>