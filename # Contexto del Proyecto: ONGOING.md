# Contexto del Proyecto: ONGOING.MX - Versión 2.0
**Rol:** Actúa como un Desarrollador Front-End Senior y Especialista en UX/UI.
**Objetivo:** Desarrollar el código (HTML5, CSS3 y Vanilla JavaScript) de la nueva página principal de un ERP con IA llamado Ongoing.
**Estilo de Diseño:** "Deep Tech & Human Clarity". Moderno, oscuro, elegante, con toques de Glassmorphism.

## 1. Reglas de Diseño (ADN Visual)
* **Tipografía:** Usa Google Fonts 'Plus Jakarta Sans'. Títulos en ExtraBold (800), cuerpo en Regular (400) y Medium (500).
* **Paleta de Colores:**
    * Fondo Primario: `#001953` (Aplica un degradado sutil radial hacia un azul más oscuro casi negro en los bordes para dar profundidad).
    * Color de Acción (CTAs): `#00c0ff` (Usa un ligero "glow" o resplandor en hover).
    * Texto principal: `#FFFFFF`.
    * Texto secundario/Subtítulos: `#D1D5DB` (Gris claro / opacidad al 80%).
* **Efecto Glassmorphism:** Para tarjetas flotantes y el chat de KAI. Usa fondos oscuros semitransparentes (`rgba(255, 255, 255, 0.05)`), desenfoque de fondo (`backdrop-filter: blur(12px)`) y bordes muy sutiles (`border: 1px solid rgba(255, 255, 255, 0.1)`).
* **Librerías Permitidas:**
    * Usa **Tailwind CSS** (vía CDN) para agilizar los estilos y garantizar un diseño responsivo (Mobile First).
    * Usa **Phosphor Icons** o **Lucide Icons** (vía CDN) para la iconografía.

## 2. Estructura y Contenido (Copy a integrar)

### A. Sticky Header (Navegación)
* **Fondo:** Transparente al inicio, con Glassmorphism al hacer scroll.
* **Logo:** Utiliza la imagen del logo blanco actual (o un placeholder `<img src="https://wp.ongoing.mx/wp-content/uploads/..." alt="Ongoing Logo">` alineado a la izquierda).
* **Menú central:** Soluciones, Por Perfil, Recursos.
* **Derecha (CTAs):** Link `[ Ingresar ]` y botón sólido con fondo `#00c0ff` `[ Empieza Gratis ]`.

### B. Hero Section
* **Layout:** Flex o Grid. Texto a la izquierda, composición visual a la derecha.
* **Micro-etiqueta superior:** `🚀 La evolución del ERP en México` (Texto pequeño, color `#00c0ff`).
* **H1:** `El control total de tu empresa, sin la complejidad de siempre.`
* **H2:** `Centraliza tus Finanzas, CRM y Operaciones en una sola plataforma. Potenciado por KAI, el asistente de IA que te da respuestas exactas sobre tu negocio al instante.`
* **Botones (Izquierda):** * Primario: `Empieza Gratis` (Fondo `#00c0ff`, texto `#001953`). Debajo, en letra muy pequeña: *"Sin tarjeta de crédito. Listo en 2 minutos."*
    * Secundario: `Cotizar a la medida` (Borde blanco, fondo transparente).
* **Visual (Derecha):** Un contenedor para las imágenes (MacBook + iPhone flotando). Agrega una tarjeta flotante estilo Glassmorphism que simule una notificación:
    * *Icono de IA + "Notificación: Factura F-402 aprobada y validada ante el SAT."*

### C. Sección KAI (El Poder de KAI - Interactiva)
* **Fondo:** Transición fluida a un fondo ligeramente más oscuro.
* **H2 (Centro):** `No busques entre menús. Solo pregúntale a KAI.`
* **Subtítulo (Centro):** `KAI no es un bot de soporte, es tu analista 24/7. Interpreta tu lenguaje natural y cruza los datos de toda tu empresa en segundos.`
* **Layout Interactivo:** Grid de 2 columnas. 
    * **Izquierda (Botones de Píldoras):** 3 botones grandes para cambiar el contenido del chat. (1. Finanzas 📊, 2. Operativo ⚙️, 3. CRM 🤝).
    * **Derecha (Chat UI):** Un contenedor estilo Glassmorphism que simule una ventana de chat.
* **Lógica JavaScript requerida:** Al hacer clic en las píldoras de la izquierda, el contenido del chat a la derecha debe cambiar con una animación suave de *fade-in*.
    * **Contenido Tab 1 (Finanzas):** Usuario: *"¿Cuánto facturamos la semana pasada?"* -> KAI: *"Facturamos $145,000 MXN (12% más). Aquí tienes la gráfica."*
    * **Contenido Tab 2 (Operativo):** Usuario: *"¿Qué se acordó en la junta de Villahermosa?"* -> KAI: *"Renovar el inventario el día 15. Tarea asignada a Roberto."*
    * **Contenido Tab 3 (CRM):** Usuario: *"¿Cuándo fue la última llamada con la sucursal Centro?"* -> KAI: *"Ayer a las 4:00 PM con Roberto. Minuta guardada."*

### [D] Selector de Necesidades (Grid 2x2)
* **Título:** "¿Qué necesitas resolver hoy?"
* **Tarjetas:**
    1. **Vender Más:** "CRM Básico incluido desde el día 1." (Icono: Embudo).
    2. **Finanzas Claras:** "Materialidad y Flujo de efectivo." (Icono: Gráfica).
    3. **Orden Operativo:** "Gestión de proyectos y tareas." (Icono: Check/Tareas).
    4. **Desarrollo Único:** "Software que se adapta a ti, no al revés." (Icono: Código).
* **Estilo:** Tarjetas limpias, fondo blanco o gris muy claro (#F5F7FA) para dar "respiro" visual.

### [E] La Diferencia Ongoing (USP)
* **Concepto:** "Cluster Tecnológico + Humano".
* **Texto Principal:** "Otros te venden una licencia y desaparecen. Nosotros somos tu brazo tecnológico."
* **Puntos clave:**
    * **Soporte Humano:** No hables con bots, habla con expertos.
    * **IA Estratégica:** Automatización de procesos aburridos.
* **Visual:** Lado derecho con un diagrama de nodos (SVG) que represente conexión constante.

### [F] Sección "Silos" (SEO & Diagnóstico)
* **Título:** "Diagnóstico y Soluciones".
* **Formato:** 4 Tarjetas horizontales o Grid.
* **Contenido:**
    * **Comercial:** "Deja de perder ventas en post-its." -> [Link: Ver CRM]
    * **Financiero:** "Cumple con el SAT y visualiza tu dinero real." -> [Link: Ver Finanzas]
    * **Operativo:** "Del caos a la ejecución. Asigna y mide." -> [Link: Ver Proyectos]
    * **Custom:** "Tu negocio en tu bolsillo. App nativa." -> [Link: Ver Desarrollo]

### [G] Footer de Confianza
* **Logos (Marquee o Grid):** UNIVA, Sports World (Monocromáticos/Blancos con opacidad).
* **Links:** Soluciones, Recursos, Legal, Contacto.
* **Copyright:** "© 2026 Ongoing. Realizado con IA, diseñado para humanos."

## 3. Entregables Esperados
Genera un archivo `index.html` completo que incluya:
1.  La estructura HTML semántica.
2.  Las configuraciones de Tailwind en el `<head>` para los colores personalizados (`primary: '#001953'`, `action: '#00c0ff'`).
3.  El CSS personalizado necesario (en una etiqueta `<style>`) para las animaciones (glow, flotación) y el efecto de Glassmorphism avanzado.
4.  El código JavaScript necesario al final del `<body>` para hacer funcionar el Sticky Header al hacer scroll y la lógica de pestañas (tabs) de la sección KAI.
5.  Asegúrate de que el código sea 100% responsivo (colapsando el menú en móvil y pasando los grids a 1 columna).
