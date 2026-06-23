 
<x-app-layout>
  {{-- Murphy Light Table/Card skin --}}
  <style>
    :root{
      --murphy-border:#e5e7eb; --murphy-text:#111827; --murphy-muted:#6b7280;
      --murphy-accent:#2563eb; --murphy-bg:#f6f8fb; --murphy-card:#ffffff;
    }
    body{ background:radial-gradient(1200px 700px at -10% -10%, #fff 0, #eef2f7 55%, var(--murphy-bg) 100%) }

    .murphy_wrap{ max-width:1100px; margin:18px auto; padding:0 12px; }
    .murphy_card{
      background:var(--murphy-card); border:1px solid var(--murphy-border); border-radius:16px;
      box-shadow:0 10px 24px rgba(17,24,39,.08);
    }
    .murphy_head{ padding:16px 18px; border-bottom:1px solid var(--murphy-border); display:flex; gap:12px; flex-wrap:wrap; align-items:center; justify-content:space-between; }
    .murphy_title{ margin:0; font-size:1.25rem; font-weight:800; color:var(--murphy-text); letter-spacing:.2px; }
    .murphy_tools{ display:flex; gap:10px; align-items:center; }
    .murphy_search{
      border:1px solid var(--murphy-border); border-radius:12px; padding:10px 12px; min-width:240px;
    }
    .murphy_btn{
      border:2px solid var(--murphy-accent); color:var(--murphy-accent); background:#fff;
      padding:9px 14px; border-radius:12px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:.5ch;
    }
    .murphy_body{ padding:12px; }

    /* Desktop table */
    .murphy_table{ width:100%; border-collapse:separate; border-spacing:0; }
    .murphy_table thead th{
      background:#f4f7fc; color:#334155; font-weight:700; text-align:left; padding:12px; border-bottom:1px solid var(--murphy-border);
    }
    .murphy_table tbody td{
      padding:12px; border-bottom:1px solid var(--murphy-border); color:var(--murphy-text);
    }
    .murphy_table tbody tr:last-child td{ border-bottom:0; }

    /* Status badge */
    .murphy_badge{ display:inline-block; padding:4px 10px; border-radius:999px; font-weight:700; font-size:.8rem; border:1px solid; }
    .murphy_badge--active   { color:#057a55; background:#e8f9f3; border-color:#cbeee3; }
    .murphy_badge--inactive { color:#b91c1c; background:#ffecec; border-color:#ffd2d2; }
    .murphy_badge--pending  { color:#1d4ed8; background:#eaf1ff; border-color:#cbd9ff; }

    /* Mobile cards */
    .murphy_mobile{ display:grid; gap:12px; }
    .murphy_company{
      background:#fff; border:1px solid var(--murphy-border); border-radius:14px; padding:12px;
      box-shadow:0 6px 18px rgba(17,24,39,.06);
    }
    .murphy_row{ display:flex; justify-content:space-between; gap:10px; padding:6px 0; }
    .murphy_label{ color:var(--murphy-muted); font-size:.9rem; }
    .murphy_value{ color:var(--murphy-text); font-weight:600; text-align:right; }
    .murphy_meta{ display:flex; gap:8px; flex-wrap:wrap; margin-top:6px; color:var(--murphy-muted); font-size:.9rem; }

    /* Switch: table on ≥900px, cards on <900px */
    .murphy_desktop{ display:none; }
    @media (min-width:900px){
      .murphy_desktop{ display:block; }
      .murphy_mobile{ display:none; }
    }

    /* Tiny helpers */
    .murphy_phone a{ color:var(--murphy-accent); text-decoration:none; }
    .murphy_phone a:hover{ text-decoration:underline; }
    .murphy_pager{ display:flex; justify-content:center; padding:16px; }
  </style>

  <div class="murphy_wrap">
    <div class="murphy_card">
      <div class="murphy_head">
        <h2 class="murphy_title">ລາຍການບໍລິສັດ </h2>

        {{-- optional quick search (GET ?q=) --}}
        <div class="murphy_tools">
            <input type="text" id="murphy_search" class="murphy_search" placeholder="Search company / owner / phone…">
            <button class="murphy_btn" id="murphy_search_btn" type="button">Search</button>
        </div>
      </div>

      <div class="murphy_body">
        {{-- Desktop table --}}
        <div class="murphy_desktop">
          <table class="murphy_table">
            <thead>
              <tr>
                <th style="width:28%">ບໍລິສັດ</th>
                <th style="width:20%">ເຈົ້າຂອງ</th>
                <th style="width:18%">ໂທ</th>
                <th style="width:14%">ສະຖານະ</th>
                <th style="width:20%">ອາຍຸໃຊ້ (Active → End)</th>
              </tr>
            </thead>
            <tbody>
              @forelse($company as $c)
                @php
                $status = strtoupper((string)($c->com_status ?? ''));
                    if ($status === 'ACTIVE') {
                        $badgeClass = 'murphy_badge murphy_badge--active';
                    } elseif ($status === 'INACTIVE') {
                        $badgeClass = 'murphy_badge murphy_badge--inactive';
                    } else {
                        $badgeClass = 'murphy_badge murphy_badge--pending';
                    }
                @endphp
                <tr>
                  <td>
                    <div style="font-weight:700">{{ $c->com_name }}</div>
                    <div class="murphy_meta">
                      {{-- you can place extra meta here if needed --}}
                    </div>
                  </td>
                  <td>{{ $c->com_owner }}</td>
                  <td class="murphy_phone">
                    @if($c->com_phone)
                       {{ $c->com_phone }} 
                    @endif
                  </td>
                  <td><span class="{{ $badgeClass }}">{{ $status ?: 'PENDING' }}</span></td>
                  <td>
                    {{ optional($c->active_at)->format('d-m-Y') ?? '-' }}
                    &nbsp;→&nbsp;
                    {{ optional($c->end_at)->format('d-m-Y') ?? '-' }}
                  </td>
                </tr>
              @empty
                <tr><td colspan="5">No companies found.</td></tr>
              @endforelse
            </tbody>
          </table>

          <div class="murphy_pager">
            {{ $company->withQueryString()->links() }}
          </div>
        </div>

        {{-- Mobile cards --}}
        <div class="murphy_mobile">
          @forelse($company as $c)
            @php
                $status = strtoupper((string)($c->com_status ?? ''));
                if ($status === 'ACTIVE') {
                    $badgeClass = 'murphy_badge murphy_badge--active';
                } elseif ($status === 'INACTIVE') {
                    $badgeClass = 'murphy_badge murphy_badge--inactive';
                } else {
                    $badgeClass = 'murphy_badge murphy_badge--pending';
                }
            @endphp
            <article class="murphy_company">
              <div class="murphy_row">
                <span class="murphy_label">ບໍລິສັດ</span>
                <span class="murphy_value">{{ $c->com_name }}</span>
              </div>
              <div class="murphy_row">
                <span class="murphy_label">ເຈົ້າຂອງ</span>
                <span class="murphy_value">{{ $c->com_owner }}</span>
              </div>
              <div class="murphy_row">
                <span class="murphy_label">ໂທ</span>
                <span class="murphy_value murphy_phone">
                  @if($c->com_phone)
                    <a href="tel:{{ preg_replace('/\s+/', '', $c->com_phone) }}">{{ $c->com_phone }}</a>
                  @else
                    -
                  @endif
                </span>
              </div>
              <div class="murphy_row">
                <span class="murphy_label">ສະຖານະ</span>
                <span class="murphy_value"><span class="{{ $badgeClass }}">{{ $status ?: 'PENDING' }}</span></span>
              </div>
              <div class="murphy_row">
                <span class="murphy_label">Active → End</span>
                <span class="murphy_value">
                  {{ optional($c->active_at)->format('d-m-Y') ?? '-' }}
                  → {{ optional($c->end_at)->format('d-m-Y') ?? '-' }}
                </span>
              </div>
            </article>
          @empty
            <div class="murphy_company">No companies found.</div>
          @endforelse

          <div class="murphy_pager">
            {{ $company->withQueryString()->links() }}
          </div>
        </div>

      </div>
    </div>
  </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function(){
    // search on click
    $('#murphy_search_btn').on('click', function(){
        fetchCompanies($('#murphy_search').val());
    });

    // or on Enter key
    $('#murphy_search').on('keypress', function(e){
        if(e.which === 13){
        e.preventDefault();
        fetchCompanies($(this).val());
        }
    });

    function fetchCompanies(query){
        $.ajax({
        url: '{{ route("quotar.tell.search") }}',
        method: 'GET',
        data: { q: query },
        beforeSend: function(){
            $('.murphy_body').html('<div style="text-align:center;padding:20px;">Loading...</div>');
        },
        success: function(data){
            if(!data.length){
            $('.murphy_body').html('<div style="text-align:center;padding:20px;">No companies found</div>');
            return;
            }

            let tableHTML = `
            <table class="murphy_table">
                <thead>
                <tr>
                    <th>ບໍລິສັດ</th>
                    <th>ເຈົ້າຂອງ</th>
                    <th>ໂທ</th>
                    <th>ສະຖານະ</th>
                    <th>Active → End</th>
                </tr>
                </thead>
                <tbody>
            `;

            data.forEach(c => {
            const status = (c.com_status ?? '').toUpperCase();
            let badgeClass = 'murphy_badge murphy_badge--pending';
            if(status === 'ACTIVE') badgeClass = 'murphy_badge murphy_badge--active';
            else if(status === 'INACTIVE') badgeClass = 'murphy_badge murphy_badge--inactive';

            tableHTML += `
                <tr>
                <td>${c.com_name ?? '-'}</td>
                <td>${c.com_owner ?? '-'}</td>
                <td><a href="tel:${c.com_phone ?? ''}">${c.com_phone ?? '-'}</a></td>
                <td><span class="${badgeClass}">${status || 'PENDING'}</span></td>
                <td>${c.active_at ?? '-'} → ${c.end_at ?? '-'}</td>
                </tr>
            `;
            });

            tableHTML += '</tbody></table>';

            $('.murphy_body').html('<div class="murphy_desktop">'+tableHTML+'</div>');
        },
        error: function(xhr){
            $('.murphy_body').html('<div style="text-align:center;padding:20px;color:red;">Error loading data</div>');
        }
        });
    }
    });
</script>

</x-app-layout>
