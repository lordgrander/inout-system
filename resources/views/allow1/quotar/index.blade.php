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
            grid-temname-columns: repeat(3, 1fr);
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

        #modal-close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-price_total: bold;
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

    </style>

    <div id="modal">
        <div id="modal-content">
            <p class="laob display_msg"></p>
            <!-- <button id="modal-close">Close</button> -->
        </div>
    </div>
    <div class="py-2 laos">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

         
                <div class="bg-white-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                    <div class="p-2">
                        <div class=" items-center">
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                <div class="context"> 
                                    <select name="" id="name" class="form-control">
                                        @foreach ($list as $l)
                                            <option value="{{ $l->pro_name }}">{{ $l->pro_name }} {{ $l->QuotarHaveUnit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="context">
                                    <input type="text" class="form-control" id="price_total" placeholder="ມູນຄ່າ" onkeyup="javascript:this.value=Comma(this.value);">
                                </div>
                                <div class="context"> 
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
                                    <input type="text" class="form-control" id="qty" placeholder="ຈຳນວນ">
                                      
                                </div>
                                <div class="context">
                                <input type="text" class="form-control" id="weight" placeholder="ນ້ຳໜັກ" style="color:#797a7c!important;" onkeyup="javascript:this.value=Comma(this.value);">

                                </div>
                                <div class="context">
                                </div>
                                <div class="context">
                                    <div class="ml-12 text-lg text-gray-600 leading-7 font-semibold  text-right">
                                    
                                    <div class="context">

                                        <button type="button" class="btn btn-outline-success" id="add" value="ເພີ່ມ">
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
                                    <label class="laob">ຂໍ້ມູນລາຍການປ້ອນ</label>
                                </td>
                            </tr>
                        </table>
                        <form id="form-data" class="">
                            <div class="table_display_data" width="100%">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>ລາຍການສິນຄ້າ</tb>
                                        <td>ຈຳນວນ</tb>   
                                        <td>ມູນຄ່າ</tb>
                                        <td>ນ້ຳຫນັກ</tb>
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
                                    <div class="w-100 p-3" style="border:solid #343434 1px;border-radius:5px;"> 
                                        <div class="d-flex justify-content-between w-100">
                                                <div>
                                                    <input type="checkbox" class="" name="in" id="in" value="ນຳເຂົ້າ">
                                                    <label for="in">ນຳເຂົ້າ</label>
                                                </div>
                                                <div>
                                                    <input type="checkbox" class="" name="out" id="out" value="ສົ່ງອອກ"> 
                                                    <label for="out">ສົ່ງອອກ</label>  
                                                </div>
                                                <div>
                                                    <input type="checkbox" class="" name="pass" id="pass" value="ຂົນສົ່ງຜ່ານ"> 
                                                    <label for="pass">ຂົນສົ່ງຜ່ານ</label> 
                                                </div>
                                                <div>
                                                    <input type="checkbox" class="" name="in_for_animal" id="in_for_animal" value="">
                                                    <label for="in_for_animal">ນຳເຂົ້າເພື່ອສົ່ງອອກສັດ ແລະ ພະລິດຕະພັນສິນຄ້າກ່ຽວກັບສັດ</label>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>

                                        <br>
                                        <input type="text" class="form-control lasttails" id="lasttails"
                                            name="lasttails" autocomplete="off"
                                            placeholder="ລະບຸພິເສດ ( ຖ້າຕ້ອງການ )">
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
                        <button class="btn btn-outline-success" id="draft">ເກັບໄວ້</button>
                        <button class="btn btn-outline-success" id="save">ສົ່ງແບບຟອມ</button>
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

    </script>

    <script>
        $(document).ready(function () {
            $('#price_total').on('keypress', function(event) {
                var allowedChars = [',', '.', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                var char = String.fromCharCode(event.which);
                if (allowedChars.indexOf(char) === -1) {
                event.preventDefault();
                }
            });

            $('#price_total').on("cut copy paste",function(e) {
                var allowedChars = [',', '.', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                var char = String.fromCharCode(event.which);
                if (allowedChars.indexOf(char) === -1) {
                event.preventDefault();
                }
            });

            $(document).on('keypress','.sub_price_total', function (e) {
                var allowedChars = [',', '.', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                var char = String.fromCharCode(event.which);
                if (allowedChars.indexOf(char) === -1) {
                event.preventDefault();
                }
            });

            $(document).on('cut copy paste','.sub_price_total', function (e) {
                var allowedChars = [',', '.', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                var char = String.fromCharCode(event.which);
                if (allowedChars.indexOf(char) === -1) {
                event.preventDefault();
                }
            });

            $('#add').on('click', function (e) {

                let name = jugtext($('#name').val());
                let qty = jugtext($('#qty').val());
                // let t_model = Number($('#t_model').val());
                let display_t_model = '101';
                let p_import = jugtext($('#p_import').val());
                let price_total = jugtext($('#price_total').val());
                let weight = jugtext($('#weight').val());

             
                if (name == '') {
                    let dumx = "*ກະລຸນາລະບຸ : '<u>ປ້າຍທະບຽນລົດ</u>.'";
                    showAlert(dumx);
                    $('#name').focus();
                    return false
                }
                if (qty == '') {
                    let dumx = "*ກະລຸນາລະບຸ : '<u>ຊື່ຄົນຂັບລົດ</u>.'";
                    showAlert(dumx);
                    $('#qty').focus();
                    return false
                }
                // if (t_model == '') {
                //     let dumx = "*ກະລຸນາລະບຸ : '<u>ປະເພດຂອງລົດ</u>.'";
                //     showAlert(dumx);
                //     $('#t_model').focus();
                //     return false
                // }
                if (p_import == '') {
                    let dumx = "*ກະລຸນາລະບຸ : '<u>ປະເພດຂອງສິນຄ້ານຳເຂົ້າ</u>.'";
                    showAlert(dumx);
                    $('#p_import').focus();
                    return false
                }
                if (price_total == '') {
                    let dumx = "*ກະລຸນາລະບຸ : '<u>ນ້ຳໜັກສະເລ່ຍ</u>.'";
                    showAlert(dumx);
                    $('#price_total').focus();
                    return false
                }
                if (weight == '') {
                    let dumx = "*ກະລຸນາລະບຸ : '<u>ເລກທີນຳເຂົ້າສີນຄ້າ</u>.'";
                    showAlert(dumx);
                    $('#weight').focus();
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
                    <td><p id="display_name_' + index + '">' + name + '</p></td>\
                    <td><p id="display_qty_' + index + '">' + qty + '</p></td>\
                    <td><p id="display_price_total_' + index + '">' + price_total + '</p></td>\
                    <td><p id="display_weight_' + index + '">' + weight + '</p></td>\
                    <td><asd class="edit" id="' + index + '">ແກ້ໄຂ</asd> | <asd class="delete" id="' + index + '">ລືບຖີ້ມ</asd></td>\
                </tr>';

let input_dum = '<tr class="row_input_' + index + '" id="input_' + index + '" style="display:none">\
                    <td><input type="text" class="form-control" id="input_name_' + index +
    '" name="input_name_' + index + '" value="' + name + '"></td>\
                    <td><input type="text" class="form-control" id="input_qty_' + index +
    '" name="input_qty_' + index + '" value="' + qty + '"></td>\
                    <td><input type="text" class="form-control sub_price_total" id="input_price_total_' + index +
    '" name="input_price_total_' + index + '" value="' + price_total + '"  onkeyup="javascript:this.value=Comma(this.value);"></td>\
                    <td><input type="text" class="form-control sub_price_total" id="input_weight_' + index +
    '" name="input_weight_' + index + '" value="' + weight + '"  onkeyup="javascript:this.value=Comma(this.value);"></td>\
                    <td><asd class="edit_save" id="' + index +
    '">ບັນທຶກ</asd> | <asd class="edit_cancel" id="' + index + '" >ຍົກເລີກ</asd></td>\
                </tr>';

        $('#build').append(display_dum + input_dum);

        // SelectElement("input_t_model_" + index, t_model);
        $('#name').val('');
        $('#qty').val('');
        // $('#p_import').val('');
        $('#price_total').val('');
        // $('#weight').val('');
});

            var dum_name = '';
            var dum_qty = '';
            var dum_t_model = '';
            var display_t_model = '';
            var dum_p_import = '';
            var dum_price_total = '';
            var dum_weight = '';

            $('#build').on('click', '.edit', function (e) {
                let index = $(this).attr("id");
                $("#display_" + index).css("display", "none");
                $("#input_" + index).css("display", "");

                dum_name = jugtext($('#input_name_' + index).val());
                dum_qty = jugtext($('#input_qty_' + index).val());
                // let dum_t_model_id = Number($('#display_t_model_' + index).attr('data-value'));
                fetch_t_model = '101';
                // dum_t_model = fetch_t_model.name;

                // SelectElement("input_t_model_" + index, dum_t_model_id);
                dum_p_import = jugtext($('#input_p_import_' + index).val());
                dum_price_total = jugtext($('#input_price_total_' + index).val());
                dum_weight = jugtext($('#input_weight_' + index).val());

            });

            $('#build').on('click', '.edit_cancel', function (e) {
                let index = $(this).attr("id");
                $('#display_name_' + index).html(dum_name);
                $('#display_qty_' + index).html(dum_qty);
                // $('#display_t_model_' + index).html(dum_t_model);
                $('#display_p_import_' + index).html(dum_p_import);
                $('#display_price_total_' + index).html(dum_price_total);
                $('#display_weight_' + index).html(dum_weight);


                $('#input_name_' + index).val(dum_name);
                $('#input_qty_' + index).val(dum_qty);
                // $('#input_t_model_' + index).val(dum_t_model);
                $('#input_p_import_' + index).val(dum_p_import);
                $('#input_price_total_' + index).val(dum_price_total);
                $('#input_weight_' + index).val(dum_weight);

                $("#input_" + index).css("display", "none");
                $("#display_" + index).css("display", "");
                dum_name = '';
                dum_qty = '';
                // dum_t_model = '';
                dum_p_import = '';
                dum_price_total = '';
                dum_weight = '';

            });
            $('#build').on('click', '.edit_save', function (e) {
                    let index = $(this).attr("id");


                    let dum_name = jugtext($('#input_name_' + index).val());
                    let dum_qty = jugtext($('#input_qty_' + index).val());

                    // let dum_t_model = Number($('#input_t_model_' + index).val());
                    // $('#display_t_model_' + index).attr('data-value', dum_t_model);
                    fetch_t_model = '101';
                    let dum_p_import = jugtext($('#input_p_import_' + index).val());
                    let dum_price_total = jugtext($('#input_price_total_' + index).val());
                    let dum_weight = jugtext($('#input_weight_' + index).val());


                    if (dum_name == '') {
                        let dumx = "*ກະລຸນາລະບຸ : '<u>ປ້າຍທະບຽນລົດ</u>.'";
                        showAlert(dumx);
                        return false
                    }
                    if (dum_qty == '') {
                        let dumx = "*ກະລຸນາລະບຸ : '<u>ຊື່ຄົນຂັບລົດ</u>.'";
                        showAlert(dumx);
                        return false
                    }
                    // if (dum_t_model == '') {
                    //     let dumx = "*ກະລຸນາລະບຸ : '<u>ປະເພດຂອງລົດ</u>.'";
                    //     showAlert(dumx);
                    //     return false
                    // }
                    if (dum_p_import == '') {
                        let dumx = "*ກະລຸນາລະບຸ : '<u>ປະເພດຂອງສິນຄ້ານຳເຂົ້າ</u>.'";
                        showAlert(dumx);
                        return false
                    }
                    if (dum_price_total == '') {
                        let dumx = "*ກະລຸນາລະບຸ : '<u>ນ້ຳໜັກສະເລ່ຍ</u>.'";
                        showAlert(dumx);
                        return false
                    }
                    if (dum_weight == '') {
                        let dumx = "*ກະລຸນາລະບຸ : '<u>ເລກທີນຳເຂົ້າສີນຄ້າ</u>.'";
                        showAlert(dumx);
                        return false
                    }

                    $('#display_name_' + index).html(dum_name);
                    $('#display_qty_' + index).html(dum_qty);
                    // $('#display_t_model_' + index).html(fetch_t_model.name);
                    $('#display_p_import_' + index).html(dum_p_import);
                    $('#display_price_total_' + index).html(dum_price_total);
                    $('#display_weight_' + index).html(dum_weight);


                    $("#input_" + index).css("display", "none");
                    $("#display_" + index).css("display", "");

            });

$('#build').on('click', '.delete', function (e) {
if (confirm("Are you sure?")) {
    let index = $(this).attr("id");


    $("#input_" + index).css("display", "");
    $("#display_" + index).css("display", "");

    $('#input_name_' + index).val("this_delete");
    $('#input_qty_' + index).val("");
    // $('#input_t_model_' + index).val("");
    $('#input_p_import_' + index).val("");
    $('#input_price_total_' + index).val("");
    $('#input_weight_' + index).val("");

    $('#display_name_' + index).html('this_delete');
    $('#display_qty_' + index).html('');
    // $('#display_t_model_' + index).html('');
    $('#display_p_import_' + index).html('');
    $('#display_price_total_' + index).html('');
    $('#display_weight_' + index).html('');



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
    url: "/enter/save",
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


            document.querySelector('#weight').addEventListener('input', function() {
                sendAjaxRequest(this.value, 'weight');
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
