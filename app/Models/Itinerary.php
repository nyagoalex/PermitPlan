<?php

namespace App\Models;

use App\Traits\Searchable;
use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    use UsesUuid, Searchable;

    public $searchable = [
        'ref_no','title'
    ];

          /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
    ];

   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ref_no', 'title', 'date', 'days'
    ];

    public function getDaysAttribute($value)
    {
        return json_decode($value);
    }
}
