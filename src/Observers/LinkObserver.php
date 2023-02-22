<?php

namespace Corals\Modules\Shortener\Observers;

use Corals\Modules\Shortener\Models\Link;

class LinkObserver
{
    /**
     * @param Link $link
     */
    public function created(Link $link)
    {
    }
}
