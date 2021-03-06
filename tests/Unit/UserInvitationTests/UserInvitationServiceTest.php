<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Exceptions\UserInvitationExceptions\UserAlreadyRegistered;

use App\Services\UserInvitationService;
use App\Services\RegisterService;


use App\User;
use App\Models\Organization;
use App\Models\Role;
use \App\Models\UserInvitation;
use App\Http\Controllers\RegisterController;
use App\Http\Requests\Auth\RegisterRequest;

class UserInvitationServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $service;
    private $user;
    private $role;
    private $classPath = 'App\Services\UserInvitationService';


    public function setUp()
    {
        parent::setUp();
        $this->service = new UserInvitationService();
        $this->seed('TimeCalculatorTypeSeeder');
        $this->seed('PayPeriodTypeSeeder');
        $this->seed('OrganizationSeeder'); //seeds org and settings
        $this->seed('CategorySeeder');
        $this->seed('RoleSeeder');
        $this->seed('UsersTableSeeder');
        $this->seed('ProgramSeeder'); // seeds also UserProgram table
        $this->seed('LocationSeeder');
        $this->seed('UserInvitationsTableSeeder');
        $this->user = User::first();
        $this->role = Role::where('name', 'Employee')->first();
        $this->actingAs($this->user);
    }

    /**
     * User Invitation Service
     *
     * @return json
     */
    public function test_user_invitation_service()
    {
        $orgId = Organization::all()->random()->id;
        $name = "John Goober";
        $email = "j0hNGewB3r@email.com";
        $roleId = $this->role->id;

        $response = $this->service->inviteNewUser($orgId, $roleId, $name, $email);

        $this->assertArrayHasKey('email', $response);
    }

    public function test_user_invite_service_deletes_row_same_email()
    {
        $orgId = Organization::all()->random()->id;
        $name = 'John Booger';
        $email = 'tony@tony.com';
        // TODO: Tony - grabbing from roles table not working for some reason
        $roleId = $this->role->id;

        $response = $this->service->inviteNewUser($orgId, $roleId, $name, $email);

        $previousInviteCode = UserInvitation::where('email', $email)->first()['invite_code'];

        $response = $this->service->inviteNewUser($orgId, $roleId, $name, $email);

        $newInviteCode = UserInvitation::where('email', $email)->first()['invite_code'];

        $this->assertNull(UserInvitation::where('invite_code', $previousInviteCode)->first());

        $this->assertNotEquals($previousInviteCode, $newInviteCode);
    }

    public function test_user_invite_service_throws_error_registered_email()
    {
        $userInvitation = UserInvitation::all()->random();

        $name = $userInvitation->name;
        $email = $userInvitation->email;
        $password = "secret";
        $inviteCode = $userInvitation->invite_code;
        $roleId = $userInvitation->role_id;
        $orgId = $userInvitation->organization_id;

        $input['name'] = $name;
        $input['email'] = $email;
        $input['password'] = $password;
        $input['password_confirmation'] = $password;
        $input['invitation_code'] = $inviteCode;

        $response = $this->json('POST', "/api/register", $input);

        $this->expectException('App\Exceptions\UserInvitationExceptions\UserAlreadyRegistered');
        $response = $this->service->inviteNewUser($orgId, $roleId, $name, $email);
    }
}
