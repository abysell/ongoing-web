# Manual del Usuario Final - OnGoing ERP (Versión 2.0)

Bienvenido al manual oficial de OnGoing ERP, la plataforma integral potenciada por inteligencia artificial diseñada para optimizar la gestión comercial, operativa y de recursos de tu empresa.

---

## Índice
1. [Módulo de Clientes y Ventas (CRM)](#1-módulo-de-clientes-y-ventas-crm)
2. [Módulo de Proyectos, Tiempos y Rentabilidad](#2-módulo-de-proyectos-tiempos-y-rentabilidad)
3. [Seguridad, Accesos y Sesión Única](#3-seguridad-accesos-y-sesión-única)
4. [Soporte Técnico y Consultas a KAI](#4-soporte-técnico-y-consultas-a-kai)

---

## 1. Módulo de Clientes y Ventas (CRM)

El CRM de OnGoing está diseñado para consolidar el control de tus prospectos comerciales y evitar el desorden de hojas de cálculo o anotaciones externas.

### Gestión del Pipeline Comercial
* **Columnas de Proceso:** El embudo de ventas está dividido en tres etapas principales:
  1. **Prospectos:** Contactos iniciales, leads calificados y oportunidades tempranas.
  2. **Negociación:** Clientes en proceso de revisión de propuesta, llamadas de seguimiento y cotizaciones enviadas.
  3. **Cerrado:** Tratos ganados o facturados.
* **Interfaz de Arrastrar y Soltar (Drag & Drop):** Puedes mover las tarjetas de cliente entre las distintas etapas manteniendo pulsado el mouse (o el dedo en dispositivos táctiles) sobre la tarjeta correspondiente y soltándola en la columna objetivo.
* **Valores y Métricas:** Cada tarjeta comercial muestra el nombre del prospecto y el valor estimado de la venta. En la parte superior de cada columna se calcula el acumulado total del flujo proyectado de manera automática.

---

## 2. Módulo de Proyectos, Tiempos y Rentabilidad

Optimiza la gestión operativa y asegura que tus horas de trabajo contratadas se mantengan rentables frente al presupuesto real del cliente.

### Registro de Actividades (Timesheets)
* Cada colaborador puede ingresar las horas reales destinadas a una tarea o entregable específico.
* El sistema asocia automáticamente el costo por hora del colaborador para calcular el consumo financiero del proyecto en tiempo real.

### Alertas de Desviación de Presupuesto
* **Saludable (Verde):** El proyecto ha consumido menos del 80% de las horas y recursos económicos asignados.
* **Advertencia (Amarillo):** El proyecto está entre el 80% y el 95% del presupuesto.
* **Crítico / Alerta (Rojo):** El proyecto ha superado el 95% del presupuesto estimado (por ejemplo, el caso del *Proyecto Alpha*). 
  * *Acción sugerida:* KAI alertará automáticamente al administrador para realizar reasignaciones de tareas, renegociación de alcances o detención de horas adicionales para mitigar pérdidas financieras.

---

## 3. Seguridad, Accesos y Sesión Única

La integridad y confidencialidad de la información de tu empresa son prioridades fundamentales en la arquitectura de OnGoing.

### Aislamiento de Bases de Datos
* Toda cuenta funciona bajo una infraestructura **Multi-Tenant**.
* La base de datos de tu organización está separada físicamente de la de otros clientes. Esto garantiza rendimiento continuo y evita riesgos de fugas accidentales de datos.

### Control de Sesión Única Activa (Anti-Piratería)
* Para proteger tu cuenta de usos concurrentes no autorizados, el sistema limita el inicio de sesión a **un dispositivo activo por licencia de usuario**.
* Si inicias sesión en el *Dispositivo B* (por ejemplo, una laptop), la sesión anterior en el *Dispositivo A* (como una tablet o celular) será destruida automáticamente. Al intentar realizar una consulta en el Dispositivo A, el sistema enviará un código `401 Unauthorized` y te redirigirá a la pantalla de Login con el mensaje *"Sesión cerrada debido al inicio de sesión en un dispositivo nuevo"*.

---

## 4. Soporte Técnico y Consultas a KAI

El asistente inteligente **KAI** está integrado directamente en la consola para agilizar la obtención de información gerencial y el soporte operativo.

### Cómo Consultar a KAI
* Puedes escribirle en lenguaje natural. No necesitas navegar por menús complejos.
* **Ejemplos de comandos admitidos:**
  * *¿Cuánto facturamos la semana pasada?* ➡️ KAI te devolverá el saldo consolidado e imprimirá un gráfico de barras interactivo del flujo de caja.
  * *¿Cómo van los proyectos activos?* ➡️ KAI analizará los tiempos de los entregables y te notificará de inmediato sobre alertas de desviación.
