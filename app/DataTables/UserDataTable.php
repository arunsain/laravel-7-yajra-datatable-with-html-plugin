<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
        ->eloquent($query)
        ->addColumn('action',function($data){

            $view ='<a href="'.route('edit.user',$data->id).'" class="btn btn-success btn-sm">edit</a> <button type="button" data-id="'.$data->id.'" class="btn btn-danger btn-sm deleteData">delete</button>';

            return $view;
        })
        ->setRowClass(function ($user) {
            return $user->id % 2 == 0 ? 'alert-success' : 'alert-warning';
        })->setRowId(function ($user) {
            return $user->id;
        })->editColumn('created_at', function(User $user) {
                    return $user->created_at->diffforHumans();
                })->editColumn('class_id', function(User $user) {
                    return $user->classData->class_name;
                })->addColumn('intro', 'Hi {{$name}}!')
                ->addColumn('test', 'test.test')->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
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
        ->setTableId('user-table')
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->dom('Bfrtip')
        ->orderBy(1)
        ->buttons(
           Button::make('create')->action("window.location = '".route('add.user')."';"),
            Button::make('export'),
            Button::make('print'),
            Button::make('reset'),
            Button::make('reload')
        )->parameters([
            // 'dom'          => 'Bfrtip',
            // 'buttons'      => ['export', 'print', 'reset', 'reload'],
            'initComplete' => "function () {
                this.api().columns().every(function () {
                    var column = this;
                    var input = document.createElement(\"input\");
                    $(input).appendTo($(column.footer()).empty())
                    .on('keyup', function () {
                        column.search($(this).val(), false, false, true).draw();
                        });
                        });
                    }",
                ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [

            Column::make('id')->title('sno'),
            Column::make('name'),
            Column::make('email'),
            Column::make('intro'),
            Column::make('test'),
            Column::make('class_id')->title('Class Name')->searchable(false),
            Column::make('created_at'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->orderable(true)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'User_' . date('YmdHis');
    }
}
