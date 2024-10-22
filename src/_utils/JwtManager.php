<?php

namespace Sthom\FilRouge\_utils;

class JwtManager
{

    /**
     * @method generate
     *
     *  Cette méthode permet de générer un token JWT
     *  En fonction de la clé de signature et des données à encoder
     * @return string
     */
    public final static function generate(string $signing_key, array $payload): string
    {
        $header = [
            "alg" => "HS512",
            "typ" => "JWT"
        ];
        $header = self::base64_url_encode(json_encode($header));
        $payload["exp"] = time() + 3600;
        $payload = self::base64_url_encode(json_encode($payload));
        $signature = self::base64_url_encode(hash_hmac('sha512', "$header.$payload", $signing_key, true));
        return "$header.$payload.$signature";
    }

    /**
     * @method base64_url_encode
     *
     * Cette méthode permet d'encoder en base64 une chaine de caractères
     * en utilisant l'URL et le format de l'encodage
     *
     * @param string $text
     * @return string
     */
    private static function base64_url_encode(string $text): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($text));
    }
}