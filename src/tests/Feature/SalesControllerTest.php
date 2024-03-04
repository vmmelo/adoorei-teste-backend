<?php


use App\Models\Sale;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class SalesControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected $products;
    protected $sale;

    protected function setUp(): void
    {
        parent::setUp();
        $this->products = \App\Models\Product::factory(10)->create();
        $service = new \App\Services\SalesService();
        $this->sale = $service->store(
            [
                "products"=> [
                    [
                        "id"=> $this->products[0]['id'],
                        "amount"=> 1
                    ],
                    [
                        "id"=> $this->products[1]['id'],
                        "amount"=> 2
                    ]
                ]
            ]
        );
    }

    public function testIndex()
    {
        $response = $this->get(route('sales.index'));

        $response->assertOk();
        $response->assertSee($this->sale->id);
    }

    public function testShow()
    {
        $response = $this->get(route('sales.show', $this->sale->id));
        $response->assertOk();

        $response->assertSee('products');
        $response->assertJsonStructure([
            "id",
            "amount",
            "deleted_at",
            "created_at",
            "updated_at",
            "sales_products"
        ]);
        $response->assertSee($this->sale->id);
        $response->assertSee($this->products[0]['id']);
        $response->assertSee($this->products[1]['id']);
    }



    public function testStore()
    {
        $data = [
            "products"=> [
                [
                    "id"=> $this->products[0]['id'],
                    "amount"=> 1
                ],
                [
                    "id"=> $this->products[1]['id'],
                    "amount"=> 2
                ],
                [
                    "id"=> $this->products[2]['id'],
                    "amount"=> 3
                ]
            ]
        ];

        $response = $this->post(route('sales.store'), $data)->json();

        $this->assertDatabaseHas('sales', ['id' => $response['id']]);
        $this->assertDatabaseHas('sales_products', ['sale_id' => $response['id'], 'product_id' => $response['sales_products'][0]['product_id'] ]);

    }

    public function testAddProducts()
    {
        $data = [
            "products"=> [
                [
                    "id"=> $this->products[5]['id'],
                    "amount"=> 1
                ]
            ]
        ];

        $response = $this->put(route('products.addProducts', $this->sale['id']), $data)->json();

        $this->assertDatabaseHas('sales_products', ['sale_id' => $this->sale['id'], 'product_id' => $this->products[5]['id'] ]);
        $this->assertEquals( 3, count($response['sales_products']));

    }

    public function testDestroy()
    {
        $this->assertTrue(Sale::where('id', $this->sale['id'])->exists());
        $this->delete(route('sales.destroy', $this->sale->id));

        $this->assertNotTrue(Sale::where('id', $this->sale['id'])->exists());
    }
    protected function tearDown(): void
    {
        parent::tearDown();

    }
}
