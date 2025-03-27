<?php

namespace App\Http\Controllers;

use App\DataTables\TicketLogsDataTable;
use App\Models\TicketLog;
use Illuminate\Http\Request;

class TicketLogsController extends Controller
{
    public function index(TicketLogsDataTable $dataTable)
    {
        return $dataTable->render('logs.index');
    }
}
