<?php
namespace app\index\controller;

class Project extends Common
{
    public function addProject()
    {
        dump($this->getProjectType());
        exit;
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
    }
    
    public function getProjectType()
    {
        $list = model('ProjectType')->field(['id', 'name'])->where('status', 1)->select();
        if ($list)
            return $this->success($list, '获取项目分类成功！');
        else 
            return $this->error('获取项目分类失败！');
    }
}