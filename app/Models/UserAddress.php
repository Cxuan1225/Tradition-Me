<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'recipient_name', 'phone_number', 'address_line1', 'address_line2', 'postal_code', 'state', 'reference', 'is_default'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function __toString()
    {
        session()->put('userAddress', $this->id);

        return sprintf(
            '%s,<br>%s,<br>%s%s%s,<br> %s,<br>%s,<br>%s',
            $this->recipient_name,
            $this->address_line1,
            $this->address_line2 ? $this->address_line2.'<br>' : '',
            $this->city,
            $this->postal_code,
            $this->state,
            $this->phone_number,
            $this->reference ? "Reference: $this->reference<br>" : '',
        );
    }
}
