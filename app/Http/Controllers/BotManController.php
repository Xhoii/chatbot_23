<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Conversations\ExampleConversation;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->hears('hello', function (BotMan $bot) {
            // $attachment = new Image('https://static.tumblr.com/1171f60ff599233dd980af8438c49210/tskjndn/111oe05k6/tumblr_static_ep66egpd5jscssk40w40gockg_640_v2.gif', [
            //     'custom_payload' => true,
            // ]);

            // // Build message object
            // $message = OutgoingMessage::create('Hello')
            //             ->withAttachment($attachment);

            // // Reply message object
            // $bot->reply($message);
            $bot->startConversation(new ExampleConversation());
        });

        $botman->listen();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('tinker');
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {
        $bot->startConversation(new ExampleConversation());
    }
}
