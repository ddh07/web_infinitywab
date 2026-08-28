<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeamMemberRequest;
use App\Models\TeamMember;

class TeamMemberController extends Controller
{
    public function index()
    {
        $members = TeamMember::orderBy('order')->get();
        return response()->json($members);
    }

    public function store(TeamMemberRequest $request)
    {
        $member = TeamMember::create($request->validated());
        return response()->json($member, 201);
    }

    public function show($id)
    {
        $member = TeamMember::findOrFail($id);
        return response()->json($member);
    }

    public function update(TeamMemberRequest $request, $id)
    {
        $member = TeamMember::findOrFail($id);
        $member->update($request->validated());
        return response()->json($member);
    }

    public function destroy($id)
    {
        $member = TeamMember::findOrFail($id);
        $member->delete();
        return response()->json(['message' => 'Team member deleted successfully']);
    }
}
