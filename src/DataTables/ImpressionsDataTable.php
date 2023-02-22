<?php

namespace Corals\Modules\Shortener\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Shortener\Models\Impression;
use Corals\Modules\Shortener\Transformers\ImpressionTransformer;
use Yajra\DataTables\EloquentDataTable;

class ImpressionsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('shortener.models.impression.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new ImpressionTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Impression $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Impression $model)
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
            'url' => [
                'title' => trans('Shortener::attributes.link.url'),
                'searchable' => false,
                'orderable' => false,
            ],
            'alias' => [
                'title' => trans('Shortener::attributes.link.alias'),
                'searchable' => false,
                'orderable' => false,
            ],
            'ip_address' => ['title' => trans('Shortener::attributes.impression.ip_address')],
            'browser' => ['title' => trans('Shortener::attributes.impression.browser')],
            'browser_version' => ['title' => trans('Shortener::attributes.impression.browser_version')],
            'is_phone' => ['title' => trans('Shortener::attributes.impression.is_phone')],
            'is_tablet' => ['title' => trans('Shortener::attributes.impression.is_tablet')],
            'is_robot' => ['title' => trans('Shortener::attributes.impression.is_robot')],
            'robot' => ['title' => trans('Shortener::attributes.impression.robot')],
            'platform' => ['title' => trans('Shortener::attributes.impression.platform')],
            'platform_version' => ['title' => trans('Shortener::attributes.impression.platform_version')],
            'languages' => ['title' => trans('Shortener::attributes.impression.languages')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
        ];
    }

    public function getFilters()
    {
        return [
            'link.url' => [
                'title' => trans('Shortener::attributes.link.url'),
                'class' => 'col-md-2',
                'type' => 'text',
                'condition' => 'like',
                'active' => true,
            ],
            'link.alias' => [
                'title' => trans('Shortener::attributes.link.alias'),
                'class' => 'col-md-2',
                'type' => 'text',
                'condition' => 'like',
                'active' => true,
            ],
            'browser' => [
                'title' => trans('Shortener::attributes.impression.browser'),
                'class' => 'col-md-2',
                'type' => 'text',
                'condition' => 'like',
                'active' => true,
            ],
            'platform' => [
                'title' => trans('Shortener::attributes.impression.platform'),
                'class' => 'col-md-2',
                'type' => 'text',
                'condition' => 'like',
                'active' => true,
            ],
            'ip_address' => [
                'title' => trans('Shortener::attributes.impression.ip_address'),
                'class' => 'col-md-2',
                'type' => 'text',
                'condition' => 'like',
                'active' => true,
            ],
        ];
    }
}
