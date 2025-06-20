<?php

namespace App\Models;


// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    //     'last_login_at',
    // ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'password_reset_token_expires_at' => 'datetime',
            'last_login_at' => 'datetime',
        ];
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function investments(): HasMany
    {
        return $this->hasMany(\App\Models\Investment::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


    public function profile()
    {
        return $this->hasOne(Profile::class);
    }


    // In User model
    public function kycVerifications()
    {
        return $this->hasMany(KycVerification::class);
    }


    protected $dates = [
        'last_login_at',
    ];

    protected $appends = ['status'];

    public function getStatusAttribute()
    {
        return $this->active ? 'Active' : 'Banned';
    }

    // public function depositTransactions()
    // {
    //     return $this->hasMany(DepositTransaction::class);
    // }



    // Accessor for easy balance retrieval
    public function getBalanceAttribute()
    {
        return $this->wallet ? $this->wallet->balance : 0;
    }


    public function depositTransactions()
    {
        return $this->hasManyThrough(
            DepositTransaction::class,
            Deposit::class
        );
    }
}
