import './bootstrap';

import Alpine from 'alpinejs';
import { ThreeMap } from './three-map';
import LogRocket from 'logrocket';

// Import the Saudi map generator
import { getSaudiMap } from './saudi-map';

window.Alpine = Alpine;

// Initialize LogRocket
LogRocket.init('8hoguu/hadaf');

// LogRocket integration
// Identify user if authenticated
const user = window.logrocketUser || window.Laravel?.user;
if (user) {
    LogRocket.identify(user.id, {
        name: user.name,
        email: user.email,
        role: user.role || 'user'
    });
}

// Capture console logs
LogRocket.captureConsole();

// Capture network requests
LogRocket.captureNetwork();

Alpine.start();

// Initialize the Saudi Arabia map
document.addEventListener('DOMContentLoaded', () => {
    const mapContainer = document.getElementById('saudi-map');
    if (mapContainer) {
        // Create the Three.js map
        const threeMap = new ThreeMap(mapContainer);
    }
});
