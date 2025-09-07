# Scroll Animations System

This system provides smooth, scroll-triggered animations using the Intersection Observer API. It respects the browser's native scrolling behavior and only triggers animations once when elements enter the viewport.

## Features

- **Fade in + Slide up**: Elements fade from opacity 0 to 1 and slide up from 30px below their final position
- **One-time trigger**: Animations only happen once when elements enter the viewport
- **Staggered animations**: Support for delayed animations using delay classes
- **Customizable**: Easy to adjust duration, delay, and easing
- **Performance optimized**: Uses Intersection Observer API for efficient scroll detection
- **Fallback support**: Graceful degradation for browsers without Intersection Observer

## Usage

### Basic Animation

Add the `scroll-animate` class to any element you want to animate:

```html
<div class="scroll-animate">
    <h2>This will fade in and slide up when scrolled into view</h2>
</div>
```

### Staggered Animations

Use delay classes to create staggered effects:

```html
<div class="scroll-animate delay-100">First item</div>
<div class="scroll-animate delay-200">Second item</div>
<div class="scroll-animate delay-300">Third item</div>
<div class="scroll-animate delay-400">Fourth item</div>
<div class="scroll-animate delay-500">Fifth item</div>
```

### Custom Duration

Override the default 0.6s duration:

```html
<div class="scroll-animate duration-fast">Fast animation (0.4s)</div>
<div class="scroll-animate duration-slow">Slow animation (0.8s)</div>
```

### Custom Easing

Override the default ease-out timing:

```html
<div class="scroll-animate ease-in">Ease in animation</div>
<div class="scroll-animate ease-in-out">Ease in-out animation</div>
```

## Available Classes

### Animation Classes
- `scroll-animate` - Base animation class (required)
- `animate-in` - Applied automatically when element enters viewport

### Delay Classes
- `delay-100` - 0.1s delay
- `delay-200` - 0.2s delay
- `delay-300` - 0.3s delay
- `delay-400` - 0.4s delay
- `delay-500` - 0.5s delay

### Duration Classes
- `duration-fast` - 0.4s duration
- `duration-slow` - 0.8s duration
- Default - 0.6s duration

### Easing Classes
- `ease-in` - Ease in timing
- `ease-out` - Ease out timing (default)
- `ease-in-out` - Ease in-out timing

## Configuration

The animation system can be configured by modifying the JavaScript initialization:

```javascript
window.scrollAnimations = new ScrollAnimations({
    threshold: 0.1,        // Trigger when 10% of element is visible
    rootMargin: '0px 0px -50px 0px', // Trigger 50px before element enters view
    debug: false           // Set to true for debugging
});
```

## JavaScript API

### Manual Trigger

Trigger animations manually for specific elements:

```javascript
// Trigger by selector
window.scrollAnimations.triggerAnimation('.my-elements');

// Trigger by element
window.scrollAnimations.triggerAnimation(document.getElementById('my-element'));

// Trigger by NodeList
window.scrollAnimations.triggerAnimation(document.querySelectorAll('.my-elements'));
```

### Reset Animations

Reset animations for testing:

```javascript
// Reset all animations
window.scrollAnimations.resetAnimations();

// Reset specific elements
window.scrollAnimations.resetAnimations('.my-elements');
```

### Destroy

Clean up the observer:

```javascript
window.scrollAnimations.destroy();
```

## Files

- `resources/css/scroll-animations.css` - CSS styles and animations
- `resources/js/scroll-animations.js` - JavaScript logic and Intersection Observer
- `vite.config.js` - Updated to include the new files

## Browser Support

- Modern browsers with Intersection Observer API support
- Graceful fallback for older browsers (animations trigger immediately)

## Performance Notes

- Uses Intersection Observer API for efficient scroll detection
- Elements are unobserved after animation to prevent memory leaks
- CSS transitions are hardware-accelerated for smooth performance
- Minimal JavaScript footprint with no external dependencies
