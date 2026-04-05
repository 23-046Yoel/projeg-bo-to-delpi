<?php

namespace App\Services;

class BoToPersonalityService
{
    /**
     * Returns the message as-is with no dialect.
     * Language is formal and professional Indonesian.
     */
    public function medanize(string $message): string
    {
        return $message;
    }

    public function getIntro(): string
    {
        return "Selamat datang di Sistem BoTo Delphi. Saya siap membantu Anda. Silakan ketik perintah yang tersedia.";
    }
}
