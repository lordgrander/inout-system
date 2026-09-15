<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewEnterDetail extends Model
{
    protected $table = 'new_enter_details';
    public $timestamps = false;

    protected $fillable = [
        'new_enter_id',
        'user_id',
        'plate_number',
        'driver_name',
        'vehicle_type_id',
        'rounds',
        'import_product',
        'import_document_no',
        'weight_kg',
        'watchlist_status',
        'status',
        'created_at',
        'updated_at',
    ];
}
