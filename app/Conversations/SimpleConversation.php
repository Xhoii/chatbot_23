<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class SimpleConversation extends Conversation
{
    protected $firstname;

    protected $userAnswer;

    /**
     * First question
     */
    public function askReason()
    {
        // Huh - you woke me up.
        $question = Question::create("What do you need?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create('Tell a joke')->value('joke'),
                Button::create('Give me a fancy quote')->value('quote'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'joke') {
                    $joke = json_decode(file_get_contents('http://api.icndb.com/jokes/random'));
                    $this->say($joke->value->joke);
                    $this->didYouLikeTheJoke();
                } else {
                    $this->say(Inspiring::quote());
                }
            }
        });
    }

    public function askForName()
    {
        $this->ask('Hello! What is your name?', function(Answer $answer) {
            // Save result
            $this->firstname = $answer->getText();

            $this->say('Nice to meet you '.$this->firstname);
            $this->askReason();
        });
    }

    public function didYouLikeTheJoke()
    {

        $this->ask('Do you want another one?', function(Answer $answer) {
            $userAnswer = $answer->getText();
            if ($userAnswer === 'Yes') {
                $joke = json_decode(file_get_contents('http://api.icndb.com/jokes/random'));
                $this->say($joke->value->joke);
            }
            // else {
            //     $this->sadImage();
            // }
        });
    }

    // public function sadImage()
    // {
    //     $attachment = new Image('https://media.giphy.com/media/d2lcHJTG5Tscg/giphy.gif', [
    //         'custom_payload' => true,
    //     ]);

    //     $outgoing = new OutgoingMessage;
    //     $message = $outgoing->withAttachment($attachment);

    //     $this->say($message);
    // }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askForName();
    }
}
