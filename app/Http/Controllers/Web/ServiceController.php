<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Models\RoomType;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('roomTypes')->latest()->get();
        return view('services.index', compact('services'));
    }

    public function create()
    {
        $roomTypes = RoomType::all();
        return view('services.create', compact('roomTypes'));
    }

    public function store(StoreServiceRequest $request)
    {
        $service = Service::create($request->only([
            'name',
            'description'
        ]));

        if ($request->filled('room_types')) {
            $service->roomTypes()->sync($request->room_types);
        }

        return redirect()->route('services.index')
            ->with('success', ' The service has been created successfully  ');
    }

    public function edit(Service $service)
    {
        $roomTypes = RoomType::all();
        $service->load('roomTypes');

        return view('services.edit', compact('service', 'roomTypes'));
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->update($request->only([
            'name',
            'description'
        ]));

        if ($request->has('room_types')) {
            $service->roomTypes()->sync($request->room_types);
        } else {
            $service->roomTypes()->detach();
        }

        return redirect()->route('services.index')
            ->with('success', 'The service has been edited successfully   ');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index')
            ->with('success', 'The service has been moved to the trash');
    }

    public function trash()
    {
        $services = Service::onlyTrashed()->get();
        return view('services.trash', compact('services'));
    }

    public function restore($id)
    {
        Service::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('services.trash')
            ->with('success', 'service has been restored');
    }

    public function forceDelete($id)
    {
        Service::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('services.trash')
            ->with('success', 'The service has been permanently deleted ');
    }
}