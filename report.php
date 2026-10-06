<?php
/**
 * Report Viewer & Printable A4 Template
 * Developer: Sevcan Koç
 */

$config = require __DIR__ . '/config.php';

$reportId = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['id'] ?? '');
$reportFile = __DIR__ . '/reports/' . $reportId . '.json';

if (empty($reportId) || !file_exists($reportFile)) {
    die("<h3>Rapor bulunamadı veya henüz oluşturulmadı.</h3><a href='index.php'>Yeni Analiz Başlat</a>");
}

$data = json_decode(file_get_contents($reportFile), true);
$user = $data['user'];
$astro = $data['astrology'];
$analysis = $data['analysis'];
$lang = $user['language'] ?? 'tr';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($user['name']) ?> - Cosmic Intelligence Profil Raporu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        @page {
            margin: 0;
            size: A4 portrait;
        }

        @media print {
            body {
                background: #060B18 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print {
                display: none !important;
            }
            .a4-sheet {
                box-shadow: none !important;
                margin: 0 auto !important;
                page-break-inside: avoid !important;
            }
        }

        .report-page-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px 10px;
            background: #030712;
            min-height: 100vh;
        }

        .toolbar {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            z-index: 100;
        }

        .btn-toolbar {
            background: rgba(14, 165, 233, 0.15);
            border: 1px solid rgba(14, 165, 233, 0.4);
            color: #ffffff;
            padding: 10px 22px;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(8px);
            transition: all 0.25s ease;
        }

        .btn-toolbar:hover {
            background: #0284c7;
            border-color: #38bdf8;
            box-shadow: 0 0 15px rgba(14, 165, 233, 0.5);
            transform: translateY(-1px);
        }

        .btn-toolbar.btn-primary {
            background: linear-gradient(135deg, #0284c7, #7c3aed);
            border: none;
        }

        /* Standard A4 exact box */
        .a4-sheet {
            width: 794px;
            min-height: 1122px;
            max-height: 1122px;
            background-color: #060B18;
            background-image: radial-gradient(circle at 85% 15%, rgba(14, 165, 233, 0.25) 0%, rgba(6, 11, 24, 0.95) 50%);
            color: #ffffff;
            position: relative;
            box-sizing: border-box;
            padding: 24px 38px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.8), 0 0 20px rgba(14, 165, 233, 0.2);
            border-radius: 12px;
        }

        .rep-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid rgba(14, 165, 233, 0.6);
            padding-bottom: 12px;
            margin-bottom: 12px;
            z-index: 2;
        }

        .rep-logo {
            height: 48px;
            max-width: 250px;
            object-fit: contain;
        }

        .rep-title-block {
            text-align: right;
        }

        .rep-title-block h1 {
            margin: 0;
            font-size: 20px;
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: #FFD700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .rep-title-block h2 {
            margin: 2px 0 0 0;
            font-size: 11px;
            color: #9FDDFF;
            font-weight: 400;
            letter-spacing: 1px;
        }

        .rep-user-bar {
            display: grid;
            grid-template-columns: 1.2fr 1.2fr 1fr 1.2fr;
            gap: 10px;
            background: rgba(14, 165, 233, 0.08);
            border: 1px solid rgba(14, 165, 233, 0.25);
            padding: 8px 14px;
            border-radius: 8px;
            margin-bottom: 10px;
            z-index: 2;
        }

        .rep-user-item label {
            display: block;
            font-size: 9px;
            color: #7dd3fc;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .rep-user-item span {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #ffffff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-top: 2px;
        }

        .rep-astro-line {
            font-size: 9.5px;
            color: #93c5fd;
            text-align: right;
            margin-bottom: 8px;
            z-index: 2;
            font-weight: 500;
        }

        .rep-stats-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr 1.4fr;
            gap: 10px;
            background: rgba(3, 7, 18, 0.6);
            border: 1px solid rgba(14, 165, 233, 0.2);
            padding: 7px 12px;
            border-radius: 8px;
            margin-bottom: 12px;
            z-index: 2;
            align-items: center;
        }

        .rep-stat {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 10px;
        }

        .stat-tag {
            color: #7dd3fc;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 9px;
        }

        .progress-bar-wrap {
            flex: 1;
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            overflow: hidden;
            border: 1px solid rgba(14, 165, 233, 0.5);
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #0284c7, #00f5d4);
            box-shadow: 0 0 8px #00f5d4;
        }

        .rep-sections-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px 14px;
            margin-bottom: 12px;
            z-index: 2;
        }

        .rep-sec-card {
            background: rgba(10, 18, 38, 0.75);
            border: 1px solid rgba(14, 165, 233, 0.2);
            border-left: 3.5px solid #0284c7;
            border-radius: 6px;
            padding: 8px 12px;
            backdrop-filter: blur(4px);
        }

        .rep-sec-card h3 {
            margin: 0 0 3px 0;
            font-size: 10.5px;
            font-weight: 700;
            color: #7dd3fc;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .rep-sec-card p {
            margin: 0;
            font-size: 10px;
            line-height: 1.35;
            color: #e2e8f0;
        }

        .rep-coffee-card {
            display: flex;
            align-items: center;
            background: rgba(14, 165, 233, 0.07);
            border: 1px solid rgba(255, 215, 0, 0.35);
            border-radius: 8px;
            padding: 8px 14px;
            gap: 15px;
            margin-bottom: 10px;
            z-index: 2;
        }

        .rep-coffee-thumb {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #FFD700;
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.4);
            flex-shrink: 0;
        }

        .rep-coffee-details h4 {
            margin: 0 0 2px 0;
            font-size: 12.5px;
            color: #FFD700;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .rep-coffee-details .desc {
            font-size: 9.5px;
            color: #e2e8f0;
            line-height: 1.3;
            margin: 0;
        }

        .rep-coffee-details .reason {
            font-size: 9px;
            color: #93c5fd;
            font-style: italic;
            margin-top: 3px;
        }

        .rep-advice-card {
            background: linear-gradient(135deg, rgba(2, 132, 199, 0.35) 0%, rgba(124, 58, 237, 0.3) 100%);
            border: 1px solid rgba(255, 215, 0, 0.6);
            border-radius: 8px;
            padding: 8px 14px;
            text-align: center;
            margin-bottom: 10px;
            z-index: 2;
        }

        .rep-advice-card h4 {
            margin: 0 0 3px 0;
            font-size: 10px;
            color: #FFD700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 700;
        }

        .rep-advice-card p {
            margin: 0;
            font-size: 11px;
            font-weight: 600;
            font-style: italic;
            color: #ffffff;
            line-height: 1.35;
        }

        .chart-bg-overlay {
            position: absolute;
            top: 52%;
            left: 50%;
            transform: translate(-50%, -45%);
            width: 720px;
            height: 720px;
            opacity: 0.12;
            z-index: 0;
            pointer-events: none;
        }

        .chart-bg-overlay img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
        }

        .planet-marker {
            position: absolute;
            width: 7px;
            height: 7px;
            background: #FFD700;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            box-shadow: 0 0 8px #FFD700;
        }

        .planet-tag {
            position: absolute;
            color: #FFD700;
            font-size: 8px;
            font-weight: 700;
            transform: translate(8px, -50%);
            text-shadow: 0 0 4px #000;
        }

        .rep-footer {
            margin-top: auto;
            border-top: 1px solid rgba(14, 165, 233, 0.25);
            padding-top: 8px;
            text-align: center;
            font-size: 8.5px;
            color: #94a3b8;
            z-index: 2;
        }
        
        .rep-footer strong {
            color: #38bdf8;
        }
    </style>
</head>
<body>

<div class="report-page-wrapper">
    
    <!-- Action Toolbar (Hidden in Print) -->
    <div class="toolbar no-print">
        <a href="index.php" class="btn-toolbar">
            <span>←</span> <?= $lang === 'en' ? 'New Profiler' : 'Yeni Analiz' ?>
        </a>
        <button onclick="window.print()" class="btn-toolbar btn-primary">
            <span>🖨️</span> <?= $lang === 'en' ? 'Print / Save as PDF' : 'Yazdır / PDF Olarak Kaydet' ?>
        </button>
    </div>

    <!-- Official A4 Document -->
    <div class="a4-sheet">

        <!-- Header -->
        <div class="rep-header">
            <img src="assets/img/cosmic_logo.svg" alt="Cosmic Intelligence" class="rep-logo">
            <div class="rep-title-block">
                <h1>AI Natal Profiler</h1>
                <h2>Cosmic Intelligence Potential &amp; Leadership Report</h2>
            </div>
        </div>

        <!-- User Information Bar -->
        <div class="rep-user-bar">
            <div class="rep-user-item">
                <label><?= $lang === 'en' ? 'Candidate Name' : 'Katılımcı Adı' ?></label>
                <span><?= htmlspecialchars($user['name']) ?></span>
            </div>
            <div class="rep-user-item">
                <label><?= $lang === 'en' ? 'Profession / Title' : 'Meslek / Unvan' ?></label>
                <span><?= htmlspecialchars($user['title']) ?></span>
            </div>
            <div class="rep-user-item">
                <label><?= $lang === 'en' ? 'Birth Place' : 'Doğum Yeri' ?></label>
                <span><?= htmlspecialchars($user['birthPlace']) ?></span>
            </div>
            <div class="rep-user-item">
                <label><?= $lang === 'en' ? 'Birth Date & Time' : 'Tarih & Saat' ?></label>
                <span><?= htmlspecialchars($user['birthDate']) ?> | <?= htmlspecialchars($user['birthTime']) ?></span>
            </div>
        </div>

        <!-- Planetary Coordinates Line -->
        <div class="rep-astro-line">
            <?= $lang === 'en' ? 'Planetary Alignment:' : 'Gezegen Konumları:' ?> 
            Sun <?= $astro['positions']['Sun'] ?? '' ?> &bull; 
            Moon <?= $astro['positions']['Moon'] ?? '' ?> &bull; 
            Mercury <?= $astro['positions']['Mercury'] ?? '' ?> &bull; 
            Venus <?= $astro['positions']['Venus'] ?? '' ?> &bull; 
            Mars <?= $astro['positions']['Mars'] ?? '' ?>
        </div>

        <!-- Mini Stats Bar -->
        <div class="rep-stats-grid">
            <div class="rep-stat">
                <span class="stat-tag"><?= $lang === 'en' ? 'INNOVATION ENERGY:' : 'İNOVASYON & ODAK:' ?></span>
                <div class="progress-bar-wrap">
                    <div class="progress-bar-fill" style="width: <?= (int)$analysis['energy_score'] ?>%;"></div>
                </div>
                <span style="font-weight: 700; color: #00f5d4;">%<?= (int)$analysis['energy_score'] ?></span>
            </div>

            <div class="rep-stat">
                <span class="stat-tag"><?= $lang === 'en' ? 'AURA HEX:' : 'AURA HEX:' ?></span>
                <div style="width: 11px; height: 11px; border-radius: 50%; background: <?= htmlspecialchars($analysis['lucky_hex']) ?>; box-shadow: 0 0 6px <?= htmlspecialchars($analysis['lucky_hex']) ?>;"></div>
                <span style="font-weight: 700; color: <?= htmlspecialchars($analysis['lucky_hex']) ?>;"><?= htmlspecialchars($analysis['lucky_color_name']) ?></span>
            </div>

            <div class="rep-stat">
                <span class="stat-tag"><?= $lang === 'en' ? 'OFFICE TOTEM:' : 'MASA TOTEMİ:' ?></span>
                <span style="font-weight: 700; color: #FFD700;"><?= htmlspecialchars($analysis['lucky_totem']) ?></span>
            </div>
        </div>

        <!-- 6 Analysis Sections Grid -->
        <div class="rep-sections-grid">
            <?php foreach ($analysis['sections'] as $sec): ?>
                <div class="rep-sec-card">
                    <h3><?= htmlspecialchars($sec['title']) ?></h3>
                    <p><?= htmlspecialchars($sec['content']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Coffee Match Section -->
        <div class="rep-coffee-card">
            <img src="<?= htmlspecialchars($analysis['coffee']['image']) ?>" alt="Coffee Match" class="rep-coffee-thumb">
            <div class="rep-coffee-details">
                <h4><?= $lang === 'en' ? 'Cosmic Coffee Match:' : 'Kozmik Kahve Eşleşmesi:' ?> <?= htmlspecialchars($analysis['coffee']['name']) ?></h4>
                <p class="desc"><?= htmlspecialchars($analysis['coffee']['desc']) ?></p>
                <?php if (!empty($analysis['coffee']['reason'])): ?>
                    <div class="reason">"<?= htmlspecialchars($analysis['coffee']['reason']) ?>"</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- AI Advice of the Day -->
        <div class="rep-advice-card">
            <h4><?= $lang === 'en' ? 'AI Potential & Leadership Aphorism' : 'Günün AI Liderlik & Potansiyel Aforizması' ?></h4>
            <p>"<?= htmlspecialchars($analysis['advice']) ?>"</p>
        </div>

        <!-- Celestial Radar Chart Overlay -->
        <div class="chart-bg-overlay">
            <img src="assets/img/chart_base.jpg" alt="Natal Chart">
            <?php if (!empty($astro['chart_points'])): ?>
                <?php foreach ($astro['chart_points'] as $pt): ?>
                    <div class="planet-marker" style="left: <?= $pt['x'] ?>%; top: <?= $pt['y'] ?>%;"></div>
                    <div class="planet-tag" style="left: <?= $pt['x'] ?>%; top: <?= $pt['y'] ?>%;"><?= strtoupper(substr($pt['name'], 0, 3)) ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Footer with Developer Credit -->
        <div class="rep-footer">
            Generated by <strong>Cosmic Intelligence AI</strong> &bull; System Architecture &amp; Lead Development: <strong>Sevcan Koç</strong><br>
            Powered by Google Gemini 2.5 Flash &bull; Professional Cognitive Profiling &copy; <?= date('Y') ?>
        </div>

    </div>

</div>

</body>
</html>
