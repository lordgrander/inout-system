<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover" />
  <title>Realtime Camera Text Scan (ENG/TH/LA)</title>

  <!-- Bootstrap (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600;800&family=Sarabun:wght@400;600;800&family=Noto+Sans+Lao:wght@400;600;800&display=swap" rel="stylesheet">

  <!-- Tesseract.js (OCR) -->
  <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>

  <style>
    :root{
      --bg0:#06080f;
      --bg1:#0b1020;
      --glass: rgba(18, 24, 44, .45);
      --glass2: rgba(18, 24, 44, .28);
      --line: rgba(255,255,255,.12);
      --ink: rgba(255,255,255,.92);
      --sub: rgba(255,255,255,.68);
      --brand: #4da3ff;
      --ok: #22c55e;
      --warn: #fbbf24;
      --danger: #ff5564;
      --shadow: 0 18px 45px rgba(0,0,0,.45);
      --r: 18px;
    }

    body{
      min-height:100vh;
      background:
        radial-gradient(1200px 800px at 15% 5%, rgba(77,163,255,.22), transparent 60%),
        radial-gradient(900px 700px at 90% 10%, rgba(34,197,94,.16), transparent 60%),
        radial-gradient(900px 700px at 50% 110%, rgba(251,191,36,.14), transparent 60%),
        linear-gradient(180deg, var(--bg1), var(--bg0));
      color: var(--ink);
      overflow-x:hidden;
      font-family: Roboto, system-ui, -apple-system, Segoe UI, Arial, sans-serif;
    }

    .font-th { font-family: Sarabun, Roboto, sans-serif; }
    .font-la { font-family: "Noto Sans Lao", Roboto, sans-serif; }
    .font-en { font-family: Roboto, sans-serif; }

    .glass{
      background: var(--glass);
      border: 1px solid var(--line);
      border-radius: var(--r);
      box-shadow: var(--shadow);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
    }
    .glass-lite{
      background: var(--glass2);
      border: 1px solid var(--line);
      border-radius: 14px;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }

    .app-wrap{ padding: clamp(14px, 2vw, 20px); }
    .title{
      font-weight: 800;
      letter-spacing: .2px;
      line-height: 1.1;
    }
    .subtitle{
      color: var(--sub);
      line-height: 1.35;
      margin: 0;
    }

    /* Camera stage */
    .stage{
      position: relative;
      width: 100%;
      aspect-ratio: 16 / 10;
      border-radius: 18px;
      overflow: hidden;
      border: 1px solid var(--line);
      background: rgba(0,0,0,.35);
    }
    @media (max-width: 576px){
      .stage{ aspect-ratio: 3 / 4; }
    }

    video{
      position:absolute;
      inset:0;
      width:100%;
      height:100%;
      object-fit: cover;
      transform: translateZ(0);
    }

    /* Scan frame overlay */
    .scan-overlay{
      position:absolute;
      inset:0;
      pointer-events:none;
      display:flex;
      align-items:center;
      justify-content:center;
    }
    .scan-box{
      width: min(86%, 820px);
      height: min(42%, 320px);
      border-radius: 16px;
      position: relative;
      box-shadow: 0 0 0 9999px rgba(0,0,0,.34);
      border: 1px solid rgba(255,255,255,.18);
      background: linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.02));
      overflow:hidden;
    }
    @media (max-width: 576px){
      .scan-box{
        width: 88%;
        height: 40%;
      }
    }
    .scan-box::before{
      content:"";
      position:absolute; inset:0;
      background:
        linear-gradient(to right, rgba(255,255,255,.15) 1px, transparent 1px) 0 0 / 24px 24px,
        linear-gradient(to bottom, rgba(255,255,255,.12) 1px, transparent 1px) 0 0 / 24px 24px;
      opacity: .18;
      mix-blend-mode: screen;
      pointer-events:none;
    }

    .corner{
      position:absolute; width:28px; height:28px;
      border: 3px solid rgba(77,163,255,.9);
      filter: drop-shadow(0 10px 20px rgba(77,163,255,.25));
    }
    .tl{ left:10px; top:10px; border-right:none; border-bottom:none; border-radius: 10px 0 0 0; }
    .tr{ right:10px; top:10px; border-left:none; border-bottom:none; border-radius: 0 10px 0 0; }
    .bl{ left:10px; bottom:10px; border-right:none; border-top:none; border-radius: 0 0 0 10px; }
    .br{ right:10px; bottom:10px; border-left:none; border-top:none; border-radius: 0 0 10px 0; }

    .scan-line{
      position:absolute; left:0; right:0;
      height: 2px;
      background: linear-gradient(90deg, transparent, rgba(77,163,255,.95), transparent);
      animation: sweep 1.8s ease-in-out infinite;
      opacity:.85;
    }
    @keyframes sweep{
      0%{ top: 10%; filter: blur(.2px); }
      50%{ top: 85%; filter: blur(.0px); }
      100%{ top: 10%; filter: blur(.2px); }
    }

    /* Controls */
    .btn-soft{
      border: 1px solid var(--line);
      background: rgba(255,255,255,.06);
      color: var(--ink);
      border-radius: 999px;
      padding: 10px 14px;
      font-weight: 700;
      transition: transform .08s ease, background .15s ease, border-color .15s ease;
    }
    .btn-soft:hover{ background: rgba(255,255,255,.10); border-color: rgba(255,255,255,.18); }
    .btn-soft:active{ transform: translateY(1px); }

    .btn-brand{
      border: 1px solid rgba(77,163,255,.35);
      background: linear-gradient(180deg, rgba(77,163,255,.95), rgba(18,103,255,.92));
      color: #071020;
      border-radius: 999px;
      padding: 10px 16px;
      font-weight: 900;
      letter-spacing:.2px;
      box-shadow: 0 14px 30px rgba(77,163,255,.18);
      transition: transform .08s ease, filter .15s ease;
    }
    .btn-brand:hover{ filter: brightness(1.04); }
    .btn-brand:active{ transform: translateY(1px); }

    .chip{
      display:inline-flex; align-items:center; gap:8px;
      padding: 8px 10px;
      border-radius: 999px;
      border: 1px solid var(--line);
      background: rgba(255,255,255,.06);
      color: var(--sub);
      font-size:.9rem;
    }
    .dot{
      width:10px; height:10px; border-radius: 99px;
      background: var(--warn);
      box-shadow: 0 0 0 6px rgba(251,191,36,.12);
    }
    .dot.ok{ background: var(--ok); box-shadow: 0 0 0 6px rgba(34,197,94,.12); }
    .dot.bad{ background: var(--danger); box-shadow: 0 0 0 6px rgba(255,85,100,.12); }

    textarea.form-control, select.form-select{
      background: rgba(255,255,255,.06);
      border: 1px solid var(--line);
      color: var(--ink);
      border-radius: 14px;
    }
    textarea.form-control:focus, select.form-select:focus{
      border-color: rgba(77,163,255,.55);
      box-shadow: 0 0 0 4px rgba(77,163,255,.15);
      background: rgba(255,255,255,.08);
      color: var(--ink);
    }

    .muted{ color: var(--sub); }
    .smallish{ font-size: .92rem; }

    /* Hidden canvas for capture */
    canvas{ display:none; }

    /* Reduce motion */
    @media (prefers-reduced-motion: reduce){
      .scan-line{ animation: none; display:none; }
      *{ transition:none!important; }
    }
  </style>
</head>

<body>
  <div class="app-wrap container-xxl">
    <div class="row g-3 align-items-stretch">
      <div class="col-12">
        <div class="glass p-3 p-sm-4">
          <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>
              <div class="title font-th">สแกนข้อความจากกล้อง (ENG / ไทย / ລາວ)</div>
              <p class="subtitle font-th mt-1">จัดกรอบให้พอดี → กด “จับภาพ + อ่านข้อความ” → ข้อความจะถูกใส่ในช่องด้านล่าง</p>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
              <span class="chip">
                <span id="statusDot" class="dot"></span>
                <span id="statusText" class="font-th">พร้อมใช้งาน</span>
              </span>
              <button id="btnStart" class="btn-soft font-th" type="button">เปิดกล้อง</button>
              <button id="btnFlip" class="btn-soft font-th" type="button" disabled>สลับกล้อง</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Camera + capture -->
      <div class="col-12 col-lg-7">
        <div class="glass p-3 p-sm-4 h-100">
          <div class="stage" id="stage">
            <video id="video" playsinline autoplay muted></video>

            <div class="scan-overlay">
              <div class="scan-box" id="scanBox" aria-label="Scan Area">
                <div class="corner tl"></div>
                <div class="corner tr"></div>
                <div class="corner bl"></div>
                <div class="corner br"></div>
                <div class="scan-line"></div>
              </div>
            </div>
          </div>

          <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between mt-3">
            <div class="glass-lite p-2 px-3 d-flex align-items-center gap-2">
              <span class="muted font-th smallish">ภาษา OCR:</span>
              <select class="form-select form-select-sm" id="langSelect" style="width:210px;">
                <option value="eng">English (eng)</option>
                <option value="tha">ไทย (tha)</option>
                <option value="lao">ລາວ (lao)</option>
                <option value="eng+tha" selected>English + ไทย</option>
                <option value="eng+tha+lao">English + ไทย + ລາວ</option>
              </select>
            </div>

            <div class="d-flex gap-2 flex-wrap">
              <button id="btnCapture" class="btn-brand font-th" type="button" disabled>จับภาพ + อ่านข้อความ</button>
              <button id="btnClear" class="btn-soft font-th" type="button">ล้างข้อความ</button>
            </div>
          </div>

          <p class="muted smallish font-th mt-2 mb-0">
            หมายเหตุ: OCR ทำงานหนักนิดนึง—ถ้าเครื่องช้า ให้เลือกภาษาให้น้อยลง (เช่น eng หรือ tha อย่างเดียว) จะเร็วขึ้น
          </p>
        </div>
      </div>

      <!-- Output -->
      <div class="col-12 col-lg-5">
        <div class="glass p-3 p-sm-4 h-100">
          <div class="d-flex align-items-center justify-content-between">
            <div class="title font-th" style="font-size:1.1rem;">ผลลัพธ์ข้อความ</div>
            <div class="muted smallish font-th" id="progressText">—</div>
          </div>

          <div class="mt-3">
            <label class="muted font-th smallish mb-2 d-block">ข้อความที่อ่านได้ (ปรับแก้ได้)</label>
            <textarea id="output" class="form-control font-en" rows="10" placeholder="Result text will appear here..."></textarea>
          </div>

          <div class="mt-3 glass-lite p-3">
            <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
              <div class="muted font-th smallish">
                โหมดฟอนต์:
              </div>
              <div class="btn-group" role="group" aria-label="Font mode">
                <button class="btn btn-sm btn-soft" type="button" id="fontEN">English</button>
                <button class="btn btn-sm btn-soft" type="button" id="fontTH">ไทย</button>
                <button class="btn btn-sm btn-soft" type="button" id="fontLA">ລາວ</button>
              </div>
            </div>
            <div class="muted font-th smallish mt-2">
              Tip: ใช้ “ไทย” เพื่ออ่านง่ายตอนตรวจคำไทย, ใช้ “ລາວ” เพื่อตรวจคำลาว, แล้วค่อยกลับ “English” ได้
            </div>
          </div>

          <div class="mt-3 d-flex gap-2 flex-wrap">
            <button id="btnCopy" class="btn-soft font-th" type="button">คัดลอกข้อความ</button>
            <button id="btnStop" class="btn-soft font-th" type="button" disabled>ปิดกล้อง</button>
          </div>

          <div class="mt-3 muted smallish font-th">
            ถ้ากล้องไม่ขึ้น: ต้องเปิดผ่าน <b>https</b> หรือ <b>localhost</b> (เบราว์เซอร์บังคับความปลอดภัย)
          </div>
        </div>
      </div>
    </div>
  </div>

  <canvas id="captureCanvas"></canvas>

  <script>
    // ===== Tiny helpers
    const $ = (id) => document.getElementById(id);

    const ui = {
      video: $("video"),
      stage: $("stage"),
      scanBox: $("scanBox"),
      canvas: $("captureCanvas"),
      output: $("output"),
      langSelect: $("langSelect"),
      btnStart: $("btnStart"),
      btnStop: $("btnStop"),
      btnFlip: $("btnFlip"),
      btnCapture: $("btnCapture"),
      btnClear: $("btnClear"),
      btnCopy: $("btnCopy"),
      statusDot: $("statusDot"),
      statusText: $("statusText"),
      progressText: $("progressText"),
      fontEN: $("fontEN"),
      fontTH: $("fontTH"),
      fontLA: $("fontLA"),
    };

    let stream = null;
    let currentFacing = "environment"; // prefer back camera
    let worker = null;
    let isBusy = false;

    function setStatus(kind, text){
      ui.statusDot.className = "dot" + (kind ? (" " + kind) : "");
      ui.statusText.textContent = text;
    }
    function setProgress(text){
      ui.progressText.textContent = text || "—";
    }

    async function startCamera(){
      try{
        setStatus("", "กำลังเปิดกล้อง...");
        const constraints = {
          audio: false,
          video: {
            facingMode: { ideal: currentFacing },
            width: { ideal: 1280 },
            height: { ideal: 720 }
          }
        };

        // stop previous
        await stopCamera();

        stream = await navigator.mediaDevices.getUserMedia(constraints);
        ui.video.srcObject = stream;

        // wait metadata for correct sizing
        await new Promise(res => ui.video.onloadedmetadata = () => res());

        ui.btnStop.disabled = false;
        ui.btnCapture.disabled = false;

        // enable flip only if multiple cameras exist
        try{
          const devices = await navigator.mediaDevices.enumerateDevices();
          const cams = devices.filter(d => d.kind === "videoinput");
          ui.btnFlip.disabled = cams.length < 2;
        }catch(e){
          ui.btnFlip.disabled = false; // best effort
        }

        setStatus("ok", "กล้องพร้อม");
      }catch(err){
        console.error(err);
        setStatus("bad", "เปิดกล้องไม่สำเร็จ");
        setProgress("ตรวจสิทธิ์กล้อง / ต้องใช้ https หรือ localhost");
        ui.btnStop.disabled = true;
        ui.btnCapture.disabled = true;
        ui.btnFlip.disabled = true;
      }
    }

    async function stopCamera(){
      if(stream){
        stream.getTracks().forEach(t => t.stop());
        stream = null;
      }
      ui.video.srcObject = null;
      ui.btnStop.disabled = true;
      ui.btnCapture.disabled = true;
      setStatus("", "พร้อมใช้งาน");
    }

    function cropScanAreaToCanvas(){
      // We draw the exact video frame to an offscreen canvas, then crop to scanBox area.
      const video = ui.video;
      const stageRect = ui.stage.getBoundingClientRect();
      const boxRect = ui.scanBox.getBoundingClientRect();

      // Map scanBox region (CSS pixels) to video pixels.
      // Important: video is object-fit: cover, so we must account for cropping.
      const vw = video.videoWidth;
      const vh = video.videoHeight;
      if(!vw || !vh) throw new Error("Video not ready");

      const stageW = stageRect.width;
      const stageH = stageRect.height;

      // Compute how object-fit:cover scales video into stage
      const videoAspect = vw / vh;
      const stageAspect = stageW / stageH;

      let drawW, drawH, offsetX, offsetY;
      if(videoAspect > stageAspect){
        // video wider -> height fits, width crops
        drawH = stageH;
        drawW = stageH * videoAspect;
        offsetX = (stageW - drawW) / 2;
        offsetY = 0;
      }else{
        // video taller -> width fits, height crops
        drawW = stageW;
        drawH = stageW / videoAspect;
        offsetX = 0;
        offsetY = (stageH - drawH) / 2;
      }

      // Box coords relative to stage
      const bx = boxRect.left - stageRect.left;
      const by = boxRect.top - stageRect.top;
      const bw = boxRect.width;
      const bh = boxRect.height;

      // Convert stage pixels -> "drawn video" pixels -> source video pixels
      const sx = (bx - offsetX) * (vw / drawW);
      const sy = (by - offsetY) * (vh / drawH);
      const sw = bw * (vw / drawW);
      const sh = bh * (vh / drawH);

      // Clamp safe
      const csx = Math.max(0, Math.min(vw - 1, sx));
      const csy = Math.max(0, Math.min(vh - 1, sy));
      const csw = Math.max(1, Math.min(vw - csx, sw));
      const csh = Math.max(1, Math.min(vh - csy, sh));

      // Output canvas size (keep it reasonable for speed)
      const targetW = Math.min(1200, Math.round(csw));
      const scale = targetW / csw;
      const targetH = Math.round(csh * scale);

      ui.canvas.width = targetW;
      ui.canvas.height = targetH;

      const ctx = ui.canvas.getContext("2d", { willReadFrequently: true });

      // Improve OCR with a bit of contrast preprocessing
      ctx.drawImage(video, csx, csy, csw, csh, 0, 0, targetW, targetH);

      // Simple luminance stretch
      const img = ctx.getImageData(0, 0, targetW, targetH);
      const data = img.data;

      // quick auto-contrast-ish
      let min = 255, max = 0;
      for(let i=0;i<data.length;i+=4){
        const r=data[i], g=data[i+1], b=data[i+2];
        const y = (0.2126*r + 0.7152*g + 0.0722*b) | 0;
        if(y<min) min=y;
        if(y>max) max=y;
      }
      const range = Math.max(1, max - min);
      const boost = 255 / range;

      for(let i=0;i<data.length;i+=4){
        const r=data[i], g=data[i+1], b=data[i+2];
        let y = (0.2126*r + 0.7152*g + 0.0722*b);
        y = (y - min) * boost;
        y = Math.max(0, Math.min(255, y));
        // mild sharpening via contrast
        data[i] = data[i+1] = data[i+2] = y;
        // keep alpha
      }
      ctx.putImageData(img, 0, 0);
    }

    async function ensureWorker(lang){
      if(worker){
        // If worker exists but languages differ, easiest: terminate and recreate (reliable)
        await worker.terminate();
        worker = null;
      }

      setProgress("Loading OCR engine...");
      setStatus("", "กำลังเตรียม OCR...");

      worker = await Tesseract.createWorker({
        logger: m => {
          if(m.status === "recognizing text"){
            const pct = Math.round((m.progress || 0) * 100);
            setProgress(`OCR: ${pct}%`);
          }else if(m.status){
            setProgress(m.status);
          }
        }
      });

      try{
        await worker.loadLanguage(lang);
      }catch(e){
        // Lao traineddata might not be available in some builds/CDNs
        if(lang.includes("lao")){
          console.warn("Failed to load lao; falling back to eng+tha", e);
          ui.langSelect.value = "eng+tha";
          lang = "eng+tha";
          await worker.loadLanguage(lang);
          setProgress("Lao not available on this CDN → fallback to English+Thai");
        }else{
          throw e;
        }
      }

      await worker.initialize(lang);

      // A few helpful defaults
      try{
        // PSM 6 = Assume a uniform block of text
        await worker.setParameters({
          tessedit_pageseg_mode: "6"
        });
      }catch(_){}

      setStatus("ok", "OCR พร้อม");
      setProgress("Ready");
    }

    async function doOCR(){
      if(isBusy) return;
      if(!stream){
        setStatus("bad", "ต้องเปิดกล้องก่อน");
        return;
      }

      isBusy = true;
      ui.btnCapture.disabled = true;
      ui.btnStart.disabled = true;
      ui.btnFlip.disabled = true;

      try{
        setStatus("", "กำลังจับภาพ...");
        cropScanAreaToCanvas();

        const lang = ui.langSelect.value;

        await ensureWorker(lang);

        setStatus("", "กำลังอ่านตัวอักษร...");
        const { data } = await worker.recognize(ui.canvas);

        const text = (data && data.text ? data.text : "").trim();
        ui.output.value = text || "";
        setStatus("ok", text ? "อ่านสำเร็จ" : "ไม่พบข้อความชัดเจน");
        setProgress(text ? "Done" : "Try again: clearer focus / more light");
      }catch(err){
        console.error(err);
        setStatus("bad", "OCR ล้มเหลว");
        setProgress("ลองใหม่: เลือกภาษาน้อยลง / เพิ่มแสง / จัดกรอบให้ตรง");
      }finally{
        isBusy = false;
        ui.btnCapture.disabled = false;
        ui.btnStart.disabled = false;
        // Flip only if camera exists and not busy; keep current disabled state if no multi cams
        // (we don't know here, but enabling is okay)
        if(stream) ui.btnFlip.disabled = false;
      }
    }

    // ===== Events
    ui.btnStart.addEventListener("click", startCamera);
    ui.btnStop.addEventListener("click", stopCamera);

    ui.btnFlip.addEventListener("click", async () => {
      currentFacing = (currentFacing === "environment") ? "user" : "environment";
      await startCamera();
    });

    ui.btnCapture.addEventListener("click", doOCR);

    ui.btnClear.addEventListener("click", () => {
      ui.output.value = "";
      setProgress("Cleared");
    });

    ui.btnCopy.addEventListener("click", async () => {
      try{
        await navigator.clipboard.writeText(ui.output.value || "");
        setProgress("Copied ✅");
        setStatus("ok", "คัดลอกแล้ว");
        setTimeout(() => setStatus("ok","OCR พร้อม"), 900);
      }catch(e){
        setProgress("Copy failed (browser permission)");
      }
    });

    // Font toggles for the output box
    function setOutFont(cls){
      ui.output.classList.remove("font-en","font-th","font-la");
      ui.output.classList.add(cls);
    }
    ui.fontEN.addEventListener("click", ()=>setOutFont("font-en"));
    ui.fontTH.addEventListener("click", ()=>setOutFont("font-th"));
    ui.fontLA.addEventListener("click", ()=>setOutFont("font-la"));

    // Auto start if possible (mobile will still ask permission)
    (async function boot(){
      setOutFont("font-en");
      setStatus("", "พร้อมใช้งาน");
      setProgress("Tap “เปิดกล้อง”");
      // Don’t auto-start without user gesture (some browsers block it)
    })();
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
