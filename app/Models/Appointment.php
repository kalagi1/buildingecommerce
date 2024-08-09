<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $table = 'appointments';
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(AssignedUser::class, 'customer_id');
    }

     // Randevu modelinde danışman ilişkisi
     public function consultant()
     {
         return $this->belongsTo(User::class, 'danisman_id');
     }
}
