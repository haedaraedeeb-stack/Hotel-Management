<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Models\RoomType;
use App\Services\ServicelayerServices;

class ServiceController extends Controller
{
    protected $serviceLayer;

    public const PERMISSIONS = [
        'view'=> 'view services',
        'create'=> 'create services',
        'edit'=> 'edit services',
        'delete'=>'delete services',
        'trash'=> 'view services trash',
        'restore'=> 'restore services',
        'forceDelete' => 'force delete services',
    ];

    public function __construct(ServicelayerServices $serviceLayer)
    {
        $this->serviceLayer = $serviceLayer;

        $this->middleware('permission:' . self::PERMISSIONS['view'])->only(['index']);
        $this->middleware('permission:' . self::PERMISSIONS['create'])->only(['create', 'store']);
        $this->middleware('permission:' . self::PERMISSIONS['edit'])->only(['edit', 'update']);
        $this->middleware('permission:' . self::PERMISSIONS['delete'])->only(['destroy']);
        $this->middleware('permission:' . self::PERMISSIONS['trash'])->only(['trash']);
        $this->middleware('permission:' . self::PERMISSIONS['restore'])->only(['restore']);
        $this->middleware('permission:' . self::PERMISSIONS['forceDelete'])->only(['forceDelete']);
    }

    public function index()
    {
        $services = $this->serviceLayer->getAll();
        return view('serv.index', compact('services'));
    }

    public function create()
    {
        $roomTypes = RoomType::all();
        return view('serv.create', compact('roomTypes'));
    }

    public function store(StoreServiceRequest $request)
    {
        $this->serviceLayer->create($request->only(['name', 'description', 'room_types']));

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
        $this->serviceLayer->update($service, $request->only(['name', 'description', 'room_types']));

        return redirect()->route('serv.index')
            ->with('success', 'The service has been edited successfully');
    }

    public function destroy(Service $service)
    {
        $this->serviceLayer->delete($service);

        return redirect()->route('serv.index')
            ->with('success', 'The service has been moved to the trash');
    }

    public function trash()
    {
        $services = $this->serviceLayer->getTrashed();
        return view('serv.trash', compact('services'));
    }

    public function restore($id)
    {
        $this->serviceLayer->restore($id);

        return redirect()->route('serv.trash')
            ->with('success', 'The service has been restored');
    }

    public function forceDelete($id)
    {
        $this->serviceLayer->forceDelete($id);

        return redirect()->route('serv.trash')
            ->with('success', 'The service has been permanently deleted');
    }
}