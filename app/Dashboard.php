<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'owner_id',
        'background',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'       => 'integer',
        'owner_id' => 'integer',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function columns()
    {
        return $this->hasMany(Column::class)->with('tasks')->orderBy('sort');
    }
}
