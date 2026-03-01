@props(['colocation'])
<div class="modal fade" id="closeColocModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Clôturer la colocation ?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Cette action est définitive. Toutes les dépenses et membres seront archivés. Êtes-vous sûr ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('colocation.close', $colocation->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">Clôturer</button>
                </form>
            </div>
        </div>
    </div>
    {{-- --}}
</div>