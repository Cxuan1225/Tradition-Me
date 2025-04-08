<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMeasurement extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'chest', 'waist', 'hips', 'arm_length', 'foot_length'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function preference()
    {
        return $this->hasOne(UserPreference::class);
    }

    public function calculateSize()
    {
        $chest = $this->chest;
        $waist = $this->waist;
        $hips = $this->hips;
        $arm_length = $this->arm_length;
        $foot_length = $this->foot_length;

        if ($chest < 30 || $waist < 25 || $hips < 30 || $arm_length < 30 || $foot_length < 20) {
            throw new Exception('Measurements are below the acceptable range.');
        }

        if ($chest >= 48 && $waist >= 44 && $hips >= 50 && $arm_length >= 65 && $foot_length >= 30) {
            return 'XXL';
        } elseif ($chest >= 44 && $waist >= 40 && $hips >= 46 && $arm_length >= 60 && $foot_length >= 28) {
            return 'XL';
        } elseif ($chest >= 40 && $waist >= 36 && $hips >= 42 && $arm_length >= 55 && $foot_length >= 26) {
            return 'L';
        } elseif ($chest >= 36 && $waist >= 32 && $hips >= 38 && $arm_length >= 50 && $foot_length >= 24) {
            return 'M';
        } elseif ($chest >= 32 && $waist >= 28 && $hips >= 34 && $arm_length >= 45 && $foot_length >= 22) {
            return 'S';
        } else {
            throw new Exception('Please check the measurements again.');
        }
    }

    public function updateUserPreference()
    {
        $preference = $this->preference()->firstOrNew(['user_id' => $this->user_id]);
        $preference->preference_size = $this->calculateSize();
        $preference->save();
    }
}
