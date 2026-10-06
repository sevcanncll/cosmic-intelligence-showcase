/**
 * Cosmic Intelligence - Main Frontend Script
 * Developer: Sevcan Koç
 */

document.addEventListener('DOMContentLoaded', () => {
    let currentLang = 'tr';
    let isMusicPlaying = false;
    const bgAudio = document.getElementById('bgAudio');
    const musicToggleBtn = document.getElementById('musicToggleBtn');
    const langToggleBtn = document.getElementById('langToggleBtn');
    const profilerForm = document.getElementById('profilerForm');
    const stepForm = document.getElementById('stepForm');
    const stepLoading = document.getElementById('stepLoading');
    const stepSuccess = document.getElementById('stepSuccess');
    const loadingStatusText = document.getElementById('loadingStatusText');
    const viewReportBtn = document.getElementById('viewReportBtn');
    const resetFormBtn = document.getElementById('resetFormBtn');

    const i18n = {
        tr: {
            title: "Cosmic Intelligence",
            subtitle: "Yapay Zeka Destekli Bireysel & Liderlik Potansiyel Analizi",
            nameLabel: "Ad Soyad",
            namePlaceholder: "Örn: Ali Yılmaz",
            emailLabel: "E-Posta Adresi",
            emailPlaceholder: "ornek@sirket.com",
            titleLabel: "Meslek / Unvan",
            titlePlaceholder: "Örn: Yazılım Mimarı / Proje Yöneticisi",
            placeLabel: "Doğum Yeri",
            placePlaceholder: "Örn: İstanbul, Türkiye",
            dateLabel: "Doğum Tarihi",
            timeLabel: "Doğum Saati (Tahmini)",
            submitBtn: "AI Potansiyel Profilimi Çıkar",
            loadingTitle: "Kozmik Zeka Analiz Ediyor",
            successTitle: "Analiziniz Başarıyla Tamamlandı!",
            successDesc: "Mesleki potansiyeliniz, bilişsel liderlik haritanız ve kozmik kahve eşleşmeniz hazırlandı.",
            viewReport: "Raporu & Çıktıyı Görüntüle",
            newQuery: "Yeni Analiz Başlat",
            loadingSteps: [
                "Gezegen efemeris koordinatları hesaplanıyor...",
                "Mesleki dinamikler & bilişsel mimari analiz ediliyor...",
                "Yapay zeka liderlik & çalışma arketipleri sentezleniyor...",
                "Kişiselleştirilmiş kahve, aura ve totem belirleniyor...",
                "Baskıya hazır resmi A4 profil raporu oluşturuluyor..."
            ],
            errGeneric: "Analiz oluşturulurken bir hata oluştu. Lütfen tekrar deneyin.",
            errConnect: "Sunucuya bağlanılamadı. XAMPP Apache servisinin çalıştığından emin olun."
        },
        en: {
            title: "Cosmic Intelligence",
            subtitle: "AI-Powered Professional Potential & Leadership Profiler",
            nameLabel: "Full Name",
            namePlaceholder: "e.g. John Doe",
            emailLabel: "Email Address",
            emailPlaceholder: "john@company.com",
            titleLabel: "Profession / Job Title",
            titlePlaceholder: "e.g. Software Architect / Director",
            placeLabel: "Birth Place",
            placePlaceholder: "e.g. London, UK",
            dateLabel: "Date of Birth",
            timeLabel: "Time of Birth (Est.)",
            submitBtn: "Generate AI Potential Profile",
            loadingTitle: "Cosmic Intelligence Active",
            successTitle: "Your Profile is Ready!",
            successDesc: "Your career potential, cognitive leadership map, and cosmic coffee match have been generated.",
            viewReport: "View & Print Report",
            newQuery: "Start New Analysis",
            loadingSteps: [
                "Calculating planetary ephemeris coordinates...",
                "Analyzing career dynamics & cognitive architecture...",
                "Synthesizing AI leadership & workplace archetypes...",
                "Determining tailored coffee, aura hex, and desk totem...",
                "Generating print-ready official A4 executive report..."
            ],
            errGeneric: "An error occurred while generating the profile. Please try again.",
            errConnect: "Could not reach server. Please check your Apache/PHP server."
        }
    };

    function updateLanguage(lang) {
        currentLang = lang;
        langToggleBtn.textContent = lang === 'tr' ? 'EN' : 'TR';
        
        const dict = i18n[lang];
        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (dict[key]) {
                el.textContent = dict[key];
            }
        });

        document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
            const key = el.getAttribute('data-i18n-placeholder');
            if (dict[key]) {
                el.placeholder = dict[key];
            }
        });
    }

    // Language Toggle
    if (langToggleBtn) {
        langToggleBtn.addEventListener('click', () => {
            const nextLang = currentLang === 'tr' ? 'en' : 'tr';
            updateLanguage(nextLang);
        });
    }

    // Music Player Toggle
    if (musicToggleBtn && bgAudio) {
        musicToggleBtn.addEventListener('click', () => {
            if (isMusicPlaying) {
                bgAudio.pause();
                musicToggleBtn.innerHTML = '🔇';
                isMusicPlaying = false;
            } else {
                bgAudio.play().then(() => {
                    musicToggleBtn.innerHTML = '🔊';
                    isMusicPlaying = true;
                }).catch(err => {
                    console.log('Audio autoplay prevented by browser:', err);
                });
            }
        });
    }

    // Form Submission
    let generatedReportUrl = '';

    if (profilerForm) {
        profilerForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Switch to loading
            stepForm.style.display = 'none';
            stepLoading.style.display = 'flex';
            stepSuccess.style.display = 'none';

            const formData = {
                name: document.getElementById('inputName').value.trim(),
                email: document.getElementById('inputEmail').value.trim(),
                title: document.getElementById('inputTitle').value.trim() || (currentLang === 'en' ? 'Professional' : 'Profesyonel'),
                birthPlace: document.getElementById('inputPlace').value.trim() || (currentLang === 'en' ? 'London' : 'İstanbul'),
                birthDate: document.getElementById('inputDate').value,
                birthTime: document.getElementById('inputTime').value || '12:00',
                language: currentLang
            };

            const steps = i18n[currentLang].loadingSteps;
            let stepIdx = 0;
            loadingStatusText.textContent = steps[0];

            const interval = setInterval(() => {
                stepIdx = (stepIdx + 1) % steps.length;
                loadingStatusText.textContent = steps[stepIdx];
            }, 2500);

            try {
                const response = await fetch('api/generate.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();
                clearInterval(interval);

                if (result.status === 'success') {
                    generatedReportUrl = result.report_url;
                    stepLoading.style.display = 'none';
                    stepSuccess.style.display = 'block';

                    // Automatically open report in a new tab for seamless experience
                    window.open(generatedReportUrl, '_blank');
                } else {
                    alert(result.message || i18n[currentLang].errGeneric);
                    stepLoading.style.display = 'none';
                    stepForm.style.display = 'block';
                }
            } catch (err) {
                clearInterval(interval);
                console.error(err);
                alert(i18n[currentLang].errConnect);
                stepLoading.style.display = 'none';
                stepForm.style.display = 'block';
            }
        });
    }

    if (viewReportBtn) {
        viewReportBtn.addEventListener('click', () => {
            if (generatedReportUrl) {
                window.open(generatedReportUrl, '_blank');
            }
        });
    }

    if (resetFormBtn) {
        resetFormBtn.addEventListener('click', () => {
            profilerForm.reset();
            stepSuccess.style.display = 'none';
            stepLoading.style.display = 'none';
            stepForm.style.display = 'block';
        });
    }
});
