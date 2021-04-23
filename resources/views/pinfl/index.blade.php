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
    </svg>',
    'copy' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
    </svg>'

    ];
    @endphp
    <div class="flex items-start space-x-4 container mx-auto">
        <div class="sticky top-0 w-1/3">
            <div class="bg-white p-4 mt-4 shadow-lg rounded-md">
                <form id="search-form" name="search-form" class="flex flex-col" action="{{ url('/') }}" method="GET">
                    <div class="w-full">
                        <select class="p-2 w-full rounded-md shadow-inset border-gray-300 mt-4" name="region"
                            id="region" name="region">
                            @foreach ($regions as $region_id => $region)
                            <option @if(old('region')==$region_id) selected @endif value="{{ $region_id }}">
                                {{ $region }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <div x-data="{ ...data() }"
                            class="border w-full rounded-md shadow-inset flex justify-between items-center border-gray-300 p-2 mt-4">
                            <input x-ref="field" @keydown.enter="submitForm()"
                                class="outline-none focus:outline-none px-2 py-px active:outline-none p-0 border-none  w-full"
                                type="text" id="name" name="name" placeholder="Исми" @if(old('name'))
                                value="{{ old('name') }}" @endif>
                            <button class="mx-1 px-2" @click.prevent="$refs.field.value = ''; $refs.field.focus()">x</button>
                        </div>
                        <div x-data="{ ...data() }"
                            class="border w-full rounded-md shadow-inset flex justify-between items-center border-gray-300 p-2 mt-4">
                            <input x-ref="field" @keydown.enter="submitForm()" type="text" name="middle_name"
                                id="middle_name"
                                class="outline-none focus:outline-none px-2 py-px active:outline-none p-0 border-none  w-full"
                                placeholder="Ота исми" @if(old('middle_name')) value="{{ old('middle_name') }}" @endif>
                            <button class="mx-1 px-2" @click.prevent="$refs.field.value = ''; $refs.field.focus()">x</button>
                        </div>
                        <div x-data="{ ...data() }"
                            class="border w-full rounded-md shadow-inset flex justify-between items-center border-gray-300 p-2 mt-4">
                            <input x-ref="field" @keydown.enter="submitForm()" name="birth_date" autocomplete="off"
                                type="text" id="birth_date"
                                class="outline-none focus:outline-none px-2 py-px active:outline-none p-0 border-none  w-full"
                                placeholder="Туғилган санаси" @if(old('birth_date')) value="{{ old('birth_date') }}"
                                @endif>
                            <button class="mx-1 px-2" @click.prevent="$refs.field.value = ''; $refs.field.focus()">x</button>
                        </div>
                    </div>
                    <div class="text-right">
                        <input
                            class="px-4 py-2 shadow-md mt-4 rounded-md bg-gradient-to-t from-blue-700 to-blue-500 hover: text-white"
                            type="submit" value="Қидириш">
                    </div>
                </form>
            </div>
        </div>
        <div class="bg-white overflow-hidden mx-auto w-2/3 m-4 p-4 shadow-lg rounded-md">
            <div class="sticky top-0">
                <div class="text-right">
                    Жами: <span class="font-bold">{{ $pinfls->total() }}</span> та (<span
                        class="font-bold">{{ $attached }}</span> та бириктирилган)
                </div>
                <div class="mt-4">
                    {{ $pinfls->onEachSide(2)->links() }}
                </div>
            </div>
            <table class="mt-4 text-sm w-full">
                <thead class="border-b-2">
                    <tr class="text-left bg-gray-100">
                        <th class="p-2">ПИНФЛ бириктирилган</th>
                        <th class="p-2">Фамилияси</th>
                        <th class="p-2">Исми</th>
                        <th class="p-2">Отасининг исми</th>
                        <th class="p-2">Туғилган санаси</th>
                        <th class="p-2">Туғилган жойи</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pinfls as $pinfl)
                    <tr class="@if($loop->even) bg-gray-50 @endif">
                        <td class="border-b w-8 p-2 text-center @if($pinfl->attached) border-green-200  @endif">
                            <form action="{{route('toggle-attach')}}" method="POST">
                                @csrf
                                @if($pinfl->attached)
                                <input type="hidden" name="id" value="{{ $pinfl->id }}">
                                <input type="hidden" name="attached" value="0">
                                <button
                                    class="text-green-400 hover:text-green-600 bg-white hover:bg-green-50 border rounded-md px-2 py-1">{!!
                                    $icons['attached'] !!}</button>
                                @else
                                <input type="hidden" name="id" value="{{ $pinfl->id }}">
                                <input type="hidden" name="attached" value="1">
                                <button
                                    class="text-red-400 bg-white hover:text-red-600 hover:bg-red-50 border rounded-md px-2 py-1">{!!
                                    $icons['not-attached'] !!}</button>
                                @endif
                            </form>
                        </td>
                        <td class="border-b p-2 @if($pinfl->attached) border-green-200  @endif">
                            <div class="flex items-center justify-between"><span
                                    data-clipboard-text="{{ $pinfl->surname_cyr }}"
                                    class="btn display-block cursor-pointer">{{ $pinfl->surname_cyr }}</span> <button
                                    data-clipboard-text="{{ $pinfl->surname_cyr }}"
                                    class="btn display-block text-gray-300 hover:text-gray-500">{!! $icons['copy']
                                    !!}</button></div>
                        </td>
                        <td class="border-b p-2 @if($pinfl->attached) border-green-200  @endif">
                            <div class="flex items-center justify-between"><span
                                    data-clipboard-text="{{ $pinfl->name_cyr }}"
                                    class="btn display-block cursor-pointer">{{ $pinfl->name_cyr }}</span> <button
                                    data-clipboard-text="{{ $pinfl->name_cyr }}"
                                    class="btn display-block text-gray-300 hover:text-gray-500">{!! $icons['copy']
                                    !!}</button></div>
                        </td>
                        <td class="border-b p-2 @if($pinfl->attached) border-green-200  @endif">
                            <div class="flex items-center justify-between"><span
                                    data-clipboard-text="{{ $pinfl->middlename_cyr }}"
                                    class="btn display-block cursor-pointer">{{ $pinfl->middlename_cyr }}</span> <button
                                    data-clipboard-text="{{ $pinfl->middlename_cyr }}"
                                    class="btn display-block text-gray-300 hover:text-gray-500">{!! $icons['copy']
                                    !!}</button></div>
                        </td>
                        <td class="border-b p-2 @if($pinfl->attached) border-green-200  @endif">
                            <div class="flex items-center justify-between"><span
                                    data-clipboard-text="{{ $pinfl->birth_date }}"
                                    class="btn display-block cursor-pointer">{{ $pinfl->birth_date }}</span> <button
                                    data-clipboard-text="{{ $pinfl->birth_date }}"
                                    class="btn display-block text-gray-300 hover:text-gray-500">{!! $icons['copy']
                                    !!}</button></div>
                        </td>
                        <td class="border-b p-2 @if($pinfl->attached) border-green-200  @endif">
                            <div class="flex items-center justify-between"><span
                                    data-clipboard-text="{{ str_replace('АНДИЖОН ВИЛОЯТИ ','',$pinfl->birth_place) }}"
                                    class="btn display-block cursor-pointer">{{ str_replace('АНДИЖОН ВИЛОЯТИ ','',$pinfl->birth_place) }}
                                </span> <button
                                    data-clipboard-text="{{ str_replace('АНДИЖОН ВИЛОЯТИ ','',$pinfl->birth_place) }}"
                                    class="btn display-block text-gray-300 hover:text-gray-500">{!! $icons['copy']
                                    !!}</button></div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $pinfls->onEachSide(2)->links() }}
            </div>
        </div>
    </div>
    <script>
        function data() {
        return {
            submitForm: () => {
                let form = document.querySelector('#search-form');
            form.submit();
            }
        }
    }
    </script>
</x-guest-layout>