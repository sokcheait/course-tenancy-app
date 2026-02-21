<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DomainController extends Controller
{
    public function index()
    {
        $domains = Domain::with('tenant')->paginate(10);
        return Inertia::render('Domains/Index', compact('domains'));
    }

    public function create()
    {
        $tenants = Tenant::all();
        return Inertia::render('Domains/Create',['tenants'=>$tenants]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
        ]);
        $tenant = Tenant::create($request->all());
        $tenant->createDomain([
            'domain' => $request->company_name.'.'.env("APP_CENTRAL"),
        ]);

        return redirect()->route('admin.domains.create')->with('success', 'Domain created!');
    }

    public function show()
    {

    }
}
