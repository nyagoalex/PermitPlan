<?php

namespace App\Models;

use App\Traits\Searchable;
use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Booking extends Model
{
    use UsesUuid, Searchable, Notifiable;
    
    public $searchable = [
        'number','ref','city', 'client_name'
    ];
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number','ref','user_id', 'agent_id', 'no_of_persons', 'cost_per_person', 'arrival_date', 'departure_date', 'client_name', 'comment', 'itinerary'
    ];
    protected $withCount = ['permits'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function permits()
    {
        return $this->hasMany(Permit::class);
    }

    public function transferedPermits()
    {
        return $this->hasManyThrough(Permit::class, PermitTransfer::class, 'from_booking_id', 'id', 'id', 'permit_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class)->orderBy('date', 'DESC');
    }

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function getTentativeAttribute()
    {
        return ($this->status == 'tentative');
    }

    public function getCancelledAttribute()
    {
        return ($this->status == 'cancelled');
    }

    public function getSourceAttribute()
    {
        return is_null($this->agent_id) ? 'direct' : 'Agent';
    }

    public function getTotalCostAttribute()
    {
        return $this->no_of_persons * $this->cost_per_person;
    }

    public function getTotalPaidAttribute()
    {
        return $this->payments->sum('amount');
    }

    public function getBalanceAttribute()
    {
        return round(($this->total_cost - $this->total_paid), 2);
    }

    public function getItineraryAttribute($value)
    {
        return json_decode($value);
    }
}