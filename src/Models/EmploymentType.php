<?php

namespace Vng\DennisCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmploymentType extends Model
{
    use SoftDeletes;

    protected $table = 'employment_types';

    protected $fillable = [
        'description',
        'code',
    ];

    public function instruments(): BelongsToMany
    {
        return $this->belongsToMany(Instrument::class, 'employment_type_instrument')->withTimestamps()->using(EmploymentTypeInstrument::class);
    }
}
