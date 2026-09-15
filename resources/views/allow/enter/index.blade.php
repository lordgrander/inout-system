<x-app-layout>
  <style>
    :root{
      --ink:#182230;
      --muted:#667085;
      --line:#d9e2ec;
      --soft:#f7fafc;
      --brand:#0a4e9b;
      --brand-2:#0f766e;
      --warn:#b7791f;
      --danger:#b42318;
    }
    body{color:var(--ink);background:#f3f7fb}
    .permit-shell{max-width:1280px;margin:0 auto;padding:14px 14px 28px}
    .permit-head{display:flex;align-items:flex-end;justify-content:space-between;gap:16px;margin-bottom:14px}
    .permit-title{font-size:24px;font-weight:900;letter-spacing:0;color:#0b2f5b;margin:0}
    .permit-sub{font-size:13px;color:var(--muted);margin:3px 0 0}
    .permit-meta{display:flex;gap:8px;flex-wrap:wrap;justify-content:flex-end}
    .pill{display:inline-flex;align-items:center;min-height:30px;border:1px solid var(--line);border-radius:999px;background:#fff;padding:5px 11px;font-size:12px;font-weight:800;color:#344054}
    .layout-grid{display:grid;grid-template-columns:minmax(0,420px) minmax(0,1fr);gap:14px;align-items:start}
    .panel{background:#fff;border:1px solid var(--line);border-radius:8px;box-shadow:0 8px 22px rgba(16,24,40,.06)}
    .panel-head{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:14px 16px;border-bottom:1px solid var(--line);background:#fbfdff}
    .panel-title{font-size:16px;font-weight:900;margin:0;color:#102a43}
    .panel-body{padding:16px}
    .field-grid{display:grid;grid-template-columns:1fr;gap:13px}
    .field-grid.two{grid-template-columns:minmax(0,1fr) 92px;gap:10px}
    .field label,.field-label{display:block;margin-bottom:6px;font-size:12px;font-weight:900;color:#4a5568;text-transform:uppercase}
    .form-control{border-color:var(--line)!important;border-radius:8px!important;min-height:42px;color:#25364a!important}
    .form-control:focus{border-color:#66a3e8!important;box-shadow:0 0 0 4px rgba(10,78,155,.12)!important}
    .hint{font-size:12px;color:var(--muted)}
    .vehicle-actions{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-top:14px}
    .btn{border-radius:8px!important;font-weight:800!important}
    .btn-primary-soft{background:#0a4e9b;color:#fff;border:1px solid #0a4e9b}
    .btn-primary-soft:hover{color:#fff;background:#083f7d}
    .btn-draft{background:#fff;color:#344054;border:1px solid var(--line)}
    .btn-draft:hover{background:#f8fafc;color:#182230}
    .btn-submit{background:#0f766e;color:#fff;border:1px solid #0f766e}
    .btn-submit:hover{background:#0b5f59;color:#fff}
    .table-wrap{overflow:auto;border:1px solid var(--line);border-radius:8px}
    .table{margin-bottom:0}
    .table thead th{background:#eef4fb!important;border-bottom:1px solid var(--line)!important;color:#344054;font-size:12px;text-transform:uppercase;white-space:nowrap}
    .table td,.table th{vertical-align:middle!important}
    #build:empty:before{content:'ຍັງບໍ່ມີລາຍການລົດ';display:block;padding:22px;text-align:center;color:var(--muted);font-weight:800}
    .action-link{cursor:pointer;font-weight:900}
    .action-link:hover{text-decoration:underline}
    .destination-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:10px}
    .submit-bar{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-top:14px;padding-top:14px;border-top:1px solid var(--line)}
    .submit-buttons{display:flex;gap:8px;justify-content:flex-end;flex-wrap:wrap}
    #modal{display:none;position:fixed;z-index:1000;inset:0;background:rgba(15,23,42,.42)}
    #modal-content{background:#fff;border:1px solid #8bb8e8;border-radius:8px;width:min(520px,92%);margin:16vh auto;padding:18px;box-shadow:0 20px 50px rgba(15,23,42,.2)}
    .display_msg{margin:0;font-size:15px}
    .spinner{display:inline-block;position:relative;width:64px;height:64px}
    .q{box-sizing:border-box;display:block;position:absolute;width:40%;height:40%;top:30%;left:30%;border-radius:50%;border:6px solid #0a4e9b;border-color:#0a4e9b transparent transparent transparent;animation:spin 1.2s linear infinite}
    @keyframes spin{to{transform:rotate(360deg)}}
    @media (max-width: 980px){
      .permit-head{align-items:flex-start;flex-direction:column}
      .permit-meta{justify-content:flex-start}
      .layout-grid{grid-template-columns:1fr}
      .destination-grid{grid-template-columns:1fr}
      .submit-bar{align-items:stretch;flex-direction:column}
      .submit-buttons{justify-content:stretch}
      .submit-buttons .btn{flex:1}
    }
  </style>

  <div id="modal">
    <div id="modal-content">
      <p class="laob display_msg"></p>
    </div>
  </div>

  <div class="permit-shell laos">
    <div class="permit-head">
      <div>
        <h1 class="permit-title">ຟອມຂໍອະນຸຍາດລົດ</h1>
        <p class="permit-sub">ປ້ອນລາຍການລົດ, ປາຍທາງ ແລະ ແນບເອກະສານ</p>
      </div>
      <div class="permit-meta">
        <span class="pill">ສູງສຸດ 5 ຄັນ</span>
        <span class="pill">PDF / JPG / PNG</span>
      </div>
    </div>

    <div class="layout-grid">
      <section class="panel">
        <div class="panel-head">
          <h2 class="panel-title">ຂໍ້ມູນລົດ</h2>
          <span class="pill show_rem" style="display:none;">0/5</span>
        </div>
        <div class="panel-body">
          <div class="field-grid">
            <div class="field">
              <label for="plate">ທະບຽນລົດ</label>
              <input type="text" class="form-control" id="plate" placeholder="ທະບຽນລົດ">
            </div>
            <div class="field">
              <label for="d_name">ຊື່ຜູ້ຂັບ</label>
              <input type="text" class="form-control" id="d_name" placeholder="ຊື່ຜູ້ຂັບ">
            </div>
            <div class="field">
              <label for="weight">ນ້ຳໜັກ</label>
              <input type="text" class="form-control" id="weight" placeholder="ນ້ຳໜັກ" onkeyup="this.value=Comma(this.value);">
              <div class="hint mt-1">ຕົວເລກ, comma ແລະ dot ເທົ່ານັ້ນ</div>
            </div>
            <div class="field">
              <label for="t_model">ປະເພດລົດ</label>
              <div class="field-grid two">
                <div id="forage">
                  <select id="t_model" class="form-control round-check">
                    <option value="19" data-round="1">ລົດ 4 ລໍ້</option>
                    @foreach (collect($beta_t_type)->where('t_type_id', '!=', 19) as $row)
                      <option value="{{ $row->t_type_id }}" data-round="{{ $row->is_round }}">
                        {{ $row->t_type_name }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div id="round">
                  <select id="tell_round" class="form-control">
                    @for($i=1;$i<=5;$i++)
                      <option value="{{$i}}">{{$i}} ຖ້ຽວ</option>
                    @endfor
                  </select>
                </div>
              </div>
            </div>
            <div class="field">
              <label for="p_import">ສິນຄ້ານຳເຂົ້າ</label>
              <input type="text" class="form-control" id="p_import" placeholder="ສິນຄ້ານຳເຂົ້າ" value="{{ old('p_import') ?? session('p_import') }}">
            </div>
            <div class="field">
              <label for="detail">ເລກທີນຳເຂົ້າສິນຄ້າ</label>
              <input type="text" class="form-control" id="detail" placeholder="ເລກທີນຳເຂົ້າສິນຄ້າ" value="{{ old('detail') ?? session('detail') }}">
            </div>
          </div>

          <div class="vehicle-actions">
            <span class="hint">ກົດເພີ່ມເພື່ອສ້າງລາຍການໃນຕາຕະລາງ</span>
            <button type="button" class="btn btn-primary-soft" id="add">ເພີ່ມຂໍ້ມູນ</button>
          </div>
        </div>
      </section>

      <section class="panel">
        <div class="panel-head">
          <h2 class="panel-title">ລາຍການ ແລະ ປາຍທາງ</h2>
          <span class="hint">ກວດກ່ອນສົ່ງ</span>
        </div>
        <div class="panel-body">
          <form id="form-data">
            <div class="table-wrap mb-3">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>ທະບຽນລົດ</th>
                    <th>ຊື່ຜູ້ຂັບ</th>
                    <th>ປະເພດລົດ</th>
                    <th>ສິນຄ້ານຳເຂົ້າ</th>
                    <th>ນ້ຳໜັກ</th>
                    <th>ເລກທີນຳເຂົ້າ</th>
                    <th style="width:136px">ຈັດການ</th>
                  </tr>
                </thead>
                <tbody id="build"></tbody>
              </table>
            </div>

            <div class="field-label">ລະບຸປາຍທາງ</div>
            <div class="destination-grid">
              <input type="text" class="form-control address" id="address" name="address" autocomplete="off" placeholder="ບ້ານ" value="{{ old('address') ?? session('address') }}">
              <input type="text" class="form-control district" id="district" name="district" autocomplete="off" placeholder="ເມືອງ" value="{{ old('district') ?? session('district') }}">
              <input type="text" class="form-control province" id="province" name="province" autocomplete="off" placeholder="ແຂວງ" value="{{ old('province') ?? session('province') }}">
            </div>

            <input type="text" class="form-control lasttails mt-3" id="lasttails" name="lasttails" autocomplete="off" placeholder="ລະບຸພິເສດສຳລັບປາຍທາງ ( ຖ້າຕ້ອງການ )">

            <div class="field mt-3">
              <label for="upload_files">ແນບເອກະສານ</label>
              <input type="file" class="form-control" id="upload_files" name="upload_files[]" multiple>
              <input type="hidden" class="index" id="index" name="index">
              <div class="hint mt-1">PDF, JPG, PNG ລວມຂະໜາດບໍ່ເກີນ 15MB</div>
            </div>

            <div class="submit-bar">
              <div class="hint">ສົ່ງແລ້ວສະຖານະຈະເປັນ WAITING</div>
              <div class="submit-buttons">
                <button class="btn btn-draft" id="draft" type="button">ເກັບໄວ້</button>
                <button class="btn btn-submit" id="save" type="button">ສົ່ງແບບຟອມ</button>
              </div>
            </div>
          </form>
        </div>
      </section>
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
      @foreach($beta_t_type as $row)
        { id: {{ $row->t_type_id }}, name: "{{ $row->t_type_name }}" },
      @endforeach
    ];
    let dum_input_option = '';
    arr_t_model.forEach(function (xdata) {
      dum_input_option += '<option value="'+xdata.id+'">'+xdata.name+'</option>';
    });

    function jugtext(str){ return str; }

    function showAlert(msg){
      $('.display_msg').html(msg);
      $("#modal").css("display","block");
    }
    $(window).click(function(e){ if (e.target == $("#modal")[0]) $("#modal").hide(); });

    function Comma(Num){
      Num = (Num||'').toString().replace(/,/g,'');
      if(!Num) return '';
      var parts = Num.split('.');
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g,',');
      return parts.join('.');
    }
    function SelectElement(id, valueToSelect){
      var el = document.getElementById(id); if(el) el.value = valueToSelect;
    }

    $('#weight').on('keypress', onlyNum); $('#weight').on('cut copy paste', blockPaste);
    $(document).on('keypress','.sub_weight', onlyNum);
    $(document).on('cut copy paste','.sub_weight', blockPaste);
    function onlyNum(e){
      var allowed=[',','.','0','1','2','3','4','5','6','7','8','9'];
      var ch=String.fromCharCode(e.which); if(allowed.indexOf(ch)===-1){e.preventDefault();}
    }
    function blockPaste(e){ e.preventDefault(); }

    $('#add').on('click', function(){
      let plate = jugtext($('#plate').val());
      let d_name = jugtext($('#d_name').val());
      let t_model = Number($('#t_model').val());
      let is_round = parseInt($('#t_model').find(':selected').data('round'));
      let display_t_model = arr_t_model.find(x=>x.id===t_model);
      let p_import = jugtext($('#p_import').val());
      let weight = jugtext($('#weight').val());
      let detail = jugtext($('#detail').val());
      let tell_round = parseInt($('#tell_round').val());

      if(!plate){ showAlert("** ກະລຸນາລະບຸ: <u>ປ້າຍທະບຽນລົດ</u>"); $('#plate').focus(); return; }
      if(!d_name){ showAlert("** ກະລຸນາລະບຸ: <u>ຊື່ຄົນຂັບ</u>"); $('#d_name').focus(); return; }
      if(!t_model){ showAlert("** ກະລຸນາລະບຸ: <u>ປະເພດລົດ</u>"); $('#t_model').focus(); return; }
      if(!p_import){ showAlert("** ກະລຸນາລະບຸ: <u>ປະເພດສິນຄ້ານຳເຂົ້າ</u>"); $('#p_import').focus(); return; }
      if(!weight){ showAlert("** ກະລຸນາລະບຸ: <u>ນ້ຳໜັກສະເລ່ຍ</u>"); $('#weight').focus(); return; }
      if(!detail){ showAlert("** ກະລຸນາລະບຸ: <u>ເລກທີນຳເຂົ້າ</u>"); $('#detail').focus(); return; }

      if(rem===5){ showAlert("ຈຳນວນລົດຄົບ 5 ຄັນ ກະລຸນາສົ່ງແບບຟອມ"); return; }
      rem += 1; index += 1;

      let limb_box = '';
      let limb_edit_box = ``;
      if(is_round===1){
        if(tell_round !== 1)
        {
          limb_box = '('+tell_round+' ຖ້ຽວ)';
          limb_edit_box = `<select class="form-control" id="input_t_model_round_${index}" name="input_t_model_round_${index}">
                              @for($i=1;$i<=5;$i++)
                                <option value="{{$i}}">{{$i}} ຖ້ຽວ</option>
                              @endfor
                            </select>`;
        }
      }

      let display_dum =
      '<tr id="display_'+index+'">\
        <td><p id="display_plate_'+index+'">'+plate+'</p></td>\
        <td><p id="display_d_name_'+index+'">'+d_name+'</p></td>\
        <td><p id="display_t_model_'+index+'" data-value="'+t_model+'" data-round="'+tell_round+'">'+display_t_model.name+' '+limb_box+'</p></td>\
        <td><p id="display_p_import_'+index+'">'+p_import+'</p></td>\
        <td><p id="display_weight_'+index+'">'+weight+'</p></td>\
        <td><p id="display_detail_'+index+'">'+detail+'</p></td>\
        <td><span class="action-link text-primary edit" id="'+index+'">ແກ້ໄຂ</span> | \
            <span class="action-link text-danger delete" id="'+index+'">ລຶບຖີ້ມ</span></td>\
      </tr>';

      let input_dum =
      '<tr id="input_'+index+'" style="display:none">\
        <td><input type="text" class="form-control" id="input_plate_'+index+'" name="input_plate_'+index+'" value="'+plate+'"></td>\
        <td><input type="text" class="form-control" id="input_d_name_'+index+'" name="input_d_name_'+index+'" value="'+d_name+'"></td>\
        <td><div class="d-flex justify-content-start" style="gap:6px"><select class="form-control" id="input_t_model_'+index+'" name="input_t_model_'+index+'">'+dum_input_option+'</select> '+limb_edit_box+' </div></td>\
        <td><input type="text" class="form-control" id="input_p_import_'+index+'" name="input_p_import_'+index+'" value="'+p_import+'"></td>\
        <td><input type="text" class="form-control sub_weight" id="input_weight_'+index+'" name="input_weight_'+index+'" value="'+weight+'"></td>\
        <td><input type="text" class="form-control" id="input_detail_'+index+'" name="input_detail_'+index+'" value="'+detail+'"></td>\
        <td><span class="action-link text-success edit_save" id="'+index+'">ບັນທຶກ</span> | \
            <span class="action-link text-muted edit_cancel" id="'+index+'">ຍົກເລີກ</span></td>\
      </tr>';

      $('#build').append(display_dum + input_dum);
      SelectElement("input_t_model_"+index, t_model);
      SelectElement("input_t_model_round_"+index, tell_round);
      SelectElement("tell_round", '1');
      $('.show_rem').text(rem + '/5').show();

      $('#plate').val(''); $('#d_name').val(''); $('#weight').val('');
    });

    var dum_plate='', dum_d_name='', dum_t_model='', dum_p_import='', dum_weight='', dum_detail='';
    $('#build').on('click','.edit',function(){
      let i = $(this).attr("id");
      $("#display_"+i).hide(); $("#input_"+i).show();

      dum_plate = jugtext($('#input_plate_'+i).val());
      dum_d_name= jugtext($('#input_d_name_'+i).val());
      let dum_t_model_id = Number($('#display_t_model_'+i).attr('data-value'));
      let fetch_t_model = arr_t_model.find(x=>x.id===dum_t_model_id);
      dum_t_model = fetch_t_model.name;
      SelectElement("input_t_model_"+i, dum_t_model_id);
      dum_p_import = jugtext($('#input_p_import_'+i).val());
      dum_weight   = jugtext($('#input_weight_'+i).val());
      dum_detail   = jugtext($('#input_detail_'+i).val());
    });

    $('#build').on('click','.edit_cancel',function(){
      let i = $(this).attr("id");
      $('#display_plate_'+i).html(dum_plate);
      $('#display_d_name_'+i).html(dum_d_name);
      $('#display_t_model_'+i).html(dum_t_model);
      $('#display_p_import_'+i).html(dum_p_import);
      $('#display_weight_'+i).html(dum_weight);
      $('#display_detail_'+i).html(dum_detail);

      $('#input_plate_'+i).val(dum_plate);
      $('#input_d_name_'+i).val(dum_d_name);
      $('#input_t_model_'+i).val(dum_t_model);
      $('#input_p_import_'+i).val(dum_p_import);
      $('#input_weight_'+i).val(dum_weight);
      $('#input_detail_'+i).val(dum_detail);

      $("#input_"+i).hide(); $("#display_"+i).show();
      dum_plate=dum_d_name=dum_t_model=dum_p_import=dum_weight=dum_detail='';
    });

    $('#build').on('click','.edit_save',function(){
      let i = $(this).attr("id");
      let v_plate = jugtext($('#input_plate_'+i).val());
      let v_dname = jugtext($('#input_d_name_'+i).val());
      let v_t = Number($('#input_t_model_'+i).val());
      $('#display_t_model_'+i).attr('data-value', v_t);
      let fetch_t_model = arr_t_model.find(x=>x.id===v_t);
      let v_import = jugtext($('#input_p_import_'+i).val());
      let v_weight = jugtext($('#input_weight_'+i).val());
      let v_detail = jugtext($('#input_detail_'+i).val());

      if(!v_plate){ showAlert("** ກະລຸນາລະບຸ: <u>ປ້າຍທະບຽນລົດ</u>"); return; }
      if(!v_dname){ showAlert("** ກະລຸນາລະບຸ: <u>ຊື່ຄົນຂັບ</u>"); return; }
      if(!v_t){ showAlert("** ກະລຸນາລະບຸ: <u>ປະເພດລົດ</u>"); return; }
      if(!v_import){ showAlert("** ກະລຸນາລະບຸ: <u>ປະເພດສິນຄ້ານຳເຂົ້າ</u>"); return; }
      if(!v_weight){ showAlert("** ກະລຸນາລະບຸ: <u>ນ້ຳໜັກສະເລ່ຍ</u>"); return; }
      if(!v_detail){ showAlert("** ກະລຸນາລະບຸ: <u>ເລກທີນຳເຂົ້າ</u>"); return; }

      $('#display_plate_'+i).html(v_plate);
      $('#display_d_name_'+i).html(v_dname);
      $('#display_t_model_'+i).html(fetch_t_model.name);
      $('#display_p_import_'+i).html(v_import);
      $('#display_weight_'+i).html(v_weight);
      $('#display_detail_'+i).html(v_detail);

      $("#input_"+i).hide(); $("#display_"+i).show();
    });

    $('#build').on('click','.delete',function(e){
      if(!confirm("Are you sure?")) return false;
      let i = $(this).attr("id");

      $('#input_plate_'+i).val("this_delete");
      $('#input_d_name_'+i).val("");
      $('#input_t_model_'+i).val("");
      $('#input_p_import_'+i).val("");
      $('#input_weight_'+i).val("");
      $('#input_detail_'+i).val("");

      $('#display_'+i).hide(); $('#input_'+i).hide();
      rem -= 1;
      $('.show_rem').text(rem + '/5').toggle(rem > 0);
      return false;
    });

    function blockAndSpin(){
      let html = '<center><div class="spinner"><div class="q"></div></div></center>';
      showAlert(html);
    }

    $('#save').on('click', function(e){
      let address=$('#address').val(), district=$('#district').val(), province=$('#province').val();
      if(index===0){ showAlert('ກະລຸນາລະບຸຂໍ້ມູນລົດ ທະບຽນລົດ, ປະເພດລົດ, ຊື່ຜູ້ຂັບ ...'); return; }
      if(!address || !district || !province){
        showAlert('ກະລຸນາລະບຸປາຍທາງ ບ້ານ-ເມືອງ-ແຂວງ');
        $('#address').focus(); return;
      }

      blockAndSpin();
      $('#index').val(index);
      $('#save').prop('disabled', true);
      e.preventDefault();

      let deta = new FormData($('#form-data')[0]);
      $.ajaxSetup({ headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

      $.ajax({
        type:"post", url:"/enter/save", data:(deta), dataType:"json",
        async:false, cache:false, contentType:false, processData:false,
        success:function(){ showAlert("ສົ່ງຂໍ້ມູນສຳເລັດ"); window.location.reload(); },
        complete:function(){ showAlert("ສົ່ງຂໍ້ມູນສຳເລັດ"); },
        error:function(jq,x,err){
          if(err==='Payload Too Large'){
            showAlert("ຂະໜາດ File ລວມ ມີຂະໜາດເກີນ 1.5Mb");
            $('#save').prop('disabled', false);
          }else{
            showAlert("ການສົ່ງຊໍ້ມູນຜິດພາດກະລຸນາສົ່ງໃຫມ່");
          }
        }
      });
    });

    $('#draft').on('click', function(e){
      let address=$('#address').val(), district=$('#district').val(), province=$('#province').val();
      if(index===0){ showAlert('ກະລຸນາລະບຸຂໍ້ມູນລົດ ທະບຽນລົດ, ປະເພດລົດ, ຊື່ຜູ້ຂັບ ...'); return; }
      if(!address || !district || !province){
        showAlert('ກະລຸນາລະບຸປາຍທາງ ບ້ານ-ເມືອງ-ແຂວງ'); $('#address').focus(); return;
      }

      blockAndSpin();
      $('#index').val(index);
      $('#draft').prop('disabled', true);
      e.preventDefault();

      let deta = new FormData($('#form-data')[0]);
      $.ajaxSetup({ headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

      $.ajax({
        type:"post", url:"/enter/draft", data:(deta), dataType:"json",
        async:false, cache:false, contentType:false, processData:false,
        success:function(){ window.location.reload(); }
      });
    });

    $('.round-check').on('change' ,function(){
      let check = $(this).find(':selected').attr('data-round');
      if(check==='1')
      {
        $('#round').show();
        SelectElement("tell_round", '1');
        $('#forage').css('width', 'auto');
      }
      else
      {
        $('#round').hide();
        SelectElement("tell_round", '1');
        $('#forage').css('width', '100%');
      }
    });

    $.ajaxSetup({ headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    ['address','district','province','p_import','detail'].forEach(function(id){
      let el=document.querySelector('#'+id); if(!el) return;
      el.addEventListener('input', function(){
        $.post('/enter/update-session', { value:this.value, input:id });
      });
    });
  </script>
</x-app-layout>
