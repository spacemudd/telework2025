import DottedMap from 'dotted-map';

// Create a map focused on Saudi Arabia
const map = new DottedMap({
    height: 80,
    grid: 'diagonal',
    region: {
        lat: { min: 16, max: 33 }, // Saudi Arabia's latitude bounds
        lng: { min: 34, max: 56 }  // Saudi Arabia's longitude bounds
    }
});

// Add major cities
const cities = [
    { name: 'Riyadh', lat: 24.7136, lng: 46.6753, color: '#EF4444' },
    { name: 'Jeddah', lat: 21.5433, lng: 39.1728, color: '#EF4444' },
    { name: 'Khobar', lat: 26.2172, lng: 50.1971, color: '#EF4444' }
];

// Add city markers
cities.forEach(city => {
    map.addPin({
        lat: city.lat,
        lng: city.lng,
        svgOptions: { 
            color: city.color,
            radius: 0.8,
            attrs: {
                class: 'city-dot',
                style: 'opacity: 0'
            }
        }
    });
});

// Generate SVG
export function getSaudiMap() {
    return map.getSVG({
        shape: 'circle',
        backgroundColor: 'transparent',
        color: '#DBDDE0',
        radius: 0.25
    });
} 