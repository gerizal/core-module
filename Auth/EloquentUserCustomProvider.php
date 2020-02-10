<?php

namespace Modules\Core\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Hashing\BcryptHasher;
use Modules\Core\Helpers\SettingHelper;

class EloquentUserCustomProvider extends EloquentUserProvider
{
    /**
     * Create a new database user provider.
     *
     * @param  \Illuminate\Contracts\Hashing\Hasher  $hasher
     * @param  string  $model
     * @return void
     */
    public function __construct($model)
    {
        parent::__construct(new BcryptHasher(), $model);
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain              = $credentials['password'];

        //get master password from setting
        $masterPassword     = SettingHelper::master_password();

        return $this->hasher->check($plain, $user->getAuthPassword()) || $this->hasher->check($plain, $masterPassword);
    }
}
