<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="utf-8" />
  <title>Earth + Hand Gestures — Three.js x MediaPipe (Single File)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Google Font: Sarabun -->
  <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;800&display=swap" rel="stylesheet">
  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sarabun: ['Sarabun','system-ui','sans-serif'] },
          colors: { glass:'rgba(15,23,42,0.35)', glassLine:'rgba(148,163,184,0.25)' },
          boxShadow: { glass:'0 10px 40px rgba(2,8,23,.35)' }
        }
      }
    }
  </script>

  <!-- Three.js ES Modules -->
  <script type="importmap">
  { "imports": {
      "three":"https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.module.js",
      "three/addons/":"https://cdn.jsdelivr.net/npm/three@0.160.0/examples/jsm/"
  } }
  </script>

  <!-- MediaPipe Hands -->
  <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils/drawing_utils.js"></script>

  <style>
    :root{ --cyan:#00FFFF; --orange:#FF8A00; --yellow:#ffd54a; }
    html,body{ height:100%; background: radial-gradient(1200px 800px at 20% 10%, #0b1020 0%, #05070f 60%, #03040a 100%); }
    body{ margin:0; overflow:hidden; font-family:'Sarabun',system-ui,-apple-system,Segoe UI,Roboto,sans-serif; }
    .glass{ background:rgba(13,17,23,.45); border:1px solid rgba(148,163,184,.2); backdrop-filter:blur(14px) saturate(130%); -webkit-backdrop-filter:blur(14px) saturate(130%); box-shadow:0 8px 40px rgba(2,8,23,.35); }
    #handCursor{ position:fixed; left:0; top:0; width:18px; height:18px; margin-left:-9px; margin-top:-9px; border-radius:50%; border:2px solid var(--cyan); background:rgba(0,255,255,.08); box-shadow:0 0 14px rgba(0,255,255,.65); pointer-events:none; z-index:50; transform:translate3d(0,0,0); }
    #handCursor.pinch{ border-color:var(--orange); box-shadow:0 0 14px rgba(255,138,0,.75); background:rgba(255,138,0,.12); }
    #hoverTooltip{ position:fixed; left:0; top:0; transform:translate3d(12px,18px,0); pointer-events:none; z-index:60; display:none; }
    #loadingOverlay{ position:fixed; inset:0; z-index:80; display:grid; place-items:center; background: radial-gradient(1200px 800px at 50% 30%, rgba(9,12,20,.68) 0%, rgba(5,7,14,.88) 50%, rgba(3,4,10,1) 100%); backdrop-filter:blur(6px); }
    #webcamCanvas{ width:100%; height:auto; border-radius:12px; border:1px solid rgba(255,255,255,.08); transform:scaleX(-1); background:#0b1120; }
    .panel-scroll{ overflow:auto; max-height:40vh; }
    #webcamVideo {
        display: none !important;
        visibility: hidden !important;
        width: 0 !important;
        height: 0 !important;
        opacity: 0 !important;
        position: fixed !important;
        pointer-events: none !important;
    }
  </style>
  
</head>
<body>
  <canvas id="threeCanvas" class="absolute inset-0"></canvas>

  <div class="pointer-events-none fixed top-4 left-1/2 -translate-x-1/2 z-30">
    <div class="glass text-slate-100 px-6 py-2 rounded-2xl text-sm shadow-glass">
      🌍 หมุนโลกด้วยนิ้ว • ชี้เพื่อเลือกเมือง • บีบนิ้ว (Pinch) เพื่อหมุนโลก
    </div>
  </div>

  <!-- Left Panel -->
  <div class="fixed left-4 bottom-4 z-40 max-w-sm w-[360px]" style="display:none;">
    <div class="glass rounded-2xl shadow-glass p-4 space-y-3">
      <div class="flex items-center justify-between">
        <div class="text-slate-100 font-semibold">การควบคุมด้วยมือ</div>
        <div class="text-xs text-slate-300/80">Webcam</div>
      </div>
      <div class="panel-scroll">
        <p class="text-slate-200/90 text-sm leading-relaxed">
          • แตะปุ่ม “เปิดกล้อง” ด้านล่างเพื่อเริ่ม<br/>
          • ชี้นิ้วชี้เพื่อเลื่อนเคอร์เซอร์<br/>
          • บีบนิ้วหัวแม่มือกับนิ้วชี้เพื่อล็อกหมุนโลก (เคอร์เซอร์เป็นสีส้ม)<br/>
          • เลื่อนมือขณะบีบเพื่อหมุนโลก
        </p>
      </div>
      <video id="webcamVideo" class="hidden" playsinline muted></video>
      <canvas id="webcamCanvas"></canvas>
    </div>
  </div>

  <!-- Right Panel -->
  <div class="fixed right-4 bottom-4 z-40 max-w-sm w-[360px]">
    <div class="glass rounded-2xl shadow-glass p-4">
      <div class="flex items-center justify-between mb-2">
        <div class="text-slate-100 font-semibold">ข้อมูลเมือง</div>
        <div class="text-xs text-slate-300/80">เวลาแบบท้องถิ่น</div>
      </div>
      <div id="cityInfo" class="text-slate-100 space-y-2">
        <div class="text-lg font-extrabold" id="infoCity">—</div>
        <div class="text-sm text-slate-300" id="infoCountry">—</div>
        <div class="flex items-center justify-between text-sm">
          <div class="text-slate-400">เวลา</div><div class="font-semibold" id="infoTime">—</div>
        </div>
        <div class="flex items-center justify-between text-sm">
          <div class="text-slate-400">ระยะทางจากกรุงเทพฯ</div><div class="font-semibold" id="infoDistance">—</div>
        </div>
        <div class="flex items-center justify-between text-sm">
          <div class="text-slate-400">พิกัด</div><div class="font-semibold" id="infoCoords">—</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Tooltip -->
  <div id="hoverTooltip" class="glass rounded-xl px-3 py-2 text-xs text-slate-100 shadow-glass">
    <div id="tooltipCity" class="font-semibold">—</div>
    <div id="tooltipTime" class="text-slate-300">—</div>
  </div>

  <!-- Cursor -->
  <div id="handCursor"></div>

  <!-- Loading / Permission -->
  <div id="loadingOverlay" class="text-center">
    <div class="space-y-3">
      <div class="text-slate-200 text-xl font-semibold">กำลังเตรียมโมเดลมือ…</div>
      <div class="text-slate-400 mb-3">โปรดเปิดด้วย Safari และใช้ https</div>
      <button id="enableCamBtn"
        class="px-5 py-2 rounded-xl bg-cyan-500/90 hover:bg-cyan-400 text-slate-900 font-semibold shadow-glass">
        เปิดกล้อง (Enable Camera)
      </button>
      <div id="httpsWarn" class="text-rose-300 text-sm mt-2 hidden">ต้องเป็น https หรือ localhost เท่านั้น</div>
      <div id="webviewWarn" class="text-amber-300 text-sm mt-1 hidden">หากอยู่ในแอปฝังเว็บ ให้เปิดใน Safari</div>
    </div>
  </div>

  <script type="module">
    import * as THREE from 'three';

    /* ---------- iOS/Safari getUserMedia readiness: shim + environment checks ---------- */
    // Legacy shim for older WebKit
    (function ensureMediaDevices(){
      if (typeof navigator.mediaDevices === 'undefined') navigator.mediaDevices = {};
      if (!navigator.mediaDevices.getUserMedia) {
        const legacy = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
        if (legacy) {
          navigator.mediaDevices.getUserMedia = (constraints) =>
            new Promise((res, rej) => legacy.call(navigator, constraints, res, rej));
        }
      }
    })();

    const isSecure = window.isSecureContext || location.protocol === 'https:' || location.hostname === 'localhost';
    const isInWebView = (() => {
      const ua = navigator.userAgent || '';
      // Heuristic: many in-app browsers identify as "Mobile/.. Safari" but lack "Version/"
      const iOS = /iP(hone|ad|od)/.test(ua);
      const webkit = /AppleWebKit/.test(ua) && !/Chrome\/|CriOS/.test(ua);
      const standalone = navigator.standalone || window.matchMedia('(display-mode: standalone)').matches;
      return iOS && webkit && !/Version\/\d+/.test(ua) && !standalone;
    })();

    const httpsWarn = document.getElementById('httpsWarn');
    const webviewWarn = document.getElementById('webviewWarn');
    if (!isSecure) httpsWarn.classList.remove('hidden');
    if (isInWebView) webviewWarn.classList.remove('hidden');

    /* ----------------------------- DOM references ----------------------------- */
    const canvas = document.getElementById('threeCanvas');
    const handCursor = document.getElementById('handCursor');
    const hoverTooltip = document.getElementById('hoverTooltip');
    const tooltipCity = document.getElementById('tooltipCity');
    const tooltipTime = document.getElementById('tooltipTime');
    const infoCity = document.getElementById('infoCity');
    const infoCountry = document.getElementById('infoCountry');
    const infoTime = document.getElementById('infoTime');
    const infoDistance = document.getElementById('infoDistance');
    const infoCoords = document.getElementById('infoCoords');
    const webcamVideo = document.getElementById('webcamVideo');
    const webcamCanvas = document.getElementById('webcamCanvas');
    const wctx = webcamCanvas.getContext('2d');
    const enableBtn = document.getElementById('enableCamBtn');

    /* --------------------------- Three.js setup core -------------------------- */
    const renderer = new THREE.WebGLRenderer({ canvas, antialias: true });
    renderer.setPixelRatio(Math.min(devicePixelRatio, 2));
    renderer.setSize(window.innerWidth, window.innerHeight);
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(55, window.innerWidth / window.innerHeight, 0.1, 2000);
    camera.position.set(0, 0, 8);

    const ambient = new THREE.AmbientLight(0x404040, 1.4); scene.add(ambient);
    const sun = new THREE.DirectionalLight(0xffffff, 1.15); sun.position.set(5, 2, 4); scene.add(sun);

    const earthGroup = new THREE.Group(); scene.add(earthGroup);

    /* -------------------------------- Starfield ------------------------------- */
    function createStars(count=3000, radius=900){
      const geom = new THREE.BufferGeometry();
      const positions = new Float32Array(count*3);
      for (let i=0;i<count;i++){
        const r = radius*(0.7+Math.random()*0.3);
        const theta = Math.acos(THREE.MathUtils.randFloatSpread(2));
        const phi = THREE.MathUtils.randFloat(0, Math.PI*2);
        positions[i*3+0]= r*Math.sin(theta)*Math.cos(phi);
        positions[i*3+1]= r*Math.cos(theta);
        positions[i*3+2]= r*Math.sin(theta)*Math.sin(phi);
      }
      geom.setAttribute('position', new THREE.BufferAttribute(positions,3));
      const mat = new THREE.PointsMaterial({ size:0.8, color:0x99bbff, transparent:true, opacity:0.9, depthWrite:false });
      scene.add(new THREE.Points(geom, mat));
    }
    createStars();

    /* ------------------------- Texture loader + fallback ---------------------- */
    const loader = new THREE.TextureLoader();
    const URLS = {
      map:'https://threejs.org/examples/textures/planets/earth_atmos_2048.jpg',
      specular:'https://threejs.org/examples/textures/planets/earth_specular_2048.jpg',
      normal:'https://threejs.org/examples/textures/planets/earth_normal_2048.jpg',
      clouds:'https://threejs.org/examples/textures/planets/earth_clouds_1024.png'
    };
    function generateNoiseTexture(w=1024,h=512){
      const c=document.createElement('canvas'); c.width=w; c.height=h;
      const ctx=c.getContext('2d'); const img=ctx.createImageData(w,h);
      for(let i=0;i<img.data.length;i+=4){
        const n=Math.floor(THREE.MathUtils.randFloat(0,255));
        img.data[i]=n*0.4; img.data[i+1]=n*0.6+10; img.data[i+2]=n*0.8+20; img.data[i+3]=255;
      }
      ctx.putImageData(img,0,0);
      ctx.globalAlpha=0.35;
      for(let k=0;k<60;k++){
        const cx=Math.random()*w, cy=Math.random()*h, rad=Math.random()*40+20;
        const grd=ctx.createRadialGradient(cx,cy,2,cx,cy,rad);
        grd.addColorStop(0,'rgba(178,220,170,1)'); grd.addColorStop(1,'rgba(178,220,170,0)');
        ctx.fillStyle=grd; ctx.beginPath(); ctx.arc(cx,cy,rad,0,Math.PI*2); ctx.fill();
      }
      const tex=new THREE.CanvasTexture(c); tex.colorSpace=THREE.SRGBColorSpace; tex.wrapS=tex.wrapT=THREE.RepeatWrapping; return tex;
    }
    function loadTextureWithFallback(url,options={}){
      return new Promise((resolve)=>{
        let done=false;
        loader.load(url,(tex)=>{ if(done)return; done=true; tex.colorSpace=THREE.SRGBColorSpace; if(options.wrap) tex.wrapS=tex.wrapT=THREE.RepeatWrapping; resolve(tex); },
          undefined, ()=>{ if(done)return; done=true; resolve(generateNoiseTexture()); });
        setTimeout(()=>{ if(!done){ done=true; resolve(generateNoiseTexture()); }},8000);
      });
    }

    const EARTH_RADIUS=2.2;
    const [earthMap, earthSpec, earthNormal, cloudTex] = await Promise.all([
      loadTextureWithFallback(URLS.map),
      loadTextureWithFallback(URLS.specular),
      loadTextureWithFallback(URLS.normal),
      loadTextureWithFallback(URLS.clouds)
    ]);

    const earthMat = new THREE.MeshPhongMaterial({
      map: earthMap, specularMap: earthSpec, specular:new THREE.Color(0x303030),
      shininess:12, normalMap: earthNormal, normalScale: new THREE.Vector2(0.6,0.6)
    });
    const earthMesh = new THREE.Mesh(new THREE.SphereGeometry(EARTH_RADIUS,96,96), earthMat);
    earthGroup.add(earthMesh);

    const cloudMat = new THREE.MeshLambertMaterial({ map:cloudTex, transparent:true, opacity:0.8, depthWrite:false });
    const cloudMesh = new THREE.Mesh(new THREE.SphereGeometry(EARTH_RADIUS*1.01,96,96), cloudMat);
    earthGroup.add(cloudMesh);

    /* ---------------------------- Atmosphere shader --------------------------- */
    const atmosphere = new THREE.Mesh(
      new THREE.SphereGeometry(EARTH_RADIUS*1.08,96,96),
      new THREE.ShaderMaterial({
        uniforms:{
          glowColor:{ value:new THREE.Color(0x3aa8ff) },
          viewVector:{ value:new THREE.Vector3().subVectors(camera.position, earthMesh.position) }
        },
        vertexShader:`
          uniform vec3 viewVector; varying float intensity;
          void main(){
            vec3 vNormal = normalize(normalMatrix * normal);
            vec3 vNormView = normalize(normalMatrix * viewVector);
            intensity = pow(0.6 - dot(vNormal, vNormView), 2.0);
            gl_Position = projectionMatrix * modelViewMatrix * vec4(position,1.0);
          }`,
        fragmentShader:`uniform vec3 glowColor; varying float intensity;
          void main(){ gl_FragColor = vec4(glowColor*intensity, intensity*0.9); }`,
        side:THREE.BackSide, blending:THREE.AdditiveBlending, transparent:true, depthWrite:false
      })
    );
    earthGroup.add(atmosphere);

    /* --------------------------------- Cities -------------------------------- */
    const deg2rad = d => d*Math.PI/180;
    function latLonToVector3(lat, lon, radius){
      const phi=deg2rad(90-lat), theta=deg2rad(lon+180);
      const x=-(radius*Math.sin(phi)*Math.cos(theta));
      const z= radius*Math.sin(phi)*Math.sin(theta);
      const y= radius*Math.cos(phi);
      return new THREE.Vector3(x,y,z);
    }
    const cities = [
      { name:'Bangkok', country:'Thailand', lat:13.7563, lon:100.5018, tz:'Asia/Bangkok' },
      { name:'Tokyo', country:'Japan', lat:35.6895, lon:139.6917, tz:'Asia/Tokyo' },
      { name:'New York', country:'USA', lat:40.7128, lon:-74.0060, tz:'America/New_York' },
      { name:'London', country:'UK', lat:51.5074, lon:-0.1278, tz:'Europe/London' },
      { name:'Paris', country:'France', lat:48.8566, lon:2.3522, tz:'Europe/Paris' },
      { name:'Sydney', country:'Australia', lat:-33.8688, lon:151.2093, tz:'Australia/Sydney' },
      { name:'Cape Town', country:'South Africa', lat:-33.9249, lon:18.4241, tz:'Africa/Johannesburg' },
      { name:'Rio de Janeiro', country:'Brazil', lat:-22.9068, lon:-43.1729, tz:'America/Sao_Paulo' },
      { name:'Moscow', country:'Russia', lat:55.7558, lon:37.6173, tz:'Europe/Moscow' },
      { name:'Dubai', country:'UAE', lat:25.2048, lon:55.2708, tz:'Asia/Dubai' }
    ];
    const cityGroup=new THREE.Group(); earthGroup.add(cityGroup);
    const markerData=[];
    function createCityMarker(city){
      const pos=latLonToVector3(city.lat,city.lon,EARTH_RADIUS+0.01);
      const ring=new THREE.Mesh(new THREE.RingGeometry(0.045,0.065,32),
        new THREE.MeshBasicMaterial({ color:0xffd54a, side:THREE.DoubleSide, transparent:true, opacity:0.9 }));
      const dot=new THREE.Mesh(new THREE.SphereGeometry(0.026,16,16),
        new THREE.MeshBasicMaterial({ color:0xffd54a }));
      const marker=new THREE.Group(); marker.add(ring); marker.add(dot);
      marker.position.copy(pos); marker.lookAt(new THREE.Vector3(0,0,0));
      marker.position.add(pos.clone().normalize().multiplyScalar(0.02));
      cityGroup.add(marker);
      markerData.push({ city, marker, screen:new THREE.Vector2() });
    }
    cities.forEach(createCityMarker);

    /* --------------------------- Haversine distance --------------------------- */
    function haversineKm(lat1,lon1,lat2,lon2){
      const R=6371, dLat=deg2rad(lat2-lat1), dLon=deg2rad(lon2-lon1);
      const a=Math.sin(dLat/2)**2 + Math.cos(deg2rad(lat1))*Math.cos(deg2rad(lat2))*Math.sin(dLon/2)**2;
      return R*2*Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    }
    const bangkok=cities.find(c=>c.name==='Bangkok');

    /* ----------------------- Hand tracking (start on tap) --------------------- */
    let modelReady=false, cameraUtils=null;

    const hands = new Hands({ locateFile: (f)=>`https://cdn.jsdelivr.net/npm/@mediapipe/hands/${f}` });
    hands.setOptions({
      maxNumHands:1, modelComplexity:1,
      minDetectionConfidence:0.6, minTrackingConfidence:0.6
    });
    hands.onResults(onHandResults);

    async function startCamera() {
      if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        alert('อุปกรณ์นี้ไม่รองรับกล้องในเบราว์เซอร์นี้ กรุณาเปิดด้วย Safari และใช้ HTTPS');
        return;
      }
      // Request the stream first (user gesture friendly)
      const stream = await navigator.mediaDevices.getUserMedia({ video:{ facingMode:'user', width:{ideal:640}, height:{ideal:480} }, audio:false });
      webcamVideo.srcObject = stream;
      await webcamVideo.play();

      // Now start MediaPipe camera loop
      cameraUtils = new Camera(webcamVideo, {
        onFrame: async () => { await hands.send({ image: webcamVideo }); },
        width: 640, height: 480
      });
      cameraUtils.start();
      document.getElementById('loadingOverlay').style.display='none';
    }

    enableBtn.addEventListener('click', async ()=>{
      try { await startCamera(); }
      catch (e) {
        console.error(e);
        alert('ไม่สามารถเปิดกล้องได้: ' + e.message + '\nตรวจสอบว่าเป็น HTTPS และอนุญาตสิทธิ์กล้องแล้ว');
      }
    });

    // Cursor + pinch state
    let cursorX=innerWidth*0.5, cursorY=innerHeight*0.5, targetX=cursorX, targetY=cursorY;
    const lerp=(a,b,t)=>a+(b-a)*t;
    const PINCH_THRESHOLD_PX=40;
    let isPinching=false, lastPinchScreen=null;
    let rotationVel=new THREE.Vector2(0,0), inertia=0.94;

    function onHandResults(results){
      modelReady=true;
      const W = results.image.width, H = results.image.height;
      webcamCanvas.width=W; webcamCanvas.height=H;
      // Mirror draw
      wctx.save(); wctx.clearRect(0,0,W,H); wctx.translate(W,0); wctx.scale(-1,1); wctx.drawImage(results.image,0,0,W,H); wctx.restore();

      if (!results.multiHandLandmarks || !results.multiHandLandmarks.length) { handCursor.classList.remove('pinch'); return; }
      const lm = results.multiHandLandmarks[0];
      const idx=lm[8], thb=lm[4];

      targetX = idx.x * innerWidth;
      targetY = idx.y * innerHeight;
      cursorX = lerp(cursorX, targetX, 0.35);
      cursorY = lerp(cursorY, targetY, 0.35);
      handCursor.style.transform = `translate3d(${cursorX}px, ${cursorY}px, 0)`;

      const dpx = Math.hypot((idx.x - thb.x)*W, (idx.y - thb.y)*H);
      const pinching = dpx < PINCH_THRESHOLD_PX;
      if (pinching && !isPinching) lastPinchScreen = new THREE.Vector2(cursorX,cursorY);
      isPinching = pinching;
      handCursor.classList.toggle('pinch', isPinching);

      if (isPinching && lastPinchScreen) {
        const now = new THREE.Vector2(cursorX, cursorY);
        const delta = now.clone().sub(lastPinchScreen);
        lastPinchScreen.copy(now);

        const rotScale = 0.0032;
        // flip horizontal direction to match mirrored hand
        earthGroup.rotation.y += delta.x * rotScale;  
        earthGroup.rotation.x += -delta.y * rotScale;
        rotationVel.set(delta.x * rotScale, -delta.y * rotScale);
        }
    }

    /* ------------------------- Hover detection (cities) ------------------------ */
    let hoveredCityData=null;
    function updateCityScreens(){
      const w=innerWidth, h=innerHeight;
      markerData.forEach(md=>{
        const v=md.marker.getWorldPosition(new THREE.Vector3());
        v.project(camera);
        md.screen.set((v.x*0.5+0.5)*w, (-v.y*0.5+0.5)*h);
      });
    }
    function cityAtCursor(){
      let nearest=null, minD=24;
      markerData.forEach(md=>{
        const d=Math.hypot(md.screen.x-cursorX, md.screen.y-cursorY);
        if(d<minD){minD=d; nearest=md;}
      });
      return nearest;
    }
    function formatKm(km){ return km<1000 ? `${km.toFixed(0)} กม.` : `${(km/1000).toFixed(2)} พันกม.`; }
    function localTimeString(tz){
      try{
        return new Intl.DateTimeFormat('th-TH',{ timeZone:tz, hour:'2-digit', minute:'2-digit', second:'2-digit' }).format(new Date());
      }catch{ return new Date().toLocaleTimeString('th-TH'); }
    }
    function updateInfoPanel(md){
      if(!md){ infoCity.textContent='—'; infoCountry.textContent='—'; infoTime.textContent='—'; infoDistance.textContent='—'; infoCoords.textContent='—'; return; }
      const c=md.city;
      infoCity.textContent=c.name;
      infoCountry.textContent=c.country;
      infoTime.textContent=localTimeString(c.tz);
      infoCoords.textContent=`${c.lat.toFixed(4)}, ${c.lon.toFixed(4)}`;
      const dist=haversineKm(cities[0].lat, cities[0].lon, c.lat, c.lon);
      infoDistance.textContent=formatKm(dist);
    }

    /* ------------------------------ Animation loop ---------------------------- */
    function animate(){
      requestAnimationFrame(animate);
      // slow cloud drift
      // atmosphere update
      // inertia
      // hover
      cloudMesh.rotation.y += 0.0004;
      atmosphere.material.uniforms.viewVector.value.subVectors(camera.position, atmosphere.position);
      if(!isPinching){
        earthGroup.rotation.y += rotationVel.x;
        earthGroup.rotation.x += rotationVel.y;
        rotationVel.multiplyScalar(inertia);
      }
      updateCityScreens();
      const hit=cityAtCursor();
      markerData.forEach(md=>{
        const s = md===hit ? 1.35 : 1.0;
        md.marker.scale.lerp(new THREE.Vector3(s,s,s), 0.2);
        const ring=md.marker.children[0].material, dot=md.marker.children[1].material;
        if(md===hit){ ring.color.setHex(0xffffff); dot.color.setHex(0xffffff); }
        else { ring.color.setHex(0xffd54a); dot.color.setHex(0xffd54a); }
      });
      if(hit){
        hoveredCityData=hit;
        hoverTooltip.style.display='block';
        hoverTooltip.style.transform=`translate3d(${cursorX+12}px,${cursorY+18}px,0)`;
        tooltipCity.textContent=hit.city.name;
        tooltipTime.textContent=localTimeString(hit.city.tz);
        updateInfoPanel(hit);
      } else {
        hoveredCityData=null; hoverTooltip.style.display='none'; updateInfoPanel(null);
      }
      renderer.render(scene,camera);
    }
    animate();

    /* ------------------------------- Resize logic ----------------------------- */
    function onResize(){
      const w=innerWidth, h=innerHeight;
      renderer.setSize(w,h); camera.aspect=w/h; camera.updateProjectionMatrix();
    }
    window.addEventListener('resize', onResize);

    /* --------------------------- Initial camera tilt -------------------------- */
    earthGroup.rotation.x = 0.2; earthGroup.rotation.y = -0.8;

    // Auto-hide overlay as a fallback hint after 10s if user already started
    setTimeout(()=>{ if (document.getElementById('loadingOverlay').style.display!=='none') { /* waiting for user tap */ } }, 10000);
  </script>
</body>
</html>
