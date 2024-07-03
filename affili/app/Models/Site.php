<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Site extends Model
{
    use HasFactory;

    const TABLE_ABBREVIATED_NAME = 'si.';

    public function getList()
    {
        $columnList = [
            'si.id',
            'si.name',
            'pf.name as platform_name',
            'si.delete_flg',
            'si.created_at',
            'si.updated_at',
        ];

        $retList = DB::table('sites as si')
            ->select($columnList)
            ->join('platforms as pf', 'pf.id', '=', 'si.platform_id')
            ->where('pf.delete_flg', config('const.DELETE_FLG_OFF'))
            ->where('si.delete_flg', config('const.DELETE_FLG_OFF'))
            ->get();

        return $retList;
    }

    public function insertData($inputData)
    {
        $query = DB::table('sites');

        $value = [
            'name' => $inputData['name'],
            'platform_id' => $inputData['platform_id'],
            'delete_flg' => config('const.DELETE_FLG_OFF'),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $query->insert($value);
    }

    public function getDataById($request)
    {
        $columnList = [
            'si.id',
            'si.name',
            'si.platform_id',
            'si.delete_flg',
            'si.created_at',
            'si.updated_at',
        ];

        $retData = DB::table('sites as si')
            ->select($columnList)
            ->where('si.delete_flg', config('const.DELETE_FLG_OFF'))
            ->where('si.id', $request->site_id)
            ->first();

        return $retData;
    }

    public function updateData($inputData)
    {
        $query = DB::table('sites');

        $value = [
            'name' => $inputData['name'],
            'platform_id' => $inputData['platform_id'],
            'updated_at' => now(),
        ];

        $query->where('id', $inputData['id'])
            ->update($value);
    }

    public function deleteData($deleteIds)
    {
        $value = [
            'delete_flg' => config('const.DELETE_FLG_ON'),
            'updated_at' => now(),
        ];

        if (isset($deleteIds)) {
            $query = DB::table('sites');
            $query->whereIn('id', $deleteIds);
            $query->update($value);
        }
    }

    public function getListForArticle()
    {
        $columnList = [
            'si.id',
            'si.name',
        ];

        $query = DB::table('sites as si');

        $query->select($columnList);
        $query->where('si.delete_flg', config('const.DELETE_FLG_OFF'));
        $query->orderBy('si.updated_at', 'DESC');

        $retList = $query->get();

        return $retList;
    }
}
