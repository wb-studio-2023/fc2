<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;

class MultiAuthTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //管理者
        $init_admins = [
            [
                // 'name' => 'wb-studio-admin',
                // 'email' => 'wb-studio-affiliate-admin',
                // 'password' => 'wb-studio-affiliate-admin-2024',
                'name' => 'test',
                'email' => 'test',
                'password' => 'testpass',
            ],

        ];

        foreach($init_admins as $init_admin) {

            $admin = new Admin();
            // $admin->name = $init_admin['name'];
            $admin->email = $init_admin['email'];
            $admin->password = Hash::make($init_admin['password']);
            $admin->created_at = now();
            $admin->updated_at = now();
            $admin->save();
        }

        // //会員
        // $init_members = [
        //     [
        //         'name' => 'テスト会員',
        //         'email' => 'test@test.com',
        //         'password' => 'testpass',
        //         'delete_flg' => 0,
        //         'status' => 1,
        //     ],

        // ];

        // foreach($init_members as $init_member) {

        //     $member = new Member();
        //     $member->email = $init_member['email'];
        //     $member->password = Hash::make($init_member['password']);
        //     $member->name = $init_member['name'];
        //     $member->delete_flg = $init_member['delete_flg'];
        //     $member->status = $init_member['status'];
        //     $member->created_at = now();
        //     $member->updated_at = now();
        //     $member->save();
        // }
        // //会員
        // $init_members = [
        //     [
        //         'name' => 'テスト会員01',
        //         'email' => '01@error.com',
        //         'password' => 'testpass',
        //         'delete_flg' => 1,
        //         'status' => 1,
        //     ],

        // ];

        // foreach($init_members as $init_member) {

        //     $member = new Member();
        //     $member->email = $init_member['email'];
        //     $member->password = Hash::make($init_member['password']);
        //     $member->name = $init_member['name'];
        //     $member->delete_flg = $init_member['delete_flg'];
        //     $member->status = $init_member['status'];
        //     $member->created_at = now();
        //     $member->updated_at = now();
        //     $member->save();
        // }
        // //会員
        // $init_members = [
        //     [
        //         'name' => 'テスト会員02',
        //         'email' => '02@error.com',
        //         'password' => 'testpass',
        //         'delete_flg' => 0,
        //         'status' => 0,
        //     ],

        // ];

        // foreach($init_members as $init_member) {

        //     $member = new Member();
        //     $member->email = $init_member['email'];
        //     $member->password = Hash::make($init_member['password']);
        //     $member->name = $init_member['name'];
        //     $member->delete_flg = $init_member['delete_flg'];
        //     $member->status = $init_member['status'];
        //     $member->created_at = now();
        //     $member->updated_at = now();
        //     $member->save();
        // }
    }
}
