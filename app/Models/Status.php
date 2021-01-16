<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    const BREAKTIME_STATUS_KEY = 'break';
    const CHECK_STATUS_KEY = 'check';
    const BIOBREAK_STATUS_KEY = 'bio_break';

    protected $fillable = [
        'name',
        'key',
        'number',
        'in_allowance',
    ];
}
