<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\BasicSetting as BS;
use App\BookingChat;
use Validator;

class ChatController extends Controller {

    protected $auth;

    public function __construct() { 

        $this->auth = \Auth::user();
    }

    /**
     * Display a chatboard
     *
     * @return Response
     */
    public function index() {
        
        $authDetail = \Auth::user();

        $user_id =  $authDetail->id;
        
        $bs = BS::first();

        BookingChat::where('user_id', $user_id)->where('message_type','out-msg')->update(['message_read' => '1']);
        
        $chatMessages = BookingChat::where('user_id',$user_id)->orderBy('created_at','ASC')->get();
        return view('front.booking.chat.chat',compact('chatMessages','authDetail','bs'));
    }

    /**
     * Store a chat in database
     *
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        
        $chat = new BookingChat;
        $chat->user_id = Auth::user()->id;
        $chat->message_content = $data['message'];
        $chat->message_type = 'in-msg';
        $chat->save();
        return 'true';
    }
}

