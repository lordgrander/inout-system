<x-app-layout>
          <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
     <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

<style>
    /* ================= Murphy Dark Theme ================= */
:root {
  --murphy-bg: #0e1116;
  --murphy-elev: #141a22;
  --murphy-surface: #192231;
  --murphy-border: #2b3647;
  --murphy-text: #e8ecf1;
  --murphy-muted: #9aa6b2;
  --murphy-accent: #6ea8fe;
  --murphy-accent-2: #8b9dff;
  --murphy-danger: #ff6b6b;
  --murphy-ok: #34d399;
  --murphy-radius-lg: 16px;
  --murphy-radius: 12px;
  --murphy-shadow: 0 10px 30px rgba(0,0,0,.35);
}

/* Scoped dark area so the rest of your site can stay light if needed */
.murphy_scope {
   color: var(--murphy-text);
}

/* Container */
.murphy_container {
  width: 100%;
  max-width: 980px;
  margin-inline: auto;
  padding: 16px;
}

/* Card */
.murphy_card {
  background: linear-gradient(180deg, var(--murphy-elev), var(--murphy-surface));
  border: 1px solid var(--murphy-border);
  border-radius: var(--murphy-radius-lg);
  box-shadow: var(--murphy-shadow);
  overflow: hidden;
}

.murphy_card__header {
  padding: 16px 18px;
  border-bottom: 1px solid var(--murphy-border);
  display: flex; align-items: center; justify-content: space-between;
}
.murphy_title {
  font-size: clamp(1.1rem, 1.4vw + .6rem, 1.35rem);
  font-weight: 700;
  letter-spacing: .2px;
  margin: 0;
}
.murphy_card__body { padding: 18px; }
.murphy_card__footer {
  padding: 14px 18px; border-top: 1px solid var(--murphy-border);
  display: flex; justify-content: flex-end; gap: 10px;
}

/* Field + inputs */
.murphy_field { margin-bottom: 14px; }
.murphy_label {
  display: block; margin-bottom: 6px; font-size: .95rem; color: var(--murphy-text);
}
.murphy_input, .murphy_select, .murphy_textarea {
  width: 100%;
  border-radius: 12px;
  border: 1px solid var(--murphy-border);
  background: #121826;
  color: var(--murphy-text);
  padding: 12px 14px;
  transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
}
.murphy_input::placeholder, .murphy_textarea::placeholder { color: var(--murphy-muted); }
.murphy_input:focus, .murphy_select:focus, .murphy_textarea:focus {
  border-color: var(--murphy-accent);
  box-shadow: 0 0 0 3px rgba(110,168,254,.18);
  outline: none;
}

.murphy_help { margin-top: 6px; font-size: .85rem; color: var(--murphy-muted); }
.murphy_invalid .murphy_input { border-color: var(--murphy-danger); box-shadow: 0 0 0 3px rgba(255,107,107,.16); }

/* Drag & drop zone */
.murphy_dropzone {
  position: relative;
  border: 1px dashed var(--murphy-border);
  background: #111622;
  border-radius: var(--murphy-radius);
  padding: 14px;
  display: grid; gap: 10px;
  transition: border-color .15s ease, background .15s ease;
}
.murphy_dropzone:hover { border-color: var(--murphy-accent-2); background: #121a29; }
.murphy_dropzone input[type="file"] { width: 100%; }
.murphy_dropzone--active { border-color: var(--murphy-accent); background: #152031; }

/* Badges */
.murphy_badge {
  display: inline-flex; align-items: center; gap: .5ch;
  font-size: .8rem; color: var(--murphy-text);
  border: 1px solid var(--murphy-border);
  border-radius: 4px; padding: 4px 10px; background: #0f1522;
}

/* Buttons */
.murphy_btn {
  display: inline-flex; align-items: center; gap: .6ch;
  padding: 10px 16px; border-radius: 4px; border: 1px solid var(--murphy-border);
  font-weight: 700; cursor: pointer; text-decoration: none;
  transition: transform .1s ease, filter .1s ease, box-shadow .12s ease;
}
.murphy_btn:active { transform: translateY(1px); }

.murphy_btn--primary {
  background: linear-gradient(180deg, var(--murphy-accent), var(--murphy-accent-2));
  color: #0a0a0a; border: none;
  box-shadow: 0 6px 16px rgba(110,168,254,.35);
}

.murphy_btn--ghost {
  background: transparent; color: var(--murphy-text);
}

/* Subtle form group spacing on mobile */
@media (min-width: 640px) {
  .murphy_grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
}

/* Smooth hover elev */
.murphy_card.murphy_hover { transition: transform .18s ease, box-shadow .18s ease; }
/* Murphy Modal (dark) */
.murphy_modal .murphy_modal__content {
  background: #121826;
  color: #e8ecf1;
  border: 1px solid #2b3647;
  border-radius: 14px;
  box-shadow: 0 10px 30px rgba(0,0,0,.35);
}
.murphy_modal__header { border-bottom: 1px solid #263043; }
.murphy_modal__footer { border-top: 1px solid #263043; }
.murphy_modal__title { font-weight: 700; letter-spacing: .2px; }
.murphy_modal__muted { color: #9aa6b2; }

.murphy_modal__list {
  margin: 0; padding-left: 1rem; list-style: disc;
}
.murphy_modal__list li {
  margin-bottom: 4px; color: #e8ecf1;
}

.murphy_check {
  display: inline-flex; width: 56px; height: 56px;
  border-radius: 50%; align-items: center; justify-content: center;
  background: linear-gradient(180deg, #34d399, #22c55e);
  color: #0a0a0a; font-weight: 900; font-size: 28px;
  box-shadow: 0 8px 20px rgba(34,197,94,.35);
  user-select: none;
}

.murphy-container
  {
    width: 100%;
    max-width: 980px;
    margin-inline: auto;
    padding: 16px;
    color:white;
  }

</style>
<body style="background:#0e1116;">
  

        <!-- Murphy Upload Modal -->
        <div class="modal fade murphy_modal" id="murphyUploadModal" tabindex="-1" role="dialog"  >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content murphy_modal__content">
            <div class="modal-header murphy_modal__header">
                <h5 class="modal-title murphy_modal__title">ກຳລັງອັບໂຫຼດເອກະສານ</h5>
            </div>

            <div class="modal-body murphy_modal__body">
                <!-- Uploading state -->
                <div id="murphy-uploading">
                <p class="murphy_modal__muted mb-2">ລາຍການເອກະສານທີ່ຈະອັບໂຫຼດ:</p>
                <ul id="murphy-file-list" class="murphy_modal__list"></ul>
                <div class="d-flex align-items-center mt-3">
                    <div class="spinner-border spinner-border-sm mr-2" role="status"  ></div>
                    <span class="murphy_modal__muted">ກຳລັງສົ່ງ…</span>
                </div>
                </div>

                <!-- Success state -->
                <div id="murphy-success" class="text-center d-none">
                <div class="murphy_check mb-2">✓</div>
                <div class="h5 mb-1">ສົ່ງຂໍ້ມູນສຳເລັດ</div>
                <small class="murphy_modal__muted">ກຳລັງປິດກ່ອງໂຕ້ຕອບ…</small>
                </div>

                <!-- Error state -->
                <div id="murphy-error" class="d-none">
                <div class="h5 text-danger mb-2">ຜິດພາດ</div>
                <p id="murphy-error-text" class="mb-0"></p>
                </div>
            </div>

            <div class="modal-footer murphy_modal__footer">
                <button type="button" id="murphy-close" class="btn btn-secondary btn-sm d-none" data-dismiss="modal">ປິດ</button>
            </div>
            </div>
        </div>
        </div>




    <section class="murphy_scope py-3 laos">
  <div class="murphy_container">
    <article class="murphy_card murphy_hover">
        <div class="p-3">
             <h1 class="text-2xl font-bold  laos">
                ຢຸດເຊີ້ຂອງທ່ານໄດ້ຫມົດອາຍຸແລ້ວ : "{{  date('d-m-Y',strtotime(Auth::user()->end_at)) }}" 
            </h1> 
            <p class="text-gray-700  laos text-white">
                <label class="">ກະລຸນາເຂົ້າມາພົວພັນທີ່ຫ້ອງການບໍລິຫານດ່ານ</label> ຂົວມິດຕະພາບ 1  (ຈຸດບໍລິການທ່າບົກນາແລ້ງ) ຫລື ຕິດຕໍ່ພົວພັນເບີໂທ : 020 5838 1616
            </p>
        </div>
      <header class="murphy_card__header">
        
        <h2 class="murphy_title">ແຈ້ງຂໍ້ມູນສືບຕໍ່ການນຳໃຊ້ຢຸດເຊີ້</h2> 
      </header>
            
      <div class="murphy_card__body">
        <form id="form-data" class="murphy_form"> 
          <div class="murphy_field">
            <label for="lasttails" class="murphy_label">ລາຍລະອຽດ</label>
            <input type="text" class="murphy_input form-control murphy_input--tight lasttails"
                   id="lasttails" name="lasttails" autocomplete="off"
                   placeholder="ພິມລາຍລະອຽດ/ຂໍ້ມູນທີ່ຈະແຈ້ງ…"> 
          </div>

          <div class="murphy_field">
            <label class="murphy_label" for="upload_files">ແນບເອກະສານຢັ້ງຢືນ : </label>  
                    <div class="d-flex"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="15px" viewBox="0 0 24 24" width="15px" fill="#e3e3e3"><rect fill="none" height="24" width="24"/><polygon points="20.79,9.23 18.79,5.77 14,8.54 14,3 10,3 10,8.54 5.21,5.77 3.21,9.23 8,12 3.21,14.77 5.21,18.23 10,15.46 10,21 14,21 14,15.46 18.79,18.23 20.79,14.77 16,12"/></svg> &nbsp;&nbsp; ໃບສະເໜີ ຂໍນຳໃຊ້ຢຸດເຊີ</div> 
                    <div class="d-flex"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="15px" viewBox="0 0 24 24" width="15px" fill="#e3e3e3"><rect fill="none" height="24" width="24"/><polygon points="20.79,9.23 18.79,5.77 14,8.54 14,3 10,3 10,8.54 5.21,5.77 3.21,9.23 8,12 3.21,14.77 5.21,18.23 10,15.46 10,21 14,21 14,15.46 18.79,18.23 20.79,14.77 16,12"/></svg> &nbsp;&nbsp; ໃບທະບຽນວິສາຫະກິດ</div> 
                    <div class="d-flex"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="15px" viewBox="0 0 24 24" width="15px" fill="#e3e3e3"><rect fill="none" height="24" width="24"/><polygon points="20.79,9.23 18.79,5.77 14,8.54 14,3 10,3 10,8.54 5.21,5.77 3.21,9.23 8,12 3.21,14.77 5.21,18.23 10,15.46 10,21 14,21 14,15.46 18.79,18.23 20.79,14.77 16,12"/></svg> &nbsp;&nbsp; ໃບທະບຽນອາການປະຈຳປີ 2024</div> 
                    
            <div class="murphy_dropzone" id="murphy-drop">
              <div>
                <small class="murphy_help">
                  (PDF, JPG, PNG) — ສາມາດເລືອກຫຼາຍໆເອກະສານໄດ້.
                </small>
                <div class="murphy_badge mt-1">ຂະໜາດລວມບໍ່ເກີນ 15MB</div>
              </div>

              <input type="file" class="form-control murphy_input"
                     id="upload_files" name="upload_files[]" multiple>
            </div>
          </div>

          <input type="hidden" class="index" id="index" name="index">
        </form>
      </div>

      <footer class="murphy_card__footer">
        <button class="murphy_btn " type="button" id="reset-form">ລ້າງຟອມ</button>
        <button class="murphy_btn  " id="save">ແຈ້ງສືບຕໍ່</button>
      </footer>
    </article>
  </div>
</section>



<div  >  
    <div class=" ">
        <main class="murphy-container admin-wrap p-1">
          <div class="">
            <div class="admin-header">  
                  <div class="mobile-card mobile-cards">
                    @foreach($beta_company_profile AS $r)
                      <div class="murphy_card murphy_hover mt-2 p-3"  id="creator-card-{{ $r->user_id }}"> 
                        <div class="mobile-row"> 
                          <div class="mobile-row d-flex justify-content-between">
                            <div class="label">
                              @if($r->status=='pending')
                                ກຳລັງເຮັດວຽກ
                              @elseif($r->status=='rejected')
                                ຖຶກຕີກັບ
                              @elseif($r->status=='accepted')
                                ຍອມຮັບແລ້ວ
                              @else
                              @endif
                            </div>
                            <div class="value small text-end"> 
                                  <div class="d-flex text-white mt-1">
                                    @if($r->status=='pending')
                                      <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="50px" viewBox="0 0 24 24" width="50px" fill="#F3F3F3"><g><rect fill="none" height="24" width="24"/></g><g><path d="M12,2C6.48,2,2,6.48,2,12c0,5.52,4.48,10,10,10s10-4.48,10-10C22,6.48,17.52,2,12,2z M13.5,6c0.55,0,1,0.45,1,1 c0,0.55-0.45,1-1,1s-1-0.45-1-1C12.5,6.45,12.95,6,13.5,6z M16,12c-0.7,0-2.01-0.54-2.91-1.76l-0.41,2.35L14,14.03V18h-1v-3.58 l-1.11-1.21l-0.52,2.64L7.6,15.08l0.2-0.98l2.78,0.57l0.96-4.89L10,10.35V12H9V9.65l3.28-1.21c0.49-0.18,1.03,0.06,1.26,0.53 C14.37,10.67,15.59,11,16,11V12z"/></g></svg>
                                    @elseif($r->status=='rejected')
                                        <svg xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="0 0 24 24" width="50px" fill="#F3F3F3"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM4 12c0-4.42 3.58-8 8-8 1.85 0 3.55.63 4.9 1.69L5.69 16.9C4.63 15.55 4 13.85 4 12zm8 8c-1.85 0-3.55-.63-4.9-1.69L18.31 7.1C19.37 8.45 20 10.15 20 12c0 4.42-3.58 8-8 8z"/></svg>
                                    @elseif($r->status=='accepted')
                                        <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="50px" viewBox="0 0 24 24" width="50px" fill="#F3F3F3"><g><rect fill="none" height="24" width="24"/></g><g><path d="M23,12l-2.44-2.79l0.34-3.69l-3.61-0.82L15.4,1.5L12,2.96L8.6,1.5L6.71,4.69L3.1,5.5L3.44,9.2L1,12l2.44,2.79l-0.34,3.7 l3.61,0.82L8.6,22.5l3.4-1.47l3.4,1.46l1.89-3.19l3.61-0.82l-0.34-3.69L23,12z M10.09,16.72l-3.8-3.81l1.48-1.48l2.32,2.33 l5.85-5.87l1.48,1.48L10.09,16.72z"/></g></svg>
                                    @else
                                    @endif
                                  </div>  
                            </div>
                          </div>


                            @if($r->status=='rejected')  
                              <div class="mobile-row">
                                <div class="label">  
                                    ສາເຫດທີ່ຖືກຕີກັບ : "{{  $r->log }}"
                                </div>
                                <div class="value small text-end">
                                  
                                </div>
                              </div> 
                            @endif

                          <div class="mobile-row">
                            <div class="label">
                              {{ $r->beta_company_group->com_name }} / 
                              <small>ເວລາສົ່ງຄຳຮ້ອງ</small> : {{ date('d-m-Y', strtotime($r->created_at)) }} /  {{ date('h:i:s', strtotime($r->created_at)) }}
                            </div>
                            <div class="value small text-end">
                                <span class="end-at" data-end-at="{{ $r->user_id }}">
                                
                                </span>
                            </div>
                          </div>
    
                        </div>
                      </div>
                    @endforeach
                  </div>
              </div>
            </div>
        </main>
      </div>
  </div>
  <br>
  <br>
  <br>
  <br>
</body>


    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">
    </script> 

    <script>
$(document).ready(function () {
  function bytesToSize(bytes) {
    if (bytes === 0) return '0 B';
    const k = 1024, sizes = ['B','KB','MB','GB'];
    const i = Math.floor(Math.log(bytes)/Math.log(k));
    return (bytes/Math.pow(k, i)).toFixed(i ? 1 : 0) + ' ' + sizes[i];
  }

  function buildFileList(files) {
    const $list = $('#murphy-file-list').empty();
    if (!files || files.length === 0) {
      $('<li/>', { text: 'ບໍ່ມີເອກະສານ' }).appendTo($list);
      return 0;
    }
    let total = 0;
    Array.from(files).forEach(f => {
      total += f.size;
      $('<li/>').text(`${f.name} — ${bytesToSize(f.size)}`).appendTo($list);
    });
    $('<li/>').html(`<strong>ລວມ:</strong> ${bytesToSize(total)}`).appendTo($list);
    return total;
  }

//   $('#murphyUploadModal').modal({ backdrop: 'static', keyboard: false });

  // Optional: allow user to close modal after error
  $('#murphy-close').on('click', function () {
    $('#murphyUploadModal').modal('hide');
  });
});
</script>
    <script>
    

        $(document).ready(function () {  
            $('#save').on('click', function (e) { 
                 
                $('#murphyUploadModal').modal('show');
                $('#save').prop('disabled', true);
                e.preventDefault(); 
                let deta = new FormData($('#form-data')[0]);
                const pdfFiles = document.querySelector('input[type="file"]').files;

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "post",
                    url: "/enter/save-test",
                    data: (deta),
                    dataType: "json",
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        // console.log(response.message) 
                        // window.location.reload();
                        
                        $('#murphyUploadModal').modal('hide'); 
                        $('#save').prop('disabled', false);
                        showState('success');
                        $('#form-data')[0].reset();
                    },
                    complete: function () {
                        // me.data('requestRunning', false);
                        let dumxxz = "ສົ່ງຂໍ້ມູນສຳເລັດ"; 

                        
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        if (errorThrown == 'Payload Too Large') {
                            let dumx = "ຂະໜາດ File ລວມ ມີຂະໜາດເກີນ 1.5Mb"; 
                            $('#save').prop('disabled', false);

                        $('#murphyUploadModal').modal('hide'); 
                        $('#save').prop('disabled', false);
                        showState('error'); 
                            return false;
                        }
                        else
                        {
                            let dumxn = "ການສົ່ງຊໍ້ມູນຜິດພາດກະລຸນາສົ່ງໃຫມ່"; 
                        }
                    }
                }); 
            }); 
        }); 
</script>

 

<script>
  $(function () {
    const $drop = $('#murphy-drop');

    // Drag & drop highlight (works even without custom upload handler)
    $(document).on('dragover dragenter', function (e) {
      e.preventDefault(); e.stopPropagation();
      $drop.addClass('murphy_dropzone--active');
    });
    $(document).on('dragleave dragend drop', function (e) {
      e.preventDefault(); e.stopPropagation();
      $drop.removeClass('murphy_dropzone--active');
    });

    // Reset button
    $('#reset-form').on('click', function () {
      $('#form-data')[0].reset();
    });

    // Your existing save logic still applies — keep your handler
    $('#save').on('click', function (e) {
      e.preventDefault();
      $('#save').prop('disabled', true);
      // ... your AJAX / submit code here
    });

    
  });

  
  function showState(state) {
    // states: uploading | success | error
    $('#murphy-uploading').toggleClass('d-none', state !== 'uploading');
    $('#murphy-success').toggleClass('d-none', state !== 'success');
    $('#murphy-error').toggleClass('d-none', state !== 'error');
    $('#murphy-close').toggleClass('d-none', state === 'uploading');
  }
</script>


</x-app-layout>
