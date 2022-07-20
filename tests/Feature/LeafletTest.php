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

    public function test_delete_image_from_database($imageId = 2)
    {
        $image = Image::factory()->count(10)->create();

        $image->find($imageId)->delete();

        $this->assertEquals(9, Image::count());
    }
   
    public function test_update_image_from_database($imageId = 2)
    {
        $image = Image::factory()->count(10)->create();
        $image->find($imageId)->update([
            'title' => 'new title',
            'description' => 'new description',
            'latitude' => 21.123,
            'longitude' => -21.123,
            'imagePath' => '/new_image_url',
        ]);
        $this->assertEquals('new title', Image::find($imageId)->title);
        $this->assertEquals('new description', Image::find($imageId)->description);
        $this->assertEquals(21.123, Image::find($imageId)->latitude);
        $this->assertEquals(-21.123, Image::find($imageId)->longitude);
        $this->assertEquals('/new_image_url', Image::find($imageId)->imagePath);
    }

    public function test_tags_factory_adds_to_tags_table()
    {
        $tag = Tag::factory()->count(10)->create();
        
        $this->assertEquals(10, Tag::count());

        $this->assertEquals($tag[0]->name, Tag::first()->name);
    }

    public function test_add_tag_to_image()
    {
        $image = Image::factory()->count(1)->create();
        $tag = Tag::factory()->count(1)->create();

        $firstImage = Image::first();
        $firstTag = Tag::first();

        $firstImage->tags()->attach($firstTag);
   
        $this->assertEquals(1, $firstImage->tags->count());
    }

    public function test_add_then_delete_tag_from_image()
    {
        $image = Image::factory()->create();
        $tag = Tag::factory()->create();

        $image->tags()->attach($tag);
   
        $this->assertEquals($tag->name, $image->tags[0]->name);

        $image = $image->fresh();

        $image->tags()->detach($tag);


        $this->assertEquals(0, $image->tags->count());
    }   
    
}
