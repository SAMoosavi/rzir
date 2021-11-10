<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::paginate(10)->toArray();
        $locations = Location::where('parent_id', '=', NULL)->get();

        return Inertia::render('Dashboard', [
            'devices' => $devices,
            'locations' => $locations,
        ]);
    }

    public function show(Location $id)
    {
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
