<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight laos">
             
        </h2>
    </x-slot>

    <div class="py-12 laos"> 
        <br>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg"> 
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-12">
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                                <path
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                <laos">ລາຍການເອກະສານ</laos>
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                                <!-- // @  table -->
                                <table class="table table-bordered border-primary">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="5%">#</th>
                                            <th scope="col">ຫົວຂໍ້</th>
                                            <th scope="col" width="10%">ເລກອ້າງອີງ</th>
                                            <th scope="col">ໝາຍເຫດ</th>
                                            <th scope="col" width="10%">ສ້າງເມື່ອ</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                <!-- // ::g  Code -->
                                        @php($i=1)
                                        @foreach($datain as $row)
                                            <tr>
                                                <th scope="row" >
                                                    {{  $i++  }}
                                                    
                                                </th>
                                                <td><span class="badge" style="background-color:{{$row->color }}; ">&nbsp;</span>
                                                    <a href="{{ url('/document/in/view/'. $row->id)}}">{{ $row->header}}</a>
                                                </td>
                                                <td>{{ $row->doc_number}}</td>
                                                <td>{{ $row->info }}</td>
                                                <td><small>{{Carbon\Carbon::parse($row->updated_at)->diffForHumans()}}</small></td>
                                            </tr>
                                        @endforeach

                                <!-- // ::g  EndCode -->
                                    </tbody>
                                </table> 

                                <!-- // ::g  Code -->
                                    {{$datain->links()}}
                                <!-- // ::g  EndCode -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
