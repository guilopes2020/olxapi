<?php

namespace Tests\Unit\AbstractService;

use Tests\TestCase;
use App\Models\State;
use Faker\Provider\pt_BR\Address;
use App\Olx\States\Entities\StateEntity;
use App\Olx\States\Services\StateService;
use App\Olx\States\Repositories\StateRepository;


class AbstractServiceUnitTest extends TestCase
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
     * Get Repository Abstract Service Method
     *
     * @return void
     */
    public function test_if_method_getRepository_is_work_correctly()
    {
        $response = $this->service->getRepository();

        $this->assertIsObject($response);
    }

    /**
     * GetAll Abstract Service Method
     *
     * @return void
     */
    public function test_if_method_getAll_is_working_correctly()
    {
        $all = $this->service->getAll();

        $this->assertCount(10, $all);
    }

    /**
     * Find Abstract Service Method
     *
     * @return void
     */
    public function test_if_method_find_is_working_correctly()
    {
        $state = $this->service->find($this->data->id);

        $this->assertSame($this->data->id, $state->id);
    }

    /**
     * Before Update Abstract Service Method
     *
     * @return void
     */
    public function test_if_method_beforeUpdate_is_working_correctly()
    {
        $response = $this->service->beforeUpdate($this->data->id, $this->data->toArray());

        $this->assertTrue($this->data->toArray() == $response);
    }

    /**
     * Update Abstract Service Method
     *
     * @return void
     */
    public function test_if_method_update_is_working_correctly()
    {
        $state = $this->data;

        $this->service->update($this->data->id, ['name' => 'name modificado']);

        $state = $state->fresh();

        $this->assertEquals($state->name, 'name modificado');
    }

    /**
     * After Update Abstract Service Method
     *
     * @return void
     */
    public function test_if_method_afterUpdate_is_working_correctly()
    {
        $response = $this->service->afterUpdate(State::class, $this->data->toArray());

        $this->assertTrue(null == $response);
    }

    /**
     * BeforeSave Abstract Service Method
     *
     * @return void
     */
    public function test_if_method_beforeSave_is_working_correctly()
    {
        $data = $this->service->beforeSave($this->state->toArray());

        $this->assertTrue($this->state->toArray() == $data);
    }

    /**
     * Save Abstract Service Method
     *
     * @return void
     */
    public function test_if_method_save_is_working_correctly()
    {
        $this->service->save($this->state->toArray());

        $this->assertDatabaseHas('states', $this->state->toArray());
    }

    /**
     * After Save Abstract Service Method
     *
     * @return void
     */
    public function test_if_method_afterSave_is_working_correctly()
    {
        $response = $this->service->afterSave(State::class, $this->data->toArray());

        $this->assertTrue(State::class == $response);
    }

    /**
     * Before Delete Abstract Service Method
     *
     * @return void
     */
    public function test_if_method_beforeDelete_is_working_correctly()
    {
        $response = $this->service->beforeDelete($this->data->id);

        $this->assertTrue($this->data->id == $response);
    }

    /**
     * DElete Abstract Service Method
     *
     * @return void
     */
    public function test_if_method_delete_is_working_correctly()
    {
        $this->service->delete($this->data->id);

        $this->assertDatabaseMissing('states', $this->data->toArray());
    }

    /**
     * After Delete Abstract Service Method
     *
     * @return void
     */
    public function test_if_method_afterDelete_is_working_correctly()
    {
        $response = $this->service->afterDelete($this->data->id);

        $this->assertTrue($this->data->id == $response);
    }

    /**
     * Create Abstract Service Method
     *
     * @return void
     */
    public function test_if_method_create_is_working_correctly()
    {
        $this->service->create($this->data->toArray());

        $this->assertDatabaseHas('states', $this->data->toArray());
    }
    
}
