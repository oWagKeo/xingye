<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    /**
     * QQ音乐礼包领取页面
     */
    public function qq_music(){
        return $this->fetch();
    }

    /**
     * 小红书礼包领取页面
     */
    public function red_book(){
        return $this->fetch();
    }

    /**
     * 接口
     */
    private function http_post($api,$p = ''){
        $time = time();
        $p = $p == '' ? '' : '&p='.$p;
        $url = '';
        $url .= '?time='.$time.'&sign='.md5('appkey='.$this->appkey.$p.'&time='.$time.'&key='.$this->md5key);
        $url .= $p;
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

}
