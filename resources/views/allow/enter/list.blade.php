<x-app-layout>
  @php
    $isHistory = request()->routeIs('EnterHistoryList');
    $activeCount = count($beta_enter ?? []);
    $cancelCount = count($beta_enter_cancel ?? []);
    $draftCount = count($beta_enter_draft ?? []);
    $fileCount = count($beta_enter_file ?? []);

    $statusMap = [
      'WAITING' => ['wait', 'ກຳລັງລໍຖ້າ'],
      'QWAIT' => ['wait', 'ກຳລັງລໍຖ້າ'],
      'POINTING' => ['process', 'ກຳລັງລະບຸສາຍທາງ'],
      'SIGNING' => ['process', 'ກຳລັງດຳເນີນການ'],
      'QSIGNING' => ['process', 'ລໍຖ້າລົງລາຍເຊັນ'],
      'SIGNINED' => ['process', 'ລົງລາຍເຊັນແລ້ວ'],
      'READY' => ['ready', 'ລໍຖ້າສົ່ງເອກະສານ'],
      'SUCCESS' => ['done', 'ສຳເລັດ'],
      'CANCEL' => ['bad', 'ຍົກເລີກ'],
      'DRAFT' => ['draft', 'Draft'],
    ];

    $fileGroups = collect($beta_enter_file ?? [])->groupBy('enter_id');
    $cancelFileGroups = collect($beta_enter_file_cancel ?? [])->groupBy('enter_id');
  @endphp

  <style>
    :root{
      --ink:#182230;
      --muted:#667085;
      --line:#d9e2ec;
      --soft:#f7fafc;
      --brand:#0a4e9b;
      --teal:#0f766e;
      --amber:#b7791f;
      --danger:#b42318;
      --green:#137333;
    }
    body{background:#f3f7fb;color:var(--ink)}
    .history-shell{max-width:1380px;margin:0 auto;padding:14px 14px 28px}
    .history-head{display:flex;align-items:flex-end;justify-content:space-between;gap:16px;margin-bottom:14px}
    .history-title{font-size:24px;font-weight:900;letter-spacing:0;margin:0;color:#0b2f5b}
    .history-sub{font-size:13px;color:var(--muted);margin:3px 0 0}
    .head-actions{display:flex;gap:8px;flex-wrap:wrap;justify-content:flex-end}
    .btn{border-radius:8px!important;font-weight:800!important}
    .btn-soft{background:#fff;color:#344054;border:1px solid var(--line)}
    .btn-soft:hover{background:#f8fafc;color:#182230}
    .stat-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:10px;margin-bottom:14px}
    .stat{background:#fff;border:1px solid var(--line);border-radius:8px;padding:12px 14px;box-shadow:0 8px 22px rgba(16,24,40,.05)}
    .stat-label{font-size:12px;font-weight:900;text-transform:uppercase;color:var(--muted)}
    .stat-value{font-size:24px;font-weight:900;color:#102a43;line-height:1.1;margin-top:4px}
    .panel{background:#fff;border:1px solid var(--line);border-radius:8px;box-shadow:0 8px 22px rgba(16,24,40,.06);overflow:hidden}
    .panel-head{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:13px 16px;border-bottom:1px solid var(--line);background:#fbfdff}
    .panel-title{font-size:16px;font-weight:900;margin:0;color:#102a43}
    .table-zone{padding:12px}
    .table-wrap{overflow:auto;border:1px solid var(--line);border-radius:8px}
    .table{margin-bottom:0!important}
    .table thead th{background:#eef4fb!important;color:#344054!important;border-bottom:1px solid var(--line)!important;font-size:12px;text-transform:uppercase;white-space:nowrap}
    .table tbody td{background:#fff!important;font-size:14px;vertical-align:middle!important}
    .doc-number{font-weight:900;color:#102a43}
    .muted{color:var(--muted);font-size:12px}
    .status-chip{display:inline-flex;align-items:center;min-height:28px;border-radius:999px;padding:4px 10px;font-size:12px;font-weight:900;white-space:nowrap}
    .status-wait{background:#e8f1ff;color:#0a4e9b}
    .status-process{background:#fff4df;color:#8a4b00}
    .status-ready{background:#e6f6f3;color:#0f766e}
    .status-done{background:#e7f6ec;color:#137333}
    .status-bad{background:#fde8e5;color:#b42318}
    .status-draft{background:#f1f5f9;color:#475569}
    .action-stack{display:flex;gap:6px;flex-wrap:wrap}
    .file-stack{display:flex;gap:6px;flex-wrap:wrap}
    .file-link{display:inline-flex;align-items:center;justify-content:center;min-width:34px;height:30px;border:1px solid var(--line);border-radius:8px;background:#fff;color:#344054;font-size:12px;font-weight:900}
    .file-link:hover{background:#eef4fb;text-decoration:none;color:#0a4e9b}
    .empty-note{padding:26px;text-align:center;color:var(--muted);font-weight:800}
    .dataTables_wrapper{padding-top:2px}
    .dataTables_filter,.dataTables_length{float:right!important;margin-left:8px;margin-bottom:8px}
    .dataTables_filter input{height:38px;border:1px solid var(--line);border-radius:8px;padding:6px 10px}
    .dataTables_length select{height:38px!important;width:92px;border-radius:8px;border:1px solid var(--line)}
    .dataTables_paginate{float:right!important;margin-top:10px}
    .paginate_button{border:1px solid var(--line);border-radius:8px;padding:6px 10px;margin:2px;cursor:pointer;color:var(--ink)!important}
    .paginate_button:hover{background:var(--soft)!important;border-color:var(--line)!important}
    .dataTables_info{color:var(--muted);font-size:12px;padding-top:14px!important}
    a{text-decoration:none}
    @media (max-width: 900px){
      .history-head{align-items:flex-start;flex-direction:column}
      .head-actions{justify-content:flex-start}
      .stat-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
    }
    @media (max-width: 560px){
      .stat-grid{grid-template-columns:1fr}
    }
  </style>

  <div class="history-shell laos">
    <div class="history-head">
      <div>
        <h1 class="history-title">{{ $isHistory ? 'ປະຫວັດເອກະສານ' : 'ລາຍການເອກະສານມື້ນີ້' }}</h1>
        <p class="history-sub">{{ $com_name ?? '' }}</p>
      </div>
      <div class="head-actions">
        <a href="{{ route('Enter') }}" class="btn btn-soft btn-sm">ສ້າງໃໝ່</a>
        <a href="{{ route('EnterList') }}" class="btn btn-soft btn-sm">ມື້ນີ້</a>
        <a href="{{ route('EnterHistoryList') }}" class="btn btn-soft btn-sm">ປະຫວັດ</a>
      </div>
    </div>

    <div class="stat-grid">
      <div class="stat">
        <div class="stat-label">ກຳລັງດຳເນີນ</div>
        <div class="stat-value">{{ $activeCount }}</div>
      </div>
      <div class="stat">
        <div class="stat-label">Draft</div>
        <div class="stat-value">{{ $draftCount }}</div>
      </div>
      <div class="stat">
        <div class="stat-label">ຍົກເລີກ</div>
        <div class="stat-value">{{ $cancelCount }}</div>
      </div>
      <div class="stat">
        <div class="stat-label">Files</div>
        <div class="stat-value">{{ $fileCount }}</div>
      </div>
    </div>

    <section class="panel">
      <div class="panel-head">
        <h2 class="panel-title">{{ $isHistory ? 'ລາຍການທັງໝົດ' : 'ລາຍການປະຈຳມື້' }}</h2>
        <span class="muted">{{ $activeCount + $draftCount + $cancelCount }} ລາຍການ</span>
      </div>

      <div class="table-zone">
        @foreach ($user_list as $row_user)
          <div class="table-wrap">
            <table class="table table-bordered display w-100" id="table_user_{{ $row_user->id }}">
              <thead>
                <tr>
                  <th width="8%">ເລກທີ</th>
                  <th width="16%">ສະຖານະ</th>
                  <th width="16%">ວັນທີ</th>
                  <th>ປາຍທາງ</th>
                  <th width="18%">ຈັດການ</th>
                  <th width="12%">Files</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($beta_enter_draft as $row_enter)
                  @if($row_enter->user_id==$row_user->id)
                    @php
                      $meta = $statusMap['DRAFT'];
                      $files = $fileGroups->get($row_enter->enter_id, collect());
                    @endphp
                    <tr>
                      <td><span class="doc-number">{{ $row_enter->enter_number }}</span></td>
                      <td>
                        <span class="status-chip status-{{ $meta[0] }}">{{ $meta[1] }}</span>
                        <div class="muted mt-1">{{ $row_enter->status }}</div>
                      </td>
                      <td>
                        <div>{{ date('d-m-Y',strtotime($row_enter->date_in)) }}</div>
                        <div class="muted">{{ date('d-m-Y',strtotime($row_enter->date_out)) }}</div>
                      </td>
                      <td>
                        <div>{{ $row_enter->address }}, {{ $row_enter->district }}, {{ $row_enter->province }}</div>
                        <div class="muted">{{ $row_enter->lasttails }}</div>
                      </td>
                      <td>
                        <div class="action-stack">
                          <button class="btn btn-outline-dark btn-sm send" id="{{ $row_enter->enter_id }}">ສົ່ງເອກະສານ</button>
                          <a href="{{ url('/enter/update/'.$row_enter->enter_id) }}" class="btn btn-outline-danger btn-sm">ແກ້ໄຂ</a>
                          <button class="btn btn-outline-danger btn-sm delete" data-id="{{ $row_enter->enter_id }}">ລຶບ</button>
                        </div>
                      </td>
                      <td>
                        <div class="file-stack">
                          @forelse ($files as $row_file)
                            <a class="file-link" href="{{ route('download-file', ['file' => $row_file->file_id]) }}" target="_BLANK">File</a>
                          @empty
                            <span class="muted">-</span>
                          @endforelse
                        </div>
                      </td>
                    </tr>
                  @endif
                @endforeach

                @foreach ($beta_enter as $row_enter)
                  @if($row_enter->user_id==$row_user->id)
                    @php
                      $meta = $statusMap[$row_enter->status] ?? ['wait', $row_enter->status ?: '-'];
                      $files = $fileGroups->get($row_enter->enter_id, collect());
                    @endphp
                    <tr>
                      <td><span class="doc-number">{{ $row_enter->enter_number }}</span></td>
                      <td>
                        <span class="status-chip status-{{ $meta[0] }}">{{ $meta[1] }}</span>
                        <div class="muted mt-1">{{ $row_enter->status }}</div>
                      </td>
                      <td>
                        <div>{{ date('d-m-Y',strtotime($row_enter->date_in)) }}</div>
                        <div class="muted">{{ date('d-m-Y',strtotime($row_enter->date_out)) }}</div>
                      </td>
                      <td>
                        <div>{{ $row_enter->address }}, {{ $row_enter->district }}, {{ $row_enter->province }}</div>
                        <div class="muted">{{ $row_enter->lasttails }}</div>
                      </td>
                      <td>
                        <div class="action-stack">
                          <a href="{{ url('/enter/list/view/'.$row_enter->enter_id) }}" class="btn btn-outline-dark btn-sm">ເບິ່ງຂໍ້ມູນ</a>
                          @if($row_enter->status=='WAITING')
                            <button class="btn btn-outline-danger btn-sm cancel" id="{{ $row_enter->enter_id }}">ຍົກເລີກ</button>
                          @endif
                        </div>
                      </td>
                      <td>
                        <div class="file-stack">
                          @forelse ($files as $row_file)
                            <a class="file-link" href="{{ route('download-file', ['file' => $row_file->file_id]) }}" target="_BLANK">File</a>
                          @empty
                            <span class="muted">-</span>
                          @endforelse
                        </div>
                      </td>
                    </tr>
                  @endif
                @endforeach

                @foreach ($beta_enter_cancel as $row_enter)
                  @if($row_enter->user_id==$row_user->id)
                    @php
                      $meta = $statusMap['CANCEL'];
                      $files = $cancelFileGroups->get($row_enter->enter_id, collect());
                    @endphp
                    <tr>
                      <td><span class="doc-number">{{ $row_enter->enter_number }}</span></td>
                      <td>
                        <span class="status-chip status-{{ $meta[0] }}">{{ $meta[1] }}</span>
                        <div class="muted mt-1">{{ $row_enter->status }}</div>
                      </td>
                      <td>
                        <div>{{ date('d-m-Y',strtotime($row_enter->date_in)) }}</div>
                        <div class="muted">{{ date('d-m-Y',strtotime($row_enter->date_out)) }}</div>
                      </td>
                      <td>
                        <div>{{ $row_enter->address }}, {{ $row_enter->district }}, {{ $row_enter->province }}</div>
                        <div class="muted">{{ $row_enter->cancel_log }}</div>
                      </td>
                      <td>
                        <div class="action-stack">
                          <a href="{{ url('/enter/update/'.$row_enter->enter_id) }}" class="btn btn-outline-danger btn-sm">ແກ້ໄຂ</a>
                          <button class="btn btn-outline-danger btn-sm delete" data-id="{{ $row_enter->enter_id }}">ລຶບ</button>
                        </div>
                      </td>
                      <td>
                        <div class="file-stack">
                          @forelse ($files as $row_file)
                            <a class="file-link" href="{{ route('download-file', ['file' => $row_file->file_id]) }}" target="_BLANK">File</a>
                          @empty
                            <span class="muted">-</span>
                          @endforelse
                        </div>
                      </td>
                    </tr>
                  @endif
                @endforeach
              </tbody>
            </table>
          </div>
        @endforeach

        @if(($activeCount + $draftCount + $cancelCount) === 0)
          <div class="empty-note">ບໍ່ມີຂໍ້ມູນ</div>
        @endif
      </div>
    </section>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      @foreach ($user_list as $row_user)
        $('#table_user_{{ $row_user->id }}').DataTable({
          responsive: true,
          autoWidth: false,
          ordering: false,
          pageLength: 25,
          language: {
            search: "",
            lengthMenu: "_MENU_",
            searchPlaceholder: "ຄົ້ນຫາ",
            paginate: { first: "ທຳອິດ", last: "ສຸດທ້າຍ", next: "ຕໍ່ໄປ", previous: "ກັບຄືນ" },
            info: "_START_ - _END_ / _TOTAL_"
          }
        });
      @endforeach

      $(document).on('click','.cancel', function (e) {
        e.preventDefault();
        $.ajaxSetup({ headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
          type:"post",
          url:"/enter/cancel",
          data:{ id: $(this).attr('id') },
          dataType:"json",
          success:function(){ window.location.reload(); }
        });
      });

      $(document).on('click','.delete', function (e) {
        e.preventDefault();
        if(!confirm('ຢືນຢັນການລຶບ?')) return;
        $.ajaxSetup({ headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
          type:"post",
          url:"/enter/delete",
          data:{ id: $(this).attr('data-id') },
          dataType:"json",
          success:function(){ window.location.reload(); }
        });
      });

      $(document).on('click','.send', function (e) {
        e.preventDefault();
        $.ajaxSetup({ headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
          type:"post",
          url:"/enter/send",
          data:{ id: $(this).attr('id') },
          dataType:"json",
          success:function(){ window.location.reload(); }
        });
      });
    });
  </script>
</x-app-layout>
