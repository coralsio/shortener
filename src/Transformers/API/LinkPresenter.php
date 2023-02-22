<?php

namespace Corals\Modules\Shortener\Transformers\API;

use Corals\Foundation\Transformers\FractalPresenter;

class LinkPresenter extends FractalPresenter
{

    /**
     * @return LinkTransformer
     */
    public function getTransformer()
    {
        return new LinkTransformer();
    }
}
