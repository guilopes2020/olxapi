<?php

namespace Tests\Feature\Advertise;

use App\Models\Advertise;
use App\Models\Category;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdvertiseFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $state;
    protected $category;
    protected $data;
    protected $advertise;

    /**
     * SetUp
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->state = State::factory()->create();
        $this->category = Category::factory()->create();
        $this->data = Advertise::factory()->create();
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
     * Index Advertise
     *
     * @return void
     */
    public function test_index_advertise()
    {
        $this->post('/api/advertises', $this->advertise->toArray());

        $this->get('/api/advertises')->assertStatus(200);
        $this->get('/api/advertises')->assertSee($this->advertise->title);
    }

    /**
     * Store Advertise
     *
     * @return void
     */
    public function test_store_advertise()
    {
        $this->post('/api/advertises', $this->advertise->toArray())->assertStatus(200);

        $this->assertDatabaseHas('advertises', ['title' => $this->advertise->title]);
    }

    /**
     * Show Advertise
     *
     * @return void
     */
    public function test_show_advertise()
    {
        $this->post('/api/advertises', $this->data->toArray());

        $expected = $this->data->title;

        $this->get('/api/advertises/'.$this->advertise->id)->assertStatus(200);

        $this->get('/api/advertises/'.$this->data->id)->assertSee($expected);
    }

    /**
     * Update Advertise
     *
     * @return void
     */
    public function test_update_advertise()
    {
        $advertise = $this->data;

        $expected = ['title' => 'title updated'];

        $this->put('/api/advertises/'.$this->data->id, $expected)->assertStatus(200);

        $advertise->refresh();

        $this->get('/api/advertises/'.$this->data->id)->assertSee($expected);
    }

    /**
     * Delete Advertise
     *
     * @return void
     */
    public function test_delete_advertise()
    {
        $this->post('/api/advertises', $this->data->toArray());

        $this->delete('/api/advertises/'.$this->data->id)->assertStatus(200);

        $this->assertDatabaseMissing('advertises', $this->data->toArray());
    }
}
