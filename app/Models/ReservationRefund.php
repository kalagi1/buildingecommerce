<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationRefund extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'content',
        'terms',
        'user_id',
        'reservation_id',
        'status',
        'return_iban',
        'return_bank',
        
    ];
    // User modeli ile ilişkiyi tanımlayın
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // CartOrder modeli ile ilişkiyi tanımlayın
    public function reservation()
    {
        return $this->belongsTo(reservation::class);
    }
}
