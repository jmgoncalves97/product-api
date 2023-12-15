<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->M = Group::class;
    }

    public function store(Request $request)
    {
        try {
            $group = new Group;
            $group->name = $request->input('name');
            $group->description = $request->input('description');
            $group->save();
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }

        return response()->json($group);
    }
}
