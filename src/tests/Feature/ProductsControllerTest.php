<?php


use App\Models\Agente;
use App\Models\Ambiente;
use App\Models\Unidade;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ProductsControllerTest extends TestCase
{
    use DatabaseMigrations;
    protected $products;

    protected function setUp(): void
    {
        parent::setUp();
        $this->products = \App\Models\Product::factory(10)->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('products.index'));
        $response->assertOk();

        $response->assertSee($this->products[0]->id);
        $response->assertSee($this->products[1]->id);
        $response->assertSee($this->products[2]->id);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

    }


}
