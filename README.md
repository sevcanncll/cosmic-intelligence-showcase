# Cosmic Intelligence 🌌  
### AI Potential & Leadership Profiler

**Lead Developer & System Architect:** [Sevcan Koç](https://github.com/sevcankoc)  
**Version:** 2.0.0 (Pure PHP Native Edition)

---

## 🌟 Proje Hakkında (About the Project)

**Cosmic Intelligence**, katılımcıların doğum haritası astrolojik efemeris koordinatları ile **mesleki unvanlarını ve çalışma dinamiklerini** yapay zeka ile sentezleyen; bilişsel liderlik, kariyer potansiyeli ve çalışma karakteri analizi sunan yeni nesil bir profilleme platformudur.

Geleneksel astroloji/fal klişelerinden tamamen uzak, modern iş dünyasına, karar mekanizmalarına ve yönetici vizyonuna odaklanan resmi ve saygın bir dille tasarlanmıştır.

---

## 🎯 Kurumsal Etkinlik & Sektörel Uyarlanabilirlik (Customizable for Events & B2B)

Bu platform; **şirketlere, zirvelere, lansmanlara ve mesleki organizasyonlara** kolayca entegre edilebilir esnek ve modüler bir mimariye sahiptir:

* 🏢 **Kurumsal Şirketler & İK Etkinlikleri:** Şirket içi yetenek yönetimi, yönetici kampları, motivasyon günleri ve ekip dinamiği analizlerinde kullanılabilir.
* 🎪 **Fuar, Zirve & Lansman Stantları:** Teknoloji forumları, kongreler ve marka aktivasyonlarında ziyaretçilere özel anlık etkileşim ve deneyim sunar.
* 🖨️ **Baskıya Hazır Anında Çıktı (Print-Ready A4 & PDF):** Analiz tamamlandığı anda stanttaki veya ofisteki yazıcıdan **tam A4 boyutunda resmi profil sertifikası / raporu** olarak yazdırılabilir ya da tek tıkla dijital PDF formatında kaydedilebilir.
* 👔 **Meslek Gruplarına Özel Dinamik Analiz:** Yazılımcılardan üst düzey yöneticilere, tasarımcılardan satış liderlerine kadar her meslek dalının çalışma ritmine, kahve ihtiyacına ve odak totemine özel çıktılar üretir.
* 🎨 **White-Label & Markalama Kolaylığı:** Farklı bir etkinlik veya marka için sadece `config.php` üzerindeki başlıklar ve `assets/img/` altındaki logonun değiştirilmesi yeterlidir.

---

## 🚀 Temel Özellikler (Key Highlights)

- **Saf PHP Astroloji & Efemeris Motoru:** Harici ağır Python kütüphanelerine gerek kalmadan Güneş, Ay, Merkür, Venüs ve Mars gezegen konumlarını ve burç derecelerini doğrudan PHP ile milimetrik hesaplar.
- **Google Gemini 2.5 Flash Yapay Zeka Entegrasyonu:** Kişinin mesleğini ve astrolojik arketiplerini saniyeler içinde kurumsal zeka raporuna dönüştürür.
- **Mesleki Kahve & Aura & Totem Eşleşmesi:** Kişinin meslek temposuna uygun 11 gurme kahve arasından seçim, şanslı HEX aura rengi ve masaüstü odak totemi belirlenir.
- **Modern & Prestijli Arayüz:** Cam morfizm (glassmorphism), fütüristik renk paleti, interaktif kozmik ses oynatıcı ve çift dil (TR / EN) desteği.
- **Hafif, Güvenli ve Taşınabilir:** XAMPP (`htdocs`) ortamında sıfır kurulum zahmetiyle anında çalışır.

---

## 📂 Dizin Yapısı (Project Structure)

```text
cosmic_intelligence/
├── api/
│   └── generate.php             # JSON API Endpoint (Profil Üretimi)
├── assets/
│   ├── audio/
│   │   └── mystic_bgm.mp3       # Arka plan fon müziği
│   ├── css/
│   │   └── style.css            # Modern karanlık mod & cam efekti stilleri
│   ├── img/
│   │   ├── cosmic_logo.svg      # Vektörel resmi marka logosu
│   │   ├── chart_base.jpg       # Natal harita arka planı
│   │   └── coffee_*.jpg         # Gurme kahve eşleşme görselleri
│   └── js/
│       └── app.js               # Frontend etkileşim & API bağlantısı
├── reports/                     # Üretilen rapor JSON arşivi (.gitkeep)
├── services/
│   ├── AstrologyService.php     # Saf PHP Gezegen & Natal Chart Motoru
│   └── GeminiService.php        # Google Gemini AI Entegrasyonu & Prompt Motoru
├── .env.example                 # Ortam değişkenleri şablonu (Gizli anahtarlar)
├── config.php                   # Sistem yapılandırması & API yükleyici
├── config.example.php           # GitHub vitrin yapılandırma şablonu
├── index.php                    # Ana kullanıcı arayüzü (SPA)
├── report.php                   # Yazdırılabilir A4 Rapor & PDF Şablonu
├── start.bat                    # Tek tıkla yerel başlatma betiği
└── README.md                    # Dokümantasyon
```

---

## 🛠️ Kurulum & Çalıştırma (Setup & Execution)

### 1. Gereksinimler
- **XAMPP** (Apache + PHP 8.0+)
- **Google Gemini API Key** ([Google AI Studio](https://aistudio.google.com/) üzerinden ücretsiz temin edilebilir)

### 2. Adımlar
1. Projeyi XAMPP `htdocs` dizini içine yerleştirin:
   ```text
   C:\xampp\htdocs\cosmic_intelligence
   ```
2. `.env.example` dosyasını `.env` olarak kopyalayın ve API anahtarınızı tanımlayın:
   ```env
   GEMINI_API_KEY=your_actual_gemini_api_key
   GEMINI_MODEL=gemini-2.5-flash
   ```
3. XAMPP Control Panel üzerinden **Apache** servisini başlatın.
4. Tarayıcınızdan uygulamayı açın:
   👉 **`http://localhost/cosmic_intelligence/`**

---

## 🔒 Güvenlik & GitHub Vitrin Standartları

- Gerçek API anahtarları `.env` dosyasında tutulur ve `.gitignore` ile korunur.
- Depoda hiçbir şekilde sert kodlanmış (hardcoded) gizli anahtar barındırılmaz.
- `config.example.php` ve `.env.example` dosyaları açık kaynak paylaşımına ve public vitrin reponuza tam uyumludur.

---

## 👩‍💻 Geliştirici (Author)

* **Sevcan Koç** — [GitHub Profili](https://github.com/sevcankoc)
* **Lisans:** MIT License
