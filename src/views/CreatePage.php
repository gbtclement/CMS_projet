<?php include 'header.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Initialiser les gestionnaires d'événements pour les éléments de la sidebar
    initElementClickHandlers();
    
    // Gestionnaire pour le bouton de sauvegarde
    document.querySelector('.btn-save').addEventListener('click', validateAndSavePage);
});

function initElementClickHandlers() {
    const elements = document.querySelectorAll('.element-item');
    elements.forEach(element => {
        element.addEventListener('click', () => {
            addElement(element.getAttribute('data-type'));
        });
    });
}

function addElement(type) {
    const buildArea = document.getElementById('buildArea');
    const emptyState = buildArea.querySelector('.empty-state');
    
    if (emptyState) {
        emptyState.style.display = 'none';
    }
    
    const element = document.createElement('div');
    element.className = 'builder-element';
    element.setAttribute('data-element-type', type);
    
    // Créer les contrôles
    const controls = `
        <div class="element-controls">
            <button class="move-up" title="Monter">↑</button>
            <button class="move-down" title="Descendre">↓</button>
            <button class="delete-element" title="Supprimer">×</button>
        </div>
    `;
    
    // Créer le contenu selon le type
    let content = '';
    switch(type) {
        case 'text':
            content = '<div class="element-content" contenteditable="true"><p>Double-cliquez pour éditer le texte</p></div>';
            break;
        case 'heading':
            content = '<div class="element-content" contenteditable="true"><h2>Double-cliquez pour éditer le titre</h2></div>';
            break;
        case 'image':
            content = `
                <div class="element-content">
                    <div class="image-placeholder">
                        <input type="file" accept="image/*">
                        <p>Cliquez pour ajouter une image</p>
                    </div>
                </div>`;
            break;
        case 'button':
            content = `<div class="element-content"><button class="custom-button">Nouveau bouton</button></div>`;
            break;
        case 'section':
            content = '<div class="element-content section-content"></div>';
            break;
        case 'column':
            content = '<div class="element-content column-content"></div>';
            break;
    }
    
    element.innerHTML = controls + content;
    
    // Ajouter les gestionnaires d'événements
    element.querySelector('.delete-element').addEventListener('click', () => {
        element.remove();
        checkEmptyState();
    });
    
    element.querySelector('.move-up').addEventListener('click', () => {
        const prev = element.previousElementSibling;
        if (prev) {
            buildArea.insertBefore(element, prev);
        }
    });
    
    element.querySelector('.move-down').addEventListener('click', () => {
        const next = element.nextElementSibling;
        if (next) {
            buildArea.insertBefore(next, element);
        }
    });
    
    buildArea.appendChild(element);
}

function checkEmptyState() {
    const buildArea = document.getElementById('buildArea');
    const emptyState = buildArea.querySelector('.empty-state');
    const hasElements = buildArea.querySelector('.builder-element');
    
    if (emptyState) {
        emptyState.style.display = hasElements ? 'none' : 'flex';
    }
}

function validateAndSavePage() {
    const title = document.querySelector('.page-title').value.trim();
    const content = document.getElementById('buildArea');
    const elements = content.querySelectorAll('.builder-element');
    
    // Validation
    if (!title) {
        alert('Le titre est obligatoire');
        return;
    }
    
    if (elements.length === 0) {
        alert('Le contenu ne peut pas être vide');
        return;
    }
    
    // Préparer le contenu pour la sauvegarde
    const contentClone = content.cloneNode(true);
    
    // Nettoyer les contrôles
    contentClone.querySelectorAll('.element-controls').forEach(el => el.remove());
    
    const pageData = {
        title: title,
        content: contentClone.innerHTML
    };
    
    // Sauvegarder
    fetch('index.php?action=savePage', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(pageData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Page sauvegardée avec succès !');
        } else {
            alert('Erreur lors de la sauvegarde : ' + data.error);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de la sauvegarde de la page');
    });
}
</script>



<div class="page-builder">
    <!-- Sidebar des éléments -->
    <div class="builder-sidebar">
        <div class="sidebar-header">
            <h3>Éléments</h3>
        </div>
        
        <!-- Sections des éléments -->
        <div class="elements-section">
            <h4>Structure</h4>
            <div class="element-item" data-type="section">
                <i class="fas fa-columns"></i>
                Section
            </div>
            <div class="element-item" data-type="column">
                <i class="fas fa-columns"></i>
                Colonne
            </div>
        </div>

        <div class="elements-section">
            <h4>Éléments basiques</h4>
            <div class="element-item" data-type="text">
                <i class="fas fa-paragraph"></i>
                Texte
            </div>
            <div class="element-item" data-type="heading">
                <i class="fas fa-heading"></i>
                Titre
            </div>
            <div class="element-item" data-type="image">
                <i class="fas fa-image"></i>
                Image
            </div>
            <div class="element-item" data-type="button">
                <i class="fas fa-square"></i>
                Bouton
            </div>
        </div>
    </div>

    <!-- Zone d'édition principale -->
    <div class="builder-content">
        <div class="content-header">
            <input type="text" class="page-title" placeholder="Titre de la page">
        </div>
        
        <div class="content-area" id="buildArea">
            <div class="empty-state">
                <i class="fas fa-plus-circle"></i>
                <p>Faites glisser des éléments ici</p>
            </div>
        </div>
    </div>
</div>

<!-- Barre d'action fixe en bas -->
<div class="action-bar">
    <button class="btn-preview">
        <i class="fas fa-eye"></i>
        Aperçu
    </button>
    <button class="btn-save">
        <i class="fas fa-save"></i>
        Sauvegarder
    </button>
</div>

<?php include 'footer.php'; ?>