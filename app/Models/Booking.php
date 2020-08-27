<?php

namespace App\Models;

use App\Traits\Searchable;
use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use UsesUuid, Searchable;
    
    public $searchable = [
        'number','ref','city', 'client_name'
    ];
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number','ref','user_id', 'agent_id', 'no_of_persons', 'cost_per_person', 'arrival_date', 'departure_date', 'client_name', 'comment'
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function permits()
    {
        return $this->hasMany(Permit::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function getTentativeAttribute()
    {
        return ($this->status == 'tentative');
    }

    public function getSourceAttribute()
    {
        return is_null($this->agent_id) ? 'direct' : 'Agent';
    }
}