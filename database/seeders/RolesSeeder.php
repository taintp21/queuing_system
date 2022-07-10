<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesSeeder extends Seeder
{
    public function run(Request $request)
    {
        DB::table('roles')->insert([
            'role_name' => 'Superadmin',
            'ip_address' => $request->ip(),
            'description' => 'Superadmin',
            'role_delegation' => 'tb,dv,cs,bc,vt,tk,nk,tb_action,dv_action,cs_action,vt_action,tk_action',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
