<?php

namespace Tests\Feature;

use App\Models\StockType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class StockTypeTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_getOneStockType()
    {
        $stockType = StockType::factory()->create();

        $response = $this->get('/api/stocktypes/'.$stockType->id);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => 
                $json->has('data')
                    ->whereAllType([
                        'data' => 'array',
                        'data.id' => 'integer',
                        'data.name' => 'string',
                    ])
                    ->where('data.id', $stockType->id)
                    ->missing('data.1')
            );
    }
   
    public function test_getAllStockTypes()
    {
        StockType::factory()->count(3)->create();

        $response = $this->get('/api/stocktypes');

        $response->assertStatus(200);

        $response->assertJson(fn (AssertableJson $json) => 
            $json->has('data')
                ->whereAllType([
                    'data' => 'array',
                    'data.1.id' => 'integer',
                    'data.1.name' => 'string',
                ])
        );
    }
    
    public function test_createStockType(){
        $response = $this->postJson('/api/stocktypes', [
            'name' => 'test stock type',
        ]);
        

        $response
            ->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => 
                $json->has('data')
                    ->whereAllType([
                        'data' => 'array',
                        'data.id' => 'integer',
                        'data.name' => 'string',
                    ])
                    ->where('data.name', 'test stock type')
                    ->missing('data.1')
            );
    }

    public function test_updateStockType(){
        $stockType = StockType::factory()->create();

        $response = $this->putJson('/api/stocktypes/'.$stockType->id, [
            'name' => 'New Stock Type Name',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => 
                $json->has('data')
                    ->whereAllType([
                        'data' => 'array',
                        'data.id' => 'integer',
                        'data.name' => 'string',
                    ])
                    ->where('data.name', 'New Stock Type Name')
                    ->missing('data.1')
            );;
    }

    public function test_deleteStockType(){
        $stockType = StockType::factory()->create();
        
        $deleteResponse = $this->deleteJson('/api/stocktypes/'.$stockType->id);
        $deleteResponse->assertStatus(200);

        $getResponse = $this->get('/api/stocktypes/'.$stockType->id);
        $getResponse->assertStatus(404);
    }
}