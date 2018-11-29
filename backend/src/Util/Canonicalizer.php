<?php

namespace App\Util;

/**
 * Class Canonicalizer.
 */
class Canonicalizer
{
    /**
     * @param string $email
     *
     * @return string
     */
    public function canonicalizeEmail(string $email): string
    {
        $encoding = mb_detect_encoding($email);

        return $encoding
            ? mb_convert_case($email, MB_CASE_LOWER, $encoding)
            : mb_convert_case($email, MB_CASE_LOWER);
    }
}
