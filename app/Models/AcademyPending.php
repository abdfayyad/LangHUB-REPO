<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AcademyAdminstrator ;
class AcademyPending extends Model
{
    protected $fillable = [
        'name' , 'description' ,'location','license_number','english','germany','spanish','french','user_id','academy_adminstrator_id' ,'photo'
    ];
    public function academyAdmin(){
        return $this->belongsTo(AcademyAdminstrator::class);
    }
    public function photos(){
        return $this->hasMany(AcademyPhoto::class);
    }
    use HasFactory;
}
