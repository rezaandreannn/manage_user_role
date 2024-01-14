<?php

namespace App\DataTables;

use DB;
use Yajra\DataTables\Html\Column;
use Illuminate\Database\Query\Builder;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Services\DataTable;

class ProduksiDataTable extends DataTable
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
            ->editColumn('docket', function ($query) {
                return $query->docket ?? '-';
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
            ->rawColumns(['action', 'no']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Spatie\Permission\Models\Permission $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return DB::connection('second_db')
            ->table('bp_tickets as tk')
            ->select('tk.ticket_number as docket', 'tk.customer', 'jh.name as mutu', 'tk.load_qty as qty', 'tk.delivered_qty', 'tk.ordered_qty', 'tk.created_at', 'tk.jo_number as ref1', 'tk.sklp_number as ref2', 'bl.code as bp_name')
            ->join('bp_location as bl', 'bl.id', '=', 'tk.id_batchingplant')
            ->join('bp_jobmix_header as jh', 'jh.id', '=', 'tk.id_jobmix_header')
            ->where('tk.id_jobmix_header', '>', 0);
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
            ['data' => 'docket', 'name' => 'docket', 'title' => 'Docket', 'className' => 'text-left'],
            ['data' => 'customer', 'name' => 'customer', 'title' => 'Customer', 'className' => 'text-left'],
            ['data' => 'mutu', 'name' => 'mutu', 'title' => 'Mutu', 'className' => 'text-center'],
            ['data' => 'qty', 'name' => 'qty', 'title' => 'Qty', 'className' => 'text-center'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At', 'className' => 'text-center'],
        ];


        $columns[] = Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->searchable(false)
            ->width(60)
            ->addClass('text-center hide-search');


        return $columns;
    }
}
