<?php

namespace Vanguard\Http\Controllers\Web;

use Vanguard\Http\Controllers\Controller;
use Vanguard\Models\Group;

class ListStartupsController extends Controller
{
    public function index()
    {
        // Fetch all groups with their associated students and user, sorted by user_id
        $registrations = Group::with(['students', 'user']) // Load the user relationship
            ->orderBy('user_id') // Sort by user_id
            ->get();

        // Load the view to display the registrations
        return view('user.ListStartups', compact('registrations'));
    }
}
