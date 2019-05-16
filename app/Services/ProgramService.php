<?php
namespace App\Services;

use \Illuminate\Support\Facades\DB;

// Domain Value Objects
use App\DomainValueObjects\UUIDGenerator\UUID;

//Models
use App\Models\Project;

//Exceptions

//Contracts
use App\Contracts\ProgramContract;


class ProgramService implements ProgramContract
{
    private function generateName($displayName)
    {
        $name = preg_replace("/[^a-z0-9_-\s]+/i", "", $displayName);
        return strtolower($name);
    }

    public function create($organizationId, $displayName)
    {
        $name = $this->generateName($displayName);

        $projectId = UUID::generate();

        try {
            $project = Project::create([
                'id' => $projectId,
                'organization_id' => $organizationId,
                'name' => $name,
                'display_name' => $displayName,
            ]);
        } catch (\Exception $e) { // Handles duplicate
            throw $e;
        }

        return $project;
    }

    public function all($organizationId)
    {
        try {
            return Project::with('location')->get();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function update($program, $displayName)
    {
        $name = $this->generateName($displayName);

        return DB::transaction(function () use ($program, $displayName, $name) {
            try {
                $program->display_name = $displayName;
                $program->name = $name;
                $program->save();
            } catch (\Exception $e) {
                throw $e;
            }
            return $program;
        });
    }

    public function delete($program)
    {
        try {
            $program->delete();
        } catch (\Exception $e) {
            throw $e;
        }
        return ['message' => 'Program was deleted.'];
    }
}