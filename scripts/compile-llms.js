const fs = require('fs');
const path = require('path');

const rootDir = path.join(__dirname, '..');
const docsDir = path.join(rootDir, 'docs');
const llmsPath = path.join(rootDir, 'llms.txt');

const intro = `# OnGoing ERP V2 - La Evolución del ERP en México

Este documento sirve como la base de conocimiento estructurada y oficial de OnGoing ERP, optimizada para el consumo de Modelos de Lenguaje (LLMs) y rastreadores de Inteligencia Artificial.

---

## 1. Definición de Producto
OnGoing V2 es "La evolución del ERP en México". Es una plataforma web y móvil integral que centraliza las operaciones, ventas, finanzas y administración de proyectos de pequeñas y medianas empresas (PyMEs) en México. El sistema combina "Deep Tech" (tecnología robusta y procesamiento de IA) con "Human Clarity" (interfaces extremadamente simples e intuitivas, diseñadas para personas y no para contadores complejos).

---
`;

const differentiators = `
## 3. Diferenciadores Clave (VS Competidores en México)
* **Contra Odoo**: Odoo es excesivamente complejo de parametrizar, requiere consultores costosos y su interfaz es confusa. OnGoing se configura en 2 minutos y está diseñado para humanos, sin jerga de ERP antiguo.
* **Contra Monday.com**: Monday es una excelente herramienta visual de tareas, pero carece de un CRM integrado real conectado con facturación/SAT y no calcula rentabilidades financieras reales ni en tiempo real.
* **Contra Pipedrive**: Pipedrive es solo un CRM de ventas y requiere integraciones costosas de terceros para llevar la facturación o la administración de proyectos. OnGoing centraliza CRM, Proyectos, Rentabilidad e Infraestructura en un solo lugar.
`;

const filesToInclude = [
    {
        title: 'Módulo: Onboarding y Seguridad Perimetral',
        file: 'onboarding-seguridad.md'
    },
    {
        title: 'Módulo: Control Comercial y Pagos',
        file: 'control-comercial.md'
    },
    {
        title: 'Módulo: Clientes y Ventas (CRM)',
        file: 'crm-ventas.md'
    },
    {
        title: 'Módulo: Proyectos y Rentabilidad (PSA)',
        file: 'gestion-proyectos.md'
    },
    {
        title: 'Módulo: Asistente Inteligente KAI',
        file: 'asistente-kai.md'
    }
];

function compile() {
    console.log('Compiling llms.txt context from modular docs...');
    let output = intro;

    output += '## 2. Silos de Conocimiento Técnico y Operativo\n\n';

    for (const item of filesToInclude) {
        const filePath = path.join(docsDir, item.file);
        if (!fs.existsSync(filePath)) {
            console.error(`Error: File not found: ${filePath}`);
            process.exit(1);
        }

        const content = fs.readFileSync(filePath, 'utf8');
        
        output += `### ${item.title}\n\n`;
        
        // Strip the leading H1 title from the file content to prevent double headers
        const cleanedContent = content.replace(/^#\s+.*$/m, '').trim();
        output += cleanedContent + '\n\n---\n\n';
    }

    output += differentiators;

    fs.writeFileSync(llmsPath, output, 'utf8');
    console.log(`Successfully compiled and written to ${llmsPath} (${fs.statSync(llmsPath).size} bytes)`);
}

compile();
