<?php

namespace Tests\Unit\Advertise;

use Tests\TestCase;
use App\Models\User;
use App\Models\State;
use App\Models\Category;
use App\Models\Advertise;
use App\Olx\Advertises\Entities\AdvertiseEntity;
use App\Olx\Advertises\Services\AdvertiseService;
use App\Olx\Advertises\Repositories\AdvertiseRepository;

class AdvertiseUnitTest extends TestCase
{
    protected $service;
    protected $data;
    protected $user;
    protected $state;
    protected $category;
    protected $advertise;

    /**
     * SetUp
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->service = new AdvertiseService(new AdvertiseRepository(new AdvertiseEntity()));

        $this->data = Advertise::factory()->create();

        $this->user = User::factory()->create();
        $this->state = State::factory()->create();
        $this->category = Category::factory()->create();
        $this->advertise = Advertise::factory()->make([
            'user_id'       => $this->user->id,
            'state_id'      => $this->state->id,
            'category_id'   => $this->category->id,
            'title'         => fake()->sentence(),
            'price'         => random_int(50, 10000),
            'is_negotiable' => fake()->boolean(),
            'description'   => fake()->text(),
            'views'         => random_int(1, 500),
        ]);
    }

    /**
     * Get All Advertises
     *
     * @return void
     */
    public function test_if_get_all_advertises()
    {
        $all = $this->service->getAll();

        $this->assertCount(10, $all);
    }

    /**
     * Create a new Advertise
     *
     * @return void
     */
    public function test_if_can_create_advertise()
    {
        $this->service->save($this->advertise->toArray());

        $this->assertDatabaseHas('advertises', ['title' => $this->advertise->title]);
    }

    /**
     * Find a Advertise
     *
     * @return void
     */
    public function test_if_can_find_advertise()
    {
        $find = $this->service->find($this->data->id);

        $this->assertSame($find->id, $this->data->id);
    }

    /**
     * Update a Advertise
     *
     * @return void
     */
    public function test_if_can_update_advertise()
    {
        $advertise = $this->data;

        $this->service->update($advertise->id, ['title' => 'title atualizado']);

        $advertise = $advertise->fresh();

        $this->assertEquals($advertise->title, 'title atualizado');
    }

    /**
     * Delete a Advertise
     *
     * @return void
     */
    public function test_if_can_delete_advertise()
    {
        $this->service->delete($this->data->id);

        $this->assertDatabaseMissing('advertises', $this->data->toArray());
    }
}
