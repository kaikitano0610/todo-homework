<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'contents', 'due_date', 'user_id'];

     // due_dateをCarbonインスタンスとして扱う
     protected $dates = ['due_date'];

    public function images()
    {
        return $this->hasMany("App\Models\Image");
    }
}
