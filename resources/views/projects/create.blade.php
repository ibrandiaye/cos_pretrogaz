<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('projects.index') }}" class="btn btn-ghost" style="padding: 0.45rem 0.65rem;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h1 class="fw-bold mb-0" style="font-size: 1.35rem; letter-spacing: -0.02em;">Nouveau Projet</h1>
                <p class="mb-0 mt-1" style="font-size: 0.8rem; color: var(--text-muted);">Configurez votre modele economique petrolier</p>
            </div>
        </div>
    </x-slot>

    <div class="row justify-content-center animate-in">
        <div class="col-lg-8 col-xl-7">
            <div class="card-modern p-0 overflow-hidden">
                <!-- Header -->
                <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--border);">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 42px; height: 42px; background: var(--accent-light); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-file-earmark-plus" style="font-size: 1.1rem; color: var(--accent);"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0" style="font-size: 1rem;">Informations du projet</h5>
                            <p class="mb-0" style="font-size: 0.8rem; color: var(--text-muted);">Remplissez les details de base de votre projet</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('projects.store') }}" method="POST" style="padding: 2rem;">
                    @csrf
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label-modern">Nom du Projet</label>
                            <input type="text" name="name" required value="{{ old('name') }}" placeholder="Ex: Projet Sangomar Phase 2"
                                class="form-control form-modern form-control-lg">
                            @error('name')
                                <div class="mt-1" style="font-size: 0.8rem; color: var(--danger);">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-modern">Code Petrolier</label>
                            <select name="petroleum_code_id" required class="form-select form-modern form-select-lg">
                                @foreach($petroleumCodes as $pc)
                                    <option value="{{ $pc->id }}" {{ old('petroleum_code_id') == $pc->id ? 'selected' : '' }}>
                                        {{ $pc->name }} ({{ $pc->profit_split_method === 'r_factor' ? 'R-Factor' : 'Production' }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="mt-1" style="font-size: 0.75rem; color: var(--text-muted);">
                                <i class="bi bi-info-circle me-1"></i> <a href="{{ route('petroleum-codes.create') }}" style="color: var(--accent);">Creer un nouveau code petrolier</a>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-modern">Duree (annees)</label>
                            <input type="number" name="duration" value="{{ old('duration', 20) }}" min="1" max="50" required
                                class="form-control form-modern form-control-lg">
                            @error('duration')
                                <div class="mt-1" style="font-size: 0.8rem; color: var(--danger);">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label-modern">Type de Gisement</label>
                            <div class="row g-3">
                                <div class="col-6">
                                    <label style="display: block; cursor: pointer;">
                                        <input type="radio" name="type" value="offshore" {{ old('type', 'offshore') == 'offshore' ? 'checked' : '' }} class="d-none" onchange="this.closest('.row').querySelectorAll('.type-card').forEach(c=>c.classList.remove('selected')); this.closest('.type-card').classList.add('selected');">
                                        <div class="type-card card-modern p-3 text-center selected" style="border-width: 2px; transition: all 0.15s ease;">
                                            <i class="bi bi-water d-block mb-2" style="font-size: 1.5rem; color: var(--accent);"></i>
                                            <div class="fw-bold" style="font-size: 0.9rem;">Offshore</div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted);">Gisement en mer</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-6">
                                    <label style="display: block; cursor: pointer;">
                                        <input type="radio" name="type" value="onshore" {{ old('type') == 'onshore' ? 'checked' : '' }} class="d-none" onchange="this.closest('.row').querySelectorAll('.type-card').forEach(c=>c.classList.remove('selected')); this.closest('.type-card').classList.add('selected');">
                                        <div class="type-card card-modern p-3 text-center" style="border-width: 2px; transition: all 0.15s ease;">
                                            <i class="bi bi-geo-alt-fill d-block mb-2" style="font-size: 1.5rem; color: #7c3aed;"></i>
                                            <div class="fw-bold" style="font-size: 0.9rem;">Onshore</div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted);">Gisement terrestre</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label-modern">Description <span style="font-weight: 400; color: var(--text-muted);">(optionnel)</span></label>
                            <textarea name="description" rows="3" placeholder="Decrivez brievement le projet..."
                                class="form-control form-modern">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-4" style="border-top: 1px solid var(--border);">
                        <a href="{{ route('projects.index') }}" class="btn btn-ghost">Annuler</a>
                        <button type="submit" class="btn btn-accent px-4">
                            <i class="bi bi-check-lg me-1"></i> Creer le Projet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[name="type"]').forEach(function(radio) {
                if (radio.checked) {
                    radio.closest('.type-card').classList.add('selected');
                }
            });
        });
    </script>
    @endpush

    <style>
        .type-card.selected { border-color: var(--accent) !important; background: var(--accent-light) !important; }
    </style>
</x-app-layout>
