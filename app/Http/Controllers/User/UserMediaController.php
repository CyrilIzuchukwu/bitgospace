<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MediaVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserMediaController extends Controller
{



    public function index(Request $request)
    {
        $language = $request->query('language', 'english');

        $validLanguages = ['english', 'spanish', 'french', 'russia', 'chinese'];

        if (!in_array(strtolower($language), $validLanguages)) {
            $language = 'english'; // fallback
        }

        $videos = MediaVideo::where('language', strtolower($language))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.media', compact('videos', 'language', 'validLanguages'));
    }



}
