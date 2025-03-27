<?php

namespace App\Traits;

trait AuthUserHelper
{
    /**
     * Retrieve the currently authenticated user.
     *
     * @return \App\Models\User|null
     */
    protected function currentUser()
    {
        return auth()->user();
    }

    /**
     * Retrieve the ID of the currently authenticated user.
     *
     * @return int|null
     */
    protected function currentUserId()
    {
        return auth()->id();
    }
}
