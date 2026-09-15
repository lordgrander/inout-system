<!DOCTYPE html>
<html lang="lo">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Noto Sans Lao"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        border: '#dbeafe',
                        primary: '#2563eb',
                    }
                }
            }
        }
    </script>
    <style>
        @media (min-width: 1024px) {
            #taskShell {
                transition: grid-template-columns .2s ease;
            }

            #taskShell.sidebar-collapsed {
                grid-template-columns: 84px 1fr;
            }

            #taskShell.sidebar-collapsed [data-sidebar-hide] {
                display: none;
            }

            #taskShell.sidebar-collapsed #sidebarToggleIcon {
                transform: rotate(180deg);
            }
        }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-950 lg:overflow-hidden">
    <div id="taskShell" class="min-h-screen lg:grid lg:h-screen lg:grid-cols-[280px_1fr] lg:overflow-hidden">
        <aside class="border-b border-blue-100 bg-white lg:flex lg:h-screen lg:flex-col lg:overflow-y-auto lg:border-b-0 lg:border-r">
            <div class="relative flex items-center justify-center px-4 py-4 lg:px-5">
                <button id="sidebarToggle" type="button" class="hidden h-8 w-8 items-center justify-center rounded-md border border-blue-100 bg-white text-slate-500 transition hover:bg-blue-50 lg:absolute lg:right-3 lg:top-4 lg:inline-flex" title="Toggle sidebar">
                    <span id="sidebarToggleIcon" class="block text-lg leading-none transition-transform">&lsaquo;</span>
                </button>
                <div class="flex h-14 w-14 items-center justify-center rounded-lg font-semibold text-white">
                    <img src="{{ asset('image/thai_laos_middle.png') }}" alt="PTSD Logo" class="img-fluid" max-width="100%" height="auto" style="max-width: 100%; height: auto;">
                </div>
                <!-- <h1 class="text-lg font-semibold">ວຽງຈັນ</h1> -->
                <!-- <p class="text-xs text-slate-500">ເສັ້ນທາງ {{ $roadLabel }}</p> -->
            </div>

            <div data-sidebar-hide class="grid grid-cols-2 gap-3 px-4 pb-4 lg:grid-cols-1 lg:px-5">
                <div class="rounded-lg border border-blue-100 bg-blue-50 p-4">
                    <p class="text-xs font-medium uppercase text-blue-700">ຈຳນວນໃບອະນຸຍາດ</p>
                    <p id="enterCount" class="mt-2 text-3xl font-semibold text-blue-950">0</p>
                </div>
                <div class="rounded-lg border border-blue-100 bg-white p-4">
                    <p class="text-xs font-medium uppercase text-blue-700">ຈຳນວນລາຍການ</p>
                    <p id="detailCount" class="mt-2 text-3xl font-semibold text-slate-950">0</p>
                </div>
            </div>

            <div data-sidebar-hide class="space-y-3 px-4 pb-5 lg:px-5">
                <div class="rounded-lg border border-blue-100 bg-white p-4">
                    <p class="text-xs font-medium uppercase text-slate-500">ຜູ້ໃຊ້</p>
                    <p class="mt-1 text-sm font-medium">{{ $userName }}</p>
                    <!-- <p class="mt-1 text-xs text-slate-500">ໃຊ້ໄດ້ຮອດ {{ $authUntil ? date('d-m-Y', strtotime($authUntil)) : '-' }}</p> -->
                </div>
                <div class="rounded-lg border border-blue-100 bg-white p-4">
                    <p class="text-xs font-medium uppercase text-slate-500">ເວລາປັດຈຸບັນ</p>
                    <div class="mt-3 space-y-2 text-sm">
                        <div class="flex justify-between gap-3"><span>ນະຄອນຫຼວງວຽງຈັນ</span><span id="clockBangkok" class="font-medium tabular-nums">--:--:--</span></div>
                    </div>
                </div>
                <div class="rounded-lg border border-blue-100 bg-white p-4 text-xs text-slate-500">
                    <p>ເຂົ້າລະບົບ</p>
                    <p id="lastSync" class="mt-1 font-medium text-slate-700">ກຳລັງລໍຖ້າຂໍ້ມູນ</p>
                </div>
            </div>

            <form data-sidebar-hide method="POST" action="{{ route('task.logout') }}" class="px-4 pb-5 lg:mt-auto lg:px-5">
                @csrf
                <button type="submit" class="h-10 w-full rounded-md border border-blue-100 bg-white px-3 text-sm font-medium text-slate-700 transition hover:bg-blue-50">
                    ອອກຈາກລະບົບ
                </button>
            </form>
        </aside>

        <main class="px-4 py-5 lg:flex lg:h-screen lg:min-h-0 lg:flex-col lg:overflow-hidden lg:px-6">
            <section class="mb-5 lg:shrink-0">
                <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <!-- <h2 class="text-2xl font-semibold tracking-normal">ລາຍການທີ່ສຳເລັດ</h2> -->
                        <!-- <p class="mt-1 text-sm text-slate-500">ສະແດງສະເພາະລາຍການສຳເລັດ ຂອງເສັ້ນທາງ {{ $roadLabel }}.</p> -->
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <label for="autoReload" class="inline-flex h-10 items-center gap-2 rounded-md border border-blue-100 bg-white px-3 text-sm font-medium text-slate-700">
                            <input id="autoReload" type="checkbox" checked class="h-4 w-4 rounded border-blue-200 text-blue-600 focus:ring-blue-500">
                            <span>ໂຫຼດອັດຕະໂນມັດ</span>
                        </label>
                        <button id="refreshBtn" type="button" class="h-10 rounded-md bg-blue-600 px-4 text-sm font-medium text-white transition hover:bg-blue-700">
                            ຣີເຟຣຊ
                        </button>
                    </div>
                </div>
            </section>

            <section class="mb-5 rounded-lg border border-blue-100 bg-white p-4 shadow-sm lg:shrink-0">
                <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-8">
                    <div>
                        <label for="date_from" class="mb-1 block text-xs font-medium uppercase text-slate-500">ວັນທີເລີ່ມ</label>
                        <input id="date_from" type="date" class="h-10 w-full rounded-md border border-blue-100 px-3 text-sm outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                    </div>
                    <div>
                        <label for="date_to" class="mb-1 block text-xs font-medium uppercase text-slate-500">ວັນທີສິ້ນສຸດ</label>
                        <input id="date_to" type="date" class="h-10 w-full rounded-md border border-blue-100 px-3 text-sm outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium uppercase text-transparent">.</label>
                        <button id="applyDateBtn" type="button" class="h-10 w-full rounded-md bg-blue-600 px-3 text-sm font-medium text-white transition hover:bg-blue-700">
                            ຄົ້ນຫາ
                        </button>
                    </div>
                    <div>
                        <label for="enter_number" class="mb-1 block text-xs font-medium uppercase text-slate-500">ເລກທີ</label>
                        <input id="enter_number" type="search" class="filter-input h-10 w-full rounded-md border border-blue-100 px-3 text-sm outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                    </div>
                    <div>
                        <label for="company_name" class="mb-1 block text-xs font-medium uppercase text-slate-500">ບໍລິສັດ</label>
                        <input id="company_name" type="search" class="filter-input h-10 w-full rounded-md border border-blue-100 px-3 text-sm outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                    </div>
                    <div>
                        <label for="plate_number" class="mb-1 block text-xs font-medium uppercase text-slate-500">ປ້າຍລົດ</label>
                        <input id="plate_number" type="search" class="filter-input h-10 w-full rounded-md border border-blue-100 px-3 text-sm outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                    </div>
                    <div>
                        <label for="d_name" class="mb-1 block text-xs font-medium uppercase text-slate-500">ຊື່ຜູ້ຂັບ</label>
                        <input id="d_name" type="search" class="filter-input h-10 w-full rounded-md border border-blue-100 px-3 text-sm outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                    </div>
                    <div>
                        <label for="p_import" class="mb-1 block text-xs font-medium uppercase text-slate-500">ສິນຄ້າ</label>
                        <input id="p_import" type="search" class="filter-input h-10 w-full rounded-md border border-blue-100 px-3 text-sm outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                    </div>
                </div>
            </section>

            <section class="overflow-hidden rounded-lg border border-blue-100 bg-white shadow-sm lg:flex lg:min-h-0 lg:flex-1 lg:flex-col">
                <div class="hidden min-h-0 flex-1 overflow-auto lg:block">
                    <table class="w-full min-w-[1140px] text-left text-sm">
                        <thead class="sticky top-0 z-10 border-b border-blue-100 bg-blue-50 text-xs uppercase text-blue-800">
                            <tr>
                                <th class="w-[300px] px-4 py-3">ບໍລິສັດ</th>
                                <th class="px-4 py-3">ລາຍລະອຽດ</th>
                                <th class="w-[260px] px-4 py-3">ປາຍທາງ</th>
                                <th class="px-4 py-3">ເສັ້ນທາງ</th>
                                <th class="w-[120px] px-4 py-3">ວັນທີ</th>
                            </tr>
                        </thead>
                        <tbody id="rowsBody" class="divide-y divide-blue-50"></tbody>
                    </table>
                </div>
                <div id="mobileRows" class="divide-y divide-blue-50 lg:hidden"></div>
                <div id="emptyState" class="hidden p-8 text-center text-sm text-slate-500 lg:shrink-0">ບໍ່ພົບຂໍ້ມູນທີ່ກົງກັນ</div>
                <div id="pagination" class="hidden shrink-0 items-center justify-between gap-3 border-t border-blue-100 px-4 py-3 text-sm text-slate-600"></div>
            </section>
        </main>
    </div>

    <div id="fileModal" class="fixed inset-0 z-50 hidden bg-slate-950/60 p-4">
        <div class="mx-auto flex h-full max-w-6xl flex-col overflow-hidden rounded-lg bg-white shadow-xl">
            <div class="flex items-center justify-between gap-3 border-b border-blue-100 px-4 py-3">
                <div>
                    <h3 id="fileModalTitle" class="text-base font-semibold text-slate-950">ໄຟລ໌ແນບ</h3>
                    <p id="fileModalSubtitle" class="text-xs text-slate-500"></p>
                </div>
                <button type="button" onclick="closeFiles()" class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-blue-100 text-slate-600 transition hover:bg-blue-50" title="ປິດ">
                    <span class="text-xl leading-none">&times;</span>
                </button>
            </div>
            <div class="grid min-h-0 flex-1 md:grid-cols-[260px_1fr]">
                <aside id="fileList" class="max-h-64 overflow-y-auto border-b border-blue-100 p-3 md:max-h-none md:border-b-0 md:border-r"></aside>
                <section id="filePreview" class="min-h-[420px] overflow-auto bg-slate-50 p-3"></section>
            </div>
        </div>
    </div>

    <div id="loadingModal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-slate-950/40 p-4">
        <div class="flex items-center gap-3 rounded-lg bg-white px-5 py-4 text-sm font-medium text-slate-700 shadow-xl">
            <span class="h-5 w-5 animate-spin rounded-full border-2 border-blue-100 border-t-blue-600"></span>
            <span>ກຳລັງໂຫຼດຂໍ້ມູນ...</span>
        </div>
    </div>

    <script>
        const dataUrl = @json(route('task.dashboard.data'));
        const today = new Date().toISOString().slice(0, 10);
        const inputs = Array.from(document.querySelectorAll('.filter-input'));
        const rowsBody = document.getElementById('rowsBody');
        const mobileRows = document.getElementById('mobileRows');
        const emptyState = document.getElementById('emptyState');
        const autoReload = document.getElementById('autoReload');
        const fileModal = document.getElementById('fileModal');
        const fileList = document.getElementById('fileList');
        const filePreview = document.getElementById('filePreview');
        const fileModalTitle = document.getElementById('fileModalTitle');
        const fileModalSubtitle = document.getElementById('fileModalSubtitle');
        const loadingModal = document.getElementById('loadingModal');
        const paginationEl = document.getElementById('pagination');
        const taskShell = document.getElementById('taskShell');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const autoReloadStorageKey = 'task_dashboard_auto_reload';
        const autoReloadDateKey = 'task_dashboard_auto_reload_date';
        const sidebarStorageKey = 'task_dashboard_sidebar_collapsed';
        let rowsById = {};
        let timer = null;
        let reloadTimer = null;
        let appliedDateFrom = today;
        let appliedDateTo = today;
        let loadingCount = 0;
        let currentPage = 1;
        let lastPage = 1;

        document.getElementById('date_from').value = today;
        document.getElementById('date_to').value = today;
        restoreAutoReload();
        restoreSidebar();

        function value(id) {
            return document.getElementById(id).value.trim();
        }

        function buildUrl() {
            const params = new URLSearchParams({
                date_from: appliedDateFrom,
                date_to: appliedDateTo,
                enter_number: value('enter_number'),
                company_name: value('company_name'),
                plate_number: value('plate_number'),
                d_name: value('d_name'),
                p_import: value('p_import'),
                page: currentPage,
            });

            return `${dataUrl}?${params.toString()}`;
        }

        function esc(input) {
            return String(input ?? '').replace(/[&<>"']/g, function (char) {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                }[char];
            });
        }

        function fmtDate(input) {
            if (!input) return '-';
            const date = new Date(input);
            if (Number.isNaN(date.getTime())) return input;
            return new Intl.DateTimeFormat('en-GB', {
                timeZone: 'Asia/Bangkok',
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
            }).format(date).replaceAll('/', '-');
        }

        function showLoading() {
            loadingCount++;
            loadingModal.classList.remove('hidden');
            loadingModal.classList.add('flex');
        }

        function hideLoading() {
            loadingCount = Math.max(0, loadingCount - 1);

            if (loadingCount > 0) return;

            loadingModal.classList.add('hidden');
            loadingModal.classList.remove('flex');
        }

        async function loadData() {
            showLoading();

            try {
                const response = await fetch(buildUrl(), { headers: { 'Accept': 'application/json' } });
                if (!response.ok) return;

                const payload = await response.json();
                const rows = payload.rows || [];
                rowsById = Object.fromEntries(rows.map(row => [Number(row.enter_id), row]));
                render(rows);
                document.getElementById('enterCount').textContent = payload.summary.enter_count;
                document.getElementById('detailCount').textContent = payload.summary.detail_count;
                document.getElementById('lastSync').textContent = payload.summary.updated_at;
                renderPagination(payload.summary.pagination || {});
            } finally {
                hideLoading();
            }
        }

        function renderPagination(pagination) {
            currentPage = Number(pagination.page || 1);
            lastPage = Number(pagination.last_page || 1);
            const total = Number(pagination.total || 0);
            const perPage = Number(pagination.per_page || 40);
            const from = total ? ((currentPage - 1) * perPage) + 1 : 0;
            const to = Math.min(currentPage * perPage, total);

            paginationEl.classList.toggle('hidden', total <= perPage);
            paginationEl.classList.toggle('flex', total > perPage);
            paginationEl.innerHTML = `
                <div class="tabular-nums">${from}-${to} / ${total}</div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="goPage(${currentPage - 1})" ${currentPage <= 1 ? 'disabled' : ''} class="h-9 rounded-md border border-blue-100 px-3 text-sm font-medium transition hover:bg-blue-50 disabled:cursor-not-allowed disabled:opacity-40">ກ່ອນໜ້າ</button>
                    <span class="min-w-20 text-center tabular-nums">${currentPage} / ${lastPage}</span>
                    <button type="button" onclick="goPage(${currentPage + 1})" ${currentPage >= lastPage ? 'disabled' : ''} class="h-9 rounded-md border border-blue-100 px-3 text-sm font-medium transition hover:bg-blue-50 disabled:cursor-not-allowed disabled:opacity-40">ຖັດໄປ</button>
                </div>
            `;
        }

        function goPage(page) {
            const nextPage = Math.max(1, Math.min(Number(page), lastPage));
            if (nextPage === currentPage) return;

            currentPage = nextPage;
            autoReload.checked = false;
            saveAutoReload();
            stopAutoReload();
            loadData();
        }

        function render(rows) {
            emptyState.classList.toggle('hidden', rows.length > 0);
            rowsBody.innerHTML = rows.map(row => `
                <tr class="align-top hover:bg-blue-50/50">
                    <td class="px-4 py-4">
                        <div class="space-y-2">
                            <p class="font-medium text-slate-950">${esc(row.com_name || '-')}</p>
                            <p class="text-slate-600">${esc(row.com_phone || '-')}</p>
                            <span class="inline-flex rounded-md bg-emerald-600 px-2 py-1 text-xs font-medium text-white">${esc(row.status || '-')}</span>
                        </div>
                    </td>
                    <td class="max-w-[820px] px-4 py-3">
                        <div class="space-y-1 overflow-x-auto pb-1">
                            <div class="grid min-w-[980px] grid-cols-[150px_120px_170px_170px_260px_90px] gap-4 rounded-md bg-blue-50 px-2 py-2 text-xs font-semibold uppercase text-blue-800">
                                <span>ປ້າຍລົດ</span>
                                <span>ຜູ້ຂັບ</span>
                                <span>ປະເພດ</span>
                                <span>ລາຍລະອຽດ</span>
                                <span>ສິນຄ້າ</span>
                                <span class="text-right">ນ້ຳໜັກ</span>
                            </div>
                            ${detailRows(row.details || [])}
                        </div>
                    </td>
                    <td class="px-4 py-4 text-slate-700"><div class="max-w-[260px] overflow-x-auto whitespace-nowrap pb-1">${esc([row.address, row.district, row.province].filter(Boolean).join(', ') || '-')}</div></td>
                    <td class="px-4 py-4"><div class="max-w-[160px] overflow-x-auto whitespace-nowrap pb-1">${esc(row.main_road_name || row.main_road_id || '-')}</div></td>
                    <td class="px-4 py-4 text-slate-600">${esc(fmtDate(row.date_make))}</td>
                </tr>
            `).join('');

            mobileRows.innerHTML = rows.map(row => `
                <article class="p-4">
                    <div class="mb-3 flex items-start justify-between gap-3">
                        <p class="font-medium text-slate-950">${esc(row.com_name || '-')}</p>
                        <span class="rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700">${esc(row.main_road_name || row.main_road_id || '-')}</span>
                    </div>
                    <dl class="grid grid-cols-2 gap-3 text-sm">
                        <div><dt class="text-xs uppercase text-slate-500">ວັນທີ</dt><dd class="mt-1 font-medium">${esc(fmtDate(row.date_make))}</dd></div>
                        <div><dt class="text-xs uppercase text-slate-500">ບໍລິສັດ</dt><dd class="mt-1">${esc(row.com_name || '-')}</dd></div>
                        <div><dt class="text-xs uppercase text-slate-500">ເບີໂທ</dt><dd class="mt-1">${esc(row.com_phone || '-')}</dd></div>
                    </dl>
                    <div class="mt-4 space-y-2">${mobileDetailRows(row.details || [])}</div>
                    <p class="mt-3 text-sm text-slate-500">${esc([row.address, row.district, row.province].filter(Boolean).join(', ') || '-')}</p>
                </article>
            `).join('');
        }

        function detailRows(details) {
            if (!details.length) {
                return '<p class="py-2 text-sm text-slate-500">ບໍ່ມີລາຍການຍ່ອຍ</p>';
            }

            return details.map(detail => `
                <div class="grid min-w-[980px] grid-cols-[150px_120px_170px_170px_260px_90px] gap-4 rounded-md px-2 py-2 hover:bg-slate-50">
                    <span class="whitespace-nowrap font-medium text-blue-700">${esc(detail.plate_number || '-')}</span>
                    <span class="whitespace-nowrap">${esc(detail.d_name || '-')}</span>
                    <span class="whitespace-nowrap">${esc(detail.t_type_name || '-')}</span>
                    <span class="whitespace-nowrap">${esc(detail.detail || '-')}</span>
                    <span class="whitespace-nowrap font-medium">${esc(detail.p_import || '-')}</span>
                    <span class="whitespace-nowrap text-right tabular-nums">${esc(detail.weight || '-')}</span>
                </div>
            `).join('');
        }

        function mobileDetailRows(details) {
            if (!details.length) {
                return '<p class="rounded-md bg-slate-50 p-3 text-sm text-slate-500">ບໍ່ມີລາຍການຍ່ອຍ</p>';
            }

            return details.map(detail => `
                <div class="rounded-md border border-blue-100 bg-slate-50 p-3 text-sm">
                    <div class="mb-2 flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs uppercase text-slate-500">ປ້າຍລົດ</p>
                            <p class="font-medium text-blue-700">${esc(detail.plate_number || '-')}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs uppercase text-slate-500">ນ້ຳໜັກ</p>
                            <p class="tabular-nums text-slate-700">${esc(detail.weight || '-')}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-slate-700">
                        <div><p class="text-xs uppercase text-slate-500">ຜູ້ຂັບ</p><p>${esc(detail.d_name || '-')}</p></div>
                        <div><p class="text-xs uppercase text-slate-500">ປະເພດ</p><p>${esc(detail.t_type_name || '-')}</p></div>
                        <div><p class="text-xs uppercase text-slate-500">ລາຍລະອຽດ</p><p>${esc(detail.detail || '-')}</p></div>
                        <div><p class="text-xs uppercase text-slate-500">ສິນຄ້າ</p><p class="font-medium">${esc(detail.p_import || '-')}</p></div>
                    </div>
                </div>
            `).join('');
        }

        function fileButton(row) {
            const value = Number(row.file_count || 0);

            if (!value) {
                return '<span class="text-slate-300">-</span>';
            }

            return `
                <button type="button" onclick="openFiles(${Number(row.enter_id)})" class="inline-flex min-w-10 items-center justify-center gap-1 rounded-md border border-blue-100 bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 transition hover:bg-blue-100" title="ເບິ່ງໄຟລ໌ແນບ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 1 1-2.83-2.83l8.49-8.48"></path>
                    </svg>
                    ${value}
                </button>
            `;
        }

        function openFiles(enterId) {
            const row = rowsById[Number(enterId)];
            const files = row?.files || [];

            if (!files.length) return;

            fileModalTitle.textContent = `ໄຟລ໌ແນບ - ${row.enter_number || enterId}`;
            fileModalSubtitle.textContent = `${files.length} ໄຟລ໌`;
            fileList.innerHTML = files.map((file, index) => `
                <button type="button" data-file-index="${index}" class="file-item mb-2 flex w-full items-center gap-2 rounded-md border border-blue-100 bg-white px-3 py-2 text-left text-sm text-slate-700 transition hover:bg-blue-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-none text-blue-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 1 1-2.83-2.83l8.49-8.48"></path>
                    </svg>
                    <span class="min-w-0 flex-1 truncate">${esc(file.file_url || `ໄຟລ໌ ${index + 1}`)}</span>
                </button>
            `).join('');

            Array.from(fileList.querySelectorAll('.file-item')).forEach(button => {
                button.addEventListener('click', () => previewFile(files[Number(button.dataset.fileIndex)]));
            });

            fileModal.classList.remove('hidden');
            previewFile(files[0]);
        }

        function closeFiles() {
            fileModal.classList.add('hidden');
            filePreview.innerHTML = '';
        }

        function previewFile(file) {
            if (!file) return;

            const url = esc(file.url);
            const name = esc(file.file_url || 'ໄຟລ໌ແນບ');

            if (file.kind === 'image') {
                filePreview.innerHTML = `
                    <div class="mb-3 flex items-center justify-between gap-3">
                        <p class="truncate text-sm font-medium text-slate-700">${name}</p>
                        <a href="${url}" target="_blank" class="rounded-md border border-blue-100 bg-white px-3 py-1 text-sm font-medium text-blue-700 hover:bg-blue-50">ເປີດ</a>
                    </div>
                    <img src="${url}" alt="${name}" class="mx-auto max-h-[72vh] max-w-full rounded-md border border-blue-100 bg-white object-contain">
                `;
                return;
            }

            if (file.kind === 'pdf') {
                filePreview.innerHTML = `
                    <div class="mb-3 flex items-center justify-between gap-3">
                        <p class="truncate text-sm font-medium text-slate-700">${name}</p>
                        <a href="${url}" target="_blank" class="rounded-md border border-blue-100 bg-white px-3 py-1 text-sm font-medium text-blue-700 hover:bg-blue-50">ເປີດ</a>
                    </div>
                    <iframe src="${url}" class="h-[72vh] w-full rounded-md border border-blue-100 bg-white"></iframe>
                `;
                return;
            }

            filePreview.innerHTML = `
                <div class="flex h-full min-h-[420px] flex-col items-center justify-center rounded-md border border-blue-100 bg-white p-6 text-center">
                    <p class="text-sm font-medium text-slate-700">${name}</p>
                    <a href="${url}" target="_blank" class="mt-4 rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">ເປີດໄຟລ໌</a>
                </div>
            `;
        }

        fileModal.addEventListener('click', function (event) {
            if (event.target === fileModal) {
                closeFiles();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !fileModal.classList.contains('hidden')) {
                closeFiles();
            }
        });

        function debounceLoad() {
            clearTimeout(timer);
            timer = setTimeout(function () {
                currentPage = 1;
                loadData();
            }, 250);
        }

        function startAutoReload() {
            if (reloadTimer) return;
            reloadTimer = setInterval(loadData, 7000);
        }

        function stopAutoReload() {
            clearInterval(reloadTimer);
            reloadTimer = null;
        }

        function restoreAutoReload() {
            const savedDate = localStorage.getItem(autoReloadDateKey);

            if (savedDate !== today) {
                localStorage.setItem(autoReloadDateKey, today);
                localStorage.setItem(autoReloadStorageKey, '1');
            }

            autoReload.checked = localStorage.getItem(autoReloadStorageKey) !== '0';
        }

        function saveAutoReload() {
            localStorage.setItem(autoReloadDateKey, today);
            localStorage.setItem(autoReloadStorageKey, autoReload.checked ? '1' : '0');
        }

        function restoreSidebar() {
            taskShell.classList.toggle('sidebar-collapsed', localStorage.getItem(sidebarStorageKey) === '1');
        }

        function saveSidebar() {
            localStorage.setItem(sidebarStorageKey, taskShell.classList.contains('sidebar-collapsed') ? '1' : '0');
        }

        function validDateValue(id) {
            const input = document.getElementById(id);

            if (!input.value || !input.checkValidity()) {
                input.reportValidity();
                return null;
            }

            return input.value;
        }

        inputs.forEach(input => input.addEventListener('input', debounceLoad));
        sidebarToggle.addEventListener('click', function () {
            taskShell.classList.toggle('sidebar-collapsed');
            saveSidebar();
        });
        document.getElementById('refreshBtn').addEventListener('click', function () {
            currentPage = 1;
            loadData();
        });
        document.getElementById('applyDateBtn').addEventListener('click', function () {
            const dateFrom = validDateValue('date_from');
            const dateTo = validDateValue('date_to');

            if (!dateFrom || !dateTo) return;

            appliedDateFrom = dateFrom;
            appliedDateTo = dateTo;
            currentPage = 1;
            loadData();
        });
        autoReload.addEventListener('change', function () {
            saveAutoReload();

            if (autoReload.checked) {
                loadData();
                startAutoReload();
                return;
            }

            stopAutoReload();
        });

        function updateClocks() {
            const zones = {
                clockBangkok: 'Asia/Bangkok',
            };

            Object.entries(zones).forEach(([id, zone]) => {
                document.getElementById(id).textContent = new Intl.DateTimeFormat('en-GB', {
                    timeZone: zone,
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false,
                }).format(new Date());
            });
        }

        updateClocks();
        loadData();
        setInterval(updateClocks, 1000);
        if (autoReload.checked) {
            startAutoReload();
        }
    </script>
</body>
</html>
