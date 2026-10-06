<?php
/**
 * Cosmic Intelligence - Configuration Template (Public Showcase)
 * Developer: Sevcan Koç
 */

return [
    'app_name' => 'Cosmic Intelligence',
    'app_subtitle' => 'AI Potential & Leadership Profiler',
    'app_version' => '2.0.0',
    'developer' => 'Sevcan Koç',
    'developer_url' => 'https://github.com/sevcankoc',
    
    // Set your Google Gemini API Key in .env or here
    'gemini_api_key' => getenv('GEMINI_API_KEY') ?: 'YOUR_GEMINI_API_KEY_HERE',
    'gemini_model' => getenv('GEMINI_MODEL') ?: 'gemini-2.5-flash',
    
    'base_url' => '/cosmic_intelligence',
    'reports_dir' => __DIR__ . '/reports',
];
