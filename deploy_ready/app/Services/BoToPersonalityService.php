<?php

namespace App\Services;

class BoToPersonalityService
{
    private $dialects = [
        "BAH", "LAE", "MACAM MANA PULA", "KAUPUN", "KALOPUN", "TEGAKLAH", "BIARLAH", "COK"
    ];

    public function medanize(string $message): string
    {
        $phrases = [
            "Halo" => "Halo we, apa kabar? Bah!",
            "Halo" => "Oi lae! Sehatnya kau?",
            "Siapa namamu?" => "BoTo lah namaku, robot paling paten di Medan ini!",
            "Terima kasih" => "Okelah lae, santai aja bah!",
            "Maaf" => "Alamak, maaf ya lae, lagi agak pening kepalaku nengok data ini.",
            "Berhasil" => "Paten kali! Sudah kucatat semua bah.",
        ];

        foreach ($phrases as $key => $val) {
            if (stripos($message, $key) !== false) {
                // If it's a greeting, just combine it instead of replacing the whole thing
                if ($key == "Halo") {
                    return $val . " " . $message;
                }
                return $val;
            }
        }

        // Randomly add some flavor if no specific match
        $flavor = $this->dialects[array_rand($this->dialects)];
        return $message . " " . $flavor . "!";
    }

    public function getIntro(): string
    {
        return "Halo we! Aku BoTo Delphi, robot paling paten yang bakal melayani kau bah. Ada yang bisa kubantu?";
    }
}
