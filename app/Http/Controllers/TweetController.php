<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;
use Illuminate\Support\Facades\Auth;

class TweetController extends Controller
{
    //
    public function showTimelinePage()
    {
        $tweet = Tweet::latest()->simplePaginate(3);
        //dd($tweets);
        return view('timeline', ['tweets' => $tweet]); 
    }

    public function postTweet(Request $request)
    {
        $validator = $request->validate([
            'tweet' => ['required', 'string', 'max:280'],
        ]);

        Tweet::create([
            'user_id' => Auth::user()->id,
            'tweet' => $request->tweet,
        ]);

        return redirect()->route('timeline');
    }

    public function destroy($id)
    {
        $tweet = Tweet::find($id);
        $tweet->delete();

        return redirect()->route('timeline');
    }
}
