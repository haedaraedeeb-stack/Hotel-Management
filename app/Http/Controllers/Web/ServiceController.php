<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Models\RoomType;
use App\Services\ServicelayerServices;

/**
 * This controller manages service-related web requests,
 * including listing, creating, updating, showing, and deleting services.
 * Class ServiceController
 * @package App\Http\Controllers\Web
 */
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

    /**
     * ServiceController constructor.
     * Summary of __construct
     * @param ServicelayerServices $serviceLayer
     */
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

    /**
     * Display a listing of services.
     * Summary of index
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $services = $this->serviceLayer->getAll();
        return view('serv.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     * Summary of create
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roomTypes = RoomType::all();
        return view('serv.create', compact('roomTypes'));
    }

    /**
     * Store a newly created service in storage.
     * Summary of store
     * @param StoreServiceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreServiceRequest $request)
    {
        $this->serviceLayer->create($request->only(['name', 'description', 'room_types']));

        return redirect()->route('serv.index')
            ->with('success', 'The service has been created successfully');
    }

    /**
     * Show the form for editing the specified service.
     * Summary of show
     * @param Service $service
     * @return \Illuminate\View\View
     */
    public function edit(Service $service)
    {
        $roomTypes = RoomType::all();
        $service->load('roomTypes');

        return view('serv.edit', compact('service', 'roomTypes'));
    }

    /**
     * Update the specified service in storage.
     * Summary of update
     * @param UpdateServiceRequest $request
     * @param Service $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $this->serviceLayer->update($service, $request->only(['name', 'description', 'room_types']));

        return redirect()->route('serv.index')
            ->with('success', 'The service has been edited successfully');
    }

    /**
     * Remove the specified service from storage.
     * Summary of destroy
     * @param Service $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Service $service)
    {
        $this->serviceLayer->delete($service);

        return redirect()->route('serv.index')
            ->with('success', 'The service has been moved to the trash');
    }

    /**
     * Display a listing of trashed services.
     * Summary of trash
     * @return \Illuminate\View\View
     */
    public function trash()
    {
        $services = $this->serviceLayer->getTrashed();
        return view('serv.trash', compact('services'));
    }

    /**
     * Restore the specified trashed service.
     * Summary of restore
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $this->serviceLayer->restore($id);

        return redirect()->route('serv.trash')
            ->with('success', 'The service has been restored');
    }

    /**
     * Permanently delete the specified trashed service.
     * Summary of forceDelete
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id)
    {
        $this->serviceLayer->forceDelete($id);

        return redirect()->route('serv.trash')
            ->with('success', 'The service has been permanently deleted');
    }
}