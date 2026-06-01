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

// Mobile Menu Removed

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

// 5. Contact Form Submission
const contactForm = document.getElementById('contact-form');
if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const submitBtn = contactForm.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.innerHTML = 'Enviando... <i data-lucide="loader" class="w-5 h-5 animate-spin inline-block"></i>';
        submitBtn.disabled = true;
        lucide.createIcons();
        
        const formData = new FormData(contactForm);
        const data = Object.fromEntries(formData.entries());
        data.origen = 'https://ongoing.mx';
        
        try {
            const response = await fetch('https://n8n.ongoing.mx/webhook/a800a483-b21f-43d1-952f-be121bd9027b', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'ongoing': 'Huo0lpaw.',
                    'Authorization': 'Basic ' + btoa('ongoing:Huo0lpaw.')
                },
                body: JSON.stringify(data)
            });
            
            if (response.ok) {
                submitBtn.innerHTML = 'Mensaje Enviado <i data-lucide="check" class="w-5 h-5 inline-block"></i>';
                submitBtn.classList.add('bg-green-500', 'text-white');
                submitBtn.classList.remove('bg-action', 'text-primary');
                contactForm.reset();
            } else {
                throw new Error('Error de red');
            }
        } catch (error) {
            console.error('Error al enviar formulario:', error);
            submitBtn.innerHTML = 'Error al enviar <i data-lucide="alert-circle" class="w-5 h-5 inline-block"></i>';
            submitBtn.classList.add('bg-red-500', 'text-white');
            submitBtn.classList.remove('bg-action', 'text-primary');
        }
        
        lucide.createIcons();
        
        // Regresar el botón a su estado original después de 4 segundos
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            submitBtn.classList.remove('bg-green-500', 'bg-red-500', 'text-white');
            if(!submitBtn.classList.contains('bg-action')) {
                 submitBtn.classList.add('bg-action', 'text-primary');
            }
            lucide.createIcons();
        }, 4000);
    });
}

// 6. Hero Interactive App Logic
const heroBtnCrm = document.getElementById('hero-btn-crm');
const heroBtnProyectos = document.getElementById('hero-btn-proyectos');
const heroPanelCrm = document.getElementById('hero-panel-crm');
const heroPanelProyectos = document.getElementById('hero-panel-proyectos');

if (heroBtnCrm && heroBtnProyectos && heroPanelCrm && heroPanelProyectos) {
    heroBtnCrm.addEventListener('click', () => {
        // Toggle Buttons
        heroBtnCrm.classList.add('active', 'text-white', 'bg-action/20', 'border-action/30');
        heroBtnCrm.classList.remove('text-secondary', 'border-transparent');
        
        heroBtnProyectos.classList.remove('active', 'text-white', 'bg-action/20', 'border-action/30');
        heroBtnProyectos.classList.add('text-secondary', 'border-transparent');
        
        // Toggle Panels
        heroPanelProyectos.classList.add('hidden');
        heroPanelProyectos.classList.remove('active');
        heroPanelProyectos.style.opacity = '0';
        
        heroPanelCrm.classList.remove('hidden');
        heroPanelCrm.classList.add('active');
        setTimeout(() => {
            heroPanelCrm.style.opacity = '1';
        }, 30);
    });

    heroBtnProyectos.addEventListener('click', () => {
        // Toggle Buttons
        heroBtnProyectos.classList.add('active', 'text-white', 'bg-action/20', 'border-action/30');
        heroBtnProyectos.classList.remove('text-secondary', 'border-transparent');
        
        heroBtnCrm.classList.remove('active', 'text-white', 'bg-action/20', 'border-action/30');
        heroBtnCrm.classList.add('text-secondary', 'border-transparent');
        
        // Toggle Panels
        heroPanelCrm.classList.add('hidden');
        heroPanelCrm.classList.remove('active');
        heroPanelCrm.style.opacity = '0';
        
        heroPanelProyectos.classList.remove('hidden');
        heroPanelProyectos.classList.add('active');
        setTimeout(() => {
            heroPanelProyectos.style.opacity = '1';
        }, 30);
    });
}

// 7. Drag & Drop Simulation handlers (Global scope)
window.allowDrop = function(ev) {
    ev.preventDefault();
    const col = ev.target.closest('.bg-white\\/5');
    if (col) {
        col.classList.add('drag-over');
    }
};

window.dragCard = function(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
};

window.dragLeave = function(ev) {
    const col = ev.target.closest('.bg-white\\/5');
    if (col) {
        col.classList.remove('drag-over');
    }
};

window.dropCard = function(ev, colId) {
    ev.preventDefault();
    const data = ev.dataTransfer.getData("text");
    const card = document.getElementById(data);
    const col = ev.currentTarget;
    if (col && card) {
        col.classList.remove('drag-over');
        col.appendChild(card);
    }
};

// Bind dragleave programmatically to clean up styling robustly
document.addEventListener('DOMContentLoaded', () => {
    const columns = document.querySelectorAll('[ondrop]');
    columns.forEach(col => {
        col.addEventListener('dragleave', (ev) => {
            col.classList.remove('drag-over');
        });
    });
});
