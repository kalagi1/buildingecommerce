<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleChanges extends Model
{
    use HasFactory;

    protected $table = 'role_changes';

    protected $guarded = [];
    
    public function city()
{
    return $this->belongsTo(City::class, 'taxOfficeCity','id');
}

public function county()
{
    return $this->belongsTo(County::class, 'county_id', 'key_x');
}

public function neighborhood()
{
    return $this->belongsTo(Neighborhood::class, 'neighborhood_id', 'mahalle_id');
}

public function office()
{
    return $this->belongsTo(TaxOffice::class, 'taxOffice','id');
}

}


    
    

