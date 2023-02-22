<?php

namespace Corals\Modules\Shortener\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class TrackingPixel extends BaseModel
{
    use PresentableTrait;
    use LogsActivity;

    public $htmlentitiesExcluded = ['head_script', 'body_script'];

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'shortener.models.tracking_pixel';

    protected $table = 'shortener_tracking_pixels';

    protected $casts = [
        'properties' => 'json',
    ];

    protected $guarded = ['id'];

    public function shortDomain()
    {
        return $this->belongsTo(ShortDomain::class);
    }

    public function scopeActive($builder)
    {
        $builder->where('status', 'active');
    }
}
