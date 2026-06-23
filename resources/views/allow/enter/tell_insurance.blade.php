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
    .btn-outline-success{border-radius:10px}

    /* modal */
    #modal{display:none;position:fixed;z-index:1000;inset:0;background:rgba(0,0,0,.35)}
    #modal-content{background:#fff;border:2px solid #1c73ff;border-radius:12px;width:min(520px,90%);margin:15% auto;padding:18px}
    .display_msg{margin:0;font-size:15px}

    .mini{font-size:12px;color:var(--sub)}
    .is-invalid{border-color:#dc3545!important}
    .file-list{margin-top:8px}
    .file-pill{display:inline-block;border:1px solid var(--line);border-radius:999px;padding:4px 10px;margin:4px 6px 0 0;background:var(--soft);font-size:12px}
  </style>

  {{-- modal / toast --}}
  <div id="modal">
    <div id="modal-content">
      <p class="laob display_msg"></p>
    </div>
  </div>

  <div class="py-3 laos">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      <div class="card-elev bg-white overflow-hidden sm:rounded-lg mb-3">
        <div class="card-hdr">
          <div class="title">ຟອມແຈ້ງປະກັນໄພລົດ</div> 
        </div>

        <div class="p-3">
          <div class="row">
            <div class="col-md-6">
              <div class="k">ວັນທີລົດເຂົ້າ</div>
              <input type="date" class="form-control" id="date_in" placeholder="ວັນທີລົດເຂົ້າ">

              <div class="k mt-3">ເລກທີ່ສັນຍາປະກັນ</div>
              <input type="text" class="form-control" id="insurance_extra_number" placeholder=""> 
            </div>

            <div class="col-md-6">
              <div class="d-flex justify-content-between gap-3">
                    <div style="">
                      <div class="k">ປະເພດລົດ</div>
                      <select id="car_type_id" class="form-control">
                        <option value="">-- ເລືອກປະເພດລົດ --</option>
                        @foreach($beta_t_type as $r)
                          <option value="{{ $r->t_type_id }}">{{ $r->t_type_name }}</option>
                        @endforeach
                      </select> 
                    </div>
                    <div style="width:80%;">
                      <div class="k ">ທະບຽນລົດ</div>
                      <input type="text" class="form-control" id="plate_number" placeholder="ທະບຽນລົດ"> 
                    </div>
              </div>

              <div class="k mt-3">&nbsp;</div>
              <input type="file" class="form-control" id="file_upload" multiple>

              <div class="file-list k" id="file_list"> ເອກະສານ / ຮູບພາບ (ເລືອກໄດ້ຫຼາຍໄຟລ໌)</div>

              <div class="text-right mt-2"> 
                <button type="button" class="btn btn-outline-success" id="btnSave">
                  ແຈ້ງປະກັນໄພ
                </button>
              </div>
 
            </div>
          </div> 

        </div>
      </div>


      <div class="card-elev bg-white overflow-hidden sm:rounded-lg mb-3">
        <div class="card-hdr">
          <div class="title">ລາຍການແຈ້ງປະກັນລົດ</div> 
        </div>

        <div style="padding: 0rem 1rem 1rem 0rem !important;">
           
          <div class="row">
            <div class="col-md-12">
              <div style=" overflow-x: auto;"> 
                <table class="table table-bordered mt-4" style="width:1200px;"> 
                  <tr>
                    <th class="text-center" style="width:3%;">#</th>
                    <th class="text-center" style="width:15%;">ປ້າຍທະບຽນ</th>
                    <th class="text-center" style="width:20%;" colspan="" class="text-center">ລາຍການແຈ້ງປະກັນໄພລົດ</th>
                    <th class="text-center" style="width:40px;">ເລກທີ່ສັນຍາປະກັນ</th>
                    <th class="text-center" style="width:5%;">ວັນທີລົດເຂົ້າ</th>
                    <th class="text-center" style="width:20%;">ຄຳເຫັນ</th>
                    <th class="text-center" style="width:12%;">ສະຖານະ</th> 

                  </tr>
                  @php($count=1)
                  @foreach ($beta_tell_car_insurance as $r)
                    <tr >
                      <td class="text-center" style="width:40px;">
                        {{ $count++ }}
                      </td>
                        
                      <td class="text-center">{{ $r->plate_number }}</td>
                      <td class=" text-center"> 
                        {{ $r->t_type_name }} 
                      </td> 
                      <td class="text-center">{{ $r->insurance_extra_number }}</td>
                      <td class="text-center">{{ date('d/m/Y', strtotime($r->date_in)) }}</td> 
                    
                      <td>
                        <!-- {{ date('d-m-Y', strtotime($r->created_at))}} -->
                       {!! $r->remark !!}
                      </td>
                      <td class="text-center"> 
                        @if($r->status=='SUCCESS')
                          <div style="color:#00c314;" class="d-flex justify-content-center">
                              <div style="padding-top:2px;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="eva eva-checkmark-circle-2-outline" fill="inherit" style="fill: #00c314;"><g data-name="Layer 2"><g data-name="checkmark-circle-2"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M14.7 8.39l-3.78 5-1.63-2.11a1 1 0 0 0-1.58 1.23l2.43 3.11a1 1 0 0 0 .79.38 1 1 0 0 0 .79-.39l4.57-6a1 1 0 1 0-1.6-1.22z"></path></g></g></svg></div>
                        
                              <div>&nbsp;ຮອງຮັບແລ້ວ</div> 
                          </div>
                        @elseif($r->status=='CANCELLED')
                            <div style="color:red;">ຍົກເລີກ</div>
                            ສາເຫດ : {{ $r->cancel_reason }}
                        @else
                          <div style="color:black;" class="d-flex justify-content-center">
                          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="eva eva-clock-outline" fill="inherit"><g data-name="Layer 2"><g data-name="clock"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M16 11h-3V8a1 1 0 0 0-2 0v4a1 1 0 0 0 1 1h4a1 1 0 0 0 0-2z"></path></g></g></svg>  
                          &nbsp;ກຳລັງເຮັດວຽກ</div>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>


    </div>
  </div>

  {{-- jQuery --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
 <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    // ===== tiny toast modal =====
    function showMsg(text){
      $('.display_msg').text(text);
      $('#modal').fadeIn(120);
      setTimeout(()=>$('#modal').fadeOut(150), 1800);
    }

    function setInvalid($el, yes=true){
      $el.toggleClass('is-invalid', !!yes);
    }

    // show selected file names like candy pills
    $('#file_upload').on('change', function(){
      const box = $('#file_list');
      box.empty();
      const files = this.files || [];
      if(!files.length){
        box.html('<span class="mini">No files selected</span>');
        return;
      }
      for(const f of files){
        box.append(`<span class="file-pill">${f.name}</span>`);
      }
    });

    // ===== AJAX submit =====
    $('#btnSave').on('click', function(){
      const plate = ($('#plate_number').val() || '').trim();
      const extra = ($('#insurance_extra_number').val() || '').trim();
      const type  = ($('#car_type_id').val() || '').trim();

      setInvalid($('#plate_number'), !plate);
      setInvalid($('#car_type_id'), !type);
      setInvalid($('#insurance_extra_number'), !extra);

      if(!plate){  return showError('ກະລຸນາກອກ ທະບຽນລົດ'); }
      if(!type){    return showError('ກະລຸນາກອກ ປະເພດລົດ');}
      if(!extra){    return showError('ກະລຸນາກອກ ເລກທີ່ສັນຍາປະກັນ');}

      const fd = new FormData();
      fd.append('plate_number', plate);
      fd.append('insurance_extra_number', extra);
      fd.append('car_type_id', type);
      fd.append('date_in', $('#date_in').val());

       const fileEl        = document.getElementById('file_upload');
       const filex          = fileEl && fileEl.files && fileEl.files[0] ? fileEl.files[0] : null;
                if(!filex) return showError('ກະລຸນາແນບເອກະສານປະກັນ');

      const files = $('#file_upload')[0].files || [];
      for(let i=0;i<files.length;i++){
        fd.append('file_upload[]', files[i]);
      }

      $.ajax({
        url: "{{ route('tell_car_insurance.store') }}",
        method: "POST",
        data: fd,
        processData: false,
        contentType: false,
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        beforeSend: function(){
          $('#btnSave').prop('disabled', true).text('Saving...');
        },
        success: function(res){
          if(res && res.ok){
            showMsg('ແຈ້ງປະກັນສຳເລັດ');

            // reset form (fresh like a new morning)
            $('#plate_number').val('');
            $('#insurance_extra_number').val('');
            $('#car_type_id').val('');
            $('#file_upload').val('');
            $('#file_list').empty().html('<span class="mini">No files selected</span>');
          }else{
            showMsg('Something weird happened…');
          }
        },
        error: function(xhr){
          // Laravel validation errors
          const data = xhr.responseJSON || {};
          if(data.errors){
            const firstKey = Object.keys(data.errors)[0];
            const firstMsg = data.errors[firstKey][0] || 'Validation error';
            showMsg(firstMsg);
          }else{
            showMsg(data.message || 'Server error');
          }
        },
        complete: function(){
          $('#btnSave').prop('disabled', false).text('ບັນທຶກ');
        }
      });
    });

    // click outside to close modal
    $('#modal').on('click', function(e){
      if(e.target === this) $('#modal').fadeOut(120);
    });

     function showError(msg){
            Swal.fire({ icon:'error', title:' ', text: msg });
        }
  </script>
</x-app-layout>
