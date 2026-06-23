{{-- resources/views/allow/expired/index.blade.php --}}
<style>
    .form-control
    {
        background-color: #e1e1e1!important;
    }
    
</style>

<style>
  /* ===== Expired List — Murphy Light Table (mobile-safe) ===== */
  :root{
    --ink:#0b1221;
    --sub:#5b677a;
    --line:#e6ebf2;
    --card:#ffffff;
    --soft:#f6f9ff;
    --brand:#0a5ad1;
    --danger:#ff4757;
    --shadow:0 10px 30px rgba(9,30,66,.10);
    --radius:4px;
  }

  /* Container polish */
  .card{
    border:1px solid var(--line);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    background: linear-gradient(180deg,#fff,#fbfdff);
  }

  /* ===== Filter bar: wraps nicely on mobile ===== */
  .card form.flex{
    flex-wrap: wrap;
    justify-content: center;
    gap:10px!important;
  }
  .card .form-select,
  .card .form-control{
    border:1px solid var(--line)!important;
    border-radius: 4px!important;
    height:44px;
  }
  .card button.btn{
    height:44px;
    border-radius:4px;
    font-weight:800;
    padding:10px 16px;
  }

  /* ===== Table wrapper to prevent page breaking ===== */
  .murphy-table-wrap{
    width:100%;
    overflow-x:auto;
    -webkit-overflow-scrolling: touch;
    border-radius: 4px;
    border:1px solid var(--line);
    background:#fff;
  }

  /* ===== Table (desktop/tablet) ===== */
  .murphy-table{
    width:100%;
    min-width: 980px; /* prevents squish-break */
    border-collapse: separate!important;
    border-spacing: 0;
    margin:0!important;
  }

  .murphy-table thead th{
    position: sticky;
    top:0;
    z-index:2;
    background: linear-gradient(180deg,#f7f9fe,#eff4ff);
    color:#24324a;
    font-weight:900;
    font-size:.92rem;
    padding:12px 12px;
    border-bottom:1px solid var(--line)!important;
    white-space: nowrap;
  }

  .murphy-table tbody td{
    padding:12px 12px;
    border-bottom:1px solid var(--line)!important;
    vertical-align: middle;
    color:var(--ink);
    background:#fff;
    white-space: nowrap;
  }

  .murphy-table tbody tr:nth-child(even) td{ background:#fcfdff; }
  .murphy-table tbody tr:hover td{ background:#f6f9ff; }

  /* end_at pill */
  .murphy-pill{
    display:inline-block;
    padding:6px 10px;
    border-radius:4px;
    font-weight:800;
    font-size:.9rem;
    border:1px solid var(--line);
  }
  .murphy-pill--expired{
    background: rgba(255,71,87,.10);
    color: var(--danger);
    border-color: rgba(255,71,87,.25);
  }
  .murphy-pill--active{
    background: rgba(10,90,209,.10);
    color: var(--brand);
    border-color: rgba(10,90,209,.20);
  }

  /* date input + button sizing inside table */
  .murphy-table input[type="date"]{
    height:40px;
    border-radius: 4px!important;
    border:1px solid var(--line)!important;
    background:#fff!important;
    min-width: 170px;
  }
  .murphy-table .btn-active{
    height:40px;
    border-radius: 4px;
    font-weight:900;
    padding:8px 14px;
    white-space: nowrap;
  }

  /* ===== Mobile: convert rows to cards (no markup change needed) ===== */
  @media (max-width: 768px){

    /* filter bar: full width */
    .card form.flex > *{ width:100%; max-width: 520px; }
    .card form.flex input.form-control{ width:100%!important; }

    .murphy-table-wrap{
      border:none;
      background:transparent;
      overflow:visible;
    }

    .murphy-table{
      min-width: 0;
      display:block;
    }

    .murphy-table thead{ display:none; }
    .murphy-table tbody{
      display:grid;
      gap:12px;
    }
    .murphy-table tbody tr{
      display:grid;
      gap:8px;
      padding:12px;
      border:1px solid var(--line);
      border-radius: 4px;
      background:#fff;
      box-shadow: var(--shadow);
    }
    .murphy-table tbody td{
      display:flex;
      justify-content: space-between;
      align-items: center;
      gap:12px;
      border:none!important;
      padding:8px 2px;
      white-space: normal;
    }

    /* Labels (matches your column order exactly) */
    .murphy-table tbody td:nth-child(1)::before{ content:"ລ.ດ"; font-weight:900; color:#334155; }
    .murphy-table tbody td:nth-child(2)::before{ content:"ຊື່ຜູ້ໃຊ້"; font-weight:900; color:#334155; }
    .murphy-table tbody td:nth-child(3)::before{ content:"ບໍລິສັດ"; font-weight:900; color:#334155; }
    .murphy-table tbody td:nth-child(4)::before{ content:"ເຈົ້າຂອງ"; font-weight:900; color:#334155; }
    .murphy-table tbody td:nth-child(5)::before{ content:"ເບີໂທ"; font-weight:900; color:#334155; }
    .murphy-table tbody td:nth-child(6)::before{ content:"ຫມົດອາຍຸເມື່ອ"; font-weight:900; color:#334155; }
    .murphy-table tbody td:nth-child(7)::before{ content:"ຕໍ່ອາຍຸຮອດ"; font-weight:900; color:#334155; }
    .murphy-table tbody td:nth-child(8)::before{ content:"ຈັດການ"; font-weight:900; color:#334155; }

    /* action area looks good */
    .murphy-table tbody td:nth-child(7) input,
    .murphy-table tbody td:nth-child(8) .btn-active{
      width: 60%;
      min-width: 190px;
      justify-content: center;
    }
  }

  td
  {
    padding:0px!important;
  }
</style>

<x-app-layout> 
    <div class="cardx p-3 text-center">
        <div class="">
            <form method="GET" action="{{ route('expired.list') }}" class="flex gap-2">
                <select name="filter" class="form-select border rounded p-2">
                    <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>&nbsp;&nbsp;ທັງໝົດ&nbsp;&nbsp;</option>
                    <option value="expired" {{ request('filter') == 'expired' ? 'selected' : '' }}>&nbsp;&nbsp;ຫມົດອາຍຸ&nbsp;&nbsp;</option>
                    <option value="active" {{ request('filter') == 'active' ? 'selected' : '' }}>&nbsp;&nbsp;ຍັງໃຊ້ໄດ້&nbsp;&nbsp;</option>
                </select>

                <input type="text" name="search" placeholder="ຄົ້ນຫາຊື່ ຫຼື ເບີໂທ"
                    value="{{ request('search') }}"
                    class="form-control border rounded p-2" style="width: 250px; backgroud" >

                <button type="submit" class="btn btn-primary">ຄົ້ນຫາ</button>
            </form>
        </div> 
        <div class="murphy-table-wrap mt-3">
        <table class="table murphy-table">
            <thead>
            <tr>
                <th class="text-center">ລ.ດ</th>
                <th class="text-center">ຊື່ຜູ້ໃຊ້</th>
                <th class="text-center">ບໍລິສັດ</th>
                <th class="text-center">ເຈົ້າຂອງ</th>
                <th class="text-center">ເບີໂທ</th>
                <th class="text-center">ຫມົດອາຍຸເມື່ອ</th>
                <th class="text-center">ໃຫ້ນຳໃຊ້ຈົນຮອດວັນທີ (+30 ວັນ Auto)</th>
                <th class="text-center">ຈັດການ</th>
            </tr>
            </thead>

            <tbody>
            @php($count = ($users->currentPage() - 1) * $users->perPage() + 1)
            @foreach ($users as $row)
                <tr id="display_{{ $row->com_id }}">
                    <td class="text-center">{{ $count++ }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ optional($row->userHaveCompany)->com_name ?? '-' }}</td>
                    <td>{{ optional($row->userHaveCompany)->com_owner ?? '-' }}</td>
                    <td>{{ $row->email }}</td>

                    <td id="end_at-{{ $row->id }}" class="text-center">
                        @php($formatted = $row->end_at ? date('d-m-Y', strtotime($row->end_at)) : '-')
                        <span class="murphy-pill murphy-pill--expired">{{ $formatted }}</span>
                    </td>

                    <td>
                        <input
                        type="date"
                        class="extend-date form-control"
                        id="date-{{ $row->id }}"
                        data-id="{{ $row->id }}"
                        value="{{ \Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}"
                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                        >
                    </td>

                    <td class="text-center">
                        <button type="button" class="btn-active btn btn-primary" data-id="{{ $row->id }}">
                          ຕໍ່ອາຍຸ
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
            {{ $users->links('pagination.custome-pagination') }}
            </div> 
        </div>
    </div>
                            
{{-- if not already loaded --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).on('click', '.btn-active', function () {
        let userId = $(this).data('id');
        let dateInput = $('#date-' + userId);
        let newEndAt = dateInput.val();

        if (!newEndAt) {
            Swal.fire('ຜິດພາດ', 'ກະລຸນາເລືອກວັນທີກ່ອນ', 'error');
            return;
        }

        Swal.fire({
            title: 'ທ່ານແນ່ໃຈບໍ?',
            text: 'ຈະຕໍ່ອາຍຸຜູ້ໃຊ້ນີ້ເຖິງວັນທີ ' + newEndAt,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ຕົກລົງ',
            cancelButtonText: 'ຍົກເລີກ'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: '{{ route('users.extend') }}', // route name below
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: userId,
                        end_at: newEndAt
                    },
                    success: function (response) {
                        Swal.fire('ສໍາເລັດ', response.message, 'success');

                        // update the "end_at" column text in the table
                        if (response.end_at_formatted) {
                            $('#end_at-' + userId).text(response.end_at_formatted);
                        }
                    },
                    error: function (xhr) {
                        let msg = 'ມີບັນຫາໃນການຕໍ່ອາຍຸ';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire('ຜິດພາດ', msg, 'error');
                    }
                });

            }
        });
    });
</script>

</x-app-layout>