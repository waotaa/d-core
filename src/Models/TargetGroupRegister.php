<?php

namespace Vng\DennisCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TargetGroupRegister extends Model
{
    use SoftDeletes;

    protected $table = 'target_group_registers';

    protected $fillable = [
        'description',
    ];

    public function instruments(): BelongsToMany
    {
        return $this->belongsToMany(Instrument::class, 'instrument_target_group_register')->withTimestamps()->using(InstrumentTargetGroupRegister::class);
    }
}
