<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\TeamMember;

class AboutController extends Controller
{
    public function index()
    {
        $company = Company::active()->first();
        $teamMembers = TeamMember::active()->ordered()->get();

        return view('about', compact('company', 'teamMembers'));
    }
}
