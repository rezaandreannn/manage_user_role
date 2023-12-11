<?php

namespace App\DataTables;

use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PermissionsDataTable extends DataTable
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
            ->editColumn('name', function ($query) {
                return $query->name ?? '-';
            })
            ->editColumn('type', function ($query) {
                if ($query->type == 'module') {
                    $color = 'success';
                } else {
                    $color = 'warning';
                }
                $button = '<button class="btn btn-' . $color . ' btn-sm">' . e($query->type ?? '-') . '</button>';
                $result = $query->type ? $button : '-';
                return $result;
            })
            ->editColumn('created_at', function ($query) {
                return date('Y/m/d', strtotime($query->created_at));
            })
            ->addColumn('no', function ($query) {
                // Nomor urut secara manual
                static $i = 1;
                return $i++;
            })

            ->addColumn('action', function ($query) {
                $title = 'Edit Permission';
                $id = $query->id;
                $routeEdit = route('permission.edit', $id);
                $permissionEdit = auth()->user()->hasRole('super admin') && auth()->user()->can('edit');
                $routeDelete = route('permission.destroy', $id);
                $permissionDelete = auth()->user()->hasRole('super admin') && auth()->user()->can('delete');
                $message = 'Are you sure delete permission ?';
                return view('components.action-modal', compact('id', 'title', 'routeEdit', 'routeDelete', 'message', 'permissionEdit', 'permissionDelete'))->render();
            })
            ->rawColumns(['action', 'no', 'type']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Spatie\Permission\Models\Permission $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = Permission::query();
        return $this->applyScopes($model);
    }


    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('dataTable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"row align-items-center"<"col-md-2" l><"col-md-6" B><"col-md-4"f>><"table-responsive my-3" rt><"row align-items-center" <"col-md-6" i><"col-md-6" p>><"clear">')

            ->parameters([
                "processing" => true,
                "autoWidth" => false,
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = [
            ['data' => 'no', 'name' => 'no', 'title' => 'No', 'className' => 'text-center'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Name', 'className' => 'text-left'],
            ['data' => 'title', 'name' => 'title', 'title' => 'Title', 'className' => 'text-left'],
            ['data' => 'type', 'name' => 'type', 'title' => 'Type', 'className' => 'text-center'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At', 'className' => 'text-center'],
        ];

        if (auth()->user()->hasRole('super admin')) {
            $columns[] = Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->width(60)
                ->addClass('text-center hide-search');
        }

        return $columns;
    }
}
