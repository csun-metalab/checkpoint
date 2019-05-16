<?php

namespace App\Http\Controllers;

// Auth
use Illuminate\Support\Facades\Auth;

// Controllers
use App\Http\Controllers\Controller;

// Domain Value Objects
use App\DomainValueObjects\Location\Address;

// Requests
use App\Http\Requests\LocationRequest;

// Contract
use App\Contracts\LocationContract;

// Models
use App\Models\Project;

class LocationController extends Controller
{
    protected $locationUtility;

    public function __construct(LocationContract $locationContract)
    {
        $this->locationUtility = $locationContract;
    }

    public function update(LocationRequest $request, Project $project = null)
    {
        $user = Auth::user();
        $organizationId = $user->getOrganizationIdAuthorizeAdmin();
        $longitude = $request['longitude'];
        $latitude = $request['latitude'];
        $radius = $request['radius'];

        $address = new Address(
            $request['address_number'],
            $request['street'],
            $request['city'],
            $request['state'],
            $request['zip']
        );

        if ($project == null) {
            return $this->locationUtility->update($address, $longitude, $latitude, $radius, $organizationId);
        } else {
            $user->authorizeProject($project);
            return $this->locationUtility->update($address, $longitude, $latitude, $radius, $project->id);
        }
    }
}
