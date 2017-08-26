<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'todos';
    protected $fillable = [
      'name',
      'completed',
    ];

    /**
     * Save model.
     *
     * @param array $options
     *
     * @throws \Exception
     *
     * @return bool
     */
    public function save(array $options = [])
    {
        if (empty(self::getAttribute('name'))) {
            throw new \Exception('Todo needs name before saving!');
        }
        return parent::save($options);
    }

    /**
     * Set model relationship to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
