@php
    $enter = $beta_enter[0] ?? null;
    $permitNo   = $enter->enter_number ?? '—';
    $dateSign   = $enter->date_sign ? \Carbon\Carbon::parse($enter->date_sign)->format('d/m/Y') : '—';
    $dateIn     = $enter->date_in   ? \Carbon\Carbon::parse($enter->date_in)->format('d/m/Y')   : '—';
    $dateOut    = $enter->date_out  ? \Carbon\Carbon::parse($enter->date_out)->format('d/m/Y')  : '—';
    $status     = $enter->status ?? '—';
    $statusClass = [
        'SUCCESS'  => 'badge--success',
        'SIGNINED' => 'badge--success',
        'WAITING'  => 'badge--warning',
        'REJECT'   => 'badge--danger',
    ][$status] ?? 'badge--muted';

    $companyOwner = $com_owner_name ?? '—';
    $companyName  = $com_name ?? '—';

    $address  = isset($enter->address)  ? str_replace('ບ້ານ','',$enter->address)   : '—';
    $district = isset($enter->district) ? str_replace('ເມືອງ','',$enter->district) : '—';
    $province = isset($enter->province) ? str_replace('ແຂວງ','',$enter->province)   : '—';

    $verifyUrl = url('verified/check/'.($enter->slug ?? ''));
@endphp

<style>
:root{
  --ink:#0f172a;        /* slate-900 */
  --sub:#475569;        /* slate-600 */
  --line:#e2e8f0;       /* slate-200 */
  --soft:#f8fafc;       /* slate-50 */
  --brand:#0a4e9b;
  --ok:#0f766e;         /* teal-700 */
  --warn:#a16207;       /* amber-700 */
  --err:#b91c1c;        /* red-700 */
  --muted:#475569;
}
*{box-sizing:border-box}
html,body{margin:0;padding:0}
body{font-family:phetsarath,roboto,"Noto Sans Lao","Segoe UI",system-ui,Arial,sans-serif;color:var(--ink);background:#fafafa}
a{color:var(--brand);text-decoration:none}
.container{max-width:980px;margin:24px auto;padding:0 16px}
.card{
  background:#fff;border:1px solid var(--line);border-radius:14px;
  box-shadow:0 6px 20px rgba(2,8,23,0.06);
  overflow:hidden;
}
.card__hdr{
  display:flex;align-items:center;gap:16px;
  padding:20px 20px;border-bottom:1px solid var(--line);background:linear-gradient(180deg,#ffffff, #fbfdff)
}
.hdr__emblem{width:56px;height:56px;object-fit:contain}
.hdr__title{
  flex:1;line-height:1.2
}
.hdr__title .t1{font-size:18px;font-weight:700}
.hdr__title .t2{font-size:13px;color:var(--sub)}
.badge{
  font-size:12px;font-weight:700;padding:6px 10px;border-radius:999px;display:inline-block;white-space:nowrap
}
.badge--success{background:#d1fae5;color:var(--ok);border:1px solid #99f6e4}
.badge--warning{background:#fef3c7;color:var(--warn);border:1px solid #fde68a}
.badge--danger{background:#fee2e2;color:var(--err);border:1px solid #fecaca}
.badge--muted{background:#e2e8f0;color:var(--muted);border:1px solid #cbd5e1}

.card__body{padding:16px 20px 24px}
.meta{
  display:grid;grid-template-columns:1.5fr 1fr;gap:18px;align-items:start
}
.meta__left{}
.meta__right{text-align:right}
.qr-wrap{display:inline-block;text-align:center}
.qr-wrap img,.qr-wrap canvas{width:140px;height:140px;border:1px solid var(--line);border-radius:10px;background:#fff}
.qr-caption{font-size:11px;color:var(--sub);margin-top:6px}

.kv{display:grid;grid-template-columns:160px 1fr;gap:10px;margin:10px 0}
.kv b{font-weight:700}
.kv .k{color:var(--sub)}
.divider{height:1px;background:var(--line);margin:18px 0}

.table{
  width:100%;border-collapse:separate;border-spacing:0;overflow:hidden;border:1px solid var(--line);border-radius:12px
}
.table th, .table td{padding:10px 12px;font-size:13px;border-bottom:1px solid var(--line)}
.table thead th{
  background:var(--soft);text-align:left;font-weight:700;position:sticky;top:0;z-index:1
}
.table tbody tr:hover{background:#fafcff}
.table tbody tr:last-child td{border-bottom:none}
.num{text-align:center;width:64px;color:var(--sub)}
.cell-small{white-space:nowrap}
.note{font-size:12px;color:var(--sub)}

.footer{padding:14px 20px;border-top:1px solid var(--line);background:#fff;color:var(--sub);font-size:12px}

@media (max-width:720px){
  .meta{grid-template-columns:1fr}
  .meta__right{text-align:left;margin-top:10px}
  .kv{grid-template-columns:120px 1fr}
}

@media print{
  body{background:#fff}
  .container{max-width:100%;margin:0}
  .card{box-shadow:none;border:1px solid #000}
  .badge{border-color:#000 !important;color:#000 !important;background:#fff !important}
  a{color:#000;text-decoration:underline}
}
  .watermark {
              position: absolute;
              top: 25%;
              left: 50%;
              transform: translate(-50%, -20%); /* center horizontally, shift slightly upward */
              opacity: 0.1; /* make it faint */
              z-index: 1;
              pointer-events: none; /* so it doesn’t block text selection */
            }

            .watermark img {
              max-width: 450px; /* adjust size */
              height: auto;
            }
</style>

<div class="container">

                <div class="watermark">
                    <img src="{{ asset('/image/45.png') }}" alt="Watermark Logo" style="">
                </div>
  <div class="card">
    <!-- Header -->
    <div class="card__hdr">
      <!-- <img class="hdr__emblem" src="{{ asset('/image/Emblem_of_Laos.png') }}" alt="Emblem"> -->
      <div class="hdr__title">
        <!-- <div class="t1">ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ</div>
        <div class="t2">ສັນຕິພາບ · ເອກະລາດ · ປະຊາທິປະໄຕ · ເອກະພາບ · ວັດທະນະຖາວອນ</div> -->
      </div>
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#15d300ff"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
      <span class="badge {{ $statusClass }}">{{ $status }}</span>
    </div>

    <!-- Body -->
    <div class="card__body">

      <!-- Top meta (left: titles & fields, right: QR) -->
      <div class="meta">

        <div class="meta__left">
          <div class="t1" style="font-size:16px;font-weight:800;margin-bottom:6px;">
            ໃບອະນຸຍາດລົດບັນທຸກຂົນສົ່ງສິນຄ້າ ເຂົ້າ-ອອກຜ່ານດ່ານ
          </div>

          <div class="kv">
            <div class="k">ເລກທີ</div><div><b>{{ $permitNo }}</b> / ດຂ1.ນວ</div>
          </div>
          <div class="kv">
            <div class="k">ວັນທີອະນຸມັດ</div><div><b>{{ $dateSign }}</b></div>
          </div>
          <div class="divider"></div>

          <div class="kv">
            <div class="k">ບໍລິສັດ</div><div><b>{{ $companyName }}</b></div>
          </div>
          <div class="kv">
            <div class="k">ເຈົ້າຂອງ</div><div>{{ $companyOwner }}</div>
          </div>
          <div class="kv">
            <div class="k">ປາຍທາງ</div><div>ບ. {{ $address }} · ເມືອງ {{ $district }} · ແຂວງ {{ $province }}</div>
          </div>
          <div class="kv">
            <div class="k">ກຳນົດເວລາ</div><div>{{ $dateIn }} → {{ $dateOut }}</div>
          </div>

          <div class="divider"></div>
          <div style="font-size:12px;color:var(--sub)">
            - ອີງຕາມ ດຳລັດວ່າດ້ວຍດ່ານ ເຂົ້າ-ອອກ ສະບັບ 643/ລບ (25/11/2024)<br>
            - ອີງຕາມ ຂໍ້ຕົກລົງ ສະບັບ 691/ຈນວ (09/07/2025)
          </div>
        </div>

        <div class="meta__right">
          {{-- QR: choose your method (JS or prebuilt PNG). Example with quickchart.io --}}
          <div class="qr-wrap">
            <img src="https://quickchart.io/qr?text={{ urlencode($verifyUrl) }}&size=140&margin=1&ecLevel=M" alt="Verify QR">
            <!-- <div class="qr-caption">Scan to verify</div> -->
          </div>
          <div style="margin-top:8px;font-size:11px;color:var(--sub);word-break:break-all;">
            {{ $verifyUrl }}
          </div>
        </div>

      </div>

      <div class="divider"></div>

      <!-- Vehicles table -->
      <div style="overflow:auto">
        <table class="table">
          <thead>
            <tr>
              <th class="num">ລ/ດ</th>
              <th>ໜາຍເລກທະບຽນລົດ</th>
              <th>ຊື່ຜູ້ຂັບລົດ</th>
              <th class="cell-small">ປະເພດລົດ</th>
              <th>ເລກທີນຳເຂົ້າສິນຄ້າ</th>
              <th>ປະເພດສິນຄ້າ</th>
              <th class="cell-small">ນ້ຳໜັກ (Kg)</th>
            </tr>
          </thead>
          <tbody>
          @php($i=1)
          @foreach ($beta_enter_detail as $row)
            <tr>
              <td class="num">{{ $i++ }}</td>
              <td>{{ $row->plate_number }}</td>
              <td>{{ $row->d_name }}</td>
              <td class="cell-small">{{ $row->t_type_name }}</td>
              <td>{{ $row->detail }}</td>
              <td>{{ $row->p_import }}</td>
              <td class="cell-small">
                @if($row->weight)
                  {{ number_format(preg_replace('/\D/', '', $row->weight)) }}
                @else
                  —
                @endif
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>

      @if(!empty($enter->feed_back_msg))
      <div style="margin-top:10px" class="note">
        <b>ໝາຍເຫດ:</b> {{ $enter->feed_back_msg }}
      </div>
      @endif

    </div>

    <!-- Footer -->
    <div class="footer">
      ດ່ານສາກົນຂົວມິດຕະພາບ 1 · ນະຄອນຫຼວງວຽງຈັນ · ຈຸດບໍລິການ ທ່ານາແລ້ງ-ດົງໂພສີ
    </div>
  </div>
</div>
