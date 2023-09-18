<?php

namespace Tests\Unit\States;

use App\Models\State;
use App\Olx\States\Entities\StateEntity;
use App\Olx\States\Repositories\StateRepository;
use App\Olx\States\Services\StateService;
use Faker\Provider\pt_BR\Address;
use Tests\TestCase;

class StateUnitTest extends TestCase
{
    protected $service;
    protected $data;
    protected $state;

    /**
     * SetUp
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->service = new StateService(new StateRepository(new StateEntity()));

        $this->data = State::factory()->create();
        $this->state = State::factory()->make([
            'name' => Address::state(),
            'slug' => fake()->slug(),
        ]);
    }

    /**
     * Get All States
     *
     * @return void
     */
    public function test_if_can_get_all_states()
    {
        $all = $this->service->getAll();

        $this->assertCount(10, $all);
    }

    /**
     * Create a new State
     *
     * @return void
     */
    public function test_if_can_create_state()
    {
        $this->service->save($this->state->toArray());
        
        $this->assertDatabaseHas('states', ['name' => $this->state->name]);
    }

    /**
     * Find a State
     *
     * @return void
     */
    public function test_if_can_find_state()
    {
        $find = $this->service->find($this->data->id);

        $this->assertSame($this->data->id, $find->id);
    }

    /**
     * Update a State
     *
     * @return void
     */
    public function test_if_can_update_state()
    {
        $state = $this->data;

        $this->service->update($state->id, ['name' => 'estado modificado']);

        $state = $state->fresh();

        $this->assertEquals($state->name, 'estado modificado');
    }

    /**
     * Delete a state
     *
     * @return void
     */
    public function test_if_can_delete_state()
    {
        $this->service->delete($this->data->id);

        $this->assertDatabaseMissing('states', $this->data->toArray());
    }
}
