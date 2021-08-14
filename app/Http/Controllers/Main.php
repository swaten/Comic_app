<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Mail;


class Main extends Controller
{
  public function index()
  {
    return view('main_view');
  }

  public function subscribe_form(Request $request){

    $request->validate([

        'email_id'     =>  'required|unique:users,email|email:rfc,dns',
      ]);
      $insert_arr = array('email'=>$request->email_id,'subscribed'=>'1');
      DB::table('users')->insert([$insert_arr]);

      // Uncomment this line when you have email configurations
      // $this->send_comic($request->email_id);
      // Uncomment this line when you have email configurations

      return json_encode(array('msg'=>'Successfully Stored.','email_id'=>$insert_arr['email']));

  }

  public function unsubscribe_form(Request $request){
        DB::table('users')
            ->where('email', $request->subscribed_id)
            ->update(['subscribed' => '0']);
      //print_r($request->subscribed_id);
      return json_encode(array('msg'=>'Successfully Unsubscribe.'));

  }




  public function send_comic($send_email_to=Null){
    echo "<pre>";
    $url = 'https://c.xkcd.com/random/comic';
    $comic_headers = get_headers($url)[8];
    $random_url = explode("Location: ", $comic_headers)[1];
    $comic_id = basename($random_url);

    // get comic details
    $comic_api_url = 'http://xkcd.com/'.$comic_id.'/info.0.json';

    $api_data = json_decode(file_get_contents($comic_api_url));



    if (empty($api_data)){
        print "Nothing returned from url.<p>";
    }
    else{

        Mail::send('emails.comic_view', ['data'=>$api_data] , function($message)use($api_data) {
            $message->to($send_email_to)
                    ->subject($api_data->safe_title);


                $message->attach($api_data->img);

        });
        if (Mail::failures()) {
            return view('emails.comic_view')->with(array('data'=>$api_data));
        }else{
             return response()->success('Great! Successfully send in your mail');
        }

    }
    // exit;
      // Mail::send('emails.comic_view', ['data'=>$api_data] , function($message){
      // $message->to($send_email_to)
      //         ->subject($api_data->safe_title);
      //
      // if (Mail::failures()) {
      //      return response()->Fail('Sorry! Please try again latter');
      // }else{
      //      return response()->success('Great! Successfully send in your mail');
      // }
  }
}
