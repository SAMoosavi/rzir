<?php

namespace App\Http\Controllers;


use App\Models\Device;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function show(Request $request)
    {
        $request = json_decode($request->getContent());

        return response()->json(['itemDescendant' => Location::whereDescendantOf($request->id)->get(), 200]);
    }

    public function create(Request $request)
    {
        $request = json_decode($request->getContent());
        $user = Auth::user();

        $request->validate([
            'name' => "required|string|unique:locations,name,NULL,id,team_id,$user->current_team_id,parent_id,$request->parent_id",
            'parent_id' => 'nullable,numeric',
        ]);

        $parent = Location::find($request->parent_id);

        Location::create(
            [
                'name' => $request->name,
                'team_id' => $user->current_team_id,
                'user_id' => $user->id,
                'hidden' => $request->hidde,
            ],
            $parent
        );

        return response()->json([200]);
    }

    public function delete(Request $request)
    {
        $request = json_decode($request->getContent());

        Location::find($request->id)->delete();

        return response()->json([200]);
    }

    public function edit(Request $request)
    {
        $request = json_decode($request->getContent());

        $user = Auth::user();

        $request->validate([
            'name' => "required|string|unique:locations,name,$request->id,id,team_id,$user->current_team_id,parent_id,$request->parent_id",
        ]);

        Location::find($request->id)->update([
            'name' => $request->name,
            'hidden' => $request->hidden,
        ]);

        return response()->json([200]);
    }
}
