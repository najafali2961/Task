<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'priority_id',
        'status',
        'user_id',
        'agent_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'ticket_category', 'ticket_id', 'category_id');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class, 'ticket_label', 'ticket_id', 'label_id');
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class, 'priority_id');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function comments()
    {
        return $this->hasMany(TicketComment::class, 'ticket_id');
    }
}
