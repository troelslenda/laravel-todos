<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'todos';

    protected $fillable = [
      'name',
      'completed',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
