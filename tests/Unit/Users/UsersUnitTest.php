<?php

namespace Tests\Unit\Users;

use Tests\TestCase;
use App\Models\User;
use App\Models\State;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Olx\Users\Entities\UserEntity;
use App\Olx\Users\Services\UserService;
use App\Olx\Users\Repositories\UserRepository;



class UsersUnitTest extends TestCase
{
    protected $service;
    protected $user;
    protected $state;
    protected $data;

    /**
     * SetUp
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->service = New UserService(new UserRepository(new UserEntity()));

        $this->data = User::factory()->create();
        $this->state = State::factory()->create();
        $this->user = User::factory()->make([
            'state_id'          => $this->state->id,
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => Hash::make('12345'),
            'remember_token'    => Str::random(10),
        ]);
    }

    /**
     * Get ALL users
     *
     * @return void
     */
    public function test_if_can_get_all_users()
    {
        $all = $this->service->getAll();

        $this->assertCount(10, $all);
    }

    /**
     * Create a new user
     *
     * @return void
     */
    public function test_if_can_create_user()
    {
        $this->service->save($this->user->toArray());

        $this->assertDatabaseHas('users', ['name' => $this->user->name]);
    }

    /**
     * Find a user
     *
     * @return void
     */
    public function test_if_can_find_user()
    {
        $find = $this->service->find($this->data->id);

        $this->assertSame($find->id, $this->data->id);
    }

    /**
     * Update a user
     *
     * @return void
     */
    public function test_if_can_update_user()
    {
        $user = $this->data;

        $this->service->update($user->id, ['name' => 'name modificado']);

        $user = $user->fresh();

        $this->assertEquals('name modificado', $user->name);
    }

    /**
     * Delete a user
     *
     * @return void
     */
    public function test_if_can_delete_user()
    {
        $this->service->delete($this->data->id);

        $this->assertDatabaseMissing('users', $this->data->toArray());
    }
}
