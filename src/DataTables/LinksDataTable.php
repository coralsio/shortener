<?php

namespace Corals\Modules\Shortener\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Shortener\Models\Link;
use Corals\Modules\Shortener\Transformers\LinkTransformer;
use Yajra\DataTables\EloquentDataTable;

class LinksDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('shortener.models.link.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new LinkTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Link $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Link $model)
    {
        return $model->newQuery()
            ->when(user()->cannot('Administrations::admin.shortener'), function ($query) {
                $query->where('created_by', user()->id);
            });
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
            'url' => ['title' => trans('Shortener::attributes.link.url')],
            'alias' => ['title' => trans('Shortener::attributes.link.alias')],
            'short_url' => ['title' => trans('Shortener::attributes.link.short_url')],
            'expired_at' => ['title' => trans('Shortener::attributes.link.expired_at')],
            'parameters' => ['title' => trans('Shortener::attributes.link.parameters')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }

    public function getFilters()
    {
        return [
            'url' => [
                'title' => trans('Shortener::attributes.link.url'),
                'class' => 'col-md-2',
                'type' => 'text',
                'condition' => 'like',
                'active' => true,
            ],
            'alias' => [
                'title' => trans('Shortener::attributes.link.alias'),
                'class' => 'col-md-2',
                'type' => 'text',
                'condition' => 'like',
                'active' => true,
            ],
        ];
    }
}
