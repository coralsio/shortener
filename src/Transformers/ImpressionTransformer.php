<?php

namespace Corals\Modules\Shortener\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Shortener\Models\Impression;

class ImpressionTransformer extends BaseTransformer
{
    public function __construct($extras = [])
    {
        $this->resource_url = config('shortener.models.impression.resource_url');

        parent::__construct($extras);
    }

    /**
     * @param Impression $impression
     * @return array
     * @throws \Throwable
     */
    public function transform(Impression $impression)
    {
        $transformedArray = [
            'id' => $impression->id,

            'url' => $impression->link->url,
            'alias' => $impression->link->alias ?? '-',

            'browser' => $impression->browser,
            'ip_address' => $impression->ip_address,
            'browser_version' => $impression->browser_version,
            'is_phone' => yesNoFormatter($impression->is_phone),
            'is_tablet' => yesNoFormatter($impression->is_tablet),

            'is_robot' => yesNoFormatter($impression->is_robot),
            'robot' => yesNoFormatter($impression->robot),
            'platform' => $impression->platform,
            'platform_version' => $impression->platform_version,

            'languages' => generatePopover(formatProperties($impression->languages)),

            'created_at' => format_date_time($impression->created_at),
            'updated_at' => format_date($impression->updated_at),
            'action' => $this->actions($impression)
        ];

        return parent::transformResponse($transformedArray);
    }
}
