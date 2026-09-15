<!doctype html>
<html lang="lo">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ຕິດຕາມວຽກໃບອະນຸຍາດ</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Noto+Sans+Lao:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root{--bg:#fbfcfe;--card:#fff;--text:#171c24;--muted:#657283;--line:#d8e0ea;--soft:#f5f7fa;--primary:#0a427a;--danger:#dc2626;--green:#166534;--teal:#0f766e;--amber:#a16207;--shadow:0 1px 2px rgba(16,24,40,.08),0 16px 40px rgba(16,24,40,.06)}
    *{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--text);font-family:Inter,"Noto Sans Lao",ui-sans-serif,system-ui,sans-serif;font-size:14px;line-height:1.5}button,input,select,textarea{font:inherit}button{cursor:pointer}.topbar{position:sticky;top:0;z-index:80;border-bottom:1px solid var(--line);background:rgba(255,255,255,.96);backdrop-filter:blur(10px)}.topbar-inner{max-width:1480px;margin:0 auto;padding:13px 18px;display:flex;align-items:center;justify-content:space-between;gap:16px}.brand{display:flex;align-items:center;gap:12px;min-width:0}.mark{width:42px;height:42px;border-radius:8px;background:var(--primary);color:#fff;display:grid;place-items:center;font-weight:700}.brand-title{margin:0;font-weight:650}.brand-sub{margin:0;color:var(--muted);font-size:12px}.nav{display:flex;align-items:center;gap:8px}.nav a,.nav button{border:0;border-radius:8px;background:transparent;color:var(--muted);font-weight:650;padding:10px 12px;text-decoration:none}.nav .active{background:var(--primary);color:#fff}.nav .danger{color:var(--danger)}.main{max-width:1480px;margin:0 auto;padding:20px 18px 36px}.panel{border:1px solid var(--line);border-radius:8px;background:var(--card);box-shadow:var(--shadow);overflow:hidden}.filters{display:grid;grid-template-columns:repeat(8,minmax(0,1fr));gap:10px;padding:16px;border-bottom:1px solid var(--line)}.field label{display:block;margin:0 0 5px;font-size:12px;font-weight:650;color:var(--muted)}.control{width:100%;height:40px;border:1px solid #cdd6e1;border-radius:8px;background:#fff;padding:8px 10px;color:var(--text);outline:none}.control:focus{border-color:var(--primary);box-shadow:0 0 0 4px #dbeafe}.filter-actions{display:flex;align-items:end;gap:8px}.btn{min-height:40px;border-radius:8px;border:1px solid var(--line);background:#fff;color:var(--text);display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:8px 12px;font-weight:650;text-decoration:none;white-space:nowrap}.btn.primary{background:var(--primary);border-color:var(--primary);color:#fff}.btn.danger{color:var(--danger)}.btn.small{min-height:34px;padding:6px 10px}.btn:disabled{opacity:.55;cursor:not-allowed}.status-tabs{display:flex;flex-wrap:wrap;gap:8px;padding:14px 16px;border-bottom:1px solid var(--line)}.status-tabs button{border:1px solid var(--line);background:#fff;border-radius:8px;min-height:34px;padding:6px 12px;font-weight:650;color:var(--muted)}.status-tabs button.active{background:var(--primary);border-color:var(--primary);color:#fff}.table-wrap{overflow-x:auto}table{width:100%;border-collapse:collapse}th{background:var(--soft);border-bottom:1px solid var(--line);padding:12px 16px;color:var(--muted);font-size:12px;text-align:left;white-space:nowrap}td{border-bottom:1px solid var(--line);padding:14px 16px;vertical-align:top}.doc-no{font-weight:700;font-size:16px}.muted{color:var(--muted)}.small{font-size:12px}.chip{display:inline-flex;align-items:center;gap:6px;border:1px solid transparent;border-radius:8px;padding:4px 9px;font-size:12px;font-weight:650}.chip:before{content:"";width:6px;height:6px;border-radius:99px;background:currentColor}.waiting{color:#1d5fa7;background:#e7f1ff;border-color:#bfd9ff}.pointing,.signing{color:var(--amber);background:#fff4d7;border-color:#f1d58d}.signed,.ready{color:var(--teal);background:#dff7f3;border-color:#aee2db}.success{color:var(--green);background:#e7f6ec;border-color:#b6dfc2}.file-list,.actions,.road-list{display:flex;flex-wrap:wrap;gap:7px}.file-chip,.road-chip{border:1px solid var(--line);border-radius:8px;background:var(--soft);padding:5px 8px;font-size:12px}.file-chip{max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.actions{justify-content:flex-end}.pagination{padding:13px 16px;display:flex;justify-content:space-between;align-items:center;gap:12px}.loading{display:none;padding:28px 16px;border-bottom:1px solid var(--line);text-align:center;color:var(--muted);font-weight:650}.loading.show{display:block}.bar{height:9px;max-width:420px;margin:0 auto 10px;border-radius:999px;background:linear-gradient(90deg,var(--soft),#d7e8fb,var(--soft));background-size:200% 100%;animation:bar 1.15s linear infinite}@keyframes bar{to{background-position:-200% 0}}.empty{display:none;padding:42px 16px;text-align:center;color:var(--muted);font-weight:650}.empty.show{display:block}.cards{display:none}.card{padding:15px;border-bottom:1px solid var(--line)}.card-head{display:flex;justify-content:space-between;gap:12px}.card-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;margin-top:12px}.modal{display:none;position:fixed;inset:0;z-index:120;background:rgba(0,0,0,.25);align-items:center;justify-content:center;padding:18px}.modal.show{display:flex}.modal-card{width:min(720px,100%);max-height:calc(100vh - 36px);overflow:auto;border-radius:10px;background:#fff;box-shadow:0 24px 70px rgba(16,24,40,.28);padding:22px}.modal-title{margin:0 0 12px;font-size:22px;font-weight:650}.modal-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:18px}.vehicle-list{display:grid;gap:10px}.vehicle{border:1px solid var(--line);border-radius:8px;padding:12px}.vehicle-head{display:flex;justify-content:space-between;gap:12px}.vehicle-fields{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:10px;margin-top:10px}.check-list{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px}.check-item{border:1px solid var(--line);border-radius:8px;padding:9px 10px}.toast{position:fixed;right:18px;bottom:18px;z-index:140;display:none;min-width:260px;border-radius:10px;background:#fff;border:1px solid var(--line);box-shadow:var(--shadow);padding:14px}.toast.show{display:block}.toast strong{display:block;margin-bottom:3px}.toast.good strong{color:var(--green)}.toast.bad strong{color:var(--danger)}
    @media(max-width:1050px){.filters{grid-template-columns:repeat(2,minmax(0,1fr))}.filter-actions{grid-column:1/-1}.desktop{display:none}.cards{display:block}.actions{justify-content:flex-start}.vehicle-fields,.check-list{grid-template-columns:1fr}.topbar-inner{align-items:flex-start}.nav{flex-wrap:wrap;justify-content:flex-end}}
    @media(max-width:640px){.filters{grid-template-columns:1fr}.card-grid{grid-template-columns:1fr}.pagination{align-items:stretch;flex-direction:column}.modal-actions{flex-direction:column}.modal-actions .btn{width:100%}}
  </style>
</head>
<body>
  <header class="topbar">
    <div class="topbar-inner">
      <div class="brand">
        <div class="mark">✓</div>
        <div>
          <p class="brand-title">ລະບົບຕິດຕາມໃບອະນຸຍາດ</p>
          <p class="brand-sub">{{ $userName }} · Role {{ $userRole }} · ໝົດອາຍຸ {{ $authUntil }}</p>
        </div>
      </div>
      <nav class="nav">
        <a href="{{ route('new-enter.login') }}">ອອກໃບໃໝ່</a>
        <a class="active" href="{{ route('new-user-task.dashboard') }}">ຕິດຕາມວຽກ</a>
        <form method="POST" action="{{ route('new-user-task.logout') }}">
          @csrf
          <button class="danger" type="submit">ອອກຈາກລະບົບ</button>
        </form>
      </nav>
    </div>
  </header>

  <main class="main">
    <section class="panel">
      <div class="filters">
        <div class="field"><label>ວັນທີຈາກ</label><input class="control js-filter" id="date_from" type="date" value="{{ date('Y-m-d') }}"></div>
        <div class="field"><label>ວັນທີເຖິງ</label><input class="control js-filter" id="date_to" type="date" value="{{ date('Y-m-d') }}"></div>
        <div class="field"><label>ເລກທີ</label><input class="control js-filter" id="enter_number" placeholder="000001"></div>
        <div class="field"><label>ບໍລິສັດ</label><input class="control js-filter" id="company_name" placeholder="ຊື່ບໍລິສັດ"></div>
        <div class="field"><label>ທະບຽນລົດ</label><input class="control js-filter" id="plate_number" placeholder="1234 VTE"></div>
        <div class="field"><label>ຜູ້ຂັບ</label><input class="control js-filter" id="driver_name" placeholder="ຊື່ຜູ້ຂັບ"></div>
        <div class="field"><label>ສິນຄ້າ</label><input class="control js-filter" id="product" placeholder="ຊື່ສິນຄ້າ"></div>
        <div class="filter-actions">
          <button class="btn primary" id="reloadBtn" type="button">ໂຫຼດໃໝ່</button>
          <button class="btn" id="clearBtn" type="button">ລ້າງ</button>
        </div>
      </div>

      <div class="status-tabs" id="statusTabs">
        <button class="active" data-status="">ທັງໝົດ</button>
        @foreach ($statusOptions as $status)
          <button data-status="{{ $status }}">{{ [
            'WAITING' => 'ລໍຖ້າ',
            'POINTING' => 'ລະບຸເສັ້ນທາງ',
            'SIGNING' => 'ກຳລັງເຊັນ',
            'SIGNINED' => 'ເຊັນແລ້ວ',
            'READY' => 'ພ້ອມສົ່ງ',
            'SUCCESS' => 'ສຳເລັດ',
          ][$status] ?? $status }}</button>
        @endforeach
      </div>

      <div class="loading" id="loading"><div class="bar"></div>ກຳລັງໂຫຼດຂໍ້ມູນ...</div>
      <div class="table-wrap desktop">
        <table>
          <thead>
            <tr>
              <th>ເລກທີ</th>
              <th>ສະຖານະ</th>
              <th>ວັນທີເຂົ້າ</th>
              <th>ວັນທີອອກ</th>
              <th>ບໍລິສັດ / ປາຍທາງ</th>
              <th>ເສັ້ນທາງ</th>
              <th>ໄຟລ໌</th>
              <th style="text-align:right">ຈັດການ</th>
            </tr>
          </thead>
          <tbody id="rows"></tbody>
        </table>
      </div>
      <div class="cards" id="cards"></div>
      <div class="empty" id="empty">ບໍ່ພົບຂໍ້ມູນ</div>
      <div class="pagination">
        <div class="muted" id="pageText">ສະແດງ 0 ຈາກ 0</div>
        <div style="display:flex;align-items:center;gap:10px;justify-content:flex-end">
          <button class="btn small" id="prevBtn" type="button">ກ່ອນໜ້າ</button>
          <strong id="pageNumber">1/1</strong>
          <button class="btn small" id="nextBtn" type="button">ຕໍ່ໄປ</button>
        </div>
      </div>
    </section>
  </main>

  <div class="modal" id="viewModal">
    <div class="modal-card">
      <h2 class="modal-title" id="viewTitle">ເບິ່ງລາຍລະອຽດ</h2>
      <div id="viewBody"></div>
      <div class="modal-actions"><button class="btn primary" type="button" data-close="viewModal">ປິດ</button></div>
    </div>
  </div>

  <div class="modal" id="pointingModal">
    <div class="modal-card">
      <h2 class="modal-title">ລະບຸເສັ້ນທາງ</h2>
      <form id="pointingForm">
        <input type="hidden" id="pointingId">
        <div class="field" style="margin-bottom:12px">
          <label>ເສັ້ນທາງຫຼັກ</label>
          <select class="control" id="mainRoad" required></select>
        </div>
        <div class="field" style="margin-bottom:12px">
          <label>ເສັ້ນທາງຍ່ອຍ</label>
          <div class="check-list" id="roadChecks"></div>
        </div>
        <div class="field">
          <label>ໝາຍເຫດ / ລາຍລະອຽດ</label>
          <textarea class="control" id="pointingDetails" rows="4" style="height:auto;min-height:96px"></textarea>
        </div>
        <div class="modal-actions">
          <button class="btn" type="button" data-close="pointingModal">ຍົກເລີກ</button>
          <button class="btn primary" type="submit">ບັນທຶກ ແລະ ສົ່ງໄປ SIGNING</button>
        </div>
      </form>
    </div>
  </div>

  <div class="toast" id="toast"><strong id="toastTitle"></strong><span id="toastText"></span></div>

  <script>
    const role = @json($userRole);
    const routes = {
      data: @json(route('new-user-task.dashboard.data')),
      action: @json(route('new-user-task.dashboard.action')),
      pointing: @json(route('new-user-task.dashboard.pointing')),
      logout: @json(route('new-user-task.logout')),
    };
    const mainRoads = @json($mainRoads);
    const roadOptions = @json($roadOptions);
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    const statusLabels = {
      WAITING:'ລໍຖ້າ', POINTING:'ລະບຸເສັ້ນທາງ', SIGNING:'ກຳລັງເຊັນ',
      SIGNINED:'ເຊັນແລ້ວ', READY:'ພ້ອມສົ່ງມອບ', SUCCESS:'ສຳເລັດ'
    };
    const tones = {WAITING:'waiting',POINTING:'pointing',SIGNING:'signing',SIGNINED:'signed',READY:'ready',SUCCESS:'success'};
    let rows = [];
    let state = {page:1,lastPage:1,total:0,status:'',loading:false};
    const $ = (s) => document.querySelector(s);
    const $$ = (s) => Array.from(document.querySelectorAll(s));
    const esc = (v) => String(v ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c]));

    function chip(status) {
      return `<span class="chip ${tones[status] || 'waiting'}">${esc(statusLabels[status] || status)}</span>`;
    }

    function filters(page = 1) {
      return new URLSearchParams({
        page,
        status: state.status,
        date_from: $('#date_from').value,
        date_to: $('#date_to').value,
        enter_number: $('#enter_number').value.trim(),
        company_name: $('#company_name').value.trim(),
        plate_number: $('#plate_number').value.trim(),
        driver_name: $('#driver_name').value.trim(),
        product: $('#product').value.trim(),
      });
    }

    function setLoading(on) {
      state.loading = on;
      $('#loading').classList.toggle('show', on);
      $('#prevBtn').disabled = on || state.page <= 1;
      $('#nextBtn').disabled = on || state.page >= state.lastPage;
    }

    async function loadData(page = 1) {
      setLoading(true);
      try {
        const res = await fetch(`${routes.data}?${filters(page).toString()}`, {headers:{Accept:'application/json'}});
        const data = await res.json().catch(() => ({}));
        if (!res.ok) throw data;
        rows = data.rows || [];
        const p = data.summary?.pagination || {};
        state.page = p.page || 1;
        state.lastPage = p.last_page || 1;
        state.total = p.total || 0;
        render();
      } catch (err) {
        rows = [];
        state.page = 1;
        state.lastPage = 1;
        state.total = 0;
        render(err.message || 'ບໍ່ສາມາດໂຫຼດຂໍ້ມູນໄດ້');
      } finally {
        setLoading(false);
      }
    }

    function fileHtml(row) {
      if (!row.files?.length) return '<span class="muted">—</span>';
      return `<div class="file-list">${row.files.map(file => `<a class="file-chip" href="${esc(file.url)}" target="_blank" rel="noopener">${esc(file.name)}</a>`).join('')}</div>`;
    }

    function roadHtml(row) {
      const roads = [...(row.main_road_name ? [row.main_road_name] : []), ...(row.road_names || [])].filter(Boolean);
      if (!roads.length) return '<span class="muted">—</span>';
      return `<div class="road-list">${roads.map(r => `<span class="road-chip">${esc(r)}</span>`).join('')}</div>`;
    }

    function actionList(row) {
      const actions = [];
      const add = (label, action, tone = '') => actions.push(`<button class="btn small ${tone}" type="button" onclick="runAction(${row.id}, '${action}')">${label}</button>`);
      const point = () => actions.push(`<button class="btn small primary" type="button" onclick="openPointing(${row.id})">ລະບຸເສັ້ນທາງ</button>`);

      if (role === '2') {
        if (row.status === 'WAITING') add('ສົ່ງໄປລະບຸ', 'send_pointing', 'primary');
        if (row.status === 'POINTING') add('ດຶງກັບ', 'back_waiting');
        if (row.status === 'READY') add('ສົ່ງມອບ', 'send_success', 'primary');
      }
      if (role === '3') {
        if (row.status === 'POINTING') point();
        if (row.status === 'SIGNING') add('ດຶງກັບ', 'back_pointing');
        if (row.status === 'SIGNINED') add('ສົ່ງຕໍ່', 'send_ready', 'primary');
      }
      if (role === '4') {
        if (row.status === 'SIGNING') add('ເຊັນແລ້ວ', 'send_signed', 'primary');
        if (row.status === 'READY') add('ສົ່ງມອບ', 'send_success', 'primary');
      }
      if (role === '5') {
        if (row.status === 'WAITING') add('ສົ່ງໄປລະບຸ', 'send_pointing', 'primary');
        if (row.status === 'POINTING') { point(); add('ກັບ WAITING', 'back_waiting'); }
        if (row.status === 'SIGNING') { add('ເຊັນແລ້ວ', 'send_signed', 'primary'); add('ກັບ POINTING', 'back_pointing'); }
        if (row.status === 'SIGNINED') { add('ສົ່ງຕໍ່', 'send_ready', 'primary'); add('ກັບ SIGNING', 'back_signing'); }
        if (row.status === 'READY') { add('ສົ່ງມອບ', 'send_success', 'primary'); add('ກັບ SIGNINED', 'back_signed'); }
        if (row.status === 'SUCCESS') add('ກັບ READY', 'back_ready');
      }

      actions.unshift(`<button class="btn small" type="button" onclick="viewRow(${row.id})">ເບິ່ງ</button>`);
      return `<div class="actions">${actions.join('')}</div>`;
    }

    function render(errorText = '') {
      $('#empty').textContent = errorText || 'ບໍ່ພົບຂໍ້ມູນ';
      $('#empty').classList.toggle('show', !rows.length && !state.loading);
      $('#rows').innerHTML = rows.map(row => `
        <tr>
          <td><div class="doc-no">${esc(row.no)}</div><div class="small muted">${row.details?.length || 0} ຄັນ</div></td>
          <td>${chip(row.status)}</td>
          <td class="muted">${esc(row.date_in || row.date_make || '—')}</td>
          <td class="muted">${esc(row.date_out || '—')}</td>
          <td><strong>${esc(row.com_name || '—')}</strong><div>${esc([row.address,row.district,row.province].filter(Boolean).join(', ') || '—')}</div>${row.note ? `<div class="small muted">${esc(row.note)}</div>` : ''}</td>
          <td>${roadHtml(row)}</td>
          <td>${fileHtml(row)}</td>
          <td>${actionList(row)}</td>
        </tr>
      `).join('');
      $('#cards').innerHTML = rows.map(row => `
        <article class="card">
          <div class="card-head"><div><div class="doc-no">${esc(row.no)}</div><div class="small muted">${row.details?.length || 0} ຄັນ · ${esc(row.com_name || '')}</div></div>${chip(row.status)}</div>
          <div class="card-grid">
            <div><div class="small muted">ວັນທີເຂົ້າ</div>${esc(row.date_in || row.date_make || '—')}</div>
            <div><div class="small muted">ວັນທີອອກ</div>${esc(row.date_out || '—')}</div>
            <div><div class="small muted">ປາຍທາງ</div>${esc([row.address,row.district,row.province].filter(Boolean).join(', ') || '—')}</div>
            <div><div class="small muted">ເສັ້ນທາງ</div>${roadHtml(row)}</div>
          </div>
          <div style="margin-top:12px">${fileHtml(row)}</div>
          <div style="margin-top:12px">${actionList(row)}</div>
        </article>
      `).join('');
      const from = state.total ? ((state.page - 1) * 40) + 1 : 0;
      const to = Math.min(state.page * 40, state.total);
      $('#pageText').textContent = `ສະແດງ ${from}-${to} ຈາກ ${state.total}`;
      $('#pageNumber').textContent = `${state.page}/${state.lastPage}`;
      $('#prevBtn').disabled = state.loading || state.page <= 1;
      $('#nextBtn').disabled = state.loading || state.page >= state.lastPage;
    }

    function viewRow(id) {
      const row = rows.find(item => Number(item.id) === Number(id));
      if (!row) return;
      $('#viewTitle').textContent = row.no;
      const vehicles = row.details?.length ? row.details.map((detail, index) => `
        <article class="vehicle">
          <div class="vehicle-head"><strong>${index + 1}. ${esc(detail.plate_number || '—')}</strong><span class="muted">${esc(detail.type_name || '—')}</span></div>
          <div class="vehicle-fields">
            <div><div class="small muted">ຜູ້ຂັບ</div>${esc(detail.driver_name || '—')}</div>
            <div><div class="small muted">ສິນຄ້າ</div>${esc(detail.product || '—')}</div>
            <div><div class="small muted">ນ້ຳໜັກ</div>${esc(detail.weight || '—')}</div>
            <div><div class="small muted">ຖ້ຽວ</div>${esc(detail.rounds || '—')}</div>
            <div><div class="small muted">ເລກອ້າງອີງ</div>${esc(detail.reference || '—')}</div>
          </div>
        </article>
      `).join('') : '<p class="muted">ບໍ່ມີລາຍການລົດ</p>';
      $('#viewBody').innerHTML = `
        <div style="display:flex;justify-content:space-between;gap:12px;align-items:flex-start;margin-bottom:14px">${chip(row.status)}<span class="muted">${esc(row.com_name || '')}</span></div>
        <p><strong>ປາຍທາງ:</strong> ${esc([row.address,row.district,row.province].filter(Boolean).join(', ') || '—')}</p>
        <p><strong>ເສັ້ນທາງ:</strong> ${roadHtml(row)}</p>
        ${row.note ? `<p><strong>ໝາຍເຫດ:</strong> ${esc(row.note)}</p>` : ''}
        <h3 style="font-size:16px;margin:16px 0 10px">ລາຍການລົດ</h3>
        <div class="vehicle-list">${vehicles}</div>
        <h3 style="font-size:16px;margin:16px 0 10px">ໄຟລ໌</h3>
        ${fileHtml(row)}
      `;
      $('#viewModal').classList.add('show');
    }

    async function runAction(id, action) {
      if (!confirm('ຢືນຢັນການດຳເນີນການນີ້?')) return;
      try {
        const res = await fetch(routes.action, {
          method:'POST',
          headers:{'X-CSRF-TOKEN':csrf,'Accept':'application/json','Content-Type':'application/json'},
          body:JSON.stringify({id, action}),
        });
        const data = await res.json().catch(() => ({}));
        if (!res.ok) throw data;
        toast('ສຳເລັດ', 'ອັບເດດສະຖານະແລ້ວ', true);
        loadData(state.page);
      } catch (err) {
        toast('ບໍ່ສຳເລັດ', err.message || 'ການດຳເນີນການຖືກປະຕິເສດ', false);
      }
    }

    function openPointing(id) {
      const row = rows.find(item => Number(item.id) === Number(id));
      if (!row) return;
      $('#pointingId').value = id;
      $('#mainRoad').innerHTML = mainRoads.map(road => `<option value="${road.main_road_id}" ${Number(road.main_road_id) === Number(row.main_road_id) ? 'selected' : ''}>${esc(road.main_road_name)}</option>`).join('');
      const selected = new Set((row.road_names || []).map(String));
      $('#roadChecks').innerHTML = roadOptions.map(road => `
        <label class="check-item">
          <input type="checkbox" name="road_id" value="${road.road_id}" ${selected.has(String(road.road_name)) ? 'checked' : ''}>
          ${esc(road.road_name)}
        </label>
      `).join('');
      $('#pointingDetails').value = row.note || '';
      $('#pointingModal').classList.add('show');
    }

    $('#pointingForm').addEventListener('submit', async (event) => {
      event.preventDefault();
      const formdata = $$('input[name="road_id"]:checked').map(input => input.value);
      if (!formdata.length) {
        toast('ກວດສອບຂໍ້ມູນ', 'ກະລຸນາເລືອກເສັ້ນທາງຢ່າງໜ້ອຍ 1 ລາຍການ', false);
        return;
      }
      try {
        const res = await fetch(routes.pointing, {
          method:'POST',
          headers:{'X-CSRF-TOKEN':csrf,'Accept':'application/json','Content-Type':'application/json'},
          body:JSON.stringify({
            id: $('#pointingId').value,
            main_road: $('#mainRoad').value,
            details: $('#pointingDetails').value,
            formdata,
          }),
        });
        const data = await res.json().catch(() => ({}));
        if (!res.ok) throw data;
        $('#pointingModal').classList.remove('show');
        toast('ສຳເລັດ', 'ລະບຸເສັ້ນທາງແລະສົ່ງໄປ SIGNING ແລ້ວ', true);
        loadData(state.page);
      } catch (err) {
        toast('ບໍ່ສຳເລັດ', err.message || 'ບໍ່ສາມາດລະບຸເສັ້ນທາງໄດ້', false);
      }
    });

    function toast(title, text, good) {
      $('#toastTitle').textContent = title;
      $('#toastText').textContent = text;
      $('#toast').className = `toast show ${good ? 'good' : 'bad'}`;
      clearTimeout(window.toastTimer);
      window.toastTimer = setTimeout(() => $('#toast').classList.remove('show'), 2800);
    }

    let timer = null;
    $$('.js-filter').forEach(input => input.addEventListener('input', () => {
      clearTimeout(timer);
      timer = setTimeout(() => loadData(1), 350);
    }));
    $('#reloadBtn').addEventListener('click', () => loadData(1));
    $('#clearBtn').addEventListener('click', () => {
      ['enter_number','company_name','plate_number','driver_name','product'].forEach(id => $('#' + id).value = '');
      state.status = '';
      $$('#statusTabs button').forEach(btn => btn.classList.toggle('active', btn.dataset.status === ''));
      loadData(1);
    });
    $$('#statusTabs button').forEach(btn => btn.addEventListener('click', () => {
      state.status = btn.dataset.status;
      $$('#statusTabs button').forEach(item => item.classList.toggle('active', item === btn));
      loadData(1);
    }));
    $('#prevBtn').addEventListener('click', () => state.page > 1 && loadData(state.page - 1));
    $('#nextBtn').addEventListener('click', () => state.page < state.lastPage && loadData(state.page + 1));
    $$('[data-close]').forEach(btn => btn.addEventListener('click', () => $('#' + btn.dataset.close).classList.remove('show')));
    window.viewRow = viewRow;
    window.runAction = runAction;
    window.openPointing = openPointing;
    loadData(1);
  </script>
</body>
</html>
