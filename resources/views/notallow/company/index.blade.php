<x-app-layout>
      
<style>
  /* Dark admin styling */
  :root{
    --bg:#0b0b0f;--elev:#14141b;--text:#e6e6f0;--label:black;--accent:#7c5cff;--border:#262635;
  }
  .admin-wrap{padding:16px 0 32px}
  .admin-card{background:white;border:1px solid #c6c6c6;border-radius:16px;}
  .admin-header{
    display:flex;flex-wrap:wrap;gap:12px;align-items:center;justify-content:end;padding:16px;border-bottom:0px solid var(--border)}
  .admin-title{margin:0;font-weight:800;letter-spacing:.2px}
  .admin-actions{display:flex;gap:8px;align-items:center}
  .admin-search{display:flex;gap:8px;align-items:center}
  .admin-input{background:#0f0f16;border:1px solid var(--border);color:var(--text);border-radius:12px;padding:10px 12px;min-width:220px}
  .admin-input::placeholder{color:var(--label)}
  .admin-btn{border:1px solid var(--border);background:linear-gradient(180deg, color-mix(in oklab, var(--accent) 22%, #1a1a26), #101019);color:var(--text);
             padding:10px 14px;border-radius:12px;font-weight:700;letter-spacing:.2px}
  .admin-btn-ghost{background:transparent;border:1px solid var(--border);color:var(--label)}
  .admin-body{padding:0}

  /* Desktop table */
  .admin-table{width:100%;border-collapse:collapse}
  .admin-table th,.admin-table td{padding:12px 14px;border-bottom:1px solid var(--border);vertical-align:top}
  .admin-table th{color:black;font-weight:700;text-transform:uppercase;font-size:12px;letter-spacing:.4px}
  .admin-table td{color:black;font-size:14px}
  .admin-table .small{color:black;font-size:12px}

  /* Mobile: show cards instead of table */
  .mobile-cards{display:grid;gap:12px;padding:12px}
  .mobile-card{border:1px solid var(--border);border-radius:12px;padding:12px;background:#1a1a1a}
  .mobile-row{display:flex;justify-content:space-between;gap:12px;margin:6px 0}
  .label{color:var(--label);font-size:12px}
  .value{color:var(--text);font-size:14px}

  .admin-footer{display:flex;justify-content:space-between;align-items:center;padding:12px 16px;color:var(--label)}
  .admin-footer .pagination{margin:0}

  /* Switch layout based on width */
  @media (min-width: 768px){
    .mobile-cards{display:none}
    .admin-body{padding:8px 12px 4px}
  }
  @media (max-width: 767.98px){
    .admin-table-wrap{display:none}
  }

  /* Pagination tweak for dark */
  .pagination .page-item .page-link{background:#0f0f16;border-color:var(--border);color:var(--text)}
  .pagination .page-item.active .page-link{background:var(--accent);border-color:var(--accent)}
  .cbtn{background:#0f0f16;color:#fff;border-radius:10px;padding:8px 12px;border:1px solid var(--border);}
.cbtn-accept{border-color:#3fb950;}
.cbtn-reject{border-color:#ef4444;}
.cbtn svg{vertical-align:middle;margin-right:6px}
.cbtn:hover{filter:brightness(1.08)}

  /* === Hamburger Menu === */
.admin-menu { position: relative; }

.admin-hamburger {
  width: 38px; height: 32px;
  display: flex; flex-direction: column; justify-content: center;
  gap: 6px; background: none; border: none;
  cursor: pointer; padding: 4px; z-index: 12;
}
.admin-hamburger span {
  height: 3px; width: 100%;
  background: var(--text);
  border-radius: 2px;
  transition: all .25s ease;
}

/* Active X animation */
.admin-hamburger.active span:nth-child(1) {
  transform: translateY(9px) rotate(45deg);
}
.admin-hamburger.active span:nth-child(2) { opacity: 0; }
.admin-hamburger.active span:nth-child(3) {
  transform: translateY(-9px) rotate(-45deg);
}

/* Dropdown box */
.admin-dropdown {
  position: absolute;
  top: 42px; right: 0;
  display: none;
  flex-direction: column;
  background: var(--elev);
  border: 1px solid var(--border);
  border-radius: 10px;
  box-shadow: 0 8px 24px rgba(0,0,0,.4);
  overflow: hidden;
  min-width: 180px;
}
.admin-dropdown a {
  color: black;
  padding: 10px 14px;
  text-decoration: none;
  border-bottom: 1px solid var(--border);
  font-size: 14px;
}
.admin-dropdown a:last-child { border-bottom: none; }
.admin-dropdown a:hover { background: rgba(124,92,255,0.15); }

/* Show dropdown when open */
.admin-dropdown.show { display: flex; }

/* Desktop: always show actions inline */
@media (min-width: 992px) {
  .admin-menu { display: flex; align-items: center; gap: 10px; }
  .admin-hamburger { display: none; }
  .admin-dropdown {
    position: static;
    display: flex !important;
    flex-direction: row;
    background: transparent;
    border: none;
    box-shadow: none;
    min-width: unset;
  }
  .admin-dropdown a {
    border: none;
    background: transparent;
    padding: 8px 12px;
  }
  .admin-dropdown a:hover {
    background: rgba(255, 255, 255, 1);
  }
}
/* === Count badges inside dropdown === */
.count-badge {
  background: var(--border);
  color: var(--label);
  font-size: 11px;
  font-weight: 700;
  border-radius: 12px;
  padding: 2px 8px;
  margin-left: 6px;
}

.count-badge.success { background: rgba(63,185,80,0.25); color: #3fb950; }
.count-badge.danger  { background: rgba(239,68,68,0.25); color: #ef4444; }
.count-badge.warning { background: rgba(234,179,8,0.25); color: #eab308; }

.logout-link {
  color: #ff6666 !important;
  font-weight: 700;
}
.logout-link:hover {
  background: rgba(255,102,102,0.15);
}
/* Make the Swal truly full-screen */
.swal2-popup.swal-fullscreen{
  width: 100% !important;
  max-width: none !important;
  height: 95% !important;
  border-radius: 0 !important;
  background: #14141b;
  color: #e6e6f0;
  display: flex;
  flex-direction: column;
}
.swal2-container
{
  height: 95% !important;

}
/* Container */
.swal-full-wrapper{
  display: grid;
  grid-template-rows: auto 1fr;
  gap: 0;
}

/* Sticky header row */
.swal-header-row{
  display: grid;
  grid-template-columns: 1fr 100px 110px 110px 110px;
  gap: 10px;
  padding: 14px 16px;
  position: sticky;
  top: 0;
  background: #101019;
  border-bottom: 1px solid var(--border);
  z-index: 2;
  font-size: 12px;
  text-transform: uppercase;
  color: var(--label);
}

/* Scroll area */
.swal-scroll{
  overflow: auto;
  max-height: calc(100vh - 120px);
  padding: 6px 16px 16px;
}

/* Rows */
.swal-data-row{
  display: grid;
  grid-template-columns: 1fr 100px 110px 110px 110px;
  gap: 10px;
  padding: 12px 0;
  border-bottom: 1px solid var(--border);
  align-items: center;
}
.swal-data-row .name{ font-weight: 700; letter-spacing: .2px; }
.swal-loading, .swal-empty{ padding: 24px; text-align: center; color: var(--label); }

/* Number cells with colors */
.num{ text-align: right; font-variant-numeric: tabular-nums; }
.num.ok{ color: #3fb950; }
.num.bad{ color: #ef4444; }
.num.warn{ color: #eab308; }

/* Mobile: stack columns */
@media (max-width: 640px){
  .swal-header-row,
  .swal-data-row{
    grid-template-columns: 1fr 80px 80px;
  }
  .swal-header-row > :nth-child(4),
  .swal-header-row > :nth-child(5),
  .swal-data-row > :nth-child(4),
  .swal-data-row > :nth-child(5){
    display: none; /* hide Rejected & Pending on xs to simplify */
  }
  .swal-scroll{ max-height: calc(100vh - 160px); }
}
.btn-outline-dark
{
  color:black;
}
td
{
  padding:0px 8px 0px 8px!important;
}
.murphy-marvix
{
  border:solid white 0px;
  transition: .25s all ease;
  border-radius:8px;
}

.murphy-marvix:hover
{
  border:solid black 1px;
}
</style>
<div> 
</div> 
<body class="murphy-body">    
<main class=" admin-wrap p-1">
  <div class="admin-card">
      
    <div class="admin-header">
      <!-- <h2 class="admin-title text-white">Creators Submissions</h2> -->
       
      <div class="admin-menu position-relative"> 
        
          <div class="admin-dropdown" id="menuDropdown">
            <a href="#"   id="viewExtended" class="d-flex justift-content-between murphy-marvix">
              <div style=" margin:2px 5px 0px 0px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" class="eva eva-eye-outline eva-animation eva-icon-hover-zoom" fill="inherit"><g data-name="Layer 2"><g data-name="eye"><rect width="24" height="24" opacity="0"></rect><path d="M21.87 11.5c-.64-1.11-4.16-6.68-10.14-6.5-5.53.14-8.73 5-9.6 6.5a1 1 0 0 0 0 1c.63 1.09 4 6.5 9.89 6.5h.25c5.53-.14 8.74-5 9.6-6.5a1 1 0 0 0 0-1zM12.22 17c-4.31.1-7.12-3.59-8-5 1-1.61 3.61-4.9 7.61-5 4.29-.11 7.11 3.59 8 5-1.03 1.61-3.61 4.9-7.61 5z"></path><path d="M12 8.5a3.5 3.5 0 1 0 3.5 3.5A3.5 3.5 0 0 0 12 8.5zm0 5a1.5 1.5 0 1 1 1.5-1.5 1.5 1.5 0 0 1-1.5 1.5z"></path></g></g></svg>
              </div>
                ເບີ່ງລາຍການ 
            </a>
            <a href="{{ url('/watching/profile/filter/all') }}">
             ທັງໝົດ
             <!-- <span class="count-badge"></span> -->
            </a>
            <a href="{{ url('/watching/profile/filter/accepted') }}">
              ຍອມຮັບ 
              <!-- <span class="count-badge success"></span> -->
            </a>
            <a href="{{ url('/watching/profile/filter/rejected') }}">
              ປະຕິເສດ 
              <!-- <span class="count-badge danger"></span> -->
            </a>
            <a href="{{ url('/watching/profile/filter/pending') }}">
              ກຳລັງເຮັດວຽກ 
              <!-- <span class="count-badge warning"></span> -->
            </a>
            <button id="btn-display-list" class="btn btn-primary">
                ສະແດງລາຍການ
            </button>
          </div>
      </div>

<!-- 
      <form method="GET" class="admin-search" action="https://muanawards.com/admin/dashboard">
        <input type="hidden" name="status" value="all">
        <input type="text" class="admin-input" name="q" value="" placeholder="Search name">
        <button class="admin-btn" type="submit">Search</button>
              </form> -->
    </div>
        
    
    <div class="admin-body admin-table-wrap">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center" style="font-weight:bold;width:28%">ບໍລິສັດ</th>
                    <th class="text-center" style="font-weight:bold;width:15%">ຢູເຊີ້</th>
                    <th class="text-center" style="font-weight:bold;width:10%">ໄຟລແນບ</th>
                    <th class="text-center" style="font-weight:bold;width:10%">ວັນທີິ</th>
                    <th class="text-center" style="font-weight:bold;" colspan="3">Actions</th>
                </tr>
            </thead>
            <tbody>    
                @foreach($beta_company_profile AS $r)
                    <tr id="creator-row-{{ $r->user_id }}">
                        <td>
                            <div class="fw-bold">{{ $r->beta_company_group->com_name }}</div>                     
                            <div class="fw-bold" style="color:blue;">{{ $r->text }}</div>    
                        </td>
                        <td class="text-center"  style="padding-top:8px!important;">{{ $r->user->name ?? '' }} : {{ $r->user->email ?? '' }}</td>
                        <td class="text-center" style="padding-top:8px!important;"> 
                            @php($count=1)
                            @foreach($r->beta_company_profile_detail as $x) 
                                             <div class="d-flex align-items-center gap-2">
                                                <span>{{ $count++ }}.</span>

                                                <input
                                                    type="checkbox"
                                                    class="chkProfileDetailStatus"
                                                    data-id="{{ $x->id }}"
                                                    @if($x->status === 'YES') checked @endif
                                                >

                                                <a href="{{ asset($x->file_url) }}" target="_blank" class="ms-2">
                                                    File
                                                </a>

                                                <span class="badge ms-2 statusBadge {{ $x->status === 'YES' ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $x->status === 'YES' ? 'YES' : 'NO' }}
                                                </span>
                                             </div>
                            @endforeach  
                        </td>
                        <td class="small text-center" style="padding-top:8px!important;">
                            <span class="end-at" data-end-at="{{ $r->user_id }}">
                                {{ date('d-m-Y', strtotime($r->created_at)) }} /  {{ date('h:i:s', strtotime($r->created_at)) }}
                            </span>
                        </td>
 
                        <td style="padding-top:8px!important;width:6%;">
                            @if($r->status=='pending') 
                              <input
                                  type="date"
                                  class="extend-date form-control"
                                  data-id="{{ $r->user_id }}"
                                  value="{{ \Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}"
                                  min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                  style="padding: 0px 8px 0px 8px !important;"
                              >
                            @endif 
                        </td>

                        <td class="text-center" style="width:3%;padding-top:8px!important;">
                            @if($r->status=='pending')
                                <button type="button" class="btn-active btn btn-primary" data_com_pro_id="{{ $r->id }}" data-id="{{ $r->user_id }}" style="padding:0px 8px 0px 8px;">
                                    ຕໍ່ອາຍຸ
                                </button>
                            @endif
                        </td>
                        <td class="text-center" style="width:5%;padding-top:8px!important;">  
                            @if($r->status=='pending') 
                                <button type="button" class="btn-danger btn-reject btn btn-primary" data_com_pro_id="{{ $r->id }}" data-id="{{ $r->user_id }}" style="padding:0px 8px 0px 8px;">
                                    ປະຕິດເສດ
                                </button>
                            @endif 
                        </td>
                    </tr>   
                @endforeach
        </table> 
        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
              {{ $beta_company_profile->links('pagination.custome-pagination') }} 
            </div> 
        </div>
    </div>

    
      <div class="mobile-card mobile-cards">
        @foreach($beta_company_profile AS $r)
            <div class="mobile-card"  id="creator-card-{{ $r->user_id }}">
                <div class="mobile-row">
                    <div class="text-white" style="font-size:12px;">ບໍລິສັດ</div>
                    <div class="value fw-bold text-end">{{ $r->beta_company_group->com_name }}</div>
                </div>
                <div class="mobile-row">
                    <div class="text-white" style="font-size:12px;">ຢູເຊີ້</div>
                    <div class="value text-end">{{ $r->user->email ?? '' }}</div>
                </div>
            
            <div class="mobile-row">
                <div class="text-white" style="font-size:12px;"> ໄຟລແນບ</div>
                    <div class="value text-end">
                        @php($count=1)
                            @foreach($r->beta_company_profile_detail as $x) 
                            <div class="d-flex text-white">
                                <a href={{ asset($x->file_url) }} target="_blank">
                                    {{ $count++ }}. File
                                </a> 
                            </div> 
                            @endforeach  
                    </div>
                </div>
                <div class="mobile-row">
                    <div class="text-white" style="font-size:12px;">ສິ້ນສຸດ</div>
                    <div class="value small text-end">
                        <span class="end-at" data-end-at="{{ $r->user_id }}">
                        {{ date('d-m-Y', strtotime($r->created_at)) }} /  {{ date('h:i:s', strtotime($r->created_at)) }}
                        </span>
                    </div>
                    </div>
                    @if($r->status=='pending')  
                        <div class="mobile-row">
                        <div class="label">
                          
                            <input type="date"
                                class="extend-date form-control"
                                data-id="{{ $r->user_id }}"
                                value="{{ \Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}"
                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                style="padding: 0px !important;">
                        </div>
                        <div class="value small text-end">
                            <button type="button" class="btn-active btn btn-primary" data_com_pro_id="{{ $r->id }}" data-id="{{ $r->user_id }}">
                            ຕໍ່ອາຍຸ
                            </button>
                            <button type="button" class="btn-danger btn-reject btn btn-primary" data_com_pro_id="{{ $r->id }}" data-id="{{ $r->user_id }}">
                            ປະຕິເສດ
                            </button>
                        </div>
                        </div> 
                    @endif
            </div>
        @endforeach

        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500" style="color:white!important;">
            {{ $beta_company_profile->links('pagination.custome-pagination') }}
            </div> 
        </div>
      </div>   
  </div> 
</main>  




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  
$(document).on('click', '#viewExtended', function () {
  Swal.fire({
  title: "",
  icon: "",
  html: `
                        <table class="table table-bordered ">
                            <thead>
                                <tr> 
                                    <th class="text-center" width="3%">#</th>
                                    <th class="text-center" style="font-weight:bold;">ບໍລິສັດ</th>
                                    <th class="text-center" style="font-weight:bold;">User</th>
                                    <th class="text-center" style="font-weight:bold;">ອະນຸມັດໂດຍ</th>
                                    <th class="text-center" style="font-weight:bold;">ແຈ້ງເມື່ອ</th>
                                    <th class="text-center" style="font-weight:bold;">ໝົດອາຍຸເມື່ອ</th>
                                </tr>
                            </thead>
                            <tbody>    
                                @php($count=1)
                                @foreach($beta_extend_detail AS $r)
                                      <tr>
                                        <td class="text-center">{{ $count++ }}</td>
                                        <td><a href="/add/com/{{ $r->com_id }}/user">{{ $r->beta_company_group->com_name }}</a></td>
                                        <td>{{ $r->User->name }}</td>
                                        <td>{{ $r->Approve->name }}</td>
                                        <td class="text-center">{{ date('d-m-Y',strtotime($r->created_at)) }}</td>
                                        <td class="text-center">{{ date('d-m-Y',strtotime($r->end_at)) }}</td>
                                      </tr>
                                @endforeach
                        </table>  
  `,
  showCloseButton: true,
  showCancelButton: true,
  focusConfirm: false,
  confirmButtonText: `
     Ok
  `,
  confirmButtonAriaLabel: "Thumbs up, great!",
  cancelButtonText: `
    
  `,
  showCancelButton: false
  ,
  cancelButtonAriaLabel: "Thumbs down",
  width:1500
});
});
$(document).on('click', '.btn-active', function () {
  const $btn = $(this);
  const userId = $btn.data('id');
  const data_com_pro_id = $(this).attr('data_com_pro_id');
 
  // Find the nearest context (table row or mobile card)
  const $ctx = $btn.closest('tr, .mobile-card');

  // Find the matching date input inside this context
  const $dateInput = $ctx.find('.extend-date[data-id="' + userId + '"]').first();
  const newEndAt = $dateInput.val();

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
    if (!result.isConfirmed) return;

    $btn.prop('disabled', true);

    $.ajax({
      url: '{{ route('users.extend') }}',
      type: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        user_id: userId,
        data_com_pro_id: data_com_pro_id,
        end_at: newEndAt
      },
      success: function (response) {
        Swal.fire('ສໍາເລັດ', response.message, 'success');
        window.location.reload();

        // Update ALL matching end_at displays (desktop + mobile)
        if (response.end_at_formatted) {
          $('.end-at[data-end-at="' + userId + '"]').text(response.end_at_formatted);
        }
      },
      error: function (xhr) {
        let msg = 'ມີບັນຫາໃນການຕໍ່ອາຍຸ';
        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
        Swal.fire('ຜິດພາດ', msg, 'error');
      },
      complete: function () {
        $btn.prop('disabled', false);
      }
    });
  });
});
$(document).on('click', '.btn-reject', async function () {
  const $btn = $(this);
  const userId = $btn.data('id');
  const data_com_pro_id = $btn.attr('data_com_pro_id');

  // Ask for the reason first
  const { value: tearea } = await Swal.fire({
    input: "textarea",
    inputLabel: "ຂໍ້ຄວາມ (Reason for rejection)",
    inputPlaceholder: "ພິມເຫດຜົນການປະຕິເສດ...",
    inputAttributes: { "aria-label": "Reason for rejection" },
    showCancelButton: true,
    confirmButtonText: "ສົ່ງ",
    cancelButtonText: "ຍົກເລີກ"
  });

  if (!tearea) return; // Stop if no reason provided

  // Confirmation step
  const result = await Swal.fire({
    title: 'ທ່ານແນ່ໃຈບໍ?',
    text: "ກະລຸນາກວດສອບກ່ອນຢືນຢັນ",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'ຕົກລົງ',
    cancelButtonText: 'ຍົກເລີກ'
  });

  if (!result.isConfirmed) return;

  // Disable the button during request
  $btn.prop('disabled', true);

  $.ajax({
    url: '{{ route('users.reject') }}',
    type: 'POST',
    data: {
      _token: '{{ csrf_token() }}',
      user_id: userId,
      data_com_pro_id: data_com_pro_id,
      tearea: tearea
    },
    success: function (response) {
      Swal.fire('ສໍາເລັດ', response.message, 'success');
      // location.reload();
    },
    error: function (xhr) {
      let msg = 'ມີບັນຫາໃນການປະຕິເສດ';
      if (xhr.responseJSON && xhr.responseJSON.message)
        msg = xhr.responseJSON.message;
      Swal.fire('ຜິດພາດ', msg, 'error');
    },
    complete: function () {
      $btn.prop('disabled', false);
    }
  });
});

</script>


<script>
document.addEventListener('DOMContentLoaded', ()=>{
  const btn = document.getElementById('menuToggle');
  const menu = document.getElementById('menuDropdown');
  btn.addEventListener('click', ()=>{
    btn.classList.toggle('active');
    menu.classList.toggle('show');
  });
  // Optional: close when clicking outside
  document.addEventListener('click', e=>{
    if(!btn.contains(e.target) && !menu.contains(e.target)){
      btn.classList.remove('active');
      menu.classList.remove('show');
    }
  });
});
</script>

<script>
$(document).on('click', '#btn-display-list', function () {

    let monthOptions = '';
    for (let i = 1; i <= 12; i++) {
        monthOptions += `<option value="${i}">${i}</option>`;
    }

    let yearOptions = '';
    for (let y = 2025; y <= 2030; y++) {
        yearOptions += `<option value="${y}">${y}</option>`;
    }

    Swal.fire({
        title: ' ',
        width: 1500,
        html: `
            <div style="display:flex; gap:10px; margin-bottom:10px;">
                <select id="filter_month" class="form-control" style="width:120px;">
                    ${monthOptions}
                </select>

                <select id="filter_year" class="form-control" style="width:120px;">
                    ${yearOptions}
                </select>

                <button id="btn-load-data" class="btn btn-success">
                    ດຶງຂໍ້ມູນ
                </button>
            </div>

            <div style="margin:10px 0; font-weight:bold;">
                ຈໍານວນທັງໝົດ: <span id="total_count">0</span>
            </div>

            <div style="max-height:400px; overflow:auto;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">ລ/ດ</th>
                            <th>ບໍລິສັດ</th>
                            <th>ເຈົ້າຂອງ</th>
                            <th>ຂໍ້ຄວາມ</th>
                            <th>ວັນທີ</th>
                        </tr>
                    </thead>
                    <tbody id="result_body">
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                ຍັງບໍ່ມີຂໍ້ມູນ
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `,
        showConfirmButton: false
    });
});
</script>

<script>
$(document).on('click', '#btn-load-data', function () {

    let month = $('#filter_month').val();
    let year  = $('#filter_year').val();

    $.ajax({
        url: "{{ route('company.profile.filter') }}",
        type: "GET",
        data: {
            month: month,
            year: year
        },
        dataType: "json",
        success: function (res) {

            let tbody = $('#result_body');
            tbody.empty(); // ✅ empty table first

            $('#total_count').text(res.length);

            if (res.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            ບໍ່ພົບຂໍ້ມູນ
                        </td>
                    </tr>
                `);
                return;
            }

            let i = 1;
            $.each(res, function (index, row) {

                let comName  = row.beta_company_group ? row.beta_company_group.com_name : '-';
                let comOwner = row.beta_company_group ? row.beta_company_group.com_owner : '-';

                tbody.append(`
                    <tr>
                        <td>${i++}</td>
                        <td>${comName}</td>
                        <td>${comOwner}</td>
                        <td>${row.text ?? ''}</td>
                        <td>${formatDateTime(row.created_at)}</td>
                    </tr>
                `);
            });
        }
    });

});
</script>

<script>
function formatDateTime(dateStr) {
    const d = new Date(dateStr);

    const pad = n => n.toString().padStart(2, '0');

    const day   = pad(d.getDate());
    const month = pad(d.getMonth() + 1);
    const year  = d.getFullYear();

    const hour  = pad(d.getHours());
    const min   = pad(d.getMinutes());
    const sec   = pad(d.getSeconds());

    return `${day}-${month}-${year} / ${hour}:${min}:${sec}`;
}
</script>

<script>
$(document).on('change', '.chkProfileDetailStatus', function () {
  const $cb = $(this);
  const id = $cb.data('id');
  const status = $cb.is(':checked') ? 'YES' : 'NO';

  // tiny lock so user can't spam-click
  $cb.prop('disabled', true);

  $.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
  });

  $.ajax({
    url: "{{ route('companyProfileDetail.status') }}",
    type: "POST",
    dataType: "json",
    data: { id, status },

    success: function(res){
      // update badge next to it
      const $badge = $cb.closest('div').find('.statusBadge');
      $badge
        .text(status)
        .removeClass('bg-success bg-secondary')
        .addClass(status === 'YES' ? 'bg-success' : 'bg-secondary');
    },

    error: function(xhr){
      // revert if failed
      $cb.prop('checked', ! $cb.is(':checked'));
      alert(xhr?.responseJSON?.message || 'Update failed');
    },

    complete: function(){
      $cb.prop('disabled', false);
    }
  });
});
</script>
</x-app-layout>