<x-app-layout>
  <style>
    :root{
      --ink:#0f172a;          /* slate-900 */
      --sub:#475569;          /* slate-600 */
      --line:#e2e8f0;         /* slate-200 */
      --soft:#f8fafc;         /* slate-50 */
      --brand:#0a4e9b;
      --ok:#0f766e;           /* teal-700 */
      --warn:#a16207;         /* amber-700 */
      --err:#b91c1c;          /* red-700 */
    }
    body{color:var(--ink)}
    .card-elev{
      border:1px solid var(--line);
      border-radius:14px;
      box-shadow:0 6px 18px rgba(2,8,23,.06);
    }
    .card-hdr{
      padding:14px 16px;border-bottom:1px solid var(--line);
      background:linear-gradient(180deg,#fff,#fbfdff);
      display:flex;align-items:center;justify-content:space-between;
    }
    .card-hdr .title{font-weight:800;font-size:18px}
    .hint{color:var(--sub);font-size:12px}
    .k{font-size:12px;color:var(--sub);margin-bottom:6px}
    .badge-chip{
      display:inline-block;border:1px solid var(--line);background:var(--soft);
      padding:4px 10px;border-radius:999px;font-size:12px;color:var(--sub)
    }
    .table-wrap{overflow:auto}
    .table thead th{background:var(--soft);border-bottom:1px solid var(--line)}
    .table td, .table th{vertical-align:middle}
    .action-link{cursor:pointer; font-weight:600}
    .action-link:hover{text-decoration:underline}
    .btn-outline-dark{border-radius:10px}
    .ring{
      display:inline-block;width:64px;height:64px;border-radius:50%;
      border:6px solid #000;border-right-color:transparent;animation:spin 1s linear infinite
    }
    @keyframes spin{to{transform:rotate(360deg)}}
    /* Modal */
    #modal{display:none;position:fixed;z-index:1000;inset:0;background:rgba(0,0,0,.35)}
    #modal .panel{
      background:#fff;border:2px solid #1c73ff;border-radius:12px;
      width:min(520px,90%);margin:15% auto;padding:18px
    }
    #modal .panel p{margin:0;font-size:15px}
    /* small fixes for your grid & table scroller */
    .table_display_data{overflow-x:auto;white-space:nowrap}
    .grid-container{display:grid;grid-template-columns:repeat(3,1fr);grid-gap:12px}
    .grid-item{padding:0}
  </style>

  {{-- Toast/Modal --}}
  <div id="modal">
    <div class="panel">
      <p class="laob display_msg"></p>
    </div>
  </div>

  <div class="py-3 laos">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="card-elev bg-white overflow-hidden sm:rounded-lg">

        <div class="card-hdr">
          <div class="title">ຟອມຂໍ Quotar</div>
          <span class="hint">ເພີ່ມລາຍການ ແລ້ວກົດ “ສົ່ງແບບຟອມ”</span>
        </div>

        <div class="p-3">
          <div class="row">
            <div class="col-md-6">
              <div class="k">ລາຍການສິນຄ້າ</div>
              <input type="text" class="form-control" id="name" placeholder="ຊື່ສິນຄ້າ">
              <div class="k mt-3">ມູນຄ່າ</div>
              <div class="input-group">
                <input type="text" class="form-control w-100" id="price_total"
                       placeholder="ມູນຄ່າ"
                       onkeyup="this.value=Comma(this.value);">
                <div class="input-group-append" style="width:120px">
                  <select id="cur_select" class="form-control">
                    <option value="LAK">LAK</option>
                    <option value="THB">THB</option>
                    <option value="USD">USD</option>
                    <option value="CNY">CNY</option>
                  </select>
                </div>
              </div>
              <div class="hint mt-1">ພິມຈໍານວນເປັນຕົວເລກ, ລະບົບຈະໃສ່ , ໃຫ້ອັດຕະໂນມັດ</div>
            </div>

            <div class="col-md-6">
              <div class="k">ຈຳນວນ</div>
              <input type="text" class="form-control" id="qty" placeholder="ຈຳນວນ">
              <div class="k mt-3">ນ້ຳໜັກ</div>
              <input type="text" class="form-control" id="weight" placeholder="ນ້ຳໜັກ"
                     onkeyup="this.value=Comma(this.value);">

              <div class="text-right mt-4">
                <button type="button" class="btn btn-outline-dark" id="add">
                  ເພີ່ມລາຍການ
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="px-3 pb-3">
          <div class="k mb-1">ລາຍການທີ່ເພີ່ມ</div>

          <form id="form-data">
            <div class="table_display_data">
              <table class="table table-bordered mb-2">
                <thead>
                  <tr>
                    <th>ລາຍການສິນຄ້າ</th>
                    <th style="width:110px">ຈຳນວນ</th>
                    <th style="width:150px">ມູນຄ່າ</th>
                    <th style="width:110px">ສະກຸນ</th>
                    <th style="width:150px">ນ້ຳໜັກ</th>
                    <th style="width:130px">ຈັດການ</th>
                  </tr>
                </thead>
                <tbody id="build"></tbody>
              </table>
            </div>

            <div class="p-2 mb-3" style="border:1px solid var(--line);border-radius:10px;">
              <div class="d-flex flex-wrap align-items-center justify-content-between">
                <label class="mb-0">
                  <input type="checkbox" name="in" id="in" value="YES"> ນຳເຂົ້າ
                </label>
                <label class="mb-0">
                  <input type="checkbox" name="out" id="out" value="YES"> ສົ່ງອອກ
                </label>
                <label class="mb-0">
                  <input type="checkbox" name="pass" id="pass" value="YES"> ຂົນສົ່ງຜ່ານ
                </label>
                <label class="mb-0" style="max-width:380px">
                  <input type="checkbox" name="in_for_animal" id="in_for_animal" value="YES">
                  ນຳເຂົ້າເພື່ອສົ່ງອອກສັດ ແລະ ພະລິດຕະພັນກ່ຽວກັບສັດ
                </label>
              </div>
            </div>

            <input type="text" class="form-control lasttails" id="lasttails"
              name="lasttails" autocomplete="off"
              placeholder="ລະບຸພິເສດ ( ຖ້າຕ້ອງການ )">

            <div class="mt-3">
              <small class="hint">ແນບເອກະສານ (PDF, JPG, PNG) ລວມຂະໜາດບໍ່ເກີນ 15MB</small>
              <input type="file" class="form-control mt-1" id="upload_files" name="upload_files[]" multiple>
              <input type="hidden" id="index" name="index">
            </div>

            <div class="text-right mt-4 mb-2">
              <button class="btn btn-outline-dark" id="save" type="button">ສົ່ງແບບຟອມ</button>
            </div>
          </form>
        </div>

        <div class="px-3 pb-3">
          <span class="badge-chip">Tip</span>
          <span class="hint">ກົດ Enter ໃນຊ່ອງ “ນ້ຳໜັກ” ເພື່ອເພີ່ມລາຍການໄວ</span>
        </div>
      </div>
    </div>
  </div>

  {{-- Keep your existing CDNs --}}
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js"
          integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">
  </script>

  <script>
    // ---------- helpers ----------
    var index = 0;    // total rows created
    var rem   = 0;    // rows active

    function showAlert(html){
      $('.display_msg').html(html);
      $("#modal").css("display", "block");
    }
    $(window).on('click', function (e) {
      if (e.target === $("#modal")[0]) $("#modal").hide();
    });

    function Comma(Num){
      Num = (Num||'').toString().replace(/,/g,'');
      if(!Num) return '';
      var parts = Num.split('.');
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g,',');
      return parts.join('.');
    }
    function onlyNumberKeypress(e){
      var allowed = [',','.','0','1','2','3','4','5','6','7','8','9'];
      var ch = String.fromCharCode(e.which);
      if (allowed.indexOf(ch) === -1) e.preventDefault();
    }

    // ---------- numeric field constraints ----------
    $(document).on('keypress', '#price_total, .sub_price_total', onlyNumberKeypress);
    $(document).on('cut copy paste', '#price_total, .sub_price_total', function(e){ e.preventDefault(); });

    // ---------- add row ----------
    $('#add').on('click', addRow);
    $('#weight').on('keydown', function(e){ if(e.key==='Enter'){ e.preventDefault(); addRow(); }});

    function addRow(){
      let name = ($('#name').val()||'').trim();
      let qty  = ($('#qty').val()||'').trim();
      let price_total = ($('#price_total').val()||'').trim();
      let cur_select  = $('#cur_select').val();
      let weight = ($('#weight').val()||'').trim();

      if(!name){ showAlert("** ກະລຸນາລະບຸ: <u>ຊື່ສິນຄ້າ</u>"); $('#name').focus(); return; }
      if(!qty){ showAlert("** ກະລຸນາລະບຸ: <u>ຈຳນວນ</u>"); $('#qty').focus(); return; }
      if(!price_total){ showAlert("** ກະລຸນາລະບຸ: <u>ມູນຄ່າ</u>"); $('#price_total').focus(); return; }
      if(!weight){ showAlert("** ກະລຸນາລະບຸ: <u>ນ້ຳໜັກ</u>"); $('#weight').focus(); return; }

      if(rem === 5){ showAlert("ຈຳນວນລາຍການຄົບ 5 ລາຍການ ກະລຸນາສົ່ງແບບຟອມ"); return; }

      rem += 1; index += 1; $('#index').val(index);

      let rowDisp = `
      <tr id="display_${index}">
        <td><p id="display_name_${index}">${name}</p></td>
        <td><p id="display_qty_${index}">${qty}</p></td>
        <td><p id="display_price_total_${index}">${price_total}</p></td>
        <td><p id="display_cur_select_${index}">${cur_select}</p></td>
        <td><p id="display_weight_${index}">${weight}</p></td>
        <td>
          <span class="action-link text-primary edit" id="${index}">ແກ້ໄຂ</span> |
          <span class="action-link text-danger delete" id="${index}">ລຶບ</span>
        </td>
      </tr>`;

      let rowEdit = `
      <tr id="input_${index}" style="display:none">
        <td><input type="text" class="form-control" id="input_name_${index}" name="input_name_${index}" value="${name}"></td>
        <td><input type="text" class="form-control" id="input_qty_${index}"  name="input_qty_${index}"  value="${qty}"></td>
        <td><input type="text" class="form-control sub_price_total" id="input_price_total_${index}" name="input_price_total_${index}" value="${price_total}" onkeyup="this.value=Comma(this.value);"></td>
        <td>
          <select name="cur_select_${index}" id="cur_select_${index}" class="form-control">
            <option value="LAK">LAK</option><option value="THB">THB</option>
            <option value="USD">USD</option><option value="CNY">CNY</option>
          </select>
        </td>
        <td><input type="text" class="form-control sub_price_total" id="input_weight_${index}" name="input_weight_${index}" value="${weight}" onkeyup="this.value=Comma(this.value);"></td>
        <td>
          <span class="action-link text-success edit_save" id="${index}">ບັນທຶກ</span> |
          <span class="action-link text-muted edit_cancel" id="${index}">ຍົກເລີກ</span>
        </td>
      </tr>`;

      $('#build').append(rowDisp+rowEdit);
      // set currency selected in edit row
      document.getElementById('cur_select_'+index).value = cur_select;

      // clear inputs for next entry
      $('#name').val(''); $('#qty').val(''); $('#price_total').val(''); $('#weight').val('');
    }

    // edit / cancel / save
    let cache = {};
    $('#build').on('click','.edit', function(){
      let i = $(this).attr('id');
      cache[i] = {
        name:   $('#input_name_'+i).val(),
        qty:    $('#input_qty_'+i).val(),
        price:  $('#input_price_total_'+i).val(),
        weight: $('#input_weight_'+i).val(),
        cur:    $('#cur_select_'+i).val()
      };
      $("#display_"+i).hide(); $("#input_"+i).show();
    });

    $('#build').on('click','.edit_cancel', function(){
      let i = $(this).attr('id'), v = cache[i] || {};
      $('#display_name_'+i).text(v.name||$('#display_name_'+i).text());
      $('#display_qty_'+i).text(v.qty||$('#display_qty_'+i).text());
      $('#display_price_total_'+i).text(v.price||$('#display_price_total_'+i).text());
      $('#display_weight_'+i).text(v.weight||$('#display_weight_'+i).text());
      $('#display_cur_select_'+i).text(v.cur||$('#display_cur_select_'+i).text());

      $('#input_name_'+i).val(v.name);
      $('#input_qty_'+i).val(v.qty);
      $('#input_price_total_'+i).val(v.price);
      $('#input_weight_'+i).val(v.weight);
      $('#cur_select_'+i).val(v.cur);

      $("#input_"+i).hide(); $("#display_"+i).show();
    });

    $('#build').on('click','.edit_save', function(){
      let i = $(this).attr('id');

      let name = ($('#input_name_'+i).val()||'').trim();
      let qty  = ($('#input_qty_'+i).val()||'').trim();
      let price= ($('#input_price_total_'+i).val()||'').trim();
      let weight=($('#input_weight_'+i).val()||'').trim();
      let cur  = ($('#cur_select_'+i).val()||'').trim();

      if(!name){ showAlert("** ກະລຸນາລະບຸ: <u>ຊື່ສິນຄ້າ</u>"); return; }
      if(!qty){ showAlert("** ກະລຸນາລະບຸ: <u>ຈຳນວນ</u>"); return; }
      if(!price){ showAlert("** ກະລຸນາລະບຸ: <u>ມູນຄ່າ</u>"); return; }
      if(!weight){ showAlert("** ກະລຸນາລະບຸ: <u>ນ້ຳໜັກ</u>"); return; }

      $('#display_name_'+i).text(name);
      $('#display_qty_'+i).text(qty);
      $('#display_price_total_'+i).text(price);
      $('#display_weight_'+i).text(weight);
      $('#display_cur_select_'+i).text(cur);

      $("#input_"+i).hide(); $("#display_"+i).show();
    });

    // delete row
    $('#build').on('click','.delete', function(){
      if(!confirm("ຢືນຢັນການລຶບ?")) return false;
      let i = $(this).attr('id');
      // mark for backend as deleted (keeps index continuity)
      $('#input_name_'+i).val('this_delete');
      $('#display_'+i).hide(); $('#input_'+i).hide();
      rem -= 1;
      return false;
    });

    // save (submit)
    $('#save').on('click', function(e){
      if(index===0){ showAlert('ກະລຸນາເພີ່ມລາຍການກ່ອນ'); return; }

      // Busy UI
      showAlert('<center><span class="ring"></span></center>');

      $('#index').val(index);
      $('#save').prop('disabled', true);

      let form = new FormData($('#form-data')[0]);

      $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

      $.ajax({
        type: "post",
        url: "{{ route('tell.quotar') }}",
        data: form,
        dataType: "json",
        async:false, cache:false, contentType:false, processData:false,
        success: function(){
          showAlert("ສົ່ງຂໍ້ມູນສຳເລັດ");
          window.location.reload();
        },
        error: function(jq,x,e){
          if(e==='Payload Too Large'){
            showAlert("ຂະໜາດໄຟລ໌ລວມເກີນ 15MB");
          }else{
            showAlert("ການສົ່ງຂໍ້ມູນຜິດພາດ ກະລຸນາລອງໃໝ່");
          }
          $('#save').prop('disabled', false);
        }
      });
    });
  </script>
</x-app-layout>
