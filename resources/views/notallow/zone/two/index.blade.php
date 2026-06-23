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
    
    </style>

    <div id="modal" class="modal">
        <div class="modal-content">
            <p class="laob text-center" id="display_msg"></p> 

             <div>
                <table class="table table-bordered"> 
                    @foreach ($typex as $t)
                        <tr>
                            <td style="background:blue;color:white;" width="25%">
                                <h4><b>{{ $t->name }}</b></h4></td>
                            <td>
                                <div class="d-flex justify-content-start">
                                    <select name="" id="" class="this_select form-control">
                                        <option value="">. . .</option>
                                        @foreach ($t->proHaveType as $p) 
                                            <option value="{{ $p->id }}" data-name="{{ $p->name }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td> 
                        </tr> 
                    @endforeach
                </table>
             </div> 
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
            </select>
            
            <div class="checkbox-container checkbox-columns"> 
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
                                        <x-jet-nav-link href="{{ route('seeZoneTwoQuotar') }}" :active="request()->routeIs('seeZoneTwoQuotar')" style="color:#000!important;text-decoration:none;font-size: 0.90em!important;">
                                            <u>ແຈ້ງຢື່ນໂຄຕ້າ</u>
                                        </x-jet-nav-link>  
                                        <x-jet-nav-link href="{{ route('seeZoneTwo') }}" :active="request()->routeIs('seeZoneTwo')" style="color:#000!important;text-decoration:none;font-size: 0.90em!important;">
                                            <u>ແຈ້ງໂຄຕ້າ</u>
                                        </x-jet-nav-link>  
                                 
                                        <x-jet-nav-link href="{{ route('seeEnterQuotarWaiting') }}" :active="request()->routeIs('seeEnterQuotarWaiting')" style="color:#000!important;text-decoration:none;font-size: 0.90em!important;">
                                            ລໍຖ້າ
                                        </x-jet-nav-link>  
                                        <x-jet-nav-link href="{{ route('seeEnterQuotarSuccess') }}" :active="request()->routeIs('seeEnterQuotarSuccess')" style="color:#000!important;text-decoration:none;font-size: 0.90em!important;">
                                            
                                            ສຳເລັດ
                                        </x-jet-nav-link>  
                                           

                                
                                    <div class="xdropdown"> 
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" viewBox="0 0 24 24" class="w-8 h-5 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                                        </svg>
                                        <div class="xdropdown-content text-center"> 
                                
                                            <x-jet-nav-link href="{{ route('seeEnterall') }}" :active="request()->routeIs('seeEnterall')" style="color:#000!important;text-decoration:none;font-size: 0.90em!important;">
                                            ເອກະສານທັງໝົດ
                                            </x-jet-nav-link> 
                                            <br> 
                                            <x-jet-nav-link href="{{ route('seeEnterCancel') }}" :active="request()->routeIs('seeEnterCancel')" style="color:#000!important;text-decoration:none;font-size: 0.90em!important;">
                                            ລາຍການຍົກເລີກ
                                            </x-jet-nav-link> 
                                        </div>
                                    </div>
               
                            <div class="">
                                <table class="table table-bordered display " id=""   style="width:100%">
                                    <thead>
                                        <tr>
                                            <!-- <th width="5%">ເລກທີ</th> -->
                                            <th>ບໍລິສັດ</th> 
                                            <th width="8%">ອອກເມື່ອ</th> 
                                            <th>ລາຍການ</th>  
                                            <th width="5%">ຈັດການ</th> 
                                            <th width="8%">ເອກະສານແນບ</th> 
                                        </tr>
                                    </thead>
                                    <tbody class="sub_stable_font">
                                        @foreach ($waiting as $w)
                                            <tr>
                                                <!-- <td></td> -->
                                                <td>{{ $w->QHaveCom->com_name }}
                                                    <br><small>ອອກໂດຍ : {{ $w->user->name ?? ''  }}</small>
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
                                                                    <button class="btn btn-light setup" 
                                                                            data-id="{{ $wq->id }}" 
                                                                            data-name="{{ $wq->name }}"
                                                                            data-qty="{{ $wq->qty }}"
                                                                            data-weight="{{ $wq->weight }}"
                                                                            data-total_price="{{ number_format($wq->total_price) }}"
                                                                            style="border:solid #343434 1px;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" style="fill:blue;"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M3.9 54.9C10.5 40.9 24.5 32 40 32H472c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z"/></svg>
                                                                    </button>
                                                                </div>
                                                        </div>
                                                    @endforeach 
                                                </td>
                                                <td class=""> 
                                                        <div class="xdropdown"> 
                                                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-5 text-gray-400">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                                                            </svg>
                                                            <div class="xdropdown-content text-center"> 
                                                                <button class="btn btn-light text-center accept" data-id="{{ $w->id }}" style="border:solid #343434 1px;">
                                                                    ຍືນຍັນ
                                                                </button>
                                                                <br> 
                                                                <br> 
                                                                <button class="btn btn-light text-center  cancel" data-id="{{ $w->id }}" style="border:solid #343434 1px;">
                                                                    ຕີກັບ
                                                                </button>
                                                            </div>
                                                        </div> 
                                                </td>
                                                <td>
                                                    @foreach ($w->QhaveF as $wf)
                                                    <div><a href="{{ asset( $wf->file_url ) }}" target="_BLANK">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" style="fill:blue;"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 480H448c35.3 0 64-28.7 64-64V160c0-35.3-28.7-64-64-64H288c-10.1 0-19.6-4.7-25.6-12.8L243.2 57.6C231.1 41.5 212.1 32 192 32H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64z"/></svg>
                                                    </a></div> 
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                                <br>
                                <br>
                                    <div class="item-pagination d-flex justify-content-center mt-5">
                                        {{ $waiting->links('pagination.custome-pagination') }}
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
    <script>
 
    var go = '';
        $(document).ready(function () { 
            $(document).on('click','#cancel', function (e) {
                const cancel_log = $('#cancel_log').val();
                if(cancel_log)
                {

                }
                else
                {
                    $('#cancel_log').focus();
                    return false
                }
                if(confirm('ຕິກັບເອກະສານ?'))
                {
                    const hash = $(this).attr('data-id');
                    
                    data = {
                        id : hash, 
                        cancel_log : cancel_log, 
                    }

                    $.ajaxSetup({
                        headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: '{{ route('quotar.cancel') }}',
                            type: 'POST',
                            data: data,
                            beforeSend: function() {
                                console.log('Sending request...');
                            },
                            success: function(data) { 
                                window.location.reload();
                            },
                            error: function(xhr, status, error) {
                            
                            },
                            complete: function() {
                                console.log('Request completed.');
                            }
                        });

                }
              

            });
            $(document).on('click','.cancel', function (e) {
                const hash = $(this).attr('data-id');
                $('#cancel').attr('data-id',hash);
                
                $("#modal_cancel").css("display", "block");

            });
            $(document).on('click','.accept', function (e) { 

                if(confirm('ຍອມຮັບຂໍ້ມູນຊຸດນີ້ແມ່ນບໍ່?'))
                {
                    const hash = $(this).attr('data-id');

                    data = {
                        id : hash, 
                    }

                    $.ajaxSetup({
                        headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: '{{ route('quotar.pointing') }}',
                            type: 'POST',
                            data: data,
                            beforeSend: function() {
                                console.log('Sending request...');
                            },
                            success: function(data) { 
                                window.location.reload(); 
                            },
                            error: function(xhr, status, error) {
                            
                            },
                            complete: function() {
                                console.log('Request completed.');
                            }
                        });
                }
            });
            $(document).on('change','.this_select', function (e) { 
                const name = $(this).find('option:selected').data('name');
                const hash = $(this).val();
                $('.display_pro_type_'+go).html(name);
                $(this).val('');
                $('#display_msg').html('');


                data = {
                    id : go,
                    pro_type_id : hash,
                }

                $.ajaxSetup({
                    headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                    url: '{{ route('set.type') }}',
                    type: 'POST',
                    data: data,
                    beforeSend: function() {
                        console.log('Sending request...');
                    },
                    success: function(data) { 
                    },
                    error: function(xhr, status, error) {
                    
                    },
                    complete: function() {
                        console.log('Request completed.');
                    }
                    });
 
                $("#modal").css("display", "none");
                 
            });
            $(document).on('click','.setup', function (e) { 
                const hash = $(this).attr('data-id');

                let name = $(this).attr('data-name');
                let qty = $(this).attr('data-qty');
                let weight = $(this).attr('data-weight');
                let total_price = $(this).attr('data-total_price');

                $('#display_msg').html('<b>'+name + ' | ' + qty + ' | ' + weight + ' | '  + total_price + '</b>');

                go = hash;
                $("#modal").css("display", "block");
                
            });
        });
   </script>
    <script>

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
 
</x-app-layout>
