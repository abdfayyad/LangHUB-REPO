<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferAnnualScadual extends Model
{
    use HasFactory;
    protected $fillable = [
        'saturday', 'start_saturday', 'end_saturday',
        'sunday', 'start_sunday', 'end_sunday',
        'monday', 'start_monday', 'end_monday',
        'tuesday', 'start_tuesday', 'end_tuesday',
        'wednsday', 'start_wednsday', 'end_wednsday',
        'thursday', 'start_thursday', 'end_thursday',
        'friday', 'start_friday', 'end_friday',
        'offer_id'
    ];

}
