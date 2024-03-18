<?php

namespace App\Http\Controllers;

use App\Http\Resources\FakultasResource;
use App\Models\LogUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use WhichBrowser\Parser;

class UtilController extends Controller
{


    public function createLog($array = [])
    {
        $request = app('request');
        $userAgent = $request->header('User-Agent');
        $parser = new Parser($userAgent);
        $osName = $parser->os->name;
        $browserName = $parser->browser->name;
        $logData = array_merge([
            'ip' => $request->ip(),
            'device' =>  $osName . ' ' . $browserName,
            'login_name' => Auth::user()->login_name,
        ], $array);
        LogUser::create($logData);
    }
}
