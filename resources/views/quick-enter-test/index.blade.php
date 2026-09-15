<!doctype html>
<html lang="lo">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quick Enter Test</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 32px; color: #111827; }
        .wrap { max-width: 760px; }
        button, a { display: inline-block; margin: 6px 8px 6px 0; padding: 10px 14px; border-radius: 6px; border: 1px solid #d1d5db; background: #fff; color: #111827; font-weight: 600; text-decoration: none; cursor: pointer; }
        button.primary { background: #0a427a; border-color: #0a427a; color: #fff; }
        .box { margin: 18px 0; padding: 14px; border: 1px solid #d1d5db; border-radius: 8px; background: #f9fafb; }
        .ok { border-color: #86efac; background: #f0fdf4; }
        code { background: #eef2ff; padding: 2px 5px; border-radius: 4px; }
    </style>
</head>
<body>
    <main class="wrap">
        <h1>Quick Enter Test</h1>
        <p>One click create sample orders with status <code>WAITING</code>.</p>

        @if ($lastCreated)
            <div class="box ok">
                Created <strong>{{ $lastCreated['type'] }}</strong>
                ID: <strong>{{ $lastCreated['id'] }}</strong>
                Status: <strong>{{ $lastCreated['status'] }}</strong>
            </div>
        @endif

        <div class="box">
            <h2>Create Test Order</h2>
            <form method="POST" action="{{ route('quick-enter-test.old') }}" style="display:inline">
                @csrf
                <button class="primary" type="submit">Create beta_enter order</button>
            </form>
        </div>

        <div class="box">
            <h2>Set User #1 Role</h2>
            @foreach ([1, 2, 3, 4, 5] as $role)
                <form method="POST" action="{{ route('quick-enter-test.role', $role) }}" style="display:inline">
                    @csrf
                    <button type="submit">is_admin = {{ $role }}</button>
                </form>
            @endforeach
        </div>

        <div class="box">
            <h2>Open Pages</h2>
            <a href="{{ route('old-enter.login') }}" target="_blank" rel="noopener">/old-enter</a>
            <a href="{{ route('old-user-task-v2.dashboard') }}" target="_blank" rel="noopener">/old-user-task-v2</a>
        </div>

        <p>Note: this page creates database rows only. It does not upload files.</p>
    </main>
</body>
</html>
