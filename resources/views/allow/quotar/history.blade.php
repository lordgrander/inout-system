<x-app-layout>
    <!-- <link  rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"> -->
    <style>
         
         .table_display_data
        {  
            overflow-x: auto!important;
            /* overflow: auto!important; */
            white-space: nowrap!important; 
        }
    </style>  
    <style>  
         /* .btn
         {
             border:3px solid!important;
         } */

         .btn-light
         { 
            width:100%;
           text-align:center;
         }
         .btn-light:hover
         {
            background:#ebebeb;
         }
         .table_display_data
        {  
            overflow-x: auto!important;
            /* overflow: auto!important; */
            white-space: nowrap!important; 
            transition: all .25s ease ;
        }
        .btn-outline-dark:hover
        {
            background:#fff!important;
            color:black!important;
        }
        

        .modal {
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

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border-radius: 10px;
            border: #cccccc solid 3px;
            width: 80%; /* Could be more or less, depending on screen size */
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        }

        .modal-close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .modal-close:hover,
        .modal-close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
        
        .checkbox-columns {
            column-count: 3;
            column-gap: 20px; /* Adjust as needed */
        }
        /* .dream
        { 
            box-shadow: inset 1px 3px 5px #000!important; 
            padding:15px 5px 5px 5px;
             
            border-radius:5px;
        } */

        .btn-outline-info 
        {
            border:solid 3px #1335a1;
            color:#1335a1;
        }

        .btn-outline-info:hover
        {
             background-color:#ebebeb!important; 
             color:#3434334;
             border:solid 3px #5b78d3;
        }



        .btn-outline-danger 
        {
            border:solid 3px #b82433!important;
            color:#b82433;
        }

        .btn-outline-danger:hover
        {
             background-color:#ffd745!important; 
            color:#b82433;
        }


        .sub_stable_font
        {
            font-family: noto_serif_laoregular,roboto!important;
            font-weight: normal;
            font-size:0.90em; 
        }

        .dataTables_length select
        {
            width:100px;
        }
        table        thead        tr        th
        {
            font-weight:normal!important;
            background:#eaeaea!important;
            
        }
         
    </style>

    <style>
        .xdropdown {
        position: relative;
        display: inline-block;
        }

        .xdropdown-content {
        display: none;
        position: absolute;
        z-index: 1;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        padding: 8px 0px;
        border-radius:5px;
        }

        .xdropdown:hover .xdropdown-content {
            display: block;
        }  
        .info-jam {
        text-decoration: none;
        color: black;
        position: relative;
        }
    .info-jam:after {
        content: "";
        display: block;
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #0f42db;
        transform: scaleX(0);
        transform-origin: left;
        transition: all .25s ease;
    }
    .info-jam:hover:after {
        transform: scaleX(1);
    }
    .sub_table,.sub_table tr,.sub_table tr td
    {
        border:0px!important;
        background:white;
    }
    .dataTables_filter,.dataTables_length {
        float: right!important; 
    }
    .dataTables_length select{ 
        height:42px!important; 
        weight:120px!important; 
    }
    .white-thing
    {
       
    } 
    #table_data_display tbody tr td 
    {
        background:white!important;
    }
    .paginate_button
    {
        border:solid black 1px;
        border-radius:4px;
        padding:5px;
        cursor:pointer;
        color:black;
        margin:2px;
    }
    .dataTables_paginate
    {
        float: right!important;
    }
    .paginate_button:hover
    {
       color:#3434343;
    }
    th
    {
        text-align:center;
    }

    .object
    {
        border-radius:5px;
        background:#d0d0d0;
        margin-top:5px;
        padding:5px;
    }
    
    /* ================ Murphy Admin Light (non-breaking) ================ */
:root{
  --mur-bg:#f6f8fb;
  --mur-card:#ffffff;
  --mur-surface:#ffffff;
  --mur-border:#e5e7eb;
  --mur-text:#111827;
  --mur-muted:#6b7280;
  --mur-accent:#2563eb;   /* blue-600 */
  --mur-green:#059669;    /* emerald-600 */
  --mur-yellow:#b45309;   /* amber-700 */
  --mur-red:#dc2626;      /* red-600 */
  --mur-shadow:0 10px 24px rgba(17,24,39,.08);
}

/* Page + shell */
body{
  background:
    radial-gradient(1000px 600px at 5% -10%, #fff 0%, #eef2f7 50%, var(--mur-bg) 100%) !important;
  color:var(--mur-text);
}
.max-w-12xl .bg-white.shadow-xl.sm\:rounded-lg{
  background:var(--mur-card) !important;
  border:1px solid var(--mur-border) !important;
  border-radius:16px !important;
  box-shadow:var(--mur-shadow) !important;
}

/* Section header line */
.bg-gray-200.bg-opacity-25{background:transparent!important;border-bottom:1px solid var(--mur-border);}
.ml-4.text-lg.text-gray-600.leading-7.font-semibold{color:var(--mur-text)!important}

/* Table wrapper */
.table_display_data{padding:10px;border-radius:12px;background:transparent;}
.table{color:var(--mur-text)!important;}
.table.table-bordered{
  border-color:var(--mur-border)!important;
  border-radius:12px; overflow:hidden; background:var(--mur-card);
}
.table thead tr th{
  background:#f3f6fb!important;
  color:#334155!important;
  border-color:var(--mur-border)!important;
  position:sticky; top:0; z-index:2; letter-spacing:.2px;
}
#table_data_display tbody tr td,
.table tbody tr td{
  background:#ffffff!important;
  border-top:1px solid #f0f2f5 !important;
  vertical-align:top;
}
.table tbody tr:hover td{background:#fafbff!important;}

/* keep header centered per your code */
th{color:#334155;text-align:center;}

/* Small text inside cells */
.table td small{color:var(--mur-muted);}

/* Status labels (reuse your text-* classes) */
.table td p{margin:.25rem 0 .15rem;}
.table td p.text-primary{
  color:#1d4ed8!important;background:#e9f0ff;border:1px solid #cbd9ff;
  padding:2px 8px;border-radius:999px;display:inline-block;font-weight:700;
}
.table td p.text-success{
  color:#057a55!important;background:#e8f9f3;border:1px solid #cbeee3;
  padding:2px 8px;border-radius:999px;display:inline-block;font-weight:700;
}
.table td p.text-danger{
  color:#b91c1c!important;background:#ffecec;border:1px solid #ffd2d2;
  padding:2px 8px;border-radius:999px;display:inline-block;font-weight:700;
}

/* The “object” rows (items list) */
.object{
  border-radius:12px;
  background:#ffffff;
  border:1px solid var(--mur-border);
  padding:10px 12px; margin-top:8px; color:var(--mur-text);
  display:grid; grid-template-columns:2fr .6fr .9fr 1.1fr 1.2fr auto; gap:12px; align-items:center;
  box-shadow:0 1px 0 rgba(17,24,39,.04);
}
.object > div{white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
@media (max-width:900px){ .object{grid-template-columns:1fr 1fr; gap:8px;} }

/* File icon hover */
.table a svg{transition:transform .12s ease, filter .12s ease}
.table a:hover svg{transform:translateY(-1px);filter:drop-shadow(0 6px 12px rgba(37,99,235,.25))}

/* Buttons (keep your classes) */
.btn{
  border-radius:12px!important;font-weight:700!important;
  transition:transform .08s, filter .12s, box-shadow .15s!important;
}
.btn:active{transform:translateY(1px);}
.btn-light{
  background:#f8fafc!important; color:#0f172a!important; border:1px solid var(--mur-border)!important;
  box-shadow:inset 0 0 0 1px rgba(255,255,255,.6);
}
.btn-light:hover{background:#eef2f7!important;border-color:#d7dbe3!important;}

.btn-outline-info{
  border:2px solid var(--mur-accent)!important; color:#1e40af!important; background:transparent!important;
}
.btn-outline-info:hover{background:#eaf1ff!important;border-color:#94b7ff!important;color:#1d4ed8!important;}

.btn-outline-danger{
  border:2px solid var(--mur-red)!important; color:#9f1239!important; background:transparent!important;
}
.btn-outline-danger:hover{background:#fff1f2!important;border-color:#fca5a5!important;color:#b91c1c!important;}

/* Dropdown you already use (.xdropdown) */
.xdropdown-content{
  background:#ffffff!important; border:1px solid var(--mur-border)!important; border-radius:12px!important;
  box-shadow:var(--mur-shadow)!important; padding:10px!important;
}
.xdropdown-content a{
  color:var(--mur-text)!important; display:block; padding:6px 10px; border-radius:8px;
}
.xdropdown-content a:hover{background:#f3f6fb;}

/* DataTables controls (if used later) */
.dataTables_filter input, .dataTables_length select{
  background:#ffffff!important; border:1px solid var(--mur-border)!important; color:var(--mur-text)!important; border-radius:10px!important;
}
.paginate_button{
  background:#ffffff!important; border:1px solid var(--mur-border)!important; color:var(--mur-text)!important; border-radius:8px!important;
}
.paginate_button:hover{filter:brightness(1.03);}

/* Pagination wrapper */
.item-pagination .pagination{gap:6px;}
.item-pagination .pagination > li > a,
.item-pagination .pagination > li > span{
  background:#ffffff; border:1px solid var(--mur-border); color:var(--mur-text)!important; border-radius:8px; padding:6px 12px;
}
.item-pagination .pagination > .active > span{
  background:#eaf1ff; border-color:#b9ccff; color:#1d4ed8!important;
}

/* Modals (uses your .modal / .modal-content) */
.modal{background:rgba(15,23,42,.25)!important;backdrop-filter:blur(1px);}
.modal-content{
  background:#ffffff!important; color:var(--mur-text)!important;
  border:1px solid var(--mur-border)!important; border-radius:14px!important; box-shadow:var(--mur-shadow)!important;
}

/* Little details */
.info-jam{color:#0f172a!important;}
.info-jam:after{background-color:var(--mur-accent)!important;}
.sub_stable_font{color:#111827!important;}
/* === Responsive switch === */
.mur-desktop { display: none; }
.mur-mobile  { display: grid; gap: 12px; }

/* >= 900px: show table, hide cards */
@media (min-width: 900px) {
  .mur-desktop { display: block; }
  .mur-mobile  { display: none; }
}

/* === Card UI === */
.mur-card {
  background: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 14px;
  box-shadow: 0 8px 20px rgba(17,24,39,.06);
  padding: 12px;
}

.mur-card__row { display: grid; grid-template-columns: 1fr; gap: 8px; }
.mur-pair { display: flex; justify-content: space-between; gap: 10px; }
.mur-label { color: #6b7280; font-size: .9rem; }
.mur-value { color: #111827; font-weight: 600; text-align: right; }

.mur-status {
  display: inline-block; padding: 4px 10px; border-radius: 999px; font-weight: 700; font-size: .8rem;
  border: 1px solid;
}
.mur-status--primary { color:#1d4ed8; background:#eaf1ff; border-color:#cbd9ff; }
.mur-status--success { color:#057a55; background:#e8f9f3; border-color:#cbeee3; }
.mur-status--danger  { color:#b91c1c; background:#ffecec; border-color:#ffd2d2; }

.mur-items { display: grid; gap: 8px; margin-top: 6px; }
.mur-item {
  display: grid; gap: 8px;
  grid-template-columns: 2fr .6fr .9fr 1.2fr 1.2fr;
  padding: 8px 10px; border: 1px solid #e5e7eb; border-radius: 10px; background: #fff;
}
.mur-item > div { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
@media (max-width: 520px) { .mur-item { grid-template-columns: 1fr 1fr; } }

.mur-files { display: flex; flex-wrap: wrap; gap: 8px; }
.mur-file {
  display: inline-flex; align-items: center; gap: 6px; padding: 6px 10px; border: 1px solid #e5e7eb; border-radius: 999px;
  background: #fff; color: #1f2937; text-decoration: none;
}
.mur-note { color: #1d4ed8; margin: 6px 0 0; word-break: break-word; }
.mur-danger { color: #b91c1c; }

    </style>
   
    
    <div class="py-1 laos">
        <div class="max-w-12xl mx-auto sm:px-12 lg:px-12 ">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg ">
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-1 ">
                   
                    <div class="p-1">
                        <div class="dream  items-center"> 
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"> 
                                <div class="table_display_data"> 
                                     
                                    <table style="display:none;">
                                        <tr>
                                            <td> 
                                                <input type="text" id="timer" value="20" class="form-control" style="width:50px!important">
                                            </td>

                                            <td> 
                                                <input type="checkbox" id="autoReloadCheckbox" >
                                                <label for="autoReloadCheckbox">No-Reload</label></td>
                                            <td>
                                        </tr>
                                    </table>  
               
                            <div class="">
                                <table class="table table-bordered display " id=""   style="width:100%">
                                    <thead>
                                        <tr>
                                            <!-- <th width="5%">ເລກທີ</th> -->
                                            <th width="15%">ບໍລິສັດ</th> 
                                            <th width="8%">ອອກເມື່ອ</th> 
                                            <th>ລາຍການ</th>   
                                            <th width="8%">ເອກະສານແນບ</th> 
                                            <th width="8%">ໝາຍເຫດ</th> 
                                        </tr>
                                    </thead>
                                    <tbody class="sub_stable_font">
                                        @foreach ($beta_a_enter_quotar as $w)
                                            <tr>
                                                <!-- <td></td> -->
                                                <td>{{ $w->QHaveCom->com_name }}
                                                    <br><small>ອອກໂດຍ : {{ $w->user_id }}</small>
                                                    <p class="
                                                        @if($w->status=='CANCEL')
                                                            text-danger
                                                        @elseif($w->status=='SUCCES')
                                                            text-success
                                                        @else
                                                            text-primary
                                                        @endif
                                                    ">{{ $w->status }}</p>
                                                </td>
                                                <td >{{ date('d-m-Y',strtotime($w->created_at)) }}</td>
                                                <td>
                                                    @foreach ($w->QhaveD as $wq) 
                                                        <div class="d-flex justify-content-between object" >
                                                                <div>{{ $wq->name }}</div>
                                                                <div>{{ $wq->qty }}</div>
                                                                <div class="d-flex justify-content-start">
                                                                     {{ number_format($wq->weight) }} 
                                                                </div>
                                                                <div>{{ number_format($wq->total_price) }} {{ $wq->cur }}</div> 
                                                                <div  class="display_pro_type_{{ $wq->id }}" style="font-weight:bold;">
                                                                @if ($wq->pro_id)
                                                                    {{ $wq->dHaveP->name }} 
                                                                @endif
                                                                </div>
                                                                <div> 
                                                                </div>
                                                        </div>
                                                    @endforeach 
                                                </td> 
                                                <td>
                                                    @foreach ($w->QhaveF as $wf)
                                                    <div><a href="{{ asset( $wf->file_url ) }}" target="_BLANK">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" style="fill:blue;"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 480H448c35.3 0 64-28.7 64-64V160c0-35.3-28.7-64-64-64H288c-10.1 0-19.6-4.7-25.6-12.8L243.2 57.6C231.1 41.5 212.1 32 192 32H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64z"/></svg>
                                                    </a></div> 
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <p class="text-primary">
                                                        {{ $w->note }}
                                                    </p>
                                                    @if($w->status=="CANCEL")
                                                        ສາເຫດທີ່ຍົກເລີກ : <label class="text-danger">"{{ $w->cancel_log }}"</label>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="mur-mobile">
                                    @foreach ($beta_a_enter_quotar as $w)
                                        <article class="mur-card">
                                        <div class="mur-card__row">
                                            <div class="mur-pair">
                                            <span class="mur-label">ບໍລິສັດ</span>
                                            <span class="mur-value">{{ $w->QHaveCom->com_name }}</span>
                                            </div>
                                            <div class="mur-pair">
                                            <span class="mur-label">ອອກໂດຍ</span>
                                            <span class="mur-value">{{ $w->user_id }}</span>
                                            </div>
                                            <div class="mur-pair">
                                            <span class="mur-label">ວັນທີ</span>
                                            <span class="mur-value">{{ date('d-m-Y',strtotime($w->created_at)) }}</span>
                                            </div>
                                            <div>
                                            @php
                                                $statusClass = 'mur-status--primary';
                                                if($w->status==='CANCEL')  $statusClass='mur-status--danger';
                                                elseif($w->status==='SUCCES') $statusClass='mur-status--success';
                                            @endphp
                                            <span class="mur-status {{ $statusClass }}">{{ $w->status }}</span>
                                            </div>
                                        </div>

                                        {{-- Items --}}
                                        @if($w->QhaveD && count($w->QhaveD))
                                            <div class="mur-items">
                                            @foreach ($w->QhaveD as $wq)
                                                <div class="mur-item">
                                                <div>{{ $wq->name }}</div>
                                                <div>{{ $wq->qty }}</div>
                                                <div>{{ number_format($wq->weight) }}</div>
                                                <div>{{ number_format($wq->total_price) }} {{ $wq->cur }}</div>
                                                <div class="display_pro_type_{{ $wq->id }}" style="font-weight:700;">
                                                    @if ($wq->pro_id) {{ $wq->dHaveP->name }} @endif
                                                </div>
                                                </div>
                                            @endforeach
                                            </div>
                                        @endif

                                        {{-- Files --}}
                                        @if($w->QhaveF && count($w->QhaveF))
                                            <div class="mur-files" style="margin-top:10px;">
                                            @foreach ($w->QhaveF as $wf)
                                                <a class="mur-file" href="{{ asset($wf->file_url) }}" target="_blank" rel="noopener">
                                                {{-- tiny icon --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512 512" style="fill:#2563eb">
                                                    <path d="M64 480H448c35.3 0 64-28.7 64-64V160c0-35.3-28.7-64-64-64H288c-10.1 0-19.6-4.7-25.6-12.8L243.2 57.6C231.1 41.5 212.1 32 192 32H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64z"/>
                                                </svg>
                                                <span>File</span>
                                                </a>
                                            @endforeach
                                            </div>
                                        @endif

                                        {{-- Note --}}
                                        @if($w->note)
                                            <p class="mur-note">{{ $w->note }}</p>
                                        @endif

                                        {{-- Cancel reason --}}
                                        @if($w->status=="CANCEL" && $w->cancel_log)
                                            <div class="mur-danger" style="margin-top:6px;">
                                            ຍົກເລີກ: “{{ $w->cancel_log }}”
                                            </div>
                                        @endif
                                        </article>
                                    @endforeach

                                    <div class="item-pagination d-flex justify-content-center mt-4">
                                        {{ $beta_a_enter_quotar->links('pagination.custome-pagination') }}
                                    </div>
                                    </div>

                                </div>
                                <br>
                                <br>
                                    <div class="item-pagination d-flex justify-content-center mt-5">
                                        {{ $beta_a_enter_quotar->links('pagination.custome-pagination') }}
                                    </div>
                                </div>
                            </div>
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
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script> 
 
</x-app-layout>
