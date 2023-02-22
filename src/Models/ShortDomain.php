<?php

namespace Corals\Modules\Shortener\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\Traits\LogsActivity;

class ShortDomain extends BaseModel
{
    use PresentableTrait, LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'shortener.models.shortDomain';

    protected $table = 'shortener_short_domains';

    protected $casts = [
        'properties' => 'json',
    ];

    protected $guarded = ['id'];

    /**
     * @return HasMany
     */
    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    /**
     * @return HasMany
     */
    public function urlCodes(): HasMany
    {
        return $this->hasMany(UrlCode::class);
    }
}
