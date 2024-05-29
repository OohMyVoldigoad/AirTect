<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sensorreceive extends Model
{
    use HasFactory;

    protected $table = 'sensorreceives';

    protected $fillable = [
        'humidity',
        'temperatureC',
        'temperatureF',
        'H2',
        'CH4',
    ];
}
