<?php
/**
 * API Endpoint: Generate Profile Report
 * Developer: Sevcan Koç
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$config = require __DIR__ . '/../config.php';
require_once __DIR__ . '/../services/AstrologyService.php';
require_once __DIR__ . '/../services/GeminiService.php';

try {
    $rawInput = file_get_contents('php://input');
    $data = json_decode($rawInput, true);

    if (!$data) {
        $data = $_POST;
    }

    $name = trim($data['name'] ?? '');
    $email = trim($data['email'] ?? '');
    $title = trim($data['title'] ?? 'Profesyonel');
    $birthDate = trim($data['birthDate'] ?? '');
    $birthTime = trim($data['birthTime'] ?? '12:00');
    $birthPlace = trim($data['birthPlace'] ?? 'İstanbul');
    $language = ($data['language'] ?? 'tr') === 'en' ? 'en' : 'tr';

    if (empty($name) || empty($birthDate)) {
        echo json_encode([
            'status' => 'error',
            'message' => $language === 'en' ? 'Name and Birth Date are required.' : 'Ad Soyad ve Doğum Tarihi alanları zorunludur.'
        ]);
        exit;
    }

    // Parse Birth Date & Time
    $dateParts = explode('-', $birthDate);
    $year = isset($dateParts[0]) ? (int)$dateParts[0] : 1990;
    $month = isset($dateParts[1]) ? (int)$dateParts[1] : 1;
    $day = isset($dateParts[2]) ? (int)$dateParts[2] : 1;

    $timeParts = explode(':', $birthTime);
    $hour = isset($timeParts[0]) ? (int)$timeParts[0] : 12;
    $minute = isset($timeParts[1]) ? (int)$timeParts[1] : 0;

    // 1. Calculate Planetary Coordinates & Chart Points in PHP
    $planets = AstrologyService::calculateNatalChart($year, $month, $day, $hour, $minute, $language);

    // 2. Generate Profession & Astrological AI Profile
    $userData = [
        'name' => $name,
        'email' => $email,
        'title' => $title,
        'birthDate' => $birthDate,
        'birthTime' => $birthTime,
        'birthPlace' => $birthPlace,
        'language' => $language
    ];

    $aiResult = GeminiService::generateProfile($userData, $planets, $config);

    // 3. Resolve Coffee Assets & Details
    $coffeeName = $aiResult['coffee'] ?? 'Flat White';
    $coffeeInfo = GeminiService::$coffeeTypes[$coffeeName] ?? GeminiService::$coffeeTypes['Flat White'];
    $coffeeImage = $coffeeInfo['img'];
    $coffeeDesc = $coffeeInfo[$language];
    $coffeeReason = $aiResult['coffee_reason'] ?? '';

    $reportId = bin2hex(random_bytes(8));

    // 4. Assemble Final Response Data
    $reportData = [
        'id' => $reportId,
        'timestamp' => date('Y-m-d H:i:s'),
        'user' => [
            'name' => $name,
            'email' => $email,
            'title' => $title,
            'birthDate' => $birthDate,
            'birthTime' => $birthTime,
            'birthPlace' => $birthPlace,
            'language' => $language
        ],
        'astrology' => $planets,
        'analysis' => [
            'sections' => $aiResult['sections'],
            'advice' => $aiResult['advice'],
            'energy_score' => $aiResult['energy_score'] ?? 90,
            'lucky_hex' => $aiResult['lucky_hex'] ?? '#00E5FF',
            'lucky_color_name' => $aiResult['lucky_color_name'] ?? 'Siber Turkuaz',
            'lucky_totem' => $aiResult['lucky_totem'] ?? 'Masa Prizması',
            'coffee' => [
                'name' => $coffeeName,
                'image' => 'assets/img/' . $coffeeImage,
                'desc' => $coffeeDesc,
                'reason' => $coffeeReason
            ]
        ],
        'app' => [
            'name' => $config['app_name'],
            'subtitle' => $config['app_subtitle'],
            'developer' => $config['developer']
        ]
    ];

    // Save JSON report into reports/
    $reportFilePath = $config['reports_dir'] . '/' . $reportId . '.json';
    file_put_contents($reportFilePath, json_encode($reportData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    echo json_encode([
        'status' => 'success',
        'report_id' => $reportId,
        'data' => $reportData,
        'report_url' => 'report.php?id=' . $reportId
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
