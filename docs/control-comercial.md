# Control Comercial y Pasarela de Pagos

El modelo de negocios de OnGoing está diseñado para ser transparente, flexible y seguro. A continuación, se detallan las reglas operativas de licenciamiento, el bloqueo de cuentas expiradas y la integración con la pasarela de pagos.

---

## 1. El Plan Demo (Prueba Gratuita)

Para que las organizaciones experimenten el valor de la plataforma sin fricciones, ofrecemos un plan de prueba:

* **Duración**: 14 días naturales exactos a partir de la fecha de registro inicial.
* **Límite de Usuarios**: Restringido a **1 usuario administrador** (sin posibilidad de añadir colaboradores adicionales durante el periodo de prueba).
* **Sin Compromiso**: No se requiere ingresar tarjeta de crédito o método de pago para activar la demo.

---

## 2. Candado Comercial (Paywall) y Excepciones de Acceso

Una vez transcurridos los 14 días de prueba sin que la organización haya contratado un plan de pago, el estado de la suscripción cambia a `expired` (Expirado).

### Bloqueo de Operaciones (HTTP 402)
* **Middleware Perimetral**: Un middleware de seguridad en nuestro servidor intercepta todas las peticiones entrantes. Al detectar el estado `expired`, el backend detiene la petición y responde con un código de estado **HTTP 402 Payment Required**.
* **Redirección Forzada**: El cliente web reacciona redirigiendo inmediatamente al usuario al portal de facturación: `/billing/paywall`.

> [!IMPORTANT]
> **Zonas Exentas de Bloqueo**: Para permitir que el usuario administre su cuenta o resuelva su situación de pago, el middleware de bloqueo comercial no aplica a las siguientes rutas críticas:
> * **Logout (`/logout`)**: Para poder cerrar sesión.
> * **Perfil (`/profile`)**: Para ver sus datos de cuenta.
> * **Facturación/Pagos (`/billing/*`)**: Para seleccionar un plan, actualizar datos fiscales y realizar el pago.

---

## 3. Integración con Mercado Pago Checkout Pro

Para la adquisición y renovación de licencias, OnGoing se integra con **Mercado Pago Checkout Pro**, ofreciendo dos métodos de sincronización de datos:

### Sincronización Síncrona (Flujo de Usuario)
Cuando el usuario finaliza con éxito la transacción en el portal de Mercado Pago, la plataforma lo redirige de vuelta al sistema con un token de éxito. Esta redirección desencadena una verificación inmediata que desbloquea el tenant al instante para que el administrador pueda continuar trabajando sin esperas.

### Sincronización Asíncrona (Respaldo por Webhooks y n8n)
En caso de que el usuario cierre el navegador antes de la redirección, o si el pago tarda en procesarse (por ejemplo, pagos en efectivo/OXXO), el sistema utiliza un flujo asíncrono robusto:
1. Mercado Pago envía una notificación instantánea de pago (IPN/Webhook) a nuestro servidor web de automatización administrado en **n8n**.
2. El flujo en **n8n** procesa la confirmación del pago de forma segura en segundo plano.
3. Se actualiza el estado de la suscripción de la organización en la base de datos a `active` y se extiende la fecha de vencimiento.
4. Se dispara un correo de confirmación de pago automático al administrador.
