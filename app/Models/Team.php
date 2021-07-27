<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $table = 'teams';

    public static $unguarded = true;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'pts',
        'played',
        'wins',
        'draws',
        'loses',
        'gd',
        'winrate'
    ];
}
