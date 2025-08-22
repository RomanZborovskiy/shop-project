<?php

namespace App\Http\admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LeadMessage;
use Illuminate\Http\Request;


class LeadMessageController extends Controller
{   
    public function index()
    {
        $leadMessages = LeadMessage::where('status', 'pending')->latest()->get();
        return view('admin.leadsMessages.index', compact('leadMessages'));
    }

    public function create()
    {
        return view('admin.leadsMessages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'scheduled_at' => 'nullable|date',
        ]);

        LeadMessage::create($data);

        return redirect()->route('lead-messages.index')
            ->with('success', 'Розсилка створена');
    }

    public function edit(LeadMessage $leadMessage)
    {
        return view('admin.leadsMessages.edit', compact( 'leadMessage'));
    }

    public function update(Request $request, LeadMessage $leadMessage)  
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'scheduled_at' => 'nullable|date',
        ]);

        LeadMessage::update($data);

        return redirect()->route('lead-messages.index')->with('success', 'Повідомлення успішно оновлено!');
    
    }

    public function destroy(LeadMessage $leadMessage)
    {
        $leadMessage->delete();

        return redirect()->route('lead-messages.index')->with('success','Атрибут видалено');
    }

}


