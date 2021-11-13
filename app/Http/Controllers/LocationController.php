<?php

namespace App\Http\Controllers;


use App\Models\Team;
use App\Models\Device;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $teamId = $user->current_team_id;
        $locations = Team::find($teamId)->locations->toTree();

        $list = collect([]);
        $traverse = function ($locations, $list, $prefix = '') use (&$traverse) {
            foreach ($locations as $location) {
                if (!($location->hidden == 1 && $location->user_id != Auth::user()->id)) {
                    $name = $prefix . ' ' . $location->name;
                    $id = $location->id;
                    $hidden = $location->hidden;
                    $user_id = $location->user_id;

                    $l = [
                        'name' => $name,
                        'id' => $id,
                        'hidden' => $hidden,
                        'user_id' => $user_id,
                    ];
                    $list->push($l);

                    $traverse($location->children, $list, $prefix . '-');
                }
            }
            return $list;
        };
        $list = $traverse($locations, $list);
        $locations = $list;
        return response()->json(['itemDescendant'=>$locations],200);
        // return response()->json(['itemDescendant' => Location::whereDescendantOf($id->id)->get()], 200);
    }

    public function create(Request $request)
    {

        $user = Auth::user();
        $request->validate([
            'name' => "required|string|unique:locations,name,NULL,id,team_id,$user->current_team_id,parent_id,$request->parent_id",
        ]);

        $parent = Location::find($request->parent_id);

        Location::create(
            [
                'name' => $request->name,
                'team_id' => $user->current_team_id,
                'user_id' => $user->id,
                'hidden' => 0,
            ],
            $parent
        );

        return redirect()->route('dashboard');
    }


    public function delete(Location $id)
    {
        $Location = $id;

        $Location->delete();

        return redirect()->route('dashboard');
    }

    public function edit(Request $request, Location $id)
    {
        $request = json_decode($request->getContent());

        $user = Auth::user();

        $request->validate([
            'name' => "required|string|unique:locations,name,$request->id,id,team_id,$user->current_team_id,parent_id,$request->parent_id",
        ]);

        $Location = $id;

        $Location->update([
            'name' => $request->name,
        ]);

        return response()->json([200]);
    }

    public function hidden(Location $id)
    {

        if ($id->hidden == 0) {
            $hidden = 1;
        } else {
            $hidden = 0;
        }

        $id->update([
            'hidden' => $hidden
        ]);

        return redirect('/');
    }
}
