<?php

namespace App\Http\Controllers\Back;

use App\Events\MyEvent;
use App\Events\SendMessage;
use App\Events\SendMessagePopUp;
use App\Http\Controllers\Controller;
use App\Jobs\HappyBirthday;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $users = User::where(['level'=> 'user','notification'=>1])->get();
        $messages=Message::detectLang()->orderby('id','desc')->paginate(20);
        return view('back.messages.index',compact('users','messages'));
    }

    public function show(Message $message)
    {
        $messageItems=$message->items()->paginate(50);
        return view('back.messages.show',compact('message','messageItems'));

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);

        $input_data=[];
        if ($request->sms){
            $this->validate($request, [
                'user_message_pattern_code' => 'required',
            ],[
                'user_message_pattern_code.required'=>'کد پترن را وارد کنید'
            ]);

            option_update('user_message_pattern_code',$request->user_message_pattern_code);

            if (isset($request->variables) and count($request->variables)) {
                $request->validate([
                    'variables.*' => 'required',
                    'values.*' => 'required',
                ]);
                $input_data = array_combine($request->variables, $request->values);
            }
        }

        if ($request->users){
            $users=User::whereIn('id',$request->users)->get();
        }else{
            $users=User::where(['level'=> 'user','notification'=>1])->get();
        }

        if ($users->isEmpty()) {
            return response([
               'status'=>'error',
               'message'=> 'هیچ کاربری برای ارسال پیام، وجود ندارد.'
            ]);
        }


        $message=new Message();
        $message->title=$request->title;
        $message->description=$request->description;
        $message->email=$request->email ?: 0;
        $message->notification=$request->notification ?: 0;
        $message->popup=$request->popup ?: 0;
        $message->sms=$request->sms ?: 0;
        $message->sms_patternCode=$request->user_message_pattern_code ?: null;
        $message->sms_variables=json_encode($input_data);
        $message->save();
        $message->users()->attach($users);

        event(new SendMessage(Message::find($message->id)));
        toastr()->success('پیام ها با موفقیت وارد صف ارسال شدند');
        return response("success");
    }

    public function birthday()
    {
        $users = User::whereNotNull('birthday')->whereNotNull('mobile')->where('level', 'user')->get();
        return view('back.messages.birthday', compact('users'));
    }

    public function birthdayStore(Request $request)
    {
        $this->validate($request, [
            'user_birthday_pattern_code' => 'required',
        ]);
        $user_birthday_sms_send = 0;
        if ($request->user_birthday_sms_send) {
            $user_birthday_sms_send = 1;
        }

        option_update('user_birthday_sms_send', $user_birthday_sms_send);
        option_update('user_birthday_pattern_code', $request->user_birthday_pattern_code);

        User::whereNotNull('birthday')->whereNotNull('mobile')->where('level', 'user')->update(['notification' => 0]);
        if (isset($request->users)) {
            User::whereIn('id', $request->users)->update(['notification' => 1]);
        }
        toastr()->success('تنظیمات با موفقیت ذخیره شد.');

        return response("success");
    }


    public function destroy(Message $message)
    {
        $message->delete();

        return response('success');
    }
}
