<?php namespace TeachMe\Http\Controllers;

use Illuminate\Auth\Guard;
use Illuminate\Support\Facades\Redirect;
use TeachMe\Entities\Ticket;
use TeachMe\Entities\TicketComment;
use TeachMe\Http\Requests;
use TeachMe\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TicketsController extends Controller {

	//
    public function latest()
    {
        $tickets = Ticket::orderBy('created_at', 'DESC')->paginate();
        return view('tickets/list', compact('tickets'));
    }

    public function popular()
    {
        return view('tickets/list');
    }

    public function open()
    {
        $tickets = Ticket::where('status', 'open')->orderBy('created_at', 'DESC')->paginate();
        return view('tickets/list', compact('tickets'));
    }

    public function closed()
    {
        $tickets = Ticket::where('status', 'closed')->orderBy('created_at', 'DESC')->paginate();
        return view('tickets/list', compact('tickets'));
    }

    public function details($id, Guard $auth)
    {
        $ticket = Ticket::findOrFail($id);
        $user = $auth->user();

        return view('tickets/detail', compact('ticket', 'comments', 'user'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request, Guard $auth)
    {
        $this->validate($request, [
            'title' => 'required|max:120'
        ]);

        $ticket = $auth->user()->tickets()->create([
            'title' => $request->get('title'),
            'status' => 'open'
        ]);

        return \Redirect::route('tickets.details', $ticket->id);
    }
}
