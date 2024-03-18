<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReferensiController extends Controller
{
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
}
