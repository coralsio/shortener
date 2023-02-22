<?php

namespace Corals\Modules\Shortener\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;

class UrlCode extends BaseModel
{
    use PresentableTrait;
    use LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'shortener.models.urlCode';

    protected $table = 'shortener_url_codes';

    protected $casts = [
        'properties' => 'json',
    ];

    protected $guarded = ['id'];

    /**
     * @return BelongsTo
     */
    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }

    /**
     * @return BelongsTo
     */
    public function shortDomain(): BelongsTo
    {
        return $this->belongsTo(ShortDomain::class);
    }
}
