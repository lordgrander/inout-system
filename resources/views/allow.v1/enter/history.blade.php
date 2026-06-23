<x-app-layout> 
    <style>
         
         .table_display_data
        {  
            overflow-x: auto!important;
            /* overflow: auto!important; */
            white-space: nowrap!important; 
        }
        .btn-outline-dark:hover
        {
            background:#fff!important;
        }
        
        .btn-info
        {
            background:#0d6efd;
            cursor:pointer;
        } 

        .btn-info:hover
        {
            background:#0d6efd;
        }

        tbody
        {
            font-weight:normal;
            font-size:15px;
        }
        table thead tr td 
        {
            font-weight:normal;
            font-size:15px;
        }
        .dataTables_length 
        select 
        {
            width:70px;
            border-radius:3px;
        }

        a
        {
            text-decoration:none;
        }

        .dataTables_paginate
        {
            float: right!important;
        }
        .paginate_button:hover
        {
        color:#3434343;
        }
        .paginate_button
        {
            border:solid black 1px;
            border-radius:4px;
            padding:5px;
            cursor:pointer;
            color:black;
            margin:2px;
        }
        
        #table_data_display tbody tr td 
        {
            background:white!important;
        }

        .info-jam:hover:after {
            transform: scaleX(1);
        }
        .sub_table,.sub_table tr,.sub_table tr td
        {
            border:0px!important;
            background:white;
        }
        .dataTables_filter,.dataTables_length {
            float: right!important; 
        }
        .dataTables_length select{ 
            height:42px!important; 
            weight:120px!important; 
        }

        .dataTables_length select
        {
            width:100px;
        }
        table        thead        tr        td
        {
            font-weight:normal!important;
            background:#eaeaea!important;
            
        }
    </style>
    <div class="py-1 laos">
        <div class="max-w-12xl mx-auto sm:px-12 lg:px-12">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                 

                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-1 ">
                    @foreach ($user_list as $row_user)
                    <div class="p-1">
                        <div class="  items-center"> 
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"> 
                                <div class="table_display_data">
                                <table style="display:none;">
                                        <tr>
                                            <td> 
                                                <input type="text" id="timer" value="20" class="form-control" style="width:50px!important">
                                            </td>

                                            <td> 
                                                <input type="checkbox" id="autoReloadCheckbox" >
                                                <label for="autoReloadCheckbox">No-Reload</label></td>
                                            <td>
                                        </tr>
                                    </table> 
                                <table class="table table-bordered display " id="table_user_{{ $row_user->id }}"   style="width:100%">
                                    <thead>
                                        <tr>
                                            <td width="5%">ເລກທີ</th>
                                            <td width="10%">ສະຖານະ</th> 
                                            <td width="10%">ລົດເຂົ້າອອກ</th> 
                                            <td>ປາຍທາງ</th>
                                            <td width="10%">ເບີ່ງລາຍລະອຽດ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($beta_enter_cancel as $row_enter)
                                            @if($row_enter->user_id==$row_user->id)
                                            <tr>
                                                <td>{{ $row_enter->enter_number}}</td>
                                                <td>{{ date('d-m-Y',strtotime($row_enter->date_in)) }}<br>{{ date('d-m-Y',strtotime($row_enter->date_out)) }}</td> 
                                                <td>
                                                    {{$row_enter->address}},
                                                    {{$row_enter->district}},
                                                    {{$row_enter->province}} ,{{ $row_enter->lasttails }}</td>
                                                <td>  
                                                    <badge class="badge btn-danger">ເອກະສານຖືກຍົກເລີກ</badge> 
                                                    <br>
                                                    ສາເຫດ : {{ $row_enter->cancel_log }}
                                                </td> 
                                                <td>
                                                    <a href="{{ url('/enter/update/'.$row_enter->enter_id) }}" style="text-decoration:none;color:black;cursor:pointer;font-size:13px;" class="btn btn-outline-danger">ແກ້ໄຂ</a>
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                        @foreach ($beta_enter as $row_enter)
                                            @if($row_enter->user_id==$row_user->id)
                                            <tr>
                                                <td>{{ $row_enter->enter_number}}</td>
                                                <td> 
                                                    @if($row_enter->status=='WAITING')
                                                        <badge class="badge btn-info">ກຳລັງລໍຖ້າ  </badge>
                                                    @elseif($row_enter->status=='POINTING') 
                                                            <badge class="badge btn-info">ກຳລັງລະບຸສາຍທາງ </badge>
                                                    @elseif($row_enter->status=='SIGNING') 
                                                            <badge class="badge btn-info">ກຳລັງດຳເນີນການ </badge>
                                                    @elseif($row_enter->status=='SIGNINED') 
                                                            <badge class="badge btn-info">ກຳລັງດຳເນີນການ </badge>
                                                    @elseif($row_enter->status=='READY') 
                                                            <badge class="badge btn-info">ກຳລັງດຳເນີນການ </badge>
                                                    @elseif($row_enter->status=='SUCCESS') 
                                                            <badge class="badge btn-success">ສຳເລັດ </badge>
                                                    @elseif($row_enter->status=='CANCEL') 
                                                            <badge class="badge btn-danger">ເອກະສານຖືກຍົກເລີກ</badge>
                                                    @else 
                                                    @endif 
                                                </td> 
                                                <td>{{ date('d-m-Y',strtotime($row_enter->date_in)) }}<br>{{ date('d-m-Y',strtotime($row_enter->date_out)) }}</td> 
                                                <td>
                                                    {{$row_enter->address}},
                                                    {{$row_enter->district}},
                                                    {{$row_enter->province}} ,{{ $row_enter->lasttails }}</td>
                                               
                                                <td>
                                                    <a href="{{ url('/enter/list/view/'.$row_enter->enter_id) }}" style="text-decoration:none;color:black;cursor:pointer;font-size:13px;" class="btn btn-outline-dark">ເບີ່ງຂໍ້ມູນ</a>
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                <br><br>
                                </div>
                            </div>
                        </div>
 
                    </div> 
                    @endforeach

                </div> 
            </div>
        </div>
    </div> 
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            @foreach ($user_list as $row_user)
                $('#table_user_{{ $row_user->id }}').DataTable({
                    language: {
                    "search":         "",
                    "lengthMenu":     "_MENU_",
                    searchPlaceholder: "ຄົ້ນຫາ",
                    "paginate": {
                        "first":      "ທຳອິດ",
                        "last":       "ສຸດທ້າຍ",
                        "next":       "ຕໍ່ໄປ",
                        "previous":   "ກັບຄືນ"
                    },
                    "info":           "",
                    
                }
                });
            @endforeach
        });
    </script>
</x-app-layout>
