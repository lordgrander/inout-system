<x-app-layout>
<style>
         .seeprint
         {
             display:none;
         }
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
            font-size:14px !important;
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
            font-family: phetsarath,"Times New Roman", Times, serif!important;
                padding-left:30px!important;
                padding-right:30px!important;
        }
            .h
            {
                font-family: phetsarath,roboto!important;
            }

            .sub_td
            {
                text-align: center!important;
                line-height: 20px!important;
            }
            .sub-line
            {
                margin-top:-20px!important; 
            }
        @media print {

            .seeprint
            {
                display:block;
            }
            .noprint {
                display: none;
            }

            .tablex {
                border: 0.90px solid black;
            }
            .print
            {
                magin-top:-1550px!important;
                padding-left:25px!important;
                padding-right:25px!important;
                font-family: phetsarath,"Times New Roman", Times, serif!important;
            }

            p {
                line-height:  1.5;
                margin:0px
            }

            .sub-line
            {
                margin-top:-20px!important; 
            }

            .x10
            {
                font-size:11px !important;
            }
            .x11
            {
                font-size:14px !important;
            }

            .x12
            {
                font-size:12px !important;
            }

            .x13
            {
                font-size:17px !important;
            }

            .x14
            {
                font-size:14px !important;
            }
            .h
            {
                font-family: phetsarath,roboto!important;
                font-weight:bold;
            }
            .sub_td
            {
                text-align: center!important;
                line-height: 20px!important;
            }
            .red
            {
                color:red;
            }
        }  
        p {
            line-height:  1.5;
            margin:0px;
        }

        .head_border
        {
            border:solid 1.5px black;
            border-radius:5px;
            padding: 5px 15px 5px 15px;
            margin-bottom:10px;
        }
        
    </style> 
    <div  id="content" class="print "> 
    <button onclick="printContent();" class="btn btn-dark noprint">Print</button>
    <div class="seeprint">
        <br>
        <center>
            <p><img src="{{ asset('/image/Emblem_of_Laos.png') }}" alt="" width="10.1%"></p>
             
        <p class="x11 xbold"><b>ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ</b></p>
        <p class="x11 xbold"><b>ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນະຖາວອນ</b></p>
        </center>
        <table width="100%">
            <tr>
                <td>
                    <p class="x11">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ນະຄອນຫຼວງວຽງຈັນ</p>
                    <p class="x11">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ຄະນະຄຸ້ມຄອງດ່ານສາກົນສິນຄ້າທ່າບົກທ່ານາແລ້ງ</p>
                    <p class="x11">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ຫ້ອງການບໍລິຫານ</p>
                    <p>&nbsp;</p>
                </td>
                <td style="text-align:right;">
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p class="x11">ເລກທີ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; @if($beta_enter[0]->enter_number) <label class="red"> {{ $beta_enter[0]->enter_number }} </label> @endif @if($beta_enter[0]->status=='SUCCESS' || $beta_enter[0]->status=='SIGNINED')   @endif/ ບຫ.ຄທບ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                    <p class="x11">ນະຄອນຫຼວງວຽງຈັນ,ວັນທີ  <label class="red">{{ date('d-m-Y',strtotime($beta_enter[0]->date_sign)) }}</label>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <center>
                        <label class="x13 h head_border">ໃບອະນຸຍາດຕິດຕາມການແລ່ນລົດບັນທຸກຂົນສົ່ງສິນຄ້າ</label>
                        
                    </center> 
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding-left:12%;">
                    <p class="x11">- ອີງຕາມ ດຳລັດວ່າດ້ວຍທ່າບົກ ສະບັບເລກທີ 513/ລບ ລົງວັນທີ 04 ສິງຫາ 2021; </p>
                    <p class="x11">- ອີງຕາມ ຂໍ້ຕົກລົງຂອງທ່ານເຈົ້າຄອງ ນະຄອນຫຼວງວຽງຈັນ ສະບັບເລກທີ 978/ຈນວ ລົງວັນທີ 09 ທັນວາ 2021;</p>
                    <p class="x11">- ອີງຕາມ ແຈ້ງການຂອງຫ້ອງການກະຊວງ ຍທຂ ສະບັບເລກທີ 04718/ຍທຂ.ຫກ ລົງວັນທີ 23 ກຸມພາ 2022 </p>
                    <p class="x11">&nbsp;&nbsp;ແລະ ອີງຕາມ ແຈ້ງການຂອງພະແນກ ຍທຂ.ນວ ສະບັບເລກທີ 2192/ຍທຂ.ນວ ລົງວັນທີ 23 ມີນາ 2022.</p>
                </td>
            </tr>
        </table>
        <div   style="padding-left:5%;padding-right:10%;">
                <div class="sub-line">&nbsp;</div>
                    @php($ld = 0)
                    @foreach ($beta_enter_detail as $row)  
                    @php($ld++)
                    @endforeach 
                    <div style="margin-top:2px;"></div>
                    <p class="x11">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ຫ້ອງການບໍລິຫານ ດ່ານສາກົນສິນຄ້າ ທ່າບົກທ່ານາແລ້ງ ອະນຸຍາດ ໃຫ້ລົດຂົນສົ່ງສິນຄ້າເຂົ້າໄປຮອດປາຍທາງໄດ້</b></p>
                    <p class="x11"><b>  ຂອງທ່ານ : {{ $com_owner_name }}, ບໍລິສັດ {{ $com_name }}, ມີຈຳນວນ :  {{ $ld++}} ຄັນ ດັ່ງມີລາຍລະອຽດລຸ່ມນີ້.</b></p> 
                    <p class="x11">1.	ຂໍ້ມູນຂອງລົດບັນທຸກຂົນສົ່ງສິນຄ້າ, ຜູ້ຂັບລົດ ແລະ ເສັ້ນທາງການແລ່ນລົດ :</p>  
        </div>
        
                    <table class="table tablex table-bordered x10" id="myTable">
                        <tr>
                            <td class="td x10 sub_td" width="6%"><b>ລ/ດ</b></td>
                            <td class="td x10 sub_td"><b>ໜາຍເລກທະບຽນລົດ</b></td>
                            <td class="td x10 sub_td"><b>ລາຍຊື່ຜູ້ຂັບລົດ</b></td>
                            <td class="td x10 sub_td"><b>ປະເພດລົດ</b></td>
                            <td class="td x10 sub_td"><b>ເລກທີນຳເຂົ້າສີນຄ້າ</b></td>
                            <td class="td x10 sub_td"><b>ປະເພດສິນຄ້າ</b></td>
                            <td class="td x10 sub_td"><b>ນໍ້າໜັກລວມທີ່ບັນທຸກ Kg</b></td> 
                        </tr> 
                        @php($ld = 1)
                        @php($remem = 1)
                        @foreach ($beta_enter_detail as $row)  
                        <tr>
                            <td class="td x10 text-center">{{ $ld++}}  </td>
                            <td class="td x10">{{ $row->plate_number }}</td> 
                            <td class="td x10">{{ $row->d_name }}</td> 
                            <td class="td x10">{{ $row->t_type_name }}</td> 
                            <td class="td x10">{{ $row->detail }}</td>
                            <td class="td x10">{{ $row->p_import }}</td> 
                            @if($row->weight)
                            <td class="td x10">{{ number_format(preg_replace('/\D/', '', $row->weight)) }}</td>   
                            @else
                            <td class="td x10">{{  $row->weight }}</td>   
                            @endif
                            @if($remem==1) 
                            @php($remem = 0) 
                            @endif

                        </tr>
                        @endforeach
                        @if($ld<5)
                            @for($i=$ld;$i<=5;$i++) 
                                <tr>
                                    <td class="td x10">&nbsp;</td> 
                                    <td class="td x10">&nbsp;</td>  
                                    <td class="td x10">&nbsp;</td>  
                                    <td class="td x10">&nbsp;</td>  
                                    <td class="td x10">&nbsp;</td>  
                                    <td class="td x10">&nbsp;</td>     
                                    <td class="td x10">&nbsp;</td>     
                                </tr>
                            @endfor
                        @elseif($ld==5)
                                <tr>
                                    <td class="td x10">&nbsp;</td> 
                                    <td class="td x10">&nbsp;</td>  
                                    <td class="td x10">&nbsp;</td>  
                                    <td class="td x10">&nbsp;</td>  
                                    <td class="td x10">&nbsp;</td>  
                                    <td class="td x10">&nbsp;</td>     
                                    <td class="td x10">&nbsp;</td>     
                                </tr>
                        @endif 
                    <tr> 
                                <td class="td x10 " colspan="7">ໝາຍເຫດ : @if($beta_enter[0]->feed_back_msg)<label class="red">{{ $beta_enter[0]->feed_back_msg }}</label>@endif</td>  
                            </tr>
                    </table>
            <div   style="padding-left:5%;padding-right:10%;">
                    <p class="x11">2.	ຕົ້ນທາງອອກຈາກ: ດ່ານສາກົນສີນຄ້າທ່າບົກທ່ານາແລ້ງ.</p>
                    <p class="x11">3.	ກຳນົດເສັ້ນທາງການແລ່ນລົດ 
                        @foreach ($beta_enter_road_detail as $row)
                            {{ $row->road_name }},
                        @endforeach
                    </p>
                    <p class="x11">4.	ປາຍທາງ ບ້ານ {{ str_replace('ບ້ານ','',$beta_enter[0]->address) }} ເມືອງ {{ str_replace('ເມືອງ','',$beta_enter[0]->district) }} ແຂວງ {{ str_replace('ແຂວງ','',$beta_enter[0]->province) }}</p>
                    <p class="x11">5.	ເສັ້ນທາງກັບຄືນ: ກັບເສັ້ນທາງເດີມທີ່ໄດ້ອະນຸຍາດໃຫ້ເຂົ້າໄປ.</p>
                    <p class="x11">6.	ວັນທີເຂົ້າ : {{ date('d-m-Y',strtotime($beta_enter[0]->date_in)) }} ວັນທີອອກ : {{ date('d-m-Y',strtotime($beta_enter[0]->date_out)) }},ຂາອອກ ດ່ານສາກົນສີນຄ້າທ່າບົກທ່ານາແລ້ງ.</p>
                    <p class="x11">7.	ລົດທຸກຄັນໃຫ້ຕິດເຄື່ອງເອເລັກໂຕນິກ E-LOCK ( ຍົກເວັ້ນລົດນໍ້າມັນເຊື້ອໄຟ, ທາດລະເບີດ, ສານເຄມີທີ່ອັນຕະລາຍ </p>
                    <p class="x11">     ແລະ ລົດປູນເຕົ້າ ).</p>
                    <p class="x11">8.	ໝາຍເຫດ: ຂໍ້ກຳນົດໃນການຈັດຕັ້ງປະຕິບັດ ແລະ ມາດຕະການຕໍ່ຜູ້ລະເມີດ ມີເນື້ອໃນລະອຽດຢູ່ດ້ານຫຼັງ</p>
                    <div class="sub-line">&nbsp;</div>
                    <center><p class="x11">ດັ່ງນັ້ນ; ຈຶ່ງອອກໃບອະນຸຍາດສະບັບນີ້ ເພື່ອຕິດຕາມການແລ່ນລົດບັນທຸກຂົນສົ່ງສິນຄ້າ.</p></center>
            </div>  
        
        <div  style="padding-left:5%;padding-right:20%;text-align:right;">
        <div class="sub-line">&nbsp;</div>
                    <p class="x14"> <b>ຫົວໜ້າຫ້ອງການບໍລິຫານ </b> &nbsp;&nbsp;&nbsp;&nbsp;</p>
                    @if($beta_enter[0]->sign_url)
                    <img src="{{ asset($beta_enter[0]->sign_url) }} "  style="width:25%;float:right;">
                    @endif
                    <br>
                    &nbsp;
                </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script>
     $(document).ready(function () { 
    printContent()
    });
    
    function printContent() {
        var table = document.getElementById("myTable");
        table.style.border = "1px solid black";
        window.print();
        table.style.border = "";
        
        setTimeout(function () {
            window.close();
        }, 1000); // 3000 milliseconds = 3 seconds
    }

   
</script>
</x-app-layout>