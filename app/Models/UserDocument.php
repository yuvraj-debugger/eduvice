<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class UserDocument extends Model
{
    use HasFactory;
    protected $table = 'users_document';
    
    protected $appends = [
        'test',
        'degree',
        'experienced',
        'passport',
        'lor_document',
        'university',
    ];
    
    
    protected $fillable = ['university_id','campus_id','english_test_doc','degree_doc','cv_experienced_doc','passport_number','sop','lor','passport_doc','created_by','status','type','created_at','updated_at'];
    
    public function scopeSearch($query, $term)
    {
        $term = '%' . $term . '%';
        $query->where(function ($query) use ($term) {
            $query->where('passport_number', 'like', $term);
        });
    }
    public function getTestAttribute()
    {
        return is_file($this->getTest) ? $this->getTest : env('APP_URL') . '/storage/file_uploads/' . $this->english_test_doc;
    }
    public function getDegreeAttribute()
    {
        return is_file($this->getDegree) ? $this->getDegree : env('APP_URL') . '/storage/file_uploads/' . $this->degree_doc;
    }
    public function getExperiencedAttribute()
    {
        return is_file($this->getExperienced) ? $this->getExperienced : env('APP_URL') . '/storage/file_uploads/' . $this->cv_experienced_doc;
    }
    public function getPassportAttribute()
    {
        return is_file($this->getPassport) ? $this->getPassport : env('APP_URL') . '/storage/file_uploads/' . $this->passport_doc;
    }
    public function getLorDocumentAttribute()
    {
        return is_file($this->getLorDocument) ? $this->getLorDocument : env('APP_URL') . '/storage/file_uploads/' . $this->lor;
    }
    public function getCreated()
    {
       return $this->hasOne(User::class, 'id','created_by');
    }
    public function getFile($file)
    {
        return env('APP_URL').'/storage/file_uploads/'.$file;
    }
   
    public function getUniversity()
    {
        return $this->hasOne(University::class,'id','university_id');
    }
    public function getCampus()
    {
        return $this->hasOne(UniversityCampus::class,'id','campus_id');
    }
    public function getCourse()
    {
        return $this->hasOne(Course::class,'id','course_id');
    }
    public function getMessage()
    {
        return $this->hasMany(Message::class,'document_id','id');
    }
    public function MessageCount($document_id)
    {
        if(! empty($document_id)){
            $documentCount = Message::where('document_id',$document_id)->where('created_by','!=',Auth::user()->id)->whereNull('is_read')->count();
            return $documentCount;
        }
    }
    public function getUniversityAttribute()
    {
        $university = University::where('id',$this->university_id)->get();
        return ! empty($university) ? $university : '';
    }
}

