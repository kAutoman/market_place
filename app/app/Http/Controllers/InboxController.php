<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDirectMessage;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Message;
use Nahid\Talk\Conversations\Conversation;
use App\Models\ReportedListing;
use App\Rules\CaptchaCheck;
use Talk;
use Validator;
use MetaTag;
use GNUPG;


class InboxController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        MetaTag::set('title', "Messages");

        $inboxes = Talk::getInbox();

        return view('inbox.index', compact('inboxes'));
    }

    public function createMessageViaListing($listing)
    {
        MetaTag::set('title', "Create Message");
        return view('inbox.create')->with('listing',$listing);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store($listing,Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($request->all(), [
            'message' => 'required',
            'captcha' => ['required', new CaptchaCheck]
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

      

        $user = User::find($listing->user->id);

        if($user->id == auth()->user()->id) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        if($user == null) {
            abort(404);
        }

        $message = $request->input('message');


        if($request->input('encrypt') != null) {
            if($user->pgp_key != null) {
                $gpg = new gnupg();
                $info = $gpg->import($user->pgp_key);
                $gpg->addencryptkey($info['fingerprint']);
                $message = $gpg->encrypt($request->input('message'));
            }
        }

        Talk::setAuthUserId(auth()->user()->id);
        Talk::sendMessageByUserId($listing->user->id, $message);
        $conversationId = Talk::isConversationExists($listing->user->id);
        $user->increment('unread_messages');


        return redirect(route('inbox.show', $conversationId));
    }

   

    public function sendMessage(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($request->all(), [
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        if($request->get('recipient_id') == auth()->user()->id) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $user = User::find($request->get('recipient_id'));
        if($user == null) {
            abort(404);
        }
        
        $message = $request->input('message');

        if($request->input('encrypt') != null) {
            if($user->pgp_key != null) {
                $gpg = new gnupg();
                $info = $gpg->import($user->pgp_key);
                $gpg->addencryptkey($info['fingerprint']);
                $message = $gpg->encrypt($request->input('message'));
            }
        }


        Talk::setAuthUserId(auth()->user()->id);
        Talk::sendMessageByUserId($request->get('recipient_id'), $message);
        $conversationId = Talk::isConversationExists($request->get('recipient_id'));


        $user->increment('unread_messages');


        return redirect(route('inbox.show', $conversationId));
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {


        MetaTag::set('title', "Conversation");

        $inboxes = Talk::getInbox();
        $limit = 2000;
        $offset =0;
        $conversations = Talk::getConversationsAllById($id, $offset, $limit);
        if($conversations == null) {
            abort(404);
        }
        // dd($conversations->withUser);

        $messages = $conversations->messages;
        $recipient = $conversations->withUser;

        #mark as seen
        foreach($messages as $message) {
            if(!$message->is_seen && auth()->user()->id != $message->sender->id) {
                Talk::makeSeen($message->id);
                auth()->user()->unread_messages = auth()->user()->unread_messages -1;
                auth()->user()->update();
            }
        }

        return view('inbox.show', compact('messages', 'recipient','inboxes','id'));
    }

    public function report($id,Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($request->all(), [
            'reason' => 'required',
            'captcha' => ['required', new CaptchaCheck]
        ]);

        if ($validator->fails()) {
            return redirect('inbox/'.$id.'#report')->withErrors($validator)
                ->withInput();
        }

        ReportedListing::create([
            'reason' => $request->input('reason'),
            'notes' => $request->input('notes'),
            'user_id' => auth()->user()->id,
            'reported_user' => 0,
            'reported_conversation' => $id,
        ]);

        return redirect('inbox/'.$id. '#report')->with('message','The report is received, the moderator will see this situation within 24 hours. We can sent you message about the report, if not answered within the 3 days. Case will be closed.');
    
    }
}
