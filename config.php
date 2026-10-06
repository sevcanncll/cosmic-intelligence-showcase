<?php
/**
 * Cosmic Intelligence - Configuration
 * Developer: Sevcan Koç
 */

// Load .env if exists
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) continue;
        if (str_contains($line, '=')) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim(trim($value), "\"'");
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
}

return [
    'app_name' => 'Cosmic Intelligence',
    'app_subtitle' => 'AI Potential & Leadership Profiler',
    'app_version' => '2.0.0',
    'developer' => 'Sevcan Koç',
    'developer_url' => 'https://github.com/sevcanncll',
    
    // Gemini API Key (Loaded strictly from .env or system environment)
    'gemini_api_key' => getenv('GEMINI_API_KEY') ?: ($_ENV['GEMINI_API_KEY'] ?? ''),
    'gemini_model' => getenv('GEMINI_MODEL') ?: ($_ENV['GEMINI_MODEL'] ?? 'gemini-2.5-flash'),
    
    'base_url' => '/cosmic_intelligence',
    'reports_dir' => __DIR__ . '/reports',
];
