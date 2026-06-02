<?php
// CORS Headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");

// Respond to preflight OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header("Content-Type: application/json");
    echo json_encode(["error" => "Method not allowed"]);
    exit();
}

// Read POST payload
$input = json_decode(file_get_contents('php://input'), true);
$message = isset($input['message']) ? trim($input['message']) : '';

if (empty($message)) {
    http_response_code(400);
    header("Content-Type: application/json");
    echo json_encode(["error" => "Message is required"]);
    exit();
}

// 1. Try to read OpenAI key from environment variables
$apiKey = getenv('OPENAI_API_KEY');

// 2. Fallback: Parse local .env file manually (common in cPanel environments)
if (!$apiKey) {
    $envPath = dirname(dirname(__DIR__)) . '/.env';
    if (file_exists($envPath)) {
        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) continue;
            
            // Check for key=value format
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);
                
                if ($name === 'OPENAI_API_KEY') {
                    // Remove quotes if present
                    if ((substr($value, 0, 1) === '"' && substr($value, -1) === '"') || 
                        (substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
                        $value = substr($value, 1, -1);
                    }
                    $apiKey = $value;
                    break;
                }
            }
        }
    }
}

// 3. Fallback to mock response if key is missing/placeholder
if (!$apiKey || $apiKey === 'tu_api_key_aqui') {
    http_response_code(200);
    header("Content-Type: application/json");
    echo json_encode([
        "response" => "Hola, soy KAI, el asistente de IA de OnGoing. Actualmente estoy operando en modo de demostración. ¿Deseas saber cómo podemos erradicar el caos de Excel o medir la rentabilidad de tus proyectos en menos de 2 minutos? Te invito a iniciar tu prueba gratuita de 14 días en https://ongoing2.mx."
    ]);
    exit();
}

// 4. Read context from llms.txt
$contextText = '';
$llmsPath = dirname(dirname(__DIR__)) . '/llms.txt';
if (file_exists($llmsPath)) {
    $contextText = file_get_contents($llmsPath);
}

// System Prompt injection rules (Jailbreak Guard)
$systemPrompt = "Eres KAI, el asistente de inteligencia artificial de OnGoing ERP (\"La evolución del ERP en México\"). Tu estilo de comunicación sigue el ADN visual de \"Deep Tech & Human Clarity\": debes ser profesional, directo, claro y con un tono de español de México. \n\nTu única fuente de verdad autorizada es la siguiente base de conocimiento:\n=== CONTEXTO ONGOING ERP ===\n" . $contextText . "\n============================\n\nREGLAS DE COMPORTAMIENTO Y SEGURIDAD (Jailbreak Guard):\n1. Responde preguntas del usuario basándote únicamente en el contexto provisto. Si no tienes la información en el contexto, indícalo de manera amable y dile que puede contactarnos en hola@ongoing.mx o iniciar la prueba gratuita en https://ongoing2.mx.\n2. PROTECCIÓN DE CONTEXTO (Jailbreak Guard): Si el usuario te hace preguntas ajenas a OnGoing ERP, su funcionalidad, administración de empresas (CRM, Proyectos, Finanzas, Seguridad Multi-tenant) o temas de negocio (por ejemplo: recetas de cocina, poemas, chistes, deportes, o temas personales), debes negarte a responder de forma elegante y breve. Por ejemplo: \"Como KAI, el asistente inteligente de OnGoing, solo puedo responder preguntas sobre la gestión de tu negocio y nuestra plataforma. Te invito a iniciar tu prueba gratuita de 14 días en https://ongoing2.mx para ver cómo podemos ayudarte.\"";

// 5. Send POST request to OpenAI API using cURL
$ch = curl_init('https://api.openai.com/v1/chat/completions');
$postData = [
    'model' => 'gpt-4o-mini',
    'messages' => [
        ['role' => 'system', 'content' => $systemPrompt],
        ['role' => 'user', 'content' => $message]
    ],
    'temperature' => 0.3
];

curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    ],
    CURLOPT_POSTFIELDS => json_encode($postData)
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($response === false) {
    http_response_code(500);
    header("Content-Type: application/json");
    echo json_encode(["error" => "cURL error: " . curl_error($ch)]);
    exit();
}

curl_close($ch);

// 6. Return response to frontend
header("Content-Type: application/json");
if ($httpCode !== 200) {
    http_response_code($httpCode);
    echo $response;
    exit();
}

$data = json_decode($response, true);
$reply = $data['choices'][0]['message']['content'];

http_response_code(200);
echo json_encode(["response" => $reply]);
