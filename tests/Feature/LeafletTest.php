<?php

namespace Tests\Feature;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\User;
use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeafletTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->user = User::factory()->create();
    }

    // private function createUser()
    // {
    //     return User::factory()->create();
    // }

    public function test_map_page_contains_livewire_create_tag_modal_component()
    {
        $this->actingAs($this->user);
        $this->get('/map')->assertStatus(200);
        $this->get(route('map'))->assertSeeLivewire('create-tag-modal');

        $newTag = Tag::create([
            'name' =>  'new tag',
        ]);

        $this->assertEquals($newTag->name, Tag::first()->name);

    }

    public function test_image_factory_adds_to_images_table()
    {
        $image = Image::factory()->count(10)->create();
        
        $this->assertEquals(10, Image::count());

        $this->assertEquals($image[0]->title, Image::first()->title);
    }
    
}
