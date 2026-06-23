<x-app-layout>
<style>
body,td{
color:black!important;
}
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

        .x15
        {
            font-size:15px !important;
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
                padding-left:{{ $left }}px!important;
                padding-right:{{ $right }}px!important;
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
                padding-left:{{ $left }}px!important;
                padding-right:{{ $right }}px!important;
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

            .x9
            {
                font-size:9px !important;
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
            .watermark {
              position: absolute;
              top: 39%;
              left: 50%;
              transform: translate(-50%, -20%); /* center horizontally, shift slightly upward */
              opacity: 0.1; /* make it faint */
              z-index: 1;
              pointer-events: none; /* so it doesn’t block text selection */
            }

            .watermark img {
              max-width: 450px; /* adjust size */
              height: auto;
            }


            .barcodemark {
              position: absolute;
              top: 5%;
              left: 88%;
              transform: translate(-50%, -20%); /* center horizontally, shift slightly upward */
             
              z-index: 1;
              pointer-events: none; /* so it doesn’t block text selection */
            }

            .barcodemark img {
              max-width: 350px; /* adjust size */
              height: auto;
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
        <!-- <div class="seeprint"> -->
        <div class="seeprint">
            <br>
            <center>
                <div class="watermark">
                    <img src="{{ asset('/image/45.png') }}" alt="Watermark Logo" style="">
                </div>
                <div class="barcodemark text-center">
                    @php($verifyUrl = url('verified/check/'.$beta_enter[0]->slug)) 
                    <div style="display:inline-block;text-align:center">
                        <img
                        src="https://quickchart.io/qr?text={{ urlencode($verifyUrl) }}&size=100&margin=1&ecLevel=M"
                        alt="Verify QR" width="100" height="100">
                    </div> 
                </div>
                <p><img src="{{ asset('/image/Emblem_of_Laos.png') }}" alt="" width="10.1%"></p>
         
                <p class="x11 xbold"><b>ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ</b></p>
                <p class="x11 xbold"><b>ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນະຖາວອນ</b></p>
            </center>
            <table width="100%">
                <tr>
                    <td>
                        <p class="x11">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ນະຄອນຫຼວງວຽງຈັນ</p>
                        <p class="x11">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ຄະນະຄຸ້ມຄອງດ່ານສາກົນຂົວມິດຕະພາບ 1</p>
                        <p class="x11">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ຈຸດບໍລິການ ທ່ານາແລ້ງ-ດົງໂພສີ</p>
                        <p>&nbsp;</p>
                    </td>
                    <td style="text-align:right;">
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p class="x11">ເລກທີ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; @if($beta_enter[0]->enter_number) <label class="red"> {{ $beta_enter[0]->enter_number }} </label> @endif @if($beta_enter[0]->status=='SUCCESS' || $beta_enter[0]->status=='SIGNINED')   @endif/ ດຂ1.ນວ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                        <p class="x11">ນະຄອນຫຼວງວຽງຈັນ,ວັນທີ  <label class="red">{{ date('d-m-Y',strtotime($beta_enter[0]->date_sign)) }}</label>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <center>
                            <label class="x13 h head_border"> ໃບອະນຸຍາດລົດບັນທຸກຂົນສົ່ງສິນຄ້າ ເຂົ້າ-ອອກຜ່ານດ່ານ</label> 
                        </center> 
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-left:12%;">
                        <p class="x11">- ອີງຕາມ ດຳລັດວ່າດ້ວຍດ່ານ ເຂົ້າ-ອອກ ສປປລາວ ສະບັບເລກທີ 643/ລບ,ລົງວັນທີ 25 ພະຈິກ 2024.</p>
                        <p class="x11">- ອີງຕາມ ຂໍ້ຕົກລົງຂອງທ່ານເຈົ້າຄອງ ນະຄອນຫຼວງວຽງຈັນ ວ່າດ້ວຍການ ຈັດຕັ້ງ ແລະ ເຄື່ອນໄຫວ ຂອງດ່ານສາກົນຂົວ &nbsp;&nbsp;ມິດຕະພາບ 1 ນະຄອນຫຼວງວຽງຈັນ (ສະບັບປັບປຸງ) ສະບັບເລກທີ 691/ຈນວ, ລົງວັນທີ 09 ກໍລະກົດ 2025.</p>
                        <!-- <p class="x11">- ອີງຕາມ ແຈ້ງການຫ້ອງວ່າປົກຄອງ ນະຄອນຫຼວງວຽງຈັນ ສະບັບເລກທີ 2337/ຫວ.ນວ,ລົງວັນທີ 30 ພະຈິກ 2022 ແລະ ແຈ້ງການສະບັບເລກທີ 659/ຫວ,ນວ,ລົງວັນທີ 12 ເມສາ 2023. </p> -->
                        <!--<p class="x11">- ອີງຕາມ ແຈ້ງການພະແນກ ຍທຂ.ນວ ສະບັບເລກທີ 4830/ຍທຂ.ນວ, ລົງວັນທີ 24/6/2025</p>-->
                        <!-- this -->
                    </td>
                </tr>
            </table>
            <div style="padding-left:5%;padding-right:10%;">
            <div class="sub-line">&nbsp;</div>
                @php($ld = 0)
                @foreach ($beta_enter_detail as $row)  
                @php($ld++)
                @endforeach 
                <div style="margin-top:2px;"></div>
                <p class="x11">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ຄະນະຄຸ້ມຄອງດ່ານສາກົນ ຂົວມິດຕະພາບ 1 ນະຄອນຫຼວງວຽງຈັນ (ຈຸດບໍລິການທ່ານາແລ້ງ-ດົງໂພສີ) ອອກອະນຸຍາດ ລົດບັນທຸກຂົນສົ່ງສິນຄ້າເຂົ້າ-ອອກຜ່ານດ່ານໃຫ້ແກ່</b><b>  ທ່ານ : {{ $com_owner_name }}, ບໍລິສັດ {{ $com_name }}, ຈຳນວນ :  {{ $ld++}} ຄັນ, ລະອຽດມີດັ່ງນີ້.</b></p>
                <p class="x11"></p> 
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
                        <td class="td x10">{{ $row->t_type_name }} @if($row->rounds!=1) ( {{ $row->rounds }} ຖ້ຽວ ) @endif</td> 
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
                <p class="x11">2.	ຕົ້ນທາງອອກຈາກ: ດ່ານສາກົນມິດຕະພາບ 1 ນະຄອນຫຼວງວຽງຈັນ ຈຸດບໍລິການທ່ານາແລ້ງ-ດົງໂພສີ.</p>
                <p class="x11" style="display:none;">
                    <!-- 3.	ກຳນົດເສັ້ນທາງການແລ່ນລົດ 
                    @foreach ($beta_enter_road_detail as $row)
                        {{ $row->road_name }},
                    @endforeach -->
                </p>
                <p class="x11">3.	ປາຍທາງ ບ້ານ {{ str_replace('ບ້ານ','',$beta_enter[0]->address) }} ເມືອງ {{ str_replace('ເມືອງ','',$beta_enter[0]->district) }} ແຂວງ {{ str_replace('ແຂວງ','',$beta_enter[0]->province) }}</p>
                <!-- <p class="x11">5.	ເສັ້ນທາງກັບຄືນ: ກັບເສັ້ນທາງເດີມທີ່ໄດ້ອະນຸຍາດໃຫ້ເຂົ້າໄປ.</p> -->
                <p class="x11">4.	ວັນທີເຂົ້າ : {{ date('d-m-Y',strtotime($beta_enter[0]->date_in)) }} ວັນທີອອກ : {{ date('d-m-Y',strtotime($beta_enter[0]->date_out)) }},ຂາອອກ ດ່ານສາກົນຂົວມິດຕະພາບ 1 ນະຄອນຫຼວງວຽງຈັນ ຈຸດບໍລີການທ່ານາແລ້ງ-ດົງໂພສີ.</p>
                <!-- <p class="x11">7.	ລົດທຸກຄັນໃຫ້ຕິດເຄື່ອງເອເລັກໂຕນິກ E-LOCK ( ຍົກເວັ້ນລົດນໍ້າມັນເຊື້ອໄຟ, ທາດລະເບີດ, ສານເຄມີທີ່ອັນຕະລາຍ </p> -->
                <!-- <p class="x11">     ແລະ ລົດປູນເຕົ້າ ).</p> -->
                <!-- <p class="x11">8.	ໝາຍເຫດ: ຂໍ້ກຳນົດໃນການຈັດຕັ້ງປະຕິບັດ ແລະ ມາດຕະການຕໍ່ຜູ້ລະເມີດ ມີເນື້ອໃນລະອຽດຢູ່ດ້ານຫຼັງ</p> -->
                <div class="sub-line">&nbsp;</div>
                <center><p class="x11"> ດັ່ງນັ້ນ; ຈຶ່ງອອກໃບອະນຸຍາດສະບັບນີ້ ເພື່ອຕິດຕາມລົດບັນທຸກຂົນສົ່ງສິນຄ້າເຂົ້າອອກຜ່ານດ່ານ.</p></center>
        </div>   
            <div class=" " >
                
                <div style=" padding-right:15%;text-align:right; "> 
                    <div class="sub-line">&nbsp;</div>
                        @if(auth()->user()->id=='738')
                            <p class="x14"> <b> &nbsp; ຄະນະຄຸ້ມຄອງດ່ານສາກົນຂົວມິດຕະພາບ 1 </b> </p>
                        @else
                            @if($beta_enter[0]->boss_id=='1')
                                <p class="x14"> <b> &nbsp; <label > ຊທ </label>  ຫົວໜ້າຫ້ອງການບໍລິຫານ </b> </p> 
                            @elseif($beta_enter[0]->boss_id=='13')
                                <p class="x15"> <b> &nbsp; ຄະນະຄຸ້ມຄອງດ່ານສາກົນຂົວມິດຕະພາບ 1 </b> </p>
                            @else
                                <p class="x14" stlye="margin-right:40px;"> <b> &nbsp; <label > ຊທ </label>  ຫົວໜ້າຫ້ອງການບໍລິຫານ </b> </p> 
                            @endif
                        @endif
                        
                        @if($beta_enter[0]->sign_url)
                            @if($beta_enter[0]->boss_id=='13')
                            
                                 <img src="{{ asset($beta_enter[0]->sign_url) }}"  style="   right: 40px; float: right;
    display: block;
    position: absolute;
    width: {{ $image_size }}%;"> 
                              
                               
                            @else
                                <img src="{{ asset($beta_enter[0]->sign_url) }}"  style="right: 40px;float:right;    float: right;
    display: block;
    position: absolute;
    width: {{ $image_size }}%;">
                            @endif
                        @endif
                        <br>
                        &nbsp;
                </div>
                <div style=" ">
                    <br>
                    <br>
                    <br>
                    <div class="sub-line">&nbsp;</div>
                    <div class="sub-line">&nbsp;</div>
                    <div class="sub-line">&nbsp;</div>
                    <div class="sub-line">&nbsp;</div>
                    <div class="sub-line">&nbsp;</div>
                    <div class="sub-line">&nbsp;</div>
                    <div class="sub-line">&nbsp;</div>
                    <div class="sub-line">&nbsp;</div>
                    <p class="x9">&nbsp;&nbsp;&nbsp;<b>ຂໍ້ກໍານົດໃນການຈັດຕັ້ງປະຕິບັດມີດັ່ງນີ້ : </b></p>
                    <p class="x9">&nbsp;&nbsp;&nbsp;ກໍລະນີແລ່ນລົດບັນທຸກຂົນສົ່ງສິນຄ້າເຂົ້າພາຍໃນຕົວເມືອງ ນະຄອນຫຼວງວຽງຈັນ ຫ້າມຂົນສົ່ງໃນເວລາເລັ່ງດ່ວນໂມງເຂົ້າການ</p>
                    <p class="x9">-	ເລີກການຄື : ຕອນເຊົ້າເລີ້ມແຕ່ເວລາ 6 : 00 ຫາ 9 : 00  ໂມງ, ຕອນທ່ຽງເລີ້ມແຕ່ 11 : 00 ຫາ 13 : 00  ໂມງ, ຕອນແລງເລີ້ມແຕ່</p><p class="x9">&nbsp;&nbsp; 15 : 00 ຫາ 18 : 00 ໂມງແລງ.</p>
                    <p class="x9">-	ຫ້າມຈອດລົດຊະຊາຍຕາມເສັ້ນທາງກໍລະນີຈໍາເປັນຕ້ອງຈອດລໍຖ້າເຂົ້າຕົວເມືອງຕ້ອງໄດ້ເຂົ້າຈອດໃນສະຖານທີ່ເໝາະສົມນອກ</p><p class="x9">&nbsp;&nbsp;ເສັ້ນທາງຫຼີກລ້ຽງຄວາມແອອັດໃນການສັນຈອນ ແລະ ອຸປະຕິເຫດ.</p>
                    <p class="x9">-	ຫ້າມນໍາໃຊ້ສະຖານທີ່ເສັ້ນທາງ, ແຄມທາງ ເປັນບ່ອນຄ່ຽນຖ່າຍສິນຄ້າຂື້ນ - ລົງຢ່າງເດັດຂາດ.</p>
                    <p class="x9">-	ລົດຂົນສົ່ງສິນຄ້າເຂົ້າ - ອອກດ່ານສາກົນຂົວມິດຕະພາບ 1 ນະຄອນຫຼວງວຽງຈັນ ເພື່ອໄປສົ່ງສິນຄ້າຢູ່ປາຍທາງ ພາຍຫຼັງລົງສິນຄ້າ</p><p class="x9">&nbsp;&nbsp;ສໍາເລັດແລ້ວໃຫ້ກັບຄືນທັນທີ ຫ້າມບໍ່ໃຫ້ໄປເຄື່ອນໄຫວຮັບເອົາສິນຄ້າຢູ່ຈຸດອື່ນໆ ເພື່ອສົ່ງອອກຄືນ.</p>
                </div>
                    
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