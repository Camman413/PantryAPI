<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\StockType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class IngredientTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_getOneIngredient()
    {
        $ingredient = Ingredient::factory()->for(StockType::factory())->create();

        $response = $this->get('/api/ingredients/'.$ingredient->id);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => 
                $json->has('data')
                    ->whereAllType([
                        'data' => 'array',
                        'data.id' => 'integer',
                        'data.name' => 'string',
                        'data.stock' => 'integer|double',
                        'data.stock_type' => 'array',
                        'data.stock_type.id' => 'integer',
                        'data.stock_type.name' => 'string'
                    ])
                    ->where('data.id', $ingredient->id)
                    ->missing('data.1')
                    ->missing('data.stock_type.1')
            );
    }
    
    public function test_getAllIngredients()
    {
        Ingredient::factory()->for(StockType::factory())->count(3)->create();

        $response = $this->get('/api/ingredients');

        $response->assertStatus(200);

        $response->assertJson(fn (AssertableJson $json) => 
            $json->has('data')
                ->whereAllType([
                    'data' => 'array',
                    'data.1.id' => 'integer',
                    'data.1.name' => 'string',
                    'data.1.stock' => 'integer|double',
                    'data.1.stock_type' => 'array',
                    'data.1.stock_type.id' => 'integer',
                    'data.1.stock_type.name' => 'string'
                ])
        );
    }
    
    public function test_createIngredient(){
        $stockType = StockType::factory()->create();

        $response = $this->postJson('/api/ingredients', [
            'name' => 'test ingredient',
            'stock' => 200.22,
            'stock_type_id' => $stockType->id
        ]);
        

        $response
            ->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => 
                $json->has('data')
                    ->whereAllType([
                        'data' => 'array',
                        'data.id' => 'integer',
                        'data.name' => 'string',
                        'data.stock' => 'integer|double',
                        'data.stock_type' => 'array',
                        'data.stock_type.id' => 'integer',
                        'data.stock_type.name' => 'string'
                    ])
                    ->where('data.name', 'test ingredient')
                    ->where('data.stock', 200.22)
                    ->where('data.stock_type.id', $stockType->id)
                    ->where('data.stock_type.name', $stockType->name)
                    ->missing('data.1')
                    ->missing('data.stock_type.1')
            );
    }

    public function test_updateIngredient(){
        $ingredient = Ingredient::factory()->for(StockType::factory())->create();
        $stockType = StockType::factory()->create();

        $response = $this->putJson('/api/ingredients/'.$ingredient->id, [
            'name' => 'New Ingredient Name',
            'stock' => 200.22,
            'stock_type_id' => $stockType->id
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => 
                $json->has('data')
                    ->whereAllType([
                        'data' => 'array',
                        'data.id' => 'integer',
                        'data.name' => 'string',
                        'data.stock' => 'integer|double',
                        'data.stock_type' => 'array',
                        'data.stock_type.id' => 'integer',
                        'data.stock_type.name' => 'string'
                    ])
                    ->where('data.name', 'New Ingredient Name')
                    ->where('data.stock', 200.22)
                    ->where('data.stock_type.id', $stockType->id)
                    ->where('data.stock_type.name', $stockType->name)
                    ->missing('data.1')
                    ->missing('data.stock_type.1')
            );;
    }

    public function test_deleteIngredient(){
        $ingredient = Ingredient::factory()->for(StockType::factory())->create();
        
        $deleteResponse = $this->deleteJson('/api/ingredients/'.$ingredient->id);
        $deleteResponse->assertStatus(200);

        $getResponse = $this->get('/api/ingredients/'.$ingredient->id);
        $getResponse->assertStatus(404);
    }
}
