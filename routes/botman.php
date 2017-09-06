<?php
use App\Http\Controllers\BotManController;
use App\Conversations\HelpConversation;

$botman = resolve('botman');

$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello!');
});

$botman->hears('How are you?', function ($bot) {
    $bot->typesAndWaits(2);
    $bot->reply("I'm fine. - And you?");
});

$botman->hears('Fine', function($bot){
    $bot->startConversation(new HelpConversation);
});

$botman->hears('Help', function($bot){
    $bot->startConversation(new HelpConversation);
});

$botman->hears('Bye', function($bot){
    $bot->reply('Bye.');
});

$botman->hears('Thanks', function($bot){
    $bot->reply('My pleasure.');
});

// $botman->hears('Start conversation', BotManController::class.'@startConversation');
