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
use Faker;

class InstructionTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_getOneInstruction()
    {
        $instruction = Instruction::factory()
                        ->for(Recipe::factory())
                        ->for(Ingredient::factory()->for(StockType::factory()))
                        ->for(Instrument::factory()->for(Location::factory()))
                        ->create();

        $response = $this->get('/api/instructions/'.$instruction->id);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => 
                $json->has('data')
                    ->whereAllType([
                        'data' => 'array',
                        'data.id' => 'integer',
                        'data.recipe_id' => 'integer',
                        'data.rank' => 'integer',
                        'data.ingredient' => 'array',
                        'data.ingredient.id' => 'integer',
                        'data.ingredient.name' => 'string',
                        'data.ingredient.stock' => 'integer|double',
                        'data.ingredient.stock_type' => 'array',
                        'data.ingredient.stock_type.id' => 'integer',
                        'data.ingredient.stock_type.name' => 'string',
                        'data.ingredientAmount' => 'integer|double',
                        'data.instrument' => 'array',
                        'data.instrument.id' => 'integer',
                        'data.instrument.name' => 'string',
                        'data.instrument.location' => 'array',
                        'data.instrument.location.id' => 'integer',
                        'data.instrument.location.name' => 'string',
                        'data.description' => 'string' 
                    ])
                    ->where('data.id', $instruction->id)
                    ->missing('data.1')
                    ->missing('data.ingredient.1')
                    ->missing('data.ingredient.stock_type.1')
                    ->missing('data.instrument.1')
                    ->missing('data.instrument.location.1')
            );
    }
   
    public function test_getAllInstructions()
    {
        Instruction::factory()
                        ->for(Recipe::factory())
                        ->for(Ingredient::factory()->for(StockType::factory()))
                        ->for(Instrument::factory()->for(Location::factory()))
                        ->count(3)
                        ->create();

        $response = $this->get('/api/instructions');

        $response->assertStatus(200);

        $response->assertJson(fn (AssertableJson $json) => 
            $json->has('data')
                ->whereAllType([
                    'data' => 'array',
                        'data.1.id' => 'integer',
                        'data.1.recipe_id' => 'integer',
                        'data.1.rank' => 'integer',
                        'data.1.ingredient' => 'array',
                        'data.1.ingredient.id' => 'integer',
                        'data.1.ingredient.name' => 'string',
                        'data.1.ingredient.stock' => 'integer|double',
                        'data.1.ingredient.stock_type' => 'array',
                        'data.1.ingredient.stock_type.id' => 'integer',
                        'data.1.ingredient.stock_type.name' => 'string',
                        'data.1.ingredientAmount' => 'integer|double',
                        'data.1.instrument' => 'array',
                        'data.1.instrument.id' => 'integer',
                        'data.1.instrument.name' => 'string',
                        'data.1.instrument.location' => 'array',
                        'data.1.instrument.location.id' => 'integer',
                        'data.1.instrument.location.name' => 'string',
                        'data.1.description' => 'string' 
                ])
        );
    }
    
    public function test_createInstruction(){
        $faker = Faker\Factory::create();

        $recipe = Recipe::factory()->create();
        $ingredient = Ingredient::factory()->for(StockType::factory())->create();
        $instrument = Instrument::factory()->for(Location::factory())->create();

        $response = $this->postJson('/api/instructions', [
            'recipe_id' => $recipe->id,
            'rank' => $faker->randomNumber(2),
            'ingredient_id' => $ingredient->id,
            'ingredientAmount' => $faker->randomFloat(2, 1, 150),
            'instrument_id' => $instrument->id,
            'description' => $faker->paragraphs(3, true)
        ]);
        

        $response
            ->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => 
                $json->has('data')
                    ->whereAllType([
                        'data' => 'array',
                        'data.id' => 'integer',
                        'data.recipe_id' => 'integer',
                        'data.rank' => 'integer',
                        'data.ingredient' => 'array',
                        'data.ingredient.id' => 'integer',
                        'data.ingredient.name' => 'string',
                        'data.ingredient.stock' => 'integer|double',
                        'data.ingredient.stock_type' => 'array',
                        'data.ingredient.stock_type.id' => 'integer',
                        'data.ingredient.stock_type.name' => 'string',
                        'data.ingredientAmount' => 'integer|double',
                        'data.instrument' => 'array',
                        'data.instrument.id' => 'integer',
                        'data.instrument.name' => 'string',
                        'data.instrument.location' => 'array',
                        'data.instrument.location.id' => 'integer',
                        'data.instrument.location.name' => 'string',
                        'data.description' => 'string' 
                    ])
                    ->missing('data.1')
            );
    }

    public function test_updateInstruction(){
        $instruction = Instruction::factory()
                        ->for(Recipe::factory())
                        ->for(Ingredient::factory()->for(StockType::factory()))
                        ->for(Instrument::factory()->for(Location::factory()))
                        ->create();

        $response = $this->putJson('/api/instructions/'.$instruction->id, [
            'description' => 'New Instruction Description',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => 
                $json->has('data')
                    ->whereAllType([
                        'data' => 'array',
                        'data.id' => 'integer',
                        'data.recipe_id' => 'integer',
                        'data.rank' => 'integer',
                        'data.ingredient' => 'array',
                        'data.ingredient.id' => 'integer',
                        'data.ingredient.name' => 'string',
                        'data.ingredient.stock' => 'integer|double',
                        'data.ingredient.stock_type' => 'array',
                        'data.ingredient.stock_type.id' => 'integer',
                        'data.ingredient.stock_type.name' => 'string',
                        'data.ingredientAmount' => 'integer|double',
                        'data.instrument' => 'array',
                        'data.instrument.id' => 'integer',
                        'data.instrument.name' => 'string',
                        'data.instrument.location' => 'array',
                        'data.instrument.location.id' => 'integer',
                        'data.instrument.location.name' => 'string',
                        'data.description' => 'string' 
                    ])
                    ->where('data.description', 'New Instruction Description')
                    ->missing('data.1')
            );;
    }

    public function test_deleteInstruction(){
        $instruction = Instruction::factory()
                        ->for(Recipe::factory())
                        ->for(Ingredient::factory()->for(StockType::factory()))
                        ->for(Instrument::factory()->for(Location::factory()))
                        ->create();
        
        $deleteResponse = $this->deleteJson('/api/instructions/'.$instruction->id);
        $deleteResponse->assertStatus(200);

        $getResponse = $this->get('/api/instructions/'.$instruction->id);
        $getResponse->assertStatus(404);
    }
}