<?php


use App\Models\Banner;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use \Illuminate\Support\Facades\Redis;

function getConfig()
{
    return Cache::rememberForever('getConfig',function (){
        $setting = Setting::Name()->first();
        return $setting->content;
    });
}

function getUserInfo($id)
{
    return Cache::rememberForever('user:' . $id,function ()use($id){
        return \App\Models\User::where('id', $id)->first();
    });

}

function cs()
{
    Redis::set('token', 1111);
    $res = Redis::get('token');
    dd($res);
}



function LHC($code)
{
    if ($code == 1) {
        $arr = [5, 7, 9];
    }
    if ($code == 2) {
        $arr = [6, 8];

    }
    if ($code == 3) {
        $arr = [1, 3];

    }
    if ($code == 4) {
        $arr = [0, 2, 4];
    }

    $rand = $arr[array_rand($arr)];
    return $rand . ',' . rand(0, 9) . ',' . rand(0, 9) . ',' . rand(0, 9) . ',' . rand(0, 9);
}


function SSC($code)
{

    if ($code == 1) {
        $arr = [5, 7, 9];
    }
    if ($code == 2) {
        $arr = [6, 8];

    }
    if ($code == 3) {
        $arr = [1, 3];

    }
    if ($code == 4) {
        $arr = [0, 2, 4];
    }

    $rand = $arr[array_rand($arr)];
    return $rand . ',' . rand(0, 9) . ',' . rand(0, 9) . ',' . rand(0, 9) . ',' . rand(0, 9);
}

function KC($code)
{
    if ($code == 1) {
        $n1 = [7, 9];
        $n1 = $n1[array_rand($n1)];
        $n2 = [1, 2, 3, 4, 5, 6, 8, 10];
        shuffle($n2);
        array_unshift($n2, $n1);
        $n2[] = $n1 == 7 ? 7 : 9;
        $array = $n2;
    }
    if ($code == 2) {
        $n1 = [6, 8, 10];
        $n2 = [1, 2, 3, 4, 5, 7, 9];
        shuffle($n1);
        shuffle($n2);
        $array = array_merge($n1, $n2);
    }
    if ($code == 3) {
        $n1 = [1, 3, 5];
        $n2 = [6, 2, 8, 4, 7, 9, 10];
        shuffle($n1);
        shuffle($n2);
        $array = array_merge($n1, $n2);
    }
    if ($code == 4) {
        $n1 = [2, 4];
        $n2 = [1, 3, 5, 6, 7, 8, 9, 10];
        shuffle($n1);
        shuffle($n2);
        $array = array_merge($n1, $n2);
    }

    return implode(',', $array);
}

function k3($code)
{
    while (true) {
        $n1 = rand(1, 6);
        $n2 = rand(1, 6);
        $n3 = rand(1, 6);
        $num = $n1 + $n2 + $n3;
        if ($code == 1 && $num > 10 && $num % 2 != 0) {
            break;
        }
        if ($code == 2 && $num > 10 && $num % 2 == 0) {
            break;
        }
        if ($code == 3 && $num <= 10 && $num % 2 != 0) {
            break;
        }
        if ($code == 4 && $num <= 10 && $num % 2 == 0) {
            break;
        }
    }
    return $n1 . ',' . $n2 . ',' . $n3;
}


function strToArray($code)
{
    return explode(',', $code);
}

/**
 *  ??????
 * @param $order
 * @param $open_code
 * @return false|float|int
 */
function daxiao($order, $open_code)
{
    $open_code = strToArray($open_code);
    $num = array_sum($open_code);

    if (($num > 10 && $order['content'] == '???') || ($num <= 10 && $order['content'] == '???')) {
        return round($order['money'] * $order['rate'], 2);
    }
    return 0;
}

/**
 *  liuhe??????
 * @param $order
 * @param $open_code
 * @return false|float|int
 */
function lhdaxiao($order, $open_code)
{
    $num = strToArray($open_code);
    $num = end($num);

    if ($num == 49) {
        return round($order['money'], 2);
    }
    if (($num > 24 && $order['content'] == '???') || ($num <= 24 && $order['content'] == '???')) {
        return round($order['money'] * $order['rate'], 2);
    }
    return 0;
}

/**
 *  ???????????????
 * @param $order
 * @param $open_code
 * @return false|float|int
 */
function sscdaxiao($order, $open_code)
{
    $num = (int)$open_code[0];

    if (($num > 4 && $order['content'] == '???') || ($num <= 4 && $order['content'] == '???')) {
        return round($order['money'] * $order['rate'], 2);
    }
    return 0;
}


/**
 *  ????????????
 * @param $order
 * @param $open_code
 * @return false|float|int
 */
function kcdaxiao($order, $open_code)
{
    $open_code = strToArray($open_code);
    $num = $open_code[0] + $open_code[1];

    if (($num > 11 && $order['content'] == '???') || ($num <= 11 && $order['content'] == '???')) {
        return round($order['money'] * $order['rate'], 2);
    }
    return 0;
}


/**
 *  ??????????????????
 * @param $order
 * @param $open_code
 * @return false|float|int
 */
function gjdaxiao($order, $open_code)
{
    $open_code = strToArray($open_code);
    $num = $open_code[0];

    if (($num > 5 && $order['content'] == '???') || ($num <= 5 && $order['content'] == '???')) {
        return round($order['money'] * $order['rate'], 2);
    }
    return 0;
}

/**
 *  ??????
 * @param $order
 * @param $open_code
 * @return false|float|int
 */
function danshuang($order, $open_code)
{
    $open_code = strToArray($open_code);
    $num = array_sum($open_code);

    if (($num % 2 !== 0 && $order['content'] === '???') || ($num % 2 === 0 && $order['content'] === '???')) {
        return round($order['money'] * $order['rate'], 2);
    }
    return 0;
}

/**
 *  ??????
 * @param $order
 * @param $open_code
 * @return false|float|int
 */
function lhdanshuang($order, $open_code)
{
    $num = strToArray($open_code);
    $num = end($num);
    if ($num == 49) {
        return round($order['money'], 2);
    }

    if (($num % 2 !== 0 && $order['content'] === '???') || ($num % 2 === 0 && $order['content'] === '???')) {
        return round($order['money'] * $order['rate'], 2);
    }
    return 0;
}

/**
 *  ?????????1VS5
 * @param $order
 * @param $open_code
 * @return false|float|int
 */
function ssclonghu($order, $open_code)
{
    $open_code = strToArray($open_code);
    $code_1 = (int)$open_code[0];
    $code_4 = (int)$open_code[4];
    if ($code_1 > $code_4) $code = '???';
    if ($code_1 < $code_4) $code = '???';
    if ($code_1 == $code_4) $code = '???';
    if ($code == $order['content']) {
        return round($order['money'] * $order['rate'], 2);
    }
    return 0;
}


/**
 *  ??????
 * @param $order
 * @param $open_code
 * @return false|float|int
 */
function sscdanshuang($order, $open_code)
{
    $num = (int)$open_code[0];

    if (($num % 2 !== 0 && $order['content'] === '???') || ($num % 2 === 0 && $order['content'] === '???')) {
        return round($order['money'] * $order['rate'], 2);
    }
    return 0;
}

/**
 *  ????????????
 * @param $order
 * @param $open_code
 * @return false|float|int
 */
function kcdanshuang($order, $open_code)
{
    $open_code = strToArray($open_code);
    $num = $open_code[0] + $open_code[1];

    if (($num % 2 !== 0 && $order['content'] === '???') || ($num % 2 === 0 && $order['content'] === '???')) {
        return round($order['money'] * $order['rate'], 2);
    }
    return 0;
}


/**
 *  ??????????????????
 * @param $order
 * @param $open_code
 * @return false|float|int
 */
function gjdanshuang($order, $open_code)
{
    $open_code = strToArray($open_code);
    $num = $open_code[0];

    if (($num % 2 !== 0 && $order['content'] === '???') || ($num % 2 === 0 && $order['content'] === '???')) {
        return round($order['money'] * $order['rate'], 2);
    }
    return 0;
}

/**
 *  ????????????
 * @param $order
 * @param $open_code
 * @return false|float|int
 */
function zonghe($order, $open_code)
{
    $open_code = strToArray($open_code);
    $num = array_sum($open_code);

    if ($num == $order['content']) {
        return round($order['money'] * $order['rate'], 2);
    }
    return 0;

}


/**
 *  ??????????????????
 * @param $order
 * @param $open_code
 * @return false|float|int
 */
function kchezhi($order, $open_code)
{
    $open_code = strToArray($open_code);
    $num = $open_code[0] + $open_code[1];

    if ($num == $order['content']) {
        return round($order['money'] * $order['rate'], 2);
    }
    return 0;

}


/**
 *  ????????????????????????
 * @param $order
 * @param $open_code
 * @return false|float|int
 */
function gjshuzhi($order, $open_code)
{
    $open_code = strToArray($open_code);
    $num = $open_code[0];

    if ($num == $order['content']) {
        return round($order['money'] * $order['rate'], 2);
    }
    return 0;

}


/**
 * ??????
 * @param $order
 * @param $open_code
 * @return false|float|int
 */
function danshai($order, $open_code)
{
    $open_code = strToArray($open_code);
    $open_code = array_count_values($open_code);
    if (!empty($open_code[$order['content']])) {
        $num = $open_code[$order['content']];
        return round($order['money'] * $order['rate'] * $num, 2);
    }
    return 0;
}

/**
 * ??????
 * @param $order
 * @param $open_code
 * @return false|float|int
 */
function lhtm($order, $open_code)
{
    $num = strToArray($open_code);
    $num = end($num);
    if ($num == $order['content']) {
        return round($order['money'] * $order['rate'], 2);
    }
    return 0;
}

/**
 * ??????
 * @param $order
 * @param $open_code
 * @return false|float|int
 */
function lhshengxiao($order, $open_code)
{
    $num = strToArray($open_code);
    $num = end($num);

    if (in_array($num, [12, 24, 36, 48])) $content = '???';
    if (in_array($num, [10, 22, 34, 46])) $content = '???';
    if (in_array($num, [8, 20, 32, 44])) $content = '???';
    if (in_array($num, [6, 18, 30, 42])) $content = '???';
    if (in_array($num, [4, 16, 28, 40])) $content = '???';
    if (in_array($num, [2, 14, 26, 38])) $content = '???';
    if (in_array($num, [11, 23, 35, 47])) $content = '???';
    if (in_array($num, [7, 19, 31, 43])) $content = '???';
    if (in_array($num, [5, 17, 29, 41])) $content = '???';
    if (in_array($num, [3, 15, 27, 39])) $content = '???';
    if (in_array($num, [1, 13, 25, 37, 49])) $content = '???';
    if (isset($content) && $content == $order['content']) {
        return round($order['money'] * $order['rate'], 2);
    }
    return 0;
}

/**
 * ??????
 * @param $order
 * @param $open_code
 * @return false|float|int
 */
function lhsebo($order, $open_code)
{
    $num = strToArray($open_code);
    $num = end($num);
    if (in_array($num, [1,2,7,8,12,13,18,19,23,24,29,30,34,35,40,45,46])) $content = '??????';
    if (in_array($num, [3,4,9,10,14,15,20,25,26,36,37,41,42,47,48,31])) $content = '??????';
    if (in_array($num, [5,6,11,16,17,21,22,27,28,32,33,38,39,43,44,49])) $content = '??????';

    if (isset($content) && $content == $order['content']) {
        return round($order['money'] * $order['rate'], 2);
    }
    return 0;
}

/**
 * 5???1
 * @param $order
 * @param $open_code
 * @return false|float|int
 */
function sscdanshai($order, $open_code)
{
    $open_code = strToArray($open_code);

    if (in_array($order['content'], $open_code)) {
        return round($order['money'] * $order['rate'], 2);
    }
    return 0;
}


/**
 *  ??????
 * @param $order
 * @param $open_code
 * @return false|float|int
 */
function duizi($order, $open_code)
{
    $open_code = strToArray($open_code);
    $open_code = array_count_values($open_code);
    if (!empty($open_code[$order['content']]) && $open_code[$order['content']] > 1) {
        return round($order['money'] * $order['rate'], 2);
    }
    return 0;
}

function baozi($order, $open_code)
{
    $open_code = strToArray($open_code);
    $code = array_count_values($open_code);
    $code = array_values($code);
    $content = $order['content'];

    if ($code[0] == 3 && (in_array($content, $open_code) || $content == '??????')) {
        return round($order['money'] * $order['rate'], 2);
    }
    return 0;

}

function createOrderOn()
{
    $prefix = date('Ymd');
    // ???????????? 6 ????????????,??????????????????
    $no = $prefix . rand(100000, 999999) . substr(microtime(true), -4);
    return $no;
}


function userAccountChange($user_id, $type, $before_money, $money, $after_money, $remark)
{
    $insert = [
        'user_id' => $user_id,
        'type' => $type,
        'before_money' => $before_money,
        'money' => $money,
        'after_money' => $after_money,
        'remark' => $remark,
    ];

    $res = \App\Models\UsersAccountChange::create($insert);
    return $res;
}



function parseUpdate($data, $field)
{
    $sql = '';
    $keys = array_keys(current($data));
    foreach ($keys as $column) {

        $sql .= sprintf("`%s` = CASE `%s` \n", $column, $field);
        foreach ($data as $line) {
            $sql .= sprintf("WHEN '%s' THEN '%s' \n", $line[$field], $line[$column]);
        }
        $sql .= "END,";
    }

    return rtrim($sql, ',');
}
