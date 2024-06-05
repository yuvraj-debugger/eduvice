<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AreaOfInterest extends Model
{
    use HasFactory;

    protected $table = 'area_of_interest';
    
    protected $appends = [
        'selected'
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'position',
        'has_icon',
        'icon_png',
        'icon_png_high',
        'is_selected',
        'status',
        'type',
        'created_by'
    ];
    
    public function scopeSearch($query, $term)
    {
        $term = '%' . $term . '%';
        $query->where(function ($query) use ($term) {
            $query->where('title', 'like', $term);
        });
    }
    public function getSelectedAttribute()
    {
        $areaInterest = Preference::where('created_by',Auth::user()->id)->where('area_of_interest',$this->id)->first();
        if($areaInterest)
        {
            return true;
        }
        return false;
    }
}
