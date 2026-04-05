<x-guest-layout>
    <div class="auth-form-header">
        <h2 class="auth-form-title">Bienvenue</h2>
        <p class="auth-form-desc">Connectez-vous a votre espace de simulation</p>
    </div>

    @if (session('status'))
        <div class="auth-status">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('status') }}
        </div>
    @endif

    <div class="auth-card">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label for="email">Adresse Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    class="form-input" placeholder="vous@exemple.com" required autofocus autocomplete="username">
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                    <label for="password" style="margin-bottom: 0;">Mot de Passe</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="auth-link" style="font-size: 0.75rem;">
                            Mot de passe oublie ?
                        </a>
                    @endif
                </div>
                <input id="password" type="password" name="password"
                    class="form-input" placeholder="••••••••" required autocomplete="current-password">
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="form-check">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me">Se souvenir de moi</label>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-auth">
                <i class="bi bi-box-arrow-in-right" style="margin-right: 6px;"></i>
                Se Connecter
            </button>
        </form>
    </div>

    <div class="auth-footer">
        Pas encore de compte ? <a href="{{ route('register') }}">Creer un compte</a>
    </div>
</x-guest-layout>
