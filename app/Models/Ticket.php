<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    use HasFactory;

    protected $fillable = [
        'reference_id',
        'user_id',
        'subject',
        'message',
        'attachment_path',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }

    // Generate a unique reference ID
    public static function generateReferenceId()
    {
        return 'TICKET-' . now()->format('ymdHis') . '-' . strtoupper(\Str::random(6));
    }
}
