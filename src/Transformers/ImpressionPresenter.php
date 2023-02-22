<?php

namespace Corals\Modules\Shortener\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class ImpressionPresenter extends FractalPresenter
{
    /**
     * @return ImpressionTransformer
     */
    public function getTransformer($extras = [])
    {
        return new ImpressionTransformer($extras);
    }
}
