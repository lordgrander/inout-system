<!doctype html>
<html lang="lo">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/x-icon" href="{{ asset('/images/favicon.svg') }}">
  <title>ຫ້ອງການບໍລິຫານ ດ່ານສາກົນສິນຄ້າ ທ່າບົກທ່ານາແລ້ງ</title>
  @php($routePrefix = $routePrefix ?? 'new-enter')
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Noto+Sans+Lao:wght@400;500;600;700&display=swap");
    :root{--bg:#fbfcfe;--card:#fff;--text:#171c24;--muted:#5f6b7a;--line:#d7dee8;--soft:#f5f7fa;--primary:#0a427a;--primary-2:#123f73;--danger:#dc2626;--danger-soft:#fee8e8;--green:#166534;--green-soft:#e7f6ec;--shadow:0 1px 2px rgba(16,24,40,.08),0 8px 24px rgba(16,24,40,.04);font-family:Inter,"Noto Sans Lao",ui-sans-serif,system-ui,sans-serif}
    *{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--text);font-size:14px;line-height:1.45}button,input,select,textarea{font:inherit}button{cursor:pointer}
    .topbar{position:sticky;top:0;z-index:100;border-bottom:1px solid var(--line);background:rgba(255,255,255,.96);backdrop-filter:blur(10px)}
    .topbar-inner{max-width:1400px;margin:0 auto;padding:12px 18px;display:grid;grid-template-columns:minmax(0,1fr) auto;gap:14px;align-items:center}
    .brand{min-width:0;display:flex;align-items:center;gap:12px}.brand-title{margin:0;font-size:14px;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.brand-sub{margin:0;font-size:12px;color:var(--muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .nav{display:flex;align-items:center;justify-content:flex-end;gap:6px}.nav-link,.logout-btn{min-height:40px;border:0;border-radius:8px;background:transparent;color:var(--muted);display:inline-flex;align-items:center;gap:8px;padding:9px 12px;font-weight:600;text-decoration:none}.nav-link:hover,.logout-btn:hover{background:var(--soft);color:var(--text)}.nav-link.active{background:var(--primary);color:#fff}.logout-btn{color:var(--danger)}
    .menu-btn{display:none;width:40px;height:40px;padding:0;border-radius:8px;border:1px solid var(--primary);background:var(--primary);color:#fff;align-items:center;justify-content:center;line-height:1;box-shadow:0 6px 16px rgba(10,66,122,.2);transition:.15s}.menu-btn:hover{background:var(--primary-2);border-color:var(--primary-2)}.menu-btn svg{display:block}.mobile-nav{display:none;position:fixed;top:61px;left:0;right:0;z-index:110;padding:8px 18px 12px;border-top:1px solid var(--line);border-bottom:1px solid var(--line);background:var(--card);box-shadow:0 14px 30px rgba(16,24,40,.12)}.mobile-nav.open{display:grid;gap:8px}.page-backdrop{display:none;position:fixed;inset:0;z-index:90;background:rgba(0,0,0,.2)}body.nav-open .page-backdrop{display:block}
    .main{max-width:1400px;margin:0 auto;padding:20px 18px 34px}.grid-form{display:grid;grid-template-columns:minmax(320px,420px) minmax(0,1fr);gap:20px;align-items:start}.panel{border:1px solid var(--line);border-radius:8px;background:var(--card);box-shadow:var(--shadow);overflow:hidden}.panel.sticky{position:sticky;top:84px}.panel-head{min-height:46px;padding:13px 16px;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;gap:12px}.panel-title{margin:0;display:flex;align-items:center;gap:8px;font-size:15px;font-weight:650}.panel-body{padding:16px}.section-gap{display:grid;gap:20px}
    .field-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}.field.full{grid-column:1/-1}label{display:block;margin-bottom:6px;font-size:12px;font-weight:600}.input,.select,.textarea{width:100%;border:1px solid #cdd6e1;border-radius:8px;background:var(--card);color:var(--text);outline:none;box-shadow:0 1px 2px rgba(16,24,40,.08)}.input,.select{height:40px;padding:8px 12px}.textarea{min-height:78px;resize:vertical;padding:10px 12px}.input:focus,.select:focus,.textarea:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(10,66,122,.13)}.hint,.error{margin:6px 0 0;font-size:12px}.hint{color:var(--muted)}.error{display:none;color:var(--danger);font-weight:600}.field.has-error .error,.error.show{display:block}.field.has-error .input,.field.has-error .select,.field.has-error .textarea{border-color:var(--danger)}
    .btn{min-height:40px;border-radius:8px;border:1px solid transparent;padding:8px 14px;display:inline-flex;align-items:center;justify-content:center;gap:8px;font-weight:650;text-decoration:none;white-space:nowrap;transition:.15s}.btn.primary{background:var(--primary);border-color:var(--primary);color:#fff}.btn.primary:hover{background:var(--primary-2)}.btn.secondary{background:var(--card);border-color:var(--line);color:var(--text)}.btn.secondary:hover{background:var(--soft)}.btn.danger{background:var(--card);border-color:var(--line);color:var(--danger)}.btn.danger:hover{background:var(--danger-soft)}.btn.small{min-height:32px;padding:6px 10px;font-size:13px}.btn:disabled{opacity:.6;cursor:not-allowed}.vehicle-actions{margin-top:18px}.vehicle-actions .btn{width:100%;min-height:44px}
    .counter{border:1px solid var(--line);background:var(--card);border-radius:8px;padding:4px 9px;text-align:center}.counter-value{font-size:14px;line-height:1.1;font-weight:700;color:var(--primary)}
    .table-wrap{width:100%;overflow-x:auto;border:1px solid var(--line);border-radius:8px}.panel>.table-wrap{border-left:0;border-right:0;border-bottom:0;border-radius:0}table{width:100%;border-collapse:collapse}th{background:var(--soft);color:var(--muted);font-size:12px;font-weight:650;text-align:left;padding:11px 16px;border-bottom:1px solid var(--line);white-space:nowrap}td{padding:13px 16px;border-bottom:1px solid var(--line);vertical-align:middle}tbody tr:last-child td{border-bottom:0}.empty-table{padding:28px 16px;text-align:center;color:var(--muted);font-weight:600}.row-actions{display:flex;align-items:center;justify-content:flex-end;gap:8px}.icon-btn{width:34px;height:34px;border-radius:8px;border:1px solid var(--line);background:var(--card);color:var(--text);display:inline-flex;align-items:center;justify-content:center;box-shadow:0 1px 2px rgba(16,24,40,.08)}.icon-btn.danger{color:var(--danger)}
    .destination-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px}.dropzone{border:1px dashed #c9d4e2;border-radius:8px;min-height:118px;display:grid;place-items:center;padding:18px;text-align:center;background:#fcfdff}.dropzone strong{display:block;margin-top:8px}.file-list{margin-top:12px;display:flex;gap:8px;flex-wrap:wrap}.file-chip{max-width:190px;min-height:30px;border:1px solid var(--line);border-radius:8px;background:var(--soft);padding:5px 8px;display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:500}.file-chip span{overflow:hidden;white-space:nowrap;text-overflow:ellipsis}.submit-panel{display:flex;align-items:center;justify-content:space-between;gap:14px;border:1px solid var(--line);border-radius:8px;background:var(--card);padding:16px;box-shadow:var(--shadow)}.submit-buttons{display:flex;align-items:center;justify-content:flex-end;gap:12px}
    .modal{display:none;position:fixed;inset:0;z-index:200;background:rgba(0,0,0,.28);align-items:center;justify-content:center;padding:18px}.modal.show{display:flex}.modal-card{width:min(430px,100%);border-radius:10px;background:#fff;box-shadow:0 24px 70px rgba(16,24,40,.25);padding:22px;text-align:center}.modal-icon{width:48px;height:48px;border-radius:99px;background:var(--green-soft);color:var(--green);display:grid;place-items:center;margin:0 auto 12px}.modal-card h2{margin:0;font-size:20px;font-weight:700}.modal-card p{margin:8px 0 18px;color:var(--muted)}
    .modal-card.wide{width:min(720px,100%);padding:0;text-align:left;overflow:hidden}.modal-head{padding:16px 18px;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;gap:12px}.modal-body{padding:16px;max-height:70vh;overflow:auto}.quota-toolbar{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:8px}.quota-list{display:grid;gap:10px}.quota-option{width:100%;border:1px solid var(--line);border-radius:8px;background:#fff;padding:12px;text-align:left;display:grid;gap:8px}.quota-option:hover{border-color:var(--primary);box-shadow:0 0 0 3px rgba(10,66,122,.08)}.quota-title{font-weight:700}.quota-meta{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:8px;color:var(--muted);font-size:12px}.quota-pick{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:8px;align-items:end}.quota-badge{display:inline-flex;align-items:center;gap:4px;border:1px solid #bfdbfe;background:#eff6ff;color:var(--primary);border-radius:999px;padding:2px 7px;font-size:11px;font-weight:700}.field-label-row{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:6px}.field-label-row label{margin:0}.quota-selected{margin-top:6px;color:var(--primary);font-size:12px;font-weight:700}.quota-selected:empty{display:none}
    .sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);border:0}
    @media(max-width:980px){.desktop-nav{display:none}.menu-btn{display:inline-flex}.grid-form{grid-template-columns:1fr}.panel.sticky{position:static}.destination-grid{grid-template-columns:1fr}.submit-panel{align-items:stretch;flex-direction:column}.submit-buttons{width:100%;display:grid;grid-template-columns:1fr}.field-grid{grid-template-columns:1fr}}
  </style>
</head>
<body>
  <div class="app">
    <header class="topbar">
      <div class="topbar-inner">
        <div class="brand">
          <div>
            <p class="brand-title">ຟອມຂໍອະນຸຍາດລົດ</p>
            <p class="brand-sub">{{ $company->com_name ?? 'No company' }}</p>
          </div>
        </div>
        <nav class="nav desktop-nav">
          <a class="nav-link active" href="{{ route($routePrefix.'.index') }}">ອອກໃບອະນຸຍາດ</a>
          <a class="nav-link" href="{{ route($routePrefix.'.documents') }}">ຕິດຕາມເອກະສານ</a>
          <a class="nav-link" href="{{ route($routePrefix.'.quotars') }}">ໂກຕ້າສິນຄ້າ</a>
          <form method="POST" action="{{ route($routePrefix.'.logout') }}">@csrf<button class="logout-btn" type="submit">ອອກຈາກລະບົບ</button></form>
        </nav>
        <button class="menu-btn" id="menuBtn" aria-label="Open navigation">
          <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16"></path><path d="M4 12h16"></path><path d="M4 18h16"></path></svg>
        </button>
      </div>
      <nav class="mobile-nav" id="mobileNav">
        <a class="nav-link active" href="{{ route($routePrefix.'.index') }}">ອອກໃບອະນຸຍາດ</a>
        <a class="nav-link" href="{{ route($routePrefix.'.documents') }}">ຕິດຕາມເອກະສານ</a>
        <a class="nav-link" href="{{ route($routePrefix.'.quotars') }}">ໂກຕ້າສິນຄ້າ</a>
        <form method="POST" action="{{ route($routePrefix.'.logout') }}">@csrf<button class="logout-btn" type="submit">ອອກຈາກລະບົບ</button></form>
      </nav>
    </header>
    <div class="page-backdrop" id="pageBackdrop"></div>

    <main class="main">
	      <form id="newEnterForm">
	        @csrf
        <div class="grid-form">
          <section class="panel sticky">
            <header class="panel-head">
              <h2 class="panel-title"><span id="vehiclePanelTitle">ຂໍ້ມູນລົດ</span></h2>
              <button class="btn secondary small" id="cancelEditBtn" type="button" style="display:none">ຍົກເລີກ</button>
            </header>
            <div class="panel-body">
              <div class="field-grid">
                <div class="field" data-field="plate"><label for="plate">ທະບຽນລົດ</label><input class="input" id="plate" placeholder="ຕົວຢ່າງ: 1234 VTE"><p class="error">ກະລຸນາລະບຸທະບຽນລົດ</p></div>
                <div class="field" data-field="driver"><label for="driver">ຊື່ຜູ້ຂັບ</label><input class="input" id="driver" placeholder="ຊື່ ແລະ ນາມສະກຸນ"><p class="error">ກະລຸນາລະບຸຊື່ຜູ້ຂັບ</p></div>
                <div class="field" data-field="weight"><label for="weight">ນ້ຳໜັກ</label><input class="input" id="weight" inputmode="decimal" placeholder="ຕົວຢ່າງ: 12.5"><p class="error">ກະລຸນາລະບຸນ້ຳໜັກ</p></div>
                <div class="field" data-field="type"><label for="vehicleType">ປະເພດລົດ</label><select class="select" id="vehicleType"><option value="">ເລືອກປະເພດລົດ</option></select><p class="error">ກະລຸນາເລືອກປະເພດລົດ</p></div>
                <div class="field" id="roundField" style="display:none"><label for="rounds">ຈຳນວນຖ້ຽວ</label><select class="select" id="rounds">@for($i=1;$i<=5;$i++)<option value="{{ $i }}">{{ $i }}</option>@endfor</select><p class="hint">ປະເພດລົດນີ້ສາມາດລະບຸຈຳນວນຖ້ຽວໄດ້</p></div>
                <div class="field" data-field="product"><div class="field-label-row"><label for="product">ສິນຄ້ານຳເຂົ້າ</label><button class="btn secondary small" id="openQuotaBtn" type="button">ເລືອກໂກຕ້າ</button></div><input class="input" id="product" placeholder="ຕົວຢ່າງ: ປູນຊີເມັນ"><p class="quota-selected" id="quotaSelectedText"></p><p class="error">ກະລຸນາລະບຸສິນຄ້ານຳເຂົ້າ</p></div>
                <div class="field full" data-field="reference"><label for="reference">ເລກທີເອກະສານນຳເຂົ້າ / ເລກອ້າງອີງ</label><input class="input" id="reference" placeholder="ຕົວຢ່າງ: INV-2026-0187"><p class="hint">ເລກພາສີ ຫຼື ເລກໃບບິນ</p><p class="error">ກະລຸນາລະບຸເລກອ້າງອີງ</p></div>
              </div>
              <div class="vehicle-actions"><button class="btn primary" id="addVehicleBtn" type="button">ເພີ່ມລົດ</button><p class="error" id="rowLimitError">ເພີ່ມລົດໄດ້ສູງສຸດ 5 ຄັນ</p></div>
            </div>
          </section>

          <div class="section-gap">
            <section class="panel">
              <header class="panel-head"><h2 class="panel-title">ລາຍການລົດທີ່ເພີ່ມ</h2><div class="counter"><div class="counter-value"><span id="vehicleCount">0</span>/5</div></div></header>
              <div class="table-wrap"><table><thead><tr><th>ທະບຽນ</th><th>ຜູ້ຂັບ</th><th>ປະເພດ</th><th>ຖ້ຽວ</th><th>ສິນຄ້າ</th><th>ນ້ຳໜັກ</th><th>ເລກອ້າງອີງ</th><th style="text-align:right">ຈັດການ</th></tr></thead><tbody id="vehicleRows"></tbody></table><div class="empty-table" id="vehicleEmpty">ຍັງບໍ່ມີລາຍການລົດ</div></div>
              <p class="error" id="rowsError" style="padding:0 16px 14px">ກະລຸນາເພີ່ມລົດຢ່າງໜ້ອຍ 1 ຄັນ</p>
            </section>

            <section class="panel"><header class="panel-head"><h2 class="panel-title">ປາຍທາງ</h2></header><div class="panel-body">
              <div class="destination-grid">
                <div class="field" data-field="village"><label for="village">ບ້ານ</label><input class="input" id="village" name="address" placeholder="ບ້ານ"><p class="error">ກະລຸນາລະບຸບ້ານ</p></div>
                <div class="field" data-field="district"><label for="district">ເມືອງ</label><input class="input" id="district" name="district" placeholder="ເມືອງ"><p class="error">ກະລຸນາລະບຸເມືອງ</p></div>
                <div class="field" data-field="province"><label for="province">ແຂວງ</label><input class="input" id="province" name="province" placeholder="ແຂວງ"><p class="error">ກະລຸນາລະບຸແຂວງ</p></div>
              </div>
              <div class="field" style="margin-top:16px"><label for="note">ໝາຍເຫດປາຍທາງພິເສດ (ຖ້າມີ)</label><textarea class="textarea" id="note" name="lasttails" placeholder="ຕົວຢ່າງ: ສົ່ງທີ່ສາງ B, ປະຕູ 2"></textarea><p class="hint">ຂໍ້ມູນປະຕູ, ສາງ ຫຼື ຄຳແນະນຳການຈັດສົ່ງ</p></div>
            </div></section>

            <section class="panel"><header class="panel-head"><h2 class="panel-title">ແນບໄຟລ໌ປະກອບ</h2></header><div class="panel-body">
              <label class="dropzone" for="files"><input id="files" name="upload_files[]" type="file" multiple accept=".pdf,.jpg,.jpeg,.png" class="sr-only"><span><strong>ເລືອກໄຟລ໌ເພື່ອແນບ</strong><span class="hint">PDF, JPG ຫຼື PNG</span></span></label><div class="file-list" id="selectedFiles"></div><input id="index" name="index" type="hidden">
            </div></section>

            <section class="submit-panel"><p class="hint" style="margin:0">  <strong style="color:var(--text)"> </strong>.</p><div class="submit-buttons"><button class="btn secondary" id="saveDraftBtn" type="button">ເກັບເປັນ Draft</button><button class="btn primary" id="submitBtn" type="button">ສົ່ງຄຳຂໍ</button></div></section>
          </div>
        </div>
      </form>
    </main>
  </div>

  <div class="modal" id="successModal"><div class="modal-card"><div class="modal-icon">✓</div><h2 id="modalTitle">ສຳເລັດ</h2><p id="modalText">ບັນທຶກຂໍ້ມູນແລ້ວ</p><button class="btn primary" id="modalOk" type="button">ໄປໜ້າເອກະສານ</button></div></div>
  <div class="modal" id="quotaModal">
    <div class="modal-card wide">
      <div class="modal-head">
        <div>
          <h2>ເລືອກໂກຕ້າສິນຄ້າ</h2>
          <p class="hint" style="margin:4px 0 0">ເລືອກ 1 ລາຍການຕໍ່ 1 ລົດ</p>
        </div>
        <button class="icon-btn" type="button" id="closeQuotaBtn">×</button>
      </div>
      <div class="modal-body">
        <div class="quota-toolbar">
          <p class="hint" id="quotaStatusText" style="margin:0">ກຳລັງໂຫຼດ...</p>
          <a class="btn secondary small" href="{{ route($routePrefix.'.quotars') }}">ຂໍໂກຕ້າໃໝ່</a>
        </div>
        <div class="quota-list" id="quotaList"></div>
      </div>
    </div>
  </div>

  <script>
    const vehicleTypes = @json($vehicleTypes);
    const routes = { store: @json(route($routePrefix.'.store')), draft: @json(route($routePrefix.'.draft')), documents: @json(route($routePrefix.'.documents')), quotars: @json(route($routePrefix.'.quotars.options')) };
    const state = { vehicles: [], editingId: null, files: [], index: 0, quotars: [], quotaLoaded: false, selectedQuota: null };
    const $ = (sel) => document.querySelector(sel);
    const $$ = (sel) => Array.from(document.querySelectorAll(sel));
    const esc = (value) => String(value ?? '').replace(/[&<>"']/g, (c) => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c]));
    const iconEdit = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"></path></svg>';
    const iconTrash = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M8 6V4h8v2"></path><path d="M19 6l-1 14H6L5 6"></path></svg>';
    vehicleTypes.forEach((type) => { const opt = document.createElement('option'); opt.value = type.id; opt.textContent = type.name; opt.dataset.round = type.is_round; $('#vehicleType').appendChild(opt); });
    function clearErrors(){ $$('.field').forEach(f=>f.classList.remove('has-error')); $('#rowsError').classList.remove('show'); $('#rowLimitError').classList.remove('show'); }
    function renderRound(){ const type = vehicleTypes.find(t => Number(t.id) === Number($('#vehicleType').value)); $('#roundField').style.display = type && Number(type.is_round) === 1 ? 'block':'none'; if (!type || Number(type.is_round) !== 1) $('#rounds').value='1'; }
    function draft(){ return { plate: $('#plate').value.trim(), driver: $('#driver').value.trim(), weight: $('#weight').value.trim(), typeId: $('#vehicleType').value, rounds: $('#rounds').value || '1', product: $('#product').value.trim(), reference: $('#reference').value.trim(), quotarId: state.selectedQuota ? state.selectedQuota.id : null }; }
    function setDraft(row){ $('#plate').value=row?.plate||''; $('#driver').value=row?.driver||''; $('#weight').value=row?.weight||''; $('#vehicleType').value=row?.typeId||''; $('#rounds').value=row?.rounds||'1'; $('#product').value=row?.product||''; $('#reference').value=row?.reference||''; state.selectedQuota = row?.quotarId ? { id: row.quotarId, product_name: row.product, picked_amount: row.weight } : null; renderQuotaSelected(); renderRound(); }
    function renderQuotaSelected(){ $('#quotaSelectedText').textContent = state.selectedQuota ? `ໃຊ້ໂກຕ້າ #${state.selectedQuota.id}` : ''; }
    function validateVehicle(row){ clearErrors(); let ok=true; [['plate',row.plate],['driver',row.driver],['weight',row.weight],['type',row.typeId],['product',row.product],['reference',row.reference]].forEach(([key,val])=>{ if(!val){ document.querySelector(`[data-field="${key}"]`).classList.add('has-error'); ok=false; }}); return ok; }
    function typeName(id){ return vehicleTypes.find(t=>Number(t.id)===Number(id))?.name || '-'; }
    function addVehicle(){ const row=draft(); if(!validateVehicle(row)) return; if(!state.editingId && state.vehicles.length>=5){ $('#rowLimitError').classList.add('show'); return; } const type=vehicleTypes.find(t=>Number(t.id)===Number(row.typeId)); const payload={...row, rounds: type && Number(type.is_round)===1 ? row.rounds : '1'}; if(state.editingId){ state.vehicles=state.vehicles.map(v=>v.id===state.editingId?{...payload,id:state.editingId,idx:v.idx}:v); } else { state.index++; state.vehicles.push({...payload,id:String(Date.now()),idx:state.index}); } cancelEdit(); renderVehicles(); }
    function editVehicle(id){ const row=state.vehicles.find(v=>v.id===id); if(!row) return; state.editingId=id; setDraft(row); $('#vehiclePanelTitle').textContent='ແກ້ໄຂຂໍ້ມູນລົດ'; $('#addVehicleBtn').textContent='ບັນທຶກລົດ'; $('#cancelEditBtn').style.display='inline-flex'; scrollTo({top:0,behavior:'smooth'}); }
    function removeVehicle(id){ state.vehicles=state.vehicles.filter(v=>v.id!==id); if(state.editingId===id) cancelEdit(); renderVehicles(); }
    function cancelEdit(){ state.editingId=null; setDraft(null); clearErrors(); $('#vehiclePanelTitle').textContent='ຂໍ້ມູນລົດ'; $('#addVehicleBtn').textContent='ເພີ່ມລົດ'; $('#cancelEditBtn').style.display='none'; }
    function renderVehicles(){ $('#vehicleCount').textContent=state.vehicles.length; $('#vehicleEmpty').style.display=state.vehicles.length?'none':'block'; $('#vehicleRows').innerHTML=state.vehicles.map(row=>`<tr><td><strong>${esc(row.plate)}</strong></td><td>${esc(row.driver)}</td><td>${esc(typeName(row.typeId))}</td><td>${esc(row.rounds)}</td><td>${row.quotarId ? '<span class="quota-badge">Quota</span> ' : ''}${esc(row.product)}</td><td>${esc(row.weight)}</td><td>${esc(row.reference)}</td><td><div class="row-actions"><button class="icon-btn" type="button" onclick="editVehicle('${row.id}')">${iconEdit}</button><button class="icon-btn danger" type="button" onclick="removeVehicle('${row.id}')">${iconTrash}</button></div><input type="hidden" name="input_plate_${row.idx}" value="${esc(row.plate)}"><input type="hidden" name="input_driver_name_${row.idx}" value="${esc(row.driver)}"><input type="hidden" name="input_vehicle_type_id_${row.idx}" value="${esc(row.typeId)}"><input type="hidden" name="input_rounds_${row.idx}" value="${esc(row.rounds)}"><input type="hidden" name="input_import_product_${row.idx}" value="${esc(row.product)}"><input type="hidden" name="input_weight_kg_${row.idx}" value="${esc(row.weight)}"><input type="hidden" name="input_import_document_no_${row.idx}" value="${esc(row.reference)}"><input type="hidden" name="input_quotar_id_${row.idx}" value="${esc(row.quotarId || '')}"></td></tr>`).join(''); }
    function quotaNumber(value){ return Number(value || 0).toLocaleString(undefined,{maximumFractionDigits:2}); }
    function closeQuota(){ $('#quotaModal').classList.remove('show'); }
    async function openQuota(){ $('#quotaModal').classList.add('show'); if(!state.quotaLoaded){ $('#quotaStatusText').textContent='ກຳລັງໂຫຼດ...'; const res=await fetch(routes.quotars,{headers:{'Accept':'application/json'}}); const data=await res.json().catch(()=>({data:[]})); state.quotars=data.data||[]; state.quotaLoaded=true; } renderQuotas(); }
    function renderQuotas(){ $('#quotaStatusText').textContent=state.quotars.length ? `${state.quotars.length} ລາຍການພ້ອມໃຊ້` : 'ບໍ່ມີໂກຕ້າທີ່ພ້ອມໃຊ້'; $('#quotaList').innerHTML=state.quotars.map(q=>`<div class="quota-option"><div class="quota-title">${esc(q.product_name)}</div><div class="quota-meta"><span>ລວມ: ${quotaNumber(q.total_amount)}</span><span>ຄົງເຫຼືອ: ${quotaNumber(q.remaining_amount)}</span><span>ໝົດອາຍຸ: ${esc(q.expire_date || '-')}</span></div><div class="quota-pick"><div><label for="quotaAmount_${q.id}">ນ້ຳໜັກທີ່ຈະໃຊ້</label><input class="input" id="quotaAmount_${q.id}" inputmode="decimal" placeholder="ຕົວຢ່າງ: 12.5"></div><button class="btn primary" type="button" onclick="pickQuota(${q.id})">ເລືອກ</button></div></div>`).join(''); }
    function pickQuota(id){ const quota=state.quotars.find(q=>Number(q.id)===Number(id)); if(!quota) return; const amount=$(`#quotaAmount_${id}`).value.trim(); if(!amount || Number(amount)<=0){ alert('ກະລຸນາລະບຸນ້ຳໜັກ'); return; } if(Number(amount)>Number(quota.remaining_amount)){ alert('ນ້ຳໜັກເກີນຈຳນວນຄົງເຫຼືອ'); return; } state.selectedQuota={...quota,picked_amount:amount}; $('#product').value=quota.product_name; $('#weight').value=amount; renderQuotaSelected(); closeQuota(); }
    function maybeCancelQuota(){ if(!state.selectedQuota) return; if($('#product').value.trim()===state.selectedQuota.product_name && $('#weight').value.trim()===String(state.selectedQuota.picked_amount)) return; if(confirm('ຕ້ອງການຍົກເລີກການເລືອກໂກຕ້າບໍ?')){ state.selectedQuota=null; renderQuotaSelected(); } else { $('#product').value=state.selectedQuota.product_name; $('#weight').value=state.selectedQuota.picked_amount; } }
    function validateForm(){ clearErrors(); let ok=true; if(state.vehicles.length<1){ $('#rowsError').classList.add('show'); ok=false; } [['village','#village'],['district','#district'],['province','#province']].forEach(([key,sel])=>{ if(!$(sel).value.trim()){ document.querySelector(`[data-field="${key}"]`).classList.add('has-error'); ok=false; }}); return ok; }
    function submit(kind){ if(!validateForm()) return; $('#index').value=state.index; const url=kind==='draft'?routes.draft:routes.store; const btn=kind==='draft'?$('#saveDraftBtn'):$('#submitBtn'); const original=btn.textContent; btn.disabled=true; btn.textContent=kind==='draft'?'ກຳລັງບັນທຶກ...':'ກຳລັງສົ່ງ...'; fetch(url,{method:'POST',credentials:'same-origin',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content,'Accept':'application/json'},body:new FormData($('#newEnterForm'))}).then(async res=>{ const data=await res.json().catch(()=>({})); if(!res.ok) throw data; $('#modalTitle').textContent=kind==='draft'?'ເກັບເປັນ Draft ສຳເລັດ':'ສົ່ງຄຳຂໍສຳເລັດ'; $('#modalText').textContent=data.message || 'ບັນທຶກຂໍ້ມູນແລ້ວ'; $('#successModal').classList.add('show'); }).catch(err=>{ if(err.message === 'CSRF token mismatch.'){ alert('Session ໝົດອາຍຸ ຫຼື token ບໍ່ຖືກຕ້ອງ. ກະລຸນາ refresh ໜ້າແລ້ວລອງໃໝ່.'); return; } alert(err.message || 'ບໍ່ສາມາດບັນທຶກໄດ້'); }).finally(()=>{ btn.disabled=false; btn.textContent=original; }); }
    $('#menuBtn').addEventListener('click',()=>{ const open=$('#mobileNav').classList.toggle('open'); document.body.classList.toggle('nav-open',open); });
    $('#pageBackdrop').addEventListener('click',()=>{ $('#mobileNav').classList.remove('open'); document.body.classList.remove('nav-open'); });
    $('#vehicleType').addEventListener('change',renderRound); $('#addVehicleBtn').addEventListener('click',addVehicle); $('#cancelEditBtn').addEventListener('click',cancelEdit); $('#submitBtn').addEventListener('click',()=>submit('save')); $('#saveDraftBtn').addEventListener('click',()=>submit('draft')); $('#modalOk').addEventListener('click',()=>location.href=routes.documents); $('#openQuotaBtn').addEventListener('click',openQuota); $('#closeQuotaBtn').addEventListener('click',closeQuota); $('#product').addEventListener('input',maybeCancelQuota); $('#weight').addEventListener('input',maybeCancelQuota);
    $('#files').addEventListener('change',e=>{ $('#selectedFiles').innerHTML=Array.from(e.target.files||[]).map(f=>`<span class="file-chip"><span>${esc(f.name)}</span></span>`).join(''); });
    window.editVehicle=editVehicle; window.removeVehicle=removeVehicle; window.pickQuota=pickQuota; renderRound();
  </script>
</body>
</html>
