<x-app-layout>
  <style>
    /* Murphy Menu — light, crisp, mobile-first */
    :root{
      --ink:#0b1221; --sub:#6a768c; --line:#e6ebf2; --card:#ffffff; --soft:#f8fbff;
      --brand:#0a5ad1; --brand-ink:#fff; --ok:#16a34a; --warn:#f59e0b; --danger:#ff4757;
      --shadow:0 10px 30px rgba(9,30,66,.10); --shadow-lg:0 18px 40px rgba(9,30,66,.16);
      --r:16px;
    }
    .sm\:rounded-lg{
      border:1px solid var(--line);
      border-radius: var(--r)!important;
      background: linear-gradient(180deg,#fff,#fbfdff);
      box-shadow: var(--shadow);
    }
    .murphy-section{
      padding: 18px 18px 6px 18px;
      border-bottom:1px dashed var(--line);
      display:flex; align-items:center; gap:10px; color:#1c274c;
      font-weight:800; letter-spacing:.2px;
    }
    .murphy-section .dot{
      width:10px; height:10px; border-radius:999px; background:var(--brand);
      box-shadow:0 0 0 4px rgba(10,90,209,.12);
    }

    .murphy-menu{
      display:grid;
      grid-template-columns: repeat(12, 1fr);
      gap:12px; padding:14px;
    }
    /* Responsive spans */
    .span-12{ grid-column: span 12 / span 12; }
    @media (min-width: 640px){ .span-6{ grid-column: span 6 / span 6; } }
    @media (min-width: 768px){ .span-4{ grid-column: span 4 / span 4; } }

    .menu-item{
      position:relative;
      display:flex; align-items:center; gap:14px;
      padding:14px; border:1px solid var(--line); border-radius:14px;
      background:var(--card);
      box-shadow: var(--shadow);
      transition: transform .06s ease, box-shadow .12s ease, border-color .12s ease, background .12s ease;
      text-decoration:none; color:var(--ink);
      overflow:hidden;
    }
    .menu-item::after{
      content:""; position:absolute; inset:-1px;
      background:
        radial-gradient(200px 60px at -10% -20%, rgba(10,90,209,.06), transparent 60%),
        radial-gradient(200px 60px at 110% -20%, rgba(22,163,74,.05), transparent 60%);
      pointer-events:none;
    }
    .menu-item:hover{
      transform: translateY(-1px);
      border-color:#d7e4fb; background:#f7fbff;
      box-shadow: var(--shadow-lg);
    }
    .menu-icon{
      flex:0 0 auto; width:42px; height:42px; border-radius:12px;
      display:grid; place-items:center; background: #eef4ff; color:#0a5ad1;
      box-shadow: inset 0 1px 0 rgba(255,255,255,.7);
    }
    .menu-text{ display:flex; flex-direction:column; gap:2px; min-width:0; }
    .menu-title{ font-weight:800; line-height:1.2; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .menu-hint{ font-size:.875rem; color:var(--sub); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }

    /* Compact on mobile */
    @media (max-width: 720px){
      .murphy-menu{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
      .span-12,.span-6,.span-4{ grid-column: auto / span 2; }
    }
  </style>

  <div class="py-1 laos">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

        {{-- Section: Admin (2,7,8) --}}
        @if(auth()->user()->is_admin=='2' || auth()->user()->is_admin=='7' || auth()->user()->is_admin=='8')
          <div class="murphy-section">
            <span class="dot"></span>
            <div>ຕັ້ງຄ່າ</div>
          </div>
          <div class="murphy-menu">
            <a class="menu-item span-12 span-6 span-4" href="{{ route('ComAdd') }}">
              <div class="menu-icon" aria-hidden="true">
                {{-- user-add icon --}}
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                  <path d="M15 19v-1a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v1" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                  <circle cx="9" cy="7" r="3" stroke="currentColor" stroke-width="1.6"/>
                  <path d="M19 8v6M22 11h-6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
              </div>
              <div class="menu-text">
                <div class="menu-title">ເພີ່ມບໍລິສັດ ແລະ ຜູ້ໃຊ້</div> 
              </div>
            </a>
          </div>
        @endif

        {{-- Section: Operator (3) --}}
        @if(auth()->user()->is_admin=='3')
          <div class="murphy-section">
            <span class="dot" style="background:var(--ok)"></span>
            <div>ຕັ້ງຄ່າ</div>
          </div>
          <div class="murphy-menu">
            <a class="menu-item span-12 span-6 span-4" href="{{ route('Freport',['0']) }}">
              <div class="menu-icon" aria-hidden="true" style="background:#ecfdf3;color:#16a34a;">
                {{-- report icon --}}
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                  <rect x="3" y="4" width="14" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/>
                  <path d="M8 8h6M8 12h6M8 16h3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                  <path d="M17 8l4 4-4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              <div class="menu-text">
                <div class="menu-title">ເບີ່ງລາຍງານ</div>
                <!-- <div class="menu-hint">Filter & export activity reports</div> -->
              </div>
            </a>

            <a class="menu-item span-12 span-6 span-4" href="{{ route('RoadAdd') }}">
              <div class="menu-icon" aria-hidden="true">
                {{-- road icon --}}
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                  <path d="M6 21l3-9 3-9m3 18-3-9L9 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                  <path d="M3 21h18" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
              </div>
              <div class="menu-text">
                <div class="menu-title">ເພີ່ມສາຍທາງ</div>
                <!-- <div class="menu-hint">Manage route segments</div> -->
              </div>
            </a>

            <a class="menu-item span-12 span-6 span-4" href="{{ route('MainroadAdd') }}">
              <div class="menu-icon" aria-hidden="true">
                {{-- highway icon --}}
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                  <path d="M9 3h6l-1 7h-4L9 3Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M5 21l3-11h8l3 11H5Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              <div class="menu-text">
                <div class="menu-title">ເພີ່ມປະເພດລົດ</div>
                <!-- <div class="menu-hint">Main road categories</div> -->
              </div>
            </a>

            <a class="menu-item span-12 span-6 span-4" href="{{ route('WheelsAdd') }}">
              <div class="menu-icon" aria-hidden="true">
                {{-- wheel/gear icon --}}
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                  <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/>
                  <path d="M19.4 15a7.97 7.97 0 0 0 .1-6l-2.1.8-1-1.7 1.6-1.6a8.02 8.02 0 0 0-6-.1l.3 2.2h-2l.3-2.2a8.02 8.02 0 0 0-6 .1l1.6 1.6-1 1.7-2.1-.8a7.97 7.97 0 0 0 .1 6l2.1-.8 1 1.7-1.6 1.6a8.02 8.02 0 0 0 6 .1l-.3-2.2h2l-.3 2.2a8.02 8.02 0 0 0 6-.1l-1.6-1.6 1-1.7 2.1.8Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              <div class="menu-text">
                <div class="menu-title">ເພີ່ມປະເພດລໍ້ລົດ</div>
                <!-- <div class="menu-hint">Wheel types & presets</div> -->
              </div>
            </a>
          </div>
        @endif

      </div>
    </div>
  </div>
</x-app-layout>
