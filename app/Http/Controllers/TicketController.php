<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewTicketRequest;
use App\Models\Country;
use App\Models\Ticket;
use App\Models\TicketPriority;
use App\Models\TicketStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class TicketController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|View|RedirectResponse
     */
    public function list()
    {

        $filterByStatusId = 0;

        if (request()->has('status')) {
            $validator = Validator::make(request()->all(), [
                    'status' => 'exclude_if:status,0|exists:ticket_statuses,id'
                ]);

            if ($validator->fails()) {
                return redirect()->route('ticket.list')->withErrors($validator->errors());
            }

            $filterByStatusId = request()->get('status');
        }

        $tickets = Ticket::with(['user:id,name', 'status:id,name', 'priority:id,name', 'country:id,name'])
            ->filterByStatusId($filterByStatusId)
            ->orderByStatus()
            ->orderByOpenDays()
            ->paginate(5)
            ->withQueryString();

        $statuses = TicketStatus::get(['id', 'name']);

        return view('admin.ticket.list', compact('tickets', 'statuses', 'filterByStatusId'));
    }

    /**
     * @param Ticket $ticket
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function preview(Ticket $ticket) : View
    {
        return view('admin.ticket.preview', compact('ticket'));
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create() : View
    {
        $countries = Country::orderBy('name', 'asc')->get(['id', 'name']);
        $priorities = TicketPriority::orderBy('id', 'asc')->get(['id', 'name']);

        return view('admin.ticket.create', compact('countries', 'priorities'));
    }

    /**
     * @param StoreNewTicketRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreNewTicketRequest $request) : RedirectResponse
    {

        try {

            $ticket = auth()->user()->tickets()->create([
                'title' => (string)$request->get('title'),
                'description' => (string)$request->get('description'),
                'status_id' => TicketStatus::OPEN,
                'priority_id' => (integer)$request->get('priority'),
                'country_id' => (integer)$request->get('country'),
            ]);

            if ($ticket)
                return back()->with('status', 'Ticket has been created successfully.');
            else
                return back()->withInput()->withErrors('Unknown error has occurred.');

        } catch (\Exception $e) {

            return back()->withInput()->withErrors($e->getMessage());

        }
    }

    /**
     * @param Ticket $ticket
     * @return \Illuminate\Http\JsonResponse
     */
    public function setStatusClosed(Ticket $ticket) : JsonResponse
    {
        try {

            $status = $ticket->update(['status_id' => TicketStatus::CLOSED]);

            if ($status)
                return response()->json(['success' => true, 'msg' => 'Ticket has been closed successfully.']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }

        return response()->json(['success' => false, 'msg' => 'Unknown error has occurred.']);
    }

}
