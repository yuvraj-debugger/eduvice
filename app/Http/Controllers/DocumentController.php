<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class DocumentController extends Controller
{
    //
    public function document()
    {
        return view('admin.document.index');
    }
    public function message($id)
    {
        return view('admin.document.message',['id'=>$id]);
    }
    public function view($id)
    {
        return view('admin.document.view',['id'=>$id]);
    }
    public function messageAdmin(Request $request)
    {
        if(!empty($request->message))
        {
            $message = new Message();
            $message->message = $request->message;
            $message->type=1;
            $message->document_id = $request->document_id;
            $message->created_by = Auth::user()->id;
            $message->save();
            
           
            $userDocument = Message::where('document_id',$message->document_id)->first();
            if(! empty($userDocument)){
                $user = $userDocument->getCreated->email;
                Mail::send('email.userMessage', [
                    'message' => $request->message
                ], function ($message) use ($user) {
                    $message->to($user);
                    $message->subject('Admin sent you message on Eduvice');
                });
            }
            
        }
        
        $messageDoc = $request->message_document;
        if(!empty($messageDoc))
        {
            $message = new Message();
            $messageDoc=$messageDoc->getClientOriginalName();
            $request->message_document->storeAs('message_document', $messageDoc, 'public');
            $message->message ='-';
            $message->message_document =  $messageDoc;
            $message->document_id = $request->document_id;
            $message->type = 2;   
            $message->created_by = Auth::user()->id;
            if (! $message->save()) {
                throw new \Exception("Data not saved");
            }
        }
        $message=Message::where('document_id',$request->document_id)->get();
        return response()->view('messsageResponse',['message_id'=>$message]);
    }
    
}
