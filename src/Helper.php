<?php

namespace AppleDaily;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Helper
{
    // the preexisting code ....

    // your new code
    static function microlist($array)
    {
        if (!empty($array)) {
            foreach ($array['items'] as $item) {
                $list[] = "<div class='col-8'>" . $item['title'] . "</div><div class='col-4 text-right'>" . $item['price'] . " ₽</div>";
            }
            $str = implode("<div class='col-12 microlist'></div>", $list);
            return $str . "<div class='text-right col-12 xxs-pt'><a href='#repair" . $array['type_id'] . "' class='microlist-link' >Перейти к услугам</a> </div>";
        }
    }

    static function repairicons($str)
    {
        if (empty($str)) {
            return;
        } else {
            $list = [];
            $icons = explode(',', $str);
            foreach ($icons as $icon) {
                $list[] = '<img src="/images/icons/ic_' . trim($icon) . '.svg">';
            }
            return implode($list);
        }
    }


    static function randomfb()
    {
        $ar = Cache::get('randomfb', function () {
            $ar = [];
            $res = DB::table('reviews')->select('client_name as name', 'good as text')->get()->random(12);
            for ($i = 0; $i < count($res); $i++) {
                $ar[] = [
                    $res[$i]->name => mb_strimwidth($res[$i]->text, 0, 250, '..'),
                    $res[$i + 1]->name => mb_strimwidth($res[$i + 1]->text, 0, 250, '..')];
                $i++;
            }
            Cache::put('randomfb', $ar, 30);
            return $ar;
        });
        return $ar;


    }

    static function countfb()
    {
        $count = Cache::get('countfb', function () {

            $count = DB::table('reviews')->get()->count();

            Cache::put('countfb', $count, 600);
            return $count;
        });
        return $count;


    }


}
