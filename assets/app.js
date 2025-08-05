import './bootstrap.js';
import './bootstrap.bundle.js';
import './scripts.js'
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
import './styles/styles.css';
import { initCollectionManager } from './controllers/collection-manager.js';

document.addEventListener('DOMContentLoaded', () => {
    initCollectionManager('.collection-container', 'Ajouter une ligne');
});
console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
