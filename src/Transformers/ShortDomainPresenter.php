<?php

namespace Corals\Modules\Shortener\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class ShortDomainPresenter extends FractalPresenter
{

    /**
     * @return ShortDomainTransformer
     */
    public function getTransformer($extras = [])
    {
        return new ShortDomainTransformer($extras);
    }
}
