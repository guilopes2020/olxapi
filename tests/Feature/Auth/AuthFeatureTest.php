<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Models\State;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected $state;
    protected $user;
    protected $payload;

    /**
     * SetUp
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->state = State::factory()->create();

        $this->user = User::factory()->create();

        $this->payload = [
            'name'              => fake()->name(),
            'email'             => fake()->email(),
            'password'          => Hash::make('123456'),
            'state_id'          => $this->state->id,
            'email_verified_at' => now(),
            'remember_token'    => Str::random(10),
        ];
    }

    /**
     * Register User
     *
     * @return void
     */
    public function test_register_user()
    {
        $this->post('/api/register', $this->payload)->assertStatus(201)->assertSee('usuario cadastrado e logado com sucesso');
    }

    /**
     * Login User
     *
     * @return void
     */
    public function test_login_user()
    {
        $this->post('/api/register', $this->payload);

        $this->post('/api/login', ['email' => $this->payload['email'], 'password' => '123456']);
        $this->assertAuthenticated();
    }

    /**
     * Logout User
     *
     * @return void
     */
    public function test_logout_user()
    {
        $this->post('/api/register', $this->payload);
        $this->post('/api/login', ['email' => $this->payload['email'], 'password' => '123456']);

        $this->post('/api/logout')->assertStatus(200);
        $this->assertAuthenticated(false);
    }

    /**
     * User Unnauthorized
     *
     * @return void
     */
    public function test_user_unnauthorized()
    {
        $this->post('/api/states', $this->state->toArray())->assertRedirect('/api/unnauthorized')->assertRedirectToRoute('login');
    }
}
