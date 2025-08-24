<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabTarget extends Model
{
    protected $fillable = ['name','host','port','protocol','description','enabled'];
}
