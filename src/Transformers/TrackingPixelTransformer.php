<?php

namespace Corals\Modules\Shortener\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Shortener\Models\TrackingPixel;

class TrackingPixelTransformer extends BaseTransformer
{
    public function __construct($extras = [])
    {
        $this->resource_url = config('shortener.models.tracking_pixel.resource_url');

        parent::__construct($extras);
    }

    /**
     * @param TrackingPixel $trackingPixel
     * @return array
     * @throws \Throwable
     */
    public function transform(TrackingPixel $trackingPixel)
    {
        $transformedArray = [
            'id' => $trackingPixel->id,
            'name' => HtmlElement('a', ['href' => $trackingPixel->getEditUrl()], $trackingPixel->name),
            'provider' => config('shortener.models.tracking_pixel.providers')[$trackingPixel->provider] ?? '-',
            'short_domain' => $trackingPixel->short_domain_id ? $trackingPixel->shortDomain->present('title') : '-',
            'tag' => $trackingPixel->tag,
            'status' => formatStatusAsLabels($trackingPixel->status),
            'created_at' => format_date($trackingPixel->created_at),
            'updated_at' => format_date($trackingPixel->updated_at),
            'action' => $this->actions($trackingPixel)
        ];

        return parent::transformResponse($transformedArray);
    }
}
