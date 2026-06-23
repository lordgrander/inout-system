<x-app-layout>

<style>
    .btn-danger
    {
        background:#ff4859!important;
    }
</style>

<style>
  /* Dark admin styling */
  :root{
    --bg:#0b0b0f;--elev:#14141b;--text:#e6e6f0;--label:black;--accent:#7c5cff;--border:#262635;
  }
  .admin-wrap{padding:8px 0 16}
  .admin-card{background:white;border:0px solid var(--border);border-radius:16px;}
  .admin-header{
    display:flex;flex-wrap:wrap;gap:12px;align-items:center;justify-content:end;padding:16px;border-bottom:1px solid var(--border)}
  .admin-title{margin:0;font-weight:800;letter-spacing:.2px}
  .admin-actions{display:flex;gap:8px;align-items:center}
  .admin-search{display:flex;gap:8px;align-items:center}
  .admin-input{background:#0f0f16;border:1px solid var(--border);color:var(--text);border-radius:12px;padding:10px 12px;min-width:220px}
  .admin-input::placeholder{color:var(--label)}
  .admin-btn{border:1px solid var(--border);background:linear-gradient(180deg, color-mix(in oklab, var(--accent) 22%, #1a1a26), #101019);color:var(--text);
             padding:10px 14px;border-radius:12px;font-weight:700;letter-spacing:.2px}
  .admin-btn-ghost{background:transparent;border:1px solid var(--border);color:var(--label)}
  .admin-body{padding:0}

 
  /* Mobile: show cards instead of table */
  .mobile-cards{display:grid;gap:12px;padding:12px}
  .mobile-card{border:1px solid var(--border);border-radius:12px;padding:12px;background:#101019}
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
</style>
<style>
  #modal {
    display: none; /* Hide the modal by default */
    position: fixed; /* Make the modal stay in the same spot */
    z-index: 1; /* Place the modal on top of everything else */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  }

  #modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border-radius: 10px;
    border: #f46767 solid 3px;
    width: 80%; /* Could be more or less, depending on screen size */
  }

  #modal-close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  #modal-close:hover,
  #modal-close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
  }
  p
  {
    padding:0px!important;
    margin:4px!important;
  }
  
</style>

<style>
    a{
        text-decoration:none;
        color:black;
    }
    .btn-outline-dark:hover
    {
        background:#e9eaeb;
        color:black;
    }

    td{
        padding:0px 8px 0px 8px!important;
    }
</style>   
 
    <div id="modal">
        <div id="modal-content">
            <p class="laob display_msg"></p> 
        </div>
    </div>
    <div class="py-1 laos">

        <div class=" "> 
            <main class="murphy-container admin-wrap ">
                <div class="admin-card"> 
                    <div class="p-2">
                        <div>
                            <h5 style="padding-top:5px;"><p class="laob"><b>&nbsp;&nbsp;Profile ບໍລິສັດ</b></p></h5>

                           <button id="AddCompanyProfile"
                                    class="btn btn-dark"
                                    data-com-id="{{ $com_id }}"
                                    style="padding:3px 8px;margin-bottom:10px;">
                            Add
                            </button>
 
                        </div>
                        
                        <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th class="text-center" style="font-weight:bold;width:28%">ບໍລິສັດ</th>
                                    <th class="text-center" style="font-weight:bold;">ຢູເຊີ້</th>
                                    <th class="text-center" style="font-weight:bold;width:10%">ໄຟລແນບ</th>
                                    <th class="text-center" style="font-weight:bold; ">ວັນທີິ</th> 
                                </tr>
                            </thead>
                            <tbody>    
                                @foreach($beta_company_profile AS $r)
                                    <tr id="creator-row-{{ $r->user_id }}">
                                        <td>
                                            <div class="fw-bold">{{ $r->beta_company_group->com_name }}</div>   
                                        </td> 
                                        <td>{{ $r->user->name }} : {{ $r->user->email }}</td>
                                        <td>
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
                                        <td class="small">
                                            <span class="end-at" data-end-at="{{ $r->user_id }}">
                                                {{ date('d-m-Y', strtotime($r->created_at)) }} /  {{ date('h:i:s', strtotime($r->created_at)) }}
                                            </span>
                                        </td>
    
                                    </tr>   
                                    <tr>
                                        <td colspan="4">
                                            <div class="fw-bold">{{ $r->text }}</div> 
                                        </td>
                                    </tr>
                                @endforeach
                        </table>  
                    </div> 
                </div> 
            </main>  
        </div>
        <br>
        <div class=" "> 
            <main class="murphy-container admin-wrap ">
                <div class="admin-card"> 
                    <div class="p-2">
                        <h5 style="padding-top:5px;">
                            <p class="laob"><b>&nbsp;&nbsp;ປະຫວັດການອະນຸມັດລາຍການ</b></p></h5>
                        <table class="table table-bordered ">
                            <thead>
                                <tr> 
                                    <th class="text-center" width="3%">#</th>
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
                                        <td>{{ $r->User->name }}</td>
                                        <td>{{ $r->Approve->name }}</td>
                                        <td class="text-center">{{ date('d-m-Y',strtotime($r->created_at)) }}</td>
                                        <td class="text-center">{{ date('d-m-Y',strtotime($r->end_at)) }}</td>
                                      </tr>
                                @endforeach
                        </table>  
                    </div> 
                </div> 
            </main>  
        </div>
    <br>
        <div class="murphy-container admin-wrap">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg"> 
                <div class="bg-white bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                    <div class="p-2">  
                        <h5 style="padding-top:5px;">
                        <p class="laob"><b>&nbsp;&nbsp;ເພີ່ມລາຍການຜູ້ໃຊ້ງານ</b></p></h5>
                        <div class="d-flex justify-content-between items-center" style="gap:10px;"> 
                            <input type="text" class="form-control" id="name" placeholder="ຊື່ພະນັກງານ" style="padding:4px 0px 4px 8px;"> <br>
                            <input type="text" class="form-control" id="email" placeholder="ເບີໂທ" style="padding:4px 0px 4px 8px;"> 
                            <div class="flex items-center">
                                <button class="btn btn-dark" id="add_new" style="padding:3px 8px 3px 8px;">Save</button>
                            </div>
                        </div> 
                    </div> 
                </div>
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-1">
                    <div class="p-2">
                        <div class=" items-center">
                            <table class="table  table-bordered table-strip table-hover">
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">ຊື່ຜູ້ໃຊ້</th>
                                    <th class="text-center">ເບີໂທ</th>
                                    <th class="text-center">ແກ້ໄຂ</th>
                                    <th class="text-center">ລຶບ</th>
                                </tr>
                                <tbody id="build">
                                    @php($count=1)
                                    @foreach ($beta_users as $row)
                                        <tr id="display_{{ $row->id }}" style="display:">
                                            <td width="3%" class="text-center">{{ $count }}</td>
                                            <td>
                                                <p id="display_name_{{ $row->id }}" data-name="{{ $row->name }}">{{ $row->name }}</p> 
                                            </td>
                                            <td>
                                                <p id="display_owner_name_{{ $row->id }}" data-name="{{ $row->email }}">{{ $row->email }}</p> 
                                            </td>
                                            <td width="5%" class="text-center"><button data-index="{{ $row->id }}"  class="edit btn "  style="padding:0px 0px 0px 0px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="eva eva-settings-outline" fill="blue"><g data-name="Layer 2"><g data-name="settings"><rect width="24" height="24" opacity="0"></rect><path d="M8.61 22a2.25 2.25 0 0 1-1.35-.46L5.19 20a2.37 2.37 0 0 1-.49-3.22 2.06 2.06 0 0 0 .23-1.86l-.06-.16a1.83 1.83 0 0 0-1.12-1.22h-.16a2.34 2.34 0 0 1-1.48-2.94L2.93 8a2.18 2.18 0 0 1 1.12-1.41 2.14 2.14 0 0 1 1.68-.12 1.93 1.93 0 0 0 1.78-.29l.13-.1a1.94 1.94 0 0 0 .73-1.51v-.24A2.32 2.32 0 0 1 10.66 2h2.55a2.26 2.26 0 0 1 1.6.67 2.37 2.37 0 0 1 .68 1.68v.28a1.76 1.76 0 0 0 .69 1.43l.11.08a1.74 1.74 0 0 0 1.59.26l.34-.11A2.26 2.26 0 0 1 21.1 7.8l.79 2.52a2.36 2.36 0 0 1-1.46 2.93l-.2.07A1.89 1.89 0 0 0 19 14.6a2 2 0 0 0 .25 1.65l.26.38a2.38 2.38 0 0 1-.5 3.23L17 21.41a2.24 2.24 0 0 1-3.22-.53l-.12-.17a1.75 1.75 0 0 0-1.5-.78 1.8 1.8 0 0 0-1.43.77l-.23.33A2.25 2.25 0 0 1 9 22a2 2 0 0 1-.39 0zM4.4 11.62a3.83 3.83 0 0 1 2.38 2.5v.12a4 4 0 0 1-.46 3.62.38.38 0 0 0 0 .51L8.47 20a.25.25 0 0 0 .37-.07l.23-.33a3.77 3.77 0 0 1 6.2 0l.12.18a.3.3 0 0 0 .18.12.25.25 0 0 0 .19-.05l2.06-1.56a.36.36 0 0 0 .07-.49l-.26-.38A4 4 0 0 1 17.1 14a3.92 3.92 0 0 1 2.49-2.61l.2-.07a.34.34 0 0 0 .19-.44l-.78-2.49a.35.35 0 0 0-.2-.19.21.21 0 0 0-.19 0l-.34.11a3.74 3.74 0 0 1-3.43-.57L15 7.65a3.76 3.76 0 0 1-1.49-3v-.31a.37.37 0 0 0-.1-.26.31.31 0 0 0-.21-.08h-2.54a.31.31 0 0 0-.29.33v.25a3.9 3.9 0 0 1-1.52 3.09l-.13.1a3.91 3.91 0 0 1-3.63.59.22.22 0 0 0-.14 0 .28.28 0 0 0-.12.15L4 11.12a.36.36 0 0 0 .22.45z" data-name="&lt;Group&gt;"></path><path d="M12 15.5a3.5 3.5 0 1 1 3.5-3.5 3.5 3.5 0 0 1-3.5 3.5zm0-5a1.5 1.5 0 1 0 1.5 1.5 1.5 1.5 0 0 0-1.5-1.5z"></path></g></g></svg>
                                            </button></td>
                                            <td width="5%" class="text-center"><button data-index="{{ $row->id }}"  class="btn_del btn  text-danger" style="padding:0px 0px 0px 0px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="eva eva-close-circle-outline" fill="red"><g data-name="Layer 2"><g data-name="close-circle"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M14.71 9.29a1 1 0 0 0-1.42 0L12 10.59l-1.29-1.3a1 1 0 0 0-1.42 1.42l1.3 1.29-1.3 1.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l1.29-1.3 1.29 1.3a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42L13.41 12l1.3-1.29a1 1 0 0 0 0-1.42z"></path></g></g></svg>
                                            </button></td>
                                        </tr>

                                        <tr id="input_{{ $row->id }}" style="display:none;">
                                            <td width="1%">{{ $count++ }}</td>
                                            <td> 
                                                <input type="text" id="input_name_{{ $row->id }}" value="{{ $row->name }}" class="form-control" autocomplete="off">
                                            </td> 
                                            <td> 
                                                <input type="text" id="input_owner_name_{{ $row->id }}" value="{{ $row->email }}" class="form-control" autocomplete="off">
                                            </td>
                                            <td width="5%"><button data-index="{{ $row->id }}"  class="edit_save btn btn-outline-dark" style="color:lime;">Update</button></td>
                                            <td width="5%"><button data-index="{{ $row->id }}"  class="edit_cancel btn btn-outline-dark " style="color:red;">Cancel</button></td>
                                        </tr>
                                    @endforeach 
                                </tbody>
                            </table>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div> 
                        </div>
                    </div>  
                </div>

 
 
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var name = '';
    var owner_name = '';
    $('#build').on('click','.edit', function (e) {

        let index = $(this).attr("data-index"); 

        $("#display_"+index).css("display", "none");
        $("#input_"+index).css("display", "");
  
        $('#input_name_'+ index).focus().select();
 
    });


    $('#build').on('click','.edit_cancel', function (e) {
        let index = $(this).attr("data-index"); 
        let name = $('#display_name_'+index).attr('data-name'); 

        $('#display_name_'+index).html(name);   

        $('#input_name_'+index).val(name);  
        
        $("#input_"+index).css("display", "none");
        $("#display_"+index).css("display", "");
 

    });


    $('#build').on('click','.edit_save', function (e) {
    
        let index = $(this).attr("data-index"); 
        let name  = $('#display_name_'+index).attr('data-name');         



        let name_edit = $('#input_name_'+index).val();  

        $('#display_name_'+index).html(name_edit);   

        $("#input_"+index).css("display", "none");
        $("#display_"+index).css("display", "");

        let msg = 'Update succesfully !';

        e.preventDefault();   
        var data = {
                        "id" : index, 
                        "name_edit" : name_edit, 
                        "name_old" : name,
                    }

 
        $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type:"post",
                        url:"/add/comUser/{{ $com_id }}/update",
                        data:(data),
                        dataType:"json", 
                        success: function(response){ 
                            // console.log(response.message)  
                            // window.location.reload(); 
                           

                            if(response.message=='Already_exist')
                            {
                                let msg = 'Email ຜູ້ໃຊ້ ມີຢູ່ແລ້ວ';
                                showAlert(msg)  
                            }
                            else
                            {
                                $('#display_name_'+index).attr('data-name',name_edit);

                            }
                        },
                        complete: function() {
                            // me.data('requestRunning', false);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            if(errorThrown=='Payload Too Large')
                            { 
                                // let dumx = "ຂະໜາດ File ລວມ ມີຂະໜາດເກີນ 1.5Mb"; 
                                return false;
                            }
                        }
                    })
    })




    $('#build').on('click','.btn_del', function (e) {
    
        var result = confirm("Do you want to proceed?");
    if (result != true) {
        return false
    }
    let index = $(this).attr("data-index");  
    e.preventDefault();   
    var data = {
                    "id" : index, 
                }


    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type:"post",
                    url:"/add/comUser/{{ $com_id }}/del",
                    data:(data),
                    dataType:"json", 
                    success: function(response){ 
                        // console.log(response.message)  
                        window.location.reload(); 
                      
                    },
                    complete: function() {
                        // me.data('requestRunning', false);
                        window.location.reload(); 
                         
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if(errorThrown=='Payload Too Large')
                        { 
                            // let dumx = "ຂະໜາດ File ລວມ ມີຂະໜາດເກີນ 1.5Mb"; 
                            return false;
                        }
                    }
                })
})

    $('#add_new').on('click', function (e) {     
        $('#add_new').prop('disabled', true); 
        
        e.preventDefault();   
        var data = {
                        "name" : $('#name').val(),  
                        "owner_name" : $('#email').val(),  
                    } 
        $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type:"post",
                        url:"/add/comUser/{{ $com_id }}/store",
                        data:(data),
                        dataType:"json", 
                        success: function(response){ 
                            // console.log(response.message)  
                            if(response.message=='Already_exist')
                            {
                                let msg = 'Email ຜູ້ໃຊ້ ມີຢູ່ແລ້ວ';
                                showAlert(msg)
                                $('#add_new').prop('disabled', false); 

                            }
                            else
                            {
                             window.location.reload(); 

                            }
                           
                        },
                        complete: function(response) {
                            // me.data('requestRunning', false);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            if(errorThrown=='Payload Too Large')
                            { 
                                let dumx = "ຂະໜາດ File ລວມ ມີຂະໜາດເກີນ 1.5Mb"; 
                                alert(dumx)
                                return false;
                            }
                            else
                            {
                                
                            }
                        }
                    })
    })

   

    function validateSQL(str) {
        // remove potentially harmful characters using a regular expression
        str = str.replace(/[^a-zA-Z0-9ก-๙ກ-໛\s]/gi, '');
        // return the sanitized string
        return str;
    }

    function showAlert(msg) {
        // Create the link
        var link = document.createElement("a");
        link.href = "https://www.example.com";
        link.innerHTML = "Click here to visit example.com";

        // Add the link to the alert message
        var message = "Please click on the link: " + link.outerHTML;
        $('.display_msg').html(msg);
        $("#modal").css("display", "block");
    }


    $(document).ready(function() {
        // When the modal button is clicked 
        // When the user clicks anywhere outside of the modal, close it
        $(window).click(function(event) {
        if (event.target == $("#modal")[0]) {
            $("#modal").css("display", "none");
        }
        }); 
        // When the close button is clicked
        $("#modal-close").click(function() {
        // Hide the modal
        $("#modal").css("display", "none");
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


<script>
$(document).on('click', '#AddCompanyProfile', function(){

  const comId = $(this).data('com-id');

  const html = `
    <section class="murphy_scope py-2 laos" style="text-align:left">
      <div class="murphy_field mb-2">
        <label class="murphy_label" style="font-weight:800;">ລາຍລະອຽດ</label>
        <input type="text" class="form-control" id="cp_lasttails"
          placeholder="ພິມລາຍລະອຽດ/ຂໍ້ມູນທີ່ຈະແຈ້ງ…">
      </div>

      <div class="murphy_field">
        <label class="murphy_label" style="font-weight:800;">ແນບເອກະສານຢັ້ງຢືນ</label>
        <small style="display:block;color:#64748b;margin-bottom:6px;">
          (PDF, JPG, PNG) — ເລືອກຫຼາຍໄດ້
        </small>
        <input type="file" class="form-control" id="cp_upload_files" multiple accept=".pdf,.jpg,.jpeg,.png">
      </div>
    </section>
  `;

  Swal.fire({
    title: 'Profile ບໍລິສັດ',
    html,
    width: 720,
    showCancelButton: true,
    confirmButtonText: 'ບັນທຶກ',
    cancelButtonText: 'ຍົກເລີກ',
    focusConfirm: false,
    preConfirm: () => {
      const lasttails = ($('#cp_lasttails').val() || '').trim();
      const filesEl = document.getElementById('cp_upload_files');
      const files = filesEl && filesEl.files ? filesEl.files : null;

      // you said: not required -> so no hard validation needed
      // but if you want at least one of them:
      // if(!lasttails && (!files || files.length === 0)) {
      //   Swal.showValidationMessage('ກະລຸນາພິມຂໍ້ຄວາມ ຫຼື ແນບເອກະສານ');
      //   return false;
      // }

      return { lasttails };
    }
  }).then((result) => {
    if(!result.isConfirmed) return;

    const fd = new FormData();
    fd.append('com_id', comId);
    fd.append('lasttails', (result.value?.lasttails || ''));

    const filesEl = document.getElementById('cp_upload_files');
    if(filesEl && filesEl.files && filesEl.files.length){
      for(let i=0; i<filesEl.files.length; i++){
        fd.append('upload_files[]', filesEl.files[i]);
      }
    }

    $.ajaxSetup({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $.ajax({
      url: "{{ route('company_profile.store') }}",
      type: "POST",
      data: fd,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function(res){
        if(res.status === 200){
          Swal.fire({
            icon: 'success',
            title: 'ສຳເລັດ',
            text: 'ບັນທຶກແລ້ວ ✅'
          }).then(() => {
            // simplest
            location.reload();
          });
        }else{
          Swal.fire({ icon:'error', title:'ຜິດພາດ', text: (res.message || 'error') });
        }
      },
      error: function(xhr){
        let msg = 'ມີບັນຫາໃນການບັນທຶກ';
        if(xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;

        // show first validation error if exists
        if(xhr.responseJSON && xhr.responseJSON.errors){
          const firstKey = Object.keys(xhr.responseJSON.errors)[0];
          if(firstKey) msg = xhr.responseJSON.errors[firstKey][0];
        }

        Swal.fire({ icon:'error', title:'ຜິດພາດ', text: msg });
      }
    });
  });

});
</script>
</x-app-layout>
