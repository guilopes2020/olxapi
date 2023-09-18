<?php

namespace Tests\Feature\State;

use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StateRulesTest extends TestCase
{
    protected $data;
    protected $state;
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

        $this->user = User::factory()->create();
        $this->data = State::factory()->create();

        $states = [
            'Acre',
            'Alagoas',
            'Amapa',
            'Amazonas',
            'Bahia',
            'Ceara',
            'Distrito Federal',
            'Espirito Santo',
            'Goias',
            'Maranhao',
            'Mato Grosso',
            'Mato Grosso do Sul',
            'Minas Gerais',
            'Para',
            'Paraiba',
            'Parana',
            'Pernambuco',
            'Piaui',
            'Rio de Janeiro',
            'Rio Grande do Norte',
            'Rio Grande do Sul',
            'Rondonia',
            'Roraima',
            'Santa Catarina',
            'Sao Paulo',
            'Sergipe',
            'Tocantins',
        ];

        $this->state = State::factory()->make([
            'name' => fake()->randomElement($states),
            'slug' => fake()->slug(),
        ]);
    }

    /**
     * Doesnt Let Create State With Empty Name Empty
     *
     * @return void
     */
    public function test_that_you_cant_let_create_state_with_name_field_empty()
    {
        $this->actingAs($this->user);

        $state = [
            'name' => '',
            'slug' => $this->state->slug,
        ];

        $this->post('/api/states', $state)->assertStatus(422)->assertSee('o campo name e obrigatorio');
    }

    /**
     * Can't Let Create State With The Name Field Without Being a String
     *
     * @return void
     */
    public function test_that_you_cant_let_create_state_with_the_name_field_without_being_a_string()
    {
        $this->actingAs($this->user);

        $this->actingAs($this->user);

        $state = [
            'name' => random_int(1, 100),
            'slug' => $this->state->slug,
        ];

        $this->post('/api/states', $state)->assertStatus(422)->assertSee('o campo name tem que ser do tipo string');
    }

    /**
     * Not Can Create State With Empty Slug Field
     *
     * @return void
     */
    public function test_not_can_create_state_with_empty_slug_field()
    {
        $this->actingAs($this->user);

        $state = [
            'name' => $this->state->name,
            'slug' => '',
        ];

        $this->post('/api/states', $state)->assertStatus(422)->assertSee('o campo slug e obrigatorio');
    }

    /**
     * Cannot Create State With The Slug Field Without Being Of Type String
     *
     * @return void
     */
    public function test_that_cannot_create_state_with_slug_field_without_being_of_type_string()
    {
        $this->actingAs($this->user);

        $state = [
            'name' => $this->state->name,
            'slug' => fake()->boolean(),
        ];

        $this->post('/api/states', $state)->assertStatus(422)->assertSee('o campo slug tem que ser do tipo string');
    }
}
