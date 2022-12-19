<?php

namespace Vng\DennisCore\Models;

use Illuminate\Database\Eloquent\Builder;
use Vng\DennisCore\ElasticResources\ProviderResource;
use Vng\DennisCore\Interfaces\IsMemberInterface;
use Vng\DennisCore\Observers\ProviderObserver;
use Vng\DennisCore\Repositories\Eloquent\ProviderRepository;
use Vng\DennisCore\Traits\HasContacts;
use Vng\DennisCore\Traits\HasOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Provider extends SearchableModel
{
    use SoftDeletes, HasOwner, HasFactory, HasContacts, MutationLog;

    protected $table = 'providers';
    protected string $elasticResource = ProviderResource::class;

    protected $attributes = [
        'is_fixed' => false,
    ];

    protected $fillable = [
        'uuid',
        'name',
        'is_fixed',
        'email',
        'website',
        'logo_header',
        'logo_body',
        'logo_color',

        'import_mark',
    ];

    protected $casts = [
        'is_fixed' => 'boolean',
    ];

    /**
     *  Setup model event hooks
     */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });

        static::observe(ProviderObserver::class);
    }

    public function instruments(): HasMany
    {
        return $this->hasMany(Instrument::class);
    }

//    public function instruments(): BelongsToMany
//    {
//        return $this->belongsToMany(Instrument::class, 'instrument_provider')->withTimestamps()->using(InstrumentProvider::class);
//    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }


    public function scopeOwnedBy(Builder $query, IsMemberInterface $user)
    {
        $repo = new ProviderRepository();
        return $repo->addMultipleOwnerConditions($query, $user->getAssociations());
    }
}
