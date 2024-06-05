<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    
    protected $table = 'message';
    
    protected $appends = [
        'name',
        'profile',
        'profile_photo_url',
        'message_document_url'
    ];
    protected $fillable = [
        'message',
        'document_id',
        'status',
        'type',
        'created_by'
    ];
    public function getCreated()
    {
        return $this->hasOne(User::class,'id','created_by');
    }
    public function getStudent()
    {
        return $this->hasOne(TeamUser::class,'user_id','created_by');
    }
    public function getNameAttribute()
    {
        return ! empty($this->getCreated) ? $this->getCreated->name :'';
    }
    public function getProfileAttribute()
    {
        return ! empty($this->getCreated) ? $this->getCreated->profile_photo_path :'';
    }
    public function getProfilePhotoUrlAttribute()
    {
        return ! empty($this->getCreated) ? $this->getCreated->profile_photo_url :'';
    }
    public function getmessageDocument($document)
    {
        return env('APP_URL').'/storage/message_document/'.$document;
    }   
    public function getDocument()
    {
        return $this->hasOne(UserDocument::class,'document_id','id');
    }
    public function getmessageDocumentUrlAttribute()
    {
        return env('APP_URL').'/storage/message_document/'.$this->message_document;
    }
}
