<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Name', 'Description', 'Rating','TicketPrice'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'Country','Genre','Photo'
    ];
    public function comment()
    {
        return $this->hasMany('App\Comment');
    }
}
