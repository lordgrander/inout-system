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
                                                                @if($row_enter->status=='SIGNINED' || $row_enter->status=='READY' || $row_enter->status=='SUCCESS') 
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