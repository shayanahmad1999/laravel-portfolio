/**
 * Custom animations and interactive effects for Laravel Portfolio
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize scroll animations
    initScrollAnimations();
    
    // Initialize staggered animations
    initStaggeredAnimations();
    
    // Add hover effects to cards
    initCardHoverEffects();
    
    // Initialize skill bars animation
    initSkillBars();
});

/**
 * Initialize scroll-based animations
 */
function initScrollAnimations() {
    const fadeElements = document.querySelectorAll('.fade-in-scroll');
    
    // Initial check for elements in viewport
    checkElementsInViewport(fadeElements);
    
    // Check on scroll
    window.addEventListener('scroll', function() {
        checkElementsInViewport(fadeElements);
    });
}

/**
 * Check if elements are in viewport and add 'visible' class
 */
function checkElementsInViewport(elements) {
    elements.forEach(element => {
        const position = element.getBoundingClientRect();
        
        // Check if element is in viewport
        if(position.top < window.innerHeight * 0.9) {
            element.classList.add('visible');
        }
    });
}

/**
 * Initialize staggered animations for list items
 */
function initStaggeredAnimations() {
    const staggerContainers = document.querySelectorAll('[data-stagger="container"]');
    
    staggerContainers.forEach(container => {
        const items = container.querySelectorAll('.stagger-item');
        
        // Add show class with delay
        items.forEach((item, index) => {
            setTimeout(() => {
                item.classList.add('show');
            }, 100 * index);
        });
    });
}

/**
 * Add hover effects to cards
 */
function initCardHoverEffects() {
    const cards = document.querySelectorAll('.card-hover-effect');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.classList.add('hover');
        });
        
        card.addEventListener('mouseleave', function() {
            this.classList.remove('hover');
        });
    });
}

/**
 * Initialize skill bars animation
 */
function initSkillBars() {
    const skillBars = document.querySelectorAll('.skill-bar');
    
    // Function to animate skill bars when they come into view
    function animateSkillBars() {
        skillBars.forEach(bar => {
            const position = bar.getBoundingClientRect();
            
            if(position.top < window.innerHeight * 0.9) {
                const progressBar = bar.querySelector('.skill-progress');
                if(progressBar && progressBar.dataset.width) {
                    progressBar.style.width = progressBar.dataset.width;
                }
            }
        });
    }
    
    // Initial check
    animateSkillBars();
    
    // Check on scroll
    window.addEventListener('scroll', animateSkillBars);
}

/**
 * Add typing animation to an element
 * @param {HTMLElement} element - The element to add typing animation to
 * @param {string} text - The text to type
 * @param {number} speed - Typing speed in milliseconds
 */
function typeText(element, text, speed = 100) {
    let i = 0;
    element.innerHTML = '';
    
    const cursor = document.createElement('span');
    cursor.className = 'typing-cursor';
    element.parentNode.appendChild(cursor);
    
    const typing = setInterval(() => {
        if (i < text.length) {
            element.innerHTML += text.charAt(i);
            i++;
        } else {
            clearInterval(typing);
        }
    }, speed);
}

/**
 * Add floating animation to elements
 */
function addFloatingAnimation() {
    const elements = document.querySelectorAll('.floating');
    
    elements.forEach(element => {
        // Add random delay to create natural effect
        const delay = Math.random() * 2;
        element.style.animationDelay = `${delay}s`;
    });
}

/**
 * Initialize page transition effects
 */
function initPageTransitions() {
    document.addEventListener('DOMContentLoaded', () => {
        document.body.classList.add('page-enter-active');
    });
    
    // Add page exit animation before navigating away
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Only for internal links
            if (href && href.indexOf('#') !== 0 && href.indexOf('http') !== 0) {
                e.preventDefault();
                document.body.classList.remove('page-enter-active');
                document.body.classList.add('page-exit');
                
                setTimeout(() => {
                    window.location.href = href;
                }, 500);
            }
        });
    });
}