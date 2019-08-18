<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Board extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'layout'
    ];    
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
