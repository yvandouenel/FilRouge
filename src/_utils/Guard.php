<?php

namespace Sthom\FilRouge\_utils;

class Guard
{

    public static function check(string $token, $roles = []): bool
    {
        $jwt = new JwtManager();
        $decoded = $jwt->decode($token);
        if ($decoded === null) {
            return false;
        }
        if (empty($roles)) {
            return true;
        }
        return in_array($decoded->role, $roles);
    }

}