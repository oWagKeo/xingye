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
}
