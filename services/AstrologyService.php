<?php
/**
 * Planetary and Natal Chart Calculations in PHP
 * Developer: Sevcan Koç
 */

class AstrologyService {
    
    private static $zodiacSignsTR = [
        "Koç", "Boğa", "İkizler", "Yengeç", 
        "Aslan", "Başak", "Terazi", "Akrep", 
        "Yay", "Oğlak", "Kova", "Balık"
    ];

    private static $zodiacSignsEN = [
        "Aries", "Taurus", "Gemini", "Cancer",
        "Leo", "Virgo", "Libra", "Scorpio",
        "Sagittarius", "Capricorn", "Aquarius", "Pisces"
    ];

    /**
     * Calculate Julian Day Number from UTC date/time
     */
    public static function getJulianDay($year, $month, $day, $hour = 12, $minute = 0) {
        $d = $day + ($hour + $minute / 60.0) / 24.0;
        if ($month <= 2) {
            $year -= 1;
            $month += 12;
        }
        $a = floor($year / 100);
        $b = 2 - $a + floor($a / 4);
        return floor(365.25 * ($year + 4716)) + floor(30.6001 * ($month + 1)) + $d + $b - 1524.5;
    }

    /**
     * Normalize degree to 0 - 360
     */
    public static function normalizeDegrees($deg) {
        $deg = fmod($deg, 360.0);
        if ($deg < 0) $deg += 360.0;
        return $deg;
    }

    /**
     * Returns zodiac sign based on ecliptic longitude
     */
    public static function getZodiacSign($lonDegrees, $lang = 'tr') {
        $index = (int)(self::normalizeDegrees($lonDegrees) / 30) % 12;
        return $lang === 'en' ? self::$zodiacSignsEN[$index] : self::$zodiacSignsTR[$index];
    }

    /**
     * Calculate planetary positions for given birth date and time
     */
    public static function calculateNatalChart($year, $month, $day, $hour = 12, $minute = 0, $lang = 'tr') {
        $jd = self::getJulianDay($year, $month, $day, $hour, $minute);
        $t = ($jd - 2451545.0) / 36525.0; // Julian centuries from J2000.0
        $d = $jd - 2451545.0;              // Days from J2000.0

        // 1. Sun Position (Mean longitude + Equation of Center)
        $l0 = 280.46646 + 36000.76983 * $t + 0.0003032 * $t * $t;
        $m_sun = 357.52911 + 35999.05029 * $t - 0.0001537 * $t * $t;
        $m_sun_rad = deg2rad(self::normalizeDegrees($m_sun));
        $c_sun = (1.914602 - 0.004817 * $t - 0.000014 * $t * $t) * sin($m_sun_rad)
               + (0.019993 - 0.000101 * $t) * sin(2 * $m_sun_rad)
               + 0.000289 * sin(3 * $m_sun_rad);
        $sun_lon = self::normalizeDegrees($l0 + $c_sun);

        // 2. Moon Position (Simplified Brown's Lunar Theory)
        $l_moon = 218.3164477 + 481267.88123421 * $t;
        $m_moon = 134.9633964 + 477198.8675055 * $t;
        $d_moon = 297.8501921 + 445267.1114034 * $t;
        $f_moon = 93.2720950 + 483202.0175233 * $t;

        $moon_lon = $l_moon 
            + 6.288774 * sin(deg2rad($m_moon))
            + 1.274027 * sin(deg2rad(2 * $d_moon - $m_moon))
            + 0.658314 * sin(deg2rad(2 * $d_moon))
            + 0.213618 * sin(deg2rad(2 * $m_moon))
            - 0.185116 * sin(deg2rad($m_sun))
            - 0.114332 * sin(deg2rad(2 * $f_moon));
        $moon_lon = self::normalizeDegrees($moon_lon);

        // 3. Mercury Position (Helio to Geocentric approximation)
        $mercury_mean = 252.25 + 149472.67 * $t;
        $mercury_anomaly = deg2rad(174.79 + 149474.07 * $t);
        $mercury_lon = self::normalizeDegrees($sun_lon + 23.4 * sin($mercury_anomaly) + 5.2 * sin(deg2rad($mercury_mean - $l0)));

        // 4. Venus Position
        $venus_mean = 181.98 + 58517.81 * $t;
        $venus_anomaly = deg2rad(50.41 + 58517.81 * $t);
        $venus_lon = self::normalizeDegrees($sun_lon + 46.2 * sin(deg2rad($venus_mean - $l0)) + 1.5 * sin($venus_anomaly));

        // 5. Mars Position
        $mars_m = deg2rad(19.373 + 19140.299 * $t);
        $mars_lon = self::normalizeDegrees(355.433 + 19141.696 * $t + 10.691 * sin($mars_m));

        $raw_degrees = [
            'Sun' => round($sun_lon, 1),
            'Moon' => round($moon_lon, 1),
            'Mercury' => round($mercury_lon, 1),
            'Venus' => round($venus_lon, 1),
            'Mars' => round($mars_lon, 1)
        ];

        $positions = [];
        foreach ($raw_degrees as $planet => $deg) {
            $sign = self::getZodiacSign($deg, $lang);
            $signDeg = fmod($deg, 30.0);
            $positions[$planet] = sprintf("%.1f° %s", $signDeg, $sign);
        }

        // Calculate visual points for 2D cosmic radar / chart (Center 50,50, Radius 35)
        $chart_points = [];
        foreach ($raw_degrees as $name => $deg) {
            $rad = deg2rad($deg - 90); // 0 at top
            $x = 50 + 35 * cos($rad);
            $y = 50 + 35 * sin($rad);
            $chart_points[] = [
                'name' => $name,
                'degree' => $deg,
                'sign' => self::getZodiacSign($deg, $lang),
                'x' => round($x, 2),
                'y' => round($y, 2)
            ];
        }

        return [
            'positions' => $positions,
            'raw_degrees' => $raw_degrees,
            'chart_points' => $chart_points,
            'sun_sign' => self::getZodiacSign($raw_degrees['Sun'], $lang),
            'moon_sign' => self::getZodiacSign($raw_degrees['Moon'], $lang),
        ];
    }
}
