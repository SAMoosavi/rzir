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

    public function showDevice($devices)
    {
        $d = collect([]);
        foreach ($devices as $device) {
            //get location of device
            $loctions = Location::whereAncestorOrSelf($device->location_id)->get();

            $l = '';
            foreach ($loctions as $loction) {
                $l = "$l $loction->name";
            }

            $d->push([
                'id' => $device->id,
                'name' => $device->name,
                'location' => $l,
                'location_id' => $device->location_id,
                'hidden' => $device->hidden,
                'user_id' => $device->user_id,
            ]);
        }
        return $d;
    }

    public function show($id)
    {
        if ($id) {
            $locations = Location::whereDescendantOrSelf($id)->get();
            $Devices = collect([]);
            foreach ($locations as $location) {
                $d = Device::where('location_id', '=', $location->id)->get();
                if ($d->count() != 0) {
                    foreach($this->showDevice($d) as $de){
                        $Devices->push($de);
                    }
                }
            }
            $devices = $Devices->sortBy('name')->values()->all();
        } else {
            $user = Auth::user();
            $teamId = $user->current_team_id;
            $devices = Team::find($teamId)->devices->sortBy('name')->values()->all();
            $devices = $this->showDevice($devices)->toArray();
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

    public function delete(Device $id)
    {
        $device = $id;

        $device->delete();

        return redirect()->route('dashboard');
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
