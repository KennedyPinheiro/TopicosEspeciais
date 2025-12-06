<?php

function ConfirmarAcao($tipo = 'produto', $action = '/produtos/excluir') {
    $modalId = 'confirmDeleteModal';
    $formId = 'deleteForm';
    
    $titulos = [
        'produto' => 'Confirmar Exclusão de Produto',
        'venda' => 'Confirmar Exclusão de Venda',
        'usuario' => 'Confirmar Exclusão de Usuário'
    ];
    
    $textos = [
        'produto' => 'Tem certeza que deseja excluir o produto <strong id="itemName"></strong>?',
        'venda' => 'Tem certeza que deseja excluir a venda <strong id="itemName"></strong>?',
        'usuario' => 'Tem certeza que deseja excluir o usuário <strong id="itemName"></strong>?'
    ];
    
    $titulo = $titulos[$tipo] ?? 'Confirmar Exclusão';
    $texto = $textos[$tipo] ?? 'Tem certeza que deseja excluir <strong id="itemName"></strong>?';

    return '
    <div class="modal fade" id="' . $modalId . '" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">' . $titulo . '</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>' . $texto . '</p>
                    <p class="text-danger small">Esta ação não pode ser desfeita.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="' . $formId . '" action="' . $action . '" method="POST" class="d-inline">
                        <input type="hidden" name="id" id="deleteItemId">
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener(\'DOMContentLoaded\', function() {
        const confirmDeleteModal = document.getElementById(\'' . $modalId . '\');
        
        if (confirmDeleteModal) {
            confirmDeleteModal.addEventListener(\'show.bs.modal\', function(event) {
                const button = event.relatedTarget;
                const itemId = button.getAttribute(\'data-item-id\');
                const itemName = button.getAttribute(\'data-item-name\');
                
                document.getElementById(\'itemName\').textContent = itemName;
                document.getElementById(\'deleteItemId\').value = itemId;
            });
        }
    });
    </script>';
}