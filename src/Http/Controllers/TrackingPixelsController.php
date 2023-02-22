<?php

namespace Corals\Modules\Shortener\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Shortener\DataTables\TrackingPixelsDataTable;
use Corals\Modules\Shortener\Http\Requests\TrackingPixelRequest;
use Corals\Modules\Shortener\Models\TrackingPixel;
use Corals\Modules\Shortener\Services\TrackingPixelService;

class TrackingPixelsController extends BaseController
{
    protected $trackingPixelService;

    public function __construct(TrackingPixelService $trackingPixelService)
    {
        $this->trackingPixelService = $trackingPixelService;

        $this->resource_url = config('shortener.models.tracking_pixel.resource_url');

        $this->resource_model = new TrackingPixel();

        $this->title = trans('Shortener::module.tracking_pixel.title');
        $this->title_singular = trans('Shortener::module.tracking_pixel.title_singular');

        parent::__construct();
    }

    /**
     * @param TrackingPixelRequest $request
     * @param TrackingPixelsDataTable $dataTable
     * @return mixed
     */
    public function index(TrackingPixelRequest $request, TrackingPixelsDataTable $dataTable)
    {
        return $dataTable->render('Shortener::trackingPixels.index');
    }

    /**
     * @param TrackingPixelRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(TrackingPixelRequest $request)
    {
        $trackingPixel = new TrackingPixel();

        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular]),
        ]);

        return view('Shortener::trackingPixels.create_edit')->with(compact('trackingPixel'));
    }

    /**
     * @param TrackingPixelRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(TrackingPixelRequest $request)
    {
        try {
            $trackingPixel = $this->trackingPixelService->store($request, TrackingPixel::class);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, TrackingPixel::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param TrackingPixelRequest $request
     * @param TrackingPixel $trackingPixel
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(TrackingPixelRequest $request, TrackingPixel $trackingPixel)
    {
        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.show_title', ['title' => $trackingPixel->getIdentifier('name')]),
            'showModel' => $trackingPixel,
        ]);

        return view('Shortener::trackingPixels.show')->with(compact('trackingPixel'));
    }

    /**
     * @param TrackingPixelRequest $request
     * @param TrackingPixel $trackingPixel
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(TrackingPixelRequest $request, TrackingPixel $trackingPixel)
    {
        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.update_title', ['title' => $trackingPixel->getIdentifier('name')]),
        ]);

        return view('Shortener::trackingPixels.create_edit')->with(compact('trackingPixel'));
    }

    /**
     * @param TrackingPixelRequest $request
     * @param TrackingPixel $trackingPixel
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(TrackingPixelRequest $request, TrackingPixel $trackingPixel)
    {
        try {
            $this->trackingPixelService->update($request, $trackingPixel);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, TrackingPixel::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param TrackingPixelRequest $request
     * @param TrackingPixel $trackingPixel
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(TrackingPixelRequest $request, TrackingPixel $trackingPixel)
    {
        try {
            $this->trackingPixelService->destroy($request, $trackingPixel);

            $message = [
                'level' => 'success',
                'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular]),
            ];
        } catch (\Exception $exception) {
            log_exception($exception, TrackingPixel::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}
