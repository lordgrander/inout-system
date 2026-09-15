<!DOCTYPE html>
<html lang="lo">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('/images/favicon.svg') }}">
    @php($routePrefix = $routePrefix ?? 'new-enter')
    @php($loginLabel = $loginLabel ?? 'Old Enter')
    <title>{{ $loginLabel }} Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root{--navy:#061b3a;--navy2:#0b2f63;--red:#d62828;--bg:#f3f6fb;--muted:#6b7280;--line:#d8e0ee}
        *{box-sizing:border-box;font-family:"Noto Sans Lao",ui-sans-serif,system-ui,sans-serif}
        body{margin:0;min-height:100vh;background:var(--bg);color:#10233f}
        button,input{font:inherit}
        button{cursor:pointer}
        .login-wrapper{min-height:100vh;display:grid;grid-template-columns:1.05fr .95fr}
        .brand-panel{position:relative;overflow:hidden;color:#fff;display:flex;align-items:center;justify-content:center;padding:48px;background:linear-gradient(135deg,rgba(6,27,58,.96),rgba(11,47,99,.84))}
        .brand-panel:before{content:"";position:absolute;inset:-20%;background:radial-gradient(circle at 28% 18%,rgba(255,255,255,.10),transparent 28%),radial-gradient(circle at 74% 80%,rgba(255,255,255,.08),transparent 32%);transform:rotate(-8deg)}
        .brand-content{position:relative;z-index:1;max-width:620px;text-align:center}
        .emblem,.mobile-logo{overflow:hidden;border-radius:50%;background:#fff;box-shadow:0 18px 45px rgba(0,0,0,.25)}
        .emblem{width:140px;height:140px;margin:0 auto 26px;border:5px solid rgba(255,255,255,.35);padding:10px}
        .mobile-logo{width:92px;height:92px;margin:0 auto 18px;padding:7px;box-shadow:0 12px 30px rgba(6,27,58,.22)}
        .emblem img,.mobile-logo img{width:100%;height:100%;object-fit:contain}
        .brand-title{margin:0 0 12px;font-size:42px;font-weight:800;line-height:1.25;color:#fff}
        .brand-subtitle{margin:0 0 24px;font-size:22px;font-weight:600;opacity:.92}
        .brand-english{margin:0 0 28px;font-size:21px;font-weight:700;opacity:.92}
        .system-badge{display:inline-flex;align-items:center;justify-content:center;gap:10px;border:1px solid rgba(255,255,255,.22);border-radius:999px;background:rgba(255,255,255,.12);padding:12px 22px;font-weight:700;backdrop-filter:blur(10px)}
        .feature-row{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-top:44px}
        .feature-item{border:1px solid rgba(255,255,255,.20);border-radius:18px;background:rgba(255,255,255,.10);padding:18px 10px;font-weight:700;backdrop-filter:blur(8px)}
        .feature-icon{width:46px;height:46px;border:1px solid rgba(255,255,255,.35);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 10px}
        .feature-icon svg,.system-badge svg,.input-icon svg,.password-eye svg,.btn-login svg,.btn-register svg,.modal-close svg{display:block}
        .form-panel{display:flex;align-items:center;justify-content:center;padding:36px;background:radial-gradient(circle at top right,rgba(11,47,99,.08),transparent 32%),#f7f9fd}
        .login-card{width:100%;max-width:485px;border:1px solid rgba(6,27,58,.06);border-radius:28px;background:#fff;padding:42px;box-shadow:0 24px 70px rgba(6,27,58,.15)}
        .login-title{margin:0 0 6px;color:var(--navy);font-size:34px;font-weight:800;text-align:center}
        .login-subtitle{margin:0 0 32px;color:var(--muted);text-align:center}
        .alert{border:1px solid #fecaca;border-radius:16px;background:#fef2f2;color:#b91c1c;padding:12px 14px;margin-bottom:18px;font-size:14px;font-weight:650}
        .alert.success{border-color:#bbf7d0;background:#f0fdf4;color:#166534}
        .form-field{margin-bottom:18px}
        .form-label{display:block;margin-bottom:9px;color:#111827;font-weight:700}
        .input-group-custom{position:relative}
        .input-icon{position:absolute;left:16px;top:50%;z-index:3;color:#64748b;transform:translateY(-50%)}
        .form-control{width:100%;height:56px;border:1px solid var(--line);border-radius:16px;background:#fff;padding:0 48px;color:#10233f;font-size:15px;outline:none;transition:.2s}
        .form-control:focus{border-color:var(--navy2);box-shadow:0 0 0 4px rgba(11,47,99,.12)}
        .password-eye{position:absolute;right:16px;top:50%;z-index:3;border:0;background:transparent;color:#64748b;padding:0;transform:translateY(-50%)}
        .form-row{display:flex;align-items:center;justify-content:space-between;gap:12px;margin:4px 0 24px}
        .remember{display:inline-flex;align-items:center;gap:8px;color:var(--muted)}
        .remember input{width:16px;height:16px;margin:0;accent-color:var(--navy2)}
        .forgot-link{color:var(--red);font-weight:700;text-decoration:none}
        .btn-login{width:100%;height:56px;border:0;border-radius:16px;background:linear-gradient(135deg,var(--navy),var(--navy2));color:#fff;font-size:17px;font-weight:800;display:flex;align-items:center;justify-content:center;gap:10px;box-shadow:0 14px 28px rgba(6,27,58,.22);transition:.2s}
        .btn-login:hover{background:linear-gradient(135deg,#08264f,var(--red));transform:translateY(-1px)}
        .divider{display:flex;align-items:center;gap:16px;margin:26px 0;color:#94a3b8;font-size:14px}
        .divider:before,.divider:after{content:"";flex:1;height:1px;background:#e2e8f0}
        .btn-register{width:100%;height:54px;border:1px solid var(--line);border-radius:16px;background:#fff;color:var(--navy);font-weight:800;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:10px}
        .btn-register:hover{border-color:var(--navy);background:#f8fbff}
        .footer-text{margin-top:26px;color:#64748b;font-size:13px;text-align:center}
        .register-modal{position:fixed;inset:0;z-index:80;display:none;align-items:center;justify-content:center;background:rgba(6,27,58,.34);padding:24px}
        .register-modal.show{display:flex}
        .register-card{width:min(555px,100%);max-height:calc(100vh - 48px);overflow-y:auto;border-radius:28px;background:#fff;padding:36px 38px;box-shadow:0 24px 70px rgba(6,27,58,.22);scrollbar-color:#a8b3c5 transparent;scrollbar-width:thin}
        .register-head{text-align:center;margin-bottom:28px}
        .register-title{margin:0 0 4px;color:var(--navy);font-size:32px;font-weight:800}
        .register-subtitle{margin:0;color:var(--muted);font-size:16px}
        .register-logo{width:82px;height:82px;border-radius:50%;background:#fff;margin:0 auto 18px;padding:7px;box-shadow:0 12px 30px rgba(6,27,58,.16)}
        .register-logo img{width:100%;height:100%;object-fit:contain}
        .modal-close{position:sticky;top:0;float:right;width:36px;height:36px;border:1px solid var(--line);border-radius:12px;background:#fff;color:#64748b;display:flex;align-items:center;justify-content:center;margin:-18px -18px 0 0}
        .file-control{padding-top:13px}
        .file-hint{margin:8px 0 0;color:#64748b;font-size:13px}
        .modal-actions{margin-top:22px}
        .back-login{margin-top:18px}
        @media(max-width:991px){.login-wrapper{grid-template-columns:1fr}.brand-panel{display:none}.form-panel{min-height:100vh;padding:20px}.login-card{padding:30px 22px;border-radius:24px}.login-title{font-size:28px}}
        @media(max-width:560px){.register-modal{padding:0}.register-card{min-height:100vh;max-height:100vh;border-radius:0;padding:28px 22px}.register-title{font-size:28px}}
    </style>
</head>
<body>
    <div class="login-wrapper">
        <section class="brand-panel">
            <div class="brand-content">
                <div class="emblem"><img src="{{ asset('image/thai_laos_middle.png') }}" alt="Friendship Bridge Logo"></div>
                <h1 class="brand-title">ດ່ານສາກົນຂົວມິດຕະພາບ</h1>
                <p class="brand-subtitle">ຈຸດບໍລິການທ່ານາແລ້ງ - ດົງໂພສີ</p>
                <p class="brand-english">Friendship Bridge International Checkpoint</p>
                <div class="system-badge">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 17h4V5H2v12h3"></path><path d="M14 8h4l4 4v5h-3"></path><circle cx="7.5" cy="17.5" r="2.5"></circle><circle cx="16.5" cy="17.5" r="2.5"></circle></svg>
                    ລະບົບຂໍອະນຸຍາດລົດບັນທຸກສິນຄ້າເຂົ້າ - ອອກດ່ານ
                </div>
                <div class="feature-row">
                    <div class="feature-item"><div class="feature-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.68 0C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m9 12 2 2 4-4"></path></svg></div><div>ປອດໄພ</div></div>
                    <div class="feature-item"><div class="feature-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg></div><div>ວ່ອງໄວ</div></div>
                    <div class="feature-item"><div class="feature-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="m9 15 2 2 4-4"></path></svg></div><div>ຖືກຕ້ອງ</div></div>
                    <div class="feature-item"><div class="feature-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></div><div>ໂປ່ງໃສ</div></div>
                </div>
            </div>
        </section>

        <section class="form-panel">
            <div class="login-card">
                <div class="mobile-logo"><img src="{{ asset('image/thai_laos_middle.png') }}" alt="Friendship Bridge Logo"></div>
                <h2 class="login-title">ເຂົ້າສູ່ລະບົບ</h2>
                <p class="login-subtitle">Login to your account</p>

                @if($errors->any())
                    <div class="alert">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @if(session('register_success'))
                    <div class="alert success">{{ session('register_success') }}</div>
                @endif

                <form method="POST" action="{{ route($routePrefix.'.login.store') }}">
                    @csrf
                    <div class="form-field">
                        <label class="form-label" for="email">ອີເມວ</label>
                        <div class="input-group-custom">
                            <span class="input-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a2 2 0 0 1-2.06 0L2 7"></path></svg></span>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control" placeholder="example@email.com" required autofocus autocomplete="username">
                        </div>
                    </div>

                    <div class="form-field">
                        <label class="form-label" for="password">ລະຫັດຜ່ານ</label>
                        <div class="input-group-custom">
                            <span class="input-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg></span>
                            <input id="password" name="password" type="password" class="form-control" placeholder="********" required autocomplete="current-password">
                            <button class="password-eye" type="button" onclick="togglePassword()" aria-label="Show password">
                                <svg id="eyeIcon" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.06 12.35a1 1 0 0 1 0-.7A10.75 10.75 0 0 1 12 5c4.6 0 8.53 2.82 9.94 6.65a1 1 0 0 1 0 .7A10.75 10.75 0 0 1 12 19c-4.6 0-8.53-2.82-9.94-6.65Z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </button>
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="remember"><input type="checkbox" name="remember"> ຈື່ຈໍາຂ້ອຍ</label>
                        <a href="#" class="forgot-link">ລືມລະຫັດຜ່ານ?</a>
                    </div>

                    <button type="submit" class="btn-login">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><path d="m10 17 5-5-5-5"></path><path d="M15 12H3"></path></svg>
                        ເຂົ້າລະບົບ
                    </button>
                </form>

                <div class="divider">ຫຼື</div>

                <button type="button" class="btn-register" id="openRegisterBtn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" x2="19" y1="8" y2="14"></line><line x1="22" x2="16" y1="11" y2="11"></line></svg>
                    ສ້າງບັນຊີໃໝ່
                </button>

                <div class="footer-text">© 2026 Friendship Bridge Permit System</div>
            </div>
        </section>
    </div>

    <div class="register-modal" id="registerModal">
        <div class="register-card">
            <button class="modal-close" type="button" id="closeRegisterBtn" aria-label="Close register form">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
            </button>

            <div class="register-head">
                <div class="register-logo"><img src="{{ asset('image/thai_laos_middle.png') }}" alt="Friendship Bridge Logo"></div>
                <h2 class="register-title">ສະໝັກຜູ້ໃຊ້</h2>
                <p class="register-subtitle">Register new user account</p>
            </div>

            <form method="POST" action="{{ route($routePrefix.'.register.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-field">
                    <label class="form-label" for="company_name">1. ຊື່ບໍລິສັດ</label>
                    <div class="input-group-custom">
                        <span class="input-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="16" height="20" x="4" y="2" rx="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path><path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M16 10h.01"></path><path d="M16 14h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path></svg></span>
                        <input class="form-control" id="company_name" name="company_name" value="{{ old('company_name') }}" placeholder="ປ້ອນຊື່ບໍລິສັດໃຫ້ຖືກຕ້ອງຕາມໃບທະບຽນວິສາຫະກິດ" required>
                    </div>
                </div>

                <div class="form-field">
                    <label class="form-label" for="owner_name">2. ຊື່ ແລະ ນາມສະກຸນ</label>
                    <div class="input-group-custom">
                        <span class="input-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 2H9a2 2 0 0 0-2 2v16l5-3 5 3V4a2 2 0 0 0-2-2Z"></path><circle cx="12" cy="8" r="2"></circle></svg></span>
                        <input class="form-control" id="owner_name" name="owner_name" value="{{ old('owner_name') }}" placeholder="ປ້ອນຊື່ ແລະ ນາມສະກຸນເຈົ້າຂອງບໍລິສັດ" required>
                    </div>
                </div>

                <div class="form-field">
                    <label class="form-label" for="company_phone">3. ເບີໂທບໍລິສັດ</label>
                    <div class="input-group-custom">
                        <span class="input-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.08 4.18 2 2 0 0 1 4.06 2h3a2 2 0 0 1 2 1.72c.12.9.33 1.77.62 2.61a2 2 0 0 1-.45 2.11L8 9.67a16 16 0 0 0 6.33 6.33l1.23-1.23a2 2 0 0 1 2.11-.45c.84.29 1.71.5 2.61.62A2 2 0 0 1 22 16.92Z"></path></svg></span>
                        <input class="form-control" id="company_phone" name="company_phone" value="{{ old('company_phone') }}" placeholder="020xxxxxxxx" required>
                    </div>
                </div>

                <div class="form-field">
                    <label class="form-label" for="register_name">4. ຊື່ຜູ້ໃຊ້ງານ</label>
                    <div class="input-group-custom">
                        <span class="input-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></span>
                        <input class="form-control" id="register_name" name="name" value="{{ old('name') }}" placeholder="ປ້ອນຊື່ຜູ້ໃຊ້ງານ" required>
                    </div>
                </div>

                <div class="form-field">
                    <label class="form-label" for="register_email">5. ອີເມວ</label>
                    <div class="input-group-custom">
                        <span class="input-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a2 2 0 0 1-2.06 0L2 7"></path></svg></span>
                        <input class="form-control" id="register_email" name="email" type="email" value="{{ old('email') }}" placeholder="example@email.com" required autocomplete="username">
                    </div>
                </div>

                <div class="form-field">
                    <label class="form-label" for="user_phone">6. ເບີໂທຜູ້ໃຊ້ງານ</label>
                    <div class="input-group-custom">
                        <span class="input-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="14" height="20" x="5" y="2" rx="2"></rect><path d="M12 18h.01"></path></svg></span>
                        <input class="form-control" id="user_phone" name="user_phone" value="{{ old('user_phone') }}" placeholder="020xxxxxxxx" required>
                    </div>
                </div>

                <div class="form-field">
                    <label class="form-label" for="document_files">7. ແນບເອກະສານ</label>
                    <div class="input-group-custom">
                        <span class="input-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 1 1-2.83-2.83l8.49-8.48"></path></svg></span>
                        <input class="form-control file-control" id="document_files" name="document_files[]" type="file" multiple accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                    <p class="file-hint">ແນບເອກະສານ ທະບຽນວິສາຫະກິດ ແລະ ໃບອາກອນ ຮອງຮັບໄຟລ໌ຮູບ JPG/PNG ຫຼື PDF</p>
                </div>

                <div class="form-field">
                    <label class="form-label" for="register_password">ລະຫັດຜ່ານ</label>
                    <div class="input-group-custom">
                        <span class="input-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg></span>
                        <input class="form-control" id="register_password" name="password" type="password" placeholder="********" required autocomplete="new-password">
                        <button class="password-eye" type="button" onclick="toggleFieldPassword('register_password','registerEyeIcon')" aria-label="Show password">
                            <svg id="registerEyeIcon" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.06 12.35a1 1 0 0 1 0-.7A10.75 10.75 0 0 1 12 5c4.6 0 8.53 2.82 9.94 6.65a1 1 0 0 1 0 .7A10.75 10.75 0 0 1 12 19c-4.6 0-8.53-2.82-9.94-6.65Z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>
                </div>

                <div class="form-field">
                    <label class="form-label" for="password_confirmation">ຢືນຢັນລະຫັດຜ່ານ</label>
                    <div class="input-group-custom">
                        <span class="input-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.68 0C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m9 12 2 2 4-4"></path></svg></span>
                        <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" placeholder="********" required autocomplete="new-password">
                        <button class="password-eye" type="button" onclick="toggleFieldPassword('password_confirmation','confirmEyeIcon')" aria-label="Show password">
                            <svg id="confirmEyeIcon" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.06 12.35a1 1 0 0 1 0-.7A10.75 10.75 0 0 1 12 5c4.6 0 8.53 2.82 9.94 6.65a1 1 0 0 1 0 .7A10.75 10.75 0 0 1 12 19c-4.6 0-8.53-2.82-9.94-6.65Z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="submit" class="btn-login">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" x2="19" y1="8" y2="14"></line><line x1="22" x2="16" y1="11" y2="11"></line></svg>
                        ສະໝັກຜູ້ໃຊ້
                    </button>
                </div>

                <div class="divider">ຫຼື</div>

                <button class="btn-register back-login" type="button" id="backLoginBtn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                    ກັບໄປໜ້າເຂົ້າລະບົບ
                </button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(){
            toggleFieldPassword('password', 'eyeIcon');
        }

        function toggleFieldPassword(inputId, iconId){
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if(input.type === 'password'){
                input.type = 'text';
                icon.innerHTML = '<path d="M17.94 17.94A10.85 10.85 0 0 1 12 19c-4.6 0-8.53-2.82-9.94-6.65a1 1 0 0 1 0-.7A10.74 10.74 0 0 1 5.17 7.3"></path><path d="M22 12a10.8 10.8 0 0 0-4.19-5.1"></path><path d="M14.12 14.12A3 3 0 0 1 9.88 9.88"></path><path d="m3 3 18 18"></path>';
            }else{
                input.type = 'password';
                icon.innerHTML = '<path d="M2.06 12.35a1 1 0 0 1 0-.7A10.75 10.75 0 0 1 12 5c4.6 0 8.53 2.82 9.94 6.65a1 1 0 0 1 0 .7A10.75 10.75 0 0 1 12 19c-4.6 0-8.53-2.82-9.94-6.65Z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        }

        const registerModal = document.getElementById('registerModal');
        const openRegisterBtn = document.getElementById('openRegisterBtn');
        const closeRegisterBtn = document.getElementById('closeRegisterBtn');
        const backLoginBtn = document.getElementById('backLoginBtn');

        function openRegisterModal(){
            registerModal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeRegisterModal(){
            registerModal.classList.remove('show');
            document.body.style.overflow = '';
        }

        openRegisterBtn.addEventListener('click', openRegisterModal);
        closeRegisterBtn.addEventListener('click', closeRegisterModal);
        backLoginBtn.addEventListener('click', closeRegisterModal);
        registerModal.addEventListener('click', function(event){
            if(event.target === registerModal){
                closeRegisterModal();
            }
        });

        @if(old('company_name') || old('owner_name') || old('company_phone') || old('user_phone'))
            openRegisterModal();
        @endif
    </script>
</body>
</html>
