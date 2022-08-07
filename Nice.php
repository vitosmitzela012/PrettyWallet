<?php
/**
 * Date: 2022/8/1
 * Time: 22:52
 * 联系方式：纸飞机(Telegram):@laowu2021
 * 靓号采集（方案一）
 * 方案一：写文件
 * 方案二：写数据库
 */

namespace app\api\controller;

use think\Cache;
use think\Controller;

class Nice extends Controller
{

    /**
     * 正则
     * http://nice3.com/api/nice/zz
     */
    public function zz($str)
    {
        $type = [];
        $n8 = substr($str, -8);
        $a8 = str_split($n8);
        $ret8 = self::filter($a8, 8);

        $n7 = substr($str, -7);
        $a7 = str_split($n7);
        $ret7 = self::filter($a7, 7);

        $n6 = substr($str, -6);
        $a6 = str_split($n6);
        $ret6 = self::filter($a6, 6);

        $n5 = substr($str, -5);
        $a5 = str_split($n5);
        $ret5 = self::filter($a5, 5);

        $n4 = substr($str, -4);
        $a4 = str_split($n4);
        $ret4 = self::filter($a4, 4);

        $n3 = substr($str, -3);
        $a3 = str_split($n3);
        $ret3 = self::filter($a3, 3);

//        $n2 = substr($str, -2);
//        $a2 = str_split($n2);
//        $ret2 = self::filter($a2, 2);

        if ($ret8) {
            array_push($type, 8);
        }
        if ($ret7) {
            array_push($type, 7);
        }
        if ($ret6) {
            array_push($type, 6);
        }
        if ($ret5) {
            array_push($type, 5);
        }
        if ($ret4) {
            array_push($type, 4);
        }
        if ($ret3) {
            array_push($type, 3);
        }
//
//        if ($ret2) {
//            array_push($type, 2);
//        }

        if ($type) {
            return ['code' => 1, 'type' => implode('_', $type)];
        } else {
            return ['code' => 0];
        }

    }

    public function filter($str, $len)
    {
        $end = $len - 1;
        for ($i = 0; $i < $len; $i++) {
            if ($str[$i] == $str[$end]) {
                continue;
            } else {
                return false;
                break;
            }
        }
        return true;
    }

    /**
     * 靓号选择
     * http://nice3.com/api/nice/shownum
     */
    public function shownum()
    {
        $cache = new Cache();
        if ($cache->has('num')) {
            echo $cache->get('num');
        } else {
            echo 0;
        }
    }

    /**
     * 靓号选择
     * http://nice3.com/api/nice/choose?num=10000
     */
    public function choose()
    {
        $n = $this->request->param('num', 200);
        $t1 = time();
        $cache = new Cache();
        if ($cache->has('num')) {
            $num = $cache->get('num');
            $newnum = (int)bcadd($num, $n);
            $cache->set('num', $newnum);

        } else {
            $cache->set('num', $n);
        }

        $ret = [];
        $file = ADDRESS_PATH . date('y-m-d') . 'address.txt';
        for ($i = 1; $i <= $n; $i++) {
            $address = self::generateAddress();
            if ($address) {
                if (isset($address['address'])) {
                    $retzz = self::zz($address['address']);
                    if ($retzz['code']) {
                        $address['type'] = $retzz['type'];
                        $address['time'] = time();
                        $address['date'] = date('Y-m-d H:i:s', time());
                        $data = implode(',', $address);
                        $retcheck = file_put_contents($file, $data . "\r\n", FILE_APPEND);
                        $address['check'] = $retcheck;
                        array_push($ret, $address);
                    }
                }
            }

        }

//        if ($ret) {
//            $addressmodel = new Address();
//            $addressmodel->saveAll($ret);
//        }
        $t2 = time();
        return json(['time' => '耗时' . bcsub($t2, $t1) . '秒', 'code' => 1, 'data' => $ret]);
    }

    /**
     * 生成地址
     * http://nice3.com/api/nice/generateAddress
     */
    public function generateAddress()
    {
        $tron = new \IEXBase\TronAPI\Tron();
        $generateAddress = $tron->generateAddress(); // or createAddress()
        $address = (array)($generateAddress)->getRawData();
        $retdata['privateKey'] = $address['private_key'];
        $retdata['address'] = $address['address_base58'];
//        $retdata['hexAddress'] = $address['address_hex'];
        return $retdata;
    }

}