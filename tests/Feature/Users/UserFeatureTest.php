<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use App\Models\User;
use App\Models\State;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected $data;
    protected $user;
    protected $state;

    /**
     * SetUp
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->state = State::factory()->create();
        $this->data = User::factory()->create();
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
     * Index User
     *
     * @return void
     */
    public function test_index_user()
    {
        $this->post('/api/users', $this->user->toArray());

        $this->get('/api/users')->assertStatus(200);
        $this->get('/api/users')->assertSee($this->user->name);
    }

    /**
     * Store a user
     *
     * @return void
     */
    public function test_store_user()
    {
        $this->post('/api/users', $this->user->toArray())->assertStatus(200);
        
        $this->assertDatabaseHas('users', ['name' => $this->user->name]);
    }

    /**
     * Show a User
     *
     * @return void
     */
    public function test_show_user()
    {
        $this->post('/api/users', $this->data->toArray());

        $id = $this->data->id;

        $expected = $this->data->name;

        $this->get('/api/users/'.$id)->assertSee($expected);
    }

    /**
     * Update a User
     *
     * @return void
     */
    public function test_update_user()
    {
        $user = $this->data;

        $updatedData = [
            'name' => 'Novo Nome',
            'email' => 'novoemail@example.com',
        ];

        $this->put('/api/users/'.$user->id, $updatedData)->assertStatus(200);

        $user->refresh();

        $this->get('/api/users/'.$user->id)->assertSee('Novo Nome', 'novoemail@example.com');
    }

    /**
     * Delete a User
     *
     * @return void
     */
    public function test_delete_user()
    {
        $this->post('/api/users', $this->data->toArray());

        $this->delete('/api/users/'.$this->data->id)->assertStatus(200);

        $this->assertDatabaseMissing('users', $this->data->toArray());
    }
}
