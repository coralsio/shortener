<?php

namespace Corals\Modules\Shortener\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Shortener\Models\TrackingPixel;
use Corals\Modules\Shortener\Transformers\TrackingPixelTransformer;
use Yajra\DataTables\EloquentDataTable;

class TrackingPixelsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('shortener.models.tracking_pixel.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new TrackingPixelTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param TrackingPixel $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(TrackingPixel $model)
    {
        return $model->newQuery();
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => ['visible' => false],
            'name' => ['title' => trans('Shortener::attributes.tracking_pixel.name')],
            'short_domain' => ['title' => trans('Shortener::attributes.tracking_pixel.short_domain')],
            'provider' => ['title' => trans('Shortener::attributes.tracking_pixel.provider')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}
