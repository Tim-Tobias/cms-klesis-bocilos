<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;

class WebConfigController extends Controller
{
    public function index()
    {
        $social_medias = SocialMedia::get();

        return view('modules.dashboard.web-config.index', compact('social_medias'));
    }
}
