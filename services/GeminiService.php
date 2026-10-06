<?php
/**
 * Gemini AI Integration Service in PHP
 * Developer: Sevcan Koç
 */

class GeminiService {
    
    public static $coffeeTypes = [
        "Espresso" => [
            "img" => "coffee_espresso.jpg",
            "tr" => "Uykuyu ve ertelemeyi rafa kaldıran, hedefe kilitli, net ve tavizsiz zihinlerin tercihi. %100 Saf Güç.",
            "en" => "For decisive minds locked on targets, bold and uncompromising. 100% Pure Power."
        ],
        "Americano" => [
            "img" => "coffee_americano.jpg",
            "tr" => "Yoğun çalışma temposunda hız kesmeden uzun soluklu konsantrasyon sağlayan stratejik seçim. %30 Espresso, %70 Su.",
            "en" => "Strategic choice for steady concentration and fast-paced workflows. 30% Espresso, 70% Water."
        ],
        "Latte" => [
            "img" => "coffee_latte.jpg",
            "tr" => "Ekip içinde diplomasiyi ve pozitif enerjiyi besleyen, dengeli ve uyumlu zihin haritası. %20 Espresso, %70 Süt, %10 Köpük.",
            "en" => "Nurtures teamwork and diplomatic harmony with balanced positivity. 20% Espresso, 70% Milk, 10% Foam."
        ],
        "Cappuccino" => [
            "img" => "coffee_cappuccino.jpg",
            "tr" => "Vizyonunu estetikle birleştiren, hem detaya hem büyük resme odaklanan karizmatik duruş. %33 Espresso, %33 Süt, %33 Köpük.",
            "en" => "Combines vision with elegance, balancing detail with the big picture. 33% Espresso, 33% Milk, 33% Foam."
        ],
        "Mocha" => [
            "img" => "coffee_mocha.jpg",
            "tr" => "Yaratıcı kriz anlarında ilhamı ve enerjiyi tetikleyen, yenilikçi ve çok yönlü yaklaşım. %20 Espresso, %20 Çikolata, %50 Süt.",
            "en" => "Sparks creative breakthroughs and multifaceted energy during critical tasks. 20% Espresso, 20% Chocolate, 50% Milk."
        ],
        "Flat White" => [
            "img" => "coffee_flat_white.jpg",
            "tr" => "Detaylarda kusursuzluk arayan, analitik zekası keskin ve rafine profesyonellerin içeceği. %40 Double Espresso, %60 Mikro Köpük.",
            "en" => "For refined perfectionists with sharp analytical acuity. 40% Double Espresso, 60% Microfoam."
        ],
        "Cortado" => [
            "img" => "coffee_cortado.jpg",
            "tr" => "Gereksiz detayları eleyen, sonuç odaklı ve doğrudan iletişimi benimseyen lider tercihi. %50 Espresso, %50 Sıcak Süt.",
            "en" => "Direct, result-driven, and straight-to-the-point leadership preference. 50% Espresso, 50% Steamed Milk."
        ],
        "Macchiato" => [
            "img" => "coffee_macchiato.jpg",
            "tr" => "Az zamanda yüksek etki yaratan, pratik zekası ve odaklanma yeteneği yüksek dinamik profil. %80 Espresso, %20 Köpük.",
            "en" => "High impact in minimal time, sharp agility and intense focus. 80% Espresso, 20% Foam."
        ],
        "Turk Kahvesi" => [
            "img" => "coffee_turkish.jpg",
            "tr" => "Derin stratejik sohbetlerin, tecrübenin ve zaman testinden geçmiş vizyonun sembolü. %100 Geleneksel Çekim & Zengin Köpük.",
            "en" => "A symbol of strategic depth, wisdom, and time-tested vision. 100% Traditional Brew & Rich Foam."
        ],
        "Filtre Kahve" => [
            "img" => "coffee_filter.jpg",
            "tr" => "Sürekli üretim ve derin çalışma modunda (deep work) kesintisiz verimlilik sağlayan odak yakıtı. %100 Taze Demleme.",
            "en" => "Fuel for uninterrupted deep work and persistent productivity. 100% Fresh Brew."
        ],
        "Cold Brew" => [
            "img" => "coffee_cold_brew.jpg",
            "tr" => "Baskı altında daima soğukkanlı, uzun vadeli planları sabırla ilmek ilmek işleyen sakin güç. %100 Yavaş Soğuk Demleme.",
            "en" => "Calm strength under pressure, patiently executing long-term master plans. 100% Cold Brewed."
        ]
    ];

    /**
     * Call Gemini API with tailored prompt
     */
    public static function generateProfile($userData, $planets, $config) {
        $apiKey = $config['gemini_api_key'];
        $model = $config['gemini_model'] ?? 'gemini-2.5-flash';
        $lang = $userData['language'] ?? 'tr';

        $name = htmlspecialchars($userData['name'] ?? 'Değerli Katılımcı');
        $title = htmlspecialchars($userData['title'] ?? 'Uzman / Lider');
        $birthDate = $userData['birthDate'] ?? '';
        $birthPlace = htmlspecialchars($userData['birthPlace'] ?? '');

        $sun = $planets['positions']['Sun'] ?? '';
        $moon = $planets['positions']['Moon'] ?? '';
        $mercury = $planets['positions']['Mercury'] ?? '';
        $venus = $planets['positions']['Venus'] ?? '';
        $mars = $planets['positions']['Mars'] ?? '';

        if ($lang === 'en') {
            $systemInstruction = "You are 'Cosmic Intelligence AI', an advanced cognitive leadership and professional potential profiler developed under the architecture of Sevcan Koç. You blend cosmic archetypes, cognitive psychology, and modern career leadership into executive-level, visionary analyses.";
            $prompt = <<<EOT
Generate an executive personal potential & leadership profile for the following individual.
IMPORTANT: You MUST analyze the person deeply according to their SPECIFIC PROFESSION/TITLE ("{$title}") alongside their planetary positions.

Candidate Details:
Name: {$name}
Profession / Job Title: {$title}
Birth Details: {$birthDate}, {$birthPlace}

Astrological Coordinates:
- Sun (Core Identity & Purpose): {$sun}
- Moon (Emotional Drive & Intuition): {$moon}
- Mercury (Cognitive & Decision Architecture): {$mercury}
- Venus (Value System & Collaboration): {$venus}
- Mars (Execution & Problem-Solving Energy): {$mars}

Requirements:
1. Tone: Visionary, corporate, intelligent, empowering, and respectful. Avoid cheap horoscope/fortune-telling clichés.
2. Directly address how their planetary dynamics intersect with their specific career field ("{$title}").
3. Choose the most fitting coffee among: Espresso, Americano, Latte, Cappuccino, Mocha, Flat White, Cortado, Macchiato, Turk Kahvesi, Filtre Kahve, Cold Brew based on their profession's daily rhythm and cosmic temperament.
4. Recommend a lucky hex color (e.g. #00F5D4) with a stylish color name matching their professional aura.
5. Select an inspiring desk totem/office object specifically fitting their career (e.g. 'Ergonomic Vertical Mouse', 'Hourglass of Deep Focus', 'Bonsai of Patience', 'Mechanical Precision Keyboard', 'Titanium Prism Pen', etc.).
6. Calculate an Innovation & Focus energy score (integer between 72 and 98).
7. Create a single punchy, futuristic aphorism combining technology, career wisdom, and personal potential.

Respond ONLY with a valid JSON object in the exact schema below (no markdown wrappers like ```json):
{
  "sections": [
    {"title": "Core Energy & Professional Character", "content": "2 clear, insightful sentences tailored to their role."},
    {"title": "Cognitive & Decision Architecture", "content": "2 clear sentences on how they think and solve complex problems."},
    {"title": "Leadership & Career Vision", "content": "2 clear sentences regarding their career trajectory and impact."},
    {"title": "Professional Affinities & Passions", "content": "2 clear sentences on what drives and inspires them in work/life."},
    {"title": "Working Style & Frictions", "content": "2 clear sentences on what environment they thrive in vs what drains them."},
    {"title": "Ultimate Mission & Purpose", "content": "2 clear sentences on their overarching life and career mission."}
  ],
  "coffee": "Exact name from the 11 coffee list",
  "coffee_reason": "One sentence explaining why this coffee fits a {$title} with this cosmic alignment.",
  "lucky_hex": "#00F5D4",
  "lucky_color_name": "Cyber Emerald",
  "lucky_totem": "Titanium Prism Pen",
  "energy_score": 89,
  "advice": "Futuristic quote combining career and cosmic intellect."
}
EOT;
        } else {
            $systemInstruction = "Sen Sevcan Koç mimarisinde geliştirilmiş 'Cosmic Intelligence AI' adında ileri düzey bir bireysel potansiyel, bilişsel liderlik ve kariyer analiz yapay zekasısın. Görevin astrolojik arketipleri modern profesyonel iş dünyası, mesleki dinamikler ve vizyoner bir bakış açısıyla harmanlayarak üst düzey analizler sunmaktır.";
            $prompt = <<<EOT
Aşağıdaki kişi için profesyonel, vizyoner ve günlük iş/yaşam dinamiklerine dokunan bir potansiyel & karakter analizi hazırla.
ÖNEMLİ: Kişinin MESLEK/UNVAN bilgisini ("{$title}") ve astrolojik konumlarını doğrudan dikkate alarak mesleğine özel, resmi ve ilham verici bir değerlendirme yap.

Kişi Bilgileri:
Ad Soyad: {$name}
Meslek / Unvan: {$title}
Doğum Bilgileri: {$birthDate}, {$birthPlace}

Gezegen Koordinatları:
- Güneş (Öz Kimlik ve Liderlik Çekirdeği): {$sun}
- Ay (Sezgi ve İçsel Motivasyon): {$moon}
- Merkür (Bilişsel Mimari ve Karar Mekanizması): {$mercury}
- Venüs (Değer Yargıları ve İletişim Uyumu): {$venus}
- Mars (İcraat Gücü ve Kriz Yönetimi): {$mars}

Kurallar ve Beklentiler:
1. Üslup: Vizyoner, kurumsal, zeki, güçlendirici ve saygın. Klasik fal veya klişe burç dili KESİNLİKLE KULLANMA.
2. Analiz metinlerinde kişinin mesleğine ("{$title}") ve çalışma disiplinine özel somut dokunuşlar yap.
3. Kişinin mesleki temposuna ve enerjisine en uygun kahveyi şu listeden seç: Espresso, Americano, Latte, Cappuccino, Mocha, Flat White, Cortado, Macchiato, Turk Kahvesi, Filtre Kahve, Cold Brew.
4. Kişinin profesyonel aurasına uygun şanslı bir HEX renk kodu (#00FFAA gibi) ve şık bir Türkçe renk adı belirle.
5. Kişinin mesleğine ve masa başına yakışacak ilham verici bir 'Masa Totemi / Çalışma Nesnesi' belirle (Örn: 'Titanyum Prizma Kalem', 'Mekanik Hassasiyet Klavyesi', 'Bonsai Ağacı', 'Ergonomik Dikey Mouse', 'Manyetik Kum Saati', 'Gürültü Engelleyici Odak Kulaklığı' vb.).
6. İnovasyon & Odak Enerjisi puanı belirle (72 ile 98 arasında tam sayı).
7. Teknoloji, profesyonel yaşam ve kozmik bilgeliği birleştiren tek cümlelik fütüristik bir ilham aforizması yaz.

SADECE geçerli bir JSON formatında yanıt ver (kesinlikle ```json vb. markdown kullanma):
{
  "sections": [
    {"title": "Temel Enerji ve Profesyonel Karakter", "content": "Kişinin karakterini ve mesleki duruşunu anlatan 2 net, güçlü cümle."},
    {"title": "Bilişsel Mimari ve Düşünce Yapısı", "content": "Zihinsel çalışma tarzını ve karar alma mekanizmasını anlatan 2 cümle."},
    {"title": "Kariyer Dinamikleri ve Liderlik Vizyonu", "content": "Mesleğindeki yükseliş ve vizyon potansiyelini özetleyen 2 cümle."},
    {"title": "Mesleki İlgi Alanları ve Tutkular", "content": "Onu işinde ve hayatında en çok heyecanlandıran unsurları anlatan 2 cümle."},
    {"title": "Çalışma Tarzı ve Kaçındıkları", "content": "En verimli olduğu ortamı ve verimini düşüren faktörleri özetleyen 2 cümle."},
    {"title": "Gelecek Misyonu ve Hayat Amacı", "content": "Ulaşmak istediği nihai etki ve profesyonel mirası anlatan 2 cümle."}
  ],
  "coffee": "11 kahve listesinden birebir seçilen isim",
  "coffee_reason": "Bu kahvenin bir {$title} için neden en ideal seçim olduğunu belirten 1 cümle.",
  "lucky_hex": "#00E5FF",
  "lucky_color_name": "Siber Turkuaz",
  "lucky_totem": "Manyetik Kum Saati",
  "energy_score": 88,
  "advice": "İş ve zihin dünyasını aydınlatan fütüristik bir bilgelik aforizması."
}
EOT;
        }

        // Endpoint: Gemini REST API v1beta
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . urlencode($apiKey);

        $payload = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'systemInstruction' => [
                'parts' => [
                    ['text' => $systemInstruction]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 4096,
                'responseMimeType' => 'application/json'
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For local XAMPP SSL bundles

        $rawResponse = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError || $httpCode !== 200) {
            // Fallback gracefully if API fails or rate limited
            return self::getFallbackProfile($userData, $planets, $lang, "API Error: $curlError ($httpCode)");
        }

        $resJson = json_decode($rawResponse, true);
        $text = $resJson['candidates'][0]['content']['parts'][0]['text'] ?? '';

        return self::parseGeminiResponse($text, $lang, $userData);
    }

    /**
     * Clean and parse Gemini response
     */
    private static function parseGeminiResponse($text, $lang, $userData) {
        $clean = trim($text);
        if (str_starts_with($clean, '```json')) $clean = substr($clean, 7);
        if (str_starts_with($clean, '```')) $clean = substr($clean, 3);
        if (str_ends_with($clean, '```')) $clean = substr($clean, 0, -3);
        $clean = trim($clean);

        $data = json_decode($clean, true);

        if (!$data || !isset($data['sections'])) {
            return self::getFallbackProfile($userData, null, $lang, "JSON decode failed: $clean");
        }

        // Validate coffee
        $validCoffees = array_keys(self::$coffeeTypes);
        if (!in_array($data['coffee'] ?? '', $validCoffees)) {
            $data['coffee'] = 'Flat White';
        }

        return $data;
    }

    /**
     * Fallback generator if AI API has connectivity issues
     */
    private static function getFallbackProfile($userData, $planets, $lang, $errorMsg = '') {
        $title = $userData['title'] ?? ($lang === 'en' ? 'Professional' : 'Profesyonel');
        
        if ($lang === 'en') {
            return [
                "sections" => [
                    ["title" => "Core Energy & Professional Character", "content" => "Possesses an acute strategic vision coupled with analytical determination in their role as a {$title}."],
                    ["title" => "Cognitive & Decision Architecture", "content" => "Processes complex challenges methodically, prioritizing clarity and sustainable execution."],
                    ["title" => "Leadership & Career Vision", "content" => "Driven by forward-thinking initiatives that turn unconventional concepts into tangible value."],
                    ["title" => "Professional Affinities & Passions", "content" => "Thrives at the convergence of innovation, structure, and high-impact problem solving."],
                    ["title" => "Working Style & Frictions", "content" => "Flourishes in agile and goal-oriented teams; disdains stagnant bureaucracy and ambiguous workflows."],
                    ["title" => "Ultimate Mission & Purpose", "content" => "To leave an enduring benchmark of excellence and transformative leadership in their domain."]
                ],
                "coffee" => "Flat White",
                "coffee_reason" => "Balances intense precision with refined harmony for peak cognitive stamina.",
                "lucky_hex" => "#00E5FF",
                "lucky_color_name" => "Neon Cyan",
                "lucky_totem" => "Precision Mechanical Keyboard",
                "energy_score" => 92,
                "advice" => "True mastery is engineering order where chaos once stood."
            ];
        }

        return [
            "sections" => [
                ["title" => "Temel Enerji ve Profesyonel Karakter", "content" => "{$title} olarak analitik zekası ve kararlı duruşuyla bulunduğu ekibe güven ve stratejik vizyon katar."],
                ["title" => "Bilişsel Mimari ve Düşünce Yapısı", "content" => "Karmaşık süreçleri parçalara ayırarak yalın, hızlı ve sürdürülebilir çözümler üretme konusunda ustadır."],
                ["title" => "Kariyer Dinamikleri ve Liderlik Vizyonu", "content" => "Geleneksel kalıpların ötesine geçerek geleceğin standartlarını bugünden inşa etmeyi hedefler."],
                ["title" => "Mesleki İlgi Alanları ve Tutkular", "content" => "İnovasyon, teknolojik yetkinlik ve değer üreten projelerde yer almaktan derin motivasyon duyar."],
                ["title" => "Çalışma Tarzı ve Kaçındıkları", "content" => "Özerk, şeffaf ve çevik ortamlarda parlar; belirsizlik ve yavaşlatıcı bürokrasiden uzak durur."],
                ["title" => "Gelecek Misyonu ve Hayat Amacı", "content" => "Kendi alanında kalıcı, ilham veren ve dönüştürücü bir başarı mirası bırakmak."]
            ],
            "coffee" => "Flat White",
            "coffee_reason" => "Keskin zihinsel odaklanma ve rafine dengeyi bir araya getirerek gün boyu yüksek verim sağlar.",
            "lucky_hex" => "#00E5FF",
            "lucky_color_name" => "Siber Turkuaz",
            "lucky_totem" => "Mekanik Hassasiyet Klavyesi",
            "energy_score" => 94,
            "advice" => "Gelecek, onu bugünden inşa etme cesareti gösteren zihinlerin ellerinde şekillenir."
        ];
    }
}
