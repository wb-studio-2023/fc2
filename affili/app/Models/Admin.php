<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class Admin extends Authenticatable
{
    use HasFactory;

    public function updateToken($request) 
    {

        $rememberToken = config('const.ADMIN.LOGIN_STATUS.FORGET');
        if (isset($request->keepLogin) && $request->keepLogin == config('const.ADMIN.LOGIN_STATUS.CHECK_VALUE')) {
            $rememberToken = config('const.ADMIN.LOGIN_STATUS.REMEMBER');
        }

        $value = [
            'remember_token' => $rememberToken,
            'updated_at' => now(),
        ];

        $query = DB::table('admins');
        $query->where('email', $request->email);
        $query->update($value);

        // 更新されたレコードを再度取得
        $updatedRecord = DB::table('admins')
            ->where('email', $request->email)
            ->first();

        return $updatedRecord->id;
    }
}
