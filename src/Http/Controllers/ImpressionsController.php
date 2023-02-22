<?php

namespace Corals\Modules\Shortener\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Shortener\DataTables\ImpressionsDataTable;
use Corals\Modules\Shortener\Http\Requests\ImpressionRequest;
use Corals\Modules\Shortener\Models\Impression;
use Corals\Modules\Shortener\Services\ImpressionService;
use Illuminate\Http\Request;

class ImpressionsController extends BaseController
{
    protected $impressionService;

    public function __construct(ImpressionService $impressionService)
    {
        $this->corals_middleware_except = array_merge($this->corals_middleware, ['click']);

        $this->impressionService = $impressionService;

        $this->resource_url = config('shortener.models.impression.resource_url');

        $this->resource_model = new Impression();

        $this->title = trans('Shortener::module.impression.title');
        $this->title_singular = trans('Shortener::module.impression.title_singular');

        parent::__construct();
    }

    /**
     * @param ImpressionRequest $request
     * @param ImpressionsDataTable $dataTable
     * @return mixed
     */
    public function index(ImpressionRequest $request, ImpressionsDataTable $dataTable)
    {
        return $dataTable->render('Shortener::impressions.index');
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
