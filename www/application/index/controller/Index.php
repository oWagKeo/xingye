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
            $validate->rule('phone','require|/^1[34578]\d{9}$/');
            $validate->message('phone','手机号码格式不正确');
            $data = [
                'phone'=>input('param.phone')
            ];
            if( !$validate->check( $data ) ){
                return json($this->msg('-1','',$validate->getError()));
            }

            //验证是否为兴业中奖链接
            $ph = substr(input('param.phone'),7,4);
            $re = $this->http_post(session('qq_token'),$ph);
            if( !$re ){
                return json($this->msg('-1','','仅限兴业银行用户参与！'));
            }
            $result = json_decode($re)->header->resulttype;
            if( $result != 1 ){
                return json($this->msg('-1','','仅限兴业银行用户参与！'));
            }

            $count = Db::name('qqyy')->count();
            if( $count>=2000 ){
                return json($this->msg('-1','','礼包被领光啦!'));
            }
            //查看该手机号是否领取过
            $info = Db::name('qqyy')->where('phone',input('param.phone'))->find();
            if( !empty($info) ){
                return json($this->msg('-1','','您已经领取过了！'));
            }
            $param = [
                'phone' => input('param.phone'),
                'add_time'=>time()
            ];
            $in = Db::name('qqyy')->insert($param);
            if( empty($in) ){
                return json($this->msg('-1','','系统错误!'));
            }else{
                return json($this->msg('1','https://y.qq.com/apg/38/index.html?from=singlemessage','领取成功!'));
            }
        }else{

            if(!empty($_GET['token'])){
                session('qq_token',$_GET['token']);
            }
            return $this->fetch();
        }

    }

    /**
     * 小红书礼包领取页面
     */
    public function red_book(){
        if( request()->isAjax() ){
            $validate = new Validate();
            $validate->rule('phone','require|/^1[34578]\d{9}$/');
            $validate->message('phone','手机号码格式不正确');
            $data = [
                'phone'=>input('param.phone')
            ];
            if( !$validate->check( $data ) ){
                return json($this->msg('-1','',$validate->getError()));
            }

            //验证是否为兴业中奖链接
            $ph = substr(input('param.phone'),7,4);
            $re = $this->http_post(session('red_token'),$ph);
            if( !$re ){
                return json($this->msg('-1','','仅限兴业银行用户参与！'));
            }
            $result = json_decode($re)->header->resulttype;
            if( $result != 1 ){
                return json($this->msg('-1','','仅限兴业银行用户参与！'));
            }

            $count = Db::name('xhs')->count();
            if( $count>=2000 ){
                return json($this->msg('-1','','礼包被领光啦!'));
            }
            //查看该手机号是否领取过
            $info = Db::name('xhs')->where('phone',input('param.phone'))->find();
            if( !empty($info) ){
                return json($this->msg('-1','','您已经领取过了！'));
            }
            $param = [
                'phone' => input('param.phone'),
                'add_time'=>time()
            ];
            $in = Db::name('xhs')->insert($param);
            if( empty($in) ){
                return json($this->msg('-1','','系统错误!'));
            }else{
                return json($this->msg('1','http://www.xiaohongshu.com/red_packet/000099?from=singlemessage','领取成功!'));
            }
        }else{
            if(!empty($_GET['token'])){
                session('red_token',$_GET['token']);
            }
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
     * 接口请求
     */
    private function http_post( $token,$phone ){
        $url = 'http://cibankapi.cloudmou.cn/api/lotterydrawuser/getcheckaccount?bankcard=&phone='.$phone.'&token='.$token;
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false); //设置没有http头
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//如果成功只将结果返回，不自动输出任何内容
//        curl_setopt($ch, CURLOPT_NOBODY, true);//设置输出包中不包含body部分
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

}
