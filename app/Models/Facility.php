<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facility extends Model
{
    use HasFactory;
    // protected $fillable = ['facility_name','facility_type','parent_id','requester_name','requester_contact','requester_email'];
    protected $fillable = ['name','type','parent_id','is_active'];
    
    public function parent(){
        return $this->belongsTo(Facility::class,'parent_id','id');
    }
    
}
