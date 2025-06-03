import Globe from 'globe.gl';

export class ThreeMap {
    constructor(container) {
        // Initialize the Globe with a brighter earth texture
        this.globe = Globe()(container)
            .globeImageUrl('//unpkg.com/three-globe/example/img/earth-blue-marble.jpg')
            .backgroundColor('rgba(0,0,0,0)')
            .width(container.clientWidth)
            .height(container.clientHeight);

        // Major cities data with visibility states
        this.cities = [
            { name: 'Riyadh', lat: 24.7136, lng: 46.6753, size: 0.8, color: '#ff4444', visible: true, nextChange: Date.now() },
            { name: 'Jeddah', lat: 21.5433, lng: 39.1728, size: 0.7, color: '#ff4444', visible: true, nextChange: Date.now() },
            { name: 'Khobar', lat: 26.2172, lng: 50.1971, size: 0.6, color: '#ff4444', visible: true, nextChange: Date.now() }
        ];

        // Store initial position
        this.baseAltitude = 1.7232044799780635;
        this.baseLat = 12.034690305820064;
        this.baseLng = 33.43686107828667;

        // Animation control flags
        this.isUserInteracting = false;
        this.returnTimeout = null;
        this.isReturning = false;

        this.initGlobe();
        this.setupResizeHandler();
        this.setupInteractionHandlers();
        this.startAnimation();
        this.startDotVisibilityAnimation();

        // Log initial position
        console.log('Initial position:', this.globe.pointOfView());
    }

    getTrafficProbability() {
        // Get current hour in GMT+3
        const now = new Date();
        const gmt3Hour = (now.getUTCHours() + 3) % 24;
        
        // Traffic probability based on time of day (GMT+3)
        if (gmt3Hour >= 8 && gmt3Hour < 10) {
            // Morning rush hour (8-10 AM)
            return 0.8;
        } else if (gmt3Hour >= 16 && gmt3Hour < 19) {
            // Evening rush hour (4-7 PM)
            return 0.9;
        } else if (gmt3Hour >= 23 || gmt3Hour < 5) {
            // Late night/early morning (11 PM-5 AM)
            return 0.3;
        } else if (gmt3Hour >= 12 && gmt3Hour < 14) {
            // Lunch time (12-2 PM)
            return 0.6;
        } else {
            // Normal hours
            return 0.5;
        }
    }

    startDotVisibilityAnimation() {
        const updateDotVisibility = () => {
            const now = Date.now();
            const trafficProb = this.getTrafficProbability();

            // Update each city
            this.cities.forEach(city => {
                if (now >= city.nextChange) {
                    // Determine if dot should be visible based on traffic probability
                    city.visible = Math.random() < trafficProb;
                    
                    // Set next change time
                    // During high traffic, changes happen more frequently
                    const minDelay = trafficProb > 0.7 ? 200 : 500;
                    const maxDelay = trafficProb > 0.7 ? 1000 : 2000;
                    city.nextChange = now + minDelay + Math.random() * (maxDelay - minDelay);
                }

                // Update color based on visibility
                city.color = city.visible ? '#ff4444' : 'rgba(255, 68, 68, 0)';
            });

            // Update the points
            this.globe
                .pointsData([...this.cities])
                .pointColor(city => city.color);

            requestAnimationFrame(updateDotVisibility);
        };

        updateDotVisibility();
    }

    initGlobe() {
        // Set initial camera position to focus on Saudi Arabia
        this.globe
            .pointOfView({
                lat: this.baseLat,
                lng: this.baseLng,
                altitude: this.baseAltitude
            })
            // Add points for cities
            .pointsData(this.cities)
            .pointColor(city => city.color)
            .pointAltitude(0.02)
            .pointRadius('size')
            .pointsMerge(true)
            .pointLabel(city => `
                <div style="color: white; background: rgba(0,0,0,0.8); padding: 5px; border-radius: 5px;">
                    ${city.name}
                </div>
            `);

        // Create glowing atmosphere effect
        const atmosphereMaterial = this.globe.globeMaterial();
        atmosphereMaterial.shininess = 0.1;

        // Configure controls
        const controls = this.globe.controls();
        controls.enableDamping = true;
        controls.dampingFactor = 0.2;
        controls.enabled = true;
    }

    setupInteractionHandlers() {
        const controls = this.globe.controls();

        // Handle drag start
        controls.addEventListener('start', () => {
            console.log('DEBUG: Drag started');
            this.isUserInteracting = true;
            this.isReturning = false;
            if (this.returnTimeout) {
                clearTimeout(this.returnTimeout);
            }
        });

        // Handle drag end
        controls.addEventListener('end', () => {
            console.log('DEBUG: Drag ended');
            
            // Force immediate console log of current position
            const pos = this.globe.pointOfView();
            console.log('Current position:', {
                lat: pos.lat,
                lng: pos.lng,
                altitude: pos.altitude
            });

            if (this.isUserInteracting) {
                this.isUserInteracting = false;
                
                // Wait before starting return animation
                this.returnTimeout = setTimeout(() => {
                    const pos = this.globe.pointOfView();
                    console.log('Position before return:', {
                        lat: pos.lat,
                        lng: pos.lng,
                        altitude: pos.altitude
                    });
                    this.startReturnTransition();
                }, 2000);
            }
        });

        // Add continuous position logging during interaction
        const logPosition = () => {
            if (this.isUserInteracting) {
                const pos = this.globe.pointOfView();
                console.log('Moving position:', {
                    lat: pos.lat,
                    lng: pos.lng,
                    altitude: pos.altitude
                });
            }
            requestAnimationFrame(logPosition);
        };
        logPosition();
    }

    startReturnTransition() {
        const startPos = this.globe.pointOfView();
        console.log('Starting return from:', startPos);
        
        const startTime = Date.now();
        const duration = 1500; // 1.5 seconds

        const animate = () => {
            const now = Date.now();
            const progress = Math.min((now - startTime) / duration, 1);
            
            // Smooth easing
            const easing = t => t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
            const factor = easing(progress);

            // Calculate interpolated position
            const lat = startPos.lat + (this.baseLat - startPos.lat) * factor;
            const lng = startPos.lng + (this.baseLng - startPos.lng) * factor;
            const altitude = startPos.altitude + (this.baseAltitude - startPos.altitude) * factor;

            // Update position
            this.globe.pointOfView({
                lat,
                lng,
                altitude
            });

            // Continue animation if not complete
            if (progress < 1) {
                requestAnimationFrame(animate);
            }
        };

        animate();
    }

    startAnimation() {
        const animate = () => {
            requestAnimationFrame(animate);
            
            // Only float if not being controlled by user
            if (!this.isUserInteracting) {
                const floatOffset = Math.sin(Date.now() / 3000) * 0.15;
                
                // Only apply floating animation if we're not in a return transition
                if (!this.returnTimeout) {
                    this.globe.pointOfView({
                        lat: this.baseLat,
                        lng: this.baseLng,
                        altitude: this.baseAltitude + floatOffset
                    });
                }
            }
        };
        animate();
    }

    setupResizeHandler() {
        window.addEventListener('resize', () => {
            const width = this.globe.width();
            const height = this.globe.height();
            this.globe
                .width(width)
                .height(height);
        });
    }
} 