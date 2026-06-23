<x-app-layout>
   <div class="container">
    <div class="row">
        <div class="col-12">

            <h5>{{ $start }} > {{ $end }}</h5>

            <table class="table table-bordered">
                <tr>
                    <th>ວັນທີ</th>
                    <th>User 222</th>
                    <th>User 2</th>
                    <td>ຍົກເລີກ</td>
                    <th>20%</th>
                    <th>ອອກບິນ</th>
                    <th>ບໍອອກບິນ</th>
                    <th>ອອກບິນ</th>
                    <th>ບໍອອກບິນ</th>
                    <th>ແບບພີມ</th>
                    <th>20%</th>
                    <th>30%</th>
                    <th>70%</th>
                    <th>ແບບພີມ 50%</th>
                    <th>ຍອດເຫລືອແບບພີມ</th>
                    <th>ແບບພີມບໍ່ອອກບິນ</th>
                    <th>+</th>
                    <th>ລວມ 18+10</th>
                </tr>

               @php
                    // Initialize all grand total variables
                    $grandTotal = 0;
                    $grandTotal80 = 0;
                    $grandCancel = 0;
                    $grandTwentyPercent = 0;
                    $grandSameTake = 0;
                    $grandNoTakeDiff = 0;
                    $grandTotalBilled = 0;
                    $grandTotalNotBilled = 0;
                    $grandModelPrice = 0;
                    $grandTwentyPctPrice = 0;
                    $grandThirtyPctCut = 0;
                    $grandSeventyPctRem = 0;
                    $grandModelFiftyPct = 0;
                    $grandModelBalance = 0;
                    $grandNoBillModel = 0;
                    $grandSumPlus = 0;
                    $grandFinalTotal = 0;
                @endphp

               @foreach ($count_by_day as $row)
    @php
        // 1. Core Calculations
        $dayTotal = $row->total;
        $dayTotal80 = ceil($dayTotal * 0.754); 
        $cancel = $cancel_values[$row->report_date] ?? 0;
        $twentyPercentCount = $dayTotal - $dayTotal80;
        $no_take = ($dayTotal80 - $cancel);

        // 2. Find matching take count
        $same = 0;
        foreach($get_count as $r_take) {
            if($r_take->date_only == $row->report_date) {
                $same = $r_take->total_take;
                break; 
            }
        }

        // 3. Financial Calculations
        $billedVal = $same * 60000;
        $notBilledVal = ($no_take - $same) * 80000;
        $modelPriceVal = $same * 20000;
        $twentyPctPriceVal = $twentyPercentCount * 80000;
        $thirtyPctCutVal = ($billedVal * 30) / 100;
        $seventyPctRemVal = $billedVal - $thirtyPctCutVal;
        $modelFiftyPctVal = $modelPriceVal / 4;
        $modelBalanceVal = $modelPriceVal - $modelFiftyPctVal;
        $noBillModelVal = ($no_take - $same) * 20000;
        
        $sumPlusVal = $modelBalanceVal + $noBillModelVal;
        $finalTotalVal = $sumPlusVal + $notBilledVal;

        // 4. Add to Grand Totals
        $grandTotal += $dayTotal;
        $grandTotal80 += $dayTotal80;
        $grandCancel += $cancel;
        $grandTwentyPercent += $twentyPercentCount;
        $grandSameTake += $same;
        $grandNoTakeDiff += ($no_take - $same);
        $grandTotalBilled += $billedVal;
        $grandTotalNotBilled += $notBilledVal;
        $grandModelPrice += $modelPriceVal;
        $grandTwentyPctPrice += $twentyPctPriceVal;
        $grandThirtyPctCut += $thirtyPctCutVal;
        $grandSeventyPctRem += $seventyPctRemVal;
        $grandModelFiftyPct += $modelFiftyPctVal;
        $grandModelBalance += $modelBalanceVal;
        $grandNoBillModel += $noBillModelVal;
        $grandSumPlus += $sumPlusVal;
        $grandFinalTotal += $finalTotalVal;
    @endphp
    <tr>
        <td>{{ $row->report_date }}</td>
        <td>{{ number_format($dayTotal) }}</td>
        <td>{{ number_format($dayTotal80) }}</td>
        <td>{{ number_format($cancel) }}</td>
        <td>{{ number_format($twentyPercentCount) }}</td>
        <td>{{ number_format($same) }}</td>
        <td>{{ number_format($no_take - $same) }}</td>
        <td>{{ number_format($billedVal) }}</td>
        <td>{{ number_format($notBilledVal) }}</td>
        <td>{{ number_format($modelPriceVal) }}</td>
        <td>{{ number_format($twentyPctPriceVal) }}</td>
        <td>{{ number_format($thirtyPctCutVal) }}</td>
        <td>{{ number_format($seventyPctRemVal) }}</td>
        <td>{{ number_format($modelFiftyPctVal) }}</td>
        <td>{{ number_format($modelBalanceVal) }}</td>
        <td>{{ number_format($noBillModelVal) }}</td>
        <td>{{ number_format($sumPlusVal) }}</td>
        <td>{{ number_format($finalTotalVal) }}</td>
    </tr>
@endforeach

               <tr style="background-color: #f8f9fa; font-weight: bold;">
                    <td>ລວມ (Total)</td>
                    <td>{{ number_format($grandTotal) }}</td>
                    <td>{{ number_format($grandTotal80) }}</td>
                    <td>{{ number_format($grandCancel) }}</td>
                    <td>{{ number_format($grandTwentyPercent) }}</td>
                    <td>{{ number_format($grandSameTake) }}</td>
                    <td>{{ number_format($grandNoTakeDiff) }}</td>
                    <td>{{ number_format($grandTotalBilled) }}</td>
                    <td>{{ number_format($grandTotalNotBilled) }}</td>
                    <td>{{ number_format($grandModelPrice) }}</td>
                    <td>{{ number_format($grandTwentyPctPrice) }}</td>
                    <td>{{ number_format($grandThirtyPctCut) }}</td>
                    <td>{{ number_format($grandSeventyPctRem) }}</td>
                    <td>{{ number_format($grandModelFiftyPct) }}</td>
                    <td>{{ number_format($grandModelBalance) }}</td>
                    <td>{{ number_format($grandNoBillModel) }}</td>
                    <td>{{ number_format($grandSumPlus) }}</td>
                    <td>{{ number_format($grandFinalTotal) }}</td>
                </tr>
            </table>

        </div>
    </div>
   </div>
</x-app-layout>