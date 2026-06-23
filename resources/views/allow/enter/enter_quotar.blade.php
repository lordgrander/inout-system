<x-app-layout>
    <style>
        .edit,
        .edit_save,
        .edit_cancel,
        .delete {
            cursor: pointer;
        }

        .table_display_data {
            overflow-x: auto !important;
            /* overflow: auto!important; */
            white-space: nowrap !important;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 10px;
        }

        .grid-item {
            padding: 10px;
        }
        .spinner {
  display: inline-block;
  position: relative;
  width: 64px;
  height: 64px;
}

.q {
  box-sizing: border-box;
  display: block;
  position: absolute;
  width: 40%;
  height: 40%;
  top: 30%;
  left: 30%;
  border-radius: 50%;
  border: 6px solid #000;
  border-color: #000 transparent transparent transparent;
  animation: spin 1.2s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

    </style>

    <style>

        #modal-pick {
            display: none;
            /* Hide the modal by default */
            position: fixed;
            /* Make the modal stay in the same spot */
            z-index: 1;
            /* Place the modal on top of everything else */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }
        #modal {
            display: none;
            /* Hide the modal by default */
            position: fixed;
            /* Make the modal stay in the same spot */
            z-index: 1;
            /* Place the modal on top of everything else */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        #modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            /* 15% from the top and centered */
            padding: 20px;
            border-radius: 10px;
            border: #1c73ff solid 3px;
            width: 80%;
            /* Could be more or less, depending on screen size */
        }


        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            /* 15% from the top and centered */
            padding: 20px;
            border-radius: 10px;
            border: #1c73ff solid 3px;
            width: 40%;
            /* Could be more or less, depending on screen size */
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

        .context {
            margin-bottom: 10px;
        }

        /* ===== Murphy Light Admin (non-breaking) ===== */
:root{
  --mur-bg:#f6f8fb;
  --mur-card:#ffffff;
  --mur-border:#e5e7eb;
  --mur-text:#111827;
  --mur-muted:#6b7280;
  --mur-accent:#2563eb;       /* primary */
  --mur-accent-600:#1d4ed8;
  --mur-danger:#dc2626;
  --mur-radius:14px;
  --mur-shadow:0 10px 24px rgba(17,24,39,.08);
}

body{ background:radial-gradient(1200px 700px at -10% -10%, #fff 0, #eef2f7 55%, var(--mur-bg) 100%) !important; }

/* Shell cards */
.bg-white.shadow-xl.sm\:rounded-lg{
  background:var(--mur-card)!important; border:1px solid var(--mur-border)!important;
  border-radius:16px!important; box-shadow:var(--mur-shadow)!important;
}

/* Headings & small text */
.text-gray-600{ color:var(--mur-text)!important; }
.sub_stable_font{ color:var(--mur-text)!important; }

/* Inputs (keep .form-control & your ids) */
.form-control{
  border:1px solid var(--mur-border)!important; border-radius:12px!important;
  background:#fff!important; color:var(--mur-text)!important; padding:.65rem .8rem!important;
  box-shadow:0 0 0 rgba(0,0,0,0);
  transition:box-shadow .15s, border-color .15s;
}
.form-control:focus{
  outline:0; border-color:#c7d2fe!important; box-shadow:0 0 0 3px rgba(37,99,235,.15)!important;
}

/* Buttons (keep your classes) */
.btn{ border-radius:12px!important; font-weight:700!important; transition:transform .08s, filter .12s, box-shadow .15s!important; }
.btn:active{ transform:translateY(1px); }
.btn-outline-primary{
  border:2px solid var(--mur-accent)!important; color:var(--mur-accent-600)!important; background:#fff!important;
}
.btn-outline-primary:hover{ background:#eaf1ff!important; border-color:#94b7ff!important; }

/* Spinner upgrade (re-uses your markup) */
.spinner{ width:56px; height:56px; }
.spinner .q{ border-width:6px; border-color:var(--mur-accent) transparent transparent transparent; }

/* Two-column form grid */
.grid-container{ display:grid; grid-template-columns:repeat(3,1fr); gap:10px; }
@media (max-width:900px){ .grid-container{ grid-template-columns:1fr; } }
.grid-item{ padding:0; }

/* Section titles / context spacing */
.context{ margin-bottom:10px; }

/* Modal refresh (keeps #modal, #modal-pick & .modal-content) */
#modal, #modal-pick{
  display:none; position:fixed; inset:0; z-index:1000; background:rgba(15,23,42,.25);
  backdrop-filter:blur(2px);
}
#modal-content, .modal-content{
  background:#fff; border:1px solid var(--mur-border); width:min(680px,92%); margin:7% auto;
  border-radius:var(--mur-radius); box-shadow:var(--mur-shadow); padding:20px;
}

/* Top table (items list) */
.table{ color:var(--mur-text)!important; background:#fff; }
.table.table-bordered{ border-color:var(--mur-border)!important; border-radius:12px; overflow:hidden; }
.table thead tr th{
  background:#f4f7fc!important; color:#334155!important; border-color:var(--mur-border)!important;
}

/* “object” line items inside cells */
.object{
  border-radius:10px; border:1px solid var(--mur-border); background:#fff; padding:8px 10px; margin-top:8px;
  display:grid; gap:10px; grid-template-columns:2fr .6fr .9fr 1.2fr 1.2fr auto; align-items:center;
}
.object > div{ white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
@media (max-width:640px){ .object{ grid-template-columns:1fr 1fr; } }

/* File pill */
.table a svg{ transition:transform .12s ease, filter .12s ease }
.table a:hover svg{ transform:translateY(-1px); filter:drop-shadow(0 6px 12px rgba(37,99,235,.25)) }

/* ===== Responsive “build” table -> cards on mobile ===== */
.table_display_data{ overflow-x:auto!important; white-space:nowrap!important; transition:all .25s ease; }
@media (max-width:900px){
  .table_display_data{ white-space:normal!important; }
  .table_display_data table{ width:100%!important; border-collapse:separate; border-spacing:0 10px; }
  .table_display_data thead{ display:none; }
  .table_display_data tbody tr{
    display:block; background:#fff; border:1px solid var(--mur-border); border-radius:12px; padding:12px;
    box-shadow:0 6px 18px rgba(17,24,39,.05); margin-bottom:12px;
  }
  .table_display_data tbody tr td{
    display:flex; justify-content:space-between; align-items:flex-start; border-top:none!important;
    padding:.5rem 0 !important;
  }
  .table_display_data tbody tr td::before{
    content:attr(data-label);
    font-weight:600; color:var(--mur-muted); padding-right:12px; max-width:55%;
  }
}

/* Small notes & statuses */
.text-primary{ color:#1d4ed8!important; }
.text-success{ color:#059669!important; }
.text-danger{ color:#b91c1c!important; }

    </style>

    <div id="modal">
        <div id="modal-content">
            <p class="laob display_msg"></p>
            <!-- <button id="modal-close">Close</button> -->
        </div>
    </div>

    <div id="modal-pick">
        <div  class="modal-content">
            <p class="laob display_msg"></p>
            <table class="table table-bordered">
                <tr>
                    <th>ລາຍການ</th>
                    <th class="text-right">ໂຄຕ້າ</th>
                    <th class="text-center"width="18%">ໃຊ້ໄດ້ຈົນເຖີງ</th>
                    <td width="5%"></td>
                </tr>
                <tbody>
                    @foreach ($beta_a_enter_quotar as $r)
                        @foreach ($r->QhaveD as $rd)
                            
                            <tr>
                                <td>{{ $rd->name }}</td>
                                <td class="text-right">0 / {{ number_format($rd->weight) }} Kg</td>
                                <td class="text-center">{{ date('d-m-Y',strtotime($r->expired_at)) }}</td>
                                <td>
                                    <button class="btn btn-primary pick" data-hash="{{ $rd->id }}" data-name="{{ $rd->name }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512" style="fill:white;"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
            <script>
(function(){
  // pick the table that contains #build
  const table = document.querySelector('#build')?.closest('table');
  if(!table) return;
  const headers = Array.from(table.querySelectorAll('thead tr th, thead tr td')).map(th => th.textContent.trim());

  // label each td from its column header
  table.querySelectorAll('tbody tr').forEach(tr => {
    Array.from(tr.children).forEach((td, i) => {
      if(!td.getAttribute('data-label') && headers[i]) {
        td.setAttribute('data-label', headers[i]);
      }
    });
  });

  // if rows are added dynamically, observe and apply labels
  const tb = table.querySelector('tbody');
  if(!tb) return;
  new MutationObserver(muts => {
    muts.forEach(m => {
      m.addedNodes.forEach(node => {
        if(node.nodeType===1 && node.matches('tr')){
          Array.from(node.children).forEach((td, i) => {
            if(!td.getAttribute('data-label') && headers[i]) {
              td.setAttribute('data-label', headers[i]);
            }
          });
        }
      });
    });
  }).observe(tb, {childList:true});
})();
</script>

            <!-- <button id="modal-close">Close</button> -->
        </div>

    </div>
    <input type="text" id="hash" value="" style="height:0px;width:0px;border:solid 0px!important;position:absolute;opacity:0;">
    
    <div class="py-2 laos">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-white-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                    <div class="p-2">
                        <div class=" items-center">
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                <div class="context">
                                    <input type="text" class="form-control" id="plate" placeholder="ທະບຽນລົດ">
                                </div>
                                <div class="context">
                                    <input type="text" class="form-control" id="d_name" placeholder="ຊື່ຜູ້ຂັບ">
                                </div>
                                <div class="context"> 
                                    <input type="text" class="form-control" id="weight" placeholder="ນ້ຳໜັກ" onkeyup="javascript:this.value=Comma(this.value);">
                                </div>
                            </div>
                        </div>
                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
                        </div>
                    </div>

                    <div class="p-2 border-t border-gray-200 md:border-t-0 md:border-l">
                        <div class=" items-center">
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">

                                <div class="context">
                                     
                                    <select id="t_model" class="form-control">
                                        @foreach ($beta_t_type as $row)
                                        <option value="{{ $row->t_type_id }}">{{ $row->t_type_name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="context">
                                    <div class="d-flex">
                                        <div>
                                            <button class="btn btn-outline-primary" id="pick_quotar"> ເລືອກສິນຄ້າ </button>
                                        </div>
                                        <div style="width:70%;">
                                            <input type="text" class="form-control" id="p_import" placeholder="ສິນຄ້ານຳເຂົ້າ" disabled style="color:#797a7c!important;" value="{{ old('p_import') ?? session('p_import') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="context"> 
                                            <input type="text" class="form-control" id="detail" placeholder="ເລກທີນຳເຂົ້າສີນຄ້າ" style="color:#797a7c!important;" value="{{ old('detail') ?? session('detail') }}">
                                       
                                </div>
                                <div class="context">
                                    <div class="ml-12 text-lg text-gray-600 leading-7 font-semibold  text-right">
                                    
                                    <div class="context">

                                        <button type="button" class="btn btn-outline-primary" id="add" value="ເພີ່ມ">
                                            <div>ເພີ່ມຂໍ້ມູນ <asd class="show_rem" style="display:none;">0/5 :</asd>
                                            </div>
                                        </button>

                                    </div>
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
    <div class="py-2 laos">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white   shadow-xl sm:rounded-lg">
                <div class="p-2 sm:px-20 bg-white border-b border-gray-200">
                    <div>
                        <table>
                            <tr>
                                <td>
                                    <label class="laob">ຂໍ້ມູນປາຍທາງ, ແນບເອກະສານ ແລະ ລາຍການຂໍ້ມູນລົດ </label>
                                </td>
                            </tr>
                        </table>
                        <form id="form-data" class="">
                            <div class="table_display_data" width="100%">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>ທະບຽນລົດ</tb>
                                        <td>ຊື່ຜູ້ຂັບ</tb>
                                        <td>ປະເພດລົດ</tb>
                                        <td>ສິນຄ້ານຳເຂົ້າ</tb>
                                        <td>ນ້ຳໜັກ</tb>
                                        <td>ເລກທີນຳເຂົ້າສີນຄ້າ</tb>
                                        <td>ຈັດການ</tb>
                                    </tr>
                                </thead>
                                <tbody id="build">
                                </tbody>
                                <tr>
                                    <td colspan="7">
                                         
                                    </td>
                                </tr>
                            </table>
                            
                            </div>
                            ລະບຸປາຍທາງ
                                        <div class="grid-container" >
                                            <div class="grid-item" style="padding:0px!important;">
                                                <input type="text" class="form-control address" id="address"
                                                    name="address" autocomplete="off" placeholder="ບ້ານ" value="{{ old('address') ?? session('address') }}">
                                            </div>
                                            <div class="grid-item" style="padding:0px!important;">
                                                <input type="text" class="form-control district" id="district"
                                                    name="district" autocomplete="off" placeholder="ເມືອງ" value="{{ old('district') ?? session('district') }}">
                                            </div>
                                            <div class="grid-item" style="padding:0px!important;">
                                                <input type="text" class="form-control province" id="province"
                                                    name="province" autocomplete="off" placeholder="ແຂວງ" value="{{ old('province') ?? session('province') }}">
                                            </div>
                                        </div>

                                        <br>
                                        <input type="text" class="form-control lasttails" id="lasttails"
                                            name="lasttails" autocomplete="off"
                                            placeholder="ລະບຸພິເສດສຳລັບປາຍທາງ ( ຖ້າຕ້ອງການ )">
                                        <br>
                                        <small>ແນບເອກະສານ ( PDF,JPG,PNG) : ສາມາດເລືອກຫຼາຍໆ ເອກະສານໄດ້ ແຕ່ຂະໜາດຫ້າມເກີນ</small>
                                            15MB
                                        <br>
                                        <input type="file" class="form-control" id="upload_files" name="upload_files[]"
                                            multiple>
                                        <input type="hidden" class="index" id="index" name="index">
                                        <br>
                        </form>

                    </div>

                    <div class="mt-8 text-2xl text-right">
                        <button class="btn btn-outline-primary" id="draft">ເກັບໄວ້</button>
                        <button class="btn btn-outline-primary" id="save">ສົ່ງແບບຟອມ</button>
                    </div>

                    <div class="mt-6 text-gray-500">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">
    </script>


    <script>
        var index = 0;
        var rem = 0;

        var arr_t_model = [
            @foreach($beta_t_type as $row) {
                id: {{ $row -> t_type_id }},
                name: "{{ $row->t_type_name }}"
            },
            @endforeach
        ];

        let dum_input_option = '';
        arr_t_model.forEach(function (xdata) {
            let x_value = xdata.id;
            let x_text = xdata.name;
            dum_input_option += '<option value="' + x_value + '">' + x_text + '</option>';
        });



       

        function jugtext(str) {
            // remove potentially harmful characters using a regular expression
            // str = str.replace(/[^a-zA-Z0-9ก-๙ກ-ໜ-ໝ\s\-\.\/_]/gi, '');
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

        function rayback(m)
        {
            return m
        }

    </script>

    <script>
        $(document).ready(function () {


            $('.pick').on('click', function (e) {
                const name = $(this).attr('data-name');
                const hash = $(this).attr('data-hash');
                console.log(name,hash);
                $('#p_import').val(name);
                $('#hash').val(hash); 
                $("#modal-pick").css("display", "none");

            });
            $('#pick_quotar').on('click', function (e) {
                $("#modal-pick").css("display", "block");
                
            });

            $('#weight').on('keypress', function(event) {
                var allowedChars = [',', '.', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                var char = String.fromCharCode(event.which);
                if (allowedChars.indexOf(char) === -1) {
                    event.preventDefault();
                }
            });

            $('#weight').on("cut copy paste",function(e) {
                var allowedChars = [',', '.', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                var char = String.fromCharCode(event.which);
                if (allowedChars.indexOf(char) === -1) {
                event.preventDefault();
                }
            });

            $(document).on('keypress','.sub_weight', function (e) {
                var allowedChars = [',', '.', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                var char = String.fromCharCode(event.which);
                if (allowedChars.indexOf(char) === -1) {
                event.preventDefault();
                }
            });
            
            $(document).on('cut copy paste','.sub_weight', function (e) {
                var allowedChars = [',', '.', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                var char = String.fromCharCode(event.which);
                if (allowedChars.indexOf(char) === -1) {
                    event.preventDefault();
                }
            });

            $(document).on('change','.rayback', function (e) {
                $(this).empty();
                $(this).val($(this).attr('data-rayback'));
            });
            
            $('#add').on('click', function (e) {

                let plate = jugtext($('#plate').val());
                let d_name = jugtext($('#d_name').val());
                let t_model = Number($('#t_model').val());
                let display_t_model = arr_t_model.find(function (xdata) {
                    return xdata.id === t_model;
                });
                let p_import = jugtext($('#p_import').val());
                let weight = jugtext($('#weight').val());
                let detail = jugtext($('#detail').val());
                let hash = jugtext($('#hash').val());

             
                if (plate == '') {
                    let dumx = "*ກະລຸນາລະບຸ : '<u>ປ້າຍທະບຽນລົດ</u>.'";
                    showAlert(dumx);
                    $('#plate').focus();
                    return false
                }
                if (d_name == '') {
                    let dumx = "*ກະລຸນາລະບຸ : '<u>ຊື່ຄົນຂັບລົດ</u>.'";
                    showAlert(dumx);
                    $('#d_name').focus();
                    return false
                }
                if (t_model == '') {
                    let dumx = "*ກະລຸນາລະບຸ : '<u>ປະເພດຂອງລົດ</u>.'";
                    showAlert(dumx);
                    $('#t_model').focus();
                    return false
                }
                if (p_import == '') {
                    let dumx = "*ກະລຸນາລະບຸ : '<u>ປະເພດຂອງສິນຄ້ານຳເຂົ້າ</u>.'";
                    showAlert(dumx);
                    $('#p_import').focus();
                    return false
                }
                if (weight == '') {
                    let dumx = "*ກະລຸນາລະບຸ : '<u>ນ້ຳໜັກສະເລ່ຍ</u>.'";
                    showAlert(dumx);
                    $('#weight').focus();
                    return false
                }
                if (detail == '') {
                    let dumx = "*ກະລຸນາລະບຸ : '<u>ເລກທີນຳເຂົ້າສີນຄ້າ</u>.'";
                    showAlert(dumx);
                    $('#detail').focus();
                    return false
                }

                if (rem == 5) {
                    let dumx = "ຈຳນວນລົດໄດ້ເພີ່ມຄົບແລ້ວ ກະລຸນາສົ່ງແບບຟອມ";
                    showAlert(dumx);
                    return false;
                } else {
                    rem = rem + 1;
                    $('.show_rem').html(rem);
                }
index = index + 1;


let display_dum = '<tr class="row_' + index + '" id="display_' + index + '" style="display:">\
                    <td><p id="display_plate_' + index + '">' + plate + '</p></td>\
                    <td><p id="display_d_name_' + index + '">' + d_name + '</p></td>\
                    <td><p id="display_t_model_' + index + '" data-value="' + t_model + '">' +
    display_t_model.name + '</p></td>\
                    <td><p id="display_p_import_' + index + '">' + p_import + '</p></td>\
                    <td><p id="display_weight_' + index + '">' + weight + '</p></td>\
                    <td><p id="display_detail_' + index + '">' + detail + '</p></td>\
                    <td><asd class="edit" id="' + index + '">ແກ້ໄຂ</asd> | <asd class="delete" id="' + index + '">ລືບຖີ້ມ</asd></td>\
                </tr>';

let input_dum = '<tr class="row_input_' + index + '" id="input_' + index + '" style="display:none">\
                    <td><input type="text" class="form-control" id="input_plate_' + index +
    '" name="input_plate_' + index + '" value="' + plate + '"></td>\
                    <td><input type="text" class="form-control" id="input_d_name_' + index +
    '" name="input_d_name_' + index + '" value="' + d_name + '" ></td>\
                    <td><select class="form-control" id="input_t_model_' + index +
    '" name="input_t_model_' + index + '" value="'+t_model+'">' + dum_input_option + '</select></td>\
                    <td><input type="text" class="form-control rayback" id="input_p_import_' + index +
    '" name="input_p_import_' + index + '" value="' + p_import + '" placeholder="" data-rayback="'+ p_import +'"></td>\
                    <td><input type="text" class="form-control sub_weight" id="input_weight_' + index +
    '" name="input_weight_' + index + '" value="' + weight + '"></td>\
                    <td><input type="text" class="form-control" id="input_detail_' + index +
    '" name="input_detail_' + index + '" value="' + detail + '"><input type="text" class="form-control" id="input_hash_' + index +
    '" name="input_hash_' + index + '" value="' + hash + '" style="height:0px;width:0px;border:solid 0px!important;position:absolute;opacity:0;"></td>\
                    <td><asd class="edit_save" id="' + index +
    '">ບັນທຶກ</asd> | <asd class="edit_cancel" id="' + index + '" >ຍົກເລີກ</asd></td>\
                </tr>';

        $('#build').append(display_dum + input_dum);

        SelectElement("input_t_model_" + index, t_model);
        $('#plate').val('');
        $('#d_name').val('');
        // $('#p_import').val('');
        $('#weight').val('');
        // $('#detail').val('');
});

            var dum_plate = '';
            var dum_d_name = '';
            var dum_t_model = '';
            var display_t_model = '';
            var dum_p_import = '';
            var dum_weight = '';
            var dum_detail = '';

            $('#build').on('click', '.edit', function (e) {
                let index = $(this).attr("id");
                $("#display_" + index).css("display", "none");
                $("#input_" + index).css("display", "");

                dum_plate = jugtext($('#input_plate_' + index).val());
                dum_d_name = jugtext($('#input_d_name_' + index).val());
                let dum_t_model_id = Number($('#display_t_model_' + index).attr('data-value'));
                fetch_t_model = arr_t_model.find(function (xdata) {
                    return xdata.id === dum_t_model_id;
                });
                dum_t_model = fetch_t_model.name;

                SelectElement("input_t_model_" + index, dum_t_model_id);
                dum_p_import = jugtext($('#input_p_import_' + index).val());
                dum_weight = jugtext($('#input_weight_' + index).val());
                dum_detail = jugtext($('#input_detail_' + index).val());

            });

            $('#build').on('click', '.edit_cancel', function (e) {
                let index = $(this).attr("id");
                $('#display_plate_' + index).html(dum_plate);
                $('#display_d_name_' + index).html(dum_d_name);
                $('#display_t_model_' + index).html(dum_t_model);
                $('#display_p_import_' + index).html(dum_p_import);
                $('#display_weight_' + index).html(dum_weight);
                $('#display_detail_' + index).html(dum_detail);


                $('#input_plate_' + index).val(dum_plate);
                $('#input_d_name_' + index).val(dum_d_name);
                $('#input_t_model_' + index).val(dum_t_model);
                $('#input_p_import_' + index).val(dum_p_import);
                $('#input_weight_' + index).val(dum_weight);
                $('#input_detail_' + index).val(dum_detail);

                $("#input_" + index).css("display", "none");
                $("#display_" + index).css("display", "");
                dum_plate = '';
                dum_d_name = '';
                dum_t_model = '';
                dum_p_import = '';
                dum_weight = '';
                dum_detail = '';

            });
            $('#build').on('click', '.edit_save', function (e) {
                    let index = $(this).attr("id");


                    let dum_plate = jugtext($('#input_plate_' + index).val());
                    let dum_d_name = jugtext($('#input_d_name_' + index).val());

                    let dum_t_model = Number($('#input_t_model_' + index).val());
                    $('#display_t_model_' + index).attr('data-value', dum_t_model);
                    fetch_t_model = arr_t_model.find(function (xdata) {
                        return xdata.id === dum_t_model;
                    });
                    let dum_p_import = jugtext($('#input_p_import_' + index).val());
                    let dum_weight = jugtext($('#input_weight_' + index).val());
                    let dum_detail = jugtext($('#input_detail_' + index).val());


                    if (dum_plate == '') {
                        let dumx = "*ກະລຸນາລະບຸ : '<u>ປ້າຍທະບຽນລົດ</u>.'";
                        showAlert(dumx);
                        return false
                    }
                    if (dum_d_name == '') {
                        let dumx = "*ກະລຸນາລະບຸ : '<u>ຊື່ຄົນຂັບລົດ</u>.'";
                        showAlert(dumx);
                        return false
                    }
                    if (dum_t_model == '') {
                        let dumx = "*ກະລຸນາລະບຸ : '<u>ປະເພດຂອງລົດ</u>.'";
                        showAlert(dumx);
                        return false
                    }
                    if (dum_p_import == '') {
                        let dumx = "*ກະລຸນາລະບຸ : '<u>ປະເພດຂອງສິນຄ້ານຳເຂົ້າ</u>.'";
                        showAlert(dumx);
                        return false
                    }
                    if (dum_weight == '') {
                        let dumx = "*ກະລຸນາລະບຸ : '<u>ນ້ຳໜັກສະເລ່ຍ</u>.'";
                        showAlert(dumx);
                        return false
                    }
                    if (dum_detail == '') {
                        let dumx = "*ກະລຸນາລະບຸ : '<u>ເລກທີນຳເຂົ້າສີນຄ້າ</u>.'";
                        showAlert(dumx);
                        return false
                    }

                    $('#display_plate_' + index).html(dum_plate);
                    $('#display_d_name_' + index).html(dum_d_name);
                    $('#display_t_model_' + index).html(fetch_t_model.name);
                    $('#display_p_import_' + index).html(dum_p_import);
                    $('#display_weight_' + index).html(dum_weight);
                    $('#display_detail_' + index).html(dum_detail);


                    $("#input_" + index).css("display", "none");
                    $("#display_" + index).css("display", "");

            });

$('#build').on('click', '.delete', function (e) {
if (confirm("Are you sure?")) {
    let index = $(this).attr("id");


    $("#input_" + index).css("display", "");
    $("#display_" + index).css("display", "");

    $('#input_plate_' + index).val("this_delete");
    $('#input_d_name_' + index).val("");
    $('#input_t_model_' + index).val("");
    $('#input_p_import_' + index).val("");
    $('#input_weight_' + index).val("");
    $('#input_detail_' + index).val("");

    $('#display_plate_' + index).html('this_delete');
    $('#display_d_name_' + index).html('');
    $('#display_t_model_' + index).html('');
    $('#display_p_import_' + index).html('');
    $('#display_weight_' + index).html('');
    $('#display_detail_' + index).html('');



    $("#input_" + index).css("display", "none");
    $("#display_" + index).css("display", "none");

    rem = rem - 1;
    $('.show_rem').html(rem);

}
return false;
});

$('#save').on('click', function (e) {
  
     
let address = $('#address').val();
let district = $('#district').val();
let province = $('#province').val();

if (index == 0) {
    showAlert('ກະລຸນາລະບຸຂໍ້ມູນລົດ ທະບຽນລົດ, ປະເພດລົດ, ຊື່ຜູ້ຂັບ ... ');
    return false
}

if (address == '' || district == '' || province == '') {
    showAlert('ກະລຸນາລະບຸປາຍທາງ ບ້ານ-ເມືອງ-ແຂວງ');

    $('#address').focus();
    return false
}

let dumxx = '<center><div class="spinner"><div class="q"></div></div></center>';
    showAlert(dumxx);

$('#index').val(index);
$('#save').prop('disabled', true);
e.preventDefault();

let deta = new FormData($('#form-data')[0]);
const pdfFiles = document.querySelector('input[type="file"]').files;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.ajax({
    type: "post",
    url: "{{ route('quotar.enter.save') }}",
    data: (deta),
    dataType: "json",
    async: false,
    cache: false,
    contentType: false,
    processData: false,
    success: function (response) {
        // console.log(response.message)
        let dumxxx = "ສົ່ງຂໍ້ມູນສຳເລັດ";
        showAlert(dumxxx);
        window.location.reload();

    },
    complete: function () {
        // me.data('requestRunning', false);
        let dumxxz = "ສົ່ງຂໍ້ມູນສຳເລັດ";
        showAlert(dumxxz);
    },
    error: function (jqXHR, textStatus, errorThrown) {
        if (errorThrown == 'Payload Too Large') {
            let dumx = "ຂະໜາດ File ລວມ ມີຂະໜາດເກີນ 1.5Mb";
            showAlert(dumx);
            $('#save').prop('disabled', false);

            return false;
        }
        else
        {
            let dumxn = "ການສົ່ງຊໍ້ມູນຜິດພາດກະລຸນາສົ່ງໃຫມ່";
            showAlert(dumxn);
        }
    }
})


});


$('#draft').on('click', function (e) {
   
let address = $('#address').val();
let district = $('#district').val();
let province = $('#province').val();

if (index == 0) {
    showAlert('ກະລຸນາລະບຸຂໍ້ມູນລົດ ທະບຽນລົດ, ປະເພດລົດ, ຊື່ຜູ້ຂັບ ... ');
    return false
}

if (address == '' || district == '' || province == '') {
    showAlert('ກະລຸນາລະບຸປາຍທາງ ບ້ານ-ເມືອງ-ແຂວງ');

    $('#address').focus();
    return false
}

let dumxx = '<center><div class="spinner"><div class="q"></div></div></center>';
    showAlert(dumxx);

$('#index').val(index);
$('#draft').prop('disabled', true);
e.preventDefault();

let deta = new FormData($('#form-data')[0]);
const pdfFiles = document.querySelector('input[type="file"]').files;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.ajax({
    type: "post",
    url: "/enter/draft",
    data: (deta),
    dataType: "json",
    async: false,
    cache: false,
    contentType: false,
    processData: false,
    success: function (response) {
        // console.log(response.message)
        window.location.reload();

    },
    complete: function () {
        // me.data('requestRunning', false);
    },
    error: function (jqXHR, textStatus, errorThrown) {
        if (errorThrown == 'Payload Too Large') {
            let dumx = "ຂະໜາດ File ລວມ ມີຂະໜາດເກີນ 1.5Mb";
            showAlert(dumx);
            $('#save').prop('disabled', false);

            return false;
        }
    }
})


});




            // When the modal button is clicked



            // When the user clicks anywhere outside of the modal, close it
            $(window).click(function (event) {
                if (event.target == $("#modal")[0]) {
                    $("#modal").css("display", "none");
                }


                if (event.target == $("#modal-pick")[0]) {
                    $("#modal-pick").css("display", "none");
                }

               
            });

            // When the close button is clicked
            $("#modal-close").click(function () {
                // Hide the modal
                $("#modal").css("display", "none");
            });


            document.querySelector('#address').addEventListener('input', function() {
                sendAjaxRequest(this.value, 'address');
            });

            document.querySelector('#district').addEventListener('input', function() {
                sendAjaxRequest(this.value, 'district');
            });

            document.querySelector('#province').addEventListener('input', function() {
                sendAjaxRequest(this.value, 'province');
            });


            document.querySelector('#p_import').addEventListener('input', function() {
                sendAjaxRequest(this.value, 'p_import');
            });


            document.querySelector('#detail').addEventListener('input', function() {
                sendAjaxRequest(this.value, 'detail');
            });
            
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            function sendAjaxRequest(value, input) {
                $.ajax({
                type: 'POST',
                url: '/enter/update-session',
                data: {
                    value: value,
                    input: input
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.error(error);
                }
                });
            }

        });


 

        function Comma(Num) { //function to add commas to textboxes
        Num += '';
        Num = Num.replace(',', ''); Num = Num.replace(',', ''); Num = Num.replace(',', '');
        Num = Num.replace(',', ''); Num = Num.replace(',', ''); Num = Num.replace(',', '');
        x = Num.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        return x1 + x2;
    }


    function SelectElement(id, valueToSelect)
          {
              var element = document.getElementById(id);
              element.value = valueToSelect;
          }
    </script>


</x-app-layout>
