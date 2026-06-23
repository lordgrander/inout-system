<x-app-layout>
    <link  rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <style>
         
         .table_display_data
        {
            overflow-x: auto!important;
            /* overflow: auto!important; */
            white-space: nowrap!important;
        }
        .x10
        {
            font-size:10px !important;
        }
        .x11
        {
            font-size:11px !important;
        }

        .x12
        {
            font-size:12px !important;
        }

        .x13
        {
            font-size:13px !important;
        }

        .x14
        {
            font-size:14px !important;
        }

        .xbold
        {
            font-weight:bold;
        }



        .progress-bar {
        width: 400px; /* set the width of the progress bar */
        height: 20px; /* set the height of the progress bar */
        background-color: #ddd; /* set the background color of the progress bar */
        border-radius: 5px; /* set the border radius of the progress bar */

        }

        .phase {
        height: 100%; /* fill the height of the parent container */
        background-color: {{ $progress_bar_color }}; /* set the background color of the phase */
        transition: width 0.5s; /* set a transition for the width */
        animation: start-animation 1s ease-in-out;
        font-size: 12px;
        text-align: center;
        line-height: 20px;

        }

        /* define the keyframe animation */
        @keyframes start-animation {
        from { width: 0%; }
        to { width: {{ $progress_bar_percent }}; }
        }

        #current
        {
            width: 0;
            animation: start-animation 1s ease-in-out;
            animation-fill-mode: forwards;
        }



       
    </style>
    <div class="py-1 laos">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-1 ">
 
                    <div class="p-6">
                        <div class="  items-center">
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                <div class="table_display_data">
                                <table class="table laos">
                                    <tbody>
                                        <tr>
                                            <td width="10%">ເລກທີ່</td>
                                            <td width="5%">:</td>
                                            <td>{{ $beta_enter[0]->enter_number }}</td>
                                        </tr>
                                        <tr>
                                            <td width="10%">ປາຍທາງ</td>
                                            <td width="5%">:</td>
                                            <td>{{ $beta_enter[0]->address }},{{ $beta_enter[0]->district }},{{ $beta_enter[0]->province }}</td>
                                        </tr>
                                        <tr>
                                            <td width="10%">ອື່ນໆ</td>
                                            <td width="5%">:</td>
                                            <td>{{ $beta_enter[0]->lasttails }}</td>
                                        </tr>
                                        <tr>
                                            <td width="10%">ວັນທີ່ສ້າງເອກະສານ</td>
                                            <td width="5%">:</td>
                                            <td>{{ date('d-m-Y',strtotime($beta_enter[0]->date_make)) }}</td>
                                        </tr>
                                        <tr>
                                            <td width="10%">ລົດເຂົ້າ</td>
                                            <td width="5%">:</td>
                                            <td>{{ date('d-m-Y',strtotime($beta_enter[0]->date_in)) }}</td>
                                        </tr>
                                        <tr>
                                            <td width="10%">ລົດອອກ</td>
                                            <td width="5%">:</td>
                                            <td>{{ date('d-m-Y',strtotime($beta_enter[0]->date_out)) }}</td>
                                        </tr>
                                        <tr>
                                            <td width="10%">ສະຖານະ</td>
                                            <td width="5%">:</td>
                                            <td>
                                            <div class="progress-bar">
                                                <div class="phase" id="current">{{ $progress_bar_name }}</div>
                                            </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                 
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td>ທະບຽນລົດ</td>
                                            <td>ຊື່ຄົນຂັບ</td>
                                            <td>ປະເພດລົດ</td>
                                            <td>ປະເພດສິນຄ້າ</td>
                                            <td>ນ້ຳໜັກ</td>
                                            <td>ເລກທີ່ນຳເຂົ້າ</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($count_list=1)
                                        @foreach ($beta_enter_detail as $row)
                                        @php($count_list++)
                                        <tr>
                                            <td>{{ $row->plate_number }}</td>
                                            <td>{{ $row->d_name }}</td>
                                            <td>{{ $row->t_type_name }}</td>
                                            <td>{{ $row->p_import }}</td>
                                            <td>{{ $row->weight }}</td>
                                            <td>{{ $row->detail }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
 
                                </div>
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
</x-app-layout>
