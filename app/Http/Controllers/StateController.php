<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Country;
use App\Models\State;

class StateController extends Controller
{
    public function index()
    {
        $this->authorize('admin.states.index');
        $states = app(State::class)->with('country')->paginate(10);
        $view = "State/Index";
        return Inertia::render($view,[
            "states" => $states,
            'meta' => [
                'current_page' => $states->currentPage(),
                'last_page' => $states->lastPage(),
                'total' => $states->total(),
                'from' => $states->firstItem(),
                'to' => $states->lastItem(),
            ],
        ]);

    }
}
