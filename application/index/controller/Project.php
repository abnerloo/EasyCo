<?php
namespace app\index\controller;

/*
 * 错误编码：
 * 	-1：参数错误
 * 	-201：数据库操作新增错误
 * 	-202：数据库操作删除错误
 * 	-203：数据库操作更新错误
 * 	-204：数据库操作查询错误
 */
class Project extends Common
{
	/**
	 * 获取项目分类
	 * @return array 项目分类
	 */
    public function getProjectType()
    {
        $list = model('ProjectType')->field(['id', 'name'])->where('status', 1)->select();
        if ($list)
            return $this->success($list, '获取项目分类成功！');
        else 
            return $this->error('获取项目分类失败！', -204);
    }
    
    /**
     * 创建项目
     * @return number[]|string[]
     */
    public function addProject()
    {
    	$param = request()->param();
    	//参数验证
    	if (!isset($param['name']) && $param['name'] == '')
    		$this->error('项目名称不能为空', -1);
    	if (!isset($param['pStatus']) && !in_array($param['pStatus'], ['0', '1', '2', '3']))
    		$this->error('项目状态超出范围', -1);
    	if (!isset($param['type']) && !model('ProjectType')->where(['id'=>$param['type'], 'status'=>1])->find())
    		$this->error('项目分类不存在', -1);
    	if (!isset($param['userId']) && $param['userId'] == '')
    		$this->error('创建者不能为空！', -1);
    					
    	$insert = array(
    		'name'			=>	$param['name'],
    		'discription'	=>	$param['discription'],
    		'onlineTime'	=>	$param['onlineTime'],
    		'pStatus'		=>	$param['pStatus'],
    		'type'			=>	$param['type'],
    		'creator'		=>	$param['userId'],
    		'updater'		=>	$param['userId'],
    		'createTime'	=>	time(),
    		'updateTime'	=>	time()
    	);
    					
    	if (model('Project')->insert($insert))
    		return $this->success('', '创建项目成功！');
    	else
    		return $this->error('创建项目失败！', -201);
    }
    
    /**
     * 更新项目信息
     * @return number[]|string[]
     */
    public function editProject()
    {
    	$param = request()->param();
    	//参数验证
    	if (!isset($param['name']) && $param['name'] == '')
    		$this->error('项目名称不能为空', -1);
    	if (!isset($param['pStatus']) && !in_array($param['pStatus'], ['0', '1', '2', '3']))
    		$this->error('项目状态超出范围', -1);
    	if (!isset($param['type']) && !model('ProjectType')->where(['id'=>$param['type'], 'status'=>1])->find())
    		$this->error('项目分类不存在', -1);
    	if (!isset($param['userId']) && $param['userId'] == '')
    		$this->error('创建者不能为空！', -1);
    	
    	$update = array(
    		'name'			=>	$param['name'],
    		'discription'	=>	$param['discription'],
    		'onlineTime'	=>	$param['onlineTime'],
    		'pStatus'		=>	$param['pStatus'],
    		'type'			=>	$param['type'],
    		'creator'		=>	$param['userId'],
    		'updater'		=>	$param['userId'],
    		'createTime'	=>	time(),
    		'updateTime'	=>	time()
    	);
    	
    	if (model('Project')->where('id', $param['id'])->update($update) !== false)
    		return $this->success('', '更新项目信息成功！');
    	else 
    		return $this->error('更新项目信息失败！', -203);
    }
    
    /**
     * 删除项目
     * @param int $id 项目Id
     * @return unknown
     */
    public function delProject($id)
    {
    	if (model('Project')->where('id', $id)->delete())
    		return $this->success('', '删除项目成功！');
    	else 
    		return $this->error('删除项目失败！', -202);
    }
    
    public function getProjectList($userId = '')
    {
    	$where = array('status'=>1);
    	if ($userId != '')
    		$where['creator'] = $userId;
    	$list = model('Project')->where($where)->order('createTime desc')->select();
    	
    	if ($list)
    	{
    		foreach ($list as $k => $v)
    		{
    			$list[$k]['createTime'] = date('Y-m-d H:i:s', $v['createTime']);
    			$list[$k]['type'] = model('ProjectType')->where('id', $v['type'])->value('name');
//     			$list[$k]['creator'] = 
    		}
    		
    		return $this->success($list);
    	}
    	else 
    		return $this->error('暂无项目！');
    }
    
    public function test($uid)
    {
    	echo '123';
    }
}
















