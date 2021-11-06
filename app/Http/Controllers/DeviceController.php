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
        return Inertia::render('Dashboard');
    }

    public function show(Request $request)
    {
        $request = json_decode($request->getContent());

        $locations = Location::whereDescendantAndSelf($request->id);
        $Devices = collect([]);
        foreach ($locations as $location) {
            $d = Device::where('location_id', '=', $location->id);
            $Devices->push($d);
        }
        $devices = $Devices->toArray();

        return response()->json(['devices' => $devices, 200]);
    }

    public function create(Request $request)
    {
        $request = json_decode($request->getContent());
        $user = Auth::user();

        $request->validate([
            'name' => "required|string|unique:devices,name,NULL,id,location_id,$request->location_id",
            'body' => "nullable|string",
            'location_id' => 'required,numeric',
        ]);

        Device::create([
            'name' => $request->name,
            'body' => $request->body,
            'user' => $user->id,
            'location_id' => $request->location_id,
            'hidden' => $request->hidden,
        ]);

        return response()->json([200]);
    }

    public function delete(Request $request)
    {
        $request = json_decode($request->getContent());

        Device::find($request->id)->delete();

        return response()->json([200]);
    }

    public function edit(Request $request)
    {
        $request = json_decode($request->getContent());

        $request->validate([
            'name' => "required|string|unique:devices,name,$request->id,id,location_id,$request->location_id",
            'body' => "nullable|string",
        ]);

        Device::find($request->id)->update([
            'name' => $request->name,
            'body' => $request->body,
            'hidden' => $request->hidden,
        ]);
    }
}
