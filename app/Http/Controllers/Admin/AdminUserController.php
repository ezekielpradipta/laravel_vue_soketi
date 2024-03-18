<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{

    protected $utilController;
    public function __construct(UtilController $utilController)
    {
        $this->utilController = $utilController;
    }
    public function getUserListPagination(Request $request)
    {
        $filter_nama = $request->filter_nama;
        $paginate = $request->paginate;
        $data = DB::table('role_user as a')
            ->select('b.id', 'b.username', 'c.role_name', 'a.role_id')
            ->join('users as b', 'a.user_id', '=', 'b.id')
            ->join('roles as c', 'c.id', '=', 'a.role_id')
            ->where('b.username', 'like', '%' . $filter_nama . '%')
            ->where('c.id', '!=', '1')
            ->paginate($paginate);

        return response()->json($data);
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'role_id' => 'required',
            'password' => 'required',


        ], [
            'username.required' => 'Nama Dosen Tidak Boleh Kosong',
            'role_id.required' => 'Kode Dosen Tidak Boleh Kosong',
            'password.required' => 'Jenis Dosen Tidak Boleh Kosong',

        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'tipe' => 'multi'], 400);
        }
        try {
            DB::beginTransaction();
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ]);
            if ($user) {
                $user->roles()->sync($request->role_id);
            }
            $log = [
                'filter' => 'CreateUser',
                'status' => 'Sukses',
                'information' => 'Berhasil Menambah ' . 'User ' . $request->username
            ];
            $this->utilController->createLog($log);
            DB::commit();
            return response()->json(['message' => 'Sukses'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            $log = [
                'filter' => 'CreateUser',
                'status' => 'Gagal',
                'information' => 'Gagal Menambah ' . 'User ' . $request->username . $e->getMessage()
            ];
            $this->utilController->createLog($log);
            return response()->json(["message" => "Gagal" . $request->usename . ' ' . $e->getMessage(), 'tipe' => 'single']);
        }
    }

    public function updateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ], [
            'id.required' => 'User ID Tidak Boleh Kosong',
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
            $data = User::where('id', $request->id)->update([
                'username' => $request->username,
            ]);
            if ($data) {
                $user->roles()->sync($request->role_id);
            }
            $log = [
                'filter' => 'updateUser',
                'status' => 'Sukses',
                'information' => 'Berhasil Update ' . 'User ' . $user->username
            ];
            $this->utilController->createLog($log);
            DB::commit();
            return response()->json(['message' => 'Sukses'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            $log = [
                'filter' => 'updateUser',
                'status' => 'Gagal',
                'information' => 'Gagal Update ' . 'User ' . $user->username . $e->getMessage()
            ];
            $this->utilController->createLog($log);
            return response()->json(["message" => "Gagal" . $user->usename . ' ' . $e->getMessage(), 'tipe' => 'single']);
        }
    }
    public function deleteUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ], [
            'id.required' => 'User ID Tidak Boleh Kosong',
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
            User::where('id', $request->id)->delete();
            $log = [
                'filter' => 'deleteUser',
                'status' => 'Sukses',
                'information' => 'Berhasil Delete ' . 'User ' . $user->username
            ];
            $this->utilController->createLog($log);
            DB::commit();
            return response()->json(['message' => 'Sukses'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            $log = [
                'filter' => 'deleteUser',
                'status' => 'Gagal',
                'information' => 'Gagal Delete ' . 'User ' . $user->username . $e->getMessage()
            ];
            $this->utilController->createLog($log);
            return response()->json(["message" => "Gagal" . $user->usename . ' ' . $e->getMessage(), 'tipe' => 'single']);
        }
    }
}
