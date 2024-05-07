<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListBranches extends Model
{
    use HasFactory;

    protected $fillable = [
        'category', 'domicile', 'address', 'telp', 'fax', 'email', 'lat', 'long'
    ];
}
