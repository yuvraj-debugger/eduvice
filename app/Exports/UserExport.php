<?php
namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class UserExport implements FromQuery
{
    use Exportable;

    protected $user;

    public function __construct($user)
    {
        $this->user=$user;
    }

    public function query()
    {
        return User::query()->whereKey($this->user);
    }
}
