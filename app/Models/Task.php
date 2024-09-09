<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable=['title','description','status', 'assigned_to',];

   
    //set the column which can not input it by the user
    protected $guarded=['due_date'];
  //to change name of the praimary key
    protected $praimaryKey=['task_id'];
    public $incrementing='true';
    const CREATED_AT='creating_time';
    const UPDATED_AT='updating_time';
    //if you would like to define an attributes 
    protected $attributes=[
      'due_date'=>now(),
    ];
    //the relationship between the tasks and user
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
public function getDueDateAttribute($due_date)
{
  return $due_date->format('d-m-Y H:i');
}
public function scopePriority($query,$priority)
{
return $query->where('priority',$priority);
}
public function scopeStatus($query,$status)
{
return $query->where('status',$status);
}

}

