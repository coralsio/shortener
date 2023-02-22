<?php

namespace Corals\Modules\Shortener\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class TrackingPixelPresenter extends FractalPresenter
{
    /**
     * @param array $extras
     * @return LinkTransformer|\League\Fractal\TransformerAbstract
     */
    public function getTransformer($extras = [])
    {
        return new TrackingPixelTransformer($extras);
    }
}
