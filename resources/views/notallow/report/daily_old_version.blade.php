public function daily($start,$end)
    { 
        $start_original = $start;
        $end_original = $end;
        if(auth()->user()->id=='805')
        {
            $start = null;
            $end = null;

        }
        $com = DB::select("SELECT * FROM beta_company_group");
     
        $count_t_model = DB::select("SELECT e.com_id,COUNT(ed.enter_id) AS TOTAL_COUNT FROM beta_enter_detail ed JOIN beta_enter e ON ed.enter_id = e.enter_id WHERE e.status='SUCCESS' AND Date(e.date_make) >= '".$start."' AND Date(e.date_make) <= '".$end."' GROUP BY e.com_id");
    
        $beta_enter = DB::select("SELECT * FROM beta_enter WHERE Date(date_make) >= '".$start."' AND Date(date_make) <= '".$end."' AND status='SUCCESS' ORDER BY date_make ASC");
        $count_beta_enter = DB::select("SELECT com_id,COUNT(enter_id) AS TOTAL_COUNT_COM FROM beta_enter WHERE Date(date_make) >= '".$start."' AND Date(date_make) <= '".$end."' AND status='SUCCESS' GROUP BY com_id");
    
        $enter_detail = DB::select("SELECT e.*,ed.*,t.t_type_name FROM beta_enter_detail ed JOIN beta_enter e ON ed.enter_id = e.enter_id JOIN beta_t_type t ON ed.t_model=t.t_type_id WHERE e.status='SUCCESS' AND Date(e.date_make) >= '".$start."' AND Date(e.date_make) <= '".$end."'");
        $sw = 'on';
 
        if (count($enter_detail) > 1000) {
           $sw = 'off';
        }
        $main_road = DB::select("SELECT * FROM beta_main_road");
        $count_main_road = DB::SELECT("SELECT e.main_road_id,COUNT(ed.enter_id) AS TOTAL_COUNT_MAIN_ROAD FROM beta_enter e JOIN beta_enter_detail ed ON e.enter_id = ed.enter_id WHERE e.status='SUCCESS' AND Date(e.date_make) >= '".$start."' AND Date(e.date_make) <= '".$end."' GROUP BY main_road_id");
        
        $beta_t_type = DB::select("SELECT * FROM beta_t_type");
        $count_beta_t_type = DB::SELECT("SELECT ed.t_model,COUNT(ed.enter_id) AS TOTAL_COUNT_T FROM beta_enter e JOIN beta_enter_detail ed ON e.enter_id = ed.enter_id WHERE e.status='SUCCESS' AND Date(e.date_make) >= '".$start."' AND Date(e.date_make) <= '".$end."' GROUP BY t_model");
        

        
        return view('notallow.report.daily',compact('com','count_t_model','enter_detail','main_road','count_main_road','beta_enter','beta_t_type','count_beta_t_type','count_beta_enter'))->with('start',$start_original)->with('end',$end_original)->with('sw',$sw);
    }
    









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
                <a href="{{ url('/ptsd/'.$start.'/'.$end) }}" target="_BLANK">ສົ່ງອອກລາຍງານ.</a>
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
                            
                            <td>{{ $count++}}</td>
                            <td > 
                                <b>{{ $row_com->com_name }}</b>
                            </td>
                            <td>
                                        {{ $row_count_t_model->TOTAL_COUNT }}  
                            </td> 
                            @endif
                        @endforeach
                    </tr>
                    @if($sw=='on')
                        @foreach ($beta_enter as $row_enter) 
                            @if($row_com->com_id==$row_enter->com_id)
                                @php($rem='')
                                @foreach ($enter_detail as $row_enter_detail)
                                    @if($row_enter->enter_id==$row_enter_detail->enter_id)
                                        @if($rem!=$row_enter->date_make) 
                                            @php($rem=$row_enter->date_make) 
                                            <tr>
                                                <td colspan="2"></td>
                                                <td colspan="4"><b><u>{{ date('d-m-Y',strtotime($row_enter->date_make))}} / {{ $row_enter->enter_number}}</u> : </b></td>
                                            </tr>
                                            <tr > 
                                                <td colspan="3"></td>
                                                <td  >{{ $row_enter_detail->plate_number }}xx</td>
                                                <td>{{ $row_enter_detail->p_import }}</td>
                                                <td>{{ ($row_enter_detail->weight) }}</td>
                                                <td>{{ $row_enter_detail->t_type_name }}</td>
                                            </tr>
                                        @else
                                            <tr > 
                                                <td colspan="3"></td> 
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
