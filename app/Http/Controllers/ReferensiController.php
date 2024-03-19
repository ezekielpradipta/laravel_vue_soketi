<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ReferensiController extends Controller
{
    protected $utilController;
    public function __construct(UtilController $utilController)
    {
        $this->utilController = $utilController;
    }
    public function getRoleListPagination(Request $request)
    {
        $filter_nama = $request->filter_nama;
        $paginate = $request->paginate;
        $data = DB::table('roles')->where('role_name', '!=', 'admin')
            ->where('role_name', 'like', '%' . $filter_nama . '%')
            ->paginate($paginate);
        return response()->json($data);
    }
    public function getRoleList()
    {
        $data = DB::table('roles')->where('role_name', '!=', 'admin')->get();

        return response()->json($data);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ' required ',

        ], [
            'id.required' => 'User Tidak Boleh Kosong',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'tipe' => 'multi'], 400);
        }
        $user = User::where('id', $request->id)->first();
        if (!$user) {
            return response()->json(
                [
                    'message' => 'Gagal, User Tidak Ditemukan',
                    'tipe' => 'single'
                ],
                400
            );
        }
        try {
            DB::beginTransaction();
            User::where('id', $request->id)->update(['password' => Hash::make("qwerty123")]);
            $log = [
                'filter' => 'resetPassword',
                'status' => 'Sukses',
                'information' => 'Berhasil Reset Password ' . 'User ' . $user->username
            ];
            $this->utilController->createLog($log);
            DB::commit();
            return response()->json(['message' => 'Sukses'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            $log = [
                'filter' => 'resetPassword',
                'status' => 'Gagal',
                'information' => 'Gagal Reset Password ' . 'User ' . $user->username . $e->getMessage()
            ];
            $this->utilController->createLog($log);
            return response()->json(["message" => "Gagal" . $user->usename . ' ' . $e->getMessage(), 'tipe' => 'single']);
        }
    }

    public function gantiPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ' required ',
            'password_baru' => ' required ',
            'password_lama' => 'required',

        ], [
            'id.required' => 'User Tidak Boleh Kosong',
            'password_baru.required' => 'Password Baru Tidak Boleh Kosong',
            'password_lama.required' => 'Password Lama Tidak Boleh Kosong',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'tipe' => 'multi'], 400);
        }
        $user = User::where('id', $request->id)->first();
        if (!$user) {
            return response()->json(
                [
                    'message' => 'Gagal, User Tidak Ditemukan',
                    'tipe' => 'single'
                ],
                400
            );
        }
        if (!Hash::check($request->password_lama, $user->password)) {

            return response()->json([
                'message' => ' Gagal! Password Lama Tidak Sesuai',
                'tipe' => 'single'
            ], 400);
        }
        try {
            DB::beginTransaction();
            $user->password = Hash::make($request->password_baru);
            $user->save();
            $log = [
                'filter' => 'gantiPassword',
                'status' => 'Sukses',
                'information' => 'Berhasil Ganti Password ' . 'User ' . $user->username
            ];
            $this->utilController->createLog($log);
            DB::commit();
            return response()->json([
                'message' => 'Password Berhasil Dirubah',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            $log = [
                'filter' => 'gantiPassword',
                'status' => 'Gagal',
                'information' => 'Gagal Ganti Password ' . 'User ' .  $user->username . ' ' . $e->getMessage()
            ];
            $this->utilController->createLog($log);
            return response()->json(["message" => "Gagal" . $user->usename . ' ' . $e->getMessage(), 'tipe' => 'single']);
        }
    }
    public function getUserList(Request $request)
    {
        $filter_nama = $request->filter_nama;
        $user_id = $request->user_id;
        $data = DB::table('role_user as a')
            ->select('b.id', 'b.username', 'c.role_name', 'a.role_id')
            ->join('users as b', 'a.user_id', '=', 'b.id')
            ->join('roles as c', 'c.id', '=', 'a.role_id')
            ->where('b.username', 'like', '%' . $filter_nama . '%')
            ->where('c.id', '!=', '1')
            ->where('a.user_id', '!=', $user_id)
            ->get();

        return response()->json($data);
    }
}
