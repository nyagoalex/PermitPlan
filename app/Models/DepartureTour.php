<?php

namespace App\Models;

use App\Traits\Searchable;
use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class DepartureTour extends Model
{
    use UsesUuid, Searchable;
    
    public $searchable = [
        'name'
    ];
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','arrival_date', 'departure_date', 'user_id'
    ];


    protected $withCount = ['permits'];
    protected $with = ['permits'];
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function permits()
    {
        return $this->hasMany(DepartureTourPermit::class, 'group_tour_id');
    }

    public function getDeletableAttribute()
    {
        return $this->permits->WhereNotNull('allocated_permit_id')->count() == 0;
    }


}