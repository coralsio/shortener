<?php

namespace Corals\Modules\Shortener\Services;

use Corals\Foundation\Services\BaseServiceClass;

class LinkService extends BaseServiceClass
{
    public function postStore($request, &$additionalData)
    {
        $link = $this->model;

        $link->generateShortURL();
    }
}
