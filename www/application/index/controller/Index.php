<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Validate;

class Index extends Controller
{
    /**
     * QQ音乐礼包领取页面
     */
    public function qq_music(){
        if( request()->isAjax() ){
            $validate = new Validate();
            $validate->rule('phone','/^1[34578]\d{9}$/');
            $validate->message('phone','手机号码格式不正确');
            $data = [
                'phone'=>input('param.phone')
            ];
            if( !$validate->check( $data ) ){
                return json($this->msg('-1','',$validate->getError()));
            }
            $count = Db::name('qqyy')->count();
            if( $count>=2000 ){
                return json($this->msg('-1','','礼包被领光啦!'));
            }
            $param = [
                'phone' => input('param.phone'),
                'add_time'=>time()
            ];
            $in = Db::name('qqyy')->insert($param);
            if( empty($in) ){
                return json($this->msg('-1','','系统错误!'));
            }else{
                return json($this->msg('1','url:xxxxxx','领取成功!'));
            }
        }else{
            return $this->fetch();
        }

    }

    /**
     * 小红书礼包领取页面
     */
    public function red_book(){
        if( request()->isAjax() ){
            $validate = new Validate();
            $validate->rule('phone','/^1[34578]\d{9}$/');
            $validate->message('phone','手机号码格式不正确');
            $data = [
                'phone'=>input('param.phone')
            ];
            if( !$validate->check( $data ) ){
                return json($this->msg('-1','',$validate->getError()));
            }
            $count = Db::name('xhs')->count();
            if( $count>=2000 ){
                return json($this->msg('-1','','礼包被领光啦!'));
            }
            $param = [
                'phone' => input('param.phone'),
                'add_time'=>time()
            ];
            $in = Db::name('xhs')->insert($param);
            if( empty($in) ){
                return json($this->msg('-1','','系统错误!'));
            }else{
                return json($this->msg('1','url:xxxxxx','领取成功!'));
            }
        }else{
            return $this->fetch();
        }
    }

    /**
     * 统一返回信息
     * @param $code
     * @param $data
     * @param $msge
     */
    private function msg($code, $data, $msg)
    {
        return compact('code', 'data', 'msg');
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
