<?php

namespace Corals\Modules\Shortener\Transformers\API;

use Corals\Foundation\Transformers\APIBaseTransformer;
use Corals\Modules\Shortener\Models\Link;

class LinkTransformer extends APIBaseTransformer
{
    /**
     * @param Link $link
     * @return array
     * @throws \Throwable
     */
    public function transform(Link $link)
    {
        $transformedArray = [
            'id' => $link->id,
            'url' => $link->url,
            'full_url' => $link->full_url,
            'alias' => $link->alias,
            'short_url' => $link->short_url,
            'status' => $link->status,
            'expired_at' => $link->expired_at,
            'created_at' => format_date($link->created_at),
            'updated_at' => format_date($link->updated_at),
        ];

        return parent::transformResponse($transformedArray);
    }
}
