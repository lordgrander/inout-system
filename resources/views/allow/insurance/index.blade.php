<x-app-layout>
  <style>
    :root{
      --ink:#0f172a; --sub:#475569; --line:#e2e8f0; --soft:#f8fafc; --brand:#0a4e9b;
    }
    body{color:var(--ink)}
    .card-elev{border:1px solid var(--line);border-radius:14px;box-shadow:0 6px 18px rgba(2,8,23,.06)}
    .card-hdr{padding:14px 16px;border-bottom:1px solid var(--line);background:linear-gradient(180deg,#fff,#fbfdff);display:flex;align-items:center;justify-content:space-between}
    .card-hdr .title{font-weight:800;font-size:18px}
    .hint{color:var(--sub);font-size:12px}
    .k{font-size:12px;color:var(--sub);margin-bottom:6px;font-weight:bold;}
    .table_display_data{overflow-x:auto;white-space:nowrap}
    .table thead th{background:var(--soft);border-bottom:1px solid var(--line)}
    .table td,.table th{vertical-align:middle}
    .btn-outline-success{border-radius:10px}
    .action-link{cursor:pointer;font-weight:600}
    .action-link:hover{text-decoration:underline}

    /* modal */
    #modal{display:none;position:fixed;z-index:1000;inset:0;background:rgba(0,0,0,.35)}
    #modal-content{background:#fff;border:2px solid #1c73ff;border-radius:12px;width:min(520px,90%);margin:15% auto;padding:18px}
    .display_msg{margin:0;font-size:15px}

    /* spinner */
    .spinner{display:inline-block;position:relative;width:64px;height:64px}
    .q{box-sizing:border-box;display:block;position:absolute;width:40%;height:40%;top:30%;left:30%;border-radius:50%;border:6px solid #000;border-color:#000 transparent transparent transparent;animation:spin 1.2s linear infinite}
    @keyframes spin{to{transform:rotate(360deg)}}

    /* grid */
    .grid-container{display:grid;grid-template-columns:repeat(3,1fr);grid-gap:12px}
    .grid-item{padding:0}
  </style>



  <div class="py-3 laos">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      {{-- section: vehicle info --}}
      <div class="card-elev bg-white overflow-hidden sm:rounded-lg mb-3">
        <div class="card-hdr">
            <div class="title">ແຈ້ງປະກັນໄພລົດລ່ວງໜ້າ</div>

            <span class="hint  ">
                <div class="display-info" id="displayInsuranceInfo">
                <em class="text-muted">ຍັງບໍ່ໄດ້ເລືອກປະກັນ</em>
                </div>

                <button class="btn btn-outline-primary mt-1" id="btn_popup_insurance">
                    ເລືອກປະກັນລົດ
                </button>
            </span>
        </div>
        <div class="p-3">
          <div class="row" id="formData">
            <div class="col-md-6">
              <div class="k text-danger">*ທະບຽນຫົວລົດ</div>
              <input type="text" class="form-control" id="plate" placeholder="ທະບຽນຫົວລົດ">  
             
              <div class="k mt-3">ແນບເອກະສານສະເພາະໜື່ງຄັນ</div>
              
              <input type="file" class="form-control" id="out_file" accept=".pdf,.jpg,.jpeg,.png">

              <div class="k mt-3">ວັນທີລົດເຂົ້າດ່ານ</div>
                <div class="d-flex justify-content-start gap-2">
                    <select name="" id="select_date" class="text-center form-control" style="width:80px;">
                        @for ($i=1; $i <=31; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>

                    <select name="" id="select_month" class="text-center form-control" style="width:80px;">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>

                    <select name="" id="select_year" class="text-center form-control" style="width:100px;">
                        @for ($i = 2025; $i <= 2035; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select> 
                </div>

            </div>

            <div class="col-md-6">
              <div class="k">ທະບຽນຫາງລົດ</div>
              <input type="text" class="form-control" id="end_plate" placeholder="ທະບຽນຫາງລົດ">

              <div class="k mt-3">ປະເພດລົດ</div>
              <select id="t_model" class="form-control">
                @foreach ($beta_t_type as $row)
                  <option value="{{ $row->t_type_id }}">{{ $row->t_type_name }}</option>
                @endforeach
              </select>
            <div class="hidden">
                <div class="k mt-3">ເລກຖັງລົດ</div>
                <input type="text" class="form-control" id="engine_number" placeholder="ເລກຖັງລົດ" style="color:#797a7c!important;" value="">
            </div>
              
              <div class="hint mt-1">&nbsp;</div> 
              
              <div class="text-right mt-4">
                <button type="button" class="btn btn-outline-success" id="add">
                  ບັນທຶກຂໍ້ມູນ 
                </button>
              </div>
            </div>
          </div>
        </div>
      </div> 

      <div class="card-elev bg-white overflow-hidden sm:rounded-lg mb-3">
        <div class="card-hdr">
          <div class="title">ລາຍການປະກັນລົດ</div>
          <!-- <span class="hint">ເພີ່ມລາຍການລົດແຕ່ລະຄັນ ແລ້ວກົດ “ເພີ່ມຂໍ້ມູນ”</span> -->
        </div> 
        <div class="p-3">
          <div class="row">
            <div class="col-md-12">
                <!-- this part just for display here do can ignore it we gonna doo it for next path -->
                <table class="table table-bordered">
                    <tr>
                        <th class="text-center">ລ/ດ</th>
                        <th class="text-center">ວັນທີລົງ</th>
                        <th class="text-center">ວັນທີໝົດອາຍຸ</th>
                        <th class="text-center">ທະບຽນຫົວລົດ</th>
                        <th class="text-center">ທະບຽນທ້າຍລົດ</th>
                        <th class="text-center">ເລກຈັກລົດ</th>
                        <th class="text-center">ເອກະສານປະກັນ</th>
                        <th class="text-center">ສະຖານະປະກັນ</th>
                    </tr>
                    @php($count= 1)
                    <!-- loop here -->
                     @foreach ($beta_cars as $car) 
                        <tr>
                            <td class="text-center">{{ $count++ }}</td>
                            <td class="text-center">{{ date('d-m-Y',strtotime($car->created_at)) }}</td>
                            <td class="text-center">{{ date('d-m-Y',strtotime($car->created_at)) }}</td>
                            <td class="text-center">{{ $car->plate_number }}</td>
                            <td class="text-center">{{ $car->end_plate_number }}</td>
                            <td class="text-center">{{ $car->engine_number }}</td>
                            <td class="text-center">
                                <a href="{{ $car->file_url }}"><button class="btn btn-outline-dark">File</button></a>
                            </td>
                            <td class="text-center">
                                {{ 'ສະຖານະປະກັນ' }}
                            </td>
                        </tr> 
                     @endforeach
                    <!-- loop end --> 
                </table>
                <div class="text-end"> Page pagination</div>
            </div>
 
          </div>
        </div>
      </div> 
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
 <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    $(document).ready(function () {

     function renderInsuranceInfo() {
            const box = $('#displayInsuranceInfo');

            if (!selectedInsurance.insurance_id) {
                box.html('<em class="text-muted">ຍັງບໍ່ໄດ້ເລືອກປະກັນ</em>');
                return;
            }

            box.html(`
                <div style="line-height:1.4">
                <strong>${selectedInsurance.insurance_name}</strong><br>
                <span class="text-muted">
                    ${selectedInsurance.insurance_type_name}
                </span><br>
                <span style="color:#0a4e9b;font-weight:700">
                    ${Number(selectedInsurance.price).toLocaleString()} LAK
                </span>
                </div>
            `);
        }

        const INSURANCES = @json($beta_insurance ?? []); 
        const INS_TYPES  = @json($beta_insurance_type ?? []);

        let selectedInsurance = {
            insurance_id: null,
            insurance_name: null,
            insurance_type_id: null,
            insurance_type_name: null,
            price: null,
            image_url: null
        };

        function showError(msg){
            Swal.fire({ icon:'error', title:'ຜິດພາດ', text: msg });
        }

        function money(n){
            if(n === null || n === undefined || n === '') return '-';
            const x = String(n).replace(/,/g,'');
            if(isNaN(x)) return n;
            return Number(x).toLocaleString();
        }

         // ===== Premium Insurance Picker (3-step) =====
const INS_ASSET_BASE = ''; // if your images need prefix like '/storage/' then set: '/storage/'

function safeImg(url){
  if(!url) return null;
  // if already absolute or starts with / keep it
  if(/^https?:\/\//i.test(url) || url.startsWith('/')) return url;
  return INS_ASSET_BASE + url;
}

function getInsuranceId(row){
  return row.id ?? row.insurance_id ?? row.value;
}
function getInsuranceName(row){
  return row.name ?? row.insurance_name ?? row.title ?? ('Insurance #' + getInsuranceId(row));
}
function getInsuranceImage(row){
  // your new db column: images_url
  return safeImg(row.images_url ?? row.image_url ?? row.logo_url ?? row.image ?? row.photo_url ?? null);
}
function getTypeId(t){
  return t.id ?? t.type_id ?? t.insurance_type_id;
}
function getTypeName(t){
  return t.type_name ?? t.name ?? t.insurance_type_name ?? ('Type #' + getTypeId(t));
}
function getTypePrice(t){
  return t.price ?? t.amount ?? t.cost ?? null;
}
function getTypeImage(t){
  // sometimes type can have image too; fallback to insurance logo later
  return safeImg(t.image_url ?? t.images_url ?? t.image ?? t.photo_url ?? null);
}

function premiumSwalBase(){
  return {
    background: '#ffffff',
    color: '#0f172a',
    confirmButtonColor: '#0b5ed7',
    cancelButtonColor: '#e2e8f0',
    reverseButtons: true,
    customClass: {
      popup: 'murphy-premium-swal',
      confirmButton: 'murphy-swal-confirm',
      cancelButton: 'murphy-swal-cancel',
      title: 'murphy-swal-title',
      htmlContainer: 'murphy-swal-html'
    }
  };
}

// inject premium styles once
(function injectPremiumSwalCss(){
  if(document.getElementById('murphyPremiumSwalCss')) return;
  const css = `
  <style id="murphyPremiumSwalCss">
    .murphy-premium-swal{
      border: 1px solid rgba(15,23,42,.12)!important;
      border-radius: 18px!important;
      box-shadow: 0 18px 55px rgba(2,8,23,.15)!important;
      padding: 16px 16px 12px!important;
    }
    .murphy-swal-title{
      font-weight: 900!important;
      letter-spacing: .2px;
      color:#0a4e9b!important;
    }
    .murphy-swal-html{ margin-top: 10px!important; }
    .murphy-swal-confirm{
      border-radius: 12px!important;
      padding: 10px 18px!important;
      font-weight: 800!important;
      box-shadow: 0 10px 24px rgba(11,94,215,.22)!important;
    }
    .murphy-swal-cancel{
      border-radius: 12px!important;
      padding: 10px 18px!important;
      font-weight: 800!important;
      color:#0f172a!important;
      background:#eef2ff!important;
    }

    .murphy-grid{
      display:grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 12px;
    }
    @media (max-width: 640px){
      .murphy-grid{ grid-template-columns: repeat(2, 1fr); }
    }
    .murphy-card{
      border: 1px solid rgba(15,23,42,.10);
      border-radius: 16px;
      overflow:hidden;
      background: linear-gradient(180deg,#fff,#f8fbff);
      cursor:pointer;
      transition: transform .12s ease, box-shadow .12s ease, border-color .12s ease;
      box-shadow: 0 10px 24px rgba(2,8,23,.06);
    }
    .murphy-card:hover{
      transform: translateY(-2px);
      box-shadow: 0 14px 34px rgba(2,8,23,.10);
      border-color: rgba(10,78,155,.35);
    }
    .murphy-card.active{
      border-color: rgba(11,94,215,.85);
      box-shadow: 0 0 0 3px rgba(11,94,215,.15), 0 14px 34px rgba(2,8,23,.10);
    }
    .murphy-card .imgbox{
      width:100%;
      aspect-ratio: 1 / 1;
      background: #f1f5f9;
      display:flex;
      align-items:center;
      justify-content:center;
    }
    .murphy-card img{
      width:100%;
      height:100%;
      object-fit:cover;
    }
    .murphy-card .name{
      padding: 10px 10px 12px;
      text-align:center;
      font-weight: 900;
      font-size: 13px;
      color:#0f172a;
      line-height: 1.2;
    }
    .murphy-top-logo{
      width: 110px;
      height: 110px;
      border-radius: 18px;
      overflow:hidden;
      margin: 0 auto 12px;
      border: 1px solid rgba(15,23,42,.12);
      box-shadow: 0 10px 24px rgba(2,8,23,.08);
      background:#f1f5f9;
    }
    .murphy-top-logo img{ width:100%; height:100%; object-fit:cover; }
    .murphy-list{
      display:flex;
      flex-direction:column;
      gap:10px;
      text-align:left;
    }
    .murphy-row{
      border: 1px solid rgba(15,23,42,.10);
      border-radius: 14px;
      padding: 12px 12px;
      cursor:pointer;
      background:#fff;
      transition: border-color .12s ease, box-shadow .12s ease, transform .12s ease;
      box-shadow: 0 10px 22px rgba(2,8,23,.05);
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:10px;
    }
    .murphy-row:hover{
      transform: translateY(-1px);
      border-color: rgba(10,78,155,.35);
      box-shadow: 0 14px 30px rgba(2,8,23,.08);
    }
    .murphy-row.active{
      border-color: rgba(11,94,215,.85);
      box-shadow: 0 0 0 3px rgba(11,94,215,.15), 0 14px 30px rgba(2,8,23,.08);
    }
    .murphy-row .left{
      display:flex; flex-direction:column; gap:2px;
    }
    .murphy-row .tname{ font-weight:900; color:#0f172a; }
    .murphy-row .sub{ font-size:12px; color:#64748b; }
    .murphy-row .price{
      font-weight: 1000;
      color:#0a4e9b;
      white-space:nowrap;
    }

    .murphy-preview{
      border: 1px solid rgba(15,23,42,.10);
      border-radius: 18px;
      padding: 14px;
      background: linear-gradient(180deg,#ffffff,#f7fbff);
      box-shadow: 0 14px 34px rgba(2,8,23,.08);
      text-align:left;
    }
    .murphy-kv{ display:grid; grid-template-columns: 110px 1fr; gap: 8px 10px; }
    .murphy-kv .k{ color:#64748b; font-weight:700; font-size:12px; }
    .murphy-kv .v{ color:#0f172a; font-weight:900; }
  </style>`;
  $('head').append(css);
})();

function renderInsuranceInfo(){
  // show picked info in header (your .display-info)
  const $box = $('.display-info');
  if(!$box.length) return;

  if(!selectedInsurance.insurance_id){
    $box.html(`<span class="text-muted">— ຍັງບໍ່ໄດ້ເລືອກປະກັນ</span>`);
    return;
  }

  const img = selectedInsurance.image_url
    ? `<img src="${selectedInsurance.image_url}" style="width:42px;height:42px;border-radius:12px;object-fit:cover;border:1px solid #e2e8f0;margin-right:10px" />`
    : '';

  $box.html(`
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px">
      ${img}
      <div>
        <div style="font-weight:900;color:#0a4e9b">${selectedInsurance.insurance_name || '-'}</div>
        <div style="font-size:12px;color:#475569;font-weight:700">
          ${selectedInsurance.insurance_type_name || '-'} • ${money(selectedInsurance.price)}
        </div>
      </div>
    </div>
  `);
}

$('#btn_popup_insurance').on('click', async function(){

  // ===== Step 1: choose insurance (grid with image) =====
  const insList = (INSURANCES || [])
    .map(r => {
      const id = getInsuranceId(r);
      if(!id) return null;
      return {
        id: parseInt(id,10),
        name: getInsuranceName(r),
        image_url: getInsuranceImage(r)
      };
    })
    .filter(Boolean);

  if(insList.length === 0) return showError('ບໍ່ພົບລາຍຊື່ປະກັນ');

  const step1Html = `
    <div style="text-align:left;margin-bottom:10px;color:#64748b;font-weight:700">
      ເລືອກບໍລິສັດປະກັນ ​
    </div>
    <div class="murphy-grid" id="insGrid">
      ${insList.map(x => `
        <div class="murphy-card" data-id="${x.id}">
          <div class="imgbox">
            ${x.image_url
              ? `<img src="${x.image_url}" alt="${x.name}">`
              : `<div style="color:#94a3b8;font-weight:900">NO IMAGE</div>`
            }
          </div>
          <div class="name">${x.name}</div>
        </div>
      `).join('')}
    </div>
    <input type="hidden" id="picked_insurance_id" value="">
  `;

  const step1 = await Swal.fire({
    ...premiumSwalBase(),
    title: '1) ເລືອກຊື່ປະກັນ',
    html: step1Html,
    showCancelButton: true,
    confirmButtonText: 'ຕໍ່ໄປ',
    cancelButtonText: 'ຍົກເລີກ',
    preConfirm: () => {
      const v = $('#picked_insurance_id').val();
      if(!v) {
        Swal.showValidationMessage('ກະລຸນາເລືອກປະກັນ');
        return false;
      }
      return v;
    },
    didOpen: () => {
      // click select card
      $('#insGrid .murphy-card').on('click', function(){
        $('#insGrid .murphy-card').removeClass('active');
        $(this).addClass('active');
        $('#picked_insurance_id').val($(this).data('id'));
      });
    }
  });

  if(!step1.isConfirmed) return;

  const insurance_id = parseInt(step1.value, 10);
  const chosenIns = insList.find(x => x.id === insurance_id);
  const insurance_name = chosenIns?.name || ('Insurance #' + insurance_id);
  const insurance_logo = chosenIns?.image_url || null;

  // ===== Step 2: choose type (filtered + image top + list) =====
  const types = (INS_TYPES || []).filter(t => {
    const fk = t.insurance_id ?? t.insuranceId ?? t.parent_id;
    return parseInt(fk,10) === insurance_id;
  });

  if(types.length === 0) return showError('ປະກັນນີ້ບໍ່ມີປະເພດ/ລາຄາ');

  const mappedTypes = types.map(t => {
    const id = parseInt(getTypeId(t),10);
    return {
      id,
      name: getTypeName(t),
      price: getTypePrice(t),
      image_url: getTypeImage(t) // may be null
    };
  }).filter(x => x.id);

  const step2Html = `
    <div class="murphy-top-logo">
      ${insurance_logo
        ? `<img src="${insurance_logo}" alt="logo">`
        : `<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#94a3b8;font-weight:900">LOGO</div>`
      }
    </div>
    <div style="text-align:center;margin-bottom:10px">
      <div style="font-weight:1000;color:#0a4e9b">${insurance_name}</div>
      <div style="font-size:12px;color:#64748b;font-weight:700">ເລືອກປະເພດ + ລາຄາ</div>
    </div>

    <div class="murphy-list" id="typeList">
      ${mappedTypes.map(x => `
        <div class="murphy-row" data-id="${x.id}">
          <div class="left">
            <div class="tname">${x.name}</div>
            <div class="sub">ID: ${x.id}</div>
          </div>
          <div class="price">${money(x.price)}</div>
        </div>
      `).join('')}
    </div>
    <input type="hidden" id="picked_type_id" value="">
  `;

  const step2 = await Swal.fire({
    ...premiumSwalBase(),
    title: '2) ເລືອກປະເພດ',
    html: step2Html,
    showCancelButton: true,
    confirmButtonText: 'ຕໍ່ໄປ',
    cancelButtonText: 'ກັບຄືນ',
    preConfirm: () => {
      const v = $('#picked_type_id').val();
      if(!v) {
        Swal.showValidationMessage('ກະລຸນາເລືອກປະເພດ (แตะที่รายการ)');
        return false;
      }
      return v;
    },
    didOpen: () => {
      $('#typeList .murphy-row').on('click', function(){
        $('#typeList .murphy-row').removeClass('active');
        $(this).addClass('active');
        $('#picked_type_id').val($(this).data('id'));
      });
    }
  });

  if(!step2.isConfirmed) return;

  const insurance_type_id = parseInt(step2.value, 10);
  const picked = mappedTypes.find(x => x.id === insurance_type_id);

  const insurance_type_name = picked?.name || ('Type #' + insurance_type_id);
  const price = picked?.price ?? null;

  // prefer type image; fallback to insurance logo
  const image_url = picked?.image_url || insurance_logo || null;

  // ===== Step 3: preview + confirm (premium card) =====
  const imgHtml = image_url
    ? `<div style="width:220px;aspect-ratio:1/1;margin:12px auto;border-radius:18px;overflow:hidden;border:1px solid rgba(15,23,42,.12);box-shadow:0 14px 34px rgba(2,8,23,.10)">
         <img src="${image_url}" style="width:100%;height:100%;object-fit:cover" />
       </div>`
    : `<div style="text-align:center;color:#94a3b8;font-weight:900;margin:10px 0">(ບໍ່ມີຮູບ)</div>`;

  const step3 = await Swal.fire({
    ...premiumSwalBase(),
    title: '3) ກວດສອບກ່ອນຢືນຢັນ',
    html: `
      <div class="murphy-preview">
        <div style="text-align:center;margin-bottom:10px">
          <div style="font-weight:1000;color:#0a4e9b">Payment Summary</div>
          <div style="font-size:12px;color:#64748b;font-weight:700">ກວດສອບຂໍ້ມູນກ່ອນບັນທຶກ</div>
        </div>
        ${imgHtml}
        <div class="murphy-kv">
          <div class="k">ປະກັນ</div><div class="v">${insurance_name}</div>
          <div class="k">ປະເພດ</div><div class="v">${insurance_type_name}</div>
          <div class="k">ລາຄາ</div><div class="v" style="color:#0a4e9b">${money(price)}</div>
        </div>
      </div>
    `,
    showCancelButton: true,
    confirmButtonText: 'ຢືນຢັນ',
    cancelButtonText: 'ຍົກເລີກ'
  });

  if(!step3.isConfirmed) return;

  // Save selection to JS state
  selectedInsurance = {
    insurance_id,
    insurance_name,
    insurance_type_id,
    insurance_type_name,
    price,
    image_url
  };

  renderInsuranceInfo();

  Swal.fire({
    ...premiumSwalBase(),
    icon: 'success',
    title: 'ເລືອກສຳເລັດ',
    html: `<div style="font-weight:900;color:#0f172a">${insurance_name}</div>
           <div style="color:#64748b;font-weight:700;font-size:12px">${insurance_type_name} • ${money(price)}</div>`,
    timer: 1400,
    showConfirmButton: false
  });
});

 
        function showError(msg){
            alert(msg); // swap to Swal later if you want
        }

            $('#add').on('click', function(){

                const plate         = ($('#plate').val() || '').trim();
                const end_plate     = ($('#end_plate').val() || '').trim();
                const t_type_id     = $('#t_model').val();
                const engine_number = ($('#engine_number').val() || '0').trim();
                const fileEl        = document.getElementById('out_file');
                const file          = fileEl && fileEl.files && fileEl.files[0] ? fileEl.files[0] : null;
                const select_date   = $('#select_date').val();
                const select_month  = $('#select_month').val();
                const select_year   = $('#select_year').val();
                const exp = `${select_year}-${String(select_month).padStart(2,'0')}-${String(select_date).padStart(2,'0')}`;

                // ✅ basic validation
                if(!plate) return showError('ກະລຸນາປ້ອນ ທະບຽນຫົວລົດ');
                if(!t_type_id) return showError('ກະລຸນາເລືອກ ປະເພດລົດ');
                // if(!engine_number) return showError('ກະລຸນາປ້ອນ ເລກຖັງລົດ');
                if(!file) return showError('ກະລຸນາແນບເອກະສານປະກັນ');

                 

                // ✅ build FormData
                const fd = new FormData();
                fd.append('plate_number', plate);
                fd.append('end_plate_number', end_plate);
                fd.append('t_type_id', t_type_id);
                fd.append('engine_number', engine_number);
                fd.append('file_url', file); // name "file_url" matches controller validation
                fd.append('exp_date', exp);

                                // only append if picked
                if (selectedInsurance.insurance_id) {
                    fd.append('insurance_id', selectedInsurance.insurance_id);
                }
                if (selectedInsurance.insurance_type_id) {
                    fd.append('insurance_type_id', selectedInsurance.insurance_type_id);
                }
 

                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });

                // lock button vibe
                $('#add').prop('disabled', true).text('ກຳລັງບັນທຶກ...');

                $.ajax({
                url: "{{ route('Enter.insurance.store') }}",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                dataType: "json",

                success: function(res){
                    if(res.status === 200){
                        Swal.fire({ icon:'success', title:'ສຳເລັດ', text:'ກະລຸນານຳເອົາສຳເນົາທີ່ຖືກຕ້ອງແຈ້ງຕໍ່ເຈົ້າໜ້າທີ່ຫ້ອງການບໍລິຫານດ່ານ' });

                        // reset form
                        $('#plate').val('');
                        $('#end_plate').val('');
                        $('#engine_number').val('');
                        $('#out_file').val('');

                        // optional: refresh page or append to table later
                        // location.reload();
                    } else {
                        showError(res.message || 'ບັນທຶກບໍ່ສຳເລັດ');s
                    }
                },

                error: function(xhr){
                    let msg = 'ມີບັນຫາໃນການບັນທຶກ';
                    if(xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                    if(xhr.responseJSON && xhr.responseJSON.errors){
                    // show first validation error
                    const firstKey = Object.keys(xhr.responseJSON.errors)[0];
                    if(firstKey) msg = xhr.responseJSON.errors[firstKey][0];
                    }
                    showError(msg);
                },

                complete: function(){
                    $('#add').prop('disabled', false).text('ບັນທຶກຂໍ້ມູນ');
                }
                });

            });

            $(document).on('change', '#out_file', function () {
                const input = this;
                const file = input.files && input.files[0] ? input.files[0] : null;
                if (!file) return;

                // basic guard
                const maxMB = 15; // match your controller 15MB
                const isTooBig = file.size > maxMB * 1024 * 1024;
                if (isTooBig) {
                Swal.fire({ icon:'error', title:'ໄຟລໃຫຍ່ເກີນໄປ', text:`ບໍ່ໃຫ້ເກີນ ${maxMB}MB` });
                input.value = '';
                return;
                }

                const type = (file.type || '').toLowerCase();
                const name = file.name || 'file';
                const isImg = type.startsWith('image/');
                const isPdf = type === 'application/pdf' || name.toLowerCase().endsWith('.pdf');

                if (!isImg && !isPdf) {
                Swal.fire({ icon:'error', title:'ບໍ່ຮອງຮັບເອກະສານ', text:'ຮັບສະເພາະ PDF, JPG, JPEG, PNG' });
                input.value = '';
                return;
                }

                const url = URL.createObjectURL(file);

                const previewHtml = isImg
                ? `
                    <div style="display:flex;justify-content:center">
                    <img src="${url}" alt="preview" style="max-width:100%;max-height:60vh;border-radius:12px;border:1px solid #e2e8f0" />
                    </div>`
                : `
                    <div style="height:60vh;border-radius:12px;overflow:hidden;border:1px solid #e2e8f0">
                    <iframe src="${url}" style="width:100%;height:100%;border:0"></iframe>
                    </div>`;

                Swal.fire({
                title: 'Preview ເອກະສານປະກັນ',
                html: `
                    <div style="text-align:left;margin-bottom:10px">
                    <div><b>File:</b> ${name}</div>
                    <div><b>Size:</b> ${(file.size/1024/1024).toFixed(2)} MB</div>
                    </div>
                    ${previewHtml}
                `,
                showCancelButton: true,
                confirmButtonText: 'ໃຊ້ໄຟລ໌ນີ້',
                cancelButtonText: 'ບໍ່ໃຊ້',
                width: 720,
                didClose: () => URL.revokeObjectURL(url) // cleanup
                }).then((r) => {
                if (!r.isConfirmed) {
                    // user rejected → clear file
                    input.value = '';
                }
                });
            });

        });




            SelectElement("select_year",    "{{ date('Y') }}");  

        function SelectElement(id, valueToSelect)
        {    
              var element = document.getElementById(id);
              element.value = valueToSelect;
        }
       
</script>
</x-app-layout>
