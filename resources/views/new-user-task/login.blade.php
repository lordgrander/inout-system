<!doctype html>
<html lang="lo">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ເຂົ້າລະບົບຕິດຕາມວຽກ</title>
  @php($taskRoutePrefix = $taskRoutePrefix ?? 'new-user-task')
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Noto+Sans+Lao:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: Inter, "Noto Sans Lao", ui-sans-serif, system-ui, sans-serif; }
  </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-950">
  <main class="flex min-h-screen items-center justify-center px-4 py-10">
    <section class="w-full max-w-md rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
      <div class="mb-6 flex items-center gap-3">
        <div class="grid h-12 w-12 place-items-center rounded-lg bg-[#0a427a] text-xl font-semibold text-white">✓</div>
        <div>
          <h1 class="text-xl font-semibold">ລະບົບຕິດຕາມວຽກ</h1>
          <p class="text-sm text-slate-500">ສຳລັບຜູ້ໃຊ້ງານ is_admin 2, 3, 4, 5</p>
        </div>
      </div>

      @if ($errors->any())
        <div class="mb-4 rounded-md border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route($taskRoutePrefix.'.login.store') }}" class="space-y-4">
        @csrf
        <div>
          <label for="email" class="mb-1 block text-sm font-medium text-slate-700">ຊື່ຜູ້ໃຊ້ / Email</label>
          <input id="email" name="email" type="text" value="{{ old('email') }}" autocomplete="username" required autofocus class="h-11 w-full rounded-md border border-slate-300 bg-white px-3 outline-none transition focus:border-[#0a427a] focus:ring-4 focus:ring-blue-100">
        </div>

        <div>
          <label for="password" class="mb-1 block text-sm font-medium text-slate-700">ລະຫັດຜ່ານ</label>
          <input id="password" name="password" type="password" autocomplete="current-password" required class="h-11 w-full rounded-md border border-slate-300 bg-white px-3 outline-none transition focus:border-[#0a427a] focus:ring-4 focus:ring-blue-100">
        </div>

        <button type="submit" class="inline-flex h-11 w-full items-center justify-center rounded-md bg-[#0a427a] px-4 font-semibold text-white transition hover:bg-[#083660]">
          ເຂົ້າລະບົບ
        </button>
      </form>
    </section>
  </main>
</body>
</html>
