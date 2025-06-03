import './bootstrap';

import Alpine from 'alpinejs';
import { ThreeMap } from './three-map';

// Import the Saudi map generator
import { getSaudiMap } from './saudi-map';

window.Alpine = Alpine;

Alpine.start();

// Initialize the Saudi Arabia map
document.addEventListener('DOMContentLoaded', () => {
    const mapContainer = document.getElementById('saudi-map');
    if (mapContainer) {
        // Create the Three.js map
        const threeMap = new ThreeMap(mapContainer);
    }
});
