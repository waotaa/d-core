<?php

namespace Vng\DennisCore\Models;

use Database\Factories\RegionPageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Vng\DennisCore\Casts\CleanedHtml;
use Vng\DennisCore\ElasticResources\Original\RegionPageResource;
use Vng\DennisCore\Traits\HasContacts;

class RegionPage extends SearchableModel
{
    use HasFactory, SoftDeletes, HasContacts;

    protected $table = 'region_pages';
    protected string $elasticResource = RegionPageResource::class;

    protected $fillable = [
        'description',
        'cooperation_partners',
        'additional_information',
        'terminology',
    ];

    protected $casts = [
        'description' => CleanedHtml::class,
        'cooperation_partners' => CleanedHtml::class,
        'additional_information' => CleanedHtml::class,
        'terminology' => CleanedHtml::class,
    ];

    protected static function newFactory()
    {
        return RegionPageFactory::new();
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function regionalParty(): BelongsTo
    {
        return $this->belongsTo(RegionalParty::class);
    }
}
