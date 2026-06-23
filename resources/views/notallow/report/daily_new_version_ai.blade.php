
    public function daily($start, $end)
    {
        $start_original = $start;
        $end_original   = $end;

        // user 805 => show all dates (no filter)
        if (auth()->user()->id == '805') {
            $start = null;
            $end   = null;
        }

        $com        = DB::table('beta_company_group')->get();
        $main_road  = DB::table('beta_main_road')->get();
        $beta_t_type= DB::table('beta_t_type')->get();

        // Base query for SUCCESS enters
        $baseEnter = DB::table('beta_enter as e')
            ->where('e.status', 'SUCCESS')
            ->when($start, function ($q) use ($start) {
    $q->whereDate('e.date_make', '>=', $start);
})
->when($end, function ($q) use ($end) {
    $q->whereDate('e.date_make', '<=', $end);
});

        // 1) beta_enter list
        $beta_enter = (clone $baseEnter)
            ->orderBy('e.date_make', 'asc')
            ->get();

        // 2) count per company (COUNT DISTINCT enter_id is usually what you want)
        // If you truly want count of details rows, use join + count(ed.enter_id) instead.
        $count_beta_enter = (clone $baseEnter)
            ->select('e.com_id', DB::raw('COUNT(DISTINCT e.enter_id) AS TOTAL_COUNT_COM'))
            ->groupBy('e.com_id')
            ->get()
            ->keyBy('com_id');

        // 3) count details per company (this matches your old $count_t_model logic)
        $count_t_model = DB::table('beta_enter_detail as ed')
            ->join('beta_enter as e', 'ed.enter_id', '=', 'e.enter_id')
            ->where('e.status', 'SUCCESS')
            ->when($start, function ($q) use ($start) {
    $q->whereDate('e.date_make', '>=', $start);
})
->when($end, function ($q) use ($end) {
    $q->whereDate('e.date_make', '<=', $end);
})
            ->select('e.com_id', DB::raw('COUNT(ed.enter_id) AS TOTAL_COUNT'))
            ->groupBy('e.com_id')
            ->get()
            ->keyBy('com_id');

        // 4) main_road counts
        $count_main_road = DB::table('beta_enter as e')
            ->join('beta_enter_detail as ed', 'e.enter_id', '=', 'ed.enter_id')
            ->where('e.status', 'SUCCESS')
            ->when($start, function ($q) use ($start) {
    $q->whereDate('e.date_make', '>=', $start);
})
->when($end, function ($q) use ($end) {
    $q->whereDate('e.date_make', '<=', $end);
})
            ->select('e.main_road_id', DB::raw('COUNT(ed.enter_id) AS TOTAL_COUNT_MAIN_ROAD'))
            ->groupBy('e.main_road_id')
            ->get()
            ->keyBy('main_road_id');

        // 5) t_type counts
        $count_beta_t_type = DB::table('beta_enter as e')
            ->join('beta_enter_detail as ed', 'e.enter_id', '=', 'ed.enter_id')
            ->where('e.status', 'SUCCESS')
           ->when($start, function ($q) use ($start) {
                $q->whereDate('e.date_make', '>=', $start);
            })
            ->when($end, function ($q) use ($end) {
                $q->whereDate('e.date_make', '<=', $end);
            })
            ->select('ed.t_model', DB::raw('COUNT(ed.enter_id) AS TOTAL_COUNT_T'))
            ->groupBy('ed.t_model')
            ->get()
            ->keyBy('t_model');

        // 6) detail rows (only needed when sw on)
        $enter_detail = DB::table('beta_enter_detail as ed')
            ->join('beta_enter as e', 'ed.enter_id', '=', 'e.enter_id')
            ->join('beta_t_type as t', 'ed.t_model', '=', 't.t_type_id')
            ->where('e.status', 'SUCCESS')
            ->when($start, function ($q) use ($start) {
    $q->whereDate('e.date_make', '>=', $start);
})
->when($end, function ($q) use ($end) {
    $q->whereDate('e.date_make', '<=', $end);
})
            ->select(
                'e.enter_id', 'e.com_id', 'e.date_make', 'e.enter_number',
                'ed.enter_detail_id','ed.plate_number','ed.p_import','ed.weight','ed.t_model',
                't.t_type_name'
            )
            ->orderBy('e.date_make','asc')
            ->get();

        $sw = $enter_detail->count() > 1000 ? 'off' : 'on';

        // Index details by com_id then enter_id for fast Blade rendering
        $detailsByComEnter = [];
        if ($sw === 'on') {
            foreach ($enter_detail as $d) {
                $detailsByComEnter[$d->com_id][$d->enter_id][] = $d;
            }
        }

        return view('notallow.report.daily', compact(
            'com',
            'main_road',
            'beta_t_type',
            'beta_enter',
            'sw',
            'detailsByComEnter',
            'count_t_model',
            'count_main_road',
            'count_beta_t_type',
            'count_beta_enter'
        ))
        ->with('start', $start_original)
        ->with('end', $end_original);
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
@endforeach
                </table>
                
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</x-app-layout>
