<?php

namespace Tests\Unit;

use App\Models\PeopleInformation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class ApiRoutesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testShow()
    {
        $object = new PeopleInformation();
        $object->name = 'John Doe';
        $object->linkedin = 'https://www.linkedin.com/in/jsgomesjr/';
        $object->github = 'https://github.com/jsgomesjr';
        $object->save();

        $response = $this->get(route('peopleApi.show', [
            'md5_id' => md5($object->id),
            'name' => $object->name
        ]));
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $object->name]);
    }

    public function testStore()
    {
        $data = [
            'name' => 'John Doe',
            'linkedin' => 'https://www.linkedin.com/in/jsgomesjr/',
            'github' => 'https://github.com/jsgomesjr',
        ];

        $response = $this->post(route('peopleApi.store'), $data);
        $response->assertStatus(201);
        $response->assertJson([
            'message_name' => 'Successfully registered',
            'message_type' => 'success',
            'object' => $data
        ]);
        $this->assertDatabaseHas('people_information', $data);
    }

    public function testUpdate()
    {
        $object = new PeopleInformation();
        $object->name = 'John Doe';
        $object->linkedin = 'https://www.linkedin.com/in/jsgomesjr/';
        $object->github = 'https://github.com/jsgomesjr';
        $object->save();

        $data = [
            'name' => 'Jane Doe',
            'linkedin' => 'https://www.linkedin.com/in/janedoe/',
            'github' => 'https://github.com/janedoe',
        ];

        $response = $this->put(route('peopleApi.update', $object->id), $data);
        $response->assertStatus(200);
        $response->assertJson([
            'message_name' => 'Updated successfully',
            'message_type' => 'success',
            'object' => $data
        ]);
        $this->assertDatabaseHas('people_information', $data);
        $this->assertDatabaseMissing('people_information', ['name' => 'John Doe']);
    }
}
