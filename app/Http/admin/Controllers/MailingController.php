<?php

namespace App\Http\admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mailing;
use Illuminate\Http\Request;


class MailingController extends Controller
{   
    public function index()
    {
        $leadMessages = Mailing::where('status', 'pending')->latest()->get();
        return view('admin.mailings.index', compact('leadMessages'));
    }

    public function create()
    {
        return view('admin.mailings.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'scheduled_at' => 'nullable|date',
        ]);

        Mailing::create($data);

        return redirect()->route('mailings.index')
            ->with('success', 'Розсилка створена');
    }

    public function edit(Mailing $leadMessage)
    {
        return view('admin.mailings.edit', compact( 'leadMessage'));
    }

    public function update(Request $request, Mailing $leadMessage)  
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'scheduled_at' => 'nullable|date',
        ]);

        Mailing::update($data);

        return redirect()->route('mailings.index')->with('success', 'Повідомлення успішно оновлено!');
    
    }

    public function destroy(Mailing $leadMessage)
    {
        $leadMessage->delete();

        return redirect()->route('mailings.index')->with('success','Атрибут видалено');
    }

}


