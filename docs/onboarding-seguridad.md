# Onboarding y Seguridad Perimetral

En OnGoing ERP diseñamos un flujo de inicio rápido combinado con estándares de seguridad de nivel bancario para proteger el activo más valioso de tu empresa: sus datos.

---

## 1. Onboarding Síncrono en Menos de 2 Minutos

El caos de los ERP tradicionales comienza desde su implementación, que suele requerir meses y consultores externos costosos. En OnGoing, el proceso toma menos de 2 minutos:

1. **Registro Inicial**: El usuario ingresa sus datos básicos y nombre de la organización en la landing de conversión (`ongoing2.mx/registro`).
2. **Aprovisionamiento Inmediato**: De forma síncrona, nuestro backend aprovisiona la infraestructura necesaria para su espacio de trabajo.
3. **Envío de Magic Link**: A través de nuestro proveedor de mensajería transaccional **Brevo**, se envía un correo electrónico seguro con un enlace de acceso único y temporal (Magic Link).
4. **Primer Acceso**: Al hacer clic en el Magic Link, el usuario es autenticado automáticamente y se le otorga el rol de **Administrador**, dándole control total para configurar la cuenta, invitar colaboradores y definir permisos.

---

## 2. Infraestructura Multi-Tenant (Aislamiento Físico)

A diferencia de otros sistemas de software que mezclan los datos de todas las empresas en una única base de datos lógica (separándolos solo por una columna ID), OnGoing utiliza una arquitectura **Multi-Tenant con aislamiento físico de bases de datos**:

* **Bases de Datos Independientes**: Cada cliente/organización cuenta con su propio servidor o base de datos física completamente aislada.
* **Cero Riesgo de Fugas**: Es técnicamente imposible que los datos de un cliente se mezclen con los de otro, eliminando riesgos de seguridad y garantizando el cumplimiento de estrictas normativas de privacidad.
* **Rendimiento Garantizado**: El consumo de recursos y consultas pesadas de una empresa no afecta el rendimiento ni la velocidad de otros tenants en la nube.

---

## 3. Control de Acceso y Sistema Anti-Piratería (Sesión Única Activa)

Para resguardar la confidencialidad de la información y proteger el modelo de licencias de OnGoing, el sistema implementa una política perimetral de **Sesión Única Activa**:

> [!WARNING]
> **Regla de Concurrencia**: Solo se permite una sesión activa de forma simultánea por cada cuenta de usuario individual.

### Lógica de Funcionamiento:
1. **Inicio de Sesión en Dispositivo B**: Si un usuario con una sesión activa en el *Dispositivo A* inicia sesión en el *Dispositivo B*, el sistema registra la nueva sesión en el servidor.
2. **Invalidación de JWT**: Inmediatamente, el servidor invalida y destruye el token JSON Web Token (JWT) correspondiente al *Dispositivo A*.
3. **Bloqueo y Redirección**: En cuanto el *Dispositivo A* intente realizar cualquier acción o petición HTTP al backend, recibirá un código de estado de error **HTTP 401 Unauthorized**. El cliente de la aplicación detectará este estado, borrará los datos locales de sesión y redirigirá forzadamente al usuario a la pantalla de login con el mensaje: *"Tu sesión ha sido abierta en otro dispositivo."*
