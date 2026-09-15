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

                @if(!empty($daily_vehicle_messages))
                  <div class="alert alert-warning">
                    @foreach($daily_vehicle_messages as $message)
                      <div>{{ $message }}</div>
                    @endforeach
                  </div>
                @endif
                
                @if(!empty($daily_vehicle_validation))
                  <table class="table table-bordered">
                    <tr>
                      <td>ວັນທີ</td>
                      <td>{{ date('d-m-Y', strtotime($start)) }} - {{ date('d-m-Y', strtotime($end)) }}</td>
                    </tr>
                    <tr>
                      <td>ເປົ້າໝາຍຈາກ daily_vehicle_statistics</td>
                      <td>{{ $daily_vehicle_validation['target'] }}</td>
                    </tr>
                    <tr>
                      <td>ຈຳນວນທີ່ສະແດງ</td>
                      <td>{{ $daily_vehicle_validation['selected_count'] }}</td>
                    </tr>
                    <tr>
                      <td>ລວມທັງໝົດ</td>
                      <td>{{ $daily_vehicle_validation['grand_total'] }}</td>
                    </tr>
                    <tr>
                      <td>ສ່ວນຕ່າງ</td>
                      <td>{{ $daily_vehicle_validation['difference'] }}</td>
                    </tr>
                    <tr>
                      <td>ສະຖານະ</td>
                      <td>{{ implode(', ', $daily_vehicle_validation['statuses']) }}</td>
                    </tr>
                  </table>
                @endif
                
                @if(auth()->user()->id=='805')
                    <a href="{{ url('/i/ptsd/'.$start.'/'.$end) }}" target="_BLANK">ສົ່ງອອກລາຍງານ.</a> 
                @else
                    <a href="{{ url('/ptsd/'.$start.'/'.$end) }}" target="_BLANK">ສົ່ງອອກລາຍງານ.</a>
                @endif    
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
                                    @php($c = $count_main_road[$row_main_road->main_road_id]->TOTAL_COUNT_MAIN_ROAD ?? 0)
                                    <tr>
                                      <td>{{ $row_main_road->main_road_name }}</td>
                                      <td>{{ $c }}</td>
                                    </tr>
                                    @php($total += $c)
                                  @endforeach
                                  <!-- <tr>
                                    <td>ລວມ :</td>
                                    <td>{{ $total }}</td>
                                  </tr> -->
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
                @if(auth()->user()->id=='1' || auth()->user()->id=='738'  || auth()->user()->id=='2')
                  <table class="table table-bordered">
                    <tr>
                      <td>ຈຳນວນຖ້ຽວ</td>
                      <td class="text-center"><label id="display_round">{{ $rounds_count }}</label></td> 
                    </tr> 
                    <tr>
                      <td>ຈຳນວນທີ່ຮັບບິນ</td>
                      <td class="text-center" id="display_take" style="cursor:pointer;">{{ $take_count }}</td> 
                    </tr> 
                  </table>
                @endif


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
                            <td><b><label>{{ $row_com->com_name }}</label></b></td>
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
 <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

  $(document).ready(function () {
  @if(auth()->user()->id=='1' || auth()->user()->id=='738'  || auth()->user()->id=='2')
    $('#display_take').on('click', function(){ 
      Swal.fire({
        title: "",
        html: `
            <table class="table table-bordered">
              <tr>
                <td>ລຳດັບ</td>
                <td>ບໍລິສັດ</td>
                <td>ເລກທີ່ເອກະສານ</td>
                
              </tr> 
              @php($countxx = 1)
              @if($take_list ?? '')
              @foreach ($take_list as $r) 
                <tr>
                  <td>{{ $countxx++ }}</td>
                  <td>{{ $r->com_name }}</td>
                  <td><a href="{{ route('success_search', $r->enter_number) }}" target="_BLANk">{{ $r->enter_number }}</a></td> 
                </tr>
              @endforeach
              @endif
            </table>
        `,
        width: 1200
      });
    });
  @endif
  });
</script> 

</x-app-layout>
