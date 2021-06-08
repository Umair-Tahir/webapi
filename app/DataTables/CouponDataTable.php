<?php

namespace App\DataTables;

use App\Models\Coupon;
use App\Models\CustomField;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Barryvdh\DomPDF\Facade as PDF;

class CouponDataTable extends DataTable
{

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        $columns = array_column($this->getColumns(), 'data');
        $dataTable = $dataTable
            ->editColumn('name', function ($coupon) {
                return $coupon->name;
            })
            ->editColumn('code', function ($coupon) {
                return $coupon->code;
            })
            ->editColumn('uses', function ($coupon) {
                return $coupon->uses;
            })
            ->editColumn('max_uses', function ($coupon) {
                return $coupon->max_uses;
            })
            ->editColumn('updated_at', function ($coupon) {
                return getDateColumn($coupon, 'updated_at');
            })
            ->addColumn('action', 'coupons.datatables_actions')
            ->rawColumns(array_merge($columns, ['action']));

        return $dataTable;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = [
            [
                'data' => 'name',
                'title' => trans('lang.coupon_name'),

            ],
            [
                'data' => 'code',
                'title' => trans('lang.coupon_code'),
            ],
            [
                'data' => 'uses',
                'title' => trans('lang.coupon_uses'),
            ],
            [
                'data' => 'max_uses',
                'title' => trans('lang.coupon_max_uses'),
            ],
            [
                'data' => 'starts_at',
                'title' => trans('lang.coupon_starts_at'),
            ],
            [
                'data' => 'expires_at',
                'title' => trans('lang.coupon_expires_at'),
            ],
            [
                'data' => 'updated_at',
                'title' => trans('lang.coupon_updated_at'),
                'searchable' => false,
            ]
        ];
        
        return $columns;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Coupon $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '80px', 'printable' => false, 'responsivePriority' => '100'])
            ->parameters(array_merge(
                config('datatables-buttons.parameters'), [
                    'language' => json_decode(
                        file_get_contents(base_path('resources/lang/' . app()->getLocale() . '/datatable.json')
                        ), true)
                ]
            ));
    }

    /**
     * Export PDF using DOMPDF
     * @return mixed
     */
    public function pdf()
    {
        $data = $this->getDataForPrint();
        $pdf = PDF::loadView($this->printPreview, compact('data'));
        return $pdf->download($this->filename() . '.pdf');
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'couponsdatatable_' . time();
    }
}