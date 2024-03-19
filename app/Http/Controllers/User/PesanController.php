<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilController;
use App\Models\Inbox;
use App\Models\Outbox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PesanController extends Controller
{
    protected $utilController;
    public function __construct(UtilController $utilController)
    {
        $this->utilController = $utilController;
    }

    public function kotakMasuk(Request $request)
    {
        $status_baca = $request->status_baca ?? '';
        $judul = $request->judul ?? '';
        $tanggal_awal = $request->tanggal_awal ?? "";
        $tanggal_akhir = $request->tanggal_akhir ?? "";
        $penerima_id = Auth::user()->id;
        $db = DB::table('inboxs as a')->join('users as b', 'a.sender_id', 'b.id')
            ->select('a.id', 'a.is_read', 'a.created_at as tanggal', 'a.subject', 'b.username as nama')
            ->where('a.receiver_id', $penerima_id)
            ->where('a.is_read', 'like', '%' . $status_baca . '%')->orderBy('is_read', 'asc')
            ->orderBy('a.created_at', 'desc')
            ->where(function ($query) use ($judul) {
                $query->where('b.username', 'like', '%' . $judul . '%')
                    ->orWhere('a.subject', 'like', '%' . $judul . '%');
            });
        if ($tanggal_awal && $tanggal_akhir) {
            $tanggal_akhir = date('Y-m-d', strtotime($tanggal_akhir) + 86400);
            $db = $db->whereBetween('a.created_at', [$tanggal_awal, $tanggal_akhir]);
        }
        $db = $db->paginate(10);
        return response()->json($db);
    }
    public function kotakKeluar(Request $request)
    {

        $judul = $request->judul ?? '';
        $tanggal_awal = $request->tanggal_awal ?? "";
        $tanggal_akhir = $request->tanggal_akhir ?? "";
        $pengirim_id = Auth::user()->id;
        $db = DB::table('outboxs as a')->join('users as b', 'a.receiver_id', 'b.id')
            ->select('a.id',  'a.created_at as tanggal', 'a.subject', 'b.username as nama')
            ->where('a.sender_id', $pengirim_id)
            ->orderBy('a.created_at', 'desc')
            ->where(function ($query) use ($judul) {
                $query->where('b.username', 'like', '%' . $judul . '%')
                    ->orWhere('a.subject', 'like', '%' . $judul . '%');
            });
        if ($tanggal_awal && $tanggal_akhir) {
            $tanggal_akhir = date('Y-m-d', strtotime($tanggal_akhir) + 86400);
            $db = $db->whereBetween('a.created_at', [$tanggal_awal, $tanggal_akhir]);
        }
        $db = $db->paginate(10);
        return response()->json($db);
    }

    public function kirimPesan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'body' => 'required',
            'receiver' => 'required',
            'file_upload' => 'required|max:2048',
            'user_id' => 'required',
        ], [
            'subject.required' => 'Subject Pesan Tidak Boleh Kosong',
            'receiver.required' => 'Penerima Tidak Boleh Kosong',
            'file_upload.max' => 'Berkas Tidak Boleh Lebih Dari 2MB',
            'body.required' => "Isi Pesan Tidak Boleh Kosong",
            'user_id.required' => "Pengirim Tidak Boleh Kosong",
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'tipe' => 'multi'], 400);
        }
        $filename = null;
        $subject = $request->subject;
        $body = $request->body;
        $user_id = $request->user_id;
        if ($request->hasFile('file_upload') === false) {
            return response()->json(['message' => 'Berkas Tidak Boleh Kosong', 'tipe' => 'single'], 400);
        }
        $ext = ['pdf', 'txt', 'docx', 'doc', 'xls', 'xlsx'];
        $uniqueString = Str::random(32);
        try {
            DB::beginTransaction();
            if (!in_array($request->file_upload, ['null', '', null], true) && $request->hasFile('file_upload')) {
                $filename = $this->utilController->saveFile($ext, $request->file_upload, 'BerkasPesan', $uniqueString);
            }
            $receiver_array = $request->input('receiver');
            $receiver = explode(',', $receiver_array);
            foreach ($receiver as $key) {
                $this->utilController->kirimPesan($user_id, $key, $subject, $body, $filename);
            }
            DB::commit();
            return response()->json([
                'message' => 'Sukses!',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            $log = [
                'filter' => 'kirimPesan',
                'status' => 'Gagal',
                'information' => 'Gagal, ' . $e->getMessage()
            ];
            $this->utilController->createLog($log);
            return response()->json(['message' => 'Gagal', 'tipe' => 'single'], 400);
        }
    }
    public function detailPesan(Request $request)
    {
        $jenis = $request->jenis_pesan;
        $id = $request->id_pesan;
        if ($jenis === 'KOTAK_MASUK') {
            $db = DB::table('inboxs as a')->join('users as b', 'a.sender_id', 'b.id')
                ->select('a.id', 'a.is_read', 'a.created_at as tanggal', 'a.subject', 'b.username as nama', 'a.file_upload')
                ->where('a.id', $id)->first();
            return response()->json([
                'id' => $db->id,
                'nama' => $db->nama,
                'tanggal' => Carbon::parse($db->created_at)->locale('id')->format('d-M-Y H:i'),
                'judul' => $db->subject,
                'keterangan' => $db->body,
                'status' => 'PENGIRIM',
                'file_upload' => $db->file_upload,
            ]);
        } else {
            $db = DB::table('outboxs as a')->join('users as b', 'a.receiver_id', 'b.id')
                ->select('a.id', 'a.is_read', 'a.created_at as tanggal', 'a.subject', 'b.username as nama', 'a.file_upload')
                ->where('a.id', $id)->first();
            return response()->json([
                'id' => $db->id,
                'nama' => $db->nama,
                'tanggal' => Carbon::parse($db->created_at)->locale('id')->format('d-M-Y H:i'),
                'judul' => $db->subject,
                'keterangan' => $db->body,
                'status' => 'PENERIMA',
                'file_upload' => $db->file_upload,
            ]);
        }
    }
    public function readPesan(Request $request)
    {
        $id = $request->id_pesan;
        try {
            DB::beginTransaction();
            $db = Inbox::where('id', $id)->first();
            $db->is_read = '1';
            $db->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
    public function deletePesan(Request $request)
    {
        $jenis = $request->jenis_pesan;
        $id = $request->id_pesan;
        if ($jenis === 'KOTAK_MASUK') {
            $db = Inbox::where('id', $id)->first();
        } else {
            $db = Outbox::where('id', $id)->first();
        }
        $file = $db->file_upload;
        $no_surat = $db->subject;
        $file_kotak_masuk = Inbox::where('file_upload', $file)->count();
        $file_kotak_keluar = Outbox::where('file_upload', $file)->count();
        try {
            DB::beginTransaction();
            if (($file_kotak_masuk == 1 && $file_kotak_keluar == 0) || ($file_kotak_keluar == 1 && $file_kotak_masuk == 0)) {
                $file_link = public_path($file);
                if (File::exists($file_link)) {
                    File::delete($file_link);
                }
            }
            $db->delete();
            $log = [
                'filter' => 'HAPUS_PESAN',
                'status' => "SUKSES",
                'keterangan' => Auth::user()->username . " Berhasil Menghapus Pesan Baru - " . $no_surat
            ];
            $this->utilController->create_log($log);
            DB::commit();
            return response()->json([
                'message' => 'Pesan Berhasil Dihapus!!',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            $log = [
                'filter' => 'HAPUS_PESAN',
                'status' => "Gagal",
                'keterangan' => Auth::user()->username . " Gagal Menghapus Pesan Baru - " . $no_surat . ' ' . $e->getMessage()
            ];
            $this->utilController->create_log($log);
            return response()->json(['message' => 'Gagal', 'tipe' => 'single'], 400);
        }
    }
}
