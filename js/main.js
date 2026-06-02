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

// 8. Chatbot KAI Floating Widget Logic
const kaiTrigger = document.getElementById('kai-chat-trigger');
const kaiContainer = document.getElementById('kai-chat-container');
const kaiClose = document.getElementById('kai-chat-close');
const kaiMessages = document.getElementById('kai-chat-messages');
const kaiForm = document.getElementById('kai-chat-form');
const kaiInput = document.getElementById('kai-chat-input');

if (kaiTrigger && kaiContainer && kaiClose && kaiMessages && kaiForm && kaiInput) {
    // Helper to scroll messages to bottom
    const scrollToBottom = () => {
        kaiMessages.scrollTop = kaiMessages.scrollHeight;
    };

    // Toggle Chat visibility
    kaiTrigger.addEventListener('click', () => {
        const isHidden = kaiContainer.classList.contains('hidden');
        if (isHidden) {
            kaiContainer.classList.remove('hidden');
            kaiContainer.classList.add('active');
            scrollToBottom();
            kaiInput.focus();
        } else {
            kaiContainer.classList.add('hidden');
            kaiContainer.classList.remove('active');
        }
    });

    // Close Chat
    kaiClose.addEventListener('click', (e) => {
        e.stopPropagation();
        kaiContainer.classList.add('hidden');
        kaiContainer.classList.remove('active');
    });

    // Handle Form Submit
    kaiForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const userMessage = kaiInput.value.trim();
        if (!userMessage) return;

        // 1. Render User Message
        const userBubble = document.createElement('div');
        userBubble.className = 'chat-bubble-user px-4 py-3 max-w-[85%] leading-relaxed break-words';
        userBubble.textContent = userMessage;
        kaiMessages.appendChild(userBubble);
        
        // Clear input and scroll
        kaiInput.value = '';
        scrollToBottom();

        // 2. Render KAI Loading State
        const loadingBubble = document.createElement('div');
        loadingBubble.id = 'kai-loading-bubble';
        loadingBubble.className = 'flex gap-2';
        loadingBubble.innerHTML = `
            <div class="w-8 h-8 rounded-full bg-action flex items-center justify-center shadow-lg shrink-0">
                <i data-lucide="sparkles" class="text-primary w-4.5 h-4.5"></i>
            </div>
            <div class="chat-bubble-kai px-4 py-3 max-w-[85%] leading-relaxed flex items-center gap-1.5">
                <span class="text-white/80">KAI está analizando</span>
                <span class="flex gap-0.5 mt-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-white/70 animate-bounce" style="animation-delay: 0.1s"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-white/70 animate-bounce" style="animation-delay: 0.2s"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-white/70 animate-bounce" style="animation-delay: 0.3s"></span>
                </span>
            </div>
        `;
        kaiMessages.appendChild(loadingBubble);
        lucide.createIcons();
        scrollToBottom();

        const renderKaiReply = (reply) => {
            const kaiBubble = document.createElement('div');
            kaiBubble.className = 'flex gap-2';
            kaiBubble.innerHTML = `
                <div class="w-8 h-8 rounded-full bg-action flex items-center justify-center shadow-lg shrink-0">
                    <i data-lucide="sparkles" class="text-primary w-4.5 h-4.5"></i>
                </div>
                <div class="chat-bubble-kai px-4 py-3 max-w-[85%] leading-relaxed text-white">
                    ${formatMarkdown(reply)}
                </div>
            `;
            kaiMessages.appendChild(kaiBubble);
            lucide.createIcons();
            scrollToBottom();
        };

        const renderError = () => {
            const errorBubble = document.createElement('div');
            errorBubble.className = 'flex gap-2 text-red-400';
            errorBubble.innerHTML = `
                <div class="w-8 h-8 rounded-full bg-red-950 flex items-center justify-center shadow-lg shrink-0 border border-red-500/30">
                    <i data-lucide="alert-circle" class="w-4.5 h-4.5 text-red-400"></i>
                </div>
                <div class="chat-bubble-kai px-4 py-3 max-w-[85%] border-red-500/20 leading-relaxed text-red-400 font-medium">
                    Lo siento, ocurrió un error al procesar tu solicitud. Por favor intenta de nuevo o inicia tu prueba de 14 días gratis en <a href="https://ongoing2.mx" class="text-action underline">ongoing2.mx</a>.
                </div>
            `;
            kaiMessages.appendChild(errorBubble);
            lucide.createIcons();
            scrollToBottom();
        };

        // 3. Make fetch request to serverless endpoint
        try {
            const response = await fetch('/api/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ message: userMessage })
            });

            // Remove loading bubble
            const loader = document.getElementById('kai-loading-bubble');
            if (loader) loader.remove();

            if (!response.ok) {
                throw new Error(`Serverless endpoint returned status ${response.status}`);
            }

            const data = await response.json();
            const reply = data.response;
            renderKaiReply(reply);

        } catch (error) {
            console.warn('Serverless API failed, attempting local static fallback:', error);
            try {
                let localApiKey = window.OPENAI_API_KEY;
                
                if (!localApiKey) {
                    // Local static fallback: Try to load the .env file from the local server
                    let envResponse = await fetch('/.env');
                    if (!envResponse.ok) {
                        // Try relative path
                        envResponse = await fetch('.env');
                        if (!envResponse.ok) throw new Error('Could not fetch .env file');
                    }
                    
                    const envText = await envResponse.text();
                    // Parse key
                    const match = envText.match(/OPENAI_API_KEY\s*=\s*([^\s#]+)/);
                    if (!match || !match[1]) throw new Error('No API key found in local .env');
                    localApiKey = match[1].trim();
                }

                // Load llms.txt context locally
                let localContext = '';
                try {
                    let llmRes = await fetch('/llms.txt');
                    if (!llmRes.ok) {
                        llmRes = await fetch('llms.txt');
                    }
                    if (llmRes.ok) localContext = await llmRes.text();
                } catch(e) {
                    console.warn('Could not load llms.txt locally, running without context:', e);
                }

                // Call OpenAI direct from client
                const aiResponse = await fetch('https://api.openai.com/v1/chat/completions', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${localApiKey}`
                    },
                    body: JSON.stringify({
                        model: 'gpt-4o-mini',
                        messages: [
                            { 
                                role: 'system', 
                                content: `Eres KAI, el asistente de inteligencia artificial de OnGoing ERP ("La evolución del ERP en México"). Tu estilo de comunicación sigue el ADN "Deep Tech & Human Clarity": debes ser profesional, directo, claro y con español de México.
                                
                                Contexto:
                                ${localContext}

                                REGLAS:
                                1. Responde basándote únicamente en el contexto. Si no está en el contexto, indícalo y sugiere contactar a hola@ongoing.mx o iniciar la prueba gratis en https://ongoing2.mx.
                                2. Jailbreak Guard: Si preguntan sobre temas ajenos (recetas, poemas, chistes, etc.), debes negarte a responder de forma elegante y breve, sugiriendo iniciar la prueba de 14 días gratis en https://ongoing2.mx.`
                            },
                            { role: 'user', content: userMessage }
                        ],
                        temperature: 0.3
                    })
                });

                // Remove loading bubble if it is still there
                const loader = document.getElementById('kai-loading-bubble');
                if (loader) loader.remove();

                if (!aiResponse.ok) throw new Error('Direct OpenAI call failed');
                const aiData = await aiResponse.json();
                const reply = aiData.choices[0].message.content;
                renderKaiReply(reply);

            } catch (fallbackError) {
                console.error('Local fallback failed:', fallbackError);
                
                // Remove loading bubble
                const loader = document.getElementById('kai-loading-bubble');
                if (loader) loader.remove();

                renderError();
            }
        }
    });
}

// Simple helper to format basic bold and links from markdown
function formatMarkdown(text) {
    if (!text) return '';
    // Format bold: **text** -> <strong>text</strong>
    let formatted = text.replace(/\*\*(.*?)\*\*/g, '<strong class="text-action font-extrabold">$1</strong>');
    // Format links: [label](url) -> <a href="$2" target="_blank" class="text-action underline font-bold">$1</a>
    formatted = formatted.replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" target="_blank" class="text-action underline font-bold">$1</a>');
    // Format bullet points
    formatted = formatted.replace(/^\*\s(.*)$/gm, '• $1');
    // Replace newlines with <br>
    formatted = formatted.replace(/\n/g, '<br>');
    return formatted;
}

