-- 项目主表
create table e_project
(
  id                     int                          primary key auto_increment,
  name                   varchar(200)                 not null     comment '项目名称',
  discription            varchar(500)                              comment '项目描述',
  onlineTime             int                                       comment '项目上线时间',
  pStatus                tinyint                      default 0    comment '项目状态：0：未立项，1：未上线，2：上线，3：下线',
  type                   int                          not null     comment '项目类型，对应项目类型表中的id',
  creator                varchar(100)                 not null     comment '创建者',
  updater                varchar(100)                 not null     comment '更新者',
  createTime             int                          not null     comment '创建时间',
  updateTime             int                          not null     comment '更新时间',
  status                 tinyint                      default 1    comment '项目的启用状态：0：禁用，1：启用'
);


-- 项目类型表
create table e_project_type
(
  id                     int                          primary key auto_increment,
  name                   varchar(100)                 not null     comment '项目类型名称',
  status                 tinyint                      default 1    comment '类型状态：0：禁用，1：启用'
);

insert into e_project_type (name) values('H5');
insert into e_project_type (name) values('微信小程序');
insert into e_project_type (name) values('支付宝小程序');
insert into e_project_type (name) values('微信小游戏');


-- 需求表
create table e_project_requirements
(
  id                     int                          primary key auto_increment,
  pId                    int                          not null     comment '项目Id',
  requirements           longtext                     not null     comment '需求详情',
  creator                varchar(100)                 not null     comment '创建者',
  updater                varchar(100)                 not null     comment '更新者',
  createTime             int                          not null     comment '创建时间',
  updateTime             int                          not null     comment '更新时间',
  status                 tinyint                      default 1    comment '需求的启用状态：0：禁用，1：启用'
);


-- 项目报价表
create table e_price
(
  id                     int                          primary key auto_increment,
  pId                    int                          not null     comment '项目Id',
  front                  float                                     comment '前端研发价格',
  back                   float                                     comment '后端研发价格',
  server                 float                                     comment '服务器价格',
  tax                    float                                     comment '税点',
  others                 float                                     comment '其他',
  creator                varchar(100)                 not null     comment '创建者',
  updater                varchar(100)                 not null     comment '更新者',
  createTime             int                          not null     comment '创建时间',
  updateTime             int                          not null     comment '更新时间'
);


-- 人员角色表
create table e_person_role
(
  id                     int                          primary key auto_increment,
  name                   varchar(100)                 not null     comment '角色名称',
  status                 tinyint                      default 1    comment '需求的启用状态：0：禁用，1：启用'
);

insert into e_person_role (name) values('项目管理者');
insert into e_person_role (name) values('前端开发');
insert into e_person_role (name) values('后端开发');
insert into e_person_role (name) values('普通用户');


-- 项目参与者表
create table e_participant
(
  id                     int                          primary key auto_increment,
  pId                    int                          not null     comment '项目Id',
  userId                 varchar(100)                 not null     comment '参与者Id',
  userName               varchar(50)                  not null     comment '参与者姓名',
  role                   int                          not null     comment '参与者角色',
  status                 tinyint                      default 1    comment '需求的启用状态：0：禁用，1：启用'
);


-- 项目进度类型表
create table e_schedule_type
(
  id                     int                          primary key auto_increment,
  name                   varchar(100)                 not null     comment '进度类型名称',
  status                 tinyint                      default 1    comment '需求的启用状态：0：禁用，1：启用'
);

insert into e_schedule_type (name) values('立项');
insert into e_schedule_type (name) values('开发');
insert into e_schedule_type (name) values('测试');
insert into e_schedule_type (name) values('修改');
insert into e_schedule_type (name) values('优化');
insert into e_schedule_type (name) values('上线');
insert into e_schedule_type (name) values('下线');


-- 进度详情表
create table e_project_schedule
(
  id                      int                         primary key auto_increment,
  pId                     int                         not null     comment '项目Id',
  type                    int                         not null     comment '进度类型',
  completeTime            int                         not null     comment '完成时间',
  detail                  text                                     comment '进度说明',
  isModify                boolean                     default 0    comment '该进度是否是修改类进度说明'
);


-- 项目数据表
create table e_project_data
(
  id                      int                         primary key auto_increment,
  pId                     int                         not null     comment '项目Id',
  pv                      int                                      comment '页面',
  uv                      int                                      comment '页面',
  playvideo               int                                      comment '事件',
  jumplink                int                                      comment '事件',
  createTime              int                         not null     comment '数据日期'
);


























