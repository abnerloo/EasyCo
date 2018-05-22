<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Url;

class Common extends Controller
{
    public function success($data = '', $msg = '', $code = 1, $url = '', array $header = [])
    {
        if (is_null($url) && !is_null(Request::instance()->server('HTTP_REFERER'))) {
            $url = Request::instance()->server('HTTP_REFERER');
        } elseif ('' !== $url && !strpos($url, '://') && 0 !== strpos($url, '/')) {
            $url = Url::build($url);
        }
        
        $type = $this->getResponseType();
        $result = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url
        ];
        
        return $result;
    }
    
    public function error($msg = '', $code = 0, $data = '', $url = '', array $header = [])
    {
        if (is_null($url)) {
            $url = Request::instance()->isAjax() ? '' : 'javascript:history.back(-1);';
        } elseif ('' !== $url && !strpos($url, '://') && 0 !== strpos($url, '/')) {
            $url = Url::build($url);
        }
        
        $type = $this->getResponseType();
        $result = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url
        ];
        
        return $result;
    }
}