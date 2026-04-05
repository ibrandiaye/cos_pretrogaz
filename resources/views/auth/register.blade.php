<x-guest-layout>
    <div class="auth-form-header">
        <h2 class="auth-form-title">Creer un compte</h2>
        <p class="auth-form-desc">Commencez a modeliser vos projets petroliers</p>
    </div>

    <div class="auth-card">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name">Nom Complet</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                    class="form-input" placeholder="Jean Dupont" required autofocus autocomplete="name">
                @error('name')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Adresse Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    class="form-input" placeholder="vous@exemple.com" required autocomplete="username">
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Mot de Passe</label>
                <input id="password" type="password" name="password"
                    class="form-input" placeholder="Min. 8 caracteres" required autocomplete="new-password">
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation">Confirmer le Mot de Passe</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                    class="form-input" placeholder="••••••••" required autocomplete="new-password">
                @error('password_confirmation')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-auth">
                <i class="bi bi-person-plus-fill" style="margin-right: 6px;"></i>
                Creer mon Compte
            </button>
        </form>
    </div>

    <div class="auth-footer">
        Deja inscrit ? <a href="{{ route('login') }}">Se connecter</a>
    </div>
</x-guest-layout>
