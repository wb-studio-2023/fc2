<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Platform extends Model
{
    use HasFactory;

    const TABLE_ABBREVIATED_NAME = 'pf.';

    public function getList()
    {
        $columnList = [
            'pf.id',
            'pf.name',
            'pf.delete_flg',
            'pf.created_at',
            'pf.updated_at',
        ];

        $retList = DB::table('platforms as pf')
            ->select($columnList)
            ->where('pf.delete_flg', config('const.DELETE_FLG_OFF'))
            ->get();

        return $retList;
    }

    public function insertData($inputData)
    {
        $query = DB::table('platforms');

        $value = [
            'name' => $inputData['name'],
            'delete_flg' => config('const.DELETE_FLG_OFF'),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $query->insert($value);
    }

    public function getDataById($request)
    {
        $columnList = [
            'pf.id',
            'pf.name',
            'pf.delete_flg',
            'pf.created_at',
            'pf.updated_at',
        ];

        $retData = DB::table('platforms as pf')
            ->select($columnList)
            ->where('pf.delete_flg', config('const.DELETE_FLG_OFF'))
            ->where('pf.id', $request->platform_id)
            ->first();

        return $retData;
    }

    public function updateData($inputData)
    {
        $query = DB::table('platforms');

        $value = [
            'name' => $inputData['name'],
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
            $query = DB::table('platforms');
            $query->whereIn('id', $deleteIds);
            $query->update($value);
        }
    }

    public function getListForArticle()
    {
        $columnList = [
            'ac.id',
            'ac.name',
        ];

        $query = DB::table('actresses as ac');

        $query->select($columnList);
        $query->where('ac.delete_flg', config('const.DELETE_FLG_OFF'));
        $query->orderBy('ac.updated_at', 'DESC');

        $retList = $query->get();

        return $retList;
    }
}
