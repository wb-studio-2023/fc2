<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Query\JoinClause;

class ActressType extends Model
{
    use HasFactory;

    const TABLE_ABBREVIATED_NAME = 'at.';

    public function getList($arrayRequest)
    {
        $columnList = [
            'at.id',
            'at.name',
            'at.delete_flg',
            'at.created_at',
            'at.updated_at',
        ];

        $query = DB::table('actress_types as at');

        $query->select($columnList);

        $query->where('at.delete_flg', config('const.DELETE_FLG_OFF'));

        //keyword検索
        if (isset($arrayRequest['keyword'])) {
            $keyWord = '%' . addcslashes($arrayRequest['keyword'], '%_\\') . '%';
            $query
                ->where(function ($query) use ($keyWord) {
                    $query
                    ->orwhere('at.name', 'like', $keyWord);
                });
        }

        $query->groupBy('at.id');

        //sort
        $sortType = config('const.SORT_TYPE.d');
        $sortKind = 'updated_at';
        if ( isset($arrayRequest['sk']) && $arrayRequest['sk'] != NULL ) {
            $sortType = config('const.SORT_TYPE.' . $arrayRequest['st']);
            $sortKind = self::TABLE_ABBREVIATED_NAME . $arrayRequest['sk'];
            //joinして引っ張ったcolumn
            if ($arrayRequest['sk'] == 'articlesCount') {
                $sortKind = $arrayRequest['sk'];
            }
        }
        $query->orderBy($sortKind, $sortType);

        $retList = $query->paginate(config('const.ADMIN.LIST_PER_PAGE'));

        return $retList;
    }

    public function insertData($inputData)
    {
        $query = DB::table('actress_types');
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
            'at.id',
            'at.name',
            'at.delete_flg',
            'at.created_at',
            'at.updated_at',
        ];

        $query = DB::table('actress_types as at');

        $query->select($columnList);

        $query->where('at.delete_flg', config('const.DELETE_FLG_OFF'))
            ->where('at.id', $request->actress_type_id);
            
        $retData = $query->first();

        return $retData;
    }

    public function updateData($inputData)
    {

        $query = DB::table('actress_types');
        $value = [
            'name' => $inputData['name'],
            'updated_at' => now(),
        ];

        $query->where('id', $inputData['id']);

        $query->update($value);
    }

    public function deleteData($deleteIds)
    {
        $value = [
            'delete_flg' => config('const.DELETE_FLG_ON'),
            'updated_at' => now(),
        ];

        if (isset($deleteIds)) {
            $query = DB::table('actress_types');
            $query->whereIn('id', $deleteIds);
            $query->update($value);
        }
    }

    public function getListForActress()
    {
        $columnList = [
            'at.id',
            'at.name',
        ];

        $query = DB::table('actress_types as at');

        $query->select($columnList);
        $query->where('at.delete_flg', config('const.DELETE_FLG_OFF'));
        $query->orderBy('at.updated_at', 'DESC');

        $retList = $query->get();

        return $retList;
    }
}
