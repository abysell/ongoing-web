// Initialize Lucide Icons
lucide.createIcons();

// 1. Sticky Header Logic
const header = document.getElementById('main-header');
window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        header.classList.add('glass-header');
        header.classList.remove('py-4');
        header.classList.add('py-3');
    } else {
        header.classList.remove('glass-header');
        header.classList.add('py-4');
        header.classList.remove('py-3');
    }
});

// Mobile Menu Toggle
const mobileBtn = document.getElementById('mobile-menu-btn');
const mobileMenu = document.getElementById('mobile-menu');
mobileBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
    mobileMenu.classList.toggle('flex');
});

// 2. KAI Tabs Logic
const tabBtns = document.querySelectorAll('.tab-btn');
const tabContents = document.querySelectorAll('.tab-content');

tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        // Remove active classes
        tabBtns.forEach(b => {
            b.classList.remove('active', 'border-action', 'text-white');
            b.classList.add('border-transparent', 'text-secondary');
        });
        
        tabContents.forEach(c => {
            c.classList.remove('active');
            // Reset animation trigger
            c.style.opacity = '0';
        });

        // Add active to clicked
        btn.classList.add('active', 'border-action', 'text-white');
        btn.classList.remove('border-transparent', 'text-secondary');
        
        const targetId = btn.getAttribute('data-tab');
        const targetContent = document.getElementById(targetId);
        
        targetContent.classList.add('active');
        
        // Small delay to allow display:block to apply before animating opacity
        setTimeout(() => {
            targetContent.style.opacity = '1';
        }, 10);
    });
});

// 2.5 Section 3 Tabs Logic
const s3TabBtns = document.querySelectorAll('.s3-tab-btn');
const s3TabContents = document.querySelectorAll('.s3-tab-content');

s3TabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        // Remove active styling from all tabs
        s3TabBtns.forEach(b => {
            b.classList.remove('active', 'border-blue-600', 'text-blue-600');
            b.classList.add('border-transparent', 'text-gray-500');
        });
        
        // Hide all contents
        s3TabContents.forEach(c => {
            c.classList.remove('active');
            c.classList.add('hidden');
            c.style.opacity = '0';
        });

        // Add active to clicked tab
        btn.classList.add('active', 'border-blue-600', 'text-blue-600');
        btn.classList.remove('border-transparent', 'text-gray-500');
        
        // Show matching content
        const targetId = btn.getAttribute('data-tab');
        const targetContent = document.getElementById(targetId);
        
        targetContent.classList.remove('hidden');
        targetContent.classList.add('active');
        
        // Small delay for smooth CSS transition to kick in after display switch
        setTimeout(() => {
            targetContent.style.opacity = '1';
        }, 30);
    });
});

// 3. Intersection Observer for Fade-Up Animations
const fadeElements = document.querySelectorAll('.fade-up');

const appearOptions = {
    threshold: 0.15,
    rootMargin: "0px 0px -50px 0px"
};

const appearOnScroll = new IntersectionObserver(function(entries, observer) {
    entries.forEach(entry => {
        if (!entry.isIntersecting) {
            return;
        } else {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
        }
    });
}, appearOptions);

fadeElements.forEach(el => appearOnScroll.observe(el));

// 4. Implementación IA Slider Logic
const slider = document.getElementById('ai-slider');
const dots = document.querySelectorAll('.ai-slider-dot');
let currentSlide = 0;
let slideInterval;

function goToSlide(index) {
    if (!slider) return;
    slider.style.transform = `translateX(-${index * 100}%)`;
    
    // Update dots styling
    dots.forEach((dot, i) => {
        if(i === index) {
            dot.classList.remove('w-2', 'bg-white/30');
            dot.classList.add('w-6', 'bg-white');
        } else {
            dot.classList.remove('w-6', 'bg-white');
            dot.classList.add('w-2', 'bg-white/30');
        }
    });
    currentSlide = index;
}

// Auto slide
function startSlideShow() {
    if (!slider || dots.length === 0) return;
    slideInterval = setInterval(() => {
        let next = (currentSlide + 1) % dots.length;
        goToSlide(next);
    }, 4500);
}

// Click events for dots
if (slider && dots.length > 0) {
    dots.forEach(dot => {
        dot.addEventListener('click', (e) => {
            clearInterval(slideInterval);
            goToSlide(parseInt(e.target.dataset.slide));
            startSlideShow(); // restart interval on manual change
        });
    });
    
    startSlideShow();
}
