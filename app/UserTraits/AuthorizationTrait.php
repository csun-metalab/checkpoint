<?php

namespace App\UserTraits;

// Models
use App\User;
use App\Models\TimeLog;

// Exception
use Illuminate\Auth\Access\AuthorizationException;
use App\Exceptions\AuthExceptions\UnauthorizedUser;
use App\Models\Project;
use App\Models\Organization;

trait AuthorizationTrait
{
    public function isRole($role)
    {
        return $this->role->contains('name', $role);
    }

    public function getOrganizationIdAuthorizeAdmin()
    {
        if (!$this->isRole('Admin')) throw new UnauthorizedUser('Admin');
        return $this->organization_id;
    }

    public function getOrganizationIdAuthorizeStudent()
    {
        if (!$this->isRole('Student')) throw new UnauthorizedUser('Student');
        return $this->organization_id;
    }

    public function getOrganizationIdAuthorizeMentor()
    {
        if (!$this->isRole('Mentor')) throw new UnauthorizedUser('Mentor');
        return $this->organization_id;
    }

    public function authorizeTimeLog(TimeLog $timeLog)
    {
        $inCorrectUser = ($this->id !== $timeLog->user_id);
        $inCorrectOrganization = ($this->organization_id !== $timeLog->organization_id);

        if ($inCorrectUser || $inCorrectOrganization)  throw new AuthorizationException();

        return true;
    }

    public function authorizeProject(Project $project)
    {
        if ($this->organization_id !== $project->organization_id) throw new AuthorizationException();
        return true;
    }
}