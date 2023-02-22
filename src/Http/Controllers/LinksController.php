<?php

namespace Corals\Modules\Shortener\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Shortener\DataTables\LinksDataTable;
use Corals\Modules\Shortener\Http\Requests\LinkRequest;
use Corals\Modules\Shortener\Models\Link;
use Corals\Modules\Shortener\Services\LinkService;

class LinksController extends BaseController
{
    protected $linkService;

    public function __construct(LinkService $linkService)
    {
        $this->linkService = $linkService;

        $this->resource_url = config('shortener.models.link.resource_url');

        $this->resource_model = new Link();

        $this->title = trans('Shortener::module.link.title');
        $this->title_singular = trans('Shortener::module.link.title_singular');

        parent::__construct();
    }

    /**
     * @param LinkRequest $request
     * @param LinksDataTable $dataTable
     * @return mixed
     */
    public function index(LinkRequest $request, LinksDataTable $dataTable)
    {
        return $dataTable->render('Shortener::links.index');
    }

    /**
     * @param LinkRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(LinkRequest $request)
    {
        $link = new Link();

        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])
        ]);

        return view('Shortener::links.create_edit')->with(compact('link'));
    }

    /**
     * @param LinkRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(LinkRequest $request)
    {
        try {
            $link = $this->linkService->store($request, Link::class);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Link::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param LinkRequest $request
     * @param Link $link
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(LinkRequest $request, Link $link)
    {
        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.show_title', ['title' => $this->title_singular]),
            'showModel' => $link,
        ]);

        return view('Shortener::links.show')->with(compact('link'));
    }

    /**
     * @param LinkRequest $request
     * @param Link $link
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(LinkRequest $request, Link $link)
    {
        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.update_title', ['title' => $this->title_singular])
        ]);

        return view('Shortener::links.create_edit')->with(compact('link'));
    }

    /**
     * @param LinkRequest $request
     * @param Link $link
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(LinkRequest $request, Link $link)
    {
        try {
            $this->linkService->update($request, $link);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Link::class, 'update');
        }

        return redirectTo($this->resource_url);
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

            $message = [
                'level' => 'success',
                'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])
            ];
        } catch (\Exception $exception) {
            log_exception($exception, Link::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}
