<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['module_id','title','markdown','is_lab','order'];

    public function module() { return $this->belongsTo(Module::class); }
}
