<?php
 
namespace App\Models\Sosmed;
 
use Illuminate\Database\Eloquent\Model;
 
class Instagram extends Model
{
    protected $table = 'instagram';
 
    protected $fillable = [
        'user_id', 'provider_name','provider_id', 'access_token',
    ];
}