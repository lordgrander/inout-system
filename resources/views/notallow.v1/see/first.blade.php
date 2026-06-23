<x-app-layout> 
<style>
    .badge
    {
        padding:0.15em .65em!important;
    }
    .grid-container {
        display: grid;
        grid-template-columns: 5% 35% 50%; /* first grid item has 30% width */
        grid-gap: 10px;
        width:100%;
    }

    .grid-item {
        padding: 10px;
    }

/* Change layout for screen widths < 768px */
@media screen and (max-width: 768px) {
  .grid-container {
    grid-template-columns: repeat(1, 1fr);
  }
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

  #modal-close 
  {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  #modal-close:hover,
  #modal-close:focus 
  {
    color: #000;
    text-decoration: none;
    cursor: pointer;
  }

</style>
 
<div id="modal">
    <div id="modal-content">
        <p class="laob display_msg"></p>
    <!-- <button id="modal-close">Close</button> -->
    </div>
</div>
    <div class="py-12 laos">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20  border-b border-gray-200" style="background:#f3ca00;">
                    <div>
                    <div class="grid-container">
                        <div class="grid-item">
                        <svg viewBox="0 0 70 48" fill="none" xmlns="http://www.w3.org/2000/svg"
                                        class="block h-12 w-auto"> 
                                            
                                        <path
                                            d="M11.395 44.428C4.557 40.198 0 32.632 0 24 0 10.745 10.745 0 24 0a23.891 23.891 0 0113.997 4.502c-.2 17.907-11.097 33.245-26.602 39.926z"
                                            fill="#6875F5"></path>
                                        <path
                                            d="M14.134 45.885A23.914 23.914 0 0024 48c13.255 0 24-10.745 24-24 0-3.516-.756-6.856-2.115-9.866-4.659 15.143-16.608 27.092-31.75 31.751z"
                                            fill="#6875F5"></path>
                                    </svg> 
                        </div>
                        <div class="grid-item"> 
                                    <h4><b class="laob">ເລືອກເມນູເພື່ອຈັດການເອກະສານ.</b></h4>
                                    <div class="progress-bar">
                                        <div id="waiting" class="phase">{{ $progress_bar_name }}</div> 
                                    </div>
                        </div>
                        <div class="grid-item text-right">
                            @if(auth()->user()->is_admin=='2')
                                <table class="" width="100%">
                                    <tr>
                                        <td>
                                            @if($beta_enter[0]->status=='WAITING') 
                                                <button class="btn btn-dark up"> > ສົ່ງເອກະສານໄປລະບຸສາຍທາງ </button>
                                            @elseif($beta_enter[0]->status=='SIGNINED')
                                                <button class="btn btn-dark upcom"> > ສົ່ງເອກະສານໃຫ້ບໍລິສັດ </button>
                                            @else
                                                 
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @if($beta_enter[0]->status=='POINTING')
                                                <button  class="btn btn-danger down"> < ດຶງເອກະສານກັບ ຈາກລະບຸສາຍທາງ</button> 
                                            @elseif($beta_enter[0]->status=='SIGNINED')
                                                <button  class="btn btn-danger down5"> < ຕີເອກະສານກັບ ໄປຂັ້ນຕອນເຊັນ</button> 
                                            @else
                                                 
                                            @endif
                                        </td>
                                    </tr>
                                </table> 
                            @endif

                            @if(auth()->user()->is_admin=='3')
                                <table class="" width="100%">
                                    <tr>
                                        <td>
                                            @if($beta_enter[0]->status=='POINTING') 
                                                <button class="btn btn-dark pointing"> > ສົ່ງເອກະສານໄປລໍຖ້າເຊັນ </button>
                                            @else
                                                
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @if($beta_enter[0]->status=='POINTING')
                                                <button  class="btn btn-danger down2"> < ຕີກັບເອກະສານກັບ</button>  
                                            @elseif($beta_enter[0]->status=='SIGNING') 
                                                <button  class="btn btn-danger down3"> < ດຶງເອກະສານກັບ ຈາກການເຊັນ</button>  
                                            @else
                                            @endif
                                            
                                        </td>
                                    </tr>
                                </table> 
                            @endif

                            @if(auth()->user()->is_admin=='4')
                                <table class="" width="100%">
                                        <tr>
                                            <td>
                                                @if($beta_enter[0]->status=='SIGNING') 
                                                    <button class="btn btn-dark sign"> > ເຊັນເອກະສານ </button>
                                                @else
                                                    
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if($beta_enter[0]->status=='SIGNING')
                                                    <button  class="btn btn-danger down4"> < ຕີກັບເອກະສານກັບ</button>   
                                                @elseif($beta_enter[0]->status=='SIGNINED')
                                                <button  class="btn btn-danger down5"> < ຍົກເລີກເຊັນ</button>   
                                                @else
                                                @endif
                                                
                                            </td>
                                        </tr>
                                </table> 
                            @endif
                        </div>
                    </div> 
                        
                    </div>

                    <div class="mt-8 text-2xl">
                        <!-- ::R -->
                    </div>

                    <div class="mt-6 text-gray-500">
                         
                    </div>
                </div>

                @if(auth()->user()->is_admin=='5')
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                                <path
                                    d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z">
                                </path>
                            </svg>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                
                                @if($beta_enter[0]->status=='WAITING')
                                    <a href="#" class="up">ສົ່ງເອກະສານໄປລະບຸປາຍທາງ</a>
                                @elseif($beta_enter[0]->status=='POINTING')
                                    ສົ່ງເອກະສານກຳລັງລະບຸປາຍທາງ
                                @else
                                    ສົ່ງເອກະສານໄປເຊັນລະບຸປາຍທາງ 
                                @endif
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
 
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                                <path
                                 d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z">
                                </path> 
                            </svg>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                @if($beta_enter[0]->status=='POINTING')
                                    <a href="#" class="down">ດຶງເອກະສານກັບ ຈາກລະບຸປາຍທາງ</a> 
                                @else
                                    ດຶງເອກະສານກັບ 
                                @endif
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
 
                        </div>
                    </div>  
                </div>
                @endif

                @if(auth()->user()->is_admin=='3' OR auth()->user()->is_admin=='5')
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                                <path
                                    d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z">
                                </path>
                            </svg>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                
                              
                                @if($beta_enter[0]->status=='POINTING') 
                                    <a href="#" class="pointing">ປະເພດລົດ</a> :
                                    <select  id="main_road">
                                        @foreach ($beta_main_road as $row)
                                            <option value="{{ $row->main_road_id }}">{{ $row->main_road_name }}</option>  
                                        @endforeach
                                    </select>
                                @else
                                ປະເພດລົດ :
                                    <select  id="main_road">
                                        @foreach ($beta_main_road as $row)
                                            <option value="{{ $row->main_road_id }}" disabled="true">{{ $row->main_road_name }}</option>  
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
 
                        </div>
                    </div>
                    

                    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                                <path
                                 d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z">
                                </path> 
                            </svg>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"> 
                                @if($beta_enter[0]->status=='POINTING')
                                    <a href="#" class="down2">ຕີກັບເອກະສານ</a> :
                                    <input type="text" id="pointing_log" placeholder="ສາເຫດທີ່ຕີກັບ">
                                @elseif($beta_enter[0]->status=='SIGNING') 
                                    <a href="#" class="down3">ດຶງເອກະສານກັບ ຈາກການເຊັນ</a>
                                @else
                                    ຕີກັບເອກະສານ / ດືງເອກະສານກັບຈາກການເຊັນ
                                @endif
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div> 
                        </div>
                    </div>  
                </div>

                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-1 ">
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                                <path
                                    d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z">
                                </path>
                            </svg>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                 
                                @if($beta_enter[0]->status=='POINTING') 
                                    <a href="#" id="">ລະບຸສາຍທາງ</a> : <label class="display_road_tails"></label>
                                    <form id="form_pointing">
                                        @foreach ($beta_road_select as $row)
                                            <p><input type="checkbox" id="check{{ $row->road_id }}" name="checkbox_name" value="{{ $row->road_id }}" data-name="{{ $row->road_name }}"> : <label for="check{{ $row->road_id }}">{{ $row->road_name }}</label></p>
                                        @endforeach
                                    </form>    
                                  
                                @else
                                ລະບຸສາຍທາງ : 
                                     @foreach ($beta_road_select as $row)
                                            <p><input type="checkbox" id="check{{ $row->road_id }}" name="checkbox_name" value="{{ $row->road_id }}" disabled="true" style="color:#54668e"> : <label for="check{{ $row->road_id }}">{{ $row->road_name }}</label></p>
                                        @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
 
                        </div>
                    </div>
                    

                    
                </div>
                @endif

                @if(auth()->user()->is_admin=='4' OR auth()->user()->is_admin=='5')
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center">
                            @if(auth()->user()->is_admin=='5')
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                                <path
                                    d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z">
                                </path>
                            </svg>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                
                                @if($beta_enter[0]->status=='SIGNING') 
                                    <a href="#" class="sign">ເຊັນເອກະສານ</a>  
                                @else
                                    ເຊັນເອກະສານ 
                                @endif
                            </div>
                            @endif
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
 
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                                <path
                                 d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z">
                                </path> 
                            </svg>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"> 
                                @if($beta_enter[0]->status=='SIGNING')
                                    <a href="#" class="down4">ຕີກັບເອກະສານ</a> :
                                    <input type="text" id="signing_log" placeholder="ສາເຫດທີ່ຕີກັບ"> 
                                @else
                                    ຕີກັບເອກະສານ
                                @endif
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div> 
                        </div>
                    </div>  
                </div>
                @endif



                @if(auth()->user()->is_admin=='4' OR auth()->user()->is_admin=='5')
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center">
                            @if(auth()->user()->is_admin=='5')
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                                <path
                                    d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z">
                                </path>
                            </svg>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                
                                @if($beta_enter[0]->status=='SIGNINED') 
                                    <a href="#" class="upcom">ສົ່ງເອກະສານໃຫ້ບໍລິສັດ</a>  
                                @else
                                ສົ່ງເອກະສານໃຫ້ບໍລິສັດ
                                @endif
                            </div>
                            @endif
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
 
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                                <path
                                 d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z">
                                </path> 
                            </svg>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"> 
                                @if($beta_enter[0]->status=='SIGNINED')
                                    <a href="#" class="down5">ຕີກັບເອກະສານ</a> : 
                                @else
                                ຕີກັບເອກະສານ
                                @endif
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div> 
                        </div>
                    </div>  
                </div>
                @endif


                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2" >
                    <div class="p-6">
                        <div class="flex items-center">
                            <!-- <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg> -->
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a
                                    href="#">
                                    <!-- ເພີ່ມຄຳຄິດເຫັນໃຫ້ເອກະສານ -->
                                </a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
 
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>

                            </svg>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold text-danger">
                                @if($beta_enter[0]->status!='CANCEL')
                                    <a href="#" id="cancel" class="text-danger">ຍົກເລີກເອກະສານ</a> :
                                    <input type="text" id="cancel_log" placeholder="ສາເຫດທີ່ຍົກເລີກ">
                                @else
                                    <a href="#" id="reroll" class="text-danger">ດືງເອກະສານກັບຈາກຍົກເລີກໄປສູ່ລໍຖ້າ</a>
                                @endif
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
   <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    
<script>

$('.up').on('click', function (e) { 
        e.preventDefault();  
        var data = {
                        "id" : {{$id}}, 
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
                            console.log(response.message)
                            // let msg = 'ສຳເລັດ' + response.message;
                            // showAlert(msg) 
                            window.location.reload(); 
                        },
                        complete: function() {
                            // me.data('requestRunning', false);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            if(errorThrown=='Payload Too Large')
                            {  
                                return false;
                            }
                        }
                    })
        
       
    });



    $('.down').on('click', function (e) { 
        e.preventDefault();  
        var data = {
                        "id" : {{$id}}, 
                    }

 
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
                            console.log(response.message)
                            // let msg = 'ສຳເລັດ' + response.message;
                            
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
    });




    $('.down2').on('click', function (e) { 
        e.preventDefault();  
        if($('#pointing_log').val()=='')
        {
            msg = "ກະລຸນາລະບຸສາເຫດ ເພື່ອໃຫ້ເຈົ້າໜ້າທີ່ກ່ອນໜ້າຮັບຮູ້";
            showAlert(msg);
            return false
        }
        var data = {
                        "id" : {{$id}}, 
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
                            console.log(response.message)
                            // let msg = 'ສຳເລັດ' + response.message;
                            
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
    });



    $('.down3').on('click', function (e) { 
        e.preventDefault();  
        var data = {
                        "id" : {{$id}}, 
                    }

 
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
                            console.log(response.message)
                            // let msg = 'ສຳເລັດ' + response.message;
                            
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
    });


    $('.down4').on('click', function (e) { 
        e.preventDefault();  
        if($('#signing_log').val()=='')
        {
            msg = "ກະລຸນາລະບຸສາເຫດ ເພື່ອໃຫ້ເຈົ້າໜ້າທີ່ກ່ອນໜ້າຮັບຮູ້";
            showAlert(msg);
            return false
        }
        var data = {
                        "id" : {{$id}}, 
                        "log" : $('#signing_log').val(),
                    }

 
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
                            console.log(response.message)
                            // let msg = 'ສຳເລັດ' + response.message;
                            
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
    });


    $('.down5').on('click', function (e) { 
        e.preventDefault();   
        var data = {
                        "id" : {{$id}}, 
                    }

 
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
                            console.log(response.message)
                            // let msg = 'ສຳເລັດ' + response.message;
                            
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
    });

    let checkedValues = [];
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

    $('.pointing').on('click', function (e) {  
        e.preventDefault();   

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
                        "id" : {{$id}}, 
                        "main_road" : $('#main_road').val(),
                        "formdata" : checkedValues
                    }

        
                        // $('input[name="checkbox_name"]').val(formdata);
         
        

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
                            console.log(response.message)
                            // let msg = 'ສຳເລັດ' + response.message;
                            
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
    });

    $('#cancel').on('click', function (e) { 
        e.preventDefault();  
        if($('#cancel_log').val()=='')
        {
            msg = "ກະລຸນາລະບຸສາເຫດ ທີ່ຍົກເລີກ";
            showAlert(msg);
            return false
        }
        var data = {
                        "id" : {{$id}}, 
                        "log" : $('#cancel_log').val(),
                    }

 
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
                            console.log(response.message)
                            // let msg = 'ສຳເລັດ' + response.message;
                            
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
        
       
    });



    $('#reroll').on('click', function (e) { 
        e.preventDefault();  
        var data = {
                        "id" : {{$id}},  
                    }

 
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
                            console.log(response.message)
                            // let msg = 'ສຳເລັດ' + response.message;
                            
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
        
       
    });



$('.sign').on('click', function (e) { 
        e.preventDefault();  
        var data = {
                        "id" : {{$id}}, 
                    }

 
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
                            console.log(response.message)
                            // let msg = 'ສຳເລັດ' + response.message;
                            // showAlert(msg) 
                            window.location.reload(); 
                        },
                        complete: function() {
                            // me.data('requestRunning', false);
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

$('.upcom').on('click', function (e) { 
        e.preventDefault();  
        var data = {
                        "id" : {{$id}}, 
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
                            console.log(response.message)
                            // let msg = 'ສຳເລັດ' + response.message;
                            // showAlert(msg) 
                            window.location.reload(); 
                        },
                        complete: function() {
                            // me.data('requestRunning', false);
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


    @if($beta_enter[0]->status=='POINTING' || $beta_enter[0]->status=='SIGNING') 
        @foreach ($beta_enter_road_detail as $row) 
         
            $('#check{{$row->road_id}}').prop("checked", true);
            $('#check{{$row->road_id}}').trigger("change"); 
        @endforeach
    @endif
  });


  document.getElementById("waiting").style.width = "{{ $progress_bar_percent }}"; 

@if($beta_enter[0]->status=='POINTING' || $beta_enter[0]->status=='SIGNING') 
  @if(auth()->user()->is_admin=='5' || auth()->user()->is_admin=='3')
    SelectElement('main_road', {{ $beta_enter[0]->main_road_id }}); 

function SelectElement(id, valueToSelect)
{    
    var element = document.getElementById(id);
    element.value = valueToSelect;
}

@endif
@endif

 
</script>
</x-app-layout>
