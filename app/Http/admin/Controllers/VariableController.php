<?php

namespace App\Http\admin\Controllers;

use App\Http\admin\Requests\VariableRequest;
use App\Http\Controllers\Controller;
use Fomvasss\Variable\Models\Variable;

class VariableController extends Controller
{   
    public function index()
    {
        $variables = Variable::orderBy('key')->paginate(20);
        return view('admin.variables.index', compact('variables'));
    }

    public function create()
    {
        return view('admin.variables.create');
    }

    public function store(VariableRequest $request)
    {
        Variable::create($request->validated());

        return redirect()->route('variables.index')->with('success', 'Variable created');
    }

    public function edit(Variable $variable)
    {
        return view('admin.variables.edit', compact('variable'));
    }

    public function update(VariableRequest $request, Variable $variable)
    {
        $variable->update($request->validated());

        return redirect()->route('variables.edit')->with('success', 'Variable updated');
    }

    public function destroy(Variable $variable)
    {
        $variable->delete();
        return redirect()->route('variables.index')->with('success', 'Variable deleted');
    }

}
