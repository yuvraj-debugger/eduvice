<?php

namespace Modules\Blog\Http\Livewire;

use App\Exports\PostExport;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Blog\Entities\Posts;

class PostsLivewire extends Component
{
    
    use WithPagination;
    
    public $paginate = 10;
    
    public $search = '';
    
    public $checked = [];
    
    public $selectPage = false;
    
    public $selectAll = false;
    
    public $sortField = 'title';
    
    public $sortDirection = 'asc';
    
    public function getPostProperty()
    {
        return Posts::search(trim($this->search))->orderBy($this->sortField, $sortDirection)->paginate($this->paginate);
    }
    
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        
        $this->sortField = $field;
    }
    
    public function render()
    {
        $posts = Posts::search(trim($this->search))->orderBy($this->sortField, $this->sortDirection)->paginate($this->paginate);
        return view('blog::livewire.posts',compact('posts'));
    }
    public function deleteRecords()
    {
        Posts::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll = false;
        $this->selectPage = false;
        session()->flash('info', 'Selected Records were deleted Successfully');
    }
    
    public function deleteRecord($post_id)
    {
        $post = Posts::findOrFail($user_id);
        $post->delete();
        $this->checked = array_diff($this->checked, [
            $post_id
        ]);
        session()->flash('info', 'Record deleted successfully');
    }
    
    public function exportSelected()
    {
        return (new PostExport($this->checked))->download('posts.xlsx');
    }
    
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = $this->post->pluck('id');
        } else {
            $this->checked = [];
        }
    }
    
    public function isChecked($post_id)
    {
        return in_array($post_id, $this->checked);
    }
    
    public function updatedChecked()
    {
        $this->selectPage = false;
    }
}


