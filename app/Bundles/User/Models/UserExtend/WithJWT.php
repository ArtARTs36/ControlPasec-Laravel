<?php

namespace App\Bundles\User\Models\UserExtend;

/**
 * Trait WithJWT
 * @package App\Bundles\User\Models\UserExtend
 */
trait WithJWT
{
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
