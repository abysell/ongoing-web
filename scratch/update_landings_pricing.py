import os
import re

ROOT = "/Users/user/Documents/ongoing-web"

def update_sticky_banner_globally():
    banner_pattern = re.compile(
        r'<div class="sticky-banner" id="global-sticky-banner">\s*<span>.*?</span>\s*</div>',
        re.DOTALL
    )
    new_banner = (
        '<div class="sticky-banner" id="global-sticky-banner">\n'
        '        <span>🚀 No esperes a un vendedor. Activa tu cuenta con 1 usuario gratis para siempre y explora OnGoing V2 ahora mismo en nuestro <a href="https://demo.ongoing2.mx" target="_blank">Demo Interactivo en vivo (demo.ongoing2.mx)</a>.</span>\n'
        '    </div>'
    )
    
    banner_pattern_fallback = re.compile(
        r'<div class="sticky-banner">\s*<span>.*?</span>\s*</div>',
        re.DOTALL
    )
    new_banner_fallback = (
        '<div class="sticky-banner">\n'
        '        <span>🚀 No esperes a un vendedor. Activa tu cuenta con 1 usuario gratis para siempre y explora OnGoing V2 ahora mismo en nuestro <a href="https://demo.ongoing2.mx" target="_blank">Demo Interactivo en vivo (demo.ongoing2.mx)</a>.</span>\n'
        '    </div>'
    )

    for root, dirs, files in os.walk(ROOT):
        if '.git' in root or 'node_modules' in root or 'scratch' in root:
            continue
        for file in files:
            if file.endswith('.html'):
                filepath = os.path.join(root, file)
                with open(filepath, 'r', encoding='utf-8') as f:
                    content = f.read()
                
                original = content
                content = banner_pattern.sub(new_banner, content)
                content = banner_pattern_fallback.sub(new_banner_fallback, content)
                
                if content != original:
                    with open(filepath, 'w', encoding='utf-8') as f:
                        f.write(content)
                    print(f"Updated sticky banner in: {os.path.relpath(filepath, ROOT)}")

def update_file_copy(filepath, replacements):
    if not os.path.exists(filepath):
        print(f"File not found: {filepath}")
        return
        
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
        
    original = content
    for target, rep in replacements:
        content = content.replace(target, rep)
        
    if content != original:
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"Updated copy in: {os.path.relpath(filepath, ROOT)}")
    else:
        print(f"No copy changes made in: {os.path.relpath(filepath, ROOT)}")

def main():
    # 1. Update sticky banner globally
    update_sticky_banner_globally()
    
    # 2. Replacements for Flagship page (lp/index.html & lp/inteligencia-artificial.html)
    flagship_replacements = [
        (
            '<p class="hero-sub">OnGoing V2 fusiona la gestión integral de tu negocio con <strong>KAI</strong>, tu nuevo asistente directivo de IA. Analiza finanzas y ejecuta operaciones en tiempo real. No confíes en nuestras palabras, entra y juega con el sistema ahora mismo.</p>',
            '<p class="hero-sub">OnGoing V2 fusiona la gestión integral de tu negocio con <strong>KAI</strong>, tu nuevo asistente directivo de IA. Analiza finanzas y ejecuta operaciones en tiempo real. Entra y juega con el sistema ahora mismo de forma libre.</p>'
        ),
        (
            '<p class="hero-price">El poder de un ERP corporativo. Planes desde <strong>$1,000 MXN / mes</strong> por usuario. Sin plazos forzosos.</p>',
            '<p class="hero-price">Tu primer usuario es gratis para siempre. Usuarios adicionales desde <strong>$1,000 MXN / mes</strong>. Sin plazos forzosos.</p>'
        ),
        (
            '<a href="#trial-section" class="btn btn-secondary-white">Iniciar cuenta gratis de por vida para 1 usuario</a>',
            '<a href="#trial-section" class="btn btn-secondary-white">Comenzar Gratis (1 Usuario para Siempre)</a>'
        ),
        (
            '<p class="hero-microcopy">✨ Juega en demo.ongoing2.mx sin dejar tu correo. Inicia tu prueba gratis cuando estés listo.</p>',
            '<p class="hero-microcopy">✨ Ideal para microempresas y profesionistas: 1 usuario gratis, sin tarjetas ni plazos ocultos.</p>'
        ),
        (
            '<h4>Prueba Asistida Gratis</h4>',
            '<h4>Plan Gratis de por Vida</h4>'
        ),
        (
            '<p>Configuramos tu cuenta gratis de por vida para un usuario sin ningún costo de implementación.</p>',
            '<p>Tu primer usuario es gratis para siempre, sin costo de implementación ni tarjetas requeridas.</p>'
        ),
        (
            '<p>Comienza hoy mismo en nuestro entorno real sin proporcionar datos de contacto o inicia tu prueba guiada.</p>',
            '<p>Comienza hoy mismo con tu primer usuario gratis de por vida, sin tarjetas de crédito ni plazos forzosos.</p>'
        ),
        (
            '<a href="https://demo.ongoing2.mx" target="_blank" class="btn btn-secondary-white">Crear cuenta gratis de por vida</a>',
            '<a href="https://demo.ongoing2.mx" target="_blank" class="btn btn-secondary-white">Comenzar Gratis (1 Usuario para Siempre)</a>'
        ),
        (
            '<p class="cta-final-microcopy">✨ Desde $1,000 MXN / mes. Cancela cuando quieras, sin planes forzosos ni costos de implementación ocultos.</p>',
            '<p class="cta-final-microcopy">✨ Primer usuario gratis para siempre. Licencias adicionales desde $1,000 MXN / mes. Sin plazos ocultos.</p>'
        )
    ]
    
    update_file_copy(os.path.join(ROOT, "lp/index.html"), flagship_replacements)
    update_file_copy(os.path.join(ROOT, "lp/inteligencia-artificial.html"), flagship_replacements)

    # 3. Replacements for CRM page (lp/crm.html)
    crm_replacements = [
        (
            '<p class="hero-sub">Monitorea oportunidades y automatiza cotizaciones. Con <strong>KAI AI</strong>, tu equipo tiene un copiloto que registra interacciones en segundos. Entra al entorno funcional y compruébalo sin registrarte.</p>',
            '<p class="hero-sub">Monitorea oportunidades y automatiza cotizaciones con el copiloto <strong>KAI AI</strong>. Comienza a usarlo gratis hoy mismo.</p>'
        ),
        (
            '<p class="hero-price">Un CRM y ERP integrados. Desde <strong>$1,000 MXN / mes</strong> por usuario. Sin planes forzosos.</p>',
            '<p class="hero-price">Tu primer usuario es gratis para siempre. Usuarios adicionales desde <strong>$1,000 MXN / mes</strong>. Sin plazos forzosos.</p>'
        ),
        (
            '<a href="#trial-section" class="btn btn-secondary-white">Iniciar cuenta gratis de por vida para 1 usuario</a>',
            '<a href="#trial-section" class="btn btn-secondary-white">Activar mi Usuario Gratis de por Vida</a>'
        ),
        (
            '<p class="hero-microcopy">✨ Interactúa en demo.ongoing2.mx hoy mismo.</p>',
            '<p class="hero-microcopy">✨ Ideal para microempresas y profesionistas: 1 usuario gratis, sin tarjetas ni plazos ocultos.</p>'
        ),
        (
            '<h4>Prueba Asistida Gratis</h4>',
            '<h4>Plan Gratis de por Vida</h4>'
        ),
        (
            '<p>Configuramos tu cuenta gratis de por vida para un usuario sin ningún costo de implementación.</p>',
            '<p>Tu primer usuario es gratis para siempre, sin costo de implementación ni tarjetas requeridas.</p>'
        ),
        (
            '<p>Descubre el poder de vender con un CRM inteligente. Abre el demo interactivo sin credenciales.</p>',
            '<p>Descubre el poder de vender con un CRM inteligente. Activa tu primer usuario gratis para siempre hoy mismo.</p>'
        ),
        (
            '<a href="https://demo.ongoing2.mx" target="_blank" class="btn btn-secondary-white">Crear cuenta gratis de por vida</a>',
            '<a href="https://demo.ongoing2.mx" target="_blank" class="btn btn-secondary-white">Activar mi Usuario Gratis de por Vida</a>'
        ),
        (
            '<p class="cta-final-microcopy">✨ Desde $1,000 MXN / mes. Pagas por lo que usas, sin contratos forzosos a largo plazo.</p>',
            '<p class="cta-final-microcopy">✨ Primer usuario gratis para siempre. Licencias adicionales desde $1,000 MXN / mes. Sin plazos ocultos.</p>'
        )
    ]
    update_file_copy(os.path.join(ROOT, "lp/crm.html"), crm_replacements)

    # 4. Replacements for Inventario page (lp/inventario.html)
    inventario_replacements = [
        (
            '<p class="hero-sub">Controla múltiples almacenes y automatiza compras. Descubre cómo <strong>KAI AI</strong> audita el stock al instante. No agendes llamadas, entra a nuestro entorno vivo y compruébalo.</p>',
            '<p class="hero-sub">Controla múltiples almacenes y automatiza compras asistido por IA. Tu primer usuario es gratis para siempre.</p>'
        ),
        (
            '<p class="hero-price">Control operativo total. Desde <strong>$1,000 MXN / mes</strong> por usuario. Sin ataduras.</p>',
            '<p class="hero-price">Tu primer usuario es gratis para siempre. Usuarios adicionales desde <strong>$1,000 MXN / mes</strong>. Sin plazos forzosos.</p>'
        ),
        (
            '<a href="#trial-section" class="btn btn-secondary-white">Iniciar cuenta gratis de por vida para 1 usuario</a>',
            '<a href="#trial-section" class="btn btn-secondary-white">Activar mi Usuario Gratis de por Vida</a>'
        ),
        (
            '<p class="hero-microcopy">✨ Genera una orden de compra en demo.ongoing2.mx sin registro.</p>',
            '<p class="hero-microcopy">✨ Ideal para microempresas y profesionistas: 1 usuario gratis, sin tarjetas ni plazos ocultos.</p>'
        ),
        (
            '<h4>Prueba Asistida Gratis</h4>',
            '<h4>Plan Gratis de por Vida</h4>'
        ),
        (
            '<p>Configuramos tu cuenta gratis de por vida para un usuario sin ningún costo de implementación.</p>',
            '<p>Tu primer usuario es gratis para siempre, sin costo de implementación ni tarjetas requeridas.</p>'
        ),
        (
            '<p>Comienza a operar con precisión absoluta. Explora nuestro almacén demo de inmediato.</p>',
            '<p>Comienza a operar con precisión absoluta. Activa tu primer usuario gratis para siempre hoy mismo.</p>'
        ),
        (
            '<a href="https://demo.ongoing2.mx" target="_blank" class="btn btn-secondary-white">Crear cuenta gratis de por vida</a>',
            '<a href="https://demo.ongoing2.mx" target="_blank" class="btn btn-secondary-white">Activar mi Usuario Gratis de por Vida</a>'
        ),
        (
            '<p class="cta-final-microcopy">✨ Desde $1,000 MXN / mes. Cancela en el momento que desees, sin planes forzosos.</p>',
            '<p class="cta-final-microcopy">✨ Primer usuario gratis para siempre. Licencias adicionales desde $1,000 MXN / mes. Sin plazos ocultos.</p>'
        )
    ]
    update_file_copy(os.path.join(ROOT, "lp/inventario.html"), inventario_replacements)

    # 5. Replacements for Servicios page (lp/servicios.html)
    servicios_replacements = [
        (
            '<p class="hero-sub">Combina la gestión de tareas con un *Time Tracker* preciso. Tu asistente <strong>KAI AI</strong> te reporta la desviación de costos al instante. Entra al demo sin barreras y registra tu primera hora.</p>',
            '<p class="hero-sub">Combina gestión de tareas con un *Time Tracker* preciso e inteligencia artificial. Sin costo para tu primer usuario.</p>'
        ),
        (
            '<p class="hero-price">Rentabilidad garantizada. Desde <strong>$1,000 MXN / mes</strong> por usuario. Sin plazos forzosos.</p>',
            '<p class="hero-price">Tu primer usuario es gratis para siempre. Usuarios adicionales desde <strong>$1,000 MXN / mes</strong>. Sin plazos forzosos.</p>'
        ),
        (
            '<a href="#trial-section" class="btn btn-secondary-white">Iniciar cuenta gratis de por vida para 1 usuario</a>',
            '<a href="#trial-section" class="btn btn-secondary-white">Activar mi Usuario Gratis de por Vida</a>'
        ),
        (
            '<p class="hero-microcopy">✨ Explora los hitos en demo.ongoing2.mx sin compromiso.</p>',
            '<p class="hero-microcopy">✨ Ideal para microempresas y profesionistas: 1 usuario gratis, sin tarjetas ni plazos ocultos.</p>'
        ),
        (
            '<h4>Prueba Asistida Gratis</h4>',
            '<h4>Plan Gratis de por Vida</h4>'
        ),
        (
            '<p>Configuramos tu cuenta gratis de por vida para un usuario sin ningún costo de implementación.</p>',
            '<p>Tu primer usuario es gratis para siempre, sin costo de implementación ni tarjetas requeridas.</p>'
        ),
        (
            '<p>Monitorea y optimiza la rentabilidad operativa de tu agencia o consultora ahora mismo en el demo en vivo.</p>',
            '<p>Monitorea y optimiza la rentabilidad operativa de tu agencia o consultora con tu primer usuario gratis de por vida.</p>'
        ),
        (
            '<a href="https://demo.ongoing2.mx" target="_blank" class="btn btn-secondary-white">Iniciar gratis de por vida (1 usuario)</a>',
            '<a href="https://demo.ongoing2.mx" target="_blank" class="btn btn-secondary-white">Activar mi Usuario Gratis de por Vida</a>'
        ),
        (
            '<p class="cta-final-microcopy">✨ Desde $1,000 MXN / mes. Cero letras chiquitas y sin contratos forzosos.</p>',
            '<p class="cta-final-microcopy">✨ Primer usuario gratis para siempre. Licencias adicionales desde $1,000 MXN / mes. Sin plazos ocultos.</p>'
        )
    ]
    update_file_copy(os.path.join(ROOT, "lp/servicios.html"), servicios_replacements)

    # 6. Replacements for Finanzas page (lp/finanzas.html)
    finanzas_replacements = [
        (
            '<p class="hero-sub">Conecta ventas y compras con tu tesorería. Automatiza cuentas por cobrar/pagar con análisis en tiempo real impulsado por tu analista IA, <strong>KAI</strong>. Pruébalo ahora mismo con datos de ejemplo.</p>',
            '<p class="hero-sub">Conecta ventas y compras con tu tesorería. Automatiza cuentas por cobrar/pagar con análisis en tiempo real impulsado por tu analista IA, <strong>KAI</strong>. Tu primer usuario es gratis para siempre.</p>'
        ),
        (
            '<p class="hero-price">Inteligencia financiera corporativa. Desde <strong>$1,000 MXN / mes</strong> por usuario. Sin plazos forzosos.</p>',
            '<p class="hero-price">Tu primer usuario es gratis para siempre. Usuarios adicionales desde <strong>$1,000 MXN / mes</strong>. Sin plazos forzosos.</p>'
        ),
        (
            '<a href="#trial-section" class="btn btn-secondary-white">Iniciar cuenta gratis de por vida para 1 usuario</a>',
            '<a href="#trial-section" class="btn btn-secondary-white">Activar mi Usuario Gratis de por Vida</a>'
        ),
        (
            '<p class="hero-microcopy">✨ Audita las finanzas en demo.ongoing2.mx ahora mismo.</p>',
            '<p class="hero-microcopy">✨ Ideal para microempresas y profesionistas: 1 usuario gratis, sin tarjetas ni plazos ocultos.</p>'
        ),
        (
            '<h4>Prueba Asistida Gratis</h4>',
            '<h4>Plan Gratis de por Vida</h4>'
        ),
        (
            '<p>Configuramos tu cuenta gratis de por vida para un usuario sin ningún costo de implementación.</p>',
            '<p>Tu primer usuario es gratis para siempre, sin costo de implementación ni tarjetas requeridas.</p>'
        ),
        (
            '<p>Conozca el estado real de sus cuentas de inmediato. Ingrese a la consola financiera con datos de prueba cargados.</p>',
            '<p>Conozca el estado real de sus cuentas de inmediato. Active su primer usuario gratis para siempre hoy mismo.</p>'
        ),
        (
            '<a href="https://demo.ongoing2.mx" target="_blank" class="btn btn-secondary-white">Comenzar mi cuenta gratis de por vida para 1 usuario</a>',
            '<a href="https://demo.ongoing2.mx" target="_blank" class="btn btn-secondary-white">Activar mi Usuario Gratis de por Vida</a>'
        ),
        (
            '<p class="cta-final-microcopy">✨ Desde $1,000 MXN / mes. Libertad total, sin contratos forzosos ni plazos mínimos.</p>',
            '<p class="cta-final-microcopy">✨ Primer usuario gratis para siempre. Licencias adicionales desde $1,000 MXN / mes. Sin plazos ocultos.</p>'
        )
    ]
    update_file_copy(os.path.join(ROOT, "lp/finanzas.html"), finanzas_replacements)

if __name__ == "__main__":
    main()
