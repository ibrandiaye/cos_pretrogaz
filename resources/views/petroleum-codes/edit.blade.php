<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('petroleum-codes.index') }}" class="btn btn-ghost" style="padding: 0.45rem 0.65rem;"><i class="bi bi-arrow-left"></i></a>
            <div>
                <h1 class="fw-bold mb-0" style="font-size: 1.35rem;">Modifier : {{ $petroleumCode->name }}</h1>
                <p class="mb-0 mt-1" style="font-size: 0.8rem; color: var(--text-muted);">{{ $petroleumCode->is_system ? 'Code systeme - certains champs sont proteges' : 'Code personnalise' }}</p>
            </div>
        </div>
    </x-slot>

    <div class="row justify-content-center animate-in">
        <div class="col-xl-10">
            <div class="card-modern p-0 overflow-hidden">
                <form action="{{ route('petroleum-codes.update', $petroleumCode) }}" method="POST" style="padding: 2rem;">
                    @csrf @method('PUT')

                    @if($errors->any())
                        <div class="alert-modern alert-error-modern mb-4">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            <div>Veuillez corriger les erreurs ci-dessous.</div>
                        </div>
                    @endif

                    @include('petroleum-codes._form', ['code' => $petroleumCode])

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-4" style="border-top: 1px solid var(--border);">
                        <a href="{{ route('petroleum-codes.index') }}" class="btn btn-ghost">Annuler</a>
                        <button type="submit" class="btn btn-accent px-4">
                            <i class="bi bi-check-lg me-1"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
