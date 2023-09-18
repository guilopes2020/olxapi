<?php

namespace Tests\Unit\AbstractRepository;

use Tests\TestCase;
use App\Models\State;
use Faker\Provider\pt_BR\Address;
use App\Olx\States\Entities\StateEntity;
use App\Olx\States\Repositories\StateRepository;

class AbstractRepositoryUnitTest extends TestCase
{
    protected $repository;
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

        $this->repository = new StateRepository(new StateEntity());
        $this->data = State::factory()->create();
        $this->state = State::factory()->make([
            'name' => Address::state(),
            'slug' => fake()->slug(),
        ]);
    }

    /**
     * Get Model Abstract Repository Method
     *
     * @return void
     */
    public function test_if_get_model_is_work_correctly()
    {
        $model = $this->repository->getModel();

        $this->assertInstanceOf(State::class, $model);
    }

    /**
     * All Abstract Repository Method
     *
     * @return void
     */
    public function test_if_method_all_is_working_correctly()
    {
        $all = $this->repository->all();

        $this->assertCount(10, $all);
    }

    /**
     * Find Abstract Repository Method
     *
     * @return void
     */
    public function test_find_method_working_correctly()
    {
        $state = $this->repository->find($this->data->id);

        $this->assertSame($this->data->id, $state->id);
    }

    /**
     * Find Or Fail Abstract Repository Method
     *
     * @return void
     */
    public function test_if_find_or_fail_method_working_correctly()
    {
        $id = $this->repository->findOrFail($this->data->id);

        $this->assertDatabaseHas('states', $id->toArray());
    }

    /**
     * Create Abstract Repository Method
     *
     * @return void
     */
    public function test_if_create_method_working_correctly()
    {
        $this->repository->create($this->state->toArray());

        $this->assertDatabaseHas('states', $this->state->toArray());
    }

    /**
     * Update Abstract Repository Method
     *
     * @return void
     */
    public function test_if_update_method_working_correctly()
    {
        $state = $this->data;

        $this->repository->update($this->data, ['name' => 'name modificado']);

        $state = $state->fresh();

        $this->assertEquals('name modificado', $state->name);
    }

    /**
     * Create Or Update Abstract Method
     *
     * @return void
     */
    public function test_if_create_or_update_method_working_correctly()
    {
        $response = $this->repository->createOrUpdate(['name' => Address::state()], $this->state->toArray());

        $this->assertDatabaseHas('states', $response->toArray());
    }

    /**
     * Where Abstract Repository Method
     *
     * @return void
     */
    public function test_if_where_method_working_correctly()
    {
        $where = $this->repository->where(['name' => $this->data->name]);

        $this->assertNotNull($where);
    }

    /**
     * Delete Abstract Repository Method
     *
     * @return void
     */
    public function test_if_delete_method_working_correctly()
    {
        $this->repository->delete($this->data->id);

        $this->assertDatabaseMissing('states', $this->data->toArray());
    }

    /**
     * Delete Where Abstract Repository Method
     *
     * @return void
     */
    public function test_if_delete_where_method_working_correctly()
    {
        $this->repository->deleteWhere(['id' => $this->data->id]);

        $this->assertDatabaseMissing('states', $this->data->toArray());
    }

    /**
     * Find One Where Abstract Repository Method
     *
     * @return void
     */
    public function test_if_find_one_where_method_working_correctly()
    {
        $find = $this->repository->findOneWhere(['id' => $this->data->id]);

        $this->assertSame($this->data->id, $find->id);
    }
}
