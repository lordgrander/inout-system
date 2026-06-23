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
    .k{font-size:12px;color:var(--sub);margin-bottom:6px}
    .table_display_data{overflow-x:auto;white-space:nowrap}
    .table thead th{background:var(--soft);border-bottom:1px solid var(--line)}
    .table td,.table th{vertical-align:middle}
    .btn-outline-success{border-radius:10px}
    .btn-outline-danger{border-radius:10px}
    .action-link{cursor:pointer;font-weight:700}
    .action-link:hover{text-decoration:underline}

    /* modal / toast */
    #modal{display:none;position:fixed;z-index:1000;inset:0;background:rgba(0,0,0,.35)}
    #modal-content{background:#fff;border:2px solid #1c73ff;border-radius:12px;width:min(520px,90%);margin:15% auto;padding:18px}
    .display_msg{margin:0;font-size:15px}

    .badge-pill{border-radius:999px;padding:6px 10px;font-weight:800;font-size:12px;display:inline-block}
    .b-wait{background:#fff7ed;border:1px solid #fed7aa;color:#9a3412}
    .b-success{background:#ecfdf5;border:1px solid #a7f3d0;color:#065f46}
    .b-cancel{background:#fef2f2;border:1px solid #fecaca;color:#991b1b}

    .file-pill{display:inline-flex;align-items:center;gap:8px;border:1px solid var(--line);background:var(--soft);
      border-radius:999px;padding:5px 10px;margin:4px 6px 0 0;font-size:12px;text-decoration:none;color:var(--ink)}
    .file-pill:hover{box-shadow:0 4px 12px rgba(2,8,23,.08)}
    .file-dot{width:8px;height:8px;border-radius:50%;background:var(--brand);display:inline-block}
    .muted{color:var(--sub);font-size:12px}
  </style>
<style>
  .murphy-swal-popup{ border-radius:14px!important; overflow:hidden!important; }
  .murphy-preview-shell{ background:#fff; }
  .murphy-pdf-shell{
    height:70vh; overflow:auto; background:#0b1220;
    border-top:1px solid #e2e8f0;
    cursor: grab;
  }
  .murphy-panning{ cursor: grabbing; }
  .murphy-pdf-toolbar{
    display:flex; gap:8px; align-items:center;
    padding:10px; background:#f8fafc; border-bottom:1px solid #e2e8f0;
    position:sticky; top:0; z-index:2;
  }
  .murphy-pdf-btn{
    border:1px solid #cbd5e1; background:#fff; border-radius:10px;
    padding:6px 10px; font-weight:800; font-size:12px;
  }
  .murphy-pdf-meta{ font-size:12px; color:#475569; margin-left:auto; margin-right:6px; }
  .murphy-preview-img{ max-width:100%; height:auto; display:block; }
</style>
  {{-- modal / toast --}}
  <div id="modal">
    <div id="modal-content">
      <p class="laob display_msg"></p>
    </div>
  </div>

  <div class="py-3 laos">
    <div class="max-w-12 mx-auto sm:px-6 lg:px-12">

      <div class="card-elev bg-white overflow-hidden sm:rounded-lg mb-3">
        <div class="card-hdr"> 
          <div class="gap-3 g-5 d-flex justift-content-between"> 
            <div><a class="btn btn-light "   href="{{ route('see_insurance_tell',['WAITING']) }}">ກຳລັງເຮັດວຽກ</a></div>
            <div><a class="btn btn-light "   href="{{ route('see_insurance_tell',['CHECKING']) }}">ກຳລັງກວດສອບ</a></div>
            <div><a class="btn btn-light "   href="{{ route('see_insurance_tell',['SUCCESS']) }}">ລາຍການສຳເລັດ</a></div>
            <div><a class="btn btn-light "   href="{{ route('see_insurance_tell',['ALL']) }}">ລາຍການທັງໝົດ</a></div>
            <div><a class="btn btn-light "   href="{{ route('see_insurance_tell',['CANCELLED']) }}">ຍົກເລີກ</a></div>
          </div>
        </div>

        <div class="p-3">
          <div class="table_display_data">
            <table class="table table-bordered table-hover align-middle mb-0 table-striped">
              <thead>
                <tr>
                  <th style="width:60px" class="text-center" style="width:5px;">#</th>
                  <th class="text-center">ບໍລິສັດ</th>
                  <th class="text-center">ປະເພດລົດ</th>
                  <th class="text-center">ປ້າຍທະບຽນ</th>
                  <th class="text-center">ວັນທີລົດເຂົ້າ</th>
                  <th class="text-center">ເລກທີ່ສັນຍາປະກັນ</th>
                  <th class="text-center" width="2%">Files</th>
                  <th class="text-center">ສະຖານະ</th>
                  <th>ຄຳເຫັນ</th>
                  <th width="2%" class="text-center" >ຈັດການ</th>
                  
                </tr>
              </thead>
              <tbody>
                @forelse($beta_tell_car_insurance as $r)
                  @php
                    $status = strtoupper($r->status ?? 'WAITING');

  if ($status === 'SUCCESS') {
      $badgeClass = 'text-success';
  } elseif ($status === 'CANCELLED') {
      $badgeClass = 'text-cancel';
  } else {
      $badgeClass = 'text-wait';
  }
                    // file_upload may be JSON string of paths
                    $files = [];
                    if(!empty($r->file_upload)){
                      $tmp = json_decode($r->file_upload, true);
                      if(is_array($tmp)) $files = $tmp;
                      else $files = [$r->file_upload]; // fallback
                    }
                  @endphp

                  <tr id="row_{{ $r->id }}">
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>
                      <div style="font-weight:800">{{ $r->com_name }}</div> 
                    </td>
                    <td>{{ $r->t_type_name }} 
                    </td>
                    <td style="font-weight:900" class="text-center">
                      {{ $r->plate_number }}</td>
                      <td class="text-center">
                        <p>{{ date('d-m-Y',strtotime($r->date_in)) }}</p>
                      </td>
                      <td class="text-center"> 
                        {{$r->insurance_extra_number}}
                      </td>

                  <td style="min-width:280px">
  @if(count($files))
    @foreach($files as $path)
      @php
        $url  = \Illuminate\Support\Str::startsWith($path, ['http://','https://'])
          ? $path
          : asset($path);

        $name = basename($path);
      @endphp

      <a
        href="{{ $url }}"
        class="file-pill murphy-file-link"
        data-url="{{ $url }}"
        data-name="{{ $name }}"
      >  
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" class="eva eva-attach-2-outline eva-animation eva-icon-hover-zoom" fill="inherit"><g data-name="Layer 2"><g data-name="attach-2"><rect width="24" height="24" opacity="0"></rect><path d="M12 22a5.86 5.86 0 0 1-6-5.7V6.13A4.24 4.24 0 0 1 10.33 2a4.24 4.24 0 0 1 4.34 4.13v10.18a2.67 2.67 0 0 1-5.33 0V6.92a1 1 0 0 1 1-1 1 1 0 0 1 1 1v9.39a.67.67 0 0 0 1.33 0V6.13A2.25 2.25 0 0 0 10.33 4 2.25 2.25 0 0 0 8 6.13V16.3a3.86 3.86 0 0 0 4 3.7 3.86 3.86 0 0 0 4-3.7V6.13a1 1 0 1 1 2 0V16.3a5.86 5.86 0 0 1-6 5.7z"></path></g></g></svg>
        
      </a> 
    @endforeach
  @else
    <span class="muted"> </span>
  @endif
</td>

                    <td class="text-center">
                      <span class="badge-pill {{ $badgeClass }}" id="status_{{ $r->id }}">

                       @if($r->status=='SUCCESS')
                        <div style="color:#1a6f00;" class="d-flex justify-content-center">
                            <div style="padding-top:0px;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="eva eva-checkmark-circle-2-outline" fill="inherit" style="fill: #1a6f00;"><g data-name="Layer 2"><g data-name="checkmark-circle-2"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M14.7 8.39l-3.78 5-1.63-2.11a1 1 0 0 0-1.58 1.23l2.43 3.11a1 1 0 0 0 .79.38 1 1 0 0 0 .79-.39l4.57-6a1 1 0 1 0-1.6-1.22z"></path></g></g></svg></div>
                      
                            <div>&nbsp;ຮອງຮັບແລ້ວ</div> 
                        </div>
                       @elseif($r->status=='CANCELLED')
                          <div style="color:red;">ຍົກເລີກ</div>
                          ສາເຫດ : {{ $r->cancel_reason }}
                       @elseif($r->status=='CHECKING') 
                         <div style="color:blue;" class="d-flex justify-content-center">
                            <div style="padding-top:0px;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="eva eva-layers-outline" fill="inherit" style="fill: blue;"><g data-name="Layer 2"><g data-name="layers"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"></rect><path d="M21 11.35a1 1 0 0 0-.61-.86l-2.15-.92 2.26-1.3a1 1 0 0 0 .5-.92 1 1 0 0 0-.61-.86l-8-3.41a1 1 0 0 0-.78 0l-8 3.41a1 1 0 0 0-.61.86 1 1 0 0 0 .5.92l2.26 1.3-2.15.92a1 1 0 0 0-.61.86 1 1 0 0 0 .5.92l2.26 1.3-2.15.92a1 1 0 0 0-.61.86 1 1 0 0 0 .5.92l8 4.6a1 1 0 0 0 1 0l8-4.6a1 1 0 0 0 .5-.92 1 1 0 0 0-.61-.86l-2.15-.92 2.26-1.3a1 1 0 0 0 .5-.92zm-9-6.26l5.76 2.45L12 10.85 6.24 7.54zm-.5 7.78a1 1 0 0 0 1 0l3.57-2 1.69.72L12 14.85l-5.76-3.31 1.69-.72zm6.26 2.67L12 18.85l-5.76-3.31 1.69-.72 3.57 2.05a1 1 0 0 0 1 0l3.57-2.05z"></path></g></g></svg></div>
                            <div style="color:blue;">&nbsp;ກຳລັງຮອງຮັບ</div>
                          </div>
                       @else
                        <div style="color:black;" class="d-flex justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="eva eva-clock-outline" fill="inherit"><g data-name="Layer 2"><g data-name="clock"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M16 11h-3V8a1 1 0 0 0-2 0v4a1 1 0 0 0 1 1h4a1 1 0 0 0 0-2z"></path></g></g></svg>  
                        &nbsp;ກຳລັງເຮັດວຽກ</div>
                       @endif
                      </span>
                      
                    </td> 
                    <td style="min-width:420px">
                      {{-- hidden input that will be sent --}}
                      <input type="hidden"
                            class="richtxt_txt"
                            id="remark_{{ $r->id }}"
                            data-id="{{ $r->id }}"
                            value="{{ e($r->remark ?? '') }}">

                      {{-- quill editor container --}}
                      <div class="quill-box"
                          id="quill_{{ $r->id }}"
                          data-id="{{ $r->id }}"
                          data-value="{!! e($r->remark ?? '') !!}"
                          style="background:#fff;border:1px solid #e2e8f0;border-radius:10px;">
                      </div>
                    
                    </td>
                    <td class="text-center">
                      @if($status==='CANCELLED' )
                        <div class="muted">
                          @if(!empty($r->cancel_reason))
                            <div class="muted mt-1" style="max-width:220px;white-space:normal">
                              {{ $r->cancel_reason }}
                            </div>
                          @endif
                        </div>
                      @else
                        @if($status=='WAITING')
                        <button
                          class="btn btn-sm btn-primary btnChecking"
                          style="border-radius:4px;"
                          data-id="{{ $r->id }}" 
                        >
                          ກວດສອບ
                        </button> 

                        
                        <button
                          class="btn btn-sm btn-danger btnCancel"
                          style="border-radius:4px;"
                          data-id="{{ $r->id }}" 
                        >
                          ຍົກເລີກ
                        </button>
                        @endif

                        
                        @if($status=='CHECKING')
                        <button
                          class="btn btn-sm btn-success btnSuccess"
                          style="border-radius:4px;"
                          data-id="{{ $r->id }}" 
                        >
                          ຍອມຮັບ
                        </button> 

                        
                        <button
                          class="btn btn-sm btn-dark btnWaiting"
                          style="border-radius:4px;"
                          data-id="{{ $r->id }}"
                           
                        >
                          ຕີກັບ
                        </button>
                        @endif 
                      @endif

                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center muted py-4">No data</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div> 
            <div>
              <div class="mt-3">
                  {{ $beta_tell_car_insurance->links() }}
              </div>
            </div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>


  <script>

    const QUILL_INSTANCES = {};
const SAVE_TIMER = {};

function initQuills(){
  document.querySelectorAll('.quill-box').forEach(function(box){
    const rid = box.dataset.id;
    if(!rid) return;
    if(QUILL_INSTANCES[rid]) return; // already init

    const q = new Quill('#quill_'+rid, {
      theme: 'snow',
      placeholder: ' ',
      modules: {
        toolbar: [
          [{ header: [1, 2, 3, false] }],
          ['bold', 'italic', 'underline', 'strike'],
          [{ 'list': 'ordered'}, { 'list': 'bullet' }],
          ['blockquote', 'code-block'],
          ['link'],
          ['clean']
        ]
      }
    });

    // preload HTML
    const html = (box.dataset.value || '');
    if(html.trim()){
      q.clipboard.dangerouslyPasteHTML(html);
    }

    QUILL_INSTANCES[rid] = q;

    // on text change -> set hidden input -> trigger change (debounced)
    q.on('text-change', function(){
      clearTimeout(SAVE_TIMER[rid]);
      SAVE_TIMER[rid] = setTimeout(function(){
        const valHtml = q.root.innerHTML; // save HTML
        const $hidden = $('#remark_'+rid);
        $hidden.val(valHtml).trigger('change'); // will hit your ajax handler
      }, 700); // stop typing 0.7s then save
    });
  });
}

$(document).ready(function(){
  initQuills();
});

$(document).on('change', '.richtxt_txt', function(){
  const id = $(this).data('id');
  const remark = $(this).val();

  $.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
  });

  $.post("{{ route('tellcarinsurance.remark.update') }}", {
    id: id,
    remark: remark
  }).done(function(res){
    // optional toast
    // console.log('saved', res);
  }).fail(function(xhr){
    alert('Save failed');
  });
});

    function showMsg(text){
      $('.display_msg').text(text);
      $('#modal').fadeIn(120);
      setTimeout(()=>$('#modal').fadeOut(150), 1700);
    }

    function lockRow(id, yes=true){
      const $row = $('#row_'+id);
      $row.css('opacity', yes ? 0.65 : 1);
      $row.find('button').prop('disabled', yes);
    }

    function setStatusPill(id, status){
      $('#status_'+id).text(status);
      const up = (status || '').toUpperCase();
      $('#status_'+id).removeClass('b-wait b-success b-cancel')
        .addClass(up === 'SUCCESS' ? 'b-success' : (up === 'CANCELLED' ? 'b-cancel' : 'b-wait'));
    }

    // SUCCESS
    $(document).on('click', '.btnSuccess', function(){
      const id = $(this).data('id');

      lockRow(id, true);

      $.ajax({
        url: "{{ url('/tell-car-insurance') }}/" + id + "/success",
        method: "POST",
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        success: function(res){
          if(res && res.ok){
            setStatusPill(id, 'SUCCESS');
            showMsg(res.msg || 'SUCCESS ✅');
          }else{
            showMsg('Something went sideways…');
            lockRow(id, false);
          }
        },
        error: function(xhr){
          const data = xhr.responseJSON || {};
          showMsg(data.msg || data.message || 'Server error');
          lockRow(id, false);
        }
      });
    });


     // CHECKING
    $(document).on('click', '.btnChecking', function(){
      const id = $(this).data('id');

      lockRow(id, true);

      $.ajax({
        url: "{{ url('/tell-car-insurance') }}/" + id + "/checking",
        method: "POST",
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        success: function(res){
          if(res && res.ok){
            setStatusPill(id, 'Checking');
            showMsg(res.msg || 'Checking ✅');
          }else{
            showMsg('Something went sideways…');
            lockRow(id, false);
          }
        },
        error: function(xhr){
          const data = xhr.responseJSON || {};
          showMsg(data.msg || data.message || 'Server error');
          lockRow(id, false);
        }
      });
    });
     // WAITING
    $(document).on('click', '.btnWaiting', function(){
      const id = $(this).data('id');

      lockRow(id, true);

      $.ajax({
        url: "{{ url('/tell-car-insurance') }}/" + id + "/waiting",
        method: "POST",
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        success: function(res){
          if(res && res.ok){
            setStatusPill(id, 'Waiting');
            showMsg(res.msg || 'Waiting ✅');
          }else{
            showMsg('Something went sideways…');
            lockRow(id, false);
          }
        },
        error: function(xhr){
          const data = xhr.responseJSON || {};
          showMsg(data.msg || data.message || 'Server error');
          lockRow(id, false);
        }
      });
    });

    // CANCEL with reason
    $(document).on('click', '.btnCancel', async function(){
      const id = $(this).data('id');

      const { value: reason } = await Swal.fire({
        title: '',
        text: 'ກະລຸນາພິມສາເຫດໃນການຍົກເລີກ',
        input: 'text',
        inputPlaceholder: 'ລະບຸສາເຫດ',
        inputAttributes: { maxlength: 255 },
        showCancelButton: true,
        confirmButtonText: 'ຍົກເລີກ',
        cancelButtonText: 'ປິດ',
        preConfirm: (v) => {
          v = (v || '').trim();
          if(!v) Swal.showValidationMessage('ກະລຸນາລະບຸສາເຫດ');
          return v;
        }
      });

      if(!reason) return;

      lockRow(id, true);

      $.ajax({
        url: "{{ url('/tell-car-insurance') }}/" + id + "/cancel",
        method: "POST",
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        data: { reason: reason },
        success: function(res){
          if(res && res.ok){
            setStatusPill(id, 'CANCELLED');
            showMsg(res.msg || 'ຍົກເລີກສຳເລັດ ❌');
          }else{
            showMsg('Cancel failed…');
            lockRow(id, false);
          }
        },
        error: function(xhr){
          const data = xhr.responseJSON || {};
          if(data.errors){
            const firstKey = Object.keys(data.errors)[0];
            showMsg(data.errors[firstKey]?.[0] || 'Validation error');
          }else{
            showMsg(data.msg || data.message || 'Server error');
          }
          lockRow(id, false);
        }
      });
    });

    // click outside to close toast modal
    $('#modal').on('click', function(e){
      if(e.target === this) $('#modal').fadeOut(120);
    });
  </script>


<script>
                    let checkedValues = [];

  function murphyGetExt(url){
    const clean = (url || '').split('?')[0].split('#')[0];
    return clean.slice(clean.lastIndexOf('.') + 1).toLowerCase();
  }

    function murphyBuildPreview(url){
        const ext = murphyGetExt(url);

        if(ext === 'pdf'){
            // use unique ids so multiple opens won't conflict
            const uid = 'murphyPdf_' + Math.random().toString(36).slice(2);

            return `
            <div class="murphy-preview-shell murphy-resizable" id="murphyPreviewBox">
                <div class="murphy-pdf-toolbar">
                <button class="murphy-pdf-btn" data-act="prev" data-uid="${uid}">◀</button>
                <button class="murphy-pdf-btn" data-act="next" data-uid="${uid}">▶</button>

                <button class="murphy-pdf-btn" data-act="zoomout" data-uid="${uid}">－</button>
                <button class="murphy-pdf-btn" data-act="zoomin" data-uid="${uid}">＋</button>

                <span class="murphy-pdf-meta" id="${uid}_meta">Page ? / ?</span>

                <a class="murphy-pdf-btn" href="${url}" target="_blank" rel="noopener">Open</a>
                </div>

                <div class="murphy-pdf-shell" id="${uid}_wrap">
                <canvas class="murphy-pdf-canvas" id="${uid}_canvas"></canvas>
                </div>

                <input type="hidden" id="${uid}_url" value="${url}">
            </div>
            `;
        }

        if(['png','jpg','jpeg','webp','gif'].includes(ext)){
            return `
            <div class="murphy-preview-shell murphy-resizable" id="murphyPreviewBox">
                <img class="murphy-preview-img" src="${url}" alt="preview">
            </div>`;
        }

        return `
            <div class="murphy-preview-shell murphy-resizable" id="murphyPreviewBox" style="display:flex;align-items:center;justify-content:center;padding:18px;">
            <div style="text-align:center;">
                <div style="margin-bottom:10px;">Preview not supported</div>
                <a class="btn btn-light" href="${url}" target="_blank" rel="noopener">Open file</a>
            </div>
            </div>`;
        }

    // Delegated click (works even if list updates)
    $(document).on('click', '.murphy-file-link', function(e){
        e.preventDefault();

        const url  = $(this).data('url') || $(this).attr('href');
        const name = $(this).data('name') || 'File Preview';

        Swal.fire({
        title: '',
        html: `<div style="font-size: 12px;">`+name + `</div>`+murphyBuildPreview(url),
        width: '92vw',
        padding: 0,
        showCloseButton: true,
        showConfirmButton: false,
        backdrop: true,
        customClass: {
            popup: 'murphy-swal-popup',
            title: 'murphy-swal-title'
        },
        didOpen: async () => {
  const $popup = $(Swal.getPopup());

  // On desktop only (mobile doesn't need drag/resize)
  if (window.matchMedia('(min-width: 992px)').matches) {
    $popup.draggable({ handle: '.swal2-title', containment: 'window' });
    $popup.resizable({ handles: 'se, s, e', minHeight: 320, minWidth: 320 });
  }

  // ✅ If this modal contains a PDF hidden url input, load it
  const $hidden = $popup.find('input[id$="_url"]');
  if ($hidden.length) {
    const uid = $hidden.attr('id').replace('_url', '');
    try {
      await murphyPdfLoad(uid);
    } catch (e) {
      console.log('PDF load error:', e);
    }
  }
}
        });
    });

    const murphyPdfState = {}; // uid => {pdf, page, scale}

async function murphyPdfLoad(uid){
  const url = document.getElementById(uid + '_url').value;
if (typeof pdfjsLib === 'undefined') {
  throw new Error('pdfjsLib not loaded. Check pdf.min.js include order.');
}
  // pdf.js worker (CDN safe)
  pdfjsLib.GlobalWorkerOptions.workerSrc =
    "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";

  const loadingTask = pdfjsLib.getDocument(url);
  const pdf = await loadingTask.promise;

  murphyPdfState[uid] = { pdf, page: 1, scale: 1.2 };

  await murphyPdfRender(uid);

  murphyEnablePan(uid);

}

async function murphyPdfRender(uid){
  const st = murphyPdfState[uid];
  if(!st) return;

  const page = await st.pdf.getPage(st.page);

  const canvas = document.getElementById(uid + '_canvas');
  const ctx = canvas.getContext('2d');

  const viewport = page.getViewport({ scale: st.scale });

  canvas.width = Math.floor(viewport.width);
  canvas.height = Math.floor(viewport.height);

  await page.render({ canvasContext: ctx, viewport }).promise;

  const meta = document.getElementById(uid + '_meta');
  if(meta) meta.textContent = `Page ${st.page} / ${st.pdf.numPages}`;
}

// toolbar actions
$(document).on('click', '.murphy-pdf-btn', async function(){
  const act = $(this).data('act');
  const uid = $(this).data('uid');
  const st = murphyPdfState[uid];
  if(!st) return;

  if(act === 'prev') st.page = Math.max(1, st.page - 1);
  if(act === 'next') st.page = Math.min(st.pdf.numPages, st.page + 1);
  if(act === 'zoomin') st.scale = Math.min(3, st.scale + 0.2);
  if(act === 'zoomout') st.scale = Math.max(0.6, st.scale - 0.2);

  await murphyPdfRender(uid);
});

    
    function murphyEnablePan(uid){
  const wrap = document.getElementById(uid + '_wrap');
  if(!wrap) return;

  let isDown = false;
  let startX = 0, startY = 0;
  let scrollLeft = 0, scrollTop = 0;

  // Mouse
  wrap.addEventListener('mousedown', (e) => {
    isDown = true;
    wrap.classList.add('murphy-panning');
    startX = e.pageX - wrap.offsetLeft;
    startY = e.pageY - wrap.offsetTop;
    scrollLeft = wrap.scrollLeft;
    scrollTop = wrap.scrollTop;
  });

  window.addEventListener('mouseup', () => {
    isDown = false;
    wrap.classList.remove('murphy-panning');
  });

  wrap.addEventListener('mousemove', (e) => {
    if(!isDown) return;
    e.preventDefault();
    const x = e.pageX - wrap.offsetLeft;
    const y = e.pageY - wrap.offsetTop;
    const walkX = (x - startX);
    const walkY = (y - startY);
    wrap.scrollLeft = scrollLeft - walkX;
    wrap.scrollTop  = scrollTop  - walkY;
  });

  // Touch (mobile)
  wrap.addEventListener('touchstart', (e) => {
    if(!e.touches || !e.touches[0]) return;
    isDown = true;
    const t = e.touches[0];
    startX = t.pageX - wrap.offsetLeft;
    startY = t.pageY - wrap.offsetTop;
    scrollLeft = wrap.scrollLeft;
    scrollTop = wrap.scrollTop;
  }, { passive: true });

  wrap.addEventListener('touchmove', (e) => {
    if(!isDown || !e.touches || !e.touches[0]) return;
    const t = e.touches[0];
    const x = t.pageX - wrap.offsetLeft;
    const y = t.pageY - wrap.offsetTop;
    const walkX = (x - startX);
    const walkY = (y - startY);
    wrap.scrollLeft = scrollLeft - walkX;
    wrap.scrollTop  = scrollTop  - walkY;
  }, { passive: true });

  wrap.addEventListener('touchend', () => { isDown = false; }, { passive: true });
}
</script>
</x-app-layout>
