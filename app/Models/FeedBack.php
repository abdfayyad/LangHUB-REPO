<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Academy;
class FeedBack extends Model
{
    use HasFactory;
    protected $table = 'feed_backs';
    protected $fillable = [
        'value', 'academy_id'
    ];
    protected $hidden = [
        'academy_id' , 'created_at' ,'updated_at' 
    ];

    public function academy() {
        return $this->belongsTo(Academy::class);
    }
}
