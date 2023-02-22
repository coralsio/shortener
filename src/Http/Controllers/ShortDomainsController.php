<?php

namespace Corals\Modules\Shortener\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Shortener\DataTables\ShortDomainsDataTable;
use Corals\Modules\Shortener\Http\Requests\ShortDomainRequest;
use Corals\Modules\Shortener\Models\ShortDomain;
use Corals\Modules\Shortener\Services\ShortDomainService;

class ShortDomainsController extends BaseController
{
    protected $shortDomainService;

    public function __construct(ShortDomainService $shortDomainService)
    {
        $this->shortDomainService = $shortDomainService;

        $this->resource_url = config('shortener.models.shortDomain.resource_url');

        $this->resource_model = new ShortDomain();

        $this->title = trans('Shortener::module.shortDomain.title');
        $this->title_singular = trans('Shortener::module.shortDomain.title_singular');

        parent::__construct();
    }

    /**
     * @param ShortDomainRequest $request
     * @param ShortDomainsDataTable $dataTable
     * @return mixed
     */
    public function index(ShortDomainRequest $request, ShortDomainsDataTable $dataTable)
    {
        return $dataTable->render('Shortener::shortDomains.index');
    }

    /**
     * @param ShortDomainRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(ShortDomainRequest $request)
    {
        $shortDomain = new ShortDomain();

        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular]),
        ]);

        return view('Shortener::shortDomains.create_edit')->with(compact('shortDomain'));
    }

    /**
     * @param ShortDomainRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ShortDomainRequest $request)
    {
        try {
            $shortDomain = $this->shortDomainService->store($request, ShortDomain::class);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, ShortDomain::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param ShortDomainRequest $request
     * @param ShortDomain $shortDomain
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(ShortDomainRequest $request, ShortDomain $shortDomain)
    {
        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.show_title', ['title' => $shortDomain->getIdentifier('title')]),
            'showModel' => $shortDomain,
        ]);

        return view('Shortener::shortDomains.show')->with(compact('shortDomain'));
    }

    /**
     * @param ShortDomainRequest $request
     * @param ShortDomain $shortDomain
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(ShortDomainRequest $request, ShortDomain $shortDomain)
    {
        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.update_title', ['title' => $shortDomain->getIdentifier('title')]),
        ]);

        return view('Shortener::shortDomains.create_edit')->with(compact('shortDomain'));
    }

    /**
     * @param ShortDomainRequest $request
     * @param ShortDomain $shortDomain
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ShortDomainRequest $request, ShortDomain $shortDomain)
    {
        try {
            $this->shortDomainService->update($request, $shortDomain);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, ShortDomain::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param ShortDomainRequest $request
     * @param ShortDomain $shortDomain
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ShortDomainRequest $request, ShortDomain $shortDomain)
    {
        try {
            $this->shortDomainService->destroy($request, $shortDomain);

            $message = [
                'level' => 'success',
                'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular]),
            ];
        } catch (\Exception $exception) {
            log_exception($exception, ShortDomain::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}
