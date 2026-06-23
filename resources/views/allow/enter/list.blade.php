<x-app-layout>
  <style>
    :root{
      --ink:#0f172a; --sub:#475569; --line:#e2e8f0; --soft:#f8fafc; --brand:#0a4e9b; --ok:#16a34a; --warn:#fb923c; --err:#dc2626;
    }
    .wrap{padding-block:6px}
    .card{background:#fff;border:1px solid var(--line);border-radius:14px;box-shadow:0 6px 18px rgba(2,8,23,.06)}
    .card-hdr{padding:12px 16px;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;background:linear-gradient(180deg,#fff,#fbfdff)}
    .title{font-weight:800;font-size:18px}
    .hint{font-size:12px;color:var(--sub)}
    .section{padding:10px 14px}
    .table_display_data{overflow-x:auto;white-space:nowrap}
    table thead th{font-weight:700!important;background:var(--soft)!important;border-bottom:1px solid var(--line)!important}
    table tbody td{background:#fff!important;font-size:14px}
    .btn{border-radius:10px}
    .btn-outline-dark:hover{background:#fff!important}
    .btn-info{background:#0d6efd;color:#fff;border:none}
    .btn-info:hover{opacity:.95}
    .status{display:inline-flex;align-items:center;gap:6px;padding:4px 10px;border-radius:999px;font-size:12px;font-weight:700}
    .st-wait{background:#e0ecff;color:#0a4e9b}
    .st-proc{background:#fff3e6;color:#a14e00}
    .st-ok{background:#eaf8ef;color:#166534}
    .st-bad{background:#fde7e7;color:#991b1b}
    .badge{border-radius:999px;padding:4px 10px;font-size:12px;font-weight:700}
    .badge-danger{background:#fde7e7;color:#991b1b}
    /* DataTables tweaks */
    .dataTables_filter,.dataTables_length{float:right!important;margin-left:8px}
    .dataTables_length select{height:40px!important;width:100px;border-radius:8px;border:1px solid var(--line)}
    .dataTables_paginate{float:right!important}
    .paginate_button{border:1px solid var(--line);border-radius:8px;padding:6px 10px;margin:2px;cursor:pointer;color:var(--ink)}
    .paginate_button:hover{background:var(--soft)}
    a{text-decoration:none}
  </style>

  <div class="wrap laos">
    <div class="max-w-12xl mx-auto sm:px-12 lg:px-12">
      <div class="card overflow-hidden">
        <div class="card-hdr">
          <!-- <div class="title">ລາຍການຄຳຮ້ອງ & ເອກະສານຂອງຜູ້ໃຊ້</div> -->
          <!-- <span class="hint">ຄົ້ນຫາ, ຈັດການ draft/ຍົກເລີກ, ແລະດາວໂຫຼດໄຟລ໌</span> -->
        </div>

        <div class="section">
          <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-1">
            @foreach ($user_list as $row_user)
              <div class="mb-5">
                <div class="table_display_data">
                  {{-- timer / reload controls (hidden but kept) --}}
                  <table style="display:none;">
                    <tr>
                      <td><input type="text" id="timer" value="20" class="form-control" style="width:60px"></td>
                      <td style="padding-left:8px">
                        <input type="checkbox" id="autoReloadCheckbox">
                        <label for="autoReloadCheckbox">No-Reload</label>
                      </td>
                    </tr>
                  </table>

                  {{-- User block header --}}
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <!-- <div class="fw-bold" style="font-size:16px">
                      👤 {{ $row_user->name ?? ('User #'.$row_user->id) }}
                    </div>
                    <div class="hint">ID: {{ $row_user->id }}</div> -->
                  </div>

                  <table class="table table-bordered display w-100" id="table_user_{{ $row_user->id }}">
                    <thead>
                      <tr>
                        <th width="7%">ເລກທີ</th>
                        <th width="16%">ສະຖານະ</th>
                        <th width="14%">ລົດເຂົ້າອອກ</th>
                        <th>ປາຍທາງ</th>
                        <th width="14%">ເບິ່ງລາຍລະອຽດ</th>
                        <th width="8%"></th>
                        <th width="8%">Files</th>
                      </tr>
                    </thead>
                    <tbody>
                      {{-- CANCELED --}}
                      @foreach ($beta_enter_cancel as $row_enter)
                        @if($row_enter->user_id==$row_user->id)
                          <tr>
                            <td>{{ $row_enter->enter_number }}</td>
                            <td>
                              <div class="status st-bad">ຍົກເລີກ</div>
                              <div class="small text-muted mt-1">{{ date('d-m-Y',strtotime($row_enter->date_in)) }} – {{ date('d-m-Y',strtotime($row_enter->date_out)) }}</div>
                            </td>
                            <td>
                              {{ $row_enter->address }}, {{ $row_enter->district }}, {{ $row_enter->province }}<br>
                              <span class="text-muted">{{ $row_enter->lasttails }}</span>
                            </td>
                            <td>
                              <span class="badge badge-danger">ເອກະສານຖືກຍົກເລີກ</span><br>
                              <span class="text-muted">ສາເຫດ: {{ $row_enter->cancel_log }}</span>
                            </td>
                            <td>
                              <a href="{{ url('/enter/update/'.$row_enter->enter_id) }}" class="btn btn-outline-danger btn-sm">ແກ້ໄຂ</a>
                            </td>
                            <td>
                              <button class="btn btn-outline-danger btn-sm delete" data-id="{{ $row_enter->enter_id }}">ລຶບ</button>
                            </td>
                            <td>
                              @foreach ($beta_enter_file_cancel as $row_file)
                                @if($row_file->enter_id==$row_enter->enter_id)
                                  <a href="{{ route('download-file', ['file' => $row_file->file_id]) }}" target="_BLANK" title="Download">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                         stroke-width="2" viewBox="0 0 24 24" class="w-8 h-5 text-gray-400">
                                      <path d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                  </a>
                                @endif
                              @endforeach
                            </td>
                          </tr>
                        @endif
                      @endforeach

                      {{-- DRAFT --}}
                      @foreach ($beta_enter_draft as $row_enter)
                        @if($row_enter->user_id==$row_user->id)
                          <tr>
                            <td>{{ $row_enter->enter_number }}</td>
                            <td>
                              <div class="status st-wait">Draft</div>
                              <div class="small text-muted mt-1">{{ date('d-m-Y',strtotime($row_enter->date_in)) }} – {{ date('d-m-Y',strtotime($row_enter->date_out)) }}</div>
                            </td>
                            <td>
                              {{ $row_enter->address }}, {{ $row_enter->district }}, {{ $row_enter->province }}<br>
                              <span class="text-muted">{{ $row_enter->lasttails }}</span>
                            </td>
                            <td><span class="hint">ກົດ “ສົ່ງເອກະສານ” ເພື່ອສົ່ງຂໍ້ມູນ</span></td>
                            <td class="d-flex gap-2" style="gap:6px">
                              <button class="btn btn-outline-dark btn-sm send" id="{{ $row_enter->enter_id }}">ສົ່ງເອກະສານ</button>
                              <a href="{{ url('/enter/update/'.$row_enter->enter_id) }}" class="btn btn-outline-danger btn-sm">ແກ້ໄຂ</a>
                            </td>
                            <td>
                              <button class="btn btn-outline-danger btn-sm delete" data-id="{{ $row_enter->enter_id }}">ລຶບ</button>
                            </td>
                            <td>
                              @foreach ($beta_enter_file as $row_file)
                                @if($row_file->enter_id==$row_enter->enter_id)
                                  <a href="{{ route('download-file', ['file' => $row_file->file_id]) }}" target="_BLANK" title="Download">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                         stroke-width="2" viewBox="0 0 24 24" class="w-8 h-5 text-gray-400">
                                      <path d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                  </a>
                                @endif
                              @endforeach
                            </td>
                          </tr>
                        @endif
                      @endforeach

                      {{-- ACTIVE / OTHERS --}}
                      @foreach ($beta_enter as $row_enter)
                        @if($row_enter->user_id==$row_user->id)
                          <tr>
                            <td>{{ $row_enter->enter_number }}</td>
                            <td>
                              @php
                                $map = [
                                  'WAITING'=>'st-wait|ກຳລັງລໍຖ້າ',
                                  'QWAIT'=>'st-wait|ກຳລັງລໍຖ້າ',
                                  'POINTING'=>'st-proc|ກຳລັງລະບຸສາຍທາງ',
                                  'SIGNING'=>'st-proc|ກຳລັງດຳເນີນການ',
                                  'QSIGNING'=>'st-proc|ກຳລັງດຳເນີນການ',
                                  'SIGNINED'=>'st-proc|ກຳລັງດຳເນີນການ',
                                  'READY'=>'st-proc|ກຳລັງດຳເນີນການ',
                                  'SUCCESS'=>'st-ok|ສຳເລັດ',
                                  'CANCEL'=>'st-bad|ຍົກເລີກ'
                                ];
                                [$klass,$text] = explode('|', $map[$row_enter->status] ?? 'st-wait|–');
                              @endphp
                              <div class="status {{ $klass }}">{{ $text }}</div>
                              <div class="small text-muted mt-1">{{ date('d-m-Y',strtotime($row_enter->date_in)) }} – {{ date('d-m-Y',strtotime($row_enter->date_out)) }}</div>
                            </td>
                            <td>
                              {{ date('d-m-Y',strtotime($row_enter->date_in)) }}<br>{{ date('d-m-Y',strtotime($row_enter->date_out)) }}
                            </td>
                            <td>
                              {{ $row_enter->address }}, {{ $row_enter->district }}, {{ $row_enter->province }}
                              <br><span class="text-muted">{{ $row_enter->lasttails }}</span>
                            </td>
                            <td>
                              <a href="{{ url('/enter/list/view/'.$row_enter->enter_id) }}" class="btn btn-outline-dark btn-sm">ເບິ່ງຂໍ້ມູນ</a>
                            </td>
                            <td>
                              .
                              @if($row_enter->status=='WAITING')
                                <button class="btn btn-outline-danger btn-sm cancel" id="{{ $row_enter->enter_id }}">ຍົກເລີກ</button>
                              @endif
                            </td>
                            <td>
                              @foreach ($beta_enter_file as $row_file)
                                @if($row_file->enter_id==$row_enter->enter_id)
                                  <a href="{{ route('download-file', ['file' => $row_file->file_id]) }}" target="_BLANK" title="Download">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                         stroke-width="2" viewBox="0 0 24 24" class="w-8 h-5 text-gray-400">
                                      <path d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                  </a>
                                @endif
                              @endforeach
                            </td>
                          </tr>
                        @endif
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            @endforeach
          </div>
        </div>

      </div>
    </div>
  </div>

  {{-- scripts --}}
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      @foreach ($user_list as $row_user)
        $('#table_user_{{ $row_user->id }}').DataTable({
          responsive: true,
          autoWidth: false,
          ordering: false,
          language: {
            search: "",
            lengthMenu: "_MENU_",
            searchPlaceholder: "ຄົ້ນຫາ",
            paginate: { first: "ທຳອິດ", last: "ສຸດທ້າຍ", next: "ຕໍ່ໄປ", previous: "ກັບຄືນ" },
            info: ""
          }
        });
      @endforeach

      // CANCEL
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

      // DELETE
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

      // SEND (draft -> submit)
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
