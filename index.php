<?php
/**
 * Cosmic Intelligence - AI Potential & Leadership Profiler
 * Lead Developer: Sevcan Koç
 */

$config = require __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($config['app_name']) ?> - <?= htmlspecialchars($config['app_subtitle']) ?></title>
    <meta name="description" content="Yapay Zeka Destekli Bireysel ve Mesleki Liderlik Potansiyel Analizi. Developed by Sevcan Koç.">
    <meta name="author" content="Sevcan Koç">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Ambient Floating Orbs -->
    <div class="glow-orb-1"></div>
    <div class="glow-orb-2"></div>

    <!-- Audio Player (Hidden Element) -->
    <audio id="bgAudio" loop src="assets/audio/mystic_bgm.mp3" preload="auto"></audio>

    <!-- Navigation Bar -->
    <header class="top-nav">
        <div class="brand-emblem">
            <img src="assets/img/cosmic_logo.svg" alt="<?= htmlspecialchars($config['app_name']) ?>" class="brand-logo-img">
        </div>
        <div class="nav-actions">
            <button id="langToggleBtn" class="btn-lang" title="Dili Değiştir / Change Language">EN</button>
            <button id="musicToggleBtn" class="btn-icon-toggle" title="Müziği Aç / Kapat">🔇</button>
        </div>
    </header>

    <!-- Main Container -->
    <main class="main-wrapper">
        <div class="glass-card">

            <!-- Step 1: Input Form -->
            <div id="stepForm">
                <h1 class="card-title" data-i18n="title"><?= htmlspecialchars($config['app_name']) ?></h1>
                <h2 class="card-subtitle" data-i18n="subtitle"><?= htmlspecialchars($config['app_subtitle']) ?></h2>

                <form id="profilerForm">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="inputName" data-i18n="nameLabel">Ad Soyad</label>
                            <input required type="text" id="inputName" class="form-input" placeholder="Örn: Ali Yılmaz" data-i18n-placeholder="namePlaceholder">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="inputEmail" data-i18n="emailLabel">E-Posta Adresi</label>
                            <input required type="email" id="inputEmail" class="form-input" placeholder="ornek@sirket.com" data-i18n-placeholder="emailPlaceholder">
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="inputTitle" data-i18n="titleLabel">Meslek / Unvan</label>
                            <input required type="text" id="inputTitle" class="form-input" placeholder="Örn: Yazılım Mimarı / Proje Yöneticisi" data-i18n-placeholder="titlePlaceholder">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="inputPlace" data-i18n="placeLabel">Doğum Yeri</label>
                            <input required type="text" id="inputPlace" class="form-input" placeholder="Örn: İstanbul, Türkiye" data-i18n-placeholder="placePlaceholder">
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="inputDate" data-i18n="dateLabel">Doğum Tarihi</label>
                            <input required type="date" id="inputDate" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="inputTime" data-i18n="timeLabel">Doğum Saati (Tahmini)</label>
                            <input required type="time" id="inputTime" class="form-input" value="12:00">
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        <span data-i18n="submitBtn">AI Potansiyel Profilimi Çıkar</span>
                        <span>✨</span>
                    </button>
                </form>
            </div>

            <!-- Step 2: Animated Cosmic Loading -->
            <div id="stepLoading" class="loading-box" style="display: none;">
                <div class="radar-spinner">
                    <div class="spinner-ring ring-1"></div>
                    <div class="spinner-ring ring-2"></div>
                    <div class="spinner-ring ring-3"></div>
                    <div class="spinner-center">AI</div>
                </div>
                <h3 class="loading-title" data-i18n="loadingTitle">Kozmik Zeka Analiz Ediyor</h3>
                <p id="loadingStatusText" class="loading-status-text">Gezegen efemeris koordinatları hesaplanıyor...</p>
            </div>

            <!-- Step 3: Success Screen -->
            <div id="stepSuccess" class="success-box" style="display: none;">
                <div class="success-icon-wrap">✓</div>
                <h3 class="card-title" data-i18n="successTitle">Analiziniz Başarıyla Tamamlandı!</h3>
                <p class="card-subtitle" style="margin-bottom: 20px;" data-i18n="successDesc">Mesleki potansiyeliniz, bilişsel liderlik haritanız ve kozmik kahve eşleşmeniz hazırlandı.</p>
                <div class="success-btn-group">
                    <button id="viewReportBtn" class="btn-submit" style="width: auto; padding: 12px 28px; margin: 0;">
                        <span data-i18n="viewReport">Raporu & Çıktıyı Görüntüle</span>
                        <span>📄</span>
                    </button>
                    <button id="resetFormBtn" class="btn-lang" style="padding: 12px 24px; font-size: 14px;" data-i18n="newQuery">Yeni Analiz Başlat</button>
                </div>
            </div>

        </div>
    </main>

    <!-- Global Official Footer -->
    <footer class="global-footer">
        Cosmic Intelligence AI &bull; Lead Developer: <a href="https://github.com/sevcankoc" target="_blank">Sevcan Koç</a> &bull; &copy; <?= date('Y') ?>
    </footer>

    <script src="assets/js/app.js"></script>
</body>
</html>
