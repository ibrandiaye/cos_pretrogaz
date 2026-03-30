<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center">
            <a href="{{ route('projects.index') }}" class="btn btn-light border p-2 rounded-3 me-3">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="fw-black text-dark mb-0">Nouveau Projet</h2>
        </div>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-premium shadow-sm border p-5">
                <form action="{{ route('projects.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label fw-black text-muted text-uppercase small">Nom du Projet</label>
                            <input type="text" name="name" required class="form-control form-control-lg bg-light border-0 py-3 px-4 rounded-4 fw-bold shadow-sm">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-black text-muted text-uppercase small">Code Pétrolier</label>
                            <select name="code_petrolier" required class="form-select form-select-lg bg-light border-0 py-3 px-4 rounded-4 fw-bold shadow-sm text-dark">
                                <option value="2019">Code 2019 (R-Factor)</option>
                                <option value="1998">Code 1998 (Tax/Tranches)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-black text-muted text-uppercase small">Durée (ans)</label>
                            <input type="number" name="duration" value="20" min="1" required class="form-control form-control-lg bg-light border-0 py-3 px-4 rounded-4 fw-bold shadow-sm">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-black text-muted text-uppercase small">Type de Gisement</label>
                            <select name="type" required class="form-select form-select-lg bg-light border-0 py-3 px-4 rounded-4 fw-bold shadow-sm text-dark">
                                <option value="offshore">Offshore</option>
                                <option value="onshore">Onshore</option>
                            </select>
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label fw-black text-muted text-uppercase small">Description</label>
                            <textarea name="description" rows="3" class="form-control bg-light border-0 py-3 px-4 rounded-4 fw-bold shadow-sm"></textarea>
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary-premium btn-premium px-5 py-3 shadow">Créer le Projet</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
