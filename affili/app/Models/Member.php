<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class Member extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'line_user_key'
    ];

    protected $hidden = [
        'password',
        'line_user_key',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getMemberData($request)
    {
        $columnList = [
            'me.id',
            'me.line_user_key',
            'me.delete_flg',
            'me.created_at',
            'me.updated_at',
        ];

        $query = DB::table('members as me');

        $query->select($columnList);

        $query->where('me.delete_flg', config('const.DELETE_FLG_OFF'))
            ->where('me.line_user_key', $request['line_user_id']);
            
        $retData = $query->first();

        return $retData;
    }

    public function registMemberData($request)
    {
        $columnList = [
            'me.id',
            'me.line_user_key',
            'me.delete_flg',
            'me.created_at',
            'me.updated_at',
        ];

        $query = DB::table('members as me');

        $query->select($columnList);

        $query->where('me.delete_flg', config('const.DELETE_FLG_OFF'))
            ->where('me.line_user_key', $request['line_user_id']);
            
        $retData = $query->first();

        return $retData;
    }

    public function insertData($inputData)
    {
        $query = DB::table('members');
        $value = [
            'line_user_key' => $inputData['line_user_id'],
            'name' => '',
            'status' => 0,
            'delete_flg' => config('const.DELETE_FLG_OFF'),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $query->insertGetId($value);
    }
}