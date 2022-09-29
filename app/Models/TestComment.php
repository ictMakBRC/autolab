<?php

namespace App\Models;

use App\Models\Admin\Test;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestComment extends Model
{
    use HasFactory;
    protected $fillable =['test_id','comment'];
    public function test()
    {
        return $this->belongsTo(Test::class,'test_id','id');
    }
}
