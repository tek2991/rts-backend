<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class StateModel extends Model
{
    protected $table = 'states';
    protected $fillable = ['name'];

    public static function defaultValues()
    {
        return [
            'Assam',
        ];
    }

    public function districts()
    {
        return $this->hasMany(District::class, 'state_id');
    }
}
