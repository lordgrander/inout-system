<x-app-layout>
    
<style>
  .top-aligned {
    vertical-align: top;
  }
</style>
<script>
    @foreach ($beta_t_type as $row_beta_t_type)
        var t_{{$row_beta_t_type->t_type_id}} = 0;
    @endforeach
    var display_total = 0;
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12 laos">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <a href="{{ url('/ptsd/'.$start.'/'.$end.'/kodsa/fdsavc/zvcx/gdsa/f/'.$limit.'/90') }}" target="_BLANK">ສົ່ງອອກລາຍງານ</a>
                <br>
                <table width="100%">
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
                                    <td>{{$row_beta_t_type->t_type_name}} </td>
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
                                    
                                    <td>{{ $count++}}</td>
                                    <td > 
                                        <b>{{ $row_com->com_name }}</b>
                                    </td> 
                                    @endif
                                @endforeach
                            </tr>
                            @if($sw=='on')
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
                                                            <td colspan="2"> </td>
                                                            <td colspan="4"><b><u>{{ date('d-m-Y',strtotime($row_enter->date_make))}} / {{ $row_enter->enter_number}}</u> : 
                                                                @foreach($beta_enter_fil AS $file)
                                                                    @if($file->enter_id==$row_enter->enter_id)
                                                                    <a href="{{ asset($file->file_url) }}" target="_BLANK">File</a> | &nbsp;   
                                                                    @endif
                                                                @endforeach
                                                                    </b></td>
                                                        </tr>
                                                        <tr > 
                                                            <td colspan="3"> </td>
                                                            <td  >{{ $row_enter_detail->plate_number }}</td>
                                                            <td>{{ $row_enter_detail->p_import }}</td>
                                                            <td>{{ ($row_enter_detail->weight) }}</td>
                                                            <td>{{ $row_enter_detail->t_type_name }}</td>
                                                        </tr>
                                                    @else 
                                                        <tr > 
                                                            <td colspan="3"> </td> 
                                                            <td  >{{ $row_enter_detail->plate_number }}</td>
                                                            <td>{{ $row_enter_detail->p_import }}</td>
                                                            <td>{{ $row_enter_detail->weight }}</td>
                                                            <td>{{ $row_enter_detail->t_type_name }} {{ $row_enter_detail->t_model }}</td>
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
                        @endif
                    @endforeach
                </table>
                
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</x-app-layout>
