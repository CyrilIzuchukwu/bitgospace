<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KycVerification extends Model
{
    //

    protected $guarded = [];



    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime'
    ];


    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }



    // Helpers
    public function getFrontImageUrlAttribute()
    {
        return asset('storage/kyc_documents/' . $this->front_image_path);
    }

    public function getBackImageUrlAttribute()
    {
        return $this->back_image_path ? asset('storage/kyc_documents/' . $this->back_image_path) : null;
    }

    public function getSelfieImageUrlAttribute()
    {
        return asset('storage/kyc_selfies/' . $this->selfie_image_path);
    }
}
