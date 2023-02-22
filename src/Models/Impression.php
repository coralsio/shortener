<?php

namespace Corals\Modules\Shortener\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Impression extends BaseModel
{
    use PresentableTrait, LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'shortener.models.impression';

    protected $table = 'shortener_impressions';

    protected $casts = [
        'properties' => 'json',
        'languages' => 'json'
    ];

    protected $guarded = ['id'];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
