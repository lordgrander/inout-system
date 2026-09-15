<!DOCTYPE html>
<html lang="lo">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('/images/favicon.svg') }}">
    @php($taskRoutePrefix = $taskRoutePrefix ?? 'new-user-task')
    @php($printUrlBase = $printUrlBase ?? url('/new-user-task-v2/print'))
    
        <title>ຫ້ອງການບໍລິຫານ ດ່ານສາກົນສິນຄ້າ ທ່າບົກທ່ານາແລ້ງ</title>

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

            #taskShell.sidebar-collapsed #sidebarToggle {
                display: none;
            }

            #taskShell.sidebar-collapsed #taskSidebar {
                cursor: pointer;
            }
        }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-950 lg:overflow-hidden">
    <div id="taskShell" class="min-h-screen lg:grid lg:h-screen lg:grid-cols-[280px_1fr] lg:overflow-hidden">
        <aside id="taskSidebar" class="border-b border-blue-100 bg-white lg:flex lg:h-screen lg:flex-col lg:overflow-y-auto lg:border-b-0 lg:border-r">
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

            <form data-sidebar-hide method="POST" action="{{ route($taskRoutePrefix.'.logout') }}" class="px-4 pb-5 lg:mt-auto lg:px-5">
                @csrf
                <button type="submit" class="h-10 w-full rounded-md border border-blue-100 bg-white px-3 text-sm font-medium text-slate-700 transition hover:bg-blue-50">
                    ອອກຈາກລະບົບ
                </button>
            </form>
        </aside>

        <main class="px-4 py-5 lg:flex lg:h-screen lg:min-h-0 lg:flex-col lg:overflow-hidden lg:px-6">
            <section id="dashboardHeader" class="mb-5 lg:shrink-0">
                <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <!-- <h2 class="text-2xl font-semibold tracking-normal">ລາຍການທີ່ສຳເລັດ</h2> -->
                        <!-- <p class="mt-1 text-sm text-slate-500">ສະແດງສະເພາະລາຍການສຳເລັດ ຂອງເສັ້ນທາງ {{ $roadLabel }}.</p> -->
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        @if (in_array((string) $userRole, ['4', '5'], true))
                            <div class="inline-flex h-10 overflow-hidden rounded-md border border-blue-100 bg-white">
                                <button data-sign-mode="manual" type="button" class="sign-mode-btn px-3 text-sm font-medium transition {{ ($signMode ?? 'system') === 'manual' ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-blue-50' }}">
                                    ເຊັນເອງ
                                </button>
                                <button data-sign-mode="system" type="button" class="sign-mode-btn border-l border-blue-100 px-3 text-sm font-medium transition {{ ($signMode ?? 'system') !== 'manual' ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-blue-50' }}">
                                    ເຊັນລະບົບ
                                </button>
                            </div>
                        @endif
                        <button id="controlsCollapseBtn" type="button" class="h-10 rounded-md border border-blue-100 bg-white px-3 text-sm font-medium text-slate-700 transition hover:bg-blue-50">
                            ຫຍໍ້ຕົວກອງ
                        </button>
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

            <button id="controlsExpandBar" type="button" class="mb-3 hidden w-full items-center justify-between rounded-lg border border-blue-100 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-blue-50 lg:shrink-0">
                <span>ຕົວກອງຖືກຫຍໍ້ໄວ້</span>
                <span class="text-blue-700">ສະແດງຕົວກອງ</span>
            </button>

            <section id="filterPanel" class="mb-5 rounded-lg border border-blue-100 bg-white p-4 shadow-sm lg:shrink-0">
                <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-9">
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
                        <label for="status" class="mb-1 block text-xs font-medium uppercase text-slate-500">ສະຖານະ</label>
                        <select id="status" class="filter-input h-10 w-full rounded-md border border-blue-100 bg-white px-3 text-sm outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                            <option value="{{ ['2' => 'WAITING', '3' => 'POINTING', '4' => 'SIGNING'][$userRole] ?? '' }}">ວຽກປັດຈຸບັນ</option>
                            @foreach ($statusOptions as $status)
                                <option value="{{ $status }}">{{ $status === 'SIGNINED' ? 'SIGNED' : $status }}</option>
                            @endforeach
                        </select>
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
                    <table class="w-full min-w-[1460px] text-left text-sm">
                        <thead class="sticky top-0 z-10 border-b border-blue-100 bg-blue-50 text-xs uppercase text-blue-800">
                            <tr>
                                <th class="w-[90px] px-4 py-3">ເລກທີ</th>
                                <th class="w-[300px] px-4 py-3">ບໍລິສັດ</th>
                                <th class="px-4 py-3">ລາຍລະອຽດ</th>
                                <th class="w-[260px] px-4 py-3">ປາຍທາງ</th>
                                <th class="px-4 py-3">ເສັ້ນທາງ</th>
                                <th class="w-[120px] px-4 py-3">ວັນທີ</th>
                                <th class="w-[90px] px-4 py-3">ໄຟລ໌</th>
                                <th class="w-[160px] px-4 py-3">ຈັດການ</th>
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

    <div id="pointingModal" class="fixed inset-0 z-50 hidden bg-slate-950/60 p-4">
        <div class="mx-auto flex max-h-full max-w-3xl flex-col overflow-hidden rounded-lg bg-white shadow-xl">
            <div class="flex items-center justify-between gap-3 border-b border-blue-100 px-4 py-3">
                <div>
                    <h3 id="pointingModalTitle" class="text-base font-semibold text-slate-950">ລະບຸເສັ້ນທາງ</h3>
                    <p id="pointingModalSubtitle" class="text-xs text-slate-500"></p>
                </div>
                <button type="button" onclick="closePointing()" class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-blue-100 text-slate-600 transition hover:bg-blue-50" title="ປິດ">
                    <span class="text-xl leading-none">&times;</span>
                </button>
            </div>
            <div class="min-h-0 flex-1 overflow-y-auto p-4">
                <div class="mb-4 grid gap-3 md:grid-cols-2">
                    <div class="rounded-md bg-blue-50 p-3">
                        <p class="text-xs font-medium uppercase text-blue-700">ສິນຄ້າ</p>
                        <p id="pointingProducts" class="mt-1 text-sm text-slate-700">-</p>
                    </div>
                    <div class="rounded-md bg-blue-50 p-3">
                        <p class="text-xs font-medium uppercase text-blue-700">ປາຍທາງ</p>
                        <p id="pointingDestination" class="mt-1 text-sm text-slate-700">-</p>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="pointingMainRoad" class="mb-1 block text-xs font-medium uppercase text-slate-500">ເສັ້ນທາງຫຼັກ</label>
                    <select id="pointingMainRoad" class="h-10 w-full rounded-md border border-blue-100 bg-white px-3 text-sm outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                        @foreach ($mainRoads as $road)
                            <option value="{{ $road->main_road_id }}">{{ $road->main_road_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <p class="mb-2 text-xs font-medium uppercase text-slate-500">ລາຍການເສັ້ນທາງ</p>
                    <div id="pointingRoads" class="grid max-h-56 gap-2 overflow-y-auto rounded-md border border-blue-100 p-3 md:grid-cols-2">
                        @foreach ($roadOptions as $road)
                            <label class="flex items-center gap-2 text-sm text-slate-700">
                                <input type="checkbox" name="pointing_road" value="{{ $road->road_id }}" class="h-4 w-4 rounded border-blue-200 text-blue-600 focus:ring-blue-500">
                                <span>{{ $road->road_name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="mb-4">
                    <p class="mb-2 text-xs font-medium uppercase text-slate-500">ຫົວຂໍ້ທີ່ເຄີຍໃຊ້</p>
                    <div class="max-h-40 overflow-y-auto rounded-md border border-blue-100">
                        <table class="w-full text-left text-sm">
                            <tbody id="pointingSubjects" class="divide-y divide-blue-50">
                                <tr><td class="px-3 py-2 text-slate-400">-</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div>
                    <label for="pointingDetails" class="mb-1 block text-xs font-medium uppercase text-slate-500">ໝາຍເຫດ</label>
                    <input id="pointingDetails" type="text" class="h-10 w-full rounded-md border border-blue-100 px-3 text-sm outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                </div>
            </div>
            <div class="flex items-center justify-end gap-2 border-t border-blue-100 px-4 py-3">
                <button type="button" onclick="closePointing()" class="h-9 rounded-md border border-blue-100 bg-white px-3 text-sm font-medium text-slate-700 transition hover:bg-blue-50">ຍົກເລີກ</button>
                <button id="pointingSubmitBtn" type="button" class="h-9 rounded-md bg-blue-600 px-4 text-sm font-medium text-white transition hover:bg-blue-700">ຕົກລົງ</button>
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
        const dataUrl = @json(route($taskRoutePrefix.'.dashboard.data'));
        const actionUrl = @json(route($taskRoutePrefix.'.dashboard.action'));
        const pointingUrl = @json(route($taskRoutePrefix.'.dashboard.pointing'));
        const subjectUrl = @json(route($taskRoutePrefix.'.dashboard.subjects'));
        const signModeUrl = @json(route($taskRoutePrefix.'.dashboard.sign-mode'));
        const fileOpenedUrl = @json(route($taskRoutePrefix.'.dashboard.file-opened'));
        const printUrlBase = @json($printUrlBase);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let userRole = @json($userRole);
        const today = new Date().toISOString().slice(0, 10);
        const inputs = Array.from(document.querySelectorAll('.filter-input'));
        const rowsBody = document.getElementById('rowsBody');
        const mobileRows = document.getElementById('mobileRows');
        const emptyState = document.getElementById('emptyState');
        const statusSelect = document.getElementById('status');
        const currentWorkStatus = { '2': 'WAITING', '3': 'POINTING', '4': 'SIGNING' }[String(userRole)] || '';
        const autoReload = document.getElementById('autoReload');
        const fileModal = document.getElementById('fileModal');
        const fileList = document.getElementById('fileList');
        const filePreview = document.getElementById('filePreview');
        const fileModalTitle = document.getElementById('fileModalTitle');
        const fileModalSubtitle = document.getElementById('fileModalSubtitle');
        const pointingModal = document.getElementById('pointingModal');
        const pointingSubjects = document.getElementById('pointingSubjects');
        const pointingSubmitBtn = document.getElementById('pointingSubmitBtn');
        const loadingModal = document.getElementById('loadingModal');
        const taskShell = document.getElementById('taskShell');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const dashboardHeader = document.getElementById('dashboardHeader');
        const filterPanel = document.getElementById('filterPanel');
        const controlsExpandBar = document.getElementById('controlsExpandBar');
        const controlsCollapseBtn = document.getElementById('controlsCollapseBtn');
        const autoReloadStorageKey = 'new_user_task_v2_dashboard_auto_reload';
        const autoReloadDateKey = 'new_user_task_v2_dashboard_auto_reload_date';
        const sidebarStorageKey = 'new_user_task_v2_dashboard_sidebar_collapsed';
        const controlsStorageKey = 'new_user_task_v2_controls_collapsed';
        let rowsById = {};
        let activePointingEnterId = null;
        let timer = null;
        let reloadTimer = null;
        let loadingCount = 0;
        let appliedDateFrom = today;
        let appliedDateTo = today;
        let currentPage = 1;
        let lastPage = 1;
        let activeSignMode = @json($signMode ?? 'system');

        document.getElementById('date_from').value = today;
        document.getElementById('date_to').value = today;

        function value(id) {
            return document.getElementById(id).value.trim();
        }

        function validDateValue(id) {
            const input = document.getElementById(id);

            if (!input.value || !input.checkValidity()) {
                input.reportValidity();
                return null;
            }

            return input.value;
        }

        function buildUrl() {
            const params = new URLSearchParams({
                date_from: appliedDateFrom,
                date_to: appliedDateTo,
                enter_number: value('enter_number'),
                company_name: value('company_name'),
                plate_number: value('plate_number'),
                driver_name: value('d_name'),
                product: value('p_import'),
                status: value('status'),
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

        function statusLabel(status) {
            return status === 'SIGNINED' ? 'SIGNED' : status;
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

        function setControlsCollapsed(collapsed) {
            dashboardHeader.classList.toggle('hidden', collapsed);
            filterPanel.classList.toggle('hidden', collapsed);
            controlsExpandBar.classList.toggle('hidden', !collapsed);
            controlsExpandBar.classList.toggle('flex', collapsed);
            localStorage.setItem(controlsStorageKey, collapsed ? '1' : '0');
        }

        function setSignModeButtons(mode) {
            activeSignMode = mode === 'manual' ? 'manual' : 'system';
            document.querySelectorAll('.sign-mode-btn').forEach(button => {
                const active = button.dataset.signMode === activeSignMode;
                button.classList.toggle('bg-blue-600', active);
                button.classList.toggle('text-white', active);
                button.classList.toggle('text-slate-700', !active);
                button.classList.toggle('hover:bg-blue-50', !active);
            });
        }

        async function saveSignMode(mode) {
            const previousMode = activeSignMode;
            setSignModeButtons(mode);

            const response = await fetch(signModeUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ mode }),
            });

            if (!response.ok) {
                const payload = await response.json().catch(() => ({}));
                alert(payload.message || 'Can not update signing mode.');
                setSignModeButtons(previousMode);
            }
        }

        function restoreControls() {
            setControlsCollapsed(localStorage.getItem(controlsStorageKey) === '1');
        }

        async function loadData(showModal = true) {
            if (showModal) {
                showLoading();
            }

            try {
                const response = await fetch(buildUrl(), { headers: { 'Accept': 'application/json' } });
                if (!response.ok) return;

                const payload = await response.json();
                const rows = payload.rows || [];
                userRole = String(payload.summary.user_role || userRole);
                renderStatusOptions(payload.summary.visible_statuses || []);
                rowsById = Object.fromEntries(rows.map(row => [Number(row.id), row]));
                render(rows);
                document.getElementById('enterCount').textContent = payload.summary.enter_count;
                document.getElementById('detailCount').textContent = payload.summary.detail_count;
                document.getElementById('lastSync').textContent = payload.summary.updated_at;
                renderPagination(payload.summary.pagination || {});
            } finally {
                if (showModal) {
                    hideLoading();
                }
            }
        }

        function renderPagination(pagination) {
            currentPage = Number(pagination.page || 1);
            lastPage = Number(pagination.last_page || 1);
            const total = Number(pagination.total || 0);
            const perPage = Number(pagination.per_page || 20);
            const from = total ? ((currentPage - 1) * perPage) + 1 : 0;
            const to = Math.min(currentPage * perPage, total);
            const paginationEl = document.getElementById('pagination');

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

        function renderStatusOptions(statuses) {
            const selected = statusSelect.value;
            const visibleStatuses = statuses.filter(status => status !== currentWorkStatus);
            statusSelect.innerHTML = `
                <option value="${esc(currentWorkStatus)}">ວຽກປັດຈຸບັນ</option>
                ${visibleStatuses.map(status => `<option value="${esc(status)}">${esc(statusLabel(status))}</option>`).join('')}
            `;

            statusSelect.value = statuses.includes(selected) ? selected : currentWorkStatus;
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
                    <td class="px-4 py-4 font-medium text-slate-950">${esc(row.no || '-')}</td>
                    <td class="px-4 py-4">
                        <div class="space-y-2">
                            <p class="font-medium text-slate-950">${esc(row.com_name || '-')}</p>
                            <p class="text-slate-600">${esc(row.com_phone || '-')}</p>
                            <span class="inline-flex rounded-md bg-emerald-600 px-2 py-1 text-xs font-medium text-white">${esc(statusLabel(row.status) || '-')}</span>
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
                    <td class="px-4 py-4"><div class="max-w-[180px] space-y-1">${roadLabels(row)}</div></td>
                    <td class="px-4 py-4 text-slate-600">${esc(fmtDate(row.date_make))}</td>
                    <td class="px-4 py-4 text-center text-slate-500">${fileButton(row)}</td>
                    <td class="px-4 py-4">${actionButtons(row)}</td>
                </tr>
            `).join('');

            mobileRows.innerHTML = rows.map(row => `
                <article class="p-4">
                    <div class="mb-3 flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs uppercase text-slate-500">ເລກທີ</p>
                            <p class="text-lg font-semibold text-slate-950">${esc(row.no || '-')}</p>
                        </div>
                        <span class="rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700">${esc(row.main_road_name || '-')}</span>
                    </div>
                    <dl class="grid grid-cols-2 gap-3 text-sm">
                        <div><dt class="text-xs uppercase text-slate-500">ວັນທີ</dt><dd class="mt-1 font-medium">${esc(fmtDate(row.date_make))}</dd></div>
                        <div><dt class="text-xs uppercase text-slate-500">ບໍລິສັດ</dt><dd class="mt-1">${esc(row.com_name || '-')}</dd></div>
                        <div><dt class="text-xs uppercase text-slate-500">ສະຖານະ</dt><dd class="mt-1">${esc(statusLabel(row.status) || '-')}</dd></div>
                        <div><dt class="text-xs uppercase text-slate-500">ໄຟລ໌</dt><dd class="mt-1">${fileButton(row)}</dd></div>
                        <div class="col-span-2"><dt class="text-xs uppercase text-slate-500">ຈັດການ</dt><dd class="mt-1">${actionButtons(row)}</dd></div>
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
                    <span class="whitespace-nowrap">${esc(detail.driver_name || '-')}</span>
                    <span class="whitespace-nowrap">${esc(detail.type_name || '-')}</span>
                    <span class="whitespace-nowrap">${esc(detail.reference || '-')}</span>
                    <span class="whitespace-nowrap font-medium">${esc(detail.product || '-')}</span>
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
                        <div><p class="text-xs uppercase text-slate-500">ຜູ້ຂັບ</p><p>${esc(detail.driver_name || '-')}</p></div>
                        <div><p class="text-xs uppercase text-slate-500">ປະເພດ</p><p>${esc(detail.type_name || '-')}</p></div>
                        <div><p class="text-xs uppercase text-slate-500">ເລກອ້າງອີງ</p><p>${esc(detail.reference || '-')}</p></div>
                        <div><p class="text-xs uppercase text-slate-500">ສິນຄ້າ</p><p class="font-medium">${esc(detail.product || '-')}</p></div>
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
                <button type="button" onclick="openFiles(${Number(row.id)})" class="inline-flex min-w-10 items-center justify-center gap-1 rounded-md border border-blue-100 bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 transition hover:bg-blue-100" title="ເບິ່ງໄຟລ໌ແນບ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 1 1-2.83-2.83l8.49-8.48"></path>
                    </svg>
                    ${value}
                </button>
            `;
        }

        function roadLabels(row) {
            const labels = [
                row.main_road_name,
                ...((row.road_names || []).map(road => String(road))),
            ].filter(Boolean);

            if (!labels.length) {
                return '<span class="text-slate-300">-</span>';
            }

            return labels.map(label => `<span class="inline-flex max-w-full rounded-md bg-slate-50 px-2 py-1 text-xs text-slate-700">${esc(label)}</span>`).join('');
        }

        function actionButtons(row) {
            const actions = availableActions(row.status);
            const print = printButton(row);

            if (!actions.length && !print) {
                return '<span class="text-slate-300">-</span>';
            }

            return `
                <div class="flex flex-wrap items-center gap-2">
                    ${actions.map(action => `
                        <button type="button" onclick="${action.id === 'open_pointing' ? `openPointing(${Number(row.id)})` : `runAction(${Number(row.id)}, '${action.id}')`}" class="rounded-md border ${action.kind === 'back' ? 'border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100' : 'border-blue-100 bg-blue-50 text-blue-700 hover:bg-blue-100'} px-2 py-1 text-xs font-medium transition">
                            ${esc(action.label)}
                        </button>
                    `).join('')}
                    ${print}
                </div>
            `;
        }

        function printButton(row) {
            const printableStatuses = ['SIGNINED', 'READY', 'SUCCESS'];

            if (!['3', '5'].includes(String(userRole)) || !printableStatuses.includes(row.status)) {
                return '';
            }

            return `
                <a href="${printUrlBase}/${Number(row.id)}" target="_blank" class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-blue-100 bg-white text-slate-500 transition hover:bg-blue-50" title="ພິມ">
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="h-5 w-5" aria-hidden="true">
                        <path d="M17 17h2a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h2m2 4h6a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2zm8-12V5a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v4h10z"></path>
                    </svg>
                </a>
            `;
        }

        function availableActions(status) {
            const actionsByRole = {
                '2': {
                    WAITING: [{ id: 'send_pointing', label: 'ສົ່ງໄປລະບຸ', kind: 'next' }],
                    POINTING: [{ id: 'back_waiting', label: 'ດຶງກັບ', kind: 'back' }],
                    READY: [{ id: 'send_success', label: 'ສຳເລັດ', kind: 'next' }],
                    SUCCESS: [],
                },
                '3': {
                    POINTING: [{ id: 'open_pointing', label: 'ລະບຸເສັ້ນທາງ', kind: 'next' }],
                    SIGNING: [{ id: 'back_pointing', label: 'ດຶງກັບ', kind: 'back' }],
                    SIGNINED: [{ id: 'send_ready', label: 'ສົ່ງຂາເຂົ້າຂາອອກ', kind: 'next' }],
                    READY: [],
                },
                '4': {
                    SIGNING: [{ id: 'send_signed', label: 'ເຊັນ', kind: 'next' }],
                    SIGNINED: [{ id: 'back_signing', label: 'ດຶງກັບ', kind: 'back' }],
                    READY: [
                        { id: 'send_success', label: 'ສຳເລັດ', kind: 'next' },
                        { id: 'back_signed', label: 'ດຶງກັບ', kind: 'back' },
                    ],
                    SUCCESS: [{ id: 'back_ready', label: 'ດຶງກັບ', kind: 'back' }],
                },
                '5': {
                    WAITING: [{ id: 'send_pointing', label: 'ສົ່ງໄປລະບຸ', kind: 'next' }],
                    POINTING: [
                        { id: 'open_pointing', label: 'ລະບຸເສັ້ນທາງ', kind: 'next' },
                        { id: 'back_waiting', label: 'ດຶງກັບ', kind: 'back' },
                    ],
                    SIGNING: [
                        { id: 'send_signed', label: 'ເຊັນ', kind: 'next' },
                        { id: 'back_pointing', label: 'ດຶງກັບ', kind: 'back' },
                    ],
                    SIGNINED: [
                        { id: 'send_ready', label: 'ສົ່ງຂາເຂົ້າຂາອອກ', kind: 'next' },
                        { id: 'back_signing', label: 'ດຶງກັບ', kind: 'back' },
                    ],
                    READY: [
                        { id: 'send_success', label: 'ສຳເລັດ', kind: 'next' },
                        { id: 'back_signed', label: 'ດຶງກັບ', kind: 'back' },
                    ],
                    SUCCESS: [{ id: 'back_ready', label: 'ດຶງກັບ', kind: 'back' }],
                },
            };

            return actionsByRole[userRole]?.[status] || [];
        }

        async function runAction(enterId, action) {
            showLoading();

            try {
                const response = await fetch(actionUrl, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ id: enterId, action }),
                });

                if (!response.ok) {
                    const payload = await response.json().catch(() => ({}));
                    alert(payload.message || 'Action failed.');
                    return;
                }

                await loadData();
            } finally {
                hideLoading();
            }
        }

        function openPointing(enterId) {
            const row = rowsById[Number(enterId)];
            if (!row) return;

            activePointingEnterId = Number(enterId);
            autoReload.checked = false;
            saveAutoReload();
            stopAutoReload();
            document.getElementById('pointingModalTitle').textContent = `ລະບຸເສັ້ນທາງ - ${row.no || enterId}`;
            document.getElementById('pointingModalSubtitle').textContent = row.com_name || '';
            document.getElementById('pointingProducts').textContent = [...new Set((row.details || []).map(detail => detail.product).filter(Boolean))].join(', ') || '-';
            document.getElementById('pointingDestination').textContent = [row.address, row.district, row.province].filter(Boolean).join(', ') || '-';
            document.getElementById('pointingDetails').value = '';
            Array.from(document.querySelectorAll('input[name="pointing_road"]')).forEach(input => {
                input.checked = false;
            });
            pointingModal.classList.remove('hidden');
            loadPointingSubjects(row.com_id);
        }

        function closePointing() {
            pointingModal.classList.add('hidden');
            activePointingEnterId = null;
        }

        async function loadPointingSubjects(comId) {
            pointingSubjects.innerHTML = '<tr><td class="px-3 py-2 text-slate-400">ກຳລັງໂຫຼດ...</td></tr>';

            if (!comId) {
                pointingSubjects.innerHTML = '<tr><td class="px-3 py-2 text-slate-400">-</td></tr>';
                return;
            }

            try {
                const response = await fetch(subjectUrl, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ id: comId }),
                });

                if (!response.ok) {
                    pointingSubjects.innerHTML = '<tr><td class="px-3 py-2 text-slate-400">Not found</td></tr>';
                    return;
                }

                const payload = await response.json();
                const subjects = Array.isArray(payload.data) ? payload.data : (payload.data ? [payload.data] : []);

                if (!subjects.length) {
                    pointingSubjects.innerHTML = '<tr><td class="px-3 py-2 text-slate-400">No subjects</td></tr>';
                    return;
                }

                pointingSubjects.innerHTML = subjects.map(subject => `
                    <tr>
                        <td class="cursor-pointer px-3 py-2 text-slate-700 hover:bg-blue-50" data-subject="${esc(subject.subject || '')}" onclick="pickPointingSubject(this.dataset.subject)">${esc(subject.subject || '')}</td>
                    </tr>
                `).join('');
            } catch (error) {
                pointingSubjects.innerHTML = '<tr><td class="px-3 py-2 text-slate-400">Not found</td></tr>';
            }
        }

        function pickPointingSubject(subject) {
            document.getElementById('pointingDetails').value = subject;
        }

        async function submitPointing() {
            if (!activePointingEnterId) return;

            const selectedRoads = Array.from(document.querySelectorAll('input[name="pointing_road"]:checked')).map(input => Number(input.value));
            if (!selectedRoads.length) {
                alert('Please select at least one road.');
                return;
            }

            showLoading();

            try {
                const response = await fetch(pointingUrl, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        id: activePointingEnterId,
                        main_road: value('pointingMainRoad'),
                        details: value('pointingDetails'),
                        formdata: selectedRoads,
                    }),
                });

                if (!response.ok) {
                    const payload = await response.json().catch(() => ({}));
                    alert(payload.message || 'Action failed.');
                    return;
                }

                closePointing();
                await loadData();
            } finally {
                hideLoading();
            }
        }

        function openFiles(enterId) {
            const row = rowsById[Number(enterId)];
            const files = row?.files || [];

            if (!files.length) return;

            fileModalTitle.textContent = `ໄຟລ໌ແນບ - ${row.no || enterId}`;
            fileModalSubtitle.textContent = `${files.length} ໄຟລ໌`;
            fileList.innerHTML = files.map((file, index) => `
                <button type="button" data-file-index="${index}" data-file-viewed="${file.viewed ? '1' : '0'}" style="${file.viewed ? 'border:2px solid #0000FF;box-sizing:border-box;' : ''}" class="file-item mb-2 flex w-full items-center gap-2 rounded-md border border-blue-100 bg-white px-3 py-2 text-left text-sm text-slate-700 transition hover:bg-blue-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-none text-blue-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 1 1-2.83-2.83l8.49-8.48"></path>
                    </svg>
                    <span class="min-w-0 flex-1 truncate">${esc(file.name || file.file_url || `ໄຟລ໌ ${index + 1}`)}</span>
                </button>
            `).join('');

            Array.from(fileList.querySelectorAll('.file-item')).forEach(function (button) {
                button.addEventListener('click', function () {
                    const index = Number(button.dataset.fileIndex);
                    previewFile(files[index], index);
                });
            });

            fileModal.classList.remove('hidden');
            previewFile(files[0], 0);
        }

        function closeFiles() {
            fileModal.classList.add('hidden');
            filePreview.innerHTML = '';
        }

        function markActiveFile(index) {
            Array.from(fileList.querySelectorAll('.file-item')).forEach(function (button) {
                const active = Number(button.dataset.fileIndex) === Number(index);
                const viewed = button.dataset.fileViewed === '1';
                button.style.border = (active || viewed) ? '2px solid #0000FF' : '1px solid #dbeafe';
                button.style.boxSizing = 'border-box';
            });
        }

        function recordFileOpened(file) {
            if (!file || !file.file_id || !file.enter_id) return;

            fetch(fileOpenedUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    enter_id: file.enter_id,
                    file_id: file.file_id,
                }),
            }).catch(function () {});
        }

        function previewFile(file, index) {
            if (!file) return;

            file.viewed = true;
            const button = fileList.querySelector(`[data-file-index="${Number(index)}"]`);
            if (button) {
                button.dataset.fileViewed = '1';
            }
            markActiveFile(index);
            recordFileOpened(file);

            const url = esc(file.url);
            const name = esc(file.name || file.file_url || 'ໄຟລ໌ແນບ');

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

        pointingModal.addEventListener('click', function (event) {
            if (event.target === pointingModal) {
                closePointing();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !fileModal.classList.contains('hidden')) {
                closeFiles();
            }
            if (event.key === 'Escape' && !pointingModal.classList.contains('hidden')) {
                closePointing();
            }
        });

        pointingSubmitBtn.addEventListener('click', submitPointing);
        sidebarToggle.addEventListener('click', function (event) {
            event.stopPropagation();
            taskShell.classList.toggle('sidebar-collapsed');
            saveSidebar();
        });
        document.getElementById('taskSidebar').addEventListener('click', function (event) {
            if (!taskShell.classList.contains('sidebar-collapsed')) return;
            if (!window.matchMedia('(min-width: 1024px)').matches) return;

            taskShell.classList.remove('sidebar-collapsed');
            saveSidebar();
        });
        controlsCollapseBtn.addEventListener('click', function () {
            setControlsCollapsed(true);
        });
        controlsExpandBar.addEventListener('click', function () {
            setControlsCollapsed(false);
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
            reloadTimer = setInterval(function () {
                loadData(false);
            }, 7000);
        }

        function stopAutoReload() {
            clearInterval(reloadTimer);
            reloadTimer = null;
        }

        inputs.forEach(input => {
            input.addEventListener(input.tagName === 'SELECT' ? 'change' : 'input', debounceLoad);
        });
        document.querySelectorAll('.sign-mode-btn').forEach(button => {
            button.addEventListener('click', function () {
                saveSignMode(button.dataset.signMode);
            });
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

        restoreSidebar();
        restoreControls();
        restoreAutoReload();
        updateClocks();
        loadData();
        setInterval(updateClocks, 1000);
        if (autoReload.checked) {
            startAutoReload();
        }
    </script>
</body>
</html>
