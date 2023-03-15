<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryFeatureTest extends TestCase
{
    use RefreshDatabase;

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
     * Index Category
     *
     * @return void
     */
    public function test_index_category()
    {
        $this->post('/api/categories', $this->category->toArray());

        $this->get('/api/categories')->assertSee($this->category->name);
    }

    /**
     * Store Category
     *
     * @return void
     */
    public function test_store_category()
    {
        $this->post('/api/categories', $this->category->toArray())->assertStatus(200);

        $this->assertDatabaseHas('categories', ['slug' => $this->category->slug]);
    }

    /**
     * Show Category
     *
     * @return void
     */
    public function test_show_category()
    {
        $this->post('/api/categories', $this->data->toArray());

        $id = $this->data->id;

        $expected = $this->data->slug;

        $this->get('/api/categories/'.$id)->assertSee($expected);
    }

    /**
     * Update Category
     *
     * @return void
     */
    public function test_update_category()
    {
        $category = $this->data;

        $updated = ['slug' => 'slug updated', 'image' => 'image updated'];

        $this->put('/api/categories/'.$category->id, $updated)->assertStatus(200);

        $category->refresh();

        $this->get('/api/categories/'.$this->category->id)->assertSee('slug updated', 'image updated');
    }

    /**
     * Delete Category
     *
     * @return void
     */
    public function test_delete_category()
    {
        $this->post('/api/categories', $this->data->toArray());

        $this->delete('/api/categories/'.$this->data->id)->assertStatus(200);

        $this->assertDatabaseMissing('categories', $this->data->toArray());
    }
}
