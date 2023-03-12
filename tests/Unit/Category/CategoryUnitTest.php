<?php

namespace Tests\Unit\Category;

use Tests\TestCase;
use App\Models\Category;
use App\Olx\Categories\Entities\CategoryEntity;
use App\Olx\Categories\Services\CategoryService;
use App\Olx\Categories\Repositories\CategoryRepository;

class CategoryUnitTest extends TestCase
{
    protected $service;
    protected $data;
    protected $category;

    /**
     * SetUp
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->service = new CategoryService(new CategoryRepository(new CategoryEntity()));

        $this->data = Category::factory()->create();
        
        $a = [
            'brinquedos',
            'smartphones',
            'casa',
            'moda',
            'eletrodomesticos',
        ];
        $this->category = Category::factory()->make([
            'name'  => fake()->randomElement($a),
            'slug'  => fake()->slug(),
            'image' => fake()->imageUrl(),
        ]);
    }

    /**
     * Get All Categories
     *
     * @return void
     */
    public function test_if_can_get_all_categories()
    {
        $all = $this->service->getAll();

        $this->assertCount(10, $all);
    }

    /**
     * Create a new Category
     *
     * @return void
     */
    public function test_if_can_create_category()
    {
        $this->service->save($this->category->toArray());

        $this->assertDatabaseHas('categories', ['name' => $this->category->name]);
    }

    /**
     * Find a category
     *
     * @return void
     */
    public function test_if_can_find_category()
    {
        $find = $this->service->find($this->data->id);

        $this->assertSame($find->id, $this->data->id);
    }

    /**
     * Update a category
     *
     * @return void
     */
    public function test_if_can_update_category()
    {
        $category = $this->data;

        $this->service->update($category->id, ['name' => 'name atualizado']);

        $category = $category->fresh();

        $this->assertEquals($category->name, 'name atualizado');
    }

    /**
     * Delete a category
     *
     * @return void
     */
    public function test_if_can_delete_category()
    {
        $this->service->delete($this->data->id);

        $this->assertDatabaseMissing('categories', $this->data->toArray());
    }
}
