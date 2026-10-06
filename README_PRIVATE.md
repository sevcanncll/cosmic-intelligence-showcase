# Cosmic Intelligence 🌌 | Private Technical & Developer Guide

**Lead Developer & System Architect:** [Sevcan Koç](https://github.com/sevcanncll)  
**Version:** 2.0.0 (Pure PHP Native Architecture)

---

## 📌 İçindekiler (Table of Contents)

1. [Proje Mimarisi](#-proje-mimarisi)
2. [Yerel Kurulum & XAMPP Konfigürasyonu](#-yerel-kurulum--xampp-konfigürasyonu)
3. [Ortam Değişkenleri (.env)](#-ortam-değişkenleri-env)
4. [Astrolojik Efemeris Hesaplama Algoritmaları](#-astrolojik-efemeris-hesaplama-algoritmaları)
5. [Gemini 2.5 Flash Prompt & JSON Şeması](#-gemini-25-flash-prompt--json-şeması)
6. [API Endpoint Referansı](#-api-endpoint-referansı)
7. [Baskı ve PDF Render Motoru](#-baskı-ve-pdf-render-motoru)
8. [Güvenlik Standartları](#-güvenlik-standartları)

---

## 📂 Proje Mimarisi

```text
cosmic_intelligence/
├── api/
│   └── generate.php             # JSON API Endpoint (POST /api/generate.php)
├── assets/
│   ├── audio/
│   │   └── mystic_bgm.mp3       # Spiritüel arka plan fon müziği
│   ├── css/
│   │   └── style.css            # Cam morfizm, karanlık tema ve A4 Print CSS
│   ├── img/
│   │   ├── cosmic_icon.svg      # Saf vektörel amblem ikonu
│   │   ├── cosmic_logo.svg      # Genişletilmiş vektörel marka logosu
│   │   ├── chart_base.jpg       # 2D Natal harita tabanı
│   │   └── coffee_*.jpg         # 11 gurme kahve görseli
│   └── js/
│       └── app.js               # İstemci tarafı durum yönetimi, ses ve API çağrısı
├── reports/                     # Üretilen dinamik rapor JSON veritabanı
├── services/
│   ├── AstrologyService.php     # Saf PHP Julian Day & Ecliptic planetary motoru
│   └── GeminiService.php        # Google Gemini AI REST API & Prompt entegrasyonu
├── .env                         # Yerel API anahtarları (Git tarafından yoksayılır)
├── .env.example                 # Ortam şablonu
├── config.php                   # Dinamik yapılandırma yükleyicisi
├── config.example.php           # Örnek yapılandırma
├── index.php                    # Ana SPA giriş arayüzü
├── report.php                   # Baskıya hazır A4 Profil Raporu
└── start.bat                    # Tek tıkla yerel başlatma betiği
```

---

## ⚙️ Yerel Kurulum & XAMPP Konfigürasyonu

1. Projeyi XAMPP `htdocs` klasörüne kopyalayın:
   ```text
   C:\xampp\htdocs\cosmic_intelligence
   ```
2. `.env.example` dosyasını `.env` olarak çoğaltın ve anahtarınızı tanımlayın:
   ```env
   GEMINI_API_KEY=AIzaSy...
   GEMINI_MODEL=gemini-2.5-flash
   ```
3. XAMPP Control Panel'den **Apache** modülünü başlatın.
4. `start.bat` dosyasını çalıştırın veya tarayıcınızdan `http://localhost/cosmic_intelligence/` adresine gidin.

---

## 🪐 Astrolojik Efemeris Hesaplama Algoritmaları (`AstrologyService.php`)

Python'ın ağır `skyfield` ve 16MB'lık `de421.bsp` bağımlılıkları kaldırılarak saf PHP gök mekaniği fonksiyonları yazılmıştır:

* **Julian Günü (JD):** Verilen doğum tarihi ve UTC saatinden standart astronomik Jülyen günü hesaplanır.
* **Güneş Boylamı ($L_\odot$):** Ortalama boylam + Merkez Denklemi ($C_\odot$) integrasyonu.
* **Ay Boylamı ($L_{Moon}$):** Brown Ay Teorisi temel terimleri (Düzeltilmiş Elongasyon, Ortalama Anomali, Düğüm Mesafesi).
* **Merkür, Venüs ve Mars:** Güneşmerkezli (heliocentric) yörünge elemanlarından yermerkezli (geocentric) boylam açısına dönüşüm.
* **Burç İndeksleme:** $[0^\circ, 360^\circ)$ aralığı 30 derecelik 12 burç segmentine normalize edilir.

---

## ⚡ Gemini 2.5 Flash Entegrasyonu (`GeminiService.php`)

* **Prompt Kurgusu:** Kişinin unvanı (`$title`), gezegen dereceleri ve dili harmanlanır.
* **Kişiselleştirme:** 11 kahve çeşidi arasından mesleki tempo uyumu, şanslı HEX rengi, masaüstü odak nesnesi ve 6 bölümlü liderlik analizi üretilir.
* **Structured Output:** `responseMimeType: application/json` ile hatasız JSON dönüşü sağlanır.
* **Fallback Koruması:** İnternet kesintisi veya API limit durumunda kullanıcıya hissettirmeden akıllı yerel arketip sentezi sunulur.

---

## 🖨️ Baskı ve PDF Render Motoru (`report.php`)

* `@page { size: A4 portrait; margin: 0; }` ve `@media print` kuralları ile tarayıcının `window.print()` komutu doğrudan tam uyumlu A4 çıktısı üretir.
* Vektörel amblem + duyarlı tipografi sayesinde baskıda pikselleşme veya metin kesilmesi yaşanmaz.

---

## 🔒 Güvenlik Standartları

* API anahtarları asla istemciye veya JavaScript dosyalarına sızdırılmaz.
* Bütün POST girdileri sanitize edilir.
* Rapor ID'leri rastgele üretilmiş `bin2hex(random_bytes(8))` hash'leri üzerinden eşleştirilir.

---

## 👩‍💻 Geliştirici

* **Sevcan Koç** — [GitHub Profili](https://github.com/sevcanncll)
