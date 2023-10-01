<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['name', 'state_id'];

    public static function defaultValues()
    {
        return [
            'Assam' => [
                'Mushalpur',
                'Barpeta',
                'Bongaigaon',
                'Cachar',
                'Charaideo',
                'Chirang',
                'Darrang',
                'Dhemaji',
                'Dhubri',
                'Dibrugarh',
                'Dima Hasao',
                'Goalpara',
                'Golaghat',
                'Hailakandi',
                'Jorhat',
                'Kamrup Metropolitan',
                'Kamrup',
                'Karbi Anglong',
                'Karimganj',
                'Kokrajhar',
                'Lakhimpur',
                'Majuli',
                'Morigaon',
                'Nagaon',
                'Nalbari',
                'Sivasagar',
                'Sonitpur',
                'South Salmara-Mankachar',
                'Tinsukia',
                'Udalguri',
                'West Karbi Anglong'
            ]
        ];
    }

    public function state()
    {
        return $this->belongsTo(StateModel::class);
    }

    public function dealers()
    {
        return $this->hasMany(Dealer::class);
    }
}
