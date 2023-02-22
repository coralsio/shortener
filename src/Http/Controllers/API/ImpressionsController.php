<?php

namespace Corals\Modules\Shortener\Http\Controllers\API;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Shortener\Services\ImpressionService;
use Illuminate\Http\Request;

class ImpressionsController extends BaseController
{
    protected $impressionService;

    public function __construct(ImpressionService $impressionService)
    {
        $this->impressionService = $impressionService;

        $this->corals_middleware = ['auth.basic'];

        parent::__construct();
    }

    /**
     * @param Request $request
     * @param $codeLink
     * @return \Illuminate\Http\RedirectResponse
     */
    public function click(Request $request, $codeLink)
    {
        return $this->impressionService->click($request, $codeLink);
    }
}
