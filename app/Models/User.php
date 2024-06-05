<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'date_of_birth',
        'gender',
        'martial_status',
        'contact',
        'address',
        'state',
        'city',
        'country',
        'type',
        'remember_token',
        'pincode'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url'
    ];

    public function scopeSearch($query, $term)
    {
        $term = '%' . $term . '%';
        $query->where(function ($query) use ($term) {
            $query->where('name', 'like', $term)
                ->orwhere('email', 'like', $term);
        });
    }

    public function getProfilePhotoUrl()
    {
        return is_file(Auth::user()->profile_photo_url) ? Auth::user()->profile_photo_url : env('APP_URL') . '/storage/' . $this->profile_photo_path;
    }

    public function getStatus()
    {
        if (! empty($this->email_verified_at)) {
            $status = 'Verified';
        }else{
            $status = 'Not Verified';
        }
        return $status;
    }

    public function getStep()
    {
        if ($this->step == 0) {
            $step = 'Lead';
        }
        if ($this->step == 1) {
            $step = 'Onboarding';
        }
        if ($this->step == 3) {
            $step = 'Complete';
        }
        return $step;
    }

    public function getEducation()
    {
        return $this->hasMany(HighSchool::class, 'created_by', 'id');
    }

    public function getScore()
    {
        return $this->hasMany(TestScore::class, 'created_by', 'id');
    }

    public function getPreference()
    {
        return $this->hasOne(Preference::class, 'created_by', 'id');
    }

    public function getDocument()
    {
        return $this->hasOne(UserDocument::class, 'created_by', 'id');
    }

    public function getAreaInterest()
    {
        return $this->hasOne(AreaOfInterest::class, 'created_by', 'id');
    }

    public function getCountry()
    {
        $prefernce = Preference::where('created_by', $this->id)->first();
        if (! empty($prefernce->country_id)) {
            $prefernceCountry = json_decode($prefernce->country_id);
            $coutries = Country::whereIn('id', $prefernceCountry)->get()
                ->pluck('name')
                ->toArray();
            return ! empty($coutries) ? implode(',', $coutries) : '';
        }
    }
}
