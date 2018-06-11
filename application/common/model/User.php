<?php 
namespace app\common\model;
use think\Model;

class User extends Model
{
	/**
	 * 初始化人员
	 * @param string $userId  用户openId
	 * @param string $unionId 用户unionId
	 * @return number|unknown|unknown[]
	 */
	public function initUser($userId, $unionId)
	{
		if (!$userId)
			return -1;
		if (!$unionId)
			return -1;
		
		if ($detail = model('User')->where('id', $userId)->find())
			return $detail;
		else 
		{
			$data = array(
				'id'=>$userId,
				'unionId'=>$unionId
			);
			if (model('User')->insert($data))
				return $data;
			else 
				return -1;
		}
	}
	
	/**
	 * 设置用户信息
	 * @param string $userId  用户的openid
	 * @param array $userInfo 要更新的用户信息
	 * @return number|boolean
	 */
	public function setUserInfo($userId, array $userInfo = [])
	{
		if (!$userId)
			return -1;
		$fields = $this->getTableFields();
		$data = array();
		if (!empty($userInfo))
		{
			foreach ($userInfo as $k => $v)
			{
				if (in_array($k, $fields) && $v != '')
				{
					$data[$k] = $v;
				}
			}
			$result = $this->where('id', $userId)->update($data);
			if ($result !== false)
				return true;
			else 
				return -203;
		}
	}
	
	/**
	 * 获取用户信息
	 * @param string $userId 用户的openid
	 * @param string|array $field 想要查询的用户的信息字段名
	 * @return number[]|string[]|number[]|unknown[]|number[]
	 */
	public function getUserInfo($userId, $field)
	{
		if (!$userId)
			return ['code'=>-1,'data'=>'userId'];
		$fields = $this->getTableFields();
		if (is_array($field))
		{
			foreach ($field as $v)
			{
				if (!in_array($v, $fields))
					return ['code'=>-1,'data'=>$v];
			}
			$field = implode(',', $field);
		}
		else 
		{
			if (!in_array($field, $fields))
				return ['code'=>-1,'data'=>$fields];
			$field = $fields;
		}
		$result = $this->field($field)->where('id', $userId)->find();
		if ($result)
			return ['code'=>1, 'data'=>$result];
		else 
			return ['code'=>-204];
	}
}