<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Connexion — Administration Kenaya Finances</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/kenaya.css') }}" rel="stylesheet">
</head>
<body class="bg-navy min-vh-100 d-flex align-items-center">
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="text-center mb-4">
                    <div class="shield-wrap mb-3">
                        <span class="shield-halo" aria-hidden="true"></span>
                        <svg class="shield-icon" viewBox="0 0 64 64" width="84" height="84" aria-hidden="true" focusable="false">
                            <defs>
                                <linearGradient id="shieldGrad" x1="0" y1="0" x2="1" y2="1">
                                    <stop offset="0" stop-color="#00d082"/>
                                    <stop offset="1" stop-color="#0a875a"/>
                                </linearGradient>
                            </defs>
                            <path d="M32 3 L55 11.5 V30 C55 44.5 45.2 55.3 32 61 C18.8 55.3 9 44.5 9 30 V11.5 Z" fill="url(#shieldGrad)"/>
                            <path d="M32 8.5 L50 15.2 V30 C50 41.8 42.2 50.6 32 55.4 C21.8 50.6 14 41.8 14 30 V15.2 Z"
                                fill="none" stroke="#fff" stroke-opacity=".4" stroke-width="1.4"/>
                            <path d="M27.5 29 v-4.2 a4.5 4.5 0 0 1 9 0 V29" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round"/>
                            <rect x="22.5" y="28.5" width="19" height="15" rx="3.2" fill="#fff"/>
                            <circle cx="32" cy="35" r="2.3" fill="#0a875a"/>
                            <rect x="31" y="35.5" width="2" height="4.5" rx="1" fill="#0a875a"/>
                        </svg>
                    </div>

                    <div class="login-logo mx-auto">
                        <img src="{{ asset('images/logo.png') }}" alt="Kenaya Finances" height="56">
                    </div>

                    <h1 class="h6 text-white-50 text-uppercase mt-3 mb-0" style="letter-spacing:.12em">
                        Espace d'administration
                    </h1>
                </div>

                <div class="card border-0 shadow">
                    <div class="card-body p-4">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.login.post') }}" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse e-mail</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                       class="form-control @error('email') is-invalid @enderror"
                                       autocomplete="username" autofocus required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" id="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       autocomplete="current-password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                        </form>
                    </div>
                </div>

                <p class="text-center mt-3">
                    <a href="{{ route('home') }}" class="text-white-50 small">← Retour au site</a>
                </p>
            </div>
        </div>
    </main>
</body>
</html>