<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Notifications\WeatherAlert;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'name' => 'required',
            'long' => 'required',
            'lat' => 'required',
        ]);


        //then find the user
        $user = User::find($user->id);

        $user->name = $request->input('name');
        $user->settings()->set('lat', $request->input('lat'));
        $user->settings()->set('long', $request->input('long'));
        $user->settings()->set('storm', $request->input('storm'));
        $user->settings()->set('drizzle', $request->input('drizzle'));
        $user->settings()->set('rain', $request->input('rain'));
        $user->settings()->set('atmosphere', $request->input('atmosphere'));
        $user->settings()->set('snow', $request->input('snow'));

        return response()->json($user);
    }

    /**
     * Update the user's profile information.
     */
    public function destroy(Request $request)
    {
        $user = $request->user();
        $user = User::find(Auth::user()->id);

//        auth()->logout();

        if ($user->delete()) {

            return Redirect::route('home')->with('global', 'Your account has been deleted!');
        }

        return response()->json($user);
    }
}
