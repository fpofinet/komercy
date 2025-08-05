/**
 * Collection Manager
 * Gère dynamiquement les CollectionType Symfony (ajout/suppression de lignes)
 * Utilisation : appeler initCollectionManager sur un container
 */

/**
 * Initialise la gestion dynamique des lignes d’un CollectionType
 * @param {string} selector - Sélecteur CSS du conteneur (ex: '.collection-container')
 * @param {string} addButtonLabel - Texte du bouton "Ajouter une ligne"
 */
export function initCollectionManager(containerSelector, addButtonText = 'Ajouter une ligne') {
    document.querySelectorAll(containerSelector).forEach(function (collectionHolder) {
        // Bouton d'ajout
        const addButton = document.createElement('button');
        addButton.type = 'button';
        addButton.className = 'btn btn-sm btn-success mt-2';
        addButton.textContent = addButtonText;

        // Append bouton à la fin du container
        collectionHolder.append(addButton);

        // Compteur de lignes
        let index = collectionHolder.querySelectorAll('.collection-item').length;

        // Prototype
        const prototype = collectionHolder.dataset.prototype;

        // Ajouter une ligne
        const addForm = () => {
            const newForm = prototype.replace(/__name__/g, index);
            index++;

            const div = document.createElement('div');
            div.classList.add('collection-item');
            div.innerHTML = newForm;

            // Bouton de suppression
            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-sm btn-danger ms-2';
            removeButton.textContent = 'Supprimer';

            removeButton.addEventListener('click', () => {
                div.remove();
            });

            div.append(removeButton);
            collectionHolder.insertBefore(div, addButton);
        };

        // Ajouter bouton initial si vide
        if (index === 0) {
            addForm();
        }

        addButton.addEventListener('click', addForm);

        // Ajouter les boutons de suppression aux lignes existantes
        collectionHolder.querySelectorAll('.collection-item').forEach((item) => {
            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-sm btn-danger ms-2';
            removeButton.textContent = 'Supprimer';

            removeButton.addEventListener('click', () => {
                item.remove();
            });

            item.append(removeButton);
        });
    });
}
