<?php

namespace Corals\Modules\Shortener\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Shortener\Models\ShortDomain;
use Corals\Modules\Shortener\Transformers\ShortDomainTransformer;
use Yajra\DataTables\EloquentDataTable;

class ShortDomainsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('shortener.models.shortDomain.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new ShortDomainTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param ShortDomain $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(ShortDomain $model)
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
            'id' => ['visible' => true],
            'title' => ['title' => trans('Shortener::attributes.shortDomain.title')],
            'base_url' => ['title' => trans('Shortener::attributes.shortDomain.base_url')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }

    public function getFilters()
    {
        return [
            'title' => [
                'title' => trans('Shortener::attributes.shortDomain.title'),
                'class' => 'col-md-2',
                'type' => 'text',
                'condition' => 'like',
                'active' => true
            ],
            'base_url' => [
                'title' => trans('Shortener::attributes.shortDomain.base_url'),
                'class' => 'col-md-2',
                'type' => 'text',
                'condition' => 'like',
                'active' => true
            ],
        ];
    }
}
