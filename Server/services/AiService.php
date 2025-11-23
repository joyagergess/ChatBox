<?php
$prompts = require_once(__DIR__ . "/PromptService.php");
$config = require(__DIR__ . '/../config/config.php');
$apiKey = $config['API_KEY'];

function callAI(string $promptKey, string $userText): ?array {
    global $prompts;
    $fullPrompt = $prompts[$promptKey] . "\n\nUser Input:\n" . $userText;

    $response = sendAIRequest($fullPrompt);
    return parseAIResponse($response);
}

function sendAIRequest(string $prompt): string {
    global $apiKey;

    $data = [
        'model' => 'gpt-4o-mini',
        'messages' => [
            ['role' => 'user', 'content' => $prompt]
        ],
        'temperature' => 0
    ];

    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: ' . 'Bearer ' . $apiKey
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

function parseAIResponse(string $response): ?array {
    $responseData = json_decode($response, true);
    $content = $responseData['choices'][0]['message']['content'] ?? null;

    return $content ? ['summary' => $content] : null;
}
