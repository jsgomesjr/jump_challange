<?php

namespace Tests\Unit;

use App\Models\PeopleInformation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WebRoutesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testCreate()
    {
        $response = $this->get(route('generate.create'));

        $response->assertStatus(200);
        $response->assertViewIs('screens.people_information.form');
    }

    public function testStore()
    {
        $csrfToken = csrf_token();

        $data = [
            'id' => 1,
            'name' => $this->faker->name(),
            'linkedin' => $this->faker->url(),
            'github' => $this->faker->url(),
        ];

        $response = $this->withHeaders([
            'X-CSRF-TOKEN' => $csrfToken,
        ])->post(route('generate.store'), $data);

        $response->assertStatus(200);
        $response->assertRedirect(route('name.show', ['md5_id' => md5($data['id']), 'name' => $data['name']]));
        $this->assertDatabaseHas('people_information', $data);
    }

    public function testShow()
    {
        $object = new PeopleInformation();
        $object->name = 'John Doe';
        $object->linkedin = 'https://www.linkedin.com/in/jsgomesjr/';
        $object->github = 'https://github.com/jsgomesjr';
        $object->save();

        $response = $this->get(route('name.show', ['md5_id' => md5($object->id), 'name' => $object->name]));

        $response->assertStatus(200);
        $response->assertViewIs('screens.people_information.index');
        $response->assertViewHas('object', $object);
    }
}
