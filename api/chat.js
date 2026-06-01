const fs = require('fs');
const path = require('path');

module.exports = async function handler(req, res) {
    // Cors Headers
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Headers', 'Content-Type');
    res.setHeader('Access-Control-Allow-Methods', 'POST, OPTIONS');

    if (req.method === 'OPTIONS') {
        return res.status(200).end();
    }

    if (req.method !== 'POST') {
        return res.status(405).json({ error: 'Method not allowed' });
    }

    const { message } = req.body || {};
    if (!message) {
        return res.status(400).json({ error: 'Message is required' });
    }

    const apiKey = process.env.OPENAI_API_KEY;
    if (!apiKey || apiKey === 'tu_api_key_aqui') {
        // Mock response if no valid API key is set for testing/demo environments
        return res.status(200).json({ 
            response: "Hola, soy KAI, el asistente de IA de OnGoing. Actualmente estoy operando en modo de demostración. ¿Deseas saber cómo podemos erradicar el caos de Excel o medir la rentabilidad de tus proyectos en menos de 2 minutos? Te invito a iniciar tu prueba gratuita de 14 días en https://ongoing2.mx." 
        });
    }

    // Read llms.txt context
    let contextText = '';
    try {
        const contextPath = path.join(process.cwd(), 'llms.txt');
        contextText = fs.readFileSync(contextPath, 'utf8');
    } catch (err) {
        console.error('Error reading llms.txt:', err);
    }

    const systemPrompt = `Eres KAI, el asistente de inteligencia artificial de OnGoing ERP ("La evolución del ERP en México"). Tu estilo de comunicación sigue el ADN visual de "Deep Tech & Human Clarity": debes ser profesional, directo, claro y con un tono de español de México. 

Tu única fuente de verdad autorizada es la siguiente base de conocimiento:
=== CONTEXTO ONGOING ERP ===
${contextText}
============================

REGLAS DE COMPORTAMIENTO Y SEGURIDAD (Jailbreak Guard):
1. Responde preguntas del usuario basándote únicamente en el contexto provisto. Si no tienes la información en el contexto, indícalo de manera amable y dile que puede contactarnos en hola@ongoing.mx o iniciar la prueba gratuita en https://ongoing2.mx.
2. PROTECCIÓN DE CONTEXTO (Jailbreak Guard): Si el usuario te hace preguntas ajenas a OnGoing ERP, su funcionalidad, administración de empresas (CRM, Proyectos, Finanzas, Seguridad Multi-tenant) o temas de negocio (por ejemplo: recetas de cocina, poemas, chistes, deportes, o temas personales), debes negarte a responder de forma elegante y breve. Por ejemplo: "Como KAI, el asistente inteligente de OnGoing, solo puedo responder preguntas sobre la gestión de tu negocio y nuestra plataforma. Te invito a iniciar tu prueba gratuita de 14 días en https://ongoing2.mx para ver cómo podemos ayudarte."`;

    try {
        const response = await fetch('https://api.openai.com/v1/chat/completions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${apiKey}`
            },
            body: JSON.stringify({
                model: 'gpt-4o-mini',
                messages: [
                    { role: 'system', content: systemPrompt },
                    { role: 'user', content: message }
                ],
                temperature: 0.3
            })
        });

        if (!response.ok) {
            const errorData = await response.json();
            return res.status(500).json({ error: 'OpenAI API error', details: errorData });
        }

        const data = await response.json();
        const reply = data.choices[0].message.content;
        return res.status(200).json({ response: reply });
    } catch (error) {
        console.error('Chat API Error:', error);
        return res.status(500).json({ error: 'Internal server error' });
    }
};
