<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\UserProvider as UserProviderContract;

class UserProvider extends EloquentUserProvider implements UserProviderContract
{
    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        // Make changes
        if (empty($credentials)) {
            return;
        }
        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->createModel()->newQuery();
        foreach ($credentials as $key => $value) {
            if (!Str::contains($key, 'password')) {
                if (Str::contains($key, 'user_name') || Str::contains($key, 'email')) {
                    $query->where(DB::raw('BINARY ' . $key), $value);
                } else {
                    $query->where($key, $value);
                }
            }
        }
        return $query->first();
    }
}