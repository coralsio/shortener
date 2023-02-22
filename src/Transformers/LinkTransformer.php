<?php

namespace Corals\Modules\Shortener\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Shortener\Models\Link;
use Illuminate\Support\Arr;
use Throwable;

class LinkTransformer extends BaseTransformer
{
    public function __construct($extras = [])
    {
        $this->resource_url = config('shortener.models.link.resource_url');

        parent::__construct($extras);
    }

    /**
     * @param Link $link
     * @return array
     * @throws Throwable
     */
    public function transform(Link $link)
    {
        $parameters = array_merge(['name' => 'value'], array_combine(
            Arr::pluck($link->parameters ?? [], 'key'),
            Arr::pluck($link->parameters ?? [], 'value')));

        $transformedArray = [
            'id' => $link->id,
            'url' => HtmlElement('a', ['href' => $link->getEditUrl()], $link->url),
            'full_url' => $link->full_url,
            'alias' => $link->alias ? HtmlElement('a', ['href' => $link->getEditUrl()], $link->alias) : '-',
            'short_url' => generateCopyToClipBoard($link->id, $link->short_url ?? '-'),
            'status' => formatStatusAsLabels($link->status),
            'parameters' => $link->parameters ? generatePopover(formatProperties($parameters)) : '-',
            'expired_at' => $link->expired_at ? format_date($link->expired_at) : '-',
            'created_at' => format_date($link->created_at),
            'updated_at' => format_date($link->updated_at),
            'action' => $this->actions($link)
        ];

        return parent::transformResponse($transformedArray);
    }
}
