class ImagePreview {
    constructor() {
        this.imageInput = document.getElementById('image-input');
        this.preview = document.getElementById('image-preview');
        this.placeholder = document.getElementById('placeholder-text');
        this.container = document.getElementById('image-container');
        this.removeBtn = document.getElementById('remove-image');
        
        this.init();
    }
    
    init() {
        this.container.addEventListener('click', () => this.openFileSelector());
        this.imageInput.addEventListener('change', (e) => this.handleImageSelect(e));
        this.removeBtn.addEventListener('click', (e) => this.removeImage(e));
        
        this.container.addEventListener('dragover', (e) => this.handleDragOver(e));
        this.container.addEventListener('dragleave', (e) => this.handleDragLeave(e));
        this.container.addEventListener('drop', (e) => this.handleDrop(e));
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            this.container.addEventListener(eventName, this.preventDefaults, false);
        });
    }
    
    preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    openFileSelector() {
        this.imageInput.click();
    }
    
    handleImageSelect(event) {
        const file = event.target.files[0];
        if (file) {
            this.validateAndPreviewImage(file);
        }
    }
    
    handleDragOver(e) {
        this.preventDefaults(e);
        this.container.classList.add('drag-over');
    }
    
    handleDragLeave(e) {
        this.preventDefaults(e);
        this.container.classList.remove('drag-over');
    }
    
    handleDrop(e) {
        this.preventDefaults(e);
        this.container.classList.remove('drag-over');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            this.validateAndPreviewImage(file);
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            this.imageInput.files = dataTransfer.files;
        }
    }
    
    validateAndPreviewImage(file) {
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            alert('Por favor, selecione uma imagem válida (JPEG, PNG, GIF ou WebP).');
            return;
        }
        
        const maxSize = 5 * 1024 * 1024;
        if (file.size > maxSize) {
            alert('A imagem deve ter no máximo 5MB.');
            return;
        }
        
        this.previewImage(file);
    }
    
    previewImage(file) {
        const reader = new FileReader();
        
        this.container.classList.add('loading');
        
        reader.onload = (e) => {
            this.preview.src = e.target.result;
            this.preview.style.display = 'block';
            this.placeholder.style.display = 'none';
            this.container.classList.add('has-image');
            this.container.classList.remove('loading');
            this.removeBtn.style.display = 'inline-block';
        };
        
        reader.onerror = () => {
            alert('Erro ao carregar a imagem. Tente novamente.');
            this.container.classList.remove('loading');
        };
        
        reader.readAsDataURL(file);
    }
    
    removeImage(e) {
        e.stopPropagation();
        
        this.imageInput.value = '';
        
        this.preview.style.display = 'none';
        this.preview.src = '';
        this.placeholder.style.display = 'block';
        this.container.classList.remove('has-image');
        this.removeBtn.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    new ImagePreview();
});

window.ImagePreview = ImagePreview;