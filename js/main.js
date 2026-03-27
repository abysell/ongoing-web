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
