<x-app-layout>
    <style>
        .core-shell {
            max-width: 1280px;
            margin: 0 auto;
            padding: 16px;
        }

        .core-toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .core-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .core-tab {
            display: inline-flex;
            align-items: center;
            padding: 8px 14px;
            border: 1px solid #d1d5db;
            border-radius: 999px;
            color: #111827;
            text-decoration: none;
            background: #fff;
        }

        .core-tab.is-active {
            border-color: #111827;
            background: #111827;
            color: #fff;
        }

        .core-search {
            display: flex;
            gap: 8px;
            flex: 1 1 320px;
            justify-content: flex-end;
        }

        .core-search input {
            width: min(420px, 100%);
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 10px 12px;
        }

        .core-search button,
        .core-btn,
        .core-menu button,
        .core-modal button {
            border: 1px solid #d1d5db;
            border-radius: 10px;
            background: #fff;
            color: #111827;
            padding: 8px 12px;
        }

        .core-list {
            display: grid;
            gap: 16px;
        }

        .core-card {
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
            padding: 18px;
        }

        .core-card.is-removing {
            opacity: 0;
            transform: translateY(-8px);
            transition: 0.25s ease;
        }

        .core-head {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 14px;
        }

        .core-subtitle {
            color: #6b7280;
            font-size: 0.9rem;
        }

        .core-status {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-waiting { background: #fef3c7; color: #92400e; }
        .status-pointing { background: #dbeafe; color: #1d4ed8; }
        .status-signing { background: #fde68a; color: #92400e; }
        .status-signed { background: #dbeafe; color: #1d4ed8; }
        .status-ready { background: #e0f2fe; color: #075985; }
        .status-success { background: #dcfce7; color: #166534; }
        .status-cancel { background: #fee2e2; color: #b91c1c; }

        .core-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 12px;
            margin-bottom: 14px;
        }

        .core-block {
            border: 1px solid #f3f4f6;
            border-radius: 14px;
            padding: 12px;
            background: #fafafa;
        }

        .core-block h4 {
            margin: 0 0 8px;
            font-size: 0.9rem;
            color: #6b7280;
        }

        .core-details,
        .core-roads,
        .core-files,
        .core-menu {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .core-detail {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 10px;
            background: #fff;
            min-width: 220px;
        }

        .core-detail-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 6px;
        }

        .core-paper-toggle {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: #374151;
            user-select: none;
        }

        .core-paper-toggle input {
            width: 16px;
            height: 16px;
        }

        .core-menu {
            margin-top: 10px;
        }

        .core-menu a {
            text-decoration: none;
        }

        .core-files a {
            text-decoration: none;
        }

        .core-file {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid #d1d5db;
            border-radius: 999px;
            padding: 6px 10px;
            background: #fff;
            color: #111827;
        }

        .core-pagination {
            margin-top: 18px;
            display: flex;
            justify-content: center;
        }

        .core-empty {
            padding: 32px;
            text-align: center;
            border: 1px dashed #d1d5db;
            border-radius: 18px;
            background: #fff;
            color: #6b7280;
        }

        .core-modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 50;
        }

        .core-modal-backdrop.is-open {
            display: flex;
        }

        .core-modal {
            width: min(680px, calc(100vw - 24px));
            background: #fff;
            border-radius: 18px;
            padding: 18px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.25);
        }

        .core-modal h3 {
            margin: 0 0 12px;
            font-size: 1.1rem;
        }

        .core-modal textarea,
        .core-modal select {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 10px 12px;
            margin-bottom: 12px;
        }

        .core-road-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 8px;
            max-height: 260px;
            overflow: auto;
            margin-bottom: 12px;
        }

        .core-road-list label {
            display: flex;
            gap: 8px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 8px 10px;
            background: #fafafa;
        }

        .core-modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }
    </style>

    <div class="core-shell">
        <div class="core-toolbar">
            <div class="core-tabs">
                <a class="core-tab {{ $scope === 'success' ? 'is-active' : '' }}" href="{{ route('test.core-work.index', ['scope' => 'success']) }}">Success</a>
                <a class="core-tab {{ $scope === 'cancel' ? 'is-active' : '' }}" href="{{ route('test.core-work.index', ['scope' => 'cancel']) }}">Cancel</a>
                <a class="core-tab {{ $scope === 'all' ? 'is-active' : '' }}" href="{{ route('test.core-work.index', ['scope' => 'all']) }}">All</a>
            </div>

            <form class="core-search" method="GET" action="{{ route('test.core-work.index', ['scope' => $scope]) }}">
                <input type="hidden" name="scope" value="{{ $scope }}">
                <input
                    type="text"
                    id="text-search"
                    name="search"
                    value="{{ $search }}"
                    placeholder="ຄົ້ນຫາບໍລິສັດ, ເລກທີ່, ບ້ານ, ເມືອງ, ແຂວງ"
                    autocomplete="off"
                >
                <button type="submit">Search</button>
            </form>
        </div>

        <div id="working-place-focus">
            @if ($entries->count() === 0)
                <div class="core-empty">No records found for this view.</div>
            @else
                <div class="core-list">
                    @foreach ($entries as $entry)
                        @php
                            $details = $detailsByEnterId->get($entry->enter_id, collect());
                            $roads = $roadsByEnterId->get($entry->enter_id, collect());
                            $files = $filesByEnterId->get($entry->enter_id, collect());
                            $productList = $details->pluck('p_import')->filter()->implode('<br>');
                            $statusClass = '';
                            if ($entry->status === 'WAITING') {
                                $statusClass = 'status-waiting';
                            } elseif ($entry->status === 'POINTING') {
                                $statusClass = 'status-pointing';
                            } elseif ($entry->status === 'SIGNING') {
                                $statusClass = 'status-signing';
                            } elseif ($entry->status === 'SIGNINED') {
                                $statusClass = 'status-signed';
                            } elseif ($entry->status === 'READY') {
                                $statusClass = 'status-ready';
                            } elseif ($entry->status === 'SUCCESS') {
                                $statusClass = 'status-success';
                            } elseif ($entry->status === 'CANCEL') {
                                $statusClass = 'status-cancel';
                            }
                        @endphp

                        <div class="core-card js-row" data-id="{{ $entry->enter_id }}">
                            <div class="core-head">
                                <div>
                                    <div><strong>{{ $entry->enter_number }}</strong> {{ $entry->com_name }}</div>
                                    <div class="core-subtitle">
                                        {{ date('d-m-Y', strtotime($entry->date_in)) }} · {{ $entry->name }} · {{ $entry->email }}
                                    </div>
                                    @if ($entry->status === 'CANCEL' && $entry->cancel_log)
                                        <div class="core-subtitle" style="color:#b91c1c;">ສາເຫດ : {{ $entry->cancel_log }}</div>
                                    @endif
                                </div>

                                <div class="core-status {{ $statusClass }}">
                                    {{ $entry->status }}
                                </div>
                            </div>

                            <div class="core-grid">
                                <div class="core-block">
                                    <h4>Cars / Goods</h4>
                                    <div class="core-details">
                                        @forelse ($details as $detail)
                                            <div class="core-detail">
                                                    <div>
                                                        <label class="core-paper-toggle">
                                                            <input
                                                                type="checkbox"
                                                                class="js-paper-toggle"
                                                                data-detail-id="{{ $detail->enter_detail_id }}"
                                                                {{ ($detail->is_paper ?? 'no') === 'yes' ? 'checked' : '' }}
                                                            >
                                                            <span>ເພີ່ມໃບສຳຫລວດ</span>
                                                        </label> 
                                                    </div>
                                                <div class="core-detail-head">
                                                <div><strong>{{ $detail->plate_number }}</strong> · {{ $detail->d_name }}</div>
                                                </div>
                                                <div class="core-subtitle">
                                                    {{ $detail->t_type_name }} @if($detail->rounds != 1 && $detail->rounds !== '') ({{ $detail->rounds }}) @endif
                                                </div>
                                                <div>{{ $detail->p_import }}</div>
                                                <div class="core-subtitle">{{ $detail->detail }}</div>
                                                <div class="core-subtitle">Weight: {{ $detail->weight }}</div>
                                            </div>
                                        @empty
                                            <div class="core-subtitle">No detail rows</div>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="core-block">
                                    <h4>Route</h4>
                                    <div><strong>{{ $entry->main_road_name }}</strong></div>
                                    <div class="core-roads">
                                        @forelse ($roads as $road)
                                            <span class="core-file">{{ $road->road_name }}</span>
                                        @empty
                                            <span class="core-subtitle">No route detail</span>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="core-block">
                                    <h4>Destination</h4>
                                    <div>ບ້ານ {{ str_replace('ບ້ານ', '', $entry->address) }}</div>
                                    <div>ເມືອງ {{ str_replace('ເມືອງ', '', $entry->district) }}</div>
                                    <div>ແຂວງ {{ str_replace('ແຂວງ', '', $entry->province) }}</div>
                                    @if ($entry->lasttails)
                                        <div class="core-subtitle">({{ $entry->lasttails }})</div>
                                    @endif
                                    @if ($entry->feed_back_msg)
                                        <div class="core-subtitle" style="color:#2563eb;">ໝາຍເຫດ : {{ $entry->feed_back_msg }}</div>
                                    @endif
                                </div>

                                <div class="core-block">
                                    <h4>Files</h4>
                                    <div class="core-files">
                                        <a class="core-file" href="{{ url('/see/enter/list/view/' . $entry->enter_id) }}">View</a>
                                        @if (in_array((string) auth()->user()->is_admin, ['2', '3', '5'], true) && in_array($entry->status, ['SIGNINED', 'READY', 'SUCCESS'], true))
                                            <a class="core-file" href="{{ url('/see/enter/print/' . $entry->enter_id) }}" target="_blank" rel="noopener">Print</a>
                                        @endif
                                        @foreach ($files as $file)
                                            <a class="core-file" href="{{ asset($file->file_url) }}" target="_blank" rel="noopener">File</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="core-menu">
                                @if ((string) auth()->user()->is_admin === '2')
                                    @if ($entry->status === 'WAITING')
                                        <button type="button" class="js-action" data-action="accept" data-id="{{ $entry->enter_id }}">ຍອມຮັບ</button>
                                        <button type="button" class="js-open-cancel" data-id="{{ $entry->enter_id }}">ຍົກເລີກ</button>
                                    @elseif ($entry->status === 'POINTING')
                                        <button type="button" class="js-action" data-action="back" data-id="{{ $entry->enter_id }}">ດຶງກັບ</button>
                                    @elseif ($entry->status === 'READY')
                                        <button type="button" class="js-action" data-action="readyBack" data-id="{{ $entry->enter_id }}">ຕີກັບ</button>
                                        <button type="button" class="js-send-company" data-id="{{ $entry->enter_id }}">ສົ່ງໃຫ້ບໍລິສັດ</button>
                                    @elseif ($entry->status === 'SUCCESS')
                                        @if (auth()->user()->log === 'YES')
                                            <button type="button" class="js-action" data-action="successBack" data-id="{{ $entry->enter_id }}">ດຶງກັບ</button>
                                        @endif
                                        <button type="button" class="js-open-cancel" data-id="{{ $entry->enter_id }}">ຍົກເລີກ</button>
                                    @elseif ($entry->status === 'CANCEL')
                                        <button type="button" class="js-action" data-action="reroll" data-id="{{ $entry->enter_id }}">ດຶງກັບ</button>
                                    @endif
                                @endif

                                @if ((string) auth()->user()->is_admin === '3')
                                    @if ($entry->status === 'POINTING')
                                        <button
                                            type="button"
                                            class="js-open-pointing"
                                            data-id="{{ $entry->enter_id }}"
                                            data-address="{{ str_replace('ບ້ານ', '', $entry->address) }}"
                                            data-district="{{ str_replace('ເມືອງ', '', $entry->district) }}"
                                            data-province="{{ str_replace('ແຂວງ', '', $entry->province) }}"
                                            data-products="{{ $productList }}"
                                        >ສົ່ງໄປຖ້າເຊັນ</button>
                                        <button type="button" class="js-open-pointing-back" data-id="{{ $entry->enter_id }}">ຕີກັບ</button>
                                    @elseif ($entry->status === 'SIGNING')
                                        <button type="button" class="js-action" data-action="backSigning" data-id="{{ $entry->enter_id }}">ດຶງກັບ</button>
                                    @elseif ($entry->status === 'SIGNINED')
                                        <button type="button" class="js-action" data-action="backBossSign" data-id="{{ $entry->enter_id }}">ຕີກັບ</button>
                                        <button type="button" class="js-action" data-action="ready" data-id="{{ $entry->enter_id }}">ສົ່ງຂາເຂົ້າຂາອອກ</button>
                                    @endif
                                @endif

                                @if ((string) auth()->user()->is_admin === '4')
                                    @if ($entry->status === 'SIGNING')
                                        <button type="button" class="js-open-boss-back" data-id="{{ $entry->enter_id }}">ຕີກັບ</button>
                                        <button type="button" class="js-action" data-action="sign" data-id="{{ $entry->enter_id }}">ລົງລາຍເຊັນ</button>
                                    @elseif ($entry->status === 'SIGNINED')
                                        <button type="button" class="js-action" data-action="backToSign" data-id="{{ $entry->enter_id }}">ຍົກເລີກເຊັນ</button>
                                    @elseif ($entry->status === 'SUCCESS' && auth()->user()->log === 'YES')
                                        <button type="button" class="js-action" data-action="successBack" data-id="{{ $entry->enter_id }}">ດຶງກັບ</button>
                                    @endif
                                @endif

                                @if ((string) auth()->user()->is_admin === '5')
                                    @if ($entry->status === 'WAITING')
                                        <button type="button" class="js-action" data-action="accept" data-id="{{ $entry->enter_id }}">ຍອມຮັບ</button>
                                        <button type="button" class="js-open-cancel" data-id="{{ $entry->enter_id }}">ຍົກເລີກ</button>
                                    @elseif ($entry->status === 'POINTING')
                                        <button type="button" class="js-open-pointing-back" data-id="{{ $entry->enter_id }}">ຕີກັບ</button>
                                    @elseif ($entry->status === 'SIGNING')
                                        <button type="button" class="js-action" data-action="backSigning" data-id="{{ $entry->enter_id }}">ດຶງກັບ</button>
                                        <button type="button" class="js-open-boss-back" data-id="{{ $entry->enter_id }}">ຕີກັບ</button>
                                        <button type="button" class="js-action" data-action="sign" data-id="{{ $entry->enter_id }}">ລົງລາຍເຊັນ</button>
                                    @elseif ($entry->status === 'SIGNINED')
                                        <button type="button" class="js-action" data-action="backBossSign" data-id="{{ $entry->enter_id }}">ຕີກັບ</button>
                                        <button type="button" class="js-action" data-action="backToSign" data-id="{{ $entry->enter_id }}">ຍົກເລີກເຊັນ</button>
                                    @elseif ($entry->status === 'SUCCESS' && auth()->user()->log === 'YES')
                                        <button type="button" class="js-action" data-action="successBack" data-id="{{ $entry->enter_id }}">ດຶງກັບ</button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="core-pagination">
                    {{ $entries->links('pagination.custome-pagination') }}
                </div>
            @endif
        </div>
    </div>

    <div class="core-modal-backdrop" id="reasonModal">
        <div class="core-modal">
            <h3 id="reasonModalTitle">Add reason</h3>
            <textarea id="reasonModalInput" rows="4" placeholder="Type reason"></textarea>
            <div class="core-modal-actions">
                <button type="button" class="js-close-modal">Close</button>
                <button type="button" id="reasonModalConfirm">Confirm</button>
            </div>
        </div>
    </div>

    <div class="core-modal-backdrop" id="pointingModal">
        <div class="core-modal">
            <h3>Pointing detail</h3>
            <div class="core-subtitle" id="pointingSummary"></div>
            <div class="core-subtitle" id="pointingProducts" style="margin-bottom:12px;"></div>

            <select id="pointingMainRoad">
                @foreach ($mainRoads as $road)
                    <option value="{{ $road->main_road_id }}">{{ $road->main_road_name }}</option>
                @endforeach
            </select>

            <div class="core-road-list">
                @foreach ($roadOptions as $road)
                    <label>
                        <input type="checkbox" name="pointingRoad" value="{{ $road->road_id }}">
                        <span>{{ $road->road_name }}</span>
                    </label>
                @endforeach
            </div>

            <textarea id="pointingDetails" rows="3" placeholder="ໝາຍເຫດ"></textarea>
            <div class="core-modal-actions">
                <button type="button" class="js-close-modal">Close</button>
                <button type="button" id="pointingModalConfirm">Confirm</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const workflowUrls = {
            accept: "{{ route('test.core-work.accept') }}",
            sendCompany: "{{ route('test.core-work.send-company') }}",
            back: "{{ route('test.core-work.back') }}",
            backBossSign: "{{ route('test.core-work.back-boss-sign') }}",
            backToSign: "{{ route('test.core-work.back-to-sign') }}",
            pointing: "{{ route('test.core-work.pointing') }}",
            backPointing: "{{ route('test.core-work.back-pointing') }}",
            backSigning: "{{ route('test.core-work.back-signing') }}",
            sign: "{{ route('test.core-work.sign') }}",
            backBoss: "{{ route('test.core-work.back-boss') }}",
            readyBack: "{{ route('test.core-work.ready-back') }}",
            successBack: "{{ route('test.core-work.success-back') }}",
            cancel: "{{ route('test.core-work.cancel') }}",
            reroll: "{{ route('test.core-work.reroll') }}",
            ready: "{{ route('test.core-work.ready') }}",
            updatePaper: "{{ route('test.core-work.update-paper') }}"
        };

        let reasonModalState = null;
        let pointingRowId = null;

        function csrfHeaders() {
            return {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
        }

        function hideModals() {
            $('#reasonModal, #pointingModal').removeClass('is-open');
            $('#reasonModalInput').val('');
            $('#pointingDetails').val('');
            $('input[name="pointingRoad"]').prop('checked', false);
            reasonModalState = null;
            pointingRowId = null;
        }

        function fadeRow(id) {
            const row = $('.js-row[data-id="' + id + '"]');
            row.addClass('is-removing');
            setTimeout(function () {
                row.slideUp(180, function () {
                    $(this).remove();
                });
            }, 150);
        }

        function postWorkflow(url, data, onSuccess) {
            $.ajax({
                type: 'POST',
                url: url,
                headers: csrfHeaders(),
                data: data,
                dataType: 'json',
                success: function (response) {
                    if (typeof onSuccess === 'function') {
                        onSuccess(response);
                    }
                },
                error: function (xhr) {
                    const message = xhr.responseJSON?.message || 'Request failed';
                    alert(message);
                }
            });
        }

        $(document).on('click', '.js-action', function () {
            const action = $(this).data('action');
            const id = $(this).data('id');
            postWorkflow(workflowUrls[action], { id: id }, function () {
                fadeRow(id);
            });
        });

        $(document).on('click', '.js-send-company', function () {
            const id = $(this).data('id');
            const take = window.prompt('take value', '') || '';

            postWorkflow(workflowUrls.sendCompany, { id: id, take: take }, function () {
                fadeRow(id);
            });
        });

        $(document).on('click', '.js-open-cancel', function () {
            reasonModalState = {
                url: workflowUrls.cancel,
                id: $(this).data('id'),
                field: 'log'
            };
            $('#reasonModalTitle').text('ສາເຫດຍົກເລີກ');
            $('#reasonModal').addClass('is-open');
        });

        $(document).on('click', '.js-open-pointing-back', function () {
            reasonModalState = {
                url: workflowUrls.backPointing,
                id: $(this).data('id'),
                field: 'log'
            };
            $('#reasonModalTitle').text('ສາເຫດທີ່ຕີກັບ');
            $('#reasonModal').addClass('is-open');
        });

        $(document).on('click', '.js-open-boss-back', function () {
            reasonModalState = {
                url: workflowUrls.backBoss,
                id: $(this).data('id'),
                field: 'log'
            };
            $('#reasonModalTitle').text('ສາເຫດຕີກັບຈາກການເຊັນ');
            $('#reasonModal').addClass('is-open');
        });

        $('#reasonModalConfirm').on('click', function () {
            const value = $('#reasonModalInput').val().trim();
            if (!reasonModalState || value === '') {
                alert('Please fill the reason first.');
                return;
            }

            const payload = { id: reasonModalState.id };
            payload[reasonModalState.field] = value;

            postWorkflow(reasonModalState.url, payload, function () {
                fadeRow(reasonModalState.id);
                hideModals();
            });
        });

        $(document).on('click', '.js-open-pointing', function () {
            pointingRowId = $(this).data('id');
            $('#pointingSummary').text(
                'ບ້ານ ' + ($(this).data('address') || '') +
                ' · ເມືອງ ' + ($(this).data('district') || '') +
                ' · ແຂວງ ' + ($(this).data('province') || '')
            );
            $('#pointingProducts').html($(this).data('products') || '');
            $('#pointingModal').addClass('is-open');
        });

        $('#pointingModalConfirm').on('click', function () {
            const selectedRoads = $('input[name="pointingRoad"]:checked').map(function () {
                return $(this).val();
            }).get();

            if (!pointingRowId || selectedRoads.length === 0) {
                alert('Please select at least one road.');
                return;
            }

            postWorkflow(workflowUrls.pointing, {
                id: pointingRowId,
                main_road: $('#pointingMainRoad').val(),
                details: $('#pointingDetails').val(),
                formdata: selectedRoads
            }, function () {
                fadeRow(pointingRowId);
                hideModals();
            });
        });

        $(document).on('change', '.js-paper-toggle', function () {
            const checkbox = $(this);
            const detailId = checkbox.data('detail-id');
            const checked = checkbox.is(':checked');
            const nextValue = checked ? 'yes' : 'no';
            const previousChecked = !checked;

            Swal.fire({
                title: 'Confirm change?',
                text: 'This will update is_paper to ' + nextValue + '.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it',
                cancelButtonText: 'Cancel'
            }).then(function (result) {
                if (!result.isConfirmed) {
                    checkbox.prop('checked', previousChecked);
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: workflowUrls.updatePaper,
                    headers: csrfHeaders(),
                    data: {
                        detail_id: detailId,
                        value: nextValue
                    },
                    dataType: 'json',
                    success: function () {
                        Swal.fire({
                            title: 'Updated',
                            text: 'is_paper is now ' + nextValue + '.',
                            icon: 'success',
                            timer: 1200,
                            showConfirmButton: false
                        });
                    },
                    error: function (xhr) {
                        checkbox.prop('checked', previousChecked);
                        Swal.fire({
                            title: 'Update failed',
                            text: xhr.responseJSON?.message || 'Request failed',
                            icon: 'error'
                        });
                    }
                });
            });
        });

        $(document).on('click', '.js-close-modal', function () {
            hideModals();
        });

        $('.core-modal-backdrop').on('click', function (event) {
            if (event.target === this) {
                hideModals();
            }
        });
    </script>
</x-app-layout>
