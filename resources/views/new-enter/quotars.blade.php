<!doctype html>
<html lang="lo">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/x-icon" href="{{ asset('/images/favicon.svg') }}">
  <title>ຫ້ອງການບໍລິຫານ ດ່ານສາກົນສິນຄ້າ ທ່າບົກທ່ານາແລ້ງ</title>
  @php($routePrefix = $routePrefix ?? 'old-enter')
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Noto+Sans+Lao:wght@400;500;600;700&display=swap");
    :root{--bg:#fbfcfe;--card:#fff;--text:#171c24;--muted:#5f6b7a;--line:#d7dee8;--soft:#f5f7fa;--primary:#0a427a;--primary-2:#123f73;--danger:#dc2626;--danger-soft:#fee8e8;--green:#166534;--green-soft:#e7f6ec;--amber:#a16207;--amber-soft:#fff4d7;--shadow:0 1px 2px rgba(16,24,40,.08),0 8px 24px rgba(16,24,40,.04);font-family:Inter,"Noto Sans Lao",ui-sans-serif,system-ui,sans-serif}
    *{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--text);font-size:14px;line-height:1.45}button,input{font:inherit}button{cursor:pointer}.topbar{position:sticky;top:0;z-index:100;border-bottom:1px solid var(--line);background:rgba(255,255,255,.96);backdrop-filter:blur(10px)}.topbar-inner{max-width:1400px;margin:0 auto;padding:12px 18px;display:grid;grid-template-columns:minmax(0,1fr) auto;gap:14px;align-items:center}.brand-title{margin:0;font-weight:700;font-size:14px}.brand-sub{margin:0;font-size:12px;color:var(--muted)}.nav{display:flex;align-items:center;gap:6px}.nav-link,.logout-btn{min-height:40px;border:0;border-radius:8px;background:transparent;color:var(--muted);display:inline-flex;align-items:center;gap:8px;padding:9px 12px;font-weight:600;text-decoration:none}.nav-link:hover,.logout-btn:hover{background:var(--soft);color:var(--text)}.nav-link.active{background:var(--primary);color:#fff}.logout-btn{color:var(--danger)}.menu-btn{display:none;width:40px;height:40px;padding:0;border-radius:8px;border:1px solid var(--primary);background:var(--primary);color:#fff;align-items:center;justify-content:center}.mobile-nav{display:none;position:fixed;top:61px;left:0;right:0;z-index:110;padding:8px 18px 12px;border-top:1px solid var(--line);border-bottom:1px solid var(--line);background:#fff;box-shadow:0 14px 30px rgba(16,24,40,.12)}.mobile-nav.open{display:grid;gap:8px}.page-backdrop{display:none;position:fixed;inset:0;z-index:90;background:rgba(0,0,0,.2)}body.nav-open .page-backdrop{display:block}
    .main{max-width:1400px;margin:0 auto;padding:20px 18px 34px}.grid{display:grid;grid-template-columns:minmax(320px,420px) minmax(0,1fr);gap:20px;align-items:start}.panel{border:1px solid var(--line);border-radius:8px;background:var(--card);box-shadow:var(--shadow);overflow:hidden}.panel.sticky{position:sticky;top:84px}.panel-head{min-height:46px;padding:13px 16px;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;gap:12px}.panel-title{margin:0;font-size:15px;font-weight:650}.panel-body{padding:16px}.field{margin-bottom:16px}label{display:block;margin-bottom:6px;font-size:12px;font-weight:600}.input{width:100%;height:40px;border:1px solid #cdd6e1;border-radius:8px;background:#fff;color:var(--text);outline:none;padding:8px 12px;box-shadow:0 1px 2px rgba(16,24,40,.08)}.input:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(10,66,122,.13)}.hint{margin:6px 0 0;font-size:12px;color:var(--muted)}.btn{min-height:40px;border-radius:8px;border:1px solid transparent;padding:8px 14px;display:inline-flex;align-items:center;justify-content:center;gap:8px;font-weight:650;text-decoration:none;white-space:nowrap}.btn.primary{background:var(--primary);border-color:var(--primary);color:#fff}.btn.primary:hover{background:var(--primary-2)}.btn.secondary{background:#fff;border-color:var(--line);color:var(--text)}.btn.full{width:100%;min-height:44px}.dropzone{border:1px dashed #c9d4e2;border-radius:8px;min-height:118px;display:grid;place-items:center;padding:18px;text-align:center;background:#fcfdff}.dropzone strong{display:block}.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);border:0}.file-list{margin-top:12px;display:flex;gap:8px;flex-wrap:wrap}.file-chip{max-width:190px;min-height:30px;border:1px solid var(--line);border-radius:8px;background:var(--soft);padding:5px 8px;display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:500}.file-chip span{overflow:hidden;white-space:nowrap;text-overflow:ellipsis}
    .table-wrap{overflow-x:auto}table{width:100%;border-collapse:collapse}th{background:var(--soft);color:var(--muted);font-size:12px;font-weight:650;text-align:left;padding:11px 16px;border-bottom:1px solid var(--line);white-space:nowrap}td{padding:13px 16px;border-bottom:1px solid var(--line);vertical-align:top}.status-chip{display:inline-flex;align-items:center;border:1px solid transparent;border-radius:8px;padding:4px 8px;font-size:12px;font-weight:700}.status-pending{color:var(--amber);background:var(--amber-soft);border-color:rgba(161,98,7,.24)}.status-approved{color:var(--green);background:var(--green-soft);border-color:rgba(22,101,52,.24)}.status-rejected,.status-expired{color:var(--danger);background:var(--danger-soft);border-color:rgba(220,38,38,.24)}.amount{font-weight:700}.success{margin-bottom:14px;border:1px solid #86efac;background:#f0fdf4;color:#166534;border-radius:8px;padding:10px 12px;font-weight:700}.empty{padding:32px 16px;text-align:center;color:var(--muted);font-weight:600}
    @media(max-width:980px){.desktop-nav{display:none}.menu-btn{display:inline-flex}.grid{grid-template-columns:1fr}.panel.sticky{position:static}}
  </style>
</head>
<body>
  <header class="topbar">
    <div class="topbar-inner">
      <div><p class="brand-title">ຟອມຂໍອະນຸຍາດລົດ</p><p class="brand-sub">{{ $company->com_name ?? 'No company' }}</p></div>
      <nav class="nav desktop-nav">
        <a class="nav-link" href="{{ route($routePrefix.'.index') }}">ອອກໃບອະນຸຍາດ</a>
        <a class="nav-link" href="{{ route($routePrefix.'.documents') }}">ຕິດຕາມເອກະສານ</a>
        <a class="nav-link active" href="{{ route($routePrefix.'.quotars') }}">ໂກຕ້າສິນຄ້າ</a>
        <form method="POST" action="{{ route($routePrefix.'.logout') }}">@csrf<button class="logout-btn" type="submit">ອອກຈາກລະບົບ</button></form>
      </nav>
      <button class="menu-btn" id="menuBtn" aria-label="Open navigation"><svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16"></path><path d="M4 12h16"></path><path d="M4 18h16"></path></svg></button>
    </div>
    <nav class="mobile-nav" id="mobileNav">
      <a class="nav-link" href="{{ route($routePrefix.'.index') }}">ອອກໃບອະນຸຍາດ</a>
      <a class="nav-link" href="{{ route($routePrefix.'.documents') }}">ຕິດຕາມເອກະສານ</a>
      <a class="nav-link active" href="{{ route($routePrefix.'.quotars') }}">ໂກຕ້າສິນຄ້າ</a>
      <form method="POST" action="{{ route($routePrefix.'.logout') }}">@csrf<button class="logout-btn" type="submit">ອອກຈາກລະບົບ</button></form>
    </nav>
  </header>
  <div class="page-backdrop" id="pageBackdrop"></div>

  <main class="main">
    @if (session('success'))
      <div class="success">{{ session('success') }}</div>
    @endif
    <div class="grid">
      <section class="panel sticky">
        <header class="panel-head"><h2 class="panel-title">ຂໍໂກຕ້າສິນຄ້າ</h2></header>
        <div class="panel-body">
          <form method="POST" action="{{ route($routePrefix.'.quotars.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="field">
              <label for="product_name">ຊື່ສິນຄ້າ</label>
              <input class="input" id="product_name" name="product_name" value="{{ old('product_name') }}" placeholder="ຕົວຢ່າງ: ປູນຊີເມັນ" required>
              @error('product_name')<p class="hint" style="color:var(--danger)">{{ $message }}</p>@enderror
            </div>
            <div class="field">
              <label for="total_amount">ຈຳນວນ / ນ້ຳໜັກ</label>
              <input class="input" id="total_amount" name="total_amount" value="{{ old('total_amount') }}" inputmode="decimal" placeholder="ຕົວຢ່າງ: 1000" required>
              @error('total_amount')<p class="hint" style="color:var(--danger)">{{ $message }}</p>@enderror
            </div>
            <div class="field">
              <label class="dropzone" for="document_files">
                <input id="document_files" name="document_files[]" type="file" multiple accept=".pdf,.jpg,.jpeg,.png" class="sr-only">
                <span><strong>ເລືອກໄຟລ໌ເພື່ອແນບ</strong><span class="hint">PDF, JPG ຫຼື PNG</span></span>
              </label>
              <div class="file-list" id="selectedFiles"></div>
              @error('document_files.*')<p class="hint" style="color:var(--danger)">{{ $message }}</p>@enderror
            </div>
            <button class="btn primary full" type="submit">ສົ່ງຄຳຂໍໂກຕ້າ</button>
          </form>
        </div>
      </section>

      <section class="panel">
        <header class="panel-head"><h2 class="panel-title">ລາຍການໂກຕ້າ</h2></header>
        <div class="table-wrap">
          <table>
            <thead><tr><th>ສິນຄ້າ</th><th>ສະຖານະ</th><th>ຈຳນວນລວມ</th><th>ຄົງເຫຼືອ</th><th>ໝົດອາຍຸ</th><th>ວັນທີຂໍ</th></tr></thead>
            <tbody>
              @forelse ($quotars as $quotar)
                @php($tone = strtolower($quotar->status ?: 'pending'))
                <tr>
                  <td><strong>{{ $quotar->product_name }}</strong></td>
                  <td><span class="status-chip status-{{ $tone }}">{{ $quotar->status }}</span></td>
                  <td class="amount">{{ number_format((float) $quotar->total_amount, 2) }}</td>
                  <td class="amount">{{ number_format((float) $quotar->remaining_amount, 2) }}</td>
                  <td>{{ $quotar->expire_date ?: '-' }}</td>
                  <td>{{ $quotar->created_at ? date('d/m/Y', strtotime($quotar->created_at)) : '-' }}</td>
                </tr>
              @empty
                <tr><td colspan="6"><div class="empty">ຍັງບໍ່ມີລາຍການໂກຕ້າ</div></td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </section>
    </div>
  </main>

  <script>
    const $ = (sel) => document.querySelector(sel);
    const esc = (value) => String(value || '').replace(/[&<>"']/g, (c) => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c]));
    $('#menuBtn').addEventListener('click', function () {
      const open = $('#mobileNav').classList.toggle('open');
      document.body.classList.toggle('nav-open', open);
    });
    $('#pageBackdrop').addEventListener('click', function () {
      $('#mobileNav').classList.remove('open');
      document.body.classList.remove('nav-open');
    });
    $('#document_files').addEventListener('change', function (event) {
      $('#selectedFiles').innerHTML = Array.from(event.target.files || []).map(function (file) {
        return `<span class="file-chip"><span>${esc(file.name)}</span></span>`;
      }).join('');
    });
  </script>
</body>
</html>
