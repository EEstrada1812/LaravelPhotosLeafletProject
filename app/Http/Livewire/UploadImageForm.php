<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use App\Models\Image;
use Livewire\Component;
use App\Http\Livewire\Modal;
use Livewire\WithFileUploads;

class UploadImageForm extends Modal
{
    use WithFileUploads;
    
    public $modalHeaderText = 'Upload Image';
    public $submitButtonText = 'Upload';
    public $title;
    public $description;
    public $latitude;
    public $longitude;
    public $tags = [];
    public $allTags;
    public $imageFile;
    public $imageId;
    public $singleImageTags;
    public $selectedImage;
    
    protected $listeners = ['getSingleImage', 'resetUploadForm', 'updateTags'=> 'updateTags'];
    protected $rules = [
        'title' => 'required|min:3',
        'description' => 'required|min:3',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'tags.*' => 'exists:tags,id',
        // 'imageFile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ];

    public function uploadImage()
    {
        $this->validate();
        
        $dataToUpdate = [
            'title' => $this->title,
            'description' => $this->description,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];

        if($this->imageFile) {
            $dataToUpdate['imagePath'] = $this->imageFile->store('images', 'public');
        }

        $image = Image::updateOrCreate(
            ['id' => $this->imageId],
            $dataToUpdate,
        );
        
        if($this->tags && $this->imageId) {
            foreach($this->tags as $tag) {
                if(!$image->tags->contains($tag)) {
                    $image->tags()->attach($tag);
                }
            }
            
        } elseif ($this->tags && !$this->imageId) {
            $image->tags()->sync($this->tags);
        }


        if($image->wasRecentlyCreated){
            $message = 'Image successfully created.';
         } else {
            $message = 'Image was successfully updated.';
        }
        $this->emit('uploadFormMessage', $message);
        $this->show = false;
        $this->resetForm();
        $this->emit('reload');
    }

    public function removeTag($tagId) {
        $this->selectedImage->tags()->detach($tagId);
        $this->selectedImage = $this->selectedImage->fresh();
        $this->singleImageTags = $this->selectedImage->tags;
        $this->emit('tagRemoved');
    }

    public function getSingleImage($id)
    {
        
        $this->imageId = $id;
        $this->modalHeaderText = 'Update Image';
        $this->submitButtonText = 'Update';

        $this->selectedImage  = Image::with('tags')->find($id);

        $this->title = $this->selectedImage->title;
        $this->description = $this->selectedImage->description;
        $this->latitude = $this->selectedImage->latitude;
        $this->longitude = $this->selectedImage->longitude;
        $this->singleImageTags = $this->selectedImage->tags;

        $this->show = true;
    }

    public function deleteImage()
    {
        $this->selectedImage->tags()->detach();
        $this->selectedImage->delete();
        $this->show = false;
        $this->emit('reload');
        $this->resetForm();
    }

    public function mount()
    {
        $this->allTags = Tag::orderBy('name', 'asc')->get();
    }

    public function updateTags() {
        $this->allTags = Tag::orderBy('name', 'asc')->get();
    } 

    private function resetForm() {
        if ($this->imageId) {
            $this->title = null;
            $this->description = null;
            $this->latitude = null;
            $this->longitude = null;
            $this->tags = [];
            $this->image = null;
            $this->imageId = null;
            $this->singleImageTags = [];
            $this->selectedImage = null;
        }
    }

    public function resetUploadForm()
    {   
        $this->resetForm();
        $this->modalHeaderText = 'Upload Image';
        $this->submitButtonText = 'Upload';

        $this->show = true;
    }

    public function render()
    {   
        return view('livewire.upload-image-form');
    }
}
