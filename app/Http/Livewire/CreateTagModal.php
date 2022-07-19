<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use Livewire\Component;
use App\Http\Livewire\Modal;

class CreateTagModal extends Modal
{
    public $newTag = '';

    public function createTag()
    {
        $this->validate([
            'newTag' => 'unique:tags,name|required|min:3',
        ]);

        try {
            Tag::create([
                'name' => $this->newTag,
            ]);

            $this->emit('updateTags');

            $this->show = false;

        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.create-tag-modal');
    }
}
