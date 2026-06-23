<x-app-layout>

<style>
    .btn-danger
    {
        background:#ff4859!important;
    }
</style>
<style>
  /* ===== Murphy UI — Light, tactile, mobile-first ===== */
  :root{
    --ink:#0b1221;           /* text */
    --sub:#59657a;           /* secondary */
    --line:#e6ebf2;          /* borders */
    --card:#ffffff;          /* panels */
    --soft:#f8fbff;          /* gentle bg */
    --brand:#0a5ad1;         /* primary */
    --brand-ink:#fff;        /* on primary */
    --danger:#ff4757;
    --ok:#16a34a;
    --warn:#f59e0b;
    --shadow:0 10px 30px rgba(9,30,66,.10);
    --shadow-lg:0 18px 40px rgba(9,30,66,.16);
    --radius:4px;
    --radius-sm:4px;
    --radius-lg:4px;
  }

  /* Page scaffold polish (keeps your structure) */
  .laos .max-w-7xl{ padding-top:10px; }
  .sm\:rounded-lg{
    border-radius: var(--radius-lg)!important;
    border:1px solid var(--line);
    background: linear-gradient(180deg,#fff,#fbfdff);
    box-shadow: var(--shadow);
  }

  /* ===== Top controls row ===== */
  .grid.grid-cols-1.md\:grid-cols-2 > .p-6{
    display:grid; align-content:center;
    gap:16px;
    background:var(--card);
  }

  /* Input glam—no JS changes */
  #name{
    height:48px; border-radius:14px; border:1px solid var(--line);
    padding:12px 14px 12px 40px; width:100%;
    background:
      radial-gradient(closest-side at 16px 50%, #e9f1ff 0 60%, transparent 61%) no-repeat,
      #fff;
    background-size:28px 28px, auto;
    box-shadow: 0 1px 0 rgba(9,30,66,.03) inset;
    transition: box-shadow .15s ease, border-color .15s ease, background .15s ease;
  }
  #name:focus{ outline:0; border-color:#c9daf7; box-shadow:0 0 0 4px rgba(10,90,209,.12); }

  /* ===== Buttons ===== */
  .btn{
    border-radius: 999px;
    font-weight: 700; letter-spacing:.2px;
    padding: 10px 16px;
    transition: transform .06s ease, box-shadow .12s ease, background .12s ease, color .12s ease, border-color .12s ease;
  }
  .btn:active{ transform: translateY(1px); }

  .btn-outline-dark{
    border:1px solid var(--line);
    /* background:#fff;  */
    color:var(--ink);
    box-shadow: 0 1px 0 rgba(9,30,66,.05);
  }
  .btn-outline-dark:hover{
    background:#f3f7fe!important; border-color:#d7e4fb; color:#0b2f73!important;
  }

  #add_new{
    background: linear-gradient(180deg,#2a7bff,#0a5ad1);
    border:none; color:var(--brand-ink);
    box-shadow: 0 10px 24px rgba(10,90,209,.25);
  }
  #add_new:hover{ filter:brightness(1.03); box-shadow: 0 12px 28px rgba(10,90,209,.3); }

  .text-danger{ color:var(--danger)!important; }
  .btn-danger{ background:var(--danger)!important; border:none; color:#fff; }

  /* ===== Table → desktop table, mobile cards (no JS changes) ===== */
  .table{
    width:100%;
    background:#fff;
    border:1px solid #e9e9e9;
    border-radius: var(--radius);
    overflow:hidden;
    border-collapse: separate!important;
    border-spacing:0;
    box-shadow: var(--shadow);
  }
  .table.table-bordered thead tr th,
  .table.table-bordered tr td{ border-color:var(--line)!important; }

  .table thead tr{
    background: linear-gradient(180deg,#f7f9fe,#eff4ff);
    position: sticky; top:0; z-index:1;
  }
  .table thead td, .table thead th{
    font-weight:800!important; font-size:.92rem;
    color:#25324a; padding:12px 14px; white-space:nowrap;
  }
  .table tbody td{
    padding:12px 14px; vertical-align: middle; color:var(--ink);
  }
  .table tbody tr:nth-child(2n){ background:#fcfdff; }
  .table tbody tr:hover{ background:#f6f9ff; }

  /* Action buttons inside cells */
  .table .btn{ padding:8px 12px; border-radius:4px; }

  /* Cute icons without touching your markup */
  .edit.btn::before{
    /* content:"✏️"; */
    margin-right:8px; font-size:14px; vertical-align:-1px;
  }
  .btn_del.btn::before{
    /* content:"🗑️"; */
     margin-right:8px; font-size:14px; vertical-align:-1px;
  }

  /* ===== Modal (keep #modal & #modal-content) ===== */
  #modal{
    display:none; position:fixed; inset:0; z-index:1000;
    background: rgba(7,16,33,.45);
    backdrop-filter: blur(3px);
    padding: 24px;
  }
  #modal-content{
    width:min(740px, 96%);
    margin: min(16vh, 120px) auto 0;
    background:#fff;
    border:1px solid var(--line);
    border-radius: 18px;
    box-shadow: var(--shadow-lg);
    padding: 18px 20px;
    color:var(--ink);
    animation: murphyPop .18s ease-out;
  }
  .display_msg{ font-size:1.06rem; color:#17233a; }
  @keyframes murphyPop{
    from{ transform: translateY(6px) scale(.985); opacity:0; }
    to{ transform: translateY(0) scale(1); opacity:1; }
  }

  /* ===== Card sheen on the whole panel ===== */
  .bg-white.overflow-hidden.shadow-xl.sm\:rounded-lg{
    position: relative;
    isolation: isolate;
  }
  .bg-white.overflow-hidden.shadow-xl.sm\:rounded-lg::before{
    content:"";
    position:absolute; inset:-1px;
    background:
      radial-gradient(600px 200px at -10% -20%, rgba(10,90,209,.08), transparent 60%),
      radial-gradient(600px 200px at 110% -20%, rgba(22,163,74,.06), transparent 60%),
      radial-gradient(400px 200px at 50% 120%, rgba(245,158,11,.06), transparent 60%);
    pointer-events:none; z-index:0; border-radius: inherit;
  }

  /* ===== Mobile-first: table becomes stacked cards ===== */
  @media (max-width: 720px){
    .grid.grid-cols-1.md\:grid-cols-2{ gap:8px; }
    .p-6{ padding:14px!important; }

    .table{ display:block; border:none; box-shadow:none; background:transparent; }
    .table thead{ display:none; }
    .table tbody{ display:grid; gap:12px; }
    .table tbody tr{
      display:grid; gap:8px;
      border:1px solid var(--line);
      border-radius:14px;
      background:#fff;
      padding:12px 12px;
      box-shadow: var(--shadow);
    }
    .table tbody tr td{
      display:flex; justify-content:space-between; align-items:center;
      gap:12px; padding:8px 2px; border:none!important;
    }
    /* Labels injected with CSS—maps to your 4 columns */
    .table tbody tr td:nth-child(1)::before{ content:"No."; font-weight:800; color:#354159; }
    .table tbody tr td:nth-child(2)::before{ content:"Name"; font-weight:800; color:#354159; }
    .table tbody tr td:nth-child(3)::before{   font-weight:800; color:#354159; }
    .table tbody tr td:nth-child(4)::before{  font-weight:800; color:#354159; }

    /* Buttons fill width nicely on mobile */
    .table tbody tr td:nth-child(3) .btn,
    .table tbody tr td:nth-child(4) .btn{
      width:100%; justify-content:center;
    }
  }

  /* Respect reduced motion */
  @media (prefers-reduced-motion: reduce){
    *{ animation-duration:.01ms!important; animation-iteration-count:1!important; transition:none!important; scroll-behavior:auto!important; }
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
  .table tbody td {
    padding: 5px 14px 5px 14px;
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
</style>  

<style>
  :root{
    --ink:#0b1221; --sub:#6a768c; --line:#e6ebf2; --brand:#0a5ad1; --brand-ink:#fff;
    --shadow:0 10px 30px rgba(9,30,66,.10); --radius:14px;
  }

  .murphy-toolbar{
    background: linear-gradient(180deg,#fff,#fbfdff);
    border-radius: 16px 16px 0 0;
  }

  .murphy-label{
    display:block; font-weight:800; color:#1c2642; margin-bottom:8px; letter-spacing:.2px;
  }
  .murphy-hint{
    margin-top:8px; font-size:.88rem; color:var(--sub);
  }

  .murphy-input-wrap{
    position:relative;
  }
  .murphy-input{
    height:48px; width:100%;
    border:1px solid var(--line); border-radius: var(--radius);
    padding:10px 14px 10px 42px; background:#fff;
    box-shadow: 0 1px 0 rgba(9,30,66,.03) inset;
    transition: box-shadow .15s ease, border-color .15s ease;
  }
  .murphy-input:focus{ outline:0; border-color:#cfe0ff; box-shadow:0 0 0 4px rgba(10,90,209,.12); }

  /* Input icon (no markup change to your IDs) */
  .murphy-input-icon{
    position:absolute; inset:0 auto 0 12px; width:20px; height:20px; top:50%; transform:translateY(-50%);
    opacity:.65;
    background:
      url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="%236a768c" viewBox="0 0 24 24"><path d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>')
      center/20px 20px no-repeat;
    pointer-events:none;
  }

  /* Button: keep your classes, just polish */
  .murphy-btn{
    border-radius: 999px; font-weight:800; padding:12px 18px;
    border:1px solid var(--line); color:#0b2f73; background:#fff;
    box-shadow: 0 1px 0 rgba(9,30,66,.06);
    transition: transform .06s ease, box-shadow .12s ease, background .12s ease, color .12s ease;
  }
  .murphy-btn:hover{ background:#f3f7fe; border-color:#d7e4fb; color:#0a5ad1; }
  .murphy-btn:active{ transform: translateY(1px); }

  /* Mobile niceties */
  @media (max-width: 768px){
    .murphy-toolbar{ border-radius: 0; padding:16px; gap:10px; }
  }
</style>
 
    <div id="modal">
        <div id="modal-content">
            <p class="laob display_msg"></p> 
        </div>
    </div>
    <div class="py-1 laos">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg"> 

                <div class="murphy-toolbar bg-white/70  grid-cols-1 md:grid-cols-2 gap-3 p-1 border-b border-[var(--line)]">
                    <!-- Field -->
                    <div class="text-center" style="padding: 1% 20% 0% 20%;">
                        <div class="p-0"> 
                            <div class="murphy-input-wrap">
                                <span class="murphy-input-icon" aria-hidden="true"></span>
                                <input type="text" class="form-control murphy-input" id="name" placeholder="ປ້ອນຊື່ລາຍການປະເພດລົດ">
                            </div>
                         </div> 
                        <!-- Action -->
                        <div class="md:flex md:items-end" style="padding:15px 0px 5px 0px;">  
                            <button class="  murphy-btn w-full md:w-auto" id="add_new"> Save </button>
                        </div> 
                     </div> 
                </div>

                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-1">
                    <div class="p-6">
                        <div class=" items-center">
                            <table class="table table-bordered">
                                <tr>
                                    <td>ລ/ດ</td>
                                    <td colspan="3">ຊື່ລາຍການປະເພດລົດ</td>
                                    
                                </tr>
                                <tbody id="build">
                                    @php($count=1)
                                    @foreach ($beta_t_type as $row)
                                        <tr id="display_{{ $row->t_type_id }}" style="display:">
                                            <td width="5%" class="text-center">{{ $count }}</td>
                                            <td>
                                                <label id="display_name_{{ $row->t_type_id }}" data-name="{{ $row->t_type_name }}">{{ $row->t_type_name }}</label> 
                                            </td>
                                            <td width="5%">
                                                <button data-index="{{ $row->t_type_id }}"  class="edit  ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#666666"><g><path d="M0,0h24v24H0V0z" fill="none"/><path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41L9.25,5.35C8.66,5.59,8.12,5.92,7.63,6.29L5.24,5.33c-0.22-0.08-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.86,9.48l2.03,1.58C4.84,11.36,4.8,11.69,4.8,12s0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.08,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z M12,15.6c-1.98,0-3.6-1.62-3.6-3.6 s1.62-3.6,3.6-3.6s3.6,1.62,3.6,3.6S13.98,15.6,12,15.6z"/></g></svg>
                                                </button>
                                            </td>
                                            <td width="5%" class="" style="text-align:right!important;">
                                                <button data-index="{{ $row->t_type_id }}"  class="btn_del   text-danger" style="display: flex;justify-content: space-between;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#666666"><path d="M0 0h24v24H0z" fill="none"/><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                                </button>
                                            </td>
                                        </tr>

                                        <tr id="input_{{ $row->t_type_id }}" style="display:none;">
                                            <td width="1%">{{ $count++ }}</td>
                                            <td> 
                                                <input type="text" id="input_name_{{ $row->t_type_id }}" value="{{ $row->t_type_name }}" class="form-control" autocomplete="off">
                                            </td>
                                            <td width="5%"><button data-index="{{ $row->t_type_id }}"  class="edit_save btn btn-outline-dark" style="color:black;">Update</button></td>
                                            <td width="5%"><button data-index="{{ $row->t_type_id }}"  class="edit_cancel btn btn-outline-dark " style="color:red;">Cancel</button></td>
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
<script>
  // Enter to submit the new name
  document.getElementById('name')?.addEventListener('keypress', e=>{
    if(e.key==='Enter'){ document.getElementById('add_new')?.click(); }
  });
</script>

<script>
    var name = '';
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
                        url:"/add/wheels/update",
                        data:(data),
                        dataType:"json", 
                        success: function(response){ 
                            // console.log(response.message)  
                            // window.location.reload(); 
                            $('#display_name_'+index).attr('data-name',name_edit);
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
                    url:"/add/wheels/del",
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
                    } 
        $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type:"post",
                        url:"/add/wheels/store",
                        data:(data),
                        dataType:"json", 
                        success: function(response){ 
                            // console.log(response.message)  
                            window.location.reload(); 
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
</x-app-layout>
