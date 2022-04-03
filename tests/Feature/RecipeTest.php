<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\Instruction;
use App\Models\Instrument;
use App\Models\Location;
use App\Models\Recipe;
use App\Models\StockType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class RecipeTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_getOneRecipe()
    {
        $recipe = Recipe::factory()
                    ->has(Instruction::factory()
                            ->for(Recipe::factory())
                            ->for(Ingredient::factory()->for(StockType::factory()))
                            ->for(Instrument::factory()->for(Location::factory()))
                            ->count(3)
                        )
                    ->create();

        $response = $this->get('/api/recipes/'.$recipe->id);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => 
                $json->has('data')
                    ->whereAllType([
                        'data' => 'array',
                        'data.id' => 'integer',
                        'data.name' => 'string',
                    ])
                    ->where('data.id', $recipe->id)
                    ->missing('data.1')
                    ->has('data.instructions.2')
            );
    }
   
    public function test_getAllRecipes()
    {
        Recipe::factory()
                    ->has(Instruction::factory()
                            ->for(Recipe::factory())
                            ->for(Ingredient::factory()->for(StockType::factory()))
                            ->for(Instrument::factory()->for(Location::factory()))
                            ->count(3)
                        )
                    ->count(3)
                    ->create();

        $response = $this->get('/api/recipes');

        $response->assertStatus(200)
                  ->assertJson(fn (AssertableJson $json) => 
                    $json->has('data')
                        ->whereAllType([
                            'data' => 'array',
                            'data.1.id' => 'integer',
                            'data.1.name' => 'string',
                        ])
                        ->has('data.2.instructions.2')
                    );
    }
    
    public function test_createRecipe(){
        $response = $this->postJson('/api/recipes', [
            'name' => 'test recipe',
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
                    ->where('data.name', 'test recipe')
                    ->missing('data.1')
            );
    }

    public function test_updateRecipe(){
        $recipe = Recipe::factory()->create();

        $response = $this->putJson('/api/recipes/'.$recipe->id, [
            'name' => 'New recipe Name',
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
                    ->where('data.name', 'New recipe Name')
                    ->missing('data.1')
            );;
    }

    public function test_deleteRecipe(){
        $recipe = Recipe::factory()->create();
        
        $deleteResponse = $this->deleteJson('/api/recipes/'.$recipe->id);
        $deleteResponse->assertStatus(200);

        $getResponse = $this->get('/api/recipes/'.$recipe->id);
        $getResponse->assertStatus(404);
    }
}