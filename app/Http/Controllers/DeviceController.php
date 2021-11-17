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
            if (!($device->hidden == 1 && $device->user_id != Auth::user()->id)) {
                $loctions = Location::whereAncestorOrSelf($device->location_id)->get();

                $l = '';
                $hidden = false;
                foreach ($loctions as $location) {
                    if ($location->user_id != Auth::user()->id) {
                        if ($location->hidden) {
                            $hidden = true;
                        }
                    }
                    $l = "$l $location->name";
                }
                if (!$hidden) {
                    $d->push([
                        'id' => $device->id,
                        'name' => $device->name,
                        'location' => $l,
                        'location_id' => $device->location_id,
                        'hidden' => $device->hidden,
                        'user_id' => $device->user_id,
                    ]);
                }
            }
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
                    foreach ($this->showDevice($d) as $de) {
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

    public function rename(Request $request, Device $id)
    {
        $device = $id;

        $request->validate([
            'name' => "required|string|unique:devices,name,$device->id,id,location_id,$device->location_id",
        ]);


        $device->update([
            'name' => $request->name,
        ]);

        return redirect('/');
    }

    public function hidden(Device $id)
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
