<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\State;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRulesTest extends TestCase
{
    protected $state;
    protected $data;
    protected $user;

    use RefreshDatabase;

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
            'password'          => Hash::make('123456'),
            'remember_token'    => Str::random(10),
        ]);
    }

    /**
     * Dont Create User With Name Field Empty
     *
     * @return void
     */
    public function test_if_user_cannot_be_created_with_empty_name_field()
    {
        $this->actingAs($this->data);

        $user = [
            'state_id'          => $this->state->id,
            'name'              => '',
            'email'             => $this->user->email,
            'email_verified_at' => $this->user->email_verified_at,
            'password'          => $this->user->password,
            'remember_token'    => $this->user->remember_token,
        ];


        $this->post('/api/users', $user)->assertStatus(422)->assertSee('o campo name e obrigatorio');
    }

    /**
     * Dont Create User With Name Field Not Be String
     *
     * @return void
     */
    public function test_if_user_cannot_be_createed_with_field_name_not_being_a_string()
    {
        $this->actingAs($this->data);

        $user = [
            'state_id'          => $this->state->id,
            'name'              => fake()->boolean(),
            'email'             => $this->user->email,
            'email_verified_at' => $this->user->email_verified_at,
            'password'          => $this->user->password,
            'remember_token'    => $this->user->remember_token,
        ];

        $this->post('/api/users', $user)->assertStatus(422)->assertSee('o campo name tem que ser do tipo string');
    }

    /**
     * User Cannot Be Created With Name Field With More Than 255 Characters
     *
     * @return void
     */
    public function test_if_user_cannot_be_created_with_name_field_with_more_than_255_characters()
    {
        $this->actingAs($this->data);

        $user = [
            'state_id'          => $this->state->id,
            'name'              => 'ghgfbcvdfttyuplkhnjuiopikjhgfdrewq4587gffdfdddlpithhhgfd vfrtghnhjutredfkjutmjkpohnbgtrewqasdfghjklpmnbvcdsaqwertyuioplmbvcxzsadewrtgfdsawertyuioplkjhgfdsaqwertyuioplmnbvcxzasdfghytrewqasdfghyuioplkjhgfcvgfdertyuioplkmnbvcdsaqwertyuiopkmnbvcdsawerqqqqtyujnmbvcdf',
            'email'             => $this->user->email,
            'email_verified_at' => $this->user->email_verified_at,
            'password'          => $this->user->password,
            'remember_token'    => $this->user->remember_token,
        ];

        $this->post('/api/users', $user)->assertStatus(422)->assertSee('o campo name tem que ter no maximo 255 caracteres');
    }

    /**
     * User Cannot Be Created With Empty State Id Field
     *
     * @return void
     */
    public function test_if_user_cannot_be_created_with_empty_state_id_field()
    {
        $this->actingAs($this->data);

        $user = [
            'state_id'          => '',
            'name'              => $this->user->name,
            'email'             => $this->user->email,
            'email_verified_at' => $this->user->email_verified_at,
            'password'          => $this->user->password,
            'remember_token'    => $this->user->remember_token,
        ];

        $this->post('/api/users', $user)->assertStatus(422)->assertSee('o campo state_id e obrigatorio');
    }

    /**
     * User Cnnot Be Created With The State Id Field Not Being An Integer
     *
     * @return void
     */
    public function test_if_a_user_cannot_be_created_with_the_state_id_field_not_being_an_integer()
    {
        $this->actingAs($this->data);

        $user = [
            'state_id'          => fake()->word(),
            'email'             => $this->user->email,
            'email'             => $this->user->email,
            'email_verified_at' => $this->user->email_verified_at,
            'password'          => $this->user->password,
            'remember_token'    => $this->user->remember_token,
        ];

        $this->post('/api/users', $user)->assertStatus(422)->assertSee('o campo state_id tem que ser do tipo integer');
    }

    /**
     * User Cannot Be Created With Empty Email Field
     *
     * @return void
     */
    public function test_if_user_cannot_be_created_with_empty_email_field()
    {
        $this->actingAs($this->data);

        $user = [
            'state_id'          => $this->state->id,
            'name'              => $this->user->name,
            'email'             => '',
            'email_verified_at' => $this->user->email_verified_at,
            'password'          => $this->user->password,
            'remember_token'    => $this->user->remember_token,
        ];

        $this->post('/api/users', $user)->assertStatus(422)->assertSee('o campo email e obrigatorio');
    }

    /**
     * User Cannot Be Created With Email Field Not Being String
     *
     * @return void
     */
    public function test_if_user_cannot_be_created_with_email_field_not_being_string()
    {
        $this->actingAs($this->data);

        $user = [
            'state_id'          => $this->state->id,
            'name'              => $this->user->name,
            'email'             => fake()->boolean(),
            'email_verified_at' => $this->user->email_verified_at,
            'password'          => $this->user->password,
            'remember_token'    => $this->user->remember_token,
        ];

        $this->post('/api/users', $user)->assertStatus(422)->assertSee('o campo email tem que ser do tipo string', 'o campo email tem que ser do tipo email');
    }

    /**
     * User Cannot Be Created With Existing Email
     *
     * @return void
     */
    public function test_if_user_cannot_be_created_with_existing_email()
    {
        $this->actingAs($this->data);

        $this->post('/api/users', $this->data->toArray());

        $user = [
            'state_id'          => $this->state->id,
            'name'              => $this->user->name,
            'email'             => $this->data->email,
            'email_verified_at' => $this->user->email_verified_at,
            'password'          => $this->user->password,
            'remember_token'    => $this->user->remember_token,
        ];

        $this->post('/api/users', $user)->assertStatus(422)->assertSee('este email ja esta em uso, escolha outro');
    }

    /**
     * User Cannot Be Created With Empty Password Field
     *
     * @return void
     */
    public function test_if_user_cannot_be_created_with_empty_password_field()
    {
        $this->actingAs($this->data);

        $user = [
            'state_id'          => $this->state->id,
            'email'             => $this->user->email,
            'email'             => $this->user->email,
            'email_verified_at' => $this->user->email_verified_at,
            'password'          => '',
            'remember_token'    => $this->user->remember_token,
        ];

        $this->post('/api/users', $user)->assertStatus(422)->assertSee('o campo password e obrigatorio');
    }

    // /**
    //  * User Cannot Be Created Whith Password Field Less Than Six Characters
    //  *
    //  * @return void
    //  */
    // public function test_if_user_cannot_be_created_with_password_field_less_than_six_characters()
    // {
    //     $user = User::factory()->make([
    //         'state_id'          => $this->state->id,
    //         'name'              => fake()->name(),
    //         'email'             => fake()->unique()->safeEmail(),
    //         'email_verified_at' => now(),
    //         'password'          => 'abcd',
    //         'remember_token'    => Str::random(10),
    //     ]);

    //     $this->post('/api/users', $user->toArray())->assertStatus(422)->assertSee('o campo password tem que ter no minimo 6 caracteres');
    // }


    /**
     * Can Get a User That Not Exist
     *
     * @return void
     */
    public function test_that_it_cant_get_a_user_that_doesnt_exist()
    {
        $this->actingAs($this->data);

        $this->post('/api/users', $this->data->toArray());

        $id = 200;

        $this->get('/api/users/'.$id,)->assertStatus(422)->assertSee('Objeto nao encontrado na base de dados');
    }
}
