<x-app-layout>
    <link  rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <style>
         
         .table_display_data
        {  
            overflow-x: auto!important;
            /* overflow: auto!important; */
            white-space: nowrap!important; 
        }
        .x10
        {
            font-size:10px !important;
        }
        .x11
        {
            font-size:11px !important;
        }

        .x12
        {
            font-size:12px !important;
        }

        .x13
        {
            font-size:13px !important;
        }

        .x14
        {
            font-size:14px !important;
        }

        .xbold
        {
            font-weight:bold;
        }
        .out-plate
        {
            
            background: #ffffff;
            border-radius:5px;
            padding:8px;
            -webkit-user-select: none; /* Chrome, Safari */
            -moz-user-select: none; /* Firefox */
            -ms-user-select: none; /* Internet Explorer */
            user-select: none; /* Standard syntax */
            cursor:pointer;
        }

        .plate
        {
            border:solid black 1px;
            border-radius:5px;
            padding: 3px;
            position:inline;
            background: #f3ca00; 
        }

        .tablex {
            border-collapse: collapse;
        }

        .td {
            border: 1px solid black;
        } 

        .print
        {
            magin-top:-1550px!important;
        }

        @media print {
            .noprint {
                display: none;
            }

            .tablex {
                border: 1px solid black;
            }
            .print
            {
                magin-top:-1550px!important;
            }
        }   

        svg{
            display:inline;
        }
        
    </style> 
    <x-slot name="header" class="noprint"> 
        <table class="laob">
            <tr>
                <td>
                    <!-- <a href="{{ url("/see/enter/list/view/edit/".$id) }}" style="color:black;text-decoration:none;">ຈັດການເອກະສານ</a> 
                    &nbsp;&nbsp;&nbsp; -->
                    <a href="{{ url("/see/enter/list/view/log/".$id) }}"  style="color:black;text-decoration:none;">ປະຫວັດການເຄື່ອນໄຫວຂອງເອກະສານ</a>
                </td>
                <td>
                    
                </td>
            </tr>
        </table>
        
        
    </x-slot>
    <div class="py-12 laos">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-1 ">
                   
                    <div class="p-6">
                        <div class="  items-center"> 
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                <p class="noprint">ລາຍການອອກລົດຂອງ : {{ $user_data[0]->name }} /  {{ $com_name }}</p> 
                                <div class="table_display_data ">
                                <table class="table table-bordered laos noprint">
                                    <tbody>
                                        
                                        <tr>
                                            <td width="10%">ເລກທີ່</td>
                                            
                                            <td>{{ $beta_enter[0]->enter_number }}</td>
                                        </tr>
                                        <tr>
                                            <td width="10%">ປາຍທາງ</td>
                                            
                                            <td>ບ້ານ {{ str_replace('ບ້ານ','',$beta_enter[0]->address) }} ເມືອງ {{ str_replace('ເມືອງ','',$beta_enter[0]->district) }} ແຂວງ {{ str_replace('ແຂວງ','',$beta_enter[0]->province) }}</td>
                                        </tr>
                                        <tr>
                                            <td width="10%">ປາຍທາງອື່ນໆ</td>
                                            
                                            <td>{{ $beta_enter[0]->lasttails }}</td>
                                        </tr>
                                        <tr>
                                            <td width="10%">ວັນທີ່ສ້າງເອກະສານ</td>
                                            
                                            <td>{{ date('d-m-Y',strtotime($beta_enter[0]->date_make)) }}</td>
                                        </tr>
                                        <tr>
                                            <td width="10%">ລົດເຂົ້າ</td>
                                            
                                            <td>{{ date('d-m-Y',strtotime($beta_enter[0]->date_in)) }}</td>
                                        </tr> 
                                        <tr>
                                            <td width="10%">ລົດອອກ</td>
                                            
                                            <td>{{ date('d-m-Y',strtotime($beta_enter[0]->date_out)) }}</td>
                                        </tr>
                                        <tr>
                                            <td width="10%">ສະຖານະ</td>
                                            
                                            <td> 

                                                @if($beta_enter[0]->status=="WAITING")  
                                                            <badge class="badge btn-warning">ລໍຖ້າກວດ</badge>
                                                        @elseif($beta_enter[0]->status=="POINTING")  
                                                            <badge class="badge btn-primary">ຖ້າລະບຸເສັ້ນທາງ</badge>
                                                        @elseif($beta_enter[0]->status=="SIGNING")  
                                                            <badge class="badge btn-warning">ຖ້າເຊັນ</badge>
                                                        @elseif($beta_enter[0]->status=="SIGNINED") 
                                                            <badge class="badge btn-primary">ເຊັນແລ້ວ</badge>
                                                        @elseif($beta_enter[0]->status=="SUCCESS") 
                                                            <badge class="badge btn-success">ສຳເລັດ</badge>
                                                        @elseif($beta_enter[0]->status=="CANCEL")  
                                                            <badge class="badge btn-danger">ຍົກເລີກ</badge> 
                                                        @else
                                                            ບໍ່ມີສະຖານະ
                                                        @endif 
                                            </td>
                                        </tr>

                                        <tr>
                                            <td width="10%">ເອກະສານແນບ </td>
                                            <td>
                                            <!-- <a href="#" onclick="printContent();" >
                                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2" viewBox="0 0 24 24" class="w-8 h-5 text-gray-400">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                                                    </svg>
                                                                    </a> -->
                                                                    @php($file_count=1)
                                                @foreach ($beta_enter_file as $row)
                                                    <a href="{{ asset($row->file_url)}}" target="_BLANK">
                                                        ເອກະສານແນບ {{ $file_count++ }}
                                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                                                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-5 ">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                                                </svg>  
                                                    </a>
                                                    |
                                                @endforeach
                                            </td>
                                        </tr>
                                        @if($beta_enter[0]->status=="CANCEL")  
                                        <tr>
                                            <td>
                                                ສາເຫດທີ່ຖືກຍົກເລີກ
                                            </td>
                                            <td>
                                                {{ $beta_enter[0]->cancel_log }}
                                            </td>
                                        </tr>
                                        @endif 
                                    </tbody>
                                </table>
                                 
                                <table class="table table-bordered noprint">
                                    <thead>
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                - <u> ຂໍ້ມູນລົດ </u> :
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>ທະບຽນລົດ</td>
                                            <td>ຊື່ຄົນຂັບ</td>
                                            <td>ປະເພດລົດ</td>
                                            <td>ປະເພດສິນຄ້າ</td>
                                            <td>ນ້ຳໜັກ</td>
                                            <td>ລາຍລະອຽດ</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($count_list=1)
                                        @foreach ($beta_enter_detail as $row) 
                                        @php($count_list++)
                                        <tr>
                                            <td class="text-center"> {{ $row->plate_number }} </td> 
                                            <td>{{ $row->d_name }}</td> 
                                            <td>{{ $row->t_type_name }}</td> 
                                            <td>{{ $row->p_import }}</td> 
                                            <td>{{ $row->weight }}</td> 
                                            <td>{{ $row->detail }}</td> 
                                        </tr>
                                        @endforeach 
                                    </tbody>
                                </table>

                                <div id="content" class="print" style="display:none;"> 
                                    <br>
                                    <center>
                                    <p class="x11 xbold">ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ</p>
                                    <p class="x11 xbold">ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນະຖາວອນ</p>
                                    </center>
                                    <table width="100%">
                                        <tr>
                                            <td>
                                                <p class="x11">ນະຄອນຫຼວງວຽງຈັນ</p>
                                                <p class="x11">ຄະນະຄຸ້ມຄອງດ່ານສາກົນສິນຄ້າທ່າບົກທ່ານາແລ້ງ</p>
                                                <p class="x11">ຫ້ອງການບໍລິຫານ</p>
                                                <p>&nbsp;</p>
                                            </td>
                                            <td style="text-align:right;">
                                                <p>&nbsp;</p>
                                                <p>&nbsp;</p>
                                                <p class="x11">ເລກທີ @if($beta_enter[0]->status=='SUCCESS' || $beta_enter[0]->status=='SIGNINED') {{ $beta_enter[0]->enter_number }} @endif/ ບຫ.ຄທບ</p>
                                                <p class="x11">ນະຄອນຫຼວງວຽງຈັນ,ວັນທີ @if($beta_enter[0]->status=='SUCCESS' || $beta_enter[0]->status=='SIGNINED') {{ date('d-m-Y',strtotime($beta_enter[0]->date_sign)) }} @endif</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <center>
                                                    <p class="x13">ໃບອະນຸຍາດຕິດຕາມການແລ່ນລົດບັນທຸກຂົນສົ່ງສິນຄ້າ</p>
                                                </center> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding-left:15%;padding-right:15%">
                                                <p class="x11">-	ອີງຕາມ ດຳລັດວ່າດ້ວຍທ່າບົກ ສະບັບເລກທີ 513/ລບ ລົງວັນທີ 04 ສິງຫາ 2021; </p>
                                                <p class="x11">-	ອີງຕາມ ຂໍ້ຕົກລົງຂອງທ່ານເຈົ້າຄອງ ນະຄອນຫຼວງວຽງຈັນ ສະບັບເລກທີ 978/ຈນວ ລົງວັນທີ 09 ທັນວາ 2021;</p>
                                                <p class="x11">-	ອີງຕາມ ແຈ້ງການຂອງຫ້ອງການກະຊວງ ຍທຂ ສະບັບເລກທີ 04718/ຍທຂ.ຫກ ລົງວັນທີ 23 ກຸມພາ 2022 ແລະ ອີງຕາມ <br>
                                                    ແຈ້ງການຂອງພະແນກ ຍທຂ.ນວ ສະບັບເລກທີ 2192/ຍທຂ.ນວ ລົງວັນທີ 23 ມີນາ 2022.
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding-left:5%;padding-right:5%;">
                                                
                                                <p class="x11">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ຫ້ອງການບໍລິຫານດ່ານສາກົນສິນຄ້າທ່າບົກທ່ານາແລ້ງ ເຫັນດີອະນຸຍາດພາຫະນະຂົນສົ່ງສິນຄ້າຂອງ ທ່ານ : {{ $user_data[0]->name }}</p>
                                                <p class="x11">ບໍລິສັດ {{ $com_name }}, ມີຈຳນວນ : [ {{ $count_list }} ] ຄັນເຂົ້າໄປຮອດປາຍທາງໄດ້.</p>
                                                <br>
                                                <p class="x11">1.	ຂໍ້ມູນຂອງລົດບັນທຸກຂົນສົ່ງສິນຄ້າ, ຜູ້ຂັບລົດ ແລະ ເສັ້ນທາງການແລ່ນລົດ :</p>  

                                                <table class="table tablex table-bordered x10" id="myTable">
                                                    <tr>
                                                        <td class="td x10">ລ/ດ</td>
                                                        <td class="td x10">ໜາຍເລກທະບຽນລົດ</td>
                                                        <td class="td x10">ລາຍຊື່ຜູ້ຂັບລົດ</td>
                                                        <td class="td x10">ປະເພດລົດ</td>
                                                        <td class="td x10">ເລກທີນຳເຂົ້າສີນຄ້າ</td>
                                                        <td class="td x10">ປະເພດສິນຄ້າ</td>
                                                        <td class="td x10">ນໍ້າໜັກລວມທີ່ບັນທຸກ Kg</td>
                                                        <td class="td x10">ໝາຍເຫດ</td>
                                                    </tr> 
                                                    @php($ld = 1)
                                                    @foreach ($beta_enter_detail as $row)  
                                                    <tr>
                                                        <td class="td x10">{{ $ld++}}</td>
                                                        <td class="td x10">{{ $row->plate_number }}</td> 
                                                        <td class="td x10">{{ $row->d_name }}</td> 
                                                        <td class="td x10">{{ $row->t_type_name }}</td> 
                                                        <td class="td x10">{{ $row->detail }}</td>
                                                        <td class="td x10">{{ $row->p_import }}</td> 
                                                        <td class="td x10">{{ $row->weight }}</td> 
                                                        <td class="td x10"></td> 
                                                    </tr>
                                                    @endforeach
                                                    @if($ld<5)
                                                    @for($i=$ld;$i<=5;$i++) 
                                                        <tr>
                                                            <td class="td">&nbsp;</td> 
                                                            <td class="td">&nbsp;</td>  
                                                            <td class="td">&nbsp;</td>  
                                                            <td class="td">&nbsp;</td>  
                                                            <td class="td">&nbsp;</td>  
                                                            <td class="td">&nbsp;</td>  
                                                            <td class="td">&nbsp;</td>  
                                                            <td class="td">&nbsp;</td>  
                                                        </tr>
                                                    @endfor
                                                @endif
                                                </table>

                                                <p class="x11">2.	ຕົ້ນທາງອອກຈາກ: ດ່ານສາກົນສີນຄ້າທ່າບົກທ່ານາແລ້ງ.</p>
                                                <p class="x11">3.	ກຳນົດເສັ້ນທາງການແລ່ນລົດ 
                                                    @foreach ($beta_enter_road_detail as $row)
                                                        {{ $row->road_name }},
                                                    @endforeach
                                                </p>
                                                <p class="x11">4.	ປາຍທາງ ບ້ານ {{ str_replace('ບ້ານ','',$beta_enter[0]->address) }} ເມືອງ {{ str_replace('ເມືອງ','',$beta_enter[0]->district) }} ແຂວງ {{ str_replace('ແຂວງ','',$beta_enter[0]->province) }}</p>
                                                <p class="x11">5.	ເສັ້ນທາງກັບຄືນ: ກັບເສັ້ນທາງເດີມທີ່ໄດ້ອະນຸຍາດໃຫ້ເຂົ້າໄປ.</p>
                                                <p class="x11">6.	ວັນທີເຂົ້າ : {{ date('d-m-Y',strtotime($beta_enter[0]->date_in)) }} ວັນທີອອກ : {{ date('d-m-Y',strtotime($beta_enter[0]->date_out)) }},ຂາອອກ ດ່ານສາກົນສີນຄ້າທ່າບົກທ່ານາແລ້ງ.</p>
                                                <p class="x11">7.	ລົດທຸກຄັນໃຫ້ຕິດເຄື່ອງເອເລັກໂຕນິກ E-LOCK ( ຍົກເວັ້ນລົດນໍ້າມັນເຊື້ອໄຟ, ທາດລະເບີດ, ສານເຄມີທີ່ອັນຕະລາຍ ແລະ ລົດປູນເຕົ້າ ).</p>
                                                <p class="x11">8.	ໝາຍເຫດ: ຂໍ້ກຳນົດໃນການຈັດຕັ້ງປະຕິບັດ ແລະ ມາດຕະການຕໍ່ຜູ້ລະເມີດ ມີເນື້ອໃນລະອຽດຢູ່ດ້ານຫຼັງ</p>
                                                <center><p class="x11">ດັ່ງນັ້ນ; ຈຶ່ງອອກໃບອະນຸຍາດສະບັບນີ້ ເພື່ອຕິດຕາມການແລ່ນລົດບັນທຸກຂົນສົ່ງສິນຄ້າ.</p></center>
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding-left:5%;padding-right:15%;text-align:right;">
                                                <p class="x14"><u>ຫົວໜ້າຫ້ອງການບໍລິຫານ :</u>&nbsp;&nbsp;&nbsp;&nbsp;</p>
                                                 
                                                @if($beta_enter[0]->sign_url)
                                                <img src="{{ asset($beta_enter[0]->sign_url) }} "  style="width:20%;float:right;">
                                                @endif
                                                <br>
                                                &nbsp;
                                            </td>
                                        </tr>
                                    </table>
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
    
    function printContent() {
        var table = document.getElementById("myTable");
    table.style.border = "1px solid black";
    window.print();
    table.style.border = "";
}
</script>
</x-app-layout>
