<?php

namespace Tests\Unit;

use App\Models\PeopleInformation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PeopleInformationApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testStore()
    {
        $data = [
            'name' => $this->faker->name,
            'linkedin' => $this->faker->url,
            'github' => $this->faker->url,
        ];

        $response = $this->post(route('peopleApi.store'), $data);
        $response->assertStatus(201)
            ->assertJson([
                'message_name' => 'Successfully registered',
                'message_type' => 'success',
            ]);

        $this->assertDatabaseHas('people_information', [
            'name' => $data['name'],
            'linkedin' => $data['linkedin'],
            'github' => $data['github'],
        ]);
    }

    public function testShow()
    {
        $object = new PeopleInformation();
        $object->name = 'John Doe';
        $object->linkedin = 'https://www.linkedin.com/in/jsgomesjr/';
        $object->github = 'https://github.com/jsgomesjr';
        $object->save();

        $response = $this->get(route('peopleApi.show', ['md5_id' => md5($object->id), 'name' => $object->name]));
        $response->assertStatus(200)
            ->assertJson([
                'message_name' => 'Request successfully fulfilled',
                'message_type' => 'success',
                'object' => [
                    'id' => $object->id,
                    'name' => $object->name,
                    'linkedin' => $object->linkedin,
                    'github' => $object->github,
                ],
            ]);
    }

    public function testUpdate()
    {
        $object = new PeopleInformation();
        $object->name = 'John Doe';
        $object->linkedin = 'https://www.linkedin.com/in/jsgomesjr/';
        $object->github = 'https://github.com/jsgomesjr';
        $object->save();

        $data = [
            'name' => $this->faker->name,
            'linkedin' => $this->faker->url,
            'github' => $this->faker->url,
        ];

        $response = $this->put(route('peopleApi.update', $object->id), $data);
        $response->assertStatus(200)
            ->assertJson([
                'message_name' => 'Updated successfully',
                'message_type' => 'success',
                'object' => $data,
            ]);

        $this->assertDatabaseHas('people_information', [
            'id' => $object->id,
            'name' => $data['name'],
            'linkedin' => $data['linkedin'],
            'github' => $data['github'],
        ]);
    }
}
