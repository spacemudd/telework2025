/**
 * Scroll Animation System
 * Uses Intersection Observer API to trigger animations when elements enter viewport
 * 
 * Usage: Add class 'scroll-animate' to any element you want to animate
 * Optional classes: delay-100, delay-200, etc. for staggered animations
 * 
 * Features:
 * - Fade in (opacity: 0 → 1)
 * - Slide up (translateY: 30px → 0)
 * - Triggers only once when element enters view
 * - Respects browser's native scrolling behavior
 */

class ScrollAnimations {
    constructor(options = {}) {
        // Default configuration
        this.config = {
            // Animation trigger threshold (0.1 = 10% of element visible)
            threshold: options.threshold || 0.1,
            // Root margin for earlier/later triggering
            rootMargin: options.rootMargin || '0px 0px -50px 0px',
            // Animation class name
            animateClass: options.animateClass || 'scroll-animate',
            // Active animation class name
            activeClass: options.activeClass || 'animate-in',
            // Whether to enable debug logging
            debug: options.debug || false
        };

        // Store observed elements to avoid duplicate observations
        this.observedElements = new Set();
        
        // Initialize the observer
        this.init();
    }

    /**
     * Initialize the Intersection Observer
     */
    init() {
        // Check if Intersection Observer is supported
        if (!('IntersectionObserver' in window)) {
            console.warn('ScrollAnimations: IntersectionObserver not supported. Falling back to immediate animation.');
            this.fallbackAnimation();
            return;
        }

        // Create the observer
        this.observer = new IntersectionObserver(
            this.handleIntersection.bind(this),
            {
                threshold: this.config.threshold,
                rootMargin: this.config.rootMargin
            }
        );

        // Start observing elements
        this.observeElements();
    }

    /**
     * Find and observe all elements with the animation class
     */
    observeElements() {
        const elements = document.querySelectorAll(`.${this.config.animateClass}`);
        
        elements.forEach(element => {
            if (!this.observedElements.has(element)) {
                this.observer.observe(element);
                this.observedElements.add(element);
                
                if (this.config.debug) {
                    console.log('ScrollAnimations: Observing element', element);
                }
            }
        });
    }

    /**
     * Handle intersection changes
     * @param {IntersectionObserverEntry[]} entries
     */
    handleIntersection(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                this.animateElement(entry.target);
                // Stop observing this element after animation
                this.observer.unobserve(entry.target);
            }
        });
    }

    /**
     * Animate a single element
     * @param {HTMLElement} element
     */
    animateElement(element) {
        // Add the active class to trigger animation
        element.classList.add(this.config.activeClass);
        
        if (this.config.debug) {
            console.log('ScrollAnimations: Animating element', element);
        }
    }

    /**
     * Fallback for browsers without Intersection Observer support
     */
    fallbackAnimation() {
        const elements = document.querySelectorAll(`.${this.config.animateClass}`);
        elements.forEach(element => {
            // Small delay to ensure DOM is ready
            setTimeout(() => {
                element.classList.add(this.config.activeClass);
            }, 100);
        });
    }

    /**
     * Manually trigger animation for specific elements
     * @param {string|HTMLElement|NodeList} selector - CSS selector, element, or NodeList
     */
    triggerAnimation(selector) {
        let elements;
        
        if (typeof selector === 'string') {
            elements = document.querySelectorAll(selector);
        } else if (selector instanceof HTMLElement) {
            elements = [selector];
        } else if (selector instanceof NodeList) {
            elements = Array.from(selector);
        } else {
            console.error('ScrollAnimations: Invalid selector provided to triggerAnimation');
            return;
        }

        elements.forEach(element => {
            if (element.classList.contains(this.config.animateClass)) {
                this.animateElement(element);
            }
        });
    }

    /**
     * Reset animations for elements (useful for testing)
     * @param {string} selector - Optional CSS selector to reset specific elements
     */
    resetAnimations(selector = null) {
        const elements = selector 
            ? document.querySelectorAll(selector)
            : document.querySelectorAll(`.${this.config.animateClass}`);
            
        elements.forEach(element => {
            element.classList.remove(this.config.activeClass);
        });
    }

    /**
     * Destroy the observer and clean up
     */
    destroy() {
        if (this.observer) {
            this.observer.disconnect();
        }
        this.observedElements.clear();
    }
}

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Initialize scroll animations
    window.scrollAnimations = new ScrollAnimations({
        // Customize these options as needed
        threshold: 0.1,        // Trigger when 10% of element is visible
        rootMargin: '0px 0px -50px 0px', // Trigger 50px before element enters view
        debug: false           // Set to true for debugging
    });
});

// Export for manual usage if needed
window.ScrollAnimations = ScrollAnimations;
