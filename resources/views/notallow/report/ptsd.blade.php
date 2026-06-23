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
<table class="table tablex table-bordered x10" width="100%" id="myTable">
                    <tr>
                        <td> 

                            <table class="table table-bordered">
                                <tr>
                                    <th>ລົດເຂົ້າເມືອງ</th>
                                    <th>ຈຳນວນ</td>
                                </tr>
                                @php($total=0)
@foreach ($main_road as $row_main_road)
  @php($c = $count_main_road[$row_main_road->main_road_id]->TOTAL_COUNT_MAIN_ROAD ?? 0)
  <tr>
    <td>{{ $row_main_road->main_road_name }}</td>
    <td>{{ $c }}</td>
  </tr>
  @php($total += $c)
@endforeach
<tr>
  <td>ລວມ :</td>
  <td>{{ $total }}</td>
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
@foreach ($beta_t_type as $t)
  @php($c = $count_beta_t_type[$t->t_type_id]->TOTAL_COUNT_T ?? 0)
  <tr>
    <td>{{ $t->t_type_name }}</td>
    <td>{{ $c }}</td>
  </tr>
  @php($total += $c)
@endforeach
<tr>
  <td>ລວມ :</td>
  <td>{{ $total }}</td>
</tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table class="table table-bordered">
                    <tr>
                        <th>ລ/ດ</th>
                        <th>ບໍລິສັດ</th>
                        <th>ຈຳນວນລົດ</th> 
                        <th>ທະບຽນລົດ</th> 
                        <th>ປະເພດສິນຄ້າ</th> 
                        <th>ນ້ຳໜັກ</th> 
                        <th>ປະເພດລົດ</th> 
                    </tr>
                     @php($count=1)
@foreach ($com as $row_com)
  @php($companyTotal = $count_t_model[$row_com->com_id]->TOTAL_COUNT ?? 0)
  @if($companyTotal!=0)
  <tr>
    <td>{{ $count++ }}</td>
    <td><b>{{ $row_com->com_name }}</b></td>
    <td>{{ $companyTotal }}</td>
    <td colspan="4"></td>
  </tr>

  @if($sw === 'on')
    @foreach (($beta_enter->where('com_id',$row_com->com_id)) as $row_enter)
      @php($rows = $detailsByComEnter[$row_com->com_id][$row_enter->enter_id] ?? [])
      @if(count($rows))
        <tr>
          <td colspan="2"></td>
          <td colspan="4">
            <b><u>{{ date('d-m-Y',strtotime($row_enter->date_make))}} / {{ $row_enter->enter_number }}</u> :</b>
          </td>
          <td></td>
        </tr>
        
        @foreach($rows as $i => $d)
          <tr>
            <td colspan="3"></td>
            <td>{{ $d->plate_number }}</td>
            <td>{{ $d->p_import }}</td>
            <td>{{ $d->weight }}</td>
            <td>{{ $d->t_type_name }}</td>
          </tr>
        @endforeach
      @endif
    @endforeach
  @endif
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
            window.close();
        }, 1000); // 3000 milliseconds = 3 seconds
    }

   
</script>
</x-app-layout>