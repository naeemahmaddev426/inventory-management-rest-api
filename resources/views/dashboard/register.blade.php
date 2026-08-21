<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register — Inventory Management</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root { --primary: #6366f1; --primary-dark: #4f46e5; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #f1f5f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-wrapper { width: min(100%, 1100px); }
        .login-card {
            display: flex;
            flex-wrap: wrap;
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(2,6,23,.12), 0 4px 20px rgba(2,6,23,.06);
            min-height: 620px;
        }

        /* ─── LEFT PANEL ─── */
        .login-left {
            flex: 0 0 40%;
            background: linear-gradient(145deg, #0f172a 0%, #1e293b 50%, #312e81 100%);
            padding: 60px 48px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }
        .login-left::before {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            background: rgba(99,102,241,.15);
            border-radius: 50%;
            top: -80px; right: -80px;
        }
        .login-left::after {
            content: '';
            position: absolute;
            width: 200px; height: 200px;
            background: rgba(99,102,241,.1);
            border-radius: 50%;
            bottom: 40px; left: -60px;
        }
        .brand-logo { display: flex; align-items: center; gap: 12px; position: relative; z-index: 2; }
        .brand-logo .icon {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, #6366f1, #818cf8);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; color: #fff;
        }
        .brand-logo .text { font-size: 1.3rem; font-weight: 800; color: #fff; letter-spacing: -.3px; }
        .brand-logo .subtitle { font-size: .72rem; color: rgba(255,255,255,.5); text-transform: uppercase; letter-spacing: 1px; }
        .panel-content { position: relative; z-index: 2; }
        .panel-content h2 { font-size: 1.8rem; font-weight: 800; color: #fff; line-height: 1.2; margin-bottom: 16px; }
        .panel-content p { color: rgba(255,255,255,.65); font-size: .9rem; line-height: 1.7; }
        .features { list-style: none; position: relative; z-index: 2; margin-top: 32px; }
        .features li { display: flex; align-items: center; gap: 10px; color: rgba(255,255,255,.75); font-size: .85rem; padding: 6px 0; }
        .features li i { color: #a5b4fc; font-size: .9rem; }

        /* ─── RIGHT PANEL ─── */
        .login-right { flex: 1; padding: 50px 48px; display: flex; align-items: center; background: #fff; }
        .login-form-wrap { width: 100%; max-width: 420px; margin: 0 auto; }
        .form-heading { margin-bottom: 28px; }
        .form-heading h3 { font-size: 1.5rem; font-weight: 800; color: #0f172a; margin-bottom: 6px; }
        .form-heading p { color: #64748b; font-size: .875rem; }

        .form-label { font-size: .8rem; font-weight: 600; color: #475569; margin-bottom: 6px; }
        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: .65rem 1rem;
            font-size: .875rem;
            transition: all .2s;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99,102,241,.12);
            outline: none;
        }
        .input-group .form-control { border-radius: 12px 0 0 12px; }
        .input-group .btn-toggle-pass {
            border: 1px solid #e2e8f0;
            border-left: none;
            border-radius: 0 12px 12px 0;
            background: #f8fafc;
            color: #94a3b8;
            padding: 0 14px;
            cursor: pointer;
            transition: all .2s;
        }
        .input-group .btn-toggle-pass:hover { color: var(--primary); }
        .btn-register {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            border-radius: 12px;
            padding: .75rem 1.5rem;
            font-size: .9rem;
            font-weight: 700;
            color: #fff;
            width: 100%;
            transition: all .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-register:hover { transform: translateY(-1px); box-shadow: 0 8px 25px rgba(99,102,241,.4); }
        .alert-box {
            border-radius: 10px;
            padding: 12px 14px;
            font-size: .82rem;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-bottom: 16px;
        }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; }
        .login-link { text-align: center; margin-top: 20px; font-size: .82rem; color: #64748b; }
        .login-link a { color: var(--primary); font-weight: 600; text-decoration: none; }
        .login-link a:hover { text-decoration: underline; }
        .password-hint { font-size: .75rem; color: #94a3b8; margin-top: 4px; }

        @media (max-width: 991px) {
            .login-left { flex-basis: 100%; min-height: 240px; padding: 36px 28px; }
            .login-right { padding: 36px 28px; }
        }
        @media (max-width: 576px) {
            body { padding: 12px; }
            .login-left, .login-right { padding: 24px 20px; }
        }
    </style>
</head>
<body>
<div class="login-wrapper">
    <div class="login-card">

        <!-- Left Panel -->
        <div class="login-left">
            <div class="brand-logo">
                <div class="icon"><i class="bi bi-boxes"></i></div>
                <div>
                    <div class="text">InvenPro</div>
                    <div class="subtitle">Management System</div>
                </div>
            </div>

            <div class="panel-content">
                <h2>Join InvenPro today.</h2>
                <p>Create your account and start managing your inventory with ease. Full access to all features.</p>
                <ul class="features">
                    <li><i class="bi bi-check-circle-fill"></i> Free to get started</li>
                    <li><i class="bi bi-check-circle-fill"></i> Full inventory control</li>
                    <li><i class="bi bi-check-circle-fill"></i> Secure token-based auth</li>
                    <li><i class="bi bi-check-circle-fill"></i> RESTful API access</li>
                </ul>
            </div>

            <p style="color:rgba(255,255,255,.3);font-size:.72rem;position:relative;z-index:2;">
                © {{ date('Y') }} InvenPro · Laravel 13 REST API
            </p>
        </div>

        <!-- Right Panel -->
        <div class="login-right">
            <div class="login-form-wrap">
                <div class="form-heading">
                    <h3>Create account ✨</h3>
                    <p>Fill in the details below to get started</p>
                </div>

                {{-- Error Message --}}
                @if(session('error') || $errors->any())
                    <div class="alert-box alert-error">
                        <i class="bi bi-exclamation-circle-fill mt-1"></i>
                        <div>
                            @if(session('error'))
                                {{ session('error') }}
                            @else
                                {{ $errors->first() }}
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Success Message --}}
                @if(session('success'))
                    <div class="alert-box alert-success">
                        <i class="bi bi-check-circle-fill mt-1"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                {{-- Register Form --}}
                <form method="POST" action="{{ route('dashboard.register.post') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="John Doe"
                            value="{{ old('name') }}"
                            autocomplete="name"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="you@example.com"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            required
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Min 8 characters"
                                autocomplete="new-password"
                                required
                            >
                            <button type="button" class="btn-toggle-pass" onclick="togglePass('password','eye1')">
                                <i class="bi bi-eye" id="eye1"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger mt-1" style="font-size:.8rem;">{{ $message }}</div>
                        @enderror
                        <div class="password-hint">At least 8 characters</div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="Repeat your password"
                                autocomplete="new-password"
                                required
                            >
                            <button type="button" class="btn-toggle-pass" onclick="togglePass('password_confirmation','eye2')">
                                <i class="bi bi-eye" id="eye2"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="text-danger mt-1" style="font-size:.8rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-register">
                        <i class="bi bi-person-plus"></i>
                        Create Account
                    </button>
                </form>

                <div class="login-link">
                    Already have an account?
                    <a href="{{ route('dashboard.login') }}">Sign in</a>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function togglePass(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }
</script>
</body>
</html>
