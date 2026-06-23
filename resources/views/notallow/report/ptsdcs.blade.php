<x-app-layout>
    <style>
         .seeprint
         {
             display:none;
         }
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
            font-size:14px !important;
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
        .out-plate
        {
            
            background: #ffffff;
            border-radius:5px;
            padding:8px;
            -webkit-user-select: none; /* Chrome, Safari */
            -moz-user-select: none; /* Firefox */
            -ms-user-select: none; /* Internet Explorer */
            user-select: none; /* Standard syntax */
            cursor:pointer;
        }

        .plate
        {
            border:solid black 1px;
            border-radius:5px;
            padding: 3px;
            position:inline;
            background: #f3ca00; 
        }

        .tablex {
            border-collapse: collapse;
        }

        .td {
            border: 1px solid black;
        } 

        .print
        {
            magin-top:-1550px!important;
            font-family: phetsarath,"Times New Roman", Times, serif!important;
                padding-left:30px!important;
                padding-right:30px!important;
        }
            .h
            {
                font-family: phetsarath,roboto!important;
            }

            .sub_td
            {
                text-align: center!important;
                line-height: 20px!important;
            }
            .sub-line
            {
                margin-top:-20px!important; 
            }
        @media print {

            .seeprint
            {
                display:block;
            }
            .noprint {
                display: none;
            }

            .tablex {
                border: 0.90px solid black;
            }
            .print
            {
                magin-top:-1550px!important;
                padding-left:25px!important;
                padding-right:25px!important;
                font-family: phetsarath,"Times New Roman", Times, serif!important;
            }

            p {
                line-height:  1.5;
                margin:0px
            }

            .sub-line
            {
                margin-top:-20px!important; 
            }

            .x10
            {
                font-size:11px !important;
            }
            .x11
            {
                font-size:14px !important;
            }

            .x12
            {
                font-size:12px !important;
            }

            .x13
            {
                font-size:17px !important;
            }

            .x14
            {
                font-size:14px !important;
            }
            .h
            {
                font-family: phetsarath,roboto!important;
                font-weight:bold;
            }
            .sub_td
            {
                text-align: center!important;
                line-height: 20px!important;
            }
            .red
            {
                color:red;
            }
        }  
        p {
            line-height:  1.5;
            margin:0px;
        }

        .head_border
        {
            border:solid 1.5px black;
            border-radius:5px;
            padding: 5px 15px 5px 15px;
            margin-bottom:10px;
        }
        
    </style>  
    
<script>
    @foreach ($beta_t_type as $row_beta_t_type)
        var t_{{$row_beta_t_type->t_type_id}} = 0;
    @endforeach
    var display_total = 0;
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<table class="table tablex table-bordered x10" width="100%" id="myTable">
                    <tr>
                        <td> 

                            <table class="table table-bordered" style="display:none;">
                                <tr>
                                    <th>ລົດເຂົ້າເມືອງ</th>
                                    <th>ຈຳນວນ</td>
                                </tr>
                                @php($total=0)
                                @foreach ($main_road as $row_main_road)
                                <tr>
                                    <td>{{$row_main_road->main_road_name}}</td>
                                    <td>
                                    @foreach ($count_main_road as $row_count_main_road)
                                        @if($row_main_road->main_road_id==$row_count_main_road->main_road_id)
                                            
                                            @php($total = $total + 0)
                                        
                                        @endif
                                    @endforeach
                                    0
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td>ລວມ : </td>
                                    <td>{{ $total}}</td>
                                </tr>
                            </table>
                        </td>
                        <td style="vertical-align: top;"> 
                            <table class="table table-bordered">
                                <tr>
                                    <th>ປະເພດລົດ</th>
                                    <th>ຈຳນວນ</th>
                                </tr>
                                @php($total=0)
                                @foreach ($beta_t_type as $row_beta_t_type)
                                <tr>
                                    <td>{{$row_beta_t_type->t_type_name}}</td>
                                    
                                    <td id="display_{{$row_beta_t_type->t_type_id}}" data-value="0">
                                     0
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td>ລວມ : </td>
                                    <td id="display_total">{{ $total}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table class="table table-bordered">
                    <tr>
                        <th>ລ/ດ</th>
                        <th>ບໍລິສັດ</th> 
                        <th>ທະບຽນລົດ</th> 
                        <th>ປະເພດສິນຄ້າ</th> 
                        <th>ນ້ຳໜັກ</th> 
                        <th>ປະເພດລົດ</th> 
                    </tr>
                    @php($count=1)
                    @php($secret_count=1)
                    @foreach ($com as $row_com) 
                        @if($secret_count<$limit)
                            <tr>
                         
                                @foreach ($count_t_model as $row_count_t_model)
                                    @if($row_com->com_id==$row_count_t_model->com_id)  
                                    @foreach ($count_beta_enter as $row_count_beta_enter)
                                        @if($row_com->com_id==$row_count_beta_enter->com_id)   
                                            @php($rowspan=$row_count_t_model->TOTAL_COUNT + $row_count_beta_enter->TOTAL_COUNT_COM +1)
                                        @endif
                                    @endforeach
                                    <td rowspan="{{ $rowspan }}">{{ $count++}}</td>
                                    <td  rowspan="{{ $rowspan }}"> 
                                        {{ $row_com->com_name }}
                                    </td> 
                                    @endif
                                @endforeach
                            </tr>
                            @foreach ($beta_enter as $row_enter) 
                                @if($row_com->com_id==$row_enter->com_id)
                                    @php($rem='')
                                    @foreach ($enter_detail as $row_enter_detail)
                                        @if($secret_count<$limit)
                                            @if($row_enter->enter_id==$row_enter_detail->enter_id)
                                               @php($secret_count++)  
                                                @if($rem!=$row_enter->date_make) 
                                                    @php($rem=$row_enter->date_make) 
                                                    <tr>
                                                        <td colspan="4"><b><u>{{ date('d-m-Y',strtotime($row_enter->date_make))}} </u> : </b></td>
                                                    </tr>
                                                    <tr > 
                                                        <td  > {{ $row_enter_detail->plate_number }}</td>
                                                        <td>{{ $row_enter_detail->p_import }}</td>
                                                        <td>{{ $row_enter_detail->weight }}</td>
                                                        <td>{{ $row_enter_detail->t_type_name }}</td>
                                                    </tr>
                                                @else
                                                    <tr > 
                                                        <td  > {{ $row_enter_detail->plate_number }}</td>
                                                        <td>{{ $row_enter_detail->p_import }}</td>
                                                        <td>{{ $row_enter_detail->weight }}</td>
                                                        <td>{{ $row_enter_detail->t_type_name }}</td>
                                                    </tr>
                                                @endif
                                                
                                                    <script>
                                                        
                                                        var sam = $('#display_{{$row_enter_detail->t_model}}').attr("data-value");
                                                        sam = +sam + +1;
                                                        $('#display_{{$row_enter_detail->t_model}}').attr("data-value",sam);
                                                        $('#display_{{$row_enter_detail->t_model}}').html(sam);
                                                        display_total += 1; 
                                                        $('#display_total').html(display_total);
                                                    </script>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif 
                            @endforeach
                        @endif
                    @endforeach
                </table>
                <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script>
     $(document).ready(function () { 
    printContent()
    });
    
    function printContent() {
        var table = document.getElementById("myTable");
        table.style.border = "1px solid black";
        window.print();
        table.style.border = "";
        
        setTimeout(function () {
             
        }, 1000); // 3000 milliseconds = 3 seconds
    }

   
</script>
</x-app-layout>