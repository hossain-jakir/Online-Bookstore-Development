<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Paddle\Billable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles,Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'dob',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the full name of the user.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function address(){
        return $this->hasMany(Address::class);
    }

    public function defaultAddress(){
        return $this->hasOne(Address::class)->where('is_default', 1);
    }

    public function scopeWhereTimeframe($query, $column, $period)
    {
        if ($period == 'day') {
            return $query->whereDate($column, today());
        }elseif ($period == 'week') {
            return $query->whereBetween($column, [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($period == 'month') {
            return $query->whereMonth($column, now()->month)
                        ->whereYear($column, now()->year);
        } elseif ($period == 'year') {
            return $query->whereYear($column, now()->year);
        }elseif ($period == 'all') {
            return $query;
        }

        return $query;
    }

    public function primary_address(){
        return $this->hasOne(Address::class)->where('is_default', 1)
        ->where('status', 'active')->where('isDeleted', 'no')->orderBy('id', 'desc');
    }

    public function secondary_address(){
        return $this->hasOne(Address::class)->where('type', 'billing')->where('is_default', 0)
        ->where('status', 'active')->where('isDeleted', 'no')->orderBy('id', 'desc');
    }
}
