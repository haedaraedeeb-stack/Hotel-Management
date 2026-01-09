<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Models\RoomType;

class ServiceController extends Controller
{
    public const PERMISSIONS = [
        'view'=> 'view services',
        'create'=> 'create services',
        'edit'=> 'edit services',
        'delete'=>'delete services',
        'trash'=> 'view services trash',
        'restore'=> 'restore services',
        'forceDelete' => 'force delete services',
    ];

    public function __construct()
    {
        $this->middleware('permission:' . self::PERMISSIONS['view'])->only(['index']);
        $this->middleware('permission:' . self::PERMISSIONS['create'])->only(['create', 'store']);
        $this->middleware('permission:' . self::PERMISSIONS['edit']) ->only(['edit', 'update']);
        $this->middleware('permission:' . self::PERMISSIONS['delete'])->only(['destroy']);
        $this->middleware('permission:' . self::PERMISSIONS['trash'])->only(['trash']);
        $this->middleware('permission:' . self::PERMISSIONS['restore'])->only(['restore']);
        $this->middleware('permission:' . self::PERMISSIONS['forceDelete'])->only(['forceDelete']);
    }

    public function index()
    {
        $services = Service::with('roomTypes')->latest()->get();
        return view('serv.index', compact('services'));
    }

    public function create()
    {
        $roomTypes = RoomType::all();
        return view('serv.create', compact('roomTypes'));
    }

    public function store(StoreServiceRequest $request)
    {
        $service = Service::create($request->only(['name', 'description']));

        if ($request->filled('room_types')) {
            $service->roomTypes()->sync($request->room_types);
        }

        return redirect()->route('serv.index')
            ->with('success', 'The service has been created successfully');
    }

    public function edit(Service $service)
    {
        $roomTypes = RoomType::all();
        $service->load('roomTypes');

        return view('serv.edit', compact('service', 'roomTypes'));
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->update($request->only(['name', 'description']));

        if ($request->has('room_types')) {
            $service->roomTypes()->sync($request->room_types);
        } else {
            $service->roomTypes()->detach();
        }

        return redirect()->route('serv.index')
            ->with('success', 'The service has been edited successfully');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('serv.index')
            ->with('success', 'The service has been moved to the trash');
    }

    public function trash()
    {
        $services = Service::onlyTrashed()->get();
        return view('serv.trash', compact('services'));
    }

    public function restore($id)
    {
        Service::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('serv.trash')
            ->with('success', 'The service has been restored');
    }

    public function forceDelete($id)
    {
        Service::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('serv.trash')
            ->with('success', 'The service has been permanently deleted');
    }
}