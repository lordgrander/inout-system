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
    .murphy-break-text{
        word-break: break-word;       /* normal breaking */
        overflow-wrap: anywhere;      /* force break long strings */
        white-space: normal;          /* allow wrapping */
        line-height: 1.45;
        }

        .murphy-break-all{
        word-break: break-all;        /* aggressive break (use carefully) */
        overflow-wrap: anywhere;
        white-space: normal;
        }

        .murphy-break-clamp-2{
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        word-break: break-word;
        }

        
    </style>
<style>
  .murphy-swal-popup{
    padding: 10px !important;
    border-radius: 16px !important;
  }

  .murphy-swal-title{
    cursor: move; /* draggable handle */
    user-select: none;
    font-weight: 700;
  }

  .murphy-preview-shell{
    width: 100%;
    height: 70vh;              /* base height */
    max-height: 80vh;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,.12);
    background: #fff;
  }

  .murphy-preview-iframe{
    width: 100%;
    height: 100%;
    border: 0;
  }

  .murphy-preview-img{
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
    background: #0b0b0b;
  }

  /* Make jQuery UI resize handle visible */
  .murphy-resizable .ui-resizable-se{
    width: 18px; height: 18px;
    right: 6px; bottom: 6px;
    opacity: .6;
  }
  .murphy-swal-popup
  {
    padding:0px!important;
  }
div:where(.swal2-container) div:where(.swal2-html-container) 
{
    padding:0px!important;
    
}

.swal2-modal
{
        width: 100vw!important
        height: 115%!important;
}

</style>

    <div id="modal" class="modal">
        <div class="modal-content">
            <p class="laob display_msg"></p>
        <!-- <button id="modal-close">Close</button> -->
        </div>
    </div>

    <div id="modal_pointing" class="modal laos">
        <div class="modal-content">
         <div class="text-center">
             <table class="table table-bordered">
                 <tr>
                     <td id="efg_data"></td>
                     <td id="abc_data"></td>
                 </tr>
             </table> 
         </div>
         <br>
            <div class="detail" ></div> 
            <select  id="main_road">
                @foreach ($beta_main_road as $row)
                    <option value="{{ $row->main_road_id }}">{{ $row->main_road_name }}</option>  
                @endforeach
            </select>
            
            <div class="checkbox-container checkbox-columns">
            @foreach ($beta_road_select as $row)
                <p  >
                <input type="checkbox" id="check{{ $row->road_id }}" name="checkbox_name" value="{{ $row->road_id }}" data-name="{{ $row->road_name }}">
                <label for="check{{ $row->road_id }}">{{ $row->road_name }}</label>
                </p>
            @endforeach 
            </div>

            <hr>
            <div>
                <table class="table table-bordered table-hover">
                    <tbody id="display_subject"></tbody>
                </table>
            </div>
            <input type="text" class="form-control" name="detail" id="details" placeholder="ໝາຍເຫດ">
            <br>
            <button class="btn btn-outline-info  pointing" data-id="0">ຕົກລົງ</button>
        </div>
    </div>



    <div id="modal_cancel" class="modal laos">
        <div class="modal-content">
         <div class="text-right"> 
         </div>
         <br> 
            <input type="text" class="form-control" name="cancel_log" id="cancel_log" placeholder="ສາເຫດຍົກເລີກ">
            <br>
            <button class="btn btn-outline-info  btn_cancel" id="cancel" data-id="0">ຕົກລົງ</button>
        </div>
    </div>

    <div id="modal_pointing_back" class="modal laos">
        <div class="modal-content">
            <input type="text" id="pointing_log" placeholder="ສາເຫດທີ່ຕີກັບ">
            <button class="btn bbtn-outline-info  down2" data-id="0">ຕົກລົງ</button> 
        </div>
    </div>

    
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
                                @if(auth()->user()->is_admin=='2' || auth()->user()->is_admin=='5')
                                    <x-jet-nav-link href="{{ route('seeEnterWaiting') }}" :active="request()->routeIs('seeEnterWaiting')" style="color:#000!important;text-decoration:none;font-size: 0.90em!important;">
                                        ກຳລັງເຮັດວຽກ
                                        @if( auth()->user()->is_admin=='5')
                                            (2)
                                        @endif
                                    </x-jet-nav-link>  
                                    &nbsp;&nbsp; 
                                    @if( auth()->user()->is_admin!='5')
                                        <x-jet-nav-link href="{{ route('seeEnterPointing') }}" :active="request()->routeIs('seeEnterPointing')" style="color:#000!important;text-decoration:none;font-size: 0.90em!important;">
                                            ລໍຖ້າລະບຸປາຍທາງ
                                        </x-jet-nav-link> 
                                    @endif
                                    &nbsp;&nbsp; 
                                    <x-jet-nav-link href="{{ route('seeEnterReady') }}" :active="request()->routeIs('seeEnterReady')" style="color:#000!important;text-decoration:none;font-size: 0.90em!important;">
                                        ລໍຖ້າສົ່ງ
                                        @if( auth()->user()->is_admin=='5')
                                            (2)
                                        @endif
                                    </x-jet-nav-link>   
                                    &nbsp;&nbsp; 

                                    @if( auth()->user()->is_admin!='5')
                                        <x-jet-nav-link href="{{ route('seeEnterSussess') }}" :active="request()->routeIs('seeEnterSussess')" style="color:#000!important;text-decoration:none;font-size: 0.90em!important;">
                                            ສຳເລັດ
                                        </x-jet-nav-link>  
                                    @endif
                                &nbsp;&nbsp;
                                @endif
                                @if(auth()->user()->is_admin=='3' || auth()->user()->is_admin=='5')
                                    <x-jet-nav-link href="{{ route('seeEnterPointing') }}" :active="request()->routeIs('seeEnterPointing')" style="color:#000!important;text-decoration:none;font-size: 0.90em!important;">
                                        ກຳລັງເຮັດວຽກ  
                                        @if( auth()->user()->is_admin=='5')
                                            (3)
                                        @endif
                                    </x-jet-nav-link>  
                                    &nbsp;&nbsp;  
                                     @if( auth()->user()->is_admin!='5')
                                         
                                    <x-jet-nav-link href="{{ route('seeEnterSigning') }}" :active="request()->routeIs('seeEnterSigning')" style="color:#000!important;text-decoration:none;font-size: 0.90em!important;">
                                        ລໍ້ຖ້າເຊັນ
                                    </x-jet-nav-link> 
                                    @endif
                                    &nbsp;&nbsp; 
                                    <x-jet-nav-link href="{{ route('seeEnterSigned') }}" :active="request()->routeIs('seeEnterSigned')" style="color:#000!important;text-decoration:none;font-size: 0.90em!important;">
                                        ລໍຖ້າສົ່ງ
                                        @if( auth()->user()->is_admin=='5')
                                            (3)
                                        @endif
                                    </x-jet-nav-link>    
                                    &nbsp;&nbsp;  
                                    @if( auth()->user()->is_admin!='5') 
                                        <x-jet-nav-link href="{{ route('seeEnterSussess') }}" :active="request()->routeIs('seeEnterSussess')" style="color:#000!important;text-decoration:none;font-size: 0.90em!important;">
                                            ສຳເລັດ
                                        </x-jet-nav-link>  
                                    @endif
                                @endif
                                @if(auth()->user()->is_admin=='4' || auth()->user()->is_admin=='5')
                                    <x-jet-nav-link href="{{ route('seeEnterSigning') }}" :active="request()->routeIs('seeEnterSigning')" style="color:#000!important;text-decoration:none;font-size: 0.90em!important;">
                                        ກຳລັງເຮັດວຽກ
                                        @if( auth()->user()->is_admin=='5')
                                            (4)
                                        @endif
                                    </x-jet-nav-link> 
                                    @if( auth()->user()->is_admin!='5')
                                        &nbsp;&nbsp;
                                        <x-jet-nav-link href="{{ route('seeEnterSigned') }}" :active="request()->routeIs('seeEnterSigned')" style="color:#000!important;text-decoration:none;font-size: 0.90em!important;">
                                            ລໍຖ້າສົ່ງ
                                        </x-jet-nav-link>   
                                        &nbsp;&nbsp;
                                    @endif
                                    
                                        <x-jet-nav-link href="{{ route('seeEnterSussess') }}" :active="request()->routeIs('seeEnterSussess')" style="color:#000!important;text-decoration:none;font-size: 0.90em!important;">
                                            ສຳເລັດ
                                        </x-jet-nav-link>  
                                @endif   

                                
                                    <div class="xdropdown"> 
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" viewBox="0 0 24 24" class="w-8 h-5 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                                        </svg>
                                        <div class="xdropdown-content text-center"> 
                                        @if(auth()->user()->is_admin!='4')
                                             
                                            @endif ​
                                            <x-jet-nav-link href="{{ route('seeEnterall') }}" :active="request()->routeIs('seeEnterall')" style="color:#000!important;text-decoration:none;font-size: 0.90em!important;">
                                            ເອກະສານທັງໝົດ
                                            </x-jet-nav-link> 
                                            <br> 
                                            <x-jet-nav-link href="{{ route('seeEnterCancel') }}" :active="request()->routeIs('seeEnterCancel')" style="color:#000!important;text-decoration:none;font-size: 0.90em!important;">
                                            ລາຍການຍົກເລີກ
                                            </x-jet-nav-link> 
                                        </div>
                                    </div>
                        <div class="d-none d-sm-none d-md-none d-lg-block">
                            <div class="">
                                <table class="table table-bordered display " id="table_data_display"   style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">ເລກທີ</th>
                                            <th>ບໍລິສັດ</th> 
                                            <th>ຂໍ້ມູນລົດ</th> 
                                            <th>ສາຍທາງ</th> 
                                            <th width="15%">ປາຍທາງ</th>  
                                            <th>ຈັດການ</th> 
                                            <th>ເອກະສານແນບ</th> 
                                        </tr>
                                    </thead>
                                    <tbody class="sub_stable_font">
                                        @foreach ($beta_enter as $row_enter) 
                                            <tr class="row_fade{{ $row_enter->enter_id }}">
                                                <td class="white-thing">{{ $row_enter->enter_number}}</td>
                                                <td class="white-thing">
                                                    {{ $row_enter->com_name}}<br><small class="sub_stable_font">{{ date('d-m-Y / H:i:s',strtotime($row_enter->date_in)) }}<br>{{ $row_enter->name}}<br>{{ $row_enter->email }}</small>
                                                    <br>
                                                    @if($row_enter->status=="WAITING")  
                                                        <badge class="badge btn-warning">ລໍຖ້າກວດ</badge>
                                                    @elseif($row_enter->status=="POINTING")  
                                                        <badge class="badge btn-primary">ຖ້າລະບຸເສັ້ນທາງ</badge>
                                                    @elseif($row_enter->status=="SIGNING")  
                                                        <badge class="badge btn-warning">ຖ້າເຊັນ</badge>
                                                    @elseif($row_enter->status=="SIGNINED") 
                                                        <badge class="badge btn-primary">ເຊັນແລ້ວ</badge>
                                                    @elseif($row_enter->status=="READY") 
                                                        <badge class="badge btn-primary">ລໍຖ້າສົ່ງ</badge>
                                                    @elseif($row_enter->status=="SUCCESS") 
                                                        <badge class="badge btn-success">ສຳເລັດ</badge>
                                                    @elseif($row_enter->status=="CANCEL")  
                                                        <badge class="badge btn-danger">ຍົກເລີກ</badge> 
                                                    @elseif($row_enter->status=="DRAFT")  
                                                        <badge class="badge btn-danger">DRAFT (ບໍລິສັດ)</badge
                                                    @else
                                                        ບໍ່ມີສະຖານະ
                                                    @endif 
                                                    <br>
                                                    @if($row_enter->status=='CANCEL')
                                                    ສາເຫດ : {{ $row_enter->cancel_log }}
                                                    @endif
                                                    @if(auth()->user()->is_admin=='4' || auth()->user()->is_admin=='5')
                                                                @if($row_enter->status=='SIGNING')  
                                                                <br>
                                                                <div class="sm:hidden">
                                                                    <button class="btn btn-light sign " data-id="{{ $row_enter->enter_id}}">ລົງລາຍເຊັນ </button> 
                                                                </div>
                                                                @endif
                                                            @endif 
                                                </td>
                                                <td class="white-thing">
                                                <table class="table sub_table sub_stable_font" style="margin:0px;border-radius:5px;">  
                                                        @php($count_list=1)
                                                        @php($get_product_list_for_option = '')
                                                        @foreach ($beta_enter_detail as $row) 
                                                        @if($row->enter_id==$row_enter->enter_id)
                                                        @php($count_list++) 
                                                            <tr> 
                                                                    <td>
                                                                        <div class="d-flex justify-content-start">
                                                                            <div style="padding:7px 0px 0px 0px;">
                                                                                @if($row->is_verify=='NO')
                                                                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 0 24 24" width="24px" fill="#EA3323"><path d="M0 0h24v24H0z" fill="none"/><path d="M15.73 3H8.27L3 8.27v7.46L8.27 21h7.46L21 15.73V8.27L15.73 3zM17 15.74L15.74 17 12 13.26 8.26 17 7 15.74 10.74 12 7 8.26 8.26 7 12 10.74 15.74 7 17 8.26 13.26 12 17 15.74z"/></svg> -->
                                                                                @else
                                                                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 0 24 24" width="24px" fill="#78A75A"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg> -->
                                                                                @endif
                                                                            </div>
                                                                            {{ $row->plate_number }}
                                                                        </div>
                                                                    </td>
                                                                    <td>{{ $row->d_name }}</td>
                                                                    <td>{{ $row->t_type_name }}</td>
                                                                    <td>{{ $row->p_import }}</td>
                                                                    <td>{{ $row->detail }}</td> 
                                                                    <td>{{ ($row->weight) }}</td>
                                                                   
                                                            </tr> 
                                                            @php($get_product_list_for_option .= ''.$row->p_import.'<br>')
                                                        @endif
                                                        @endforeach  
                                                </table>
                                                </td>
                                                <td class="sub_stable_font white-thing">
                                                <u>{{ $row_enter->main_road_name }}</u><br>
                                                    @foreach ($beta_enter_road_detail as $row_enter_road_detail)
                                                        @if($row_enter_road_detail->enter_id==$row_enter->enter_id)
                                                        - {{ $row_enter_road_detail->road_name }}<br>
                                                        @endif
                                                    @endforeach
                                                </td> 
                                                <td class="sub_stable_font white-thing" style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: normal;" title="{{ $row_enter->lasttails }}"><p>ບ້ານ {{ str_replace('ບ້ານ','',$row_enter->address) }}<br> ເມືອງ {{ str_replace('ເມືອງ','',$row_enter->district) }}<br> ແຂວງ {{ str_replace('ແຂວງ','',$row_enter->province) }}
                                                    @if($row_enter->lasttails)
                                                        <div style="width: 100%; word-wrap: break-word;"><small>( {{ $row_enter->lasttails }} )</small></div>
                                                    @endif
                                                    <br>
                                                    @if($row_enter->feed_back_msg!='')
                                                    <div style="width: 100%; word-wrap: break-word;color:blue;">ໝາຍເຫດ : {{ $row_enter->feed_back_msg }}</div> 
                                                    @endif
                                                </td> 
                                                <td class="white-thing">
                                                    <div class="xdropdown"> 
                                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" viewBox="0 0 24 24" class="w-8 h-5 text-gray-400">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                                                        </svg>
                                                        <div class="xdropdown-content">    
                                                            @if(auth()->user()->is_admin=='2' || auth()->user()->is_admin=='3' || auth()->user()->is_admin=='5') 
                                                            @endif  
                                                            @if(auth()->user()->is_admin=='2'  || auth()->user()->is_admin=='5')
                                                                @if($row_enter->status=='WAITING') 
                                                                <a href="{{ url('/see/enter/list/view/'.$row_enter->enter_id) }}"> <button class="btn-light"  >ເບີ່ງຂໍ້ມູນ</button></a>
                                                                <br>
                                                                <!-- <button class="btn-light up" data-id="{{ $row_enter->enter_id}}">ສົ່ງໄປລະບຸສາຍທາງ </button>
                                                                <br> -->
                                                                <button class="btn-light"  onclick="showOptionCancel({{ $row_enter->enter_id}})">ຍົກເລີກ </button>
                                                                @elseif($row_enter->status=='READY')
                                                                <!-- <button class="btn-light upcom" data-id="{{ $row_enter->enter_id}}">ສົ່ງໃຫ້ບໍລິສັດ </button>
                                                                <br>  -->
                                                                @elseif($row_enter->status=='CANCEL')
                                                                <button class="btn-light reroll" data-id="{{ $row_enter->enter_id}}">ດືງກັບ </button>
                                                                <br>
                                                                
                                                                @else 
                                                                @endif

                                                                @if($row_enter->status=='POINTING')
                                                                    <button  class="btn-light down" data-id="{{ $row_enter->enter_id}}">ດຶງກັບ</button> 
                                                                @elseif($row_enter->status=='READY')
                                                                    <br>
                                                                    <button  class="btn-light down6" data-id="{{ $row_enter->enter_id }}">ຕີກັບ</button> 
                                                                @elseif($row_enter->status=='SUCCESS')
                                                                <br>
                                                                <button  class="btn-light down7" data-id="{{ $row_enter->enter_id }}">ດືງກັບ</button> 

                                                                @else

                                                                @endif 
                                                                
                                                            @endif

                                                            @if(auth()->user()->is_admin=='3' || auth()->user()->is_admin=='5')
                                                                @if($row_enter->status=='POINTING') 
                                                                    <!-- <button class="btn-light " onclick="showOptionPointing({{ $row_enter->enter_id}})">ສົ່ງໄປຖ້າເຊັນ </button>
                                                                    <br>  -->
                                                                    <button class="btn-light"  onclick="showOptionPointingBack({{ $row_enter->enter_id}})">ຕີກັບ </button>
                                                                @elseif($row_enter->status=='SIGNING')
                                                                    <button class="btn-light down3" data-id="{{ $row_enter->enter_id}}">ດຶງກັບ </button>
                                                                @elseif($row_enter->status=='SIGNINED')
                                                                    <button class="btn-light down5x"  data-id="{{ $row_enter->enter_id}}">ຕີກັບ</button>
                                                                @else
                                                                @endif
                                                            @endif


                                                            @if(auth()->user()->is_admin=='4' || auth()->user()->is_admin=='5')
                                                                @if($row_enter->status=='SIGNING')   
                                                                    <button class="btn-light down4"  data-id="{{ $row_enter->enter_id}}">ຕີກັບ </button>
                                                                @elseif($row_enter->status=='SIGNINED')
                                                                    <button class="btn-light down5" data-id="{{ $row_enter->enter_id}}">ຍົກເລີກເຊັນ </button>
                                                                @else 
                                                                @endif
                                                            @endif  
                                                        </div> 
                                                    </div> 

                                                    <br>
                                                            @if(auth()->user()->is_admin=='2' || auth()->user()->is_admin=='5')
                                                                @if($row_enter->status=='WAITING')  
                                                                <br>
                                                                <button class="btn btn-light up" data-id="{{ $row_enter->enter_id}}">ຍອມຮັບ </button> 
                                                                @elseif($row_enter->status=='READY')
                                                                <br>
                                                                <button class="btn btn-light upcom" data-id="{{ $row_enter->enter_id}}">ສົ່ງໃຫ້ບໍລິສັດ </button>   
                                                                @else 
                                                                @endif 
                                                            @endif

                                                            @if(auth()->user()->is_admin=='4' || auth()->user()->is_admin=='5')
                                                                @if($row_enter->status=='SIGNING')  
                                                                <br>
                                                                <div class="hidden sm:flex">
                                                                    <button class="btn btn-light sign " data-id="{{ $row_enter->enter_id}}">ລົງລາຍເຊັນ </button> 
                                                                </div>
                                                                    @if(auth()->user()->id=='738') 
                                                                        <div>
                                                                            <button class="btn btn-light special_sign " data-id="{{ $row_enter->enter_id}}">ທົດລອງລົງລາຍເຊັນ </button> 
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @endif 

                                                            @if(auth()->user()->is_admin=='3' || auth()->user()->is_admin=='5')
                                                                @if($row_enter->status=='POINTING') 
                                                                <br>
                                                                    <button class="btn btn-light " onclick="showOptionPointing({{ $row_enter->enter_id}},'{{ str_replace('ບ້ານ','',$row_enter->address) }}','{{ str_replace('ເມືອງ','',$row_enter->district) }}', '{{ str_replace('ແຂວງ','',$row_enter->province) }}','{{ $get_product_list_for_option }}','{{ $row_enter->com_id}}')">ສົ່ງໄປຖ້າເຊັນ </button>  
                                                                @elseif($row_enter->status=='SIGNINED')
                                                                <br>
                                                                    <button class="btn btn-light ready"  data-id="{{ $row_enter->enter_id}}">ສົ່ງຂາເຂົ້າຂາອອກ</button>
                                                                @else
                                                                @endif
                                                            @endif

                                                           
                                                </td> 
                                                <td class="white-thing"> 

                                                @if(auth()->user()->is_admin=='2' || auth()->user()->is_admin=='3' || auth()->user()->is_admin=='5') 
                                                                @if($row_enter->status=='SIGNINED') 
                                                                    <a class=" " href="{{url('/see/enter/print/'.$row_enter->enter_id)}}" target="_BLANK">
                                                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                                                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-5 text-gray-400">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                                                        </svg>
                                                                    </a> 
                                                                @endif 
                                                            @endif
                                                    @php($count_file = 1)
                                                    @foreach ($beta_enter_file as $row_file)
                                                        @if($row_file->enter_id==$row_enter->enter_id)
                                                            <a href="{{ asset($row_file->file_url)}}" target="_BLANK">
                                                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                                                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-5 text-gray-400">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                                                </svg>  
                                                            </a>  
                                                        @endif
                                                    @endforeach
                                                </td> 
                                            </tr> 
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>



                                <div class="d-block d-sm-block d-md-block d-lg-none space-y-3 mt-3"> 
                                    @foreach ($beta_enter as $row_enter)
                                        @php($get_product_list_for_option = '')

                                        <div class="p-3 mt-3 bg-white border rounded-xl shadow-sm row_fade{{ $row_enter->enter_id }}">

                                        {{-- Row 1: number + actions + status --}}
                                        <div class="d-flex justify-content-between gap-2">
                                            <div>
                                            <div class="fw-bold">ເລກທີ: {{ $row_enter->enter_number }}</div>
                                            <div class="text-muted small">{{ date('d-m-Y / H:i:s',strtotime($row_enter->date_in)) }}</div>
                                            </div>

                                            <div class="text-end">
                                            <div class="d-flex justify-content-end gap-2 flex-wrap">

                                                {{-- Action dropdown (copy from your table if you want full actions) --}}
                                                <div class="xdropdown">
                                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" viewBox="0 0 24 24" class="w-8 h-5 text-gray-400">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                                                    </svg>
                                                    <div class="xdropdown-content">
                                                        <div class="xdropdown-content">    
                                                            @if(auth()->user()->is_admin=='2' || auth()->user()->is_admin=='3' || auth()->user()->is_admin=='5') 
                                                            @endif  
                                                            @if(auth()->user()->is_admin=='2'  || auth()->user()->is_admin=='5')
                                                                @if($row_enter->status=='WAITING') 
                                                                <a href="{{ url('/see/enter/list/view/'.$row_enter->enter_id) }}"> <button class="btn-light"  >ເບີ່ງຂໍ້ມູນ</button></a>
                                                                <br>
                                                                <!-- <button class="btn-light up" data-id="{{ $row_enter->enter_id}}">ສົ່ງໄປລະບຸສາຍທາງ </button>
                                                                <br> -->
                                                                <button class="btn-light"  onclick="showOptionCancel({{ $row_enter->enter_id}})">ຍົກເລີກ </button>
                                                                @elseif($row_enter->status=='READY')
                                                                <!-- <button class="btn-light upcom" data-id="{{ $row_enter->enter_id}}">ສົ່ງໃຫ້ບໍລິສັດ </button>
                                                                <br>  -->
                                                                @elseif($row_enter->status=='CANCEL')
                                                                <button class="btn-light reroll" data-id="{{ $row_enter->enter_id}}">ດືງກັບ </button>
                                                                <br>
                                                                
                                                                @else 
                                                                @endif

                                                                @if($row_enter->status=='POINTING')
                                                                    <button  class="btn-light down" data-id="{{ $row_enter->enter_id}}">ດຶງກັບ</button> 
                                                                @elseif($row_enter->status=='READY')
                                                                    <br>
                                                                    <button  class="btn-light down6" data-id="{{ $row_enter->enter_id }}">ຕີກັບ</button> 
                                                                @elseif($row_enter->status=='SUCCESS')
                                                                <br>
                                                                <button  class="btn-light down7" data-id="{{ $row_enter->enter_id }}">ດືງກັບ</button> 

                                                                @else

                                                                @endif 
                                                                
                                                            @endif

                                                            @if(auth()->user()->is_admin=='3' || auth()->user()->is_admin=='5')
                                                                @if($row_enter->status=='POINTING') 
                                                                    <!-- <button class="btn-light " onclick="showOptionPointing({{ $row_enter->enter_id}})">ສົ່ງໄປຖ້າເຊັນ </button>
                                                                    <br>  -->
                                                                    <button class="btn-light"  onclick="showOptionPointingBack({{ $row_enter->enter_id}})">ຕີກັບ </button>
                                                                @elseif($row_enter->status=='SIGNING')
                                                                    <button class="btn-light down3" data-id="{{ $row_enter->enter_id}}">ດຶງກັບ </button>
                                                                @elseif($row_enter->status=='SIGNINED')
                                                                    <button class="btn-light down5x"  data-id="{{ $row_enter->enter_id}}">ຕີກັບ</button>
                                                                @else
                                                                @endif
                                                            @endif


                                                            @if(auth()->user()->is_admin=='4' || auth()->user()->is_admin=='5')
                                                                @if($row_enter->status=='SIGNING')   
                                                                    <button class="btn-light down4"  data-id="{{ $row_enter->enter_id}}">ຕີກັບ </button>
                                                                @elseif($row_enter->status=='SIGNINED')
                                                                    <button class="btn-light down5" data-id="{{ $row_enter->enter_id}}">ຍົກເລີກເຊັນ </button>
                                                                @else 
                                                                @endif
                                                            @endif 
                                                            
                                                        </div>
                                                    </div> 
                                                </div>
                                                

                                                {{-- Status badge --}}
                                                @if($row_enter->status=="WAITING")
                                                <span class="badge btn-warning">ລໍຖ້າກວດ</span>
                                                @elseif($row_enter->status=="POINTING")
                                                <span class="badge btn-primary">ຖ້າລະບຸເສັ້ນທາງ</span>
                                                @elseif($row_enter->status=="SIGNING")
                                                <span class="badge btn-warning">ຖ້າເຊັນ</span>
                                                @elseif($row_enter->status=="SIGNINED")
                                                <span class="badge btn-primary">ເຊັນແລ້ວ</span>
                                                @elseif($row_enter->status=="READY")
                                                <span class="badge btn-primary">ລໍຖ້າສົ່ງ</span>
                                                @elseif($row_enter->status=="SUCCESS")
                                                <span class="badge btn-success">ສຳເລັດ</span>
                                                @elseif($row_enter->status=="CANCEL")
                                                <span class="badge btn-danger">ຍົກເລີກ</span>
                                                @elseif($row_enter->status=="DRAFT")
                                                <span class="badge btn-danger">DRAFT (ບໍລິສັດ)</span>
                                                @else
                                                <span class="badge btn-secondary">ບໍ່ມີສະຖານະ</span>
                                                @endif

                                            </div>
                                            </div>
                                        </div>

                                        {{-- Row 2: Company --}}
                                        <div class="mt-3"> 
                                            <div class="d-flex justify-content-between fw-bold">
                                                <div>ບໍລິສັດ</div>
                                                <div class="text-end">{{ $row_enter->com_name }}</div>
                                            </div>
                                            <div class="d-flex justify-content-between text-muted small">
                                                <div>{{ $row_enter->name }}</div>
                                                <div class="text-end">{{ $row_enter->email }}</div>
                                            </div>

                                            @if($row_enter->status=='CANCEL')
                                            <div class="text-danger mt-1">ສາເຫດ : {{ $row_enter->cancel_log }}</div>
                                            @endif
                                        </div>

                                        {{-- Row 3: Car info --}}
                                        <div class="mt-3">
                                            <div class="text-muted small mb-1">ຂໍ້ມູນລົດ</div>

                                            <div class="d-grid gap-2">
                                            @foreach ($beta_enter_detail as $row)
                                                @if($row->enter_id==$row_enter->enter_id)
                                                @php($get_product_list_for_option .= ''.$row->p_import.'<br>')

                                                <div class="p-2 rounded border bg-light">
                                                    <div class="d-flex justify-content-between fw-bold">
                                                    <div>{{ $row->plate_number }}</div>
                                                    <div class="text-end">{{ $row->d_name }}</div>
                                                    </div>
                                                    <div class="d-flex justify-content-between text-muted small">
                                                    <div>{{ $row->t_type_name }} • {{ $row->p_import }}</div>
                                                    <div class="text-end">{{ $row->weight }}</div>
                                                    </div>
                                                    @if($row->detail)
                                                    <div class="text-muted small mt-1 text-end">{{ $row->detail }}</div>
                                                    @endif
                                                </div>
                                                @endif
                                            @endforeach
                                            </div>
                                        </div>

                                        {{-- Row 4: Route --}}
                                        <div class="mt-3">
                                            <div class="text-muted small">ສາຍທາງ</div>
                                            <div class="text-sm">
                                            <u class="fw-bold">{{ $row_enter->main_road_name }}</u>
                                            <div class="mt-1 text-end">
                                                @foreach ($beta_enter_road_detail as $row_enter_road_detail)
                                                @if($row_enter_road_detail->enter_id==$row_enter->enter_id)
                                                    <div>- {{ $row_enter_road_detail->road_name }}</div>
                                                @endif
                                                @endforeach
                                            </div>
                                            </div>
                                        </div>

                                            {{-- Row 5: Destination --}}
                                            <div class="mt-3">
                                                <div class="text-muted small">ປາຍທາງ</div>
                                                <div class="text-sm">
                                                    <div class="d-flex justify-content-between flex-wrap gap-2">
                                                        <div>ບ້ານ {{ str_replace('ບ້ານ','',$row_enter->address) }}</div>
                                                        <div>ເມືອງ {{ str_replace('ເມືອງ','',$row_enter->district) }}</div>
                                                        <div>ແຂວງ {{ str_replace('ແຂວງ','',$row_enter->province) }}</div>
                                                    </div>

                                                    @if($row_enter->lasttails)
                                                        <div class="text-muted small mt-1 murphy-break-text">( {{ $row_enter->lasttails }} )</div>
                                                    @endif

                                                    @if($row_enter->feed_back_msg!='')
                                                        <div class="text-sm mt-2 murphy-break-text" style="color:blue;">
                                                        ໝາຍເຫດ : {{ $row_enter->feed_back_msg }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Row 6: Print + Files --}}
                                            <div class="mt-4 flex items-center justify-between gap-2">
                                            

                                            <div class="flex items-center gap-2">
                                                {{-- Print --}}
                                                @if(auth()->user()->is_admin=='2' || auth()->user()->is_admin=='3')
                                                @if($row_enter->status=='SIGNINED')
                                                    <a href="{{url('/see/enter/print/'.$row_enter->enter_id)}}" target="_BLANK" class="btn btn-light btn-sm">
                                                    Print
                                                    </a>
                                                @endif
                                                @endif

                                                {{-- Files --}}
                                                @foreach ($beta_enter_file as $row_file)
                                                    @if($row_file->enter_id==$row_enter->enter_id)
                                                        <a href="{{ asset($row_file->file_url) }}"
                                                        class="btn btn-light btn-sm murphy-file-link"
                                                        data-url="{{ asset($row_file->file_url) }}"
                                                        data-name="
                                                        @foreach ($beta_enter_detail as $row)
                                                            @if($row->enter_id==$row_enter->enter_id)
                                                                    <div>{{ $row->plate_number }}</div>
                                                            @endif
                                                        @endforeach
                                                        ">
                                                            <div>                                                            
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" class="eva eva-attach-outline" fill="inherit"><g data-name="Layer 2"><g data-name="attach"><rect width="24" height="24" opacity="0"></rect><path d="M9.29 21a6.23 6.23 0 0 1-4.43-1.88 6 6 0 0 1-.22-8.49L12 3.2A4.11 4.11 0 0 1 15 2a4.48 4.48 0 0 1 3.19 1.35 4.36 4.36 0 0 1 .15 6.13l-7.4 7.43a2.54 2.54 0 0 1-1.81.75 2.72 2.72 0 0 1-1.95-.82 2.68 2.68 0 0 1-.08-3.77l6.83-6.86a1 1 0 0 1 1.37 1.41l-6.83 6.86a.68.68 0 0 0 .08.95.78.78 0 0 0 .53.23.56.56 0 0 0 .4-.16l7.39-7.43a2.36 2.36 0 0 0-.15-3.31 2.38 2.38 0 0 0-3.27-.15L6.06 12a4 4 0 0 0 .22 5.67 4.22 4.22 0 0 0 3 1.29 3.67 3.67 0 0 0 2.61-1.06l7.39-7.43a1 1 0 1 1 1.42 1.41l-7.39 7.43A5.65 5.65 0 0 1 9.29 21z"></path></g></g></svg>
                                                            </div>
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                                <div class="d-flex justify-content-end"> 
                                                            @if(auth()->user()->is_admin=='2' || auth()->user()->is_admin=='5')
                                                                @if($row_enter->status=='WAITING')  
                                                                <br>
                                                                <button class="btn btn-light up " style="width:20%;font-size:15px;" data-id="{{ $row_enter->enter_id}}">ຍອມຮັບ </button> 
                                                                @elseif($row_enter->status=='READY')
                                                                <br>
                                                                <button class="btn btn-light upcom " style="width:20%;font-size:15px;" data-id="{{ $row_enter->enter_id}}">ສົ່ງໃຫ້ບໍລິສັດ </button>   
                                                                @else 
                                                                @endif 
                                                            @endif
 
                                                            @if(auth()->user()->is_admin=='4' || auth()->user()->is_admin=='5')
                                                                @if($row_enter->status=='SIGNING')  
                                                                <br>
                                                                <div class="d-flex">
                                                                    <button class="btn btn-light sign  " style="font-size:15px;" data-id="{{ $row_enter->enter_id}}">ລົງລາຍເຊັນ</button> 
                                                                </div>
                                                                    @if(auth()->user()->id=='738') 
                                                                        <div>
                                                                            <button class="btn btn-light special_sign  " style="width:20%;font-size:15px;" data-id="{{ $row_enter->enter_id}}">ທົດລອງລົງລາຍເຊັນ </button> 
                                                                        </div>
                                                                    @endif
                                                                @else
                                                                @endif
                                                            @endif 

                                                            @if(auth()->user()->is_admin=='3' || auth()->user()->is_admin=='5')
                                                                @if($row_enter->status=='POINTING') 
                                                                <br>
                                                                    <button class="btn btn-light  " style="width:20%;font-size:15px;" onclick="showOptionPointing({{ $row_enter->enter_id}},'{{ str_replace('ບ້ານ','',$row_enter->address) }}','{{ str_replace('ເມືອງ','',$row_enter->district) }}', '{{ str_replace('ແຂວງ','',$row_enter->province) }}','{{ $get_product_list_for_option }}','{{ $row_enter->com_id}}')">ສົ່ງໄປຖ້າເຊັນ </button>  
                                                                @elseif($row_enter->status=='SIGNINED')
                                                                <br>
                                                                    <button class="btn btn-light ready " style="width:40%;font-size:15px;"  data-id="{{ $row_enter->enter_id}}">ສົ່ງຂາເຂົ້າຂາອອກ</button>
                                                                @else
                                                                @endif
                                                            @endif 
                                                </div>
                                        </div>
                                    @endforeach
                                </div>
                                <br>
                                <br>
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

    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <!-- jQuery (you already have probably) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- jQuery UI (for drag + resize) -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.min.js"></script>

<script>
                    let checkedValues = [];

  function murphyGetExt(url){
    const clean = (url || '').split('?')[0].split('#')[0];
    return clean.slice(clean.lastIndexOf('.') + 1).toLowerCase();
  }

  function murphyBuildPreview(url){
    const ext = murphyGetExt(url);

    if(ext === 'pdf'){
      return `
        <div class="murphy-preview-shell murphy-resizable" id="murphyPreviewBox">
          <iframe class="murphy-preview-iframe" src="${url}"></iframe>
        </div>`;
    }

    if(['png','jpg','jpeg','webp','gif'].includes(ext)){
      return `
        <div class="murphy-preview-shell murphy-resizable" id="murphyPreviewBox">
          <img class="murphy-preview-img" src="${url}" alt="preview">
        </div>`;
    }

    // Fallback: show download link
    return `
      <div class="murphy-preview-shell murphy-resizable" id="murphyPreviewBox" style="display:flex;align-items:center;justify-content:center;padding:18px;">
        <div style="text-align:center;">
          <div style="margin-bottom:10px;">Preview not supported: <b>${ext || 'unknown'}</b></div>
          <a class="btn btn-light" href="${url}" target="_blank" rel="noopener">Open file</a>
        </div>
      </div>`;
  }

  // Delegated click (works even if list updates)
  $(document).on('click', '.murphy-file-link', function(e){
    e.preventDefault();

    const url  = $(this).data('url') || $(this).attr('href');
    const name = $(this).data('name') || 'File Preview';

    Swal.fire({
      title: '',
      html: `<div style="font-size: 12px;">`+name + `</div>`+murphyBuildPreview(url),
      width: '92vw',
      padding: 0,
      showCloseButton: true,
      showConfirmButton: false,
      backdrop: true,
      customClass: {
        popup: 'murphy-swal-popup',
        title: 'murphy-swal-title'
      },
      didOpen: () => {
        const $popup = $(Swal.getPopup());

        // draggable by title
        $popup.draggable({
          handle: '.swal2-title',
          containment: 'window'
        });

        // resizable by corner
        $popup.resizable({
          handles: 'se, s, e',
          minHeight: 320,
          minWidth: 320
        });

        // keep inner preview filling popup
        $popup.on('resize', function(){
          // nothing needed because shell uses vh + 100%,
          // but leaving hook here if you want dynamic height later.
        });
      }
    });
  });
</script>
    <script>

var currentUrl = window.location.pathname;
if (currentUrl != "/see/enter/all" && currentUrl != "/see/enter/sussess" && currentUrl != "/see/enter/cancel") {
var timeoutID = setTimeout(function() {
                location.reload();
                }, 10000);
            }

                    
        $(document).ready(function () { 
           
              
            // $(document).on('mousemove keypress touchstart', function(event) {
            //     if (currentUrl != "/see/enter/all" && currentUrl != "/see/enter/sussess" && currentUrl != "/see/enter/cancel" ) {

            //         clearTimeout(timeoutID);
            //         var reloadTime = 10000;
            //         console.log('a');
            //         if ($(event.target).closest('.modal-content').length) {
            //             reloadTime = 60000;
            //             console.log('b');
            //         }
            //         timeoutID = setTimeout(function() {
            //             // location.reload(); xxxxxxxx
            //         }, reloadTime);
            //     } 
            // });



            // let timer = $('#timer').val();
            // timer = timer+'000';  
            // $('#timer').on('change',function(){
            //     timer = $('#timer').val();
            //     timer = timer+'000';
            //     alert(timer);
            // })

            // intervalId = setInterval(function() {
            //             location.reload();
            //             }, timer); // 3000 milliseconds = 3 seconds
            // var autoReload = false;0-\]
            // document.getElementById("a0  utoReloadCheckbox").addEventListener("change", function() {
            //     autoReload = this.checked;
            //     if (!autoReload) {
            //     var currentUrl = window.location.pathname;
            //         if (currentUrl != "/see/enter/all") {
            //             intervalId = setInterval(function() {
            //             location.reload();
            //             }, timer); // 3000 milliseconds = 3 seconds
            //         }
            //     } else {
            //         clearInterval(intervalId);
                    
            //     }
            // });


            $(".info-jam").hover(function() {
                $(this).find(".underline").animate({
                    width: "100%"
                }, 250);
            }, function() {
                $(this).find(".underline").animate({
                    width: "0%"
                }, 250);
            });
           
            // $('#table_data_display').DataTable({
            //     order: [[0, 'asc']],
            //     language: {
            //         "search":         "",
            //         "lengthMenu":     "_MENU_",
            //         searchPlaceholder: "ຄົ້ນຫາ",
            //         "paginate": {
            //             "first":      "ທຳອິດ",
            //             "last":       "ສຸດທ້າຍ",
            //             "next":       "ຕໍ່ໄປ",
            //             "previous":   "ກັບຄືນ"
            //         },
            //         "info":           "",
                    
            //     } 
            // }); 

            $(document).on('click','.pointing', function (e) {   
                        e.preventDefault();   
                        let id = $(this).attr('data-id');
                        if(checkedValues!='')
                        {
                            
                        }
                        else
                        {
                                msg = "ກະລຸນາລະບຸ ເສັ້ນທາງ";
                                showAlert(msg);
                            return false
                        }
                        var data = {
                                        "id" : $(this).attr('data-id'), 
                                        "main_road" : $('#main_road').val(),
                                        'details'   : $('#details').val(),
                                        "formdata"  : checkedValues
                                    } 

                        var combinedData = Object.assign(data);
                
                        $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        type:"post",
                                        url:"/see/enter/list/view/update/first/pointing",
                                        data:(data),
                                        dataType:"json", 
                                        success: function(response){  
                                            // window.location.reload(); 
                                            fade_row(id);
                                            $("#modal_pointing").css("display", "none");
                                            $('input[type=checkbox]').prop('checked', false);
                                            checkedValues = [];
                                        },
                                        complete: function() { 
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            if(errorThrown=='Payload Too Large')
                                            {  
                                                return false;
                                            }
                                        }
                                    })
                    });
             
                $(document).on('click','.up', function (e) { 
                        e.preventDefault();  
                        let id = $(this).attr('data-id');
                        var data = {
                                        "id" : $(this).attr('data-id'), 
                                    }

                
                        $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    }); 
                                    $.ajax({
                                        type:"post",
                                        url:"/see/enter/list/view/update/first",
                                        data:(data),
                                        dataType:"json", 
                                        success: function(response){  
                                            // window.location.reload(); 
                                            fade_row(id);
                                        },
                                        complete: function() { 
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            if(errorThrown=='Payload Too Large')
                                            {  
                                                return false;
                                            }
                                        }
                                    }) 
                    });


                $(document).on('click','.upcom', function (e) { 
                        e.preventDefault();  
                        let id = $(this).attr('data-id');

                        var data = {
                                        "id" : $(this).attr('data-id'), 
                                    } 
                        $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    }); 
                        $.ajax({
                            type:"post",
                            url:"/see/enter/list/view/update/first/sign/company",
                            data:(data),
                            dataType:"json", 
                            success: function(response){  
                                // window.location.reload(); 
                                fade_row(id);
                            },
                            complete: function() { 
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                if(errorThrown=='Internal Server Error')
                                {  
                                    let dumx = "ບໍ່ມີຮູບລາຍເຊັນບໍ່ສາມາດເຊັນໄດ້";
                                    showAlert(dumx)
                                    return false;
                                }
                            }
                        }) 
                    });


                    $(document).on('click','.down', function (e) { 
                        e.preventDefault();  
                        var data = {
                                    "id" : $(this).attr('data-id'), 
                                    }
                                    let id = $(this).attr('data-id');
                
                        $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        type:"post",
                                        url:"/see/enter/list/view/update/first/back",
                                        data:(data),
                                        dataType:"json", 
                                        success: function(response){  
                                            // window.location.reload(); 
                                            fade_row(id);
                                        },
                                        complete: function() { 
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            if(errorThrown=='Payload Too Large')
                                            {  
                                                return false;
                                            }
                                        }
                                    })  
                    });


                    $(document).on('click','.down5', function (e) { 
                        e.preventDefault();   
                        
                        var data = {
                                        "id" : $(this).attr('data-id'), 
                                    }
                        let id = $(this).attr('data-id');
                
                        $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        type:"post",
                                        url:"/see/enter/list/view/update/first/back/boss/tosign",
                                        data:(data),
                                        dataType:"json", 
                                        success: function(response){ 
                                            // console.log(response.message)
                                            // let msg = 'ສຳເລັດ' + response.message;
                                            
                                            // window.location.reload(); 
                                            fade_row(id);

                                            
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
                    });

                    $(document).on('click','.down5x', function (e) { 
                        e.preventDefault();   
                        var data = {
                                        "id" : $(this).attr('data-id'), 
                                    }

                                    let id = $(this).attr('data-id');
                
                        $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        type:"post",
                                        url:"/see/enter/list/view/update/first/back/tosign",
                                        data:(data),
                                        dataType:"json", 
                                        success: function(response){   
                                            // window.location.reload(); 
                                            fade_row(id);
                                        },
                                        complete: function() { 
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            if(errorThrown=='Payload Too Large')
                                            {  
                                                return false;
                                            }
                                        }
                                    })  
                    });


                    $('input[name="checkbox_name"]').on('change', function(){
                        let checkbox = $(this);
                        if(checkbox.is(':checked')){
                            checkedValues.push(checkbox.val());
                        }else {
                            checkedValues =  checkedValues.filter(function(value){
                                return value != checkbox.val()
                            });
                        }
                        
                        let dum_str = '';
                        for(i=0;i<=checkedValues.length;i++)
                        {
                            if($('#check'+checkedValues[i]).attr('data-name'))
                            {
                                let dum_name = '<badge class="badge badge-dark">'+$('#check'+checkedValues[i]).attr('data-name')+' .</badge>';
                                dum_str += dum_name+' '; 
                            }
                        }
                        $('.display_road_tails').html(dum_str);
                    });

                    

                    $(document).on('click','.down2', function (e) { 
                        e.preventDefault();  
                        let id = $(this).attr('data-id');

                        if($('#pointing_log').val()=='')
                        {
                            msg = "ກະລຸນາລະບຸສາເຫດ ເພື່ອໃຫ້ເຈົ້າໜ້າທີ່ກ່ອນໜ້າຮັບຮູ້";
                            showAlert(msg);
                            return false
                        }
                        var data = {
                                        "id" : $(this).attr('data-id'), 
                                        "log" : $('#pointing_log').val(),
                                    }

                
                        $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        type:"post",
                                        url:"/see/enter/list/view/update/first/back/pointing",
                                        data:(data),
                                        dataType:"json", 
                                        success: function(response){  
                                            // window.location.reload(); 
                                            fade_row(id);
                                        },
                                        complete: function() { 
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            if(errorThrown=='Payload Too Large')
                                            {  
                                                return false;
                                            }
                                        }
                                    })  
                    });


                    $(document).on('click','.down3', function (e) { 
                        e.preventDefault();  
                        var data = {
                                        "id" : $(this).attr('data-id'), 
                                    }

                                    let id = $(this).attr('data-id');
                
                        $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        type:"post",
                                        url:"/see/enter/list/view/update/first/back/signing",
                                        data:(data),
                                        dataType:"json", 
                                        success: function(response){  
                                            // window.location.reload(); 
                                            fade_row(id);
                                        },
                                        complete: function() { 
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            if(errorThrown=='Payload Too Large')
                                            {  
                                                return false;
                                            }
                                        }
                                    })  
                    });

                    $(document).on('click','.sign', function (e) { 
                        e.preventDefault();  
                        var data = {
                                    "id" : $(this).attr('data-id'), 
                                    }

                                    let id = $(this).attr('data-id');
                
                        $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        type:"post",
                                        url:"/see/enter/list/view/update/first/sign",
                                        data:(data),
                                        dataType:"json", 
                                        success: function(response){  
                                            // window.location.reload(); 
                                            fade_row(id);
                                        },
                                        complete: function() { 
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            if(errorThrown=='Internal Server Error')
                                            {   
                                            }
                                        }
                                    })
                        
                    
                    });  

                     $(document).on('click','.special_sign', function (e) { 
                        e.preventDefault();  
                        var data = {
                                    "id" : $(this).attr('data-id'), 
                                    }
                                    let id = $(this).attr('data-id');
                
                        $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        type:"post",
                                        url:"/see/enter/list/view/update/first/sign/special",
                                        data:(data),
                                        dataType:"json", 
                                        success: function(response){  
                                            // window.location.reload(); 
                                            fade_row(id);
                                        },
                                        complete: function() { 
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            if(errorThrown=='Internal Server Error')
                                            {   
                                            }
                                        }
                                    })
                        
                    
                    });  

                    

                    $(document).on('click', '.down4', function (e) { 
                        e.preventDefault();  
                        if($('#signing_log').val()=='')
                        {
                            msg = "ກະລຸນາລະບຸສາເຫດ ເພື່ອໃຫ້ເຈົ້າໜ້າທີ່ກ່ອນໜ້າຮັບຮູ້";
                            showAlert(msg);
                            return false
                        }
                        var data = {
                                        "id" : $(this).attr('data-id'), 
                                        "log" : $('#signing_log').val(),
                                    }
                                    let id = $(this).attr('data-id');

                
                        $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        type:"post",
                                        url:"/see/enter/list/view/update/first/back/boss",
                                        data:(data),
                                        dataType:"json", 
                                        success: function(response){  
                                            // window.location.reload(); 
                                            fade_row(id);
                                            
                                        },
                                        complete: function() { 
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            if(errorThrown=='Payload Too Large')
                                            {  
                                                return false;
                                            }
                                        }
                                    })  
                    }); 

                    

                    $(document).on('click','.down6', function (e) { 
                        e.preventDefault();   
                        var data = {
                                        "id" : $(this).attr('data-id'), 
                                    }

                
                                    let id = $(this).attr('data-id');
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        type:"post",
                                        url:"/see/enter/list/view/update/first/ready/back",
                                        data:(data),
                                        dataType:"json", 
                                        success: function(response){   
                                            // window.location.reload(); 
                                            fade_row(id);
                                             
                                            console.log(response.message);
                                        },
                                        complete: function() { 
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            if(errorThrown=='Payload Too Large')
                                            {  
                                                return false;
                                            }
                                        }
                                    })  
                    });

                    $(document).on('click','.down7', function (e) { 
                        e.preventDefault();   
                        var data = {
                                        "id" : $(this).attr('data-id'), 
                                    }

                
                                    let id = $(this).attr('data-id');
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        type:"post",
                                        url:"/see/enter/list/view/update/first/success/back",
                                        data:(data),
                                        dataType:"json", 
                                        success: function(response){   
                                            // window.location.reload(); 
                                            fade_row(id); 
                                            console.log(response.message);
                                        },
                                        complete: function() { 
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            if(errorThrown=='Payload Too Large')
                                            {  
                                                return false;
                                            }
                                        }
                                    })  
                    });


                    $(document).on('click','#cancel', function (e) { 
                        e.preventDefault();  
                        if($('#cancel_log').val()=='')
                        {
                            msg = "ກະລຸນາລະບຸສາເຫດ ທີ່ຍົກເລີກ";
                            showAlert(msg);
                            return false
                        }
                        var data = {
                                        "id" : $(this).attr('data-id'), 
                                        "log" : $('#cancel_log').val(),
                                    }
                                    let id = $(this).attr('data-id');

                
                        $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        type:"post",
                                        url:"/see/enter/list/view/update/first/cancel",
                                        data:(data),
                                        dataType:"json", 
                                        success: function(response){ 
                                            // console.log(response.message)
                                            // let msg = 'ສຳເລັດ' + response.message;
                                            
                                            // window.location.reload(); 
                                            fade_row(id);
                                            $("#modal_cancel").css("display", "none");
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
                        
                    
                    });


                    $(document).on('click','.reroll', function (e) { 
                        e.preventDefault();  
                        var data = {
                                        "id" : $(this).attr('data-id'),  
                                    }

                                    let id = $(this).attr('data-id');
                        $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        type:"post",
                                        url:"/see/enter/list/view/update/first/cancel/reroll",
                                        data:(data),
                                        dataType:"json", 
                                        success: function(response){ 
                                            // console.log(response.message)
                                            // let msg = 'ສຳເລັດ' + response.message;
                                            
                                            // window.location.reload(); 
                                            fade_row(id);
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
                        
                    
                    });

                    $(document).on('click','.ready', function (e) { 
                        e.preventDefault();  
                        var data = {
                                    "id" : $(this).attr('data-id'), 
                                    }
                                    let id = $(this).attr('data-id');
                
                        $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        type:"post",
                                        url:"/see/enter/list/view/update/first/ready",
                                        data:(data),
                                        dataType:"json", 
                                        success: function(response){  
                                            // window.location.reload(); 
                                            fade_row(id);
                                        },
                                        complete: function() { 
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            if(errorThrown=='Internal Server Error')
                                            {   
                                            }
                                        }
                                    })
                        
                    
                    });  



            @if(auth()->user()->is_admin=='4')
            $(document).on("click",'.session_set',function(){
                
            $.ajaxSetup({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
            url: '/session_set',
            type: 'POST',
            data: '',
            dataType: 'json',
            timeout: 1000,
            beforeSend: function() {
                console.log('Sending request...');
            },
            success: function(data) {
                if(data.message=='off')
                {
                    $('.session_set').html('ເຊັນເອງ');
                }
                else
                {
                    $('.session_set').html('ເຊັນລະບົບ');
                }
            },
            error: function(xhr, status, error) {
               
            },
            complete: function() {
                console.log('Request completed.');
            }
            });

            })
            @endif

        }); 
   
            function showAlert(msg) {
                // Create the link 
                $('.display_msg').html(msg);
                $("#modal").css("display", "block");
                resetModal()
            }

            function showOptionPointing(id,a,b,c,e,f) {
            // Create the link  
                $('#abc_data').html('ບ້ານ'+a + ', ເມືອງ'+ b + ', ແຂວງ' + c);
                $('#efg_data').html(''+e);
                $('.pointing').attr("data-id",id);
                $("#modal_pointing").css("display", "block");  

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let data = {
                    id : f
                }
                $.ajax({
                    type:"post",
                    url:"{{ route('com.subject.list') }}",
                    data:(data),
                    dataType:"json", 
                    success: function(response){ 
                        const $tbody = $(`#display_subject`);
                        $tbody.empty();

                        if (response.status !== 200) {
                            $tbody.append(`<tr><td colspan="3">Not found</td></tr>`);
                            return;
                        }

                        let data = response.data;

                        // If controller returned a single object, normalize to array
                        if (!Array.isArray(data)) {
                            data = data ? [data] : [];
                        }

                        if (data.length === 0) {
                            $tbody.append(`<tr><td colspan="3">No subjects</td></tr>`);
                            return;
                        }

                        let rows = '';
                        let count = 1;

                        data.forEach(item => {
                            // adjust field names to your real columns
                            rows += `
                            <tr id="row_${item.id}" class="pick_suject" data-subject='${item.subject}'>
                                <td>${item.subject ?? ''}</td>
                                <td style="width:120px"> 
                                </td>
                            </tr>
                            `;
                        });

                        $tbody.append(rows);
                    },
                    complete: function() { 
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if(errorThrown=='Payload Too Large')
                        {  
                            return false;
                        }
                    }
                }); 
            }

    $(document).on("click",".pick_suject",function(){ 
        $('#details').val('');
        $('#details').val($(this).attr('data-subject'));
    });

    function showOptionCancel(id) {
    // Create the link  
        $('#cancel').attr("data-id",id);
        $("#modal_cancel").css("display", "block");  
    }


    function showOptionPointingBack(id) {
    // Create the link  
        $('.down2').attr("data-id",id);
        $("#modal_pointing_back").css("display", "block");
   
    }
    

    function resetModal()
    {
        $("#modal_pointing").css("display", "none");
        $("#modal_cancel").css("display", "none");
        $("#modal_pointing_back").css("display", "none");
    }

    function fade_row(id)
    {
        $('.row_fade'+id).fadeOut('slow');
        
    }
 
    $(window).click(function(event) {
        if (event.target == $("#modal")[0]) {
            $("#modal").css("display", "none");
        } 
        if (event.target == $("#modal_pointing")[0]) {
            $("#modal_pointing").css("display", "none");
        }
        if (event.target == $("#modal_pointing_back")[0]) {
            $("#modal_pointing_back").css("display", "none");
        
        }
        if (event.target == $("#modal_cancel")[0]) {
            $("#modal_cancel").css("display", "none");
        }
    });
 

 
    </script>
   <script>
    

</script>
</x-app-layout>
