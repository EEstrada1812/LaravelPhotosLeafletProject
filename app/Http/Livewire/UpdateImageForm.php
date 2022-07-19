<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use App\Models\Image;
use Livewire\Component;

class UpdateImageForm extends Component
{   
    public $editTitle;
    public $editDescription;
    public $editLatitude;
    public $editLongitude;
    public $editTags = [];
    public $allTags;
    public $editImageId;

    protected $listeners = ['getSingleImage'];
    
    protected $rules = [
        'editTitle' => 'required|min:3',
        'editDescription' => 'required|min:3',
        'editLatitude' => 'required|numeric',
        'editLongitude' => 'required|numeric',
        'editTags.*' => 'exists:tags,id',
        // 'editImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ];

    public function getSingleImage($id)
    {
        $this->editImageId = $id;

        $image = Image::with('tags')->find($id);

        $this->editTitle = $image->title;
        $this->editDescription = $image->description;
        $this->editLatitude = $image->latitude;
        $this->editLongitude = $image->longitude;

    }
    
    private function resetForm() {
        $this->editTitle = '';
        $this->editDescription = '';
        $this->editLatitude = '';
        $this->editLongitude = '';
        $this->editTags = [];
        $this->editImageId = '';
    }

    public function updateImage() {
        $this->validate();
        $image = Image::find($this->editImageId);

        $image->update([
            'title' => $this->editTitle,
            'description' => $this->editDescription,
            'latitude' => $this->editLatitude,
            'longitude' => $this->editLongitude,
        ]);
        $image->tags()->attach($this->editTags);
        $this->resetForm();
        $this->emit('reload');
    }

    public function mount()
    {
        $this->allTags = Tag::all();
    }

    public function render()
    {
        return view('livewire.update-image-form');
    }
}
