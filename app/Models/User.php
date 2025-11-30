<?php

namespace App\Models;

use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $connection = 'mongodb';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'photo',
    ];

    /**
     * Get the user's photo URL or return null
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            $path = 'storage/' . $this->photo;
            if (file_exists(public_path($path))) {
                return asset($path);
            }
            // Try alternative path
            if (file_exists(storage_path('app/public/' . $this->photo))) {
                return asset('storage/' . $this->photo);
            }
        }
        return null;
    }

    /**
     * Get the user's avatar (photo or initials)
     */
    public function getAvatarAttribute()
    {
        return $this->photo_url;
    }

    /**
     * Check if user has a valid photo
     */
    public function hasPhoto()
    {
        if (!$this->photo) {
            return false;
        }

        $path = public_path('storage/' . $this->photo);
        $altPath = storage_path('app/public/' . $this->photo);

        return file_exists($path) || file_exists($altPath);
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Global scope to exclude soft-deleted users (where `delete` is true).
     */
    protected static function booted()
    {
        static::addGlobalScope('not_deleted', function (Builder $builder) {
            $builder->where(function ($q) {
                $q->where('delete', '!=', true)->orWhereNull('delete');
            });
        });
    }
}
