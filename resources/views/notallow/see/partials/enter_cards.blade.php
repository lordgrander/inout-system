@foreach ($beta_enter as $row_enter)
                                        @php($get_product_list_for_option = '')

                                        <div class="p-3 mt-3 bg-white border rounded-xl shadow-sm row_fade{{ $row_enter->enter_id }}">

                                        {{-- Row 1: number + actions + status --}}
                                        <div class="d-flex justify-content-between gap-2">
                                            <div>
                                            <div class="text-sm font-semibold">ເລກທີ: {{ $row_enter->enter_number }}</div>
                                             <div class="text-xs text-gray-500">{{ date('d-m-Y / H:i:s',strtotime($row_enter->date_in)) }}</div>
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
                                            <div class="text-sm font-semibold d-flex justify-content-between">
                                                <div>ບໍລິສັດ</div>
                                                <div>{{ $row_enter->com_name }}</div>
                                            </div>
                                            <div class="text-xs text-gray-500 d-flex justify-content-between">
                                                <div>
                                                ຂໍ້ມູນລົດ
                                            </div>
                                            <div>{{ $row_enter->name}} • {{ $row_enter->email }}</div>
                                            </div>

                                            @if($row_enter->status=='CANCEL')
                                            <div class="text-danger mt-1">ສາເຫດ : {{ $row_enter->cancel_log }}</div>
                                            @endif
                                        </div>

                                        {{-- Row 3: Car info --}}
                                        <div class="mt-3"> 

                                            <div class="d-grid gap-2">
                                            @foreach ($beta_enter_detail as $row)
                                                @if($row->enter_id==$row_enter->enter_id)
                                                @php($get_product_list_for_option .= ''.$row->p_import.'<br>')

                                                <div class="p-2 rounded-lg border bg-gray-50 text-sm">
                                                    <div class="font-semibold d-flex justify-content-between">
                                                        <div>{{ $row->plate_number }}</div><div>{{ $row->d_name }}</div>
                                                    </div>
                                                    <div class="text-xs text-gray-600 d-flex justify-content-between">
                                                        <div> {{ $row->p_import }} • {{ $row->t_type_name }}</div> 
                                                        <div>{{ $row->weight }}</div>
                                                    </div>
                                                    @if($row->detail)
                                                        <div class="text-xs text-gray-500 mt-1 d-flex justify-content-end">{{ $row->detail }}</div>
                                                    @endif
                                                </div>
                                                @endif
                                            @endforeach
                                            </div>
                                        </div>

                                        {{-- Row 4: Route --}}
                                        <div class="mt-3">
                                            <div class="text-xs text-gray-500">ສາຍທາງ</div>
                                            <div class="text-sm">
                                                <u class="font-semibold">{{ $row_enter->main_road_name }}</u>
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
                                                <div class="text-xs text-gray-500">ປາຍທາງ</div>
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
                                            

                                            <div class="flex items-center gap-2" style="overflow-x:scroll;overflow-y:scroll;">
                                                {{-- Print --}}
                                                @if(auth()->user()->is_admin=='2' || auth()->user()->is_admin=='3' || auth()->user()->is_admin=='5')
                                                    @if($row_enter->status=='SIGNINED')
                                                        <a href="{{url('/see/enter/print/'.$row_enter->enter_id)}}" target="_BLANK" class="btn btn-light btn-sm">
                                                        <!-- Print -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" class="eva eva-printer-outline" fill="inherit"><g data-name="Layer 2"><g data-name="printer"><rect width="24" height="24" opacity="0"></rect><path d="M19.36 7H18V5a1.92 1.92 0 0 0-1.83-2H7.83A1.92 1.92 0 0 0 6 5v2H4.64A2.66 2.66 0 0 0 2 9.67v6.66A2.66 2.66 0 0 0 4.64 19h.86a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2h.86A2.66 2.66 0 0 0 22 16.33V9.67A2.66 2.66 0 0 0 19.36 7zM8 5h8v2H8zm-.5 14v-4h9v4zM20 16.33a.66.66 0 0 1-.64.67h-.86v-2a2 2 0 0 0-2-2h-9a2 2 0 0 0-2 2v2h-.86a.66.66 0 0 1-.64-.67V9.67A.66.66 0 0 1 4.64 9h14.72a.66.66 0 0 1 .64.67z"></path></g></g></svg>
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