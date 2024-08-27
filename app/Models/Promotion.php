<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'link_url',
        'description',
        'image',
        'start_date',
        'end_date',
        'group_id',
        'polis_id',
        'member_id'
    ];
}
