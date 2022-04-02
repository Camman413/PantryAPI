<?php

namespace Tests\Feature;

use App\Models\Instrument;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class InstrumentTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_getOneInstrument()
    {
        $instrument = Instrument::factory()->for(Location::factory())->create();

        $response = $this->get('/api/instruments/'.$instrument->id);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => 
                $json->has('data')
                    ->whereAllType([
                        'data' => 'array',
                        'data.id' => 'integer',
                        'data.name' => 'string',
                        'data.location' => 'array',
                        'data.location.id' => 'integer',
                        'data.location.name' => 'string',
                    ])
                    ->where('data.id', $instrument->id)
                    ->missing('data.1')
                    ->missing('data.location.1')
            );
    }
   
    public function test_getAllInstruments()
    {
        Instrument::factory()->for(Location::factory())->count(3)->create();

        $response = $this->get('/api/instruments');

        $response->assertStatus(200);

        $response->assertJson(fn (AssertableJson $json) => 
            $json->has('data')
                ->whereAllType([
                    'data' => 'array',
                    'data.1.id' => 'integer',
                    'data.1.name' => 'string',
                    'data.1.location' => 'array',
                    'data.1.location.id' => 'integer',
                    'data.1.location.name' => 'string'
                ])
        );
    }
    
    public function test_createInstrument(){
        $location = Location::factory()->create();
        $response = $this->postJson('/api/instruments', [
            'name' => 'test instrument',
            'location_id' => $location->id
        ]);
        

        $response
            ->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => 
                $json->has('data')
                    ->whereAllType([
                        'data' => 'array',
                        'data.id' => 'integer',
                        'data.name' => 'string',
                        'data.location' => 'array',
                        'data.location.id' => 'integer',
                        'data.location.name' => 'string',
                    ])
                    ->where('data.name', 'test instrument')
                    ->missing('data.1')
            );
    }

    public function test_updateInstrument(){
        $instrument = Instrument::factory()->for(Location::factory())->create();

        $response = $this->putJson('/api/instruments/'.$instrument->id, [
            'name' => 'New instrument Name',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => 
                $json->has('data')
                    ->whereAllType([
                        'data' => 'array',
                        'data.id' => 'integer',
                        'data.name' => 'string',
                        'data.location' => 'array',
                        'data.location.id' => 'integer',
                        'data.location.name' => 'string',
                    ])
                    ->where('data.name', 'New instrument Name')
                    ->missing('data.1')
            );;
    }

    public function test_deleteInstrument(){
        $instrument = Instrument::factory()->for(Location::factory())->create();
        
        $deleteResponse = $this->deleteJson('/api/instruments/'.$instrument->id);
        $deleteResponse->assertStatus(200);

        $getResponse = $this->get('/api/instruments/'.$instrument->id);
        $getResponse->assertStatus(404);
    }
}