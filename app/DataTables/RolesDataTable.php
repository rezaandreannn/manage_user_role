<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Column;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Services\DataTable;

class RolesDataTable extends DataTable
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
            ->editColumn('created_at', function ($query) {
                return date('Y/m/d', strtotime($query->created_at));
            })
            ->addColumn('no', function ($query) {
                // Nomor urut secara manual
                static $i = 1;
                return $i++;
            })

            ->addColumn('action', function ($query) {
                $title = 'Edit Role';
                $id = $query->id;
                $routeEdit = route('role.edit', $id);
                $permissionEdit = auth()->user()->hasRole('super admin') && auth()->user()->can('edit');
                $routeDelete = route('role.destroy', $id);
                $permissionDelete = auth()->user()->hasRole('super admin') && auth()->user()->can('delete');
                $message = 'Are you sure delete role ?';
                return view('components.action-modal', compact('id', 'title', 'routeEdit', 'routeDelete', 'message', 'permissionEdit', 'permissionDelete'))->render();
            })
            ->rawColumns(['action', 'no']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Spatie\Permission\Models\Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = Role::where('status', 1);
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
            ['data' => 'no', 'name' => 'no', 'title' => 'No'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'title', 'name' => 'title', 'title' => 'Title'],
            ['data' => 'guard_name', 'name' => 'guard_name', 'title' => 'Guard Name'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At'],
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
