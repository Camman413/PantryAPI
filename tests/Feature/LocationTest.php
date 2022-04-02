<?php

namespace Tests\Feature;

use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class LocationTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_getOneLocation()
    {
        $location = Location::factory()->create();

        $response = $this->get('/api/locations/'.$location->id);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => 
                $json->has('data')
                    ->whereAllType([
                        'data' => 'array',
                        'data.id' => 'integer',
                        'data.name' => 'string',
                    ])
                    ->where('data.id', $location->id)
                    ->missing('data.1')
            );
    }
   
    public function test_getAllLocations()
    {
        Location::factory()->count(3)->create();

        $response = $this->get('/api/locations');

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
    
    public function test_createLocation(){
        $response = $this->postJson('/api/locations', [
            'name' => 'test location',
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
                    ->where('data.name', 'test location')
                    ->missing('data.1')
            );
    }

    public function test_updateLocation(){
        $location = Location::factory()->create();

        $response = $this->putJson('/api/locations/'.$location->id, [
            'name' => 'New location Name',
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
                    ->where('data.name', 'New location Name')
                    ->missing('data.1')
            );;
    }

    public function test_deleteLocation(){
        $location = Location::factory()->create();
        
        $deleteResponse = $this->deleteJson('/api/locations/'.$location->id);
        $deleteResponse->assertStatus(200);

        $getResponse = $this->get('/api/locations/'.$location->id);
        $getResponse->assertStatus(404);
    }
}