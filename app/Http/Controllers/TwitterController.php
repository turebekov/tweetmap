<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twitter;


class TwitterController extends Controller
{
    public function twitterUserTimeLine()
    {
        $data = Twitter::getUserTimeLine(['count' => 10, 'format' => 'array']);

        return view('twitter.twitter', compact('data'));
    }

    public function homeTimeline()
    {
        $data = Twitter::getHomeTimeline(['count' => 20, 'format' => 'array']);
        return view('twitter.twitter')->with(compact('data'));
    }

    public function twitmap()
    {
        return view('twitter.twitMap');
    }

    public function getTwits()
    {
        $twits = Twitter::getUserTimeLine(['count' => 10, 'format' => 'array']);//'screen_name' => 'potus'
        //$data = Twitter::getGeoReverse(['lat'=>51.147537,'long' => 1.395202]);
        return response()->json(['twits' => $twits, 'success' => true]);
    }

    public function tweet(Request $request)
    {
        $this->validate($request, [
            'tweet' => 'required'
        ]);

        $newTwitte = ['status' => $request->tweet];


        if (!empty($request->images)) {
            foreach ($request->images as $key => $value) {
                $uploaded_media = Twitter::uploadMedia(['media' => File::get($value->getRealPath())]);
                if (!empty($uploaded_media)) {
                    $newTwitte['media_ids'][$uploaded_media->media_id_string] = $uploaded_media->media_id_string;
                }
            }
        }

        $twitter = Twitter::postTweet($newTwitte);


        return back();
    }

    public function saveTweet(Request $request)
    {
        $geo = json_encode($request->data['geo']);
        $username = $request->data['user']['screen_name'];
        $text = $request->data['text'];


        if (!is_null($geo) && !is_null($username) && !is_null($text)) {
            $tweet = new \App\Twitter();
            $tweet->username = $username;
            $tweet->geo = $geo;
            $tweet->tweet_text = $text;

        }
        if ($tweet->save()){
            return response()
                ->json(['success' => true,
                    'message' => 'Ваш твит сохранено в базе ! '
                ]);
        }


    }
}
