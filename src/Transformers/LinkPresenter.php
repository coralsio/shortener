<?php

namespace Corals\Modules\Shortener\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class LinkPresenter extends FractalPresenter
{

    /**
     * @return LinkTransformer
     */
    public function getTransformer($extras = [])
    {
        return new LinkTransformer($extras);
    }
}
