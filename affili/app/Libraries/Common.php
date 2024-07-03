<?php

namespace App\Libraries;

use DateTime;
use Carbon\Carbon;

class Common
{
   /**
    * Invokes the common
    * 
    * @param string $data
    * @return boolean
    */
    public static function convertDatetime($data) 
    { 
        $ret = null;
        if (isset($data)) {
            $date = explode(' ', $data)[0];
            $time = explode(' ', $data)[1];
            $ret = explode('-', $date)[0] . '/' .explode('-', $date)[1] . '/' .explode('-', $date)[2] . ' ' .explode(':', $time)[0] . ':' .explode(':', $time)[1];
        }

        return $ret; 
    }
    
    public static function unlinkImage($filepath,$fileName)
    {
        $old_image = $filepath . $fileName;
        if (file_exists($old_image)) {
            @unlink($old_image);
        }
    }

    static public function dateConverter($string) {
        $ret = null;
        if (isset($string)) {
            $ret = substr($string, 0, 4) . '/' . substr($string, 5, 2) . '/' .substr($string, 8, 2);
        }        
        return $ret;
    }

    static public function timeConverter($string) {
        $ret = null;
        if (isset($string)) {
            $explodeString = explode(' ', $string);
            if ( isset($explodeString[1]) ) {
                $ret = substr($explodeString[1], 0, 5);
            }
        }        
        return $ret;
    }

    static public function dateTImeDivide($string) {
        $ret = null;
        if (isset($string)) {
            $ret['year'] =  substr($string, 0, 4);
            $ret['month'] =  substr($string, 5, 2);
            $ret['day'] =  substr($string, 8, 2);
            $ret['hour'] =  substr($string, 11, 2);
            $ret['minute'] =  substr($string, 14, 2);
        }        

        return $ret;
    }

    static public function newFlg($string) {
        $ret = false;
        $date = new DateTime();
        $threeDaysAgo = $date->modify('-3 days');
        $articleDate = new DateTime($string);
        if (isset($string) && ($threeDaysAgo < $articleDate)) {
            $ret = true;
        }
        return $ret;
    }

    static public function dateSplit($string, $type) {
        $ret = null;
        if (isset($string)) {
            $splitSpace = explode(' ', $string);
            $splitHyphen = explode('-', $splitSpace[0]);
            $splitColon = explode(':', $splitSpace[1]);

            $ret[$type . '_year'] = $splitHyphen[0];
            $ret[$type . '_month'] = $splitHyphen[1];
            $ret[$type . '_day'] = $splitHyphen[2];
            $ret[$type . '_hour'] = $splitColon[0];
            $ret[$type . '_minute'] = $splitColon[1];
        }        
        return $ret;
    }

    static public function statusConverter($status, $release_at) {
        $ret = null;
        if (isset($status)) {
            if ($status == config('const.ARTICLE.STATUS.PREPARATION.NUMBER')) {
                $ret = config('const.ARTICLE.STATUS.PREPARATION.NAME');
            } else {
                $currentDateTime = Carbon::now();
                if ($release_at > $currentDateTime) {
                    $ret = config('const.ARTICLE.STATUS.WAITING.NAME');
                } else {
                    $ret = config('const.ARTICLE.STATUS.RELEASED.NAME');
                }
            }
        }        
        return $ret;
    }
}