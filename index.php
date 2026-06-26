<?php
// Configurar zona horaria local de la Ciudad de México
date_default_timezone_set('America/Mexico_City');

// Lógica de lectura de variables de entorno y procesamiento POST
if (!function_exists('env')) {
    function env($key, $default = null) {
        $value = getenv($key);
        if ($value !== false) return $value;
        if (isset($_ENV[$key])) return $_ENV[$key];
        if (isset($_SERVER[$key])) return $_SERVER[$key];

        static $env = null;
        if ($env === null) {
            $env = [];
            $envPath = __DIR__ . '/.env';
            if (file_exists($envPath)) {
                $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ($lines as $line) {
                    if (strpos(trim($line), '#') === 0) continue;
                    $parts = explode('=', $line, 2);
                    if (count($parts) === 2) {
                        $name = trim($parts[0]);
                        $val = trim($parts[1]);
                        if (preg_match('/^"([^"]*)"$/', $val, $matches) || preg_match("/^'([^']*)'$/", $val, $matches)) {
                            $val = $matches[1];
                        }
                        $env[$name] = $val;
                    }
                }
            }
        }
        return isset($env[$key]) ? $env[$key] : $default;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        
        // Registro de prospecto (Lead) en base de datos local
        /*
        try {
            $pdo = new PDO("mysql:host=" . env('DB_HOST', 'localhost') . ";dbname=" . env('DB_DATABASE', 'ongoing'), env('DB_USERNAME', 'root'), env('DB_PASSWORD', ''));
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("INSERT INTO leads (email, created_at) VALUES (:email, NOW())");
            $stmt->execute(['email' => $email]);
        } catch (PDOException $e) {
            error_log("Error al guardar lead en DB: " . $e->getMessage());
        }
        */

        // Generación de token criptográfico temporal y redirección
        $secret = env('ONGOING_DEMO_SECRET');
        $timestamp = time();
        $token = hash_hmac('sha256', (string)$timestamp, $secret);
        $redirectUrl = "https://demo.ongoing2.mx/demo-login?timestamp={$timestamp}&token={$token}";

        header("Location: " . $redirectUrl);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OnGoing | Software Todo en Uno: CRM, ERP y Gestión de Tareas con IA</title>
    <meta name="description" content="Centraliza tus ventas, inventarios, proyectos y contabilidad en una sola plataforma en la nube. Deja de brincar entre aplicaciones y toma el control de tu empresa con el asistente de IA KAI.">
    <link rel="canonical" href="https://ongoing.mx/">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-17435181220"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'AW-17435181220');
    </script>
    
    <!-- OpenGraph Metadata -->
    <meta property="og:title" content="Ongoing - La evolución del ERP en México">
    <meta property="og:description" content="OnGoing V2 es la evolución del ERP en México. Una plataforma en la nube impulsada por el asistente de IA KAI para gestionar tu CRM, inventario, proyectos y finanzas.">
    <meta property="og:image" content="https://ongoing.mx/lp/img/real_dashboard.png">
    <meta property="og:url" content="https://ongoing.mx/">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="OnGoing ERP">
    
    <!-- Twitter Card Metadata -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Ongoing - La evolución del ERP en México">
    <meta name="twitter:description" content="OnGoing V2 es la evolución del ERP en México. Una plataforma en la nube impulsada por el asistente de IA KAI para gestionar tu CRM, inventario, proyectos y finanzas.">
    <meta name="twitter:image" content="https://ongoing.mx/lp/img/real_dashboard.png">
    <meta name="twitter:site" content="@ongoing_mx">

    <link rel="icon" type="image/png" href="img/favicon-ongoing.png">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;800&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        primary: '#001953',
                        action: '#00c0ff',
                        dark: '#000b2e',
                        light: '#F5F7FA',
                    }
                }
            }
        }
    </script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- JSON-LD Schema Markup -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "Organization",
          "@id": "https://ongoing.mx/#organization",
          "name": "OnGoing",
          "url": "https://ongoing.mx/",
          "logo": {
            "@type": "ImageObject",
            "@id": "https://ongoing.mx/#logo",
            "url": "https://ongoing.mx/img/ongoing-logo.png",
            "caption": "OnGoing Logo"
          },
          "image": {
            "@id": "https://ongoing.mx/#logo"
          },
          "sameAs": [
            "https://x.com/ongoing_mx",
            "https://www.linkedin.com/company/ongoing-mx"
          ]
        },
        {
          "@type": "WebSite",
          "@id": "https://ongoing.mx/#website",
          "url": "https://ongoing.mx/",
          "name": "OnGoing",
          "description": "OnGoing V2 es la evolución del ERP en México. Una plataforma en la nube impulsada por el asistente de IA KAI.",
          "publisher": {
            "@id": "https://ongoing.mx/#organization"
          }
        },
        {
          "@type": "SoftwareApplication",
          "@id": "https://ongoing.mx/lp/#software",
          "name": "OnGoing ERP V2",
          "operatingSystem": "Web / Cloud-Based",
          "applicationCategory": "BusinessApplication",
          "publisher": {
            "@id": "https://ongoing.mx/#organization"
          },
          "offers": {
            "@type": "Offer",
            "price": "1000",
            "priceCurrency": "MXN",
            "priceSpecification": {
              "@type": "UnitPriceSpecification",
              "price": "1000",
              "priceCurrency": "MXN",
              "referenceQuantity": {
                "@type": "QuantitativeValue",
                "value": "1",
                "unitCode": "MON"
              },
              "description": "Suscripción mensual por usuario"
            }
          },
          "featureList": "Asistente de IA KAI, CRM B2B, Inventario Multialmacén, Gestión de Proyectos PSA, Facturación CFDI 4.0"
        }
      ]
    }
    </script>
    <link rel="llms" href="llms.txt" type="text/plain">
</head>

<body class="antialiased overflow-x-hidden">

    <!-- A. Sticky Header (Navegación) -->
    <header id="main-header" class="fixed top-0 w-full z-50 transition-all duration-300 py-4">
        <div class="container mx-auto px-6 max-w-7xl flex items-center justify-between">
            <!-- Logo -->
            <a href="#" class="flex items-center transition-opacity hover:opacity-80 outline-none">
                <img src="img/ongoing-logo.png" alt="Ongoing Logo" class="h-8 md:h-[38px] w-auto">
            </a>

            <!-- Desktop Links (Centered Navigation) -->
            <div class="hidden md:flex items-center gap-6 mx-auto">
                <a href="lp/index.html" class="text-white/80 hover:text-action font-semibold text-sm transition-colors">Flagship KAI</a>
                <a href="lp/crm.html" class="text-white/80 hover:text-action font-semibold text-sm transition-colors">CRM</a>
                <a href="lp/inventario.html" class="text-white/80 hover:text-action font-semibold text-sm transition-colors">Inventario</a>
                <a href="lp/servicios.html" class="text-white/80 hover:text-action font-semibold text-sm transition-colors">Servicios</a>
                <a href="lp/finanzas.html" class="text-white/80 hover:text-action font-semibold text-sm transition-colors">Finanzas</a>
            </div>

            <!-- Desktop Navigation (Derecha / Botones) -->
            <div class="hidden md:flex items-center gap-4">
                <a href="docs/" class="text-white/85 hover:text-action font-semibold text-sm md:text-[15px] transition-colors mr-2">
                    Documentaci&oacute;n
                </a>
                <a href="https://ongoing2.mx/login" class="text-white hover:text-action font-semibold text-sm md:text-[15px] transition-colors">
                    Ingresar
                </a>
                <a href="https://ongoing2.mx" class="bg-action text-primary font-bold py-2 md:py-2.5 px-5 md:px-7 rounded-full hover:bg-opacity-90 transition-all text-sm md:text-[15px] shadow-[0_0_15px_rgba(0,192,255,0.3)]">
                    Empieza Gratis
                </a>
            </div>

            <!-- Mobile Menu Toggle Button -->
            <button id="mobile-menu-btn" class="flex md:hidden p-2 text-white hover:text-action transition-colors focus:outline-none" aria-label="Toggle Menu">
                <i data-lucide="menu" id="mobile-menu-icon-open" class="w-6 h-6"></i>
                <i data-lucide="x" id="mobile-menu-icon-close" class="w-6 h-6 hidden"></i>
            </button>
        </div>

        <!-- Mobile Navigation Panel -->
        <div id="mobile-nav-panel" class="hidden absolute top-full left-0 w-full bg-[#000b2e]/95 backdrop-blur-lg border-b border-white/10 flex flex-col px-6 py-6 gap-4 shadow-2xl z-40">
            <a href="lp/index.html" class="text-white/80 hover:text-action font-semibold text-[15px] transition-colors py-2 border-b border-white/5">
                Flagship KAI
            </a>
            <a href="lp/crm.html" class="text-white/80 hover:text-action font-semibold text-[15px] transition-colors py-2 border-b border-white/5">
                CRM Comercial
            </a>
            <a href="lp/inventario.html" class="text-white/80 hover:text-action font-semibold text-[15px] transition-colors py-2 border-b border-white/5">
                Inventario y Log&iacute;stica
            </a>
            <a href="lp/servicios.html" class="text-white/80 hover:text-action font-semibold text-[15px] transition-colors py-2 border-b border-white/5">
                Servicios (PSA)
            </a>
            <a href="lp/finanzas.html" class="text-white/80 hover:text-action font-semibold text-[15px] transition-colors py-2 border-b border-white/5">
                Control Financiero
            </a>
            <a href="docs/" class="text-white/80 hover:text-action font-semibold text-[15px] transition-colors py-2 border-b border-white/5">
                Documentaci&oacute;n
            </a>
            <a href="https://ongoing2.mx/login" class="text-white/80 hover:text-action font-semibold text-[15px] transition-colors py-2 border-b border-white/5">
                Ingresar
            </a>
            <a href="https://ongoing2.mx" class="bg-action text-primary text-center font-bold py-3.5 px-6 rounded-full hover:bg-opacity-90 transition-all text-[15px] shadow-[0_0_15px_rgba(0,192,255,0.3)] mt-2">
                Empieza Gratis
            </a>
        </div>
    </header>

    <!-- B. Hero Section -->
    <section class="min-h-screen flex items-center pt-24 pb-12 relative overflow-hidden">
        <div class="w-full px-6 md:px-10 lg:px-20 grid lg:grid-cols-2 gap-12 items-center">

            <!-- Texto Izquierda -->
            <div class="flex flex-col gap-6 z-10 fade-up">
                <div
                    class="inline-flex items-center gap-2 text-action font-medium text-sm bg-action/10 px-3 py-1.5 rounded-full w-fit border border-action/20">
                    La evolución del ERP en México
                </div>

                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold leading-[1.1] tracking-tight text-white">
                    Gestiona tus clientes, finanzas y tareas <span class="text-transparent bg-clip-text bg-gradient-to-r from-action to-blue-400">desde un solo software</span>
                </h1>

                <p class="text-lg md:text-xl text-secondary max-w-xl leading-relaxed font-medium">
                    OnGoing combina el poder de un CRM, un ERP y un sistema de gestión de tareas con IA para que dejes de brincar entre aplicaciones y tomes el control total de tu empresa.
                </p>

                <!-- Botones Hero -->
                <div class="flex flex-col sm:flex-row gap-4 mt-4 items-center sm:items-start max-w-md sm:max-w-none w-full">
                    <div class="flex flex-col gap-2 w-full sm:w-auto">
                        <a href="#demo-conversion"
                            class="bg-action text-primary font-bold py-4 px-8 rounded-full text-center hover:bg-opacity-90 transition-all block w-full shadow-[0_0_20px_rgba(0,192,255,0.4)] text-[16px]">
                            Probar Demo Al Instante ⚡
                        </a>
                        <span class="text-[11px] text-gray-400 text-center font-medium">1 usuario gratis para siempre. Sin tarjeta de crédito.</span>
                    </div>
                </div>
            </div>

            <!-- Visual Derecha: Micro-Product App -->
            <div class="relative z-10 fade-up flex justify-center items-center w-full lg:w-[120%] lg:-ml-12 mt-12 lg:mt-0">
                <div class="w-full max-w-lg bg-[#070d1e]/90 rounded-[2rem] border border-white/10 shadow-[0_30px_60px_rgba(0,0,0,0.8)] overflow-hidden flex flex-col backdrop-blur-xl">
                    <!-- App Title / Header Bar -->
                    <div class="flex items-center justify-between px-6 py-4 border-b border-white/5 bg-[#0a1329]">
                        <div class="flex items-center gap-2">
                            <div class="w-3.5 h-3.5 rounded-full bg-action/20 flex items-center justify-center">
                                <span class="w-1.5 h-1.5 rounded-full bg-action animate-pulse"></span>
                            </div>
                            <span class="text-xs font-extrabold uppercase tracking-widest text-action">ongoing2.mx</span>
                        </div>
                        <!-- Tab Selectors -->
                        <div class="flex gap-2">
                            <button id="hero-btn-crm" class="hero-tab-btn active px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all text-white bg-action/20 border border-action/30">
                                Ver CRM
                            </button>
                            <button id="hero-btn-proyectos" class="hero-tab-btn px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all text-secondary hover:text-white border border-transparent">
                                Ver Proyectos
                            </button>
                        </div>
                    </div>

                    <!-- Panel Content -->
                    <div class="p-6 h-[320px] relative overflow-hidden flex flex-col justify-between">
                        <!-- CRM View -->
                        <div id="hero-panel-crm" class="hero-panel active flex flex-col gap-4 h-full transition-opacity duration-300 w-full">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-gray-400">Embudo de Ventas (Simulado con arrastrar/soltar)</span>
                                <span class="text-[10px] bg-green-500/20 text-green-400 font-bold px-2 py-0.5 rounded-full">CRM Activo</span>
                            </div>
                            <!-- Kanban Columns -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 flex-grow overflow-hidden pb-2">
                                <!-- Column 1: Prospectos -->
                                <div class="bg-white/5 rounded-xl p-2.5 flex flex-col gap-2 min-h-[180px] border border-white/5" ondragover="allowDrop(event)" ondrop="dropCard(event, 'col-prospectos')">
                                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Prospectos</h4>
                                    <div id="card-1" draggable="true" ondragstart="dragCard(event)" class="bg-[#0b1329] p-2.5 rounded-lg border border-white/10 cursor-grab active:cursor-grabbing hover:border-action/40 transition-colors shadow-md">
                                        <p class="text-[11px] font-bold text-white mb-1">Alimentro S.A.</p>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-[9px] text-[#00c0ff] font-semibold">$35,000 MXN</span>
                                            <i data-lucide="grab" class="w-3 h-3 text-gray-500"></i>
                                        </div>
                                    </div>
                                    <div id="card-2" draggable="true" ondragstart="dragCard(event)" class="bg-[#0b1329] p-2.5 rounded-lg border border-white/10 cursor-grab active:cursor-grabbing hover:border-action/40 transition-colors shadow-md">
                                        <p class="text-[11px] font-bold text-white mb-1">Macero Corp</p>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-[9px] text-[#00c0ff] font-semibold">$82,000 MXN</span>
                                            <i data-lucide="grab" class="w-3 h-3 text-gray-500"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column 2: Negociación -->
                                <div class="bg-white/5 rounded-xl p-2.5 hidden md:flex flex-col gap-2 min-h-[180px] border border-white/5" ondragover="allowDrop(event)" ondrop="dropCard(event, 'col-negociacion')">
                                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Negociación</h4>
                                    <div id="card-3" draggable="true" ondragstart="dragCard(event)" class="bg-[#0b1329] p-2.5 rounded-lg border border-white/10 cursor-grab active:cursor-grabbing hover:border-action/40 transition-colors shadow-md">
                                        <p class="text-[11px] font-bold text-white mb-1">Apetit México</p>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-[9px] text-[#00c0ff] font-semibold">$54,000 MXN</span>
                                            <i data-lucide="grab" class="w-3 h-3 text-gray-500"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column 3: Cerrado -->
                                <div class="bg-white/5 rounded-xl p-2.5 hidden md:flex flex-col gap-2 min-h-[180px] border border-white/5" ondragover="allowDrop(event)" ondrop="dropCard(event, 'col-cerrado')">
                                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Cerrado</h4>
                                </div>
                            </div>
                        </div>

                        <!-- Proyectos View -->
                        <div id="hero-panel-proyectos" class="hero-panel hidden flex flex-col gap-4 h-full transition-opacity duration-300 opacity-0 w-full">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-gray-400">Control de Proyectos y Tiempos de Entrega</span>
                                <span class="text-[10px] bg-red-500/20 text-red-400 font-bold px-2 py-0.5 rounded-full flex items-center gap-1 animate-pulse"><i data-lucide="alert-triangle" class="w-3 h-3"></i> Alerta Activa</span>
                            </div>
                            
                            <!-- Project Graph Columns / Bars -->
                            <div class="flex-grow flex flex-col gap-4 justify-center">
                                <!-- Project Alpha (Alert) -->
                                <div class="flex flex-col gap-1.5">
                                    <div class="flex justify-between text-xs font-bold">
                                        <span class="text-red-400 font-extrabold flex items-center gap-1">Proyecto Alpha (Desviación Detectada)</span>
                                        <span class="text-white">95h / 80h presupuesto</span>
                                    </div>
                                    <div class="w-full bg-white/5 rounded-full h-3.5 overflow-hidden border border-white/10 relative">
                                        <div class="bg-gradient-to-r from-red-600 to-red-400 h-full rounded-full animate-pulse shadow-[0_0_10px_rgba(239,68,68,0.5)]" style="width: 100%"></div>
                                    </div>
                                    <p class="text-[10px] text-red-400 font-medium italic mt-0.5">⚠️ Desviación del 15% en horas estimadas. Riesgo de pérdida de rentabilidad.</p>
                                </div>
                                <!-- Project Beta (OK) -->
                                <div class="flex-col gap-1.5 hidden md:flex">
                                    <div class="flex justify-between text-xs font-bold">
                                        <span class="text-gray-300">Proyecto Beta (Saludable)</span>
                                        <span class="text-white">40h / 80h presupuesto</span>
                                    </div>
                                    <div class="w-full bg-white/5 rounded-full h-3.5 overflow-hidden border border-white/10">
                                        <div class="bg-gradient-to-r from-green-600 to-green-400 h-full rounded-full" style="width: 50%"></div>
                                    </div>
                                </div>
                                <!-- Project Gamma (OK) -->
                                <div class="flex-col gap-1.5 hidden md:flex">
                                    <div class="flex justify-between text-xs font-bold">
                                        <span class="text-gray-300">Proyecto Gamma (Saludable)</span>
                                        <span class="text-white">15h / 50h presupuesto</span>
                                    </div>
                                    <div class="w-full bg-white/5 rounded-full h-3.5 overflow-hidden border border-white/10">
                                        <div class="bg-gradient-to-r from-green-600 to-green-400 h-full rounded-full" style="width: 30%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floating Decorator Orbs -->
                <div class="absolute -bottom-6 -left-6 w-16 h-16 bg-action/20 rounded-full blur-xl pointer-events-none"></div>
                <div class="absolute -top-6 -right-6 w-20 h-20 bg-blue-600/20 rounded-full blur-xl pointer-events-none"></div>
            </div>

        </div>

        <!-- Background Blur Orbs -->
        <div
            class="absolute top-1/4 left-1/4 w-96 h-96 bg-action/20 rounded-full blur-[120px] -z-10 pointer-events-none">
        </div>
        <div
            class="absolute bottom-1/4 right-1/4 w-[500px] h-[500px] bg-blue-600/20 rounded-full blur-[150px] -z-10 pointer-events-none">
        </div>
    </section>

    <!-- Separador Estético -->
    <div
        class="w-full h-px bg-gradient-to-r from-transparent via-blue-500/80 to-transparent shadow-[0_0_20px_rgba(59,130,246,0.5)]">
    </div>

    <!-- C2. Casos de Uso KAI IA -->
    <section class="py-24 relative z-20 fade-up overflow-hidden bg-light">
        <div class="absolute inset-0 bg-[url('img/bg_section2.webp')] bg-cover bg-center opacity-[0.03] pointer-events-none mix-blend-multiply"></div>

        <div class="container mx-auto px-6 max-w-7xl relative z-10">
            <!-- Header -->
            <div class="text-center mb-16 max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-2 text-action font-semibold text-xs bg-action/10 px-3.5 py-1.5 rounded-full w-fit border border-action/20 uppercase tracking-wider mb-4">
                    KAI AI Assistant
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-primary tracking-tight mb-6">
                    Conoce a KAI: La primera IA que no solo responde, sino que <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-action">hace el trabajo por ti</span>
                </h2>
                <p class="text-secondary text-base md:text-lg font-medium leading-relaxed">
                    KAI es el asistente inteligente de OnGoing V2. No es un chat genérico; es un colaborador virtual que entiende tu lenguaje natural, consulta tu base de datos y ejecuta acciones reales en tus módulos de negocio.
                </p>
            </div>

            <!-- Grid de Casos de Uso -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Tarjeta 1: CRM (Ventas) -->
                <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-xl hover:shadow-2xl hover:border-action/30 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center mb-6 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                            <i data-lucide="users" class="w-6 h-6"></i>
                        </div>
                        <span class="text-[11px] font-extrabold uppercase tracking-widest text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">CRM (Ventas)</span>
                        <div class="mt-6 bg-[#001953]/5 p-4 rounded-2xl border-l-4 border-blue-600 text-primary/90 italic text-sm font-medium leading-relaxed">
                            "KAI, resume las notas de mi última llamada con el cliente X y agenda seguimiento."
                        </div>
                    </div>
                    <p class="text-sm text-secondary font-medium leading-relaxed mt-6">
                        Optimiza tu flujo comercial procesando interacciones en segundos y programando recordatorios automáticos sin llenar formularios.
                    </p>
                </div>

                <!-- Tarjeta 2: Tareas (Proyectos) -->
                <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-xl hover:shadow-2xl hover:border-action/30 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center mb-6 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                            <i data-lucide="check-square" class="w-6 h-6"></i>
                        </div>
                        <span class="text-[11px] font-extrabold uppercase tracking-widest text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">Tareas (Proyectos)</span>
                        <div class="mt-6 bg-[#001953]/5 p-4 rounded-2xl border-l-4 border-emerald-600 text-primary/90 italic text-sm font-medium leading-relaxed">
                            "KAI, ¿qué tareas están retrasadas en el proyecto de desarrollo y a quién pertenecen?"
                        </div>
                    </div>
                    <p class="text-sm text-secondary font-medium leading-relaxed mt-6">
                        Obtén visibilidad instantánea del progreso de tu equipo y detecta cuellos de botella sin necesidad de reuniones de estatus.
                    </p>
                </div>

                <!-- Tarjeta 3: Inventario -->
                <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-xl hover:shadow-2xl hover:border-action/30 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center mb-6 text-amber-600 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300">
                            <i data-lucide="package" class="w-6 h-6"></i>
                        </div>
                        <span class="text-[11px] font-extrabold uppercase tracking-widest text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">Inventario</span>
                        <div class="mt-6 bg-[#001953]/5 p-4 rounded-2xl border-l-4 border-amber-600 text-primary/90 italic text-sm font-medium leading-relaxed">
                            "KAI, genera una orden de compra sugerida para los artículos que están por debajo del stock mínimo."
                        </div>
                    </div>
                    <p class="text-sm text-secondary font-medium leading-relaxed mt-6">
                        Mantén tus almacenes balanceados. KAI calcula faltantes, busca proveedores y genera borradores de compra de forma proactiva.
                    </p>
                </div>

                <!-- Tarjeta 4: Finanzas -->
                <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-xl hover:shadow-2xl hover:border-action/30 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center mb-6 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300">
                            <i data-lucide="dollar-sign" class="w-6 h-6"></i>
                        </div>
                        <span class="text-[11px] font-extrabold uppercase tracking-widest text-purple-600 bg-purple-50 px-2.5 py-1 rounded-full">Finanzas</span>
                        <div class="mt-6 bg-[#001953]/5 p-4 rounded-2xl border-l-4 border-purple-600 text-primary/90 italic text-sm font-medium leading-relaxed">
                            "KAI, muéstrame las facturas vencidas de esta semana y el flujo de caja proyectado."
                        </div>
                    </div>
                    <p class="text-sm text-secondary font-medium leading-relaxed mt-6">
                        Toma decisiones financieras con certidumbre. KAI proyecta cobros y pagos basándose en datos históricos e información en tiempo real.
                    </p>
                </div>
            </div>

            <!-- Blockquote Destacado -->
            <div class="bg-gradient-to-br from-primary via-[#0a1128] to-[#00123a] p-8 md:p-12 rounded-[2.5rem] text-white shadow-2xl relative overflow-hidden mt-16 border border-white/10">
                <div class="absolute top-0 right-0 w-96 h-96 bg-action/10 blur-[100px] rounded-full pointer-events-none"></div>
                <div class="relative z-10 flex flex-col md:flex-row gap-6 md:gap-8 items-start md:items-center">
                    <div class="w-14 h-14 rounded-2xl bg-action/20 border border-action/30 flex items-center justify-center text-action shrink-0 shadow-[0_0_20px_rgba(0,192,255,0.2)]">
                        <i data-lucide="sparkles" class="w-7 h-7 animate-pulse"></i>
                    </div>
                    <div class="flex-grow">
                        <p class="text-base md:text-lg font-semibold leading-relaxed text-white/95">
                            "KAI no es un chatbot pasivo. Antes de tomar una acción crítica (como emitir una orden de compra), te muestra los datos, verifica alternativas y te pide confirmación. Inteligencia activa y segura para tu negocio."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- D. Módulos Integrados (11 Apps en Rediseño) -->
    <section class="py-24 bg-white text-primary fade-up relative z-20">
        <div class="container mx-auto px-6 max-w-7xl">
            <!-- Header -->
            <div class="text-center mb-16 max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-2 text-blue-600 font-semibold text-xs bg-blue-50 px-3.5 py-1.5 rounded-full w-fit border border-blue-100 uppercase tracking-wider mb-4">
                    Ecosistema Integrado
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold tracking-tight">
                    Una app para cada necesidad.<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-action">Integradas en una sola plataforma.</span>
                </h2>
            </div>

            <!-- Grid de 11 Módulos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- 1. CRM -->
                <div class="bg-slate-50/50 p-8 rounded-[2rem] border border-gray-100 hover:border-blue-200 hover:bg-white hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                            <i data-lucide="users" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-extrabold text-xl text-primary mb-2">CRM</h3>
                        <p class="text-sm text-secondary font-medium leading-relaxed">
                            Pipeline Comercial en formato Kanban para gestionar oportunidades, contactos and empresas de forma transparente.
                        </p>
                    </div>
                </div>

                <!-- 2. Proyectos -->
                <div class="bg-slate-50/50 p-8 rounded-[2rem] border border-gray-100 hover:border-blue-200 hover:bg-white hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                            <i data-lucide="briefcase" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-extrabold text-xl text-primary mb-2">Proyectos</h3>
                        <p class="text-sm text-secondary font-medium leading-relaxed">
                            El núcleo de tu gestión operativa (PSA) dividido en hitos y tareas para un control total de entregables.
                        </p>
                    </div>
                </div>

                <!-- 3. Registro de Horas -->
                <div class="bg-slate-50/50 p-8 rounded-[2rem] border border-gray-100 hover:border-blue-200 hover:bg-white hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-violet-50 flex items-center justify-center text-violet-600 mb-6 group-hover:bg-violet-600 group-hover:text-white transition-all duration-300">
                            <i data-lucide="clock" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-extrabold text-xl text-primary mb-2">Registro de Horas</h3>
                        <p class="text-sm text-secondary font-medium leading-relaxed">
                            Time Tracking nativo integrado a tus proyectos para medir y proteger la rentabilidad de cada hora de trabajo.
                        </p>
                    </div>
                </div>

                <!-- 4. Planeación -->
                <div class="bg-slate-50/50 p-8 rounded-[2rem] border border-gray-100 hover:border-blue-200 hover:bg-white hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-cyan-50 flex items-center justify-center text-cyan-600 mb-6 group-hover:bg-cyan-600 group-hover:text-white transition-all duration-300">
                            <i data-lucide="calendar" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-extrabold text-xl text-primary mb-2">Planeación</h3>
                        <p class="text-sm text-secondary font-medium leading-relaxed">
                            Vista de Workload integrada para equilibrar la carga de trabajo de tu equipo de manera eficiente.
                        </p>
                    </div>
                </div>

                <!-- 5. Inventario -->
                <div class="bg-slate-50/50 p-8 rounded-[2rem] border border-gray-100 hover:border-blue-200 hover:bg-white hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 mb-6 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300">
                            <i data-lucide="archive" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-extrabold text-xl text-primary mb-2">Inventario</h3>
                        <p class="text-sm text-secondary font-medium leading-relaxed">
                            Control multialmacén con historial de movimientos, ajustes de stock y kárdex automatizado en tiempo real.
                        </p>
                    </div>
                </div>

                <!-- 6. Artículos -->
                <div class="bg-slate-50/50 p-8 rounded-[2rem] border border-gray-100 hover:border-blue-200 hover:bg-white hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                            <i data-lucide="layers" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-extrabold text-xl text-primary mb-2">Artículos</h3>
                        <p class="text-sm text-secondary font-medium leading-relaxed">
                            Catálogo base estructurado para la administración de productos físicos, servicios y activos de tu negocio.
                        </p>
                    </div>
                </div>

                <!-- 7. Compras -->
                <div class="bg-slate-50/50 p-8 rounded-[2rem] border border-gray-100 hover:border-blue-200 hover:bg-white hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-red-600 mb-6 group-hover:bg-red-600 group-hover:text-white transition-all duration-300">
                            <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-extrabold text-xl text-primary mb-2">Compras</h3>
                        <p class="text-sm text-secondary font-medium leading-relaxed">
                            Ciclo de abastecimiento digital: emisión, validación y autorización de Órdenes de Compra con proveedores.
                        </p>
                    </div>
                </div>

                <!-- 8. Ventas -->
                <div class="bg-slate-50/50 p-8 rounded-[2rem] border border-gray-100 hover:border-blue-200 hover:bg-white hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 mb-6 group-hover:bg-rose-600 group-hover:text-white transition-all duration-300">
                            <i data-lucide="trending-up" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-extrabold text-xl text-primary mb-2">Ventas</h3>
                        <p class="text-sm text-secondary font-medium leading-relaxed">
                            Ciclo comercial completo: presupuestos, cotizaciones en PDF, Sales Orders y facturación electrónica CFDI 4.0.
                        </p>
                    </div>
                </div>

                <!-- 9. Contabilidad -->
                <div class="bg-slate-50/50 p-8 rounded-[2rem] border border-gray-100 hover:border-blue-200 hover:bg-white hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-600 mb-6 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300">
                            <i data-lucide="credit-card" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-extrabold text-xl text-primary mb-2">Contabilidad</h3>
                        <p class="text-sm text-secondary font-medium leading-relaxed">
                            Administración financiera de cuentas por cobrar, cuentas por pagar y flujo de caja en tiempo real.
                        </p>
                    </div>
                </div>

                <!-- 10. IA (KAI) -->
                <div class="bg-slate-50/50 p-8 rounded-[2rem] border border-gray-100 hover:border-blue-200 hover:bg-white hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-sky-50 flex items-center justify-center text-sky-600 mb-6 group-hover:bg-sky-600 group-hover:text-white transition-all duration-300">
                            <i data-lucide="sparkles" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-extrabold text-xl text-primary mb-2">IA (KAI)</h3>
                        <p class="text-sm text-secondary font-medium leading-relaxed">
                            Asistente cognitivo inteligente (KAI) disponible en toda la plataforma para ejecutar comandos en lenguaje natural.
                        </p>
                    </div>
                </div>

                <!-- 11. Tablero -->
                <div class="bg-slate-50/50 p-8 rounded-[2rem] border border-gray-100 hover:border-blue-200 hover:bg-white hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-[#001953]/5 flex items-center justify-center text-primary mb-6 group-hover:bg-primary group-hover:text-white transition-all duration-300">
                            <i data-lucide="pie-chart" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-extrabold text-xl text-primary mb-2">Tablero</h3>
                        <p class="text-sm text-secondary font-medium leading-relaxed">
                            Dashboard ejecutivo centralizado con gráficos financieros, indicadores de rendimiento de tu equipo y agenda de reuniones.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- E. La Diferencia Ongoing (USP) -->
    <section class="py-24 relative overflow-hidden fade-up">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <!-- Text Content -->
                <div>
                    <div
                        class="text-action font-extrabold uppercase tracking-widest text-sm mb-4 flex items-center gap-2">
                        <i data-lucide="zap" class="w-4 h-4"></i> El ADN Ongoing
                    </div>
                    <h2 class="text-4xl md:text-5xl font-extrabold mb-6 leading-[1.15] tracking-tight text-white">
                        Otros te venden una licencia y desaparecen. <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-action to-blue-400">Nosotros
                            somos tu brazo tecnológico.</span>
                    </h2>

                    <div class="space-y-8 mt-12 bg-black/10 p-6 rounded-3xl border border-white/5">
                        <div class="flex gap-5 items-start">
                            <div
                                class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center shrink-0 border-action/30">
                                <i data-lucide="users" class="text-action w-6 h-6"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold mb-1 text-white">Soporte Humano</h4>
                                <p class="text-secondary text-sm font-medium leading-relaxed">No hables con bots
                                    programados para esquivarte. Habla con expertos reales de nuestro equipo dispuestos
                                    a involucrarse.</p>
                            </div>
                        </div>
                        <div class="flex gap-5 items-start">
                            <div
                                class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center shrink-0 border-action/30">
                                <i data-lucide="cpu" class="text-action w-6 h-6"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold mb-1 text-white">IA Estratégica</h4>
                                <p class="text-secondary text-sm font-medium leading-relaxed">Automatización inteligente
                                    de procesos aburridos mediante agentes IA para que tu equipo se concentre en
                                    escalar.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visual Nodes Diagram -->
                <div class="relative h-[400px] flex justify-center items-center">
                    <svg class="absolute w-[120%] h-[120%] animate-float" viewBox="0 0 500 500"
                        style="animation-duration: 8s;">
                        <circle cx="250" cy="250" r="100" fill="none" stroke="rgba(0,192,255,0.2)" stroke-width="2"
                            stroke-dasharray="5,5" />
                        <circle cx="250" cy="250" r="180" fill="none" stroke="rgba(255,255,255,0.05)"
                            stroke-width="1" />

                        <!-- Center Node -->
                        <circle cx="250" cy="250" r="40" fill="rgba(0,192,255,0.1)" stroke="#00c0ff" stroke-width="2" />
                        <circle cx="250" cy="250" r="20" fill="#00c0ff">
                            <animate attributeName="r" values="20;25;20" dur="2s" repeatCount="indefinite" />
                        </circle>

                        <!-- Peripheral Nodes -->
                        <!-- Top -->
                        <line x1="250" y1="250" x2="250" y2="100" stroke="rgba(0,192,255,0.5)" stroke-width="2" />
                        <circle cx="250" cy="100" r="20" fill="#fff" />
                        <circle cx="250" cy="100" r="8" fill="#001953" />

                        <!-- Bottom Right -->
                        <line x1="250" y1="250" x2="380" y2="320" stroke="rgba(0,192,255,0.5)" stroke-width="2" />
                        <circle cx="380" cy="320" r="20" fill="#fff" />
                        <circle cx="380" cy="320" r="8" fill="#001953" />

                        <!-- Bottom Left -->
                        <line x1="250" y1="250" x2="120" y2="320" stroke="rgba(0,192,255,0.5)" stroke-width="2" />
                        <circle cx="120" cy="320" r="20" fill="#fff" />
                        <circle cx="120" cy="320" r="8" fill="#001953" />
                    </svg>

                    <div
                        class="glass-panel absolute bg-primary/80 border-action/50 px-8 py-4 rounded-full text-base font-extrabold shadow-[0_0_30px_rgba(0,192,255,0.2)] flex items-center gap-3">
                        <i data-lucide="network" class="text-action"></i> Cluster Tecnológico + Humano
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- F. Sección "Silos" (SEO & Diagnóstico) -->
    <section id="soluciones" class="py-24 fade-up">
        <div class="container mx-auto px-6 max-w-6xl">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-center mb-16 tracking-tight">Diagnóstico y
                Soluciones</h2>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Comercial / CRM -->
                <div
                    class="glass-panel p-8 rounded-3xl flex flex-col h-full hover:bg-white/10 transition-colors group border-white/5">
                    <div
                        class="w-12 h-12 rounded-xl bg-orange-500/10 flex items-center justify-center mb-6 border border-orange-500/20 text-orange-400 group-hover:bg-orange-500 group-hover:text-white transition-all">
                        <i data-lucide="trending-up" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-white">Clientes y Ventas</h3>
                    <p class="text-secondary text-sm mb-8 flex-grow font-medium leading-relaxed">Deja de perder ventas en post-its y hojas de cálculo desactualizadas.</p>
                    <a href="lp/crm.html"
                        class="text-action text-sm font-bold flex items-center gap-2 hover:gap-3 transition-all mt-auto border-t border-white/10 pt-4">
                        Ver Módulo CRM <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>

                <!-- Financiero -->
                <div
                    class="glass-panel p-8 rounded-3xl flex flex-col h-full hover:bg-white/10 transition-colors group border-white/5">
                    <div
                        class="w-12 h-12 rounded-xl bg-green-500/10 flex items-center justify-center mb-6 border border-green-500/20 text-green-400 group-hover:bg-green-500 group-hover:text-white transition-all">
                        <i data-lucide="pie-chart" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-white">Financiero</h3>
                    <p class="text-secondary text-sm mb-8 flex-grow font-medium leading-relaxed">Cumple con el SAT y visualiza tu dinero real en tiempo real sin retrasos.</p>
                    <a href="lp/finanzas.html"
                        class="text-action text-sm font-bold flex items-center gap-2 hover:gap-3 transition-all mt-auto border-t border-white/10 pt-4">
                        Ver Módulo Finanzas <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>

                <!-- Operativo / PSA -->
                <div
                    class="glass-panel p-8 rounded-3xl flex flex-col h-full hover:bg-white/10 transition-colors group border-white/5">
                    <div
                        class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center mb-6 border border-blue-500/20 text-blue-400 group-hover:bg-blue-500 group-hover:text-white transition-all">
                        <i data-lucide="layers" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-white">Proyectos y Rentabilidad</h3>
                    <p class="text-secondary text-sm mb-8 flex-grow font-medium leading-relaxed">Del caos a la ejecución. Asigna, mide y evita pérdidas por horas mal estimadas.</p>
                    <a href="lp/servicios.html"
                        class="text-action text-sm font-bold flex items-center gap-2 hover:gap-3 transition-all mt-auto border-t border-white/10 pt-4">
                        Ver Gestión Operativa <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>

                <!-- Seguridad / Multi-Tenant -->
                <div
                    class="glass-panel p-8 rounded-3xl flex flex-col h-full hover:bg-white/10 transition-colors group border-white/5">
                    <div
                        class="w-12 h-12 rounded-xl bg-purple-500/10 flex items-center justify-center mb-6 border border-purple-500/20 text-purple-400 group-hover:bg-purple-500 group-hover:text-white transition-all">
                        <i data-lucide="shield" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-white">Infraestructura Multi-Tenant</h3>
                    <p class="text-secondary text-sm mb-8 flex-grow font-medium leading-relaxed">Bases de datos independientes y seguridad activa con sesión única activa.</p>
                    <a href="modulos/infraestructura-multitenant.html"
                        class="text-action text-sm font-bold flex items-center gap-2 hover:gap-3 transition-all mt-auto border-t border-white/10 pt-4">
                        Ver Seguridad <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section id="demo-conversion" class="py-24 bg-[#0a1128] border-t border-white/5 fade-up relative z-20">
        <div class="container mx-auto px-6 max-w-4xl relative">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-80 h-80 bg-action/10 blur-[100px] rounded-full pointer-events-none"></div>
            
            <div class="text-center mb-16 relative z-10">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white mb-4 tracking-tight">Interactúa con OnGoing en tiempo real</h2>
                <p class="text-secondary text-lg md:text-xl font-medium max-w-2xl mx-auto">Entra a nuestra plataforma de prueba en tiempo real, pon a prueba a KAI (IA) y toma el control del sistema.</p>
            </div>
            
            <div class="glass-panel bg-[#0b1329] p-8 md:p-12 rounded-[2rem] shadow-2xl border border-white/10 relative z-10">
                <form id="demo-signup-form" action="" method="POST" class="flex flex-col gap-6">
                    <div class="flex flex-col gap-2">
                        <label for="correo" class="font-bold text-[13px] uppercase tracking-wider text-action">Correo Electrónico Empresarial</label>
                        <input type="email" id="correo" name="email" required class="bg-white/5 px-5 py-3.5 rounded-xl border border-white/10 focus:outline-none focus:border-action focus:ring-2 focus:ring-action/20 transition-all text-white placeholder-white/30" placeholder="tucorreo@empresa.com">
                    </div>
                    <button type="submit" class="bg-action text-primary font-extrabold text-lg py-4 px-8 rounded-xl hover:bg-opacity-90 transition-all shadow-[0_10px_20px_rgba(0,192,255,0.2)] active:scale-[0.98] mt-4 w-full md:w-auto md:self-end flex items-center justify-center gap-2">
                        Probar Demo Al Instante ⚡ <i data-lucide="send" class="w-5 h-5"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- G. Footer de Confianza -->
    <footer class="border-t border-white/10 pt-10 pb-8 bg-black/40 fade-up mt-12 relative overflow-hidden">
        <!-- Footer Gradient glow -->
        <div
            class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[800px] h-[300px] bg-action/5 rounded-t-full blur-[100px] -z-10 pointer-events-none">
        </div>

        <div class="container mx-auto px-6 max-w-6xl relative z-10">
            <!-- Logos Confianza -->
            <div class="mb-20">
                <p class="text-center text-secondary text-xs font-bold mt-3 md:mt-6 mb-10 uppercase tracking-[0.2em]">Empresas que
                    confían en nosotros</p>
                <div class="flex flex-wrap justify-center items-center gap-12 sm:gap-16">
                    <img src="img/logo_alimentro.png" alt="Alimentro"
                        class="h-8 md:h-12 w-auto object-contain opacity-40 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-500">
                    <img src="img/logo_apetit.png" alt="Apetit"
                        class="h-8 md:h-12 w-auto object-contain opacity-40 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-500">
                    <img src="img/logo_macero.png" alt="Macero"
                        class="h-8 md:h-12 w-auto object-contain opacity-40 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-500">
                    <img src="img/logo_mentoria_banregio.png" alt="Mentoría Banregio"
                        class="h-8 md:h-12 w-auto object-contain opacity-40 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-500">
                    <img src="img/logo_montgomery.png" alt="Montgomery"
                        class="h-8 md:h-12 w-auto object-contain opacity-40 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-500">
                    <img src="img/logo_steel.png" alt="Steel"
                        class="h-8 md:h-12 w-auto object-contain opacity-40 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-500">
                </div>
            </div>

            <hr class="border-white/10 mb-16">

            <!-- Footer Links -->
            <div class="grid grid-cols-2 md:grid-cols-12 gap-10 md:gap-8 mb-16 text-sm">
                <div class="col-span-2 md:col-span-4 pr-0 md:pr-12">
                    <a href="#" class="inline-block mb-6 transition-opacity hover:opacity-80 outline-none">
                        <img src="img/ongoing-logo.png" alt="Ongoing Logo" class="h-9 md:h-10 w-auto">
                    </a>
                    <p class="text-secondary leading-relaxed font-medium">Tu brazo tecnológico para escalar sin límites.
                        Integra finanzas, operaciones y CRM en un solo lugar impulsado por IA.</p>
                </div>

                <div class="col-span-1 md:col-span-2 md:col-start-6">
                    <h4 class="font-extrabold mb-5 text-white uppercase tracking-wider text-xs">Soluciones</h4>
                    <ul class="space-y-4 text-secondary font-medium">
                        <li><a href="lp/index.html" class="hover:text-action transition-colors">Flagship KAI</a></li>
                        <li><a href="lp/crm.html" class="hover:text-action transition-colors">CRM</a></li>
                        <li><a href="lp/inventario.html" class="hover:text-action transition-colors">Inventario y Log&iacute;stica</a></li>
                        <li><a href="lp/servicios.html" class="hover:text-action transition-colors">Gestión Operativa</a></li>
                        <li><a href="lp/finanzas.html" class="hover:text-action transition-colors">Finanzas y SAT</a></li>
                    </ul>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <h4 class="font-extrabold mb-5 text-white uppercase tracking-wider text-xs">Recursos</h4>
                    <ul class="space-y-4 text-secondary font-medium">
                        <li><span id="footer-kai-trigger" class="hover:text-action transition-colors flex items-center gap-2 cursor-pointer">KAI AI <span
                                    class="bg-action/20 text-action text-[10px] px-2 py-0.5 rounded border border-action/30">Nuevo</span></span>
                        </li>
                        <li><a href="docs/" class="hover:text-action transition-colors">Centro de Ayuda</a></li>
                    <li><a href="llms.txt" rel="llms" class="hover:text-action transition-colors">Especificaciones IA</a></li>
                    </ul>
                </div>

                <div class="col-span-2 md:col-span-3">
                    <h4 class="font-extrabold mb-5 text-white uppercase tracking-wider text-xs">Contacto & Legal</h4>
                    <ul class="space-y-4 text-secondary font-medium">
                        <li><a href="aviso-de-privacidad.html" class="hover:text-action transition-colors flex items-center gap-2"><i
                                    data-lucide="shield" class="w-4 h-4"></i> Aviso de Privacidad</a></li>
                        <li><a href="terminos-y-condiciones.html" class="hover:text-action transition-colors flex items-center gap-2"><i
                                    data-lucide="file-text" class="w-4 h-4"></i> T&eacute;rminos y Condiciones</a></li>
                        <li><span class="hover:text-action transition-colors flex items-center gap-2 mt-6"><i
                                    data-lucide="mail" class="w-4 h-4"></i> <!--email_off-->hola@ongoing.mx<!--/email_off--></span></li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="text-center text-xs text-gray-500 pt-8 border-t border-white/10 font-medium">
                © 2026 Ongoing
            </div>
        </div>
    </footer>

    <!-- KAI Chatbot Floating Widget -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
        <!-- Chat Trigger Button -->
        <button id="kai-chat-trigger" class="w-16 h-16 sm:w-14 sm:h-14 rounded-full bg-action text-primary flex items-center justify-center shadow-[0_0_20px_rgba(0,192,255,0.4)] hover:shadow-[0_0_30px_rgba(0,192,255,0.7)] transition-all duration-300 outline-none transform active:scale-95 group relative animate-pulse-glow">
            <i data-lucide="message-square" class="w-6 h-6 text-primary transition-transform duration-300 group-hover:scale-110"></i>
            <span class="absolute -top-10 right-0 bg-[#001953] border border-action/30 text-white text-xs font-bold py-1.5 px-3 rounded-lg shadow-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
                Pregúntale a KAI
            </span>
        </button>

        <!-- Chat Container -->
        <div id="kai-chat-container" class="hidden w-[350px] sm:w-[400px] h-[500px] bg-[#001953]/95 backdrop-blur-md border border-white/10 rounded-2xl flex flex-col shadow-[0_20px_50px_rgba(0,0,0,0.5)] overflow-hidden transition-all duration-300 mt-4 origin-bottom-right">
            <!-- Header -->
            <div class="flex items-center justify-between px-5 py-4 border-b border-white/10 bg-[#001442]">
                <div class="flex items-center gap-3">
                    <img src="img/ongoing-logo.png" alt="Ongoing Logo" class="h-5 w-auto">
                    <div class="h-4 w-px bg-white/20"></div>
                    <div class="flex items-center gap-2">
                        <span class="text-white font-extrabold text-sm tracking-wider">KAI</span>
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    </div>
                </div>
                <button id="kai-chat-close" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/10 text-white/80 hover:text-white hover:bg-white/20 transition-all text-xs font-bold sm:bg-transparent sm:p-0 sm:hover:bg-transparent sm:text-white/60 sm:hover:text-white">
                    <span class="sm:hidden tracking-wider uppercase text-[10px]">Cerrar</span>
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Body (Messages Scroll Area) -->
            <div id="kai-chat-messages" class="flex-grow p-4 overflow-y-auto flex flex-col gap-4 text-sm font-medium">
                <!-- Welcome Message from KAI -->
                <div class="flex gap-2">
                    <div class="w-8 h-8 rounded-full bg-action flex items-center justify-center shadow-lg shrink-0">
                        <i data-lucide="sparkles" class="text-primary w-4 h-4"></i>
                    </div>
                    <div class="bg-blue-900/40 border border-blue-500/20 px-4 py-3 rounded-2xl rounded-tl-sm text-white max-w-[85%] leading-relaxed">
                        ¡Hola! Soy **KAI**, tu analista de negocios inteligente 24/7. Pregúntame sobre cómo erradicar el caos de Excel, medir rentabilidad real o sobre nuestra infraestructura multi-tenant.
                    </div>
                </div>
            </div>

            <!-- Input area (Footer) -->
            <form id="kai-chat-form" class="p-4 border-t border-white/10 bg-[#001442] flex gap-2">
                <input id="kai-chat-input" type="text" autocomplete="off" placeholder="Escribe tu duda aquí..." class="flex-grow bg-white/5 px-4 py-3 rounded-xl border border-white/10 focus:outline-none focus:border-action focus:ring-2 focus:ring-action/20 transition-all text-white placeholder-white/30 text-sm">
                <button type="submit" class="bg-action text-primary font-bold px-4 rounded-xl hover:bg-opacity-90 transition-all shadow-md active:scale-95 flex items-center justify-center shrink-0">
                    <i data-lucide="send" class="w-4 h-4"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/main.js?v=2.0.5"></script>
</body>


</html>