<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="utf-8" />
  <title>Hand-Click Buttons (MediaPipe Hands + SweetAlert2)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Font + Tailwind -->
  <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;600;800&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config={theme:{extend:{fontFamily:{sarabun:['Sarabun','system-ui','sans-serif']}}}}</script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- MediaPipe Hands -->
  <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js"></script>

  <style>
    html,body{height:100%;margin:0;background:radial-gradient(900px 600px at 20% 10%,#0c1224,#070a16);font-family:'Sarabun',system-ui,sans-serif;}
    .glass{background:rgba(18,24,40,.55);border:1px solid rgba(148,163,184,.25);
           backdrop-filter:blur(14px) saturate(130%);-webkit-backdrop-filter:blur(14px) saturate(130%);
           box-shadow:0 12px 40px rgba(2,8,23,.35);}
    .btn3{border:1px solid rgba(255,255,255,.12);background:linear-gradient(180deg,#121a2e,#0d1425);
          color:#e5edff;border-radius:16px;padding:14px 18px;font-weight:700;letter-spacing:.2px;
          transition:transform .12s ease, box-shadow .12s ease, border-color .12s ease;}
    .btn3:hover{transform:translateY(-2px);box-shadow:0 10px 28px rgba(29,78,216,.35);border-color:rgba(99,102,241,.6);}
    /* Hidden video so iOS won’t fullscreen it */
    #webcamVideo{display:none!important;visibility:hidden!important;width:0!important;height:0!important;opacity:0!important;position:fixed!important;pointer-events:none!important;}
    /* Hand cursor */
    #handCursor{position:fixed;left:0;top:0;transform:translate3d(-9999px,-9999px,0);width:18px;height:18px;margin:-9px 0 0 -9px;
      border-radius:9999px;border:2px solid #00ffff;box-shadow:0 0 14px rgba(0,255,255,.7);background:rgba(0,255,255,.08);
      pointer-events:none;z-index:50;transition:border-color .12s ease, box-shadow .12s ease;}
    #handCursor.pinch{border-color:#ff8a00;box-shadow:0 0 14px rgba(255,138,0,.85);background:rgba(255,138,0,.12);}
    /* Hover ring when cursor floats over a button */
    .hoverGlow{outline:2px solid rgba(255,255,255,.22); box-shadow:0 0 0 6px rgba(99,102,241,.15), 0 10px 28px rgba(29,78,216,.35);}
    /* Overlay */
    #overlay{position:fixed;inset:0;display:grid;place-items:center;z-index:60;background:rgba(7,10,22,.85);color:#cbd5e1}
  </style>
</head>
<body>
  <!-- Header -->
  <div class="fixed top-4 left-1/2 -translate-x-1/2 z-40 glass px-5 py-2 rounded-2xl text-slate-100 text-sm">
    ชี้นิ้วเพื่อเล็ง • บีบ (Pinch) เพื่อกดปุ่ม • รองรับคลิกเมาส์ตามปกติ
  </div>

  <!-- Buttons -->
  <main class="h-full w-full grid place-items-center">
    <div class="glass rounded-3xl p-6 sm:p-8 w-[92vw] max-w-[680px]">
      <h1 class="text-xl sm:text-2xl font-extrabold text-slate-100 mb-4">เดโม: ควบคุมปุ่มด้วยมือ</h1>
      <p class="text-slate-300 mb-6 text-sm">เล็งเคอร์เซอร์ (นิ้วชี้) ไปเหนือปุ่ม แล้วบีบหัวแม่มือกับนิ้วชี้เพื่อกด</p>
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <button id="btnA" class="btn3">🔥 ปุ่ม A</button>
        <button id="btnB" class="btn3">🌊 ปุ่ม B</button>
        <button id="btnC" class="btn3">🌱 ปุ่ม C</button>
      </div>
    </div>
  </main>

  <!-- Hidden video for MediaPipe -->
  <video id="webcamVideo" playsinline muted></video>
  <!-- Hand cursor -->
  <div id="handCursor"></div>

  <!-- Overlay: enable camera -->
  <div id="overlay">
    <div class="text-center">
      <div class="text-lg font-semibold mb-2">เปิดกล้องเพื่อเริ่ม</div>
      <div class="text-sm text-slate-400 mb-4">แนะนำให้เปิดด้วย Safari และใช้ HTTPS หรือ localhost</div>
      <button id="enableBtn" class="px-5 py-2 rounded-xl bg-cyan-400 text-slate-900 font-bold">Enable Camera</button>
      <div id="errMsg" class="text-rose-300 text-sm mt-3" style="display:none;"></div>
    </div>
  </div>

  <script>
    // ---- iOS/WebKit shim so navigator.mediaDevices.getUserMedia exists
    (function ensureMediaDevices(){
      if (typeof navigator.mediaDevices === 'undefined') navigator.mediaDevices = {};
      if (!navigator.mediaDevices.getUserMedia) {
        const legacy = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
        if (legacy) {
          navigator.mediaDevices.getUserMedia = (c)=>new Promise((res,rej)=>legacy.call(navigator,c,res,rej));
        }
      }
    })();
  </script>

  <script>
    // UI refs
    const btnA = document.getElementById('btnA');
    const btnB = document.getElementById('btnB');
    const btnC = document.getElementById('btnC');
    const overlay = document.getElementById('overlay');
    const enableBtn = document.getElementById('enableBtn');
    const errMsg = document.getElementById('errMsg');
    const cursorEl = document.getElementById('handCursor');
    const videoEl = document.getElementById('webcamVideo');

    // Popups (also used for normal clicks)
    function fireA(){ Swal.fire({ icon:'success', title:'ปุ่ม A', text:'คุณกดปุ่ม A ด้วยมือ!', confirmButtonText:'เยี่ยม' }); }
    function fireB(){ Swal.fire({ icon:'info', title:'ปุ่ม B', text:'นี่คือปุ่ม B — น้ำเย็นชื่นใจ', confirmButtonText:'ตกลง' }); }
    function fireC(){ Swal.fire({ icon:'question', title:'ปุ่ม C', text:'ถามใจดู… C จะไปทางไหน?', confirmButtonText:'ไปต่อ' }); }

    // Mouse fallback
    btnA.addEventListener('click', fireA);
    btnB.addEventListener('click', fireB);
    btnC.addEventListener('click', fireC);

    // Hand state
    let cursorX = innerWidth/2, cursorY = innerHeight/2;
    let targetX = cursorX, targetY = cursorY;
    let isPinching = false;
    const PINCH_THRESHOLD = 40; // px on the processed video frame
    const lerp = (a,b,t)=>a+(b-a)*t;
    let lastPinch = false; // for edge-trigger

    // Hover detection utils
    const buttons = [
      {el:btnA, action:fireA},
      {el:btnB, action:fireB},
      {el:btnC, action:fireC},
    ];
    function hoveredButtonAt(x,y){
      for (const b of buttons){
        const r = b.el.getBoundingClientRect();
        if (x>=r.left && x<=r.right && y>=r.top && y<=r.bottom) return b;
      }
      return null;
    }
    function setHover(el, on){
      el.classList.toggle('hoverGlow', !!on);
    }

    // Start camera + mediapipe
    enableBtn.addEventListener('click', async () => {
      try {
        // Request camera
        const stream = await navigator.mediaDevices.getUserMedia({
          video: { facingMode:'user', width:{ideal:640}, height:{ideal:480} }, audio:false
        });
        videoEl.srcObject = stream;
        await videoEl.play();

        // MediaPipe Hands
        const hands = new Hands({ locateFile: (f)=>`https://cdn.jsdelivr.net/npm/@mediapipe/hands/${f}` });
        hands.setOptions({
          maxNumHands:1, modelComplexity:1, minDetectionConfidence:0.6, minTrackingConfidence:0.6
        });
        hands.onResults(onHandResults);

        const cam = new Camera(videoEl, {
          onFrame: async () => { await hands.send({ image: videoEl }); },
          width: 640, height: 480
        });
        cam.start();

        overlay.style.display = 'none';
      } catch (e) {
        errMsg.style.display='block';
        errMsg.textContent = 'ไม่สามารถเปิดกล้องได้: ' + (e?.message || e);
      }
    });

    // MediaPipe callback
    function onHandResults(results){
      const lmArr = results.multiHandLandmarks;
      if (!lmArr || lmArr.length === 0){
        cursorEl.style.transform = 'translate3d(-9999px,-9999px,0)';
        buttons.forEach(b=>setHover(b.el,false));
        lastPinch = false;
        return;
      }

      const lm = lmArr[0];
      const idx = lm[8];  // index tip
      const thb = lm[4];  // thumb tip

      // Map normalized [0..1] to viewport
      targetX = idx.x * innerWidth;
      targetY = idx.y * innerHeight;
      // Smooth
      cursorX = lerp(cursorX, targetX, 0.35);
      cursorY = lerp(cursorY, targetY, 0.35);
      cursorEl.style.transform = `translate3d(${cursorX}px, ${cursorY}px, 0)`;

      // Pinch detection (use video space)
      const W = results.image.width, H = results.image.height;
      const dpx = Math.hypot((idx.x - thb.x)*W, (idx.y - thb.y)*H);
      isPinching = dpx < PINCH_THRESHOLD;
      cursorEl.classList.toggle('pinch', isPinching);

      // Hover highlight
      const hovered = hoveredButtonAt(cursorX, cursorY);
      buttons.forEach(b=>setHover(b.el, hovered && b.el===hovered.el));

      // Edge-triggered "click" on pinch start
      if (isPinching && !lastPinch && hovered){
        hovered.action();
      }
      lastPinch = isPinching;
    }

    // Keep cursor visible on resize
    addEventListener('resize', ()=> {
      cursorX = Math.min(Math.max(cursorX, 0), innerWidth);
      cursorY = Math.min(Math.max(cursorY, 0), innerHeight);
      cursorEl.style.transform = `translate3d(${cursorX}px, ${cursorY}px, 0)`;
    });
  </script>
</body>
</html>
