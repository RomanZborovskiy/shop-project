<?php

namespace App\Http\admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Spatie\Permission\Models\Role;


class LeadController extends Controller
{   
    public function index()
    {
        $leads = Lead::paginate(10);

        return view('admin.leads.index', compact('leads' ));
    }

}
