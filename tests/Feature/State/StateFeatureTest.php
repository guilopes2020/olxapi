<?php

namespace Tests\Feature\State;

use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Provider\pt_BR\Address;
use Tests\TestCase;

class StateFeatureTest extends TestCase
{
    protected $data;
    protected $state;

    use RefreshDatabase;

    /**
     * SetUp
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->data = State::factory()->create();
        $this->state = State::factory()->make([
            'name' => Address::state(),
            'slug' => fake()->slug(),
        ]);
    }

    /**
     * Index State
     *
     * @return void
     */
    public function test_index_state()
    {
        $this->post('/api/states', $this->state->toArray());

        $this->get('/api/states')->assertStatus(200);

        $this->get('/api/states')->assertSee($this->state->name);
    }

    /**
     * Store State
     *
     * @return void
     */
    public function test_store_state()
    {
        $this->post('/api/states', $this->state->toArray())->assertStatus(200);

        $this->assertDatabaseHas('states', $this->state->toArray());
    }

    /**
     * Show State
     *
     * @return void
     */
    public function test_show_state()
    {
        $this->post('/api/states', $this->data->toArray());

        $id = $this->data->id;

        $expected = $this->data->name;

        $this->get('/api/states/'.$id)->assertSee($expected);

    }

    /**
     * Update State
     *
     * @return void
     */
    public function test_update_state()
    {
        $state = $this->data;

        $updateData = [
            'name' => 'state updated',
            'slug' => 'slug updated',
        ];

        $this->put('/api/states/'.$state->id, $updateData)->assertStatus(200);

        $state->refresh();

        $this->get('/api/states/'.$state->id)->assertSee('state updated', 'slug updated');
    }

    /**
     * Delete State
     *
     * @return void
     */
    public function test_delete_state()
    {
        $this->post('/api/states', $this->data->toArray());

        $this->delete('/api/states/'.$this->data->id)->assertStatus(200);

        $this->assertDatabaseMissing('states', $this->data->toArray());
    }

}
