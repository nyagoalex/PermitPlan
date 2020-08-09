<?php

namespace App\Models;

use App\Traits\Searchable;
use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use UsesUuid, Searchable;
    
    public $searchable = [
        'name','country','city', 'email', 'phone', 'code'
    ];
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','country','city', 'email', 'phone', 'code'
    ];



      /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
        'created_at' => 'datetime:D, d M Y',
        'updated_at' => 'datetime:D, d M Y',
    ];

        /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }
        /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }
}
