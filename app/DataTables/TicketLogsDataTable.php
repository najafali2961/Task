<?php

namespace App\DataTables;

use App\Models\TicketLog;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TicketLogsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query
     * @return EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('created_at', function (TicketLog $log) {
                return $log->created_at->format('Y-m-d H:i');
            })
            ->addColumn('user', function (TicketLog $log) {
                return $log->user ? $log->user->name : 'N/A';
            })
            ->rawColumns(['user'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @param TicketLog $model
     * @return QueryBuilder
     */
    public function query(TicketLog $model): QueryBuilder
    {
        return $model->newQuery()->with(['ticket', 'user']);
    }

    /**
     * Optional method if you want to use the HTML builder.
     *
     * @return HtmlBuilder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('ticket-logs-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('ticket_id')->title('Ticket ID'),
            Column::computed('user')->title('User'),
            Column::make('action')->title('Action'),
            Column::make('description'),
            Column::make('created_at')->title('Logged At'),
        ];
    }

    /**
     * Get the filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'TicketLogs_' . date('YmdHis');
    }
}
