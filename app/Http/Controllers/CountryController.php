<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Country;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('admin.countries.index');
        $search = $request->search;
        $countries = Country::query()
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
        $view = "Country/Index";
        return Inertia::render($view,[
            "countries" => $countries,
            'meta' => [
                'current_page' => $countries->currentPage(),
                'last_page' => $countries->lastPage(),
                'total' => $countries->total(),
                'from' => $countries->firstItem(),
                'to' => $countries->lastItem(),
            ],
            'filters' => [
                'search' => $search
            ]
        ]);

    }
}
