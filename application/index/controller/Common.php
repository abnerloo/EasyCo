<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Url;
use think\Config;
use think\Cookie;
use Gamegos\JWT\Exception\JWTExpiredException;
use Gamegos\JWT\Exception\JWTException;
use Gamegos\JWT\Validator;

class Common extends Controller
{
	protected $_userId = null;
	
	public function _initialize()
	{
// 		model('User')->initUser();
		//验证令牌
		$jwt = Cookie::get(Config::get('jwt.cookieName' . 'Income'),Config::get('cookie.prefix'));
		if($jwt)
		{
			try
			{
				$validator = new Validator();
				$token = $validator->validate($jwt,Config::get('jwt.key'));
				$this->empNo = $token->getClaim('sub');
			} 
			catch (JWTException $e)
			{
				//令牌过期
				$this->result('',403,$e->getMessage(),'json');
			}
			catch (JWTExpiredException $e)
			{
				//令牌过期
				$this->result('',403,$e->getMessage(),'json');
			}
		}
		else
		{
			//如果session没有userid，就提示用户退出重新登录
			$this->result($url,403,'登录过期，请重新登录。','json');
		}
	}

	protected function doLogin($empNo, $remember = false, $appName = ''){
        if($remember){
            $remember = true;
            $cookieTime = $this->remember;
        }else{
            $remember = false;
            $cookieTime = $this->noRemember;
        }
        //用户的岗位放到session中
        $token = new Token();
        $token->setClaim('sub',$empNo);
        $token->setClaim('exp',time() + $cookieTime);
        $encoder = new Encoder();
        $encoder->encode($token,Config::get('jwt.key'),Config::get('jwt.alg'));

        // Model('UserExtra')->updateAvatar($empNo,session('personid'));
        Cookie::init(Config::get('cookie'));
        Cookie::set(Config::get('jwt.cookieName' . $appName), $token->getJWT());
        return $token->getJWT();
    }


    public function life(){
        $member = cookie('member');
        if($member['remember']){
            $cookieTime = $this->remember;
        }else{
            $cookieTime = $this->noRemember;
        }
        cookie('member',
            [
                'id'  =>  $member['id'],
                'realName'  =>  $member['realName'],
                'phone'  =>  $member['phone'],
                'remember'  =>  $member['remember']
            ],
            ['expire'=>$cookieTime]
        );
    }
	
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
        
        return json_encode($result);
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
        
        return json_encode($result);
    }
}