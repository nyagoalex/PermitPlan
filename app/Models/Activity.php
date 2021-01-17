<?php

namespace App\Models;

use App\Traits\Searchable;
use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use UsesUuid, Searchable;
    
    public $searchable = [
        'name','location','cost_per_person', 'description'
    ];
        /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:D, d M Y',
        'updated_at' => 'datetime:D, d M Y',
    ];

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','location','cost_per_person', 'description'
    ];
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
