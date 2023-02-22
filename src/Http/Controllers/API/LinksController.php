<?php

namespace Corals\Modules\Shortener\Http\Controllers\API;

use Corals\Foundation\Http\Controllers\APIBaseController;
use Corals\Modules\Shortener\DataTables\LinksDataTable;
use Corals\Modules\Shortener\Http\Requests\LinkRequest;
use Corals\Modules\Shortener\Models\Link;
use Corals\Modules\Shortener\Services\LinkService;
use Corals\Modules\Shortener\Transformers\API\LinkPresenter;

class LinksController extends APIBaseController
{
    protected $linkService;

    /**
     * LinksController constructor.
     * @param LinkService $linkService
     * @throws \Exception
     */
    public function __construct(LinkService $linkService)
    {
        $this->linkService = $linkService;
        $this->linkService->setPresenter(new LinkPresenter());

        $this->corals_middleware = ['auth.basic'];

        parent::__construct();
    }

    /**
     * @param LinkRequest $request
     * @param LinksDataTable $dataTable
     * @return mixed
     * @throws \Exception
     */
    public function index(LinkRequest $request, LinksDataTable $dataTable)
    {
        $links = $dataTable->query(new Link());

        return $this->linkService->index($links, $dataTable);
    }

    /**
     * @param LinkRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LinkRequest $request)
    {
        try {
            $link = $this->linkService->store($request, Link::class);
            return apiResponse($this->linkService->getModelDetails(),
                trans('Corals::messages.success.created', ['item' => $link->name]));
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }

    /**
     * @param LinkRequest $request
     * @param $linkCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(LinkRequest $request, $linkCode)
    {
        try {

            $link = Link::query()->where('code', $linkCode)->firstOrFail();

            return apiResponse($this->linkService->getModelDetails($link));
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }

    /**
     * @param LinkRequest $request
     * @param Link $link
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LinkRequest $request, Link $link)
    {
        try {
            $this->linkService->update($request, $link);

            return apiResponse($this->linkService->getModelDetails(),
                trans('Corals::messages.success.updated', ['item' => $link->name]));
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }

    /**
     * @param LinkRequest $request
     * @param Link $link
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LinkRequest $request, Link $link)
    {
        try {
            $this->linkService->destroy($request, $link);

            return apiResponse([], trans('Corals::messages.success.deleted', ['item' => $link->name]));
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }
}
