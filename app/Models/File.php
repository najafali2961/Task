<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['file_path', 'mime_type'];

    public function fileable()
    {
        return $this->morphTo();
    }
}
