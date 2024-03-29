<?php

namespace Vng\DennisCore\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Relation;
use Vng\DennisCore\Enums\ContactTypeEnum;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Vng\DennisCore\Observers\ContactablesObserver;

class Contactables extends MorphPivot
{
    public $incrementing = true;
    protected $table = 'contactables';

    protected $attributes = [
        'type' => null,
        'label' => null
    ];

    protected $fillable = [
        'id',
        'contact_id',
        'contactable_id',
        'contactable_type',
        'type',
        'label'
    ];

    /**
     * On a model event of a pivot only the id's of the relationships are provided
     * The type of the morph relationship is not filled in the attributes (in this case contactable_type)
     * The protected property morphClass however contains the class (or morph map key)
     * We can use this to find the contactable entity
     */
    public function getContactableEntity()
    {
        $class = $this->getContactableClass();
        return $class::find($this->contactable_id);
    }

    private function getContactableClass()
    {
        $morphMap = Relation::morphMap();
        if (! empty($morphMap) && array_key_exists($this->morphClass, $morphMap)) {
            return $morphMap[$this->morphClass];
        }
        return $this->morphClass;
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function contactable(): MorphTo
    {
        return $this->morphTo('contactable', 'contactable_type', 'contactable_id');
    }

//    public function getContactableClass(): ?string
//    {
//        return Relation::getMorphedModel($this->morphClass);
//    }
//
//    public function findContactable()
//    {
//        var_dump($this->getMorphClass());
//        dd($this->contactable);
//        var_dump($this->contactable_type);
//        dd($this);
//
//        if (is_null($this->getContactableClass())) {
//            return null;
//        }
//        return $this->getContactableClass()::find($this->contactable_id);
//    }

    protected static function boot()
    {
        parent::boot();
        static::observe(ContactablesObserver::class);
    }

    public function setTypeAttribute($value)
    {
        if (is_null($value)) {
            $this->attributes['type'] = null;
            return;
        }
        $this->attributes['type'] = (new ContactTypeEnum($value))->getKey();
    }

    public function getTypeAttribute($value)
    {
        if (is_null($value)) {
            return null;
        }
        if(in_array($value, ContactTypeEnum::keys())) {
            return ContactTypeEnum::$value();
        }
        return $this->attributes['type'];
    }

    public function getRawTypeAttribute()
    {
        return $this->attributes['type'] ?? null;
    }
}

