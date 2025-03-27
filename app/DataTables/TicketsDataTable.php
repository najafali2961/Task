<?php

namespace App\DataTables;

use App\Models\Tickets;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TicketsDataTable extends DataTable
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
            ->editColumn('title', function ($ticket) {
                return '<a href="' . route('tickets.show', $ticket->id) . '">' . e($ticket->title) . '</a>';
            })
            ->editColumn('priority', function (Tickets $ticket) {
                return $ticket->priority ? $ticket->priority->name : '';
            })
            ->addColumn('action', function ($ticket) {
                $actions = ''; {
                    $actions .= '<a href="' . route('tickets.edit', $ticket->id) . '" class="btn btn-sm btn-warning">Edit</a> ';
                    $actions .= '<button class="btn btn-sm btn-danger delete-ticket" data-id="' . $ticket->id . '">Delete</button>';
                }
                return $actions;
            })
            ->editColumn('created_at', function (Tickets $ticket) {
                return $ticket->created_at->format('Y-m-d ');
            })
            ->rawColumns(['title', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @param Tickets $model
     * @return QueryBuilder
     */
    public function query(Tickets $model): QueryBuilder
    {
        $query = $model->newQuery();
        $user = auth()->user();
        if ($user->hasRole('Agent')) {
            $query->where('agent_id', $user->id);
        } elseif ($user->hasRole('User')) {
            $query->where('user_id', $user->id);
        }
        return $query;
    }

    /**
     * Optional method if you want to use the HTML builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('tickets-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {

        $columns = [
            Column::make('id'),
            Column::make('title'),
            Column::computed('priority')->title('Priority'),
            Column::make('status'),
            Column::make('created_at'),
        ];


        if (
            auth()->user()->hasRole('Administrator') ||
            auth()->user()->hasRole('Agent')
        ) {
            $columns[] = Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center');
        }

        return $columns;
    }


    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Tickets_' . date('YmdHis');
    }
}
