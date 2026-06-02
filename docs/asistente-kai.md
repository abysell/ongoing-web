# Asistente Inteligente KAI

**KAI** (Key Analytical Intelligence) es el copiloto de inteligencia artificial integrado en OnGoing ERP, diseñado para darte claridad humana y profundidad técnica sobre el estado de tu negocio las 24 horas del día.

---

## 1. El Rol de KAI en el ERP

KAI no es un chatbot de preguntas genéricas. Está conectado directamente al modelo de datos de tu organización (ventas, proyectos, facturación) y actúa como un analista de negocios personal:

* **Búsqueda Inteligente**: Responde preguntas complejas en lenguaje natural sin tener que navegar por múltiples menús o generar reportes manuales en PDF.
* **Alertas Proactivas**: Te avisa cuando detecta desviaciones presupuestales críticas en proyectos o retrasos inusuales en las cuentas por cobrar de tus clientes.
* **Explicaciones Claras**: Traduce conceptos contables complejos a explicaciones sencillas que cualquier directivo o tomador de decisiones puede entender.

---

## 2. Prompts Prácticos y Casos de Uso

A continuación se presentan algunos ejemplos de solicitudes que puedes hacerle a KAI dentro del sistema:

### Análisis del Pipeline de Ventas
> *"KAI, analiza el pipeline de ventas de este mes. ¿Qué tratos tienen más probabilidad de cierre y cuáles están en riesgo de enfriarse?"*
* **Respuesta de KAI**: Te dará un resumen de las oportunidades comerciales en la fase de "Negociación" que tienen más de 10 días sin interacción registrada, ayudándote a priorizar llamadas.

### Cobranza Activa Inteligente
> *"KAI, redacta un correo electrónico de cobranza amable pero firme para el cliente Corporativo MX que tiene una factura vencida de $145,000 MXN."*
* **Respuesta de KAI**: Generará una plantilla de correo profesional personalizada con el nombre del cliente, número de factura y monto exacto, lista para copiar o enviar directamente.

### Rendimiento de Proyectos
> *"KAI, ¿por qué el Proyecto Alpha tiene una desviación del 15% en el presupuesto de horas?"*
* **Respuesta de KAI**: Analizará las hojas de tiempo registradas y te indicará qué tareas específicas consumieron más tiempo de lo presupuestado o si algún colaborador requirió más soporte del estimado.

---

## 3. Límites y Seguridad del Contexto

Para proteger la integridad de tu información y asegurar un comportamiento óptimo del asistente, KAI opera bajo estrictas reglas de seguridad:

* **Privacidad de Datos**: Las consultas de datos nunca se utilizan para entrenar modelos públicos externos de OpenAI. El flujo de datos está aislado por tenant.
* **Exclusividad de Negocios (Jailbreak Guard)**: KAI está programado para rechazar cualquier pregunta ajena a OnGoing ERP o la administración de tu empresa. Si le pides recetas de cocina, chistes o poemas, responderá amablemente indicando que su propósito es ayudarte a gestionar tu negocio y te invitará a explorar el sistema.
