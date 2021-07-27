<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $table = 'results';

    public static $unguarded = true;

    protected $primaryKey = 'id';

    protected $fillable = [
        'week',
        'guest_id',
        'home_id',
        'guest_score',
        'home_score',
    ];
}
