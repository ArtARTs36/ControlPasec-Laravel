<?php

namespace App\Bundles\User\Services\Auth;

use App\Bundles\User\Contracts\Tokenizer;

final class Jwt implements Tokenizer
{
    /**
     * Returns time to live of the jwt token.
     */
    public function getTokenTTL(string $token): int
    {
        $payload = $this->decodeToken($token);

        return isset($payload['exp']) ? $payload['exp'] : 0;
    }

    /**
     * Returns an array with payload of the jwt token.
     */
    private function decodeToken(string $token): array
    {
        $payloadArray = [];
        $parts = $this->sliceToken($token);

        if (isset($parts[1])) {
            $json = base64_decode($parts[1]);
            $payloadArray = json_decode($json, true);
        }

        return $payloadArray;
    }

    /**
     * Divides the token into parts.
     */
    private function sliceToken(string $token): array
    {
        $parts = explode('.', $token);

        return count($parts) ? $parts : [];
    }
}
