const DottedMap = require('dotted-map').default;

// Create a map focused on Saudi Arabia
const map = new DottedMap({
    height: 80,
    countries: ['SAU'],  // Saudi Arabia country code
    grid: 'diagonal'
});

// Get the points that make up Saudi Arabia
const points = map.getPoints();

// Extract unique coordinates to form the outline
const uniquePoints = new Set();
points.forEach(point => {
    uniquePoints.add(`${point.x},${point.y}`);
});

console.log('Saudi Arabia coordinates:');
console.log(Array.from(uniquePoints).map(coord => {
    const [x, y] = coord.split(',').map(Number);
    return { x, y };
})); 