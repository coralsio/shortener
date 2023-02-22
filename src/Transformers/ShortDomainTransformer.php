<?php

namespace Corals\Modules\Shortener\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Shortener\Models\ShortDomain;

class ShortDomainTransformer extends BaseTransformer
{
    public function __construct($extras = [])
    {
        $this->resource_url = config('shortener.models.shortDomain.resource_url');

        parent::__construct($extras);
    }

    /**
     * @param ShortDomain $shortDomain
     * @return array
     * @throws \Throwable
     */
    public function transform(ShortDomain $shortDomain)
    {
        $transformedArray = [
            'id' => $shortDomain->id,
            'base_url' => HtmlElement('a', ['href' => $shortDomain->getEditUrl()], $shortDomain->base_url),
            'title' => HtmlElement('a', ['href' => $shortDomain->getEditUrl()], $shortDomain->title),
            'status' => formatStatusAsLabels($shortDomain->status),
            'created_at' => format_date($shortDomain->created_at),
            'updated_at' => format_date($shortDomain->updated_at),
            'action' => $this->actions($shortDomain),
        ];

        return parent::transformResponse($transformedArray);
    }
}
