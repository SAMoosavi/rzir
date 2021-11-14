<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Location;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DeviceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // $teamId = $user->current_team_id;
        // $devices = Team::find($teamId)->devices->toArray();
        // $locations = Team::find($teamId)->locations->where('parent_id', '=', NULL)->toArray();

        $userId = $user->id;

        return Inertia::render('Dashboard', [
            'userId' => $userId,
        ]);
    }

    public function show($id)
    {
        if ($id) {
            $locations = Location::whereDescendantOrSelf($id)->get();
            $Devices = collect([]);
            foreach ($locations as $location) {
                $d = Device::where('location_id', '=', $location->id)->get();
                if ($d->count() != 0) {
                    $Devices->push($d);
                }
            }
            $devices = $Devices->toArray();
            if ($Devices->count() != 0) {
                $devices = $devices[0];
            }
        } else {
            $user = Auth::user();
            $teamId = $user->current_team_id;
            $devices = Team::find($teamId)->devices->toArray();
        }

        return response()->json(['devices' => $devices], 200);
    }

    public function create(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => "required|string|unique:devices,name,NULL,id,location_id,$request->location_id",
            'location_id' => 'required',
        ]);

        Device::create([
            'name' => $request->name,
            'user_id' => $user->id,
            'location_id' => $request->location_id,
            'hidden' => 0,
        ]);


        return redirect()->route('dashboard');
    }

    public function delete($id)
    {
        $device = $id;

        $device->delete();

        return response()->json([200]);
    }

    public function edit(Request $request, Device $id)
    {
        $request = json_decode($request->getContent());

        $request->validate([
            'name' => "required|string|unique:devices,name,$request->id,id,location_id,$request->location_id",
            'body' => "nullable|string",
        ]);

        $device = $id;

        $device->update([
            'name' => $request->name,
            'body' => $request->body,
            'hidden' => $request->hidden,
        ]);
    }
}
