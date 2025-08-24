<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title','slug','level','duration_min','description','is_published'];

    public function modules()   { return $this->hasMany(Module::class)->orderBy('order'); }
    public function students()  { return $this->belongsToMany(User::class)->withPivot(['status','progress_pct'])->withTimestamps(); }
}
