// Lazy Loading for images with class 'lazyload'
document.addEventListener('DOMContentLoaded', function() {
    // Check if Intersection Observer is supported
    if ('IntersectionObserver' in window) {
        // Get all images with lazyload class
        const lazyImages = document.querySelectorAll('img.lazyload');
        
        // Create intersection observer
        const imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    
                    // Get the data-src attribute
                    const src = img.getAttribute('data-src');
                    
                    if (src) {
                        // Create a new image to test loading
                        const imageLoader = new Image();
                        
                        imageLoader.onload = function() {
                            // Image loaded successfully, update the actual img
                            img.src = src;
                            img.classList.remove('lazyload');
                            img.classList.add('lazyloaded');
                            
                            // Remove data-src attribute
                            img.removeAttribute('data-src');
                        };
                        
                        imageLoader.onerror = function() {
                            // Image failed to load, add error class
                            img.classList.remove('lazyload');
                            img.classList.add('lazyerror');
                        };
                        
                        // Start loading the image
                        imageLoader.src = src;
                    }
                    
                    // Stop observing this image
                    observer.unobserve(img);
                }
            });
        }, {
            // Load image when it's 100px away from entering viewport
            rootMargin: '100px 0px',
            threshold: 0.01
        });
        
        // Start observing all lazy images
        lazyImages.forEach(function(img) {
            imageObserver.observe(img);
        });
        
    } else {
        // Fallback for browsers that don't support Intersection Observer
        const lazyImages = document.querySelectorAll('img.lazyload');
        
        function loadImages() {
            lazyImages.forEach(function(img) {
                if (img.getBoundingClientRect().top < window.innerHeight && img.getBoundingClientRect().bottom > 0) {
                    const src = img.getAttribute('data-src');
                    if (src) {
                        img.src = src;
                        img.classList.remove('lazyload');
                        img.classList.add('lazyloaded');
                        img.removeAttribute('data-src');
                    }
                }
            });
        }
        
        // Load images on scroll and resize
        window.addEventListener('scroll', loadImages);
        window.addEventListener('resize', loadImages);
        
        // Initial load
        loadImages();
    }
    
    // Also handle dynamically added images
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(node) {
                if (node.nodeType === 1) { // Element node
                    const lazyImages = node.querySelectorAll ? node.querySelectorAll('img.lazyload') : [];
                    lazyImages.forEach(function(img) {
                        if ('IntersectionObserver' in window) {
                            imageObserver.observe(img);
                        }
                    });
                }
            });
        });
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});

// Add CSS for lazy loading states
const style = document.createElement('style');
style.textContent = `
    img.lazyload {
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    img.lazyloaded {
        opacity: 1;
    }
    
    img.lazyerror {
        opacity: 0.5;
        background-color: #f0f0f0;
    }
`;
document.head.appendChild(style);