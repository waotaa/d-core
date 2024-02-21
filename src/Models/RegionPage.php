<?php

namespace Vng\DennisCore\Models;

use Database\Factories\RegionPageFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Vng\DennisCore\ElasticResources\RegionPageResource;
use Vng\DennisCore\Traits\HasContacts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

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
