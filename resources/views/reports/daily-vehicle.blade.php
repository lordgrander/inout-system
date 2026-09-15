<x-app-layout>
    <style>
        .daily-report {
            color: #0f172a;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            padding: 24px;
        }

        .daily-report .panel {
            background: #ffffff;
            border: 1px solid #dbeafe;
            border-radius: 8px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
            margin-bottom: 18px;
            padding: 18px;
        }

        .daily-report h1,
        .daily-report h2 {
            color: #1d4ed8;
            font-weight: 700;
            margin: 0 0 14px;
        }

        .daily-report h1 {
            font-size: 26px;
        }

        .daily-report h2 {
            font-size: 18px;
        }

        .daily-report form {
            align-items: end;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .daily-report label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .daily-report input {
            border: 1px solid #bfdbfe;
            border-radius: 6px;
            min-height: 40px;
            padding: 8px 10px;
        }

        .daily-report button {
            background: #2563eb;
            border: 0;
            border-radius: 6px;
            color: #ffffff;
            cursor: pointer;
            font-weight: 700;
            min-height: 40px;
            padding: 8px 16px;
        }

        .daily-report .error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            color: #991b1b;
            margin-bottom: 18px;
            padding: 12px 14px;
        }

        .daily-report .grid {
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        }

        .daily-report .metric {
            background: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 8px;
            padding: 12px;
        }

        .daily-report .metric span {
            color: #64748b;
            display: block;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .daily-report .metric strong {
            display: block;
            font-size: 22px;
            margin-top: 4px;
        }

        .daily-report .status {
            border-radius: 999px;
            display: inline-block;
            font-weight: 700;
            padding: 6px 12px;
        }

        .daily-report .status-ok {
            background: #dcfce7;
            color: #166534;
        }

        .daily-report .status-warn {
            background: #fef3c7;
            color: #92400e;
        }

        .daily-report .status-bad {
            background: #fee2e2;
            color: #991b1b;
        }

        .daily-report .table-wrap {
            overflow-x: auto;
        }

        .daily-report table {
            border-collapse: collapse;
            min-width: 980px;
            width: 100%;
        }

        .daily-report th {
            background: #eff6ff;
            color: #1e40af;
            font-size: 12px;
            letter-spacing: .02em;
            text-align: left;
            text-transform: uppercase;
        }

        .daily-report th,
        .daily-report td {
            border: 1px solid #dbeafe;
            padding: 10px;
            vertical-align: top;
        }

        .daily-report tbody tr:nth-child(even) {
            background: #f8fbff;
        }

        .daily-report .summary-tables {
            display: grid;
            gap: 18px;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        }

        @media print {
            .daily-report form,
            .daily-report button {
                display: none;
            }

            .daily-report {
                padding: 0;
            }
        }
    </style>

    @php
        $status = $report['validation']['status'] ?? null;
        $statusClass = $status === 'Matched' ? 'status-ok' : (in_array($status, ['Insufficient Data', 'Impossible Target']) ? 'status-warn' : 'status-bad');
    @endphp

    <div class="daily-report">
        <div class="panel">
            <h1>Daily Vehicle Report</h1>
            <form method="GET" action="{{ route('reports.daily-vehicle.index') }}">
                <div>
                    <label for="date">Report Date</label>
                    <input id="date" name="date" type="date" value="{{ $date ?: now()->format('Y-m-d') }}" required>
                </div>
                <button type="submit">Load Report</button>
            </form>
        </div>

        @if($reportErrors->isNotEmpty())
            <div class="error">
                @foreach($reportErrors as $message)
                    <div>{{ $message }}</div>
                @endforeach
            </div>
        @endif

        @if($report)
            <div class="panel">
                <h2>Validation</h2>
                <div class="grid">
                    <div class="metric"><span>Report date</span><strong>{{ date('d-m-Y', strtotime($report['validation']['report_date'])) }}</strong></div>
                    <div class="metric"><span>Target</span><strong>{{ number_format($report['validation']['target']) }}</strong></div>
                    <div class="metric"><span>Database details</span><strong>{{ number_format($report['validation']['database_detail_count']) }}</strong></div>
                    <div class="metric"><span>Parent count</span><strong>{{ number_format($report['validation']['parent_count']) }}</strong></div>
                    <div class="metric"><span>Minimum possible</span><strong>{{ number_format($report['validation']['min_possible']) }}</strong></div>
                    <div class="metric"><span>Selected</span><strong>{{ number_format($report['validation']['selected_count']) }}</strong></div>
                    <div class="metric"><span>Displayed rows</span><strong>{{ number_format($report['validation']['displayed_detail_rows']) }}</strong></div>
                    <div class="metric"><span>Company total</span><strong>{{ number_format($report['validation']['company_total_sum']) }}</strong></div>
                    <div class="metric"><span>Vehicle summary</span><strong>{{ number_format($report['validation']['vehicle_summary_total']) }}</strong></div>
                    <div class="metric"><span>Product summary</span><strong>{{ number_format($report['validation']['product_summary_total']) }}</strong></div>
                    <div class="metric"><span>Grand total</span><strong>{{ number_format($report['validation']['grand_total']) }}</strong></div>
                    <div class="metric"><span>Difference</span><strong>{{ number_format($report['validation']['difference']) }}</strong></div>
                </div>
                <p style="margin-top: 14px;">
                    <span class="status {{ $statusClass }}">{{ $status }}</span>
                    @if($report['validation']['shortage'] > 0)
                        <span style="margin-left: 10px;">Shortage: {{ number_format($report['validation']['shortage']) }}</span>
                    @endif
                </p>
            </div>

            <div class="panel">
                <h2>Details</h2>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Company</th>
                                <th>Selected Count</th>
                                <th>Enter Date / Number</th>
                                <th>Plate</th>
                                <th>Product</th>
                                <th>Weight</th>
                                <th>Vehicle Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($report['companies'] as $companyIndex => $company)
                                @php
                                    $companyRowspan = $company['enters']->sum(function ($enter) {
                                        return $enter['details']->count();
                                    });
                                    $printedCompany = false;
                                @endphp

                                @foreach($company['enters'] as $enter)
                                    @php $printedEnter = false; @endphp

                                    @foreach($enter['details'] as $detail)
                                        <tr>
                                            @if(! $printedCompany)
                                                <td rowspan="{{ $companyRowspan }}">{{ $companyIndex + 1 }}</td>
                                                <td rowspan="{{ $companyRowspan }}">{{ $company['company_name'] }}</td>
                                                <td rowspan="{{ $companyRowspan }}">{{ number_format($company['selected_count']) }}</td>
                                                @php $printedCompany = true; @endphp
                                            @endif

                                            @if(! $printedEnter)
                                                <td rowspan="{{ $enter['details']->count() }}">
                                                    {{ date('d-m-Y', strtotime($enter['date_make'])) }} / {{ $enter['enter_number'] }}
                                                </td>
                                                @php $printedEnter = true; @endphp
                                            @endif

                                            <td>{{ $detail->plate_number ?: '-' }}</td>
                                            <td>{{ $detail->p_import ?: '-' }}</td>
                                            <td>{{ is_numeric($detail->weight) ? number_format($detail->weight) : ($detail->weight ?: '-') }}</td>
                                            <td>{{ $detail->t_type_name ?: '-' }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="8">No selected vehicle details for this date.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="summary-tables">
                <div class="panel">
                    <h2>Product Summary</h2>
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($report['product_summary'] as $row)
                                    <tr>
                                        <td>{{ $row['name'] }}</td>
                                        <td>{{ number_format($row['total']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="panel">
                    <h2>Vehicle Type Summary</h2>
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Vehicle Type</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($report['vehicle_summary'] as $row)
                                    <tr>
                                        <td>{{ $row['name'] }}</td>
                                        <td>{{ number_format($row['total']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
