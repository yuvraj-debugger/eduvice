<?php
namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\UserExport;

class UserPagination extends Component
{
    use WithPagination;

    public $paginate = 10;

    public $search = '';

    public $checked = [];

    public $selectPage = false;

    public $selectAll = false;

    public $sortField = 'name';

    public $sortDirection = 'DESC';

    public function getUserProperty()
    {
        return User::search(trim($this->search))->orderBy($this->sortField, $this->sortDirection)->paginate($this->paginate);
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
        $users = User::select(['users.*','team_user.role as role'])->search(trim($this->search))->orderBy($this->sortField, $this->sortDirection)->join('team_user','users.id','=','team_user.user_id')->paginate($this->paginate);
        return view('livewire.user-pagination', [
            'users' => $users
        ]);
    }

    public function deleteRecords()
    {
        User::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll = false;
        $this->selectPage = false;
        session()->flash('info', 'Selected Records were deleted Successfully');
    }

    public function deleteRecord($user_id)
    {
        $user = User::findOrFail($user_id);
        $user->delete();
        $this->checked = array_diff($this->checked, [
            $user_id
        ]);
        session()->flash('info', 'Record deleted successfully');
    }

    public function exportSelected()
    {
        return (new UserExport($this->checked))->download('users.xlsx');
    }

    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = $this->user->pluck('id');
        } else {
            
            dd('3333');
            $this->checked = [];
        }
    }

//     public function updatedChecked()
//     {
//         $this->selectPage = false;
//     }
}
