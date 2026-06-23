<x-app-layout>
    
<style>
  .top-aligned {
    vertical-align: top;
  }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12 laos">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <a href="{{ url('/ptsd/'.$start.'/'.$end) }}" target="_BLANK">ສົ່ງອອກລາຍງານ</a>
                <br>
                <table width="100%">
                    <tr>
                        <td> 

                            <table class="table table-bordered">
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
                                            {{$row_count_main_road->TOTAL_COUNT_MAIN_ROAD}}
                                            @php($total = $total + $row_count_main_road->TOTAL_COUNT_MAIN_ROAD)

                                        @endif
                                    @endforeach
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
                                    <td>
                                    @foreach ($count_beta_t_type as $row_count_beta_t_type)
                                        @if($row_beta_t_type->t_type_id==$row_count_beta_t_type->t_model)
                                            {{$row_count_beta_t_type->TOTAL_COUNT_T}}
                                            @php($total = $total + $row_count_beta_t_type->TOTAL_COUNT_T) 
                                        @endif
                                    @endforeach
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td>ລວມ : </td>
                                    <td>{{ $total}}</td>
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
                            <td  rowspan="{{ $rowspan }} ">
                                        {{ $row_count_t_model->TOTAL_COUNT }}  
                            </td> 
                            @endif
                        @endforeach
                    </tr>
                        @foreach ($beta_enter as $row_enter) 
                            @if($row_com->com_id==$row_enter->com_id)
                                @php($rem='')
                                @foreach ($enter_detail as $row_enter_detail)
                                    @if($row_enter->enter_id==$row_enter_detail->enter_id)
                                        @if($rem!=$row_enter->date_make) 
                                            @php($rem=$row_enter->date_make) 
                                            <tr>
                                                <td colspan="4"><b><u>{{ date('d-m-Y',strtotime($row_enter->date_make))}} / {{ $row_enter->enter_number}}</u> : </b></td>
                                            </tr>
                                            <tr > 
                                                <td  >{{ $row_enter_detail->plate_number }}</td>
                                                <td>{{ $row_enter_detail->p_import }}</td>
                                                <td>{{ $row_enter_detail->weight }}</td>
                                                <td>{{ $row_enter_detail->t_type_name }}</td>
                                            </tr>
                                        @else
                                            <tr > 
                                                <td  >{{ $row_enter_detail->plate_number }}</td>
                                                <td>{{ $row_enter_detail->p_import }}</td>
                                                <td>{{ $row_enter_detail->weight }}</td>
                                                <td>{{ $row_enter_detail->t_type_name }}</td>
                                            </tr>
                                        @endif
                                       
                                    @endif
                                @endforeach
                            @endif 
                        @endforeach

                    @endforeach
                </table>
                
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</x-app-layout>
