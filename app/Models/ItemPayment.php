<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class ItemPayment extends Model
{
    use UsesUuid;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount','date','user_id'
    ];

       /**
     * Get all of the post's comments.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
