<?php

namespace App\Http\Controllers;

use App\Events\KirimNotifikasi;
use App\Http\Resources\FakultasResource;
use App\Models\Inbox;
use App\Models\LogUser;
use App\Models\Outbox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use WhichBrowser\Parser;
use Illuminate\Support\Str;

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
    public function saveFile($ext, $file, $folder_name, $keterangan)
    {
        $dir = 'berkas/' . $folder_name . '/';
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileSizeInBytes = $file->getSize();
        $sanitizedFileName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME));
        $filename =  $keterangan .  date('YmdHis') . '-' . $sanitizedFileName . '.' . $extension;
        $maxFileSizeInBytes = 2 * 1024 * 1024;
        if ($fileSizeInBytes > $maxFileSizeInBytes) {
            return response()->json(['message' => 'Maksimum Ukuran File (5MB).', 'tipe' => 'single'], 403);
        }
        if (!in_array(strtolower($extension), $ext)) {
            return response()->json(['message' => 'Format File Bukan PDF / WORD / EXCEL', 'tipe' => 'single'], 403);
        }
        $absolutePath = public_path($dir);
        $relativePath = $dir . $filename;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        $file->move($absolutePath, $filename);

        return $relativePath;
    }
    public function kirimPesan($id_pengirim, $id_penerima, $subject, $body, $file_upload)
    {
        Inbox::create([
            'sender_id' => $id_pengirim,
            'receiver_id' => $id_penerima,
            'subject' => $subject,
            'body' => $body,
            'file_upload' => $file_upload,
            'is_read' => '0',

        ]);
        Outbox::create([
            'sender_id' => $id_pengirim,
            'receiver_id' => $id_penerima,
            'subject' => $subject,
            'body' => $body,
            'file_upload' => $file_upload,

        ]);
        broadcast(new KirimNotifikasi($id_penerima));
    }
}
