import './bootstrap';

import Alpine from 'alpinejs';
import { ThreeMap } from './three-map';

// Import the Saudi map generator
import { getSaudiMap } from './saudi-map';

window.Alpine = Alpine;

// LogRocket integration
if (window.LogRocket) {
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
}

Alpine.start();

// Initialize the Saudi Arabia map
document.addEventListener('DOMContentLoaded', () => {
    const mapContainer = document.getElementById('saudi-map');
    if (mapContainer) {
        // Create the Three.js map
        const threeMap = new ThreeMap(mapContainer);
    }
});
