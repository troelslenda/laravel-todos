<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;

class Todo extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'todos';

    protected $fillable = [
      'name',
      'completed',
    ];

    public function save(array $options = [])
    {
        if (empty(self::getAttribute('name'))) {
            throw new MissingMandatoryParametersException('Todo needs name before saving!');
        }
        return parent::save($options);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
