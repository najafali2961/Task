<?php

namespace App\Traits;

trait AdminCheck
{
    protected function checkAdmin()
    {
        if (!auth()->check() || !auth()->user()->hasRole('Administrator')) {
            abort(403, 'Unauthorized action.');
        }
    }
}
