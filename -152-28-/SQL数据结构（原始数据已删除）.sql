# Host: localhost  (Version: 5.5.53)
# Date: 2018-03-25 14:51:23
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "gb_admin"
#

DROP TABLE IF EXISTS `gb_admin`;
CREATE TABLE `gb_admin` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT '管理员id',
  `worknum` varchar(30) NOT NULL DEFAULT '' COMMENT '用户工号',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '姓名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '用户密码',
  `type` varchar(50) DEFAULT '',
  `cateid` mediumint(9) DEFAULT '0' COMMENT '所属学院',
  `random` varchar(80) DEFAULT NULL COMMENT '随机值',
  PRIMARY KEY (`id`),
  UNIQUE KEY `工号` (`worknum`) COMMENT '工号',
  KEY `学院号` (`cateid`)
) ENGINE=MyISAM AUTO_INCREMENT=1929 DEFAULT CHARSET=utf8;

#
# Structure for table "gb_approval"
#

DROP TABLE IF EXISTS `gb_approval`;
CREATE TABLE `gb_approval` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` varchar(255) NOT NULL DEFAULT '',
  `type` int(11) DEFAULT '0' COMMENT '1article 2gbedu 3jianli 4homeb',
  `time` int(11) DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

#
# Structure for table "gb_article"
#

DROP TABLE IF EXISTS `gb_article`;
CREATE TABLE `gb_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` varchar(30) NOT NULL DEFAULT '' COMMENT '工号外键',
  `sex` varchar(20) DEFAULT '0' COMMENT '性别',
  `img` varchar(200) NOT NULL DEFAULT '' COMMENT '一寸照',
  `nation` varchar(20) NOT NULL DEFAULT '汉',
  `birthday` varchar(20) DEFAULT '0' COMMENT '出生日期',
  `jiguan_p` varchar(20) DEFAULT '0' COMMENT '籍贯省',
  `jiguan_c` varchar(20) DEFAULT '0' COMMENT '籍贯市',
  `chushengdi_p` varchar(20) DEFAULT '0' COMMENT '出生地省',
  `chushengdi_c` varchar(20) DEFAULT '0' COMMENT '出生地市',
  `politics` varchar(30) DEFAULT '0' COMMENT '政治面貌',
  `job` varchar(50) DEFAULT '0' COMMENT '职务',
  `zhiji` varchar(20) DEFAULT '0' COMMENT '职级',
  `jobtime` varchar(30) DEFAULT '0' COMMENT '任现职时间',
  `ranktime` varchar(30) DEFAULT '0' COMMENT '任现级时间',
  `alljobtime` varchar(30) DEFAULT '0' COMMENT '工作时间',
  `joinpartytime` varchar(30) DEFAULT '0' COMMENT '入党时间',
  `edubg` varchar(30) DEFAULT '0' COMMENT '学历',
  `degree` varchar(30) DEFAULT '0' COMMENT '学位',
  `ptitle` varchar(50) DEFAULT '0' COMMENT '职称',
  `health` varchar(50) DEFAULT '0' COMMENT '健康状况',
  `jiangcheng` mediumtext COMMENT '奖惩情况',
  `jieguo` mediumtext COMMENT '考核结果',
  `specialjob` varchar(40) DEFAULT '0' COMMENT '专业或专长',
  `specialskill` mediumtext NOT NULL COMMENT '备注',
  `try` varchar(10) DEFAULT NULL COMMENT '是否试用',
  `pinrenzhi` varchar(20) NOT NULL DEFAULT '否' COMMENT '聘任制院长',
  `time` int(10) NOT NULL DEFAULT '0' COMMENT '时间',
  `sort` smallint(6) NOT NULL DEFAULT '50' COMMENT '排序',
  `niandu` varchar(100) DEFAULT NULL COMMENT '年度考核登记表',
  `peixun` varchar(100) DEFAULT NULL COMMENT '培训情况登记表',
  `shuzhi` varchar(100) DEFAULT NULL COMMENT '述职述廉报告',
  PRIMARY KEY (`id`),
  UNIQUE KEY `adminid` (`adminid`)
) ENGINE=MyISAM AUTO_INCREMENT=132 DEFAULT CHARSET=utf8 COMMENT='干部信息';

#
# Structure for table "gb_article2"
#

DROP TABLE IF EXISTS `gb_article2`;
CREATE TABLE `gb_article2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` varchar(30) NOT NULL DEFAULT '' COMMENT '工号外键',
  `sex` varchar(20) DEFAULT '0' COMMENT '性别',
  `img` varchar(200) DEFAULT '' COMMENT '一寸照',
  `nation` varchar(20) DEFAULT '汉',
  `birthday` varchar(20) DEFAULT '0' COMMENT '出生日期',
  `jiguan_p` varchar(20) DEFAULT '0' COMMENT '籍贯省',
  `jiguan_c` varchar(20) DEFAULT '0' COMMENT '籍贯市',
  `chushengdi_p` varchar(20) DEFAULT '0' COMMENT '出生地省',
  `chushengdi_c` varchar(20) DEFAULT '0' COMMENT '出生地市',
  `politics` varchar(30) DEFAULT '0' COMMENT '政治面貌',
  `job` varchar(50) DEFAULT '0' COMMENT '职务',
  `zhiji` varchar(20) DEFAULT '0' COMMENT '职级',
  `jobtime` varchar(30) DEFAULT '0' COMMENT '任现职时间',
  `ranktime` varchar(30) DEFAULT '0' COMMENT '任现级时间',
  `alljobtime` varchar(30) DEFAULT '0' COMMENT '工作时间',
  `joinpartytime` varchar(30) DEFAULT '0' COMMENT '入党时间',
  `edubg` varchar(30) DEFAULT '0' COMMENT '学历',
  `degree` varchar(30) DEFAULT '0' COMMENT '学位',
  `ptitle` varchar(50) DEFAULT '0' COMMENT '职称',
  `health` varchar(50) DEFAULT '0' COMMENT '健康状况',
  `jiangcheng` mediumtext COMMENT '奖惩情况',
  `jieguo` mediumtext COMMENT '考核结果',
  `specialjob` varchar(40) DEFAULT '0' COMMENT '专业或专长',
  `specialskill` mediumtext COMMENT '备注',
  `try` varchar(10) DEFAULT NULL COMMENT '是否试用',
  `time` int(10) DEFAULT '0' COMMENT '时间',
  `sort` smallint(6) DEFAULT '50',
  `message` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=862 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='干部信息备份';

#
# Structure for table "gb_auth_group"
#

DROP TABLE IF EXISTS `gb_auth_group`;
CREATE TABLE `gb_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Structure for table "gb_auth_group_access"
#

DROP TABLE IF EXISTS `gb_auth_group_access`;
CREATE TABLE `gb_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL DEFAULT '5',
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Structure for table "gb_auth_rule"
#

DROP TABLE IF EXISTS `gb_auth_rule`;
CREATE TABLE `gb_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  `pid` mediumint(9) NOT NULL DEFAULT '0',
  `level` tinyint(1) NOT NULL DEFAULT '0',
  `sort` int(5) NOT NULL DEFAULT '50',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

#
# Structure for table "gb_bechecked"
#

DROP TABLE IF EXISTS `gb_bechecked`;
CREATE TABLE `gb_bechecked` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `worknum` varchar(40) NOT NULL DEFAULT '' COMMENT '中层干部工号',
  `cateid` varchar(40) NOT NULL DEFAULT '' COMMENT '班子测评的部门id',
  `sumid` varchar(40) NOT NULL DEFAULT '' COMMENT '调查表id',
  PRIMARY KEY (`Id`),
  KEY `worknum` (`worknum`,`cateid`,`sumid`)
) ENGINE=MyISAM AUTO_INCREMENT=18264 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='被调查者表格';

#
# Structure for table "gb_cate"
#

DROP TABLE IF EXISTS `gb_cate`;
CREATE TABLE `gb_cate` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `catename` varchar(30) NOT NULL DEFAULT '' COMMENT '部门名称',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '部门级别',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '部门类别民主',
  `keywords2` varchar(255) NOT NULL DEFAULT '' COMMENT '部门类别互评',
  `content` text NOT NULL COMMENT '内容',
  `rec_index` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:不推荐 1：推荐',
  `rec_bottom` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:不推荐 1：推荐',
  `pid` mediumint(9) NOT NULL DEFAULT '0' COMMENT '上级栏目id',
  `sort` mediumint(9) NOT NULL DEFAULT '50' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=118 DEFAULT CHARSET=utf8;

#
# Structure for table "gb_check"
#

DROP TABLE IF EXISTS `gb_check`;
CREATE TABLE `gb_check` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `worknum` varchar(30) NOT NULL DEFAULT '' COMMENT '用户工号',
  `sumid` int(11) NOT NULL DEFAULT '0' COMMENT '调查表ID',
  `status` varchar(10) NOT NULL DEFAULT '2' COMMENT '状态 1已测评 2未测评 3已过期 4未开启',
  `allvote` int(11) NOT NULL DEFAULT '1' COMMENT '表对应用户总投票数',
  PRIMARY KEY (`Id`),
  KEY `sumid` (`sumid`,`worknum`)
) ENGINE=MyISAM AUTO_INCREMENT=160700 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='参与评价用户表格';

#
# Structure for table "gb_checktable"
#

DROP TABLE IF EXISTS `gb_checktable`;
CREATE TABLE `gb_checktable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sumid` int(11) NOT NULL DEFAULT '0' COMMENT '自定义ID',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '调查表名字',
  `timestart` varchar(20) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `timeend` varchar(20) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `type` varchar(255) NOT NULL DEFAULT '' COMMENT '调查表类型',
  `time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=152 DEFAULT CHARSET=utf8 COMMENT='调查表信息';

#
# Structure for table "gb_conf"
#

DROP TABLE IF EXISTS `gb_conf`;
CREATE TABLE `gb_conf` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT '配置项id',
  `cnname` varchar(50) NOT NULL COMMENT '配置中文名称',
  `enname` varchar(50) NOT NULL COMMENT '英文名称',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '配置类型 1：单行文本框 2：多行文本 3：单选按钮 4：复选按钮 5：下拉菜单',
  `value` varchar(255) NOT NULL COMMENT '配置值',
  `values` varchar(255) NOT NULL COMMENT '配置可选值',
  `sort` smallint(6) NOT NULL DEFAULT '50' COMMENT '配置项排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

#
# Structure for table "gb_data"
#

DROP TABLE IF EXISTS `gb_data`;
CREATE TABLE `gb_data` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `sumid` int(11) NOT NULL DEFAULT '0' COMMENT '调查表ID',
  `beworknum` varchar(30) DEFAULT '' COMMENT '受测评者工号',
  `cateid` varchar(50) DEFAULT '' COMMENT '收评测部门ID',
  `worknum` varchar(30) DEFAULT '' COMMENT '投票者工号',
  `neng` varchar(50) DEFAULT NULL COMMENT '能',
  `qin` varchar(50) DEFAULT NULL COMMENT '勤',
  `ji` varchar(50) DEFAULT NULL COMMENT '绩',
  `lian` varchar(50) DEFAULT NULL COMMENT '廉',
  `summary` varchar(50) DEFAULT NULL COMMENT '总体评价（民主）',
  `zzde` varchar(50) DEFAULT NULL COMMENT '政治品德',
  `zyde` varchar(50) DEFAULT NULL COMMENT '职业道德',
  `shde` varchar(50) DEFAULT NULL COMMENT '社会公德',
  `jtde` varchar(50) DEFAULT NULL COMMENT '家庭美德',
  `summary2` varchar(50) DEFAULT NULL COMMENT '总体评价（德）',
  `Q1` varchar(20) DEFAULT '没有' COMMENT '不敢坚持原则，做老好人',
  `Q2` varchar(20) DEFAULT '没有' COMMENT '大局意识差',
  `Q3` varchar(20) DEFAULT '没有' COMMENT '工作责任心不强，在急难险重任务面前退缩逃避、敷衍推诿、怕承担责任',
  `Q4` varchar(20) DEFAULT '没有' COMMENT '组织观念不强、工作上不服从组织安排',
  `Q5` varchar(20) DEFAULT '没有' COMMENT '闹不团结',
  `Q6` varchar(20) DEFAULT '没有' COMMENT '虚报工作业绩',
  `Q7` varchar(20) DEFAULT '没有' COMMENT '有跑官要官、拉票等非组织行为',
  `Q8` varchar(20) DEFAULT '没有' COMMENT '对个人名利得失比较计较',
  `Q9` varchar(20) DEFAULT '没有' COMMENT '学术不端，以不正当手段获取荣誉、称职、学历学位等利益',
  `Q10` varchar(20) DEFAULT '没有' COMMENT '发表、传播错误言论，散布贬损他人的小道消息',
  `Q11` varchar(20) DEFAULT '没有' COMMENT '讲排场，比阔气，挥霍公款，铺张浪费，追求享受',
  `Q12` varchar(20) DEFAULT '没有' COMMENT '大办婚事丧事，造成不良影响',
  `Q13` varchar(20) DEFAULT '没有' COMMENT '作风不检点，不注意自身形象',
  `Q14` varchar(20) DEFAULT '没有' COMMENT '对亲属和身边工作人员要交不严，利用职权和职务上的影响',
  `Q15` varchar(20) DEFAULT '没有' COMMENT '交友不慎，造成不良后果',
  `Else` varchar(50) DEFAULT NULL COMMENT '如有上述情况或其他不良表现，请用文字在反面作具体说明',
  `bzsummary` varchar(30) DEFAULT NULL COMMENT '班子总体评价',
  `yijian` text COMMENT '意见',
  `time` int(10) DEFAULT NULL COMMENT '时间',
  `srd` varchar(50) DEFAULT NULL COMMENT '试用期干部胜任度',
  `zssr` varchar(50) DEFAULT NULL COMMENT '是否同意正式胜任',
  `de` varchar(50) DEFAULT NULL COMMENT '德（已弃用）',
  `score1` varchar(50) DEFAULT NULL COMMENT '分数（民主）',
  `score2` varchar(50) DEFAULT NULL COMMENT '分数（德）',
  `score3` varchar(50) DEFAULT NULL COMMENT '分数（班子）',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=16689 DEFAULT CHARSET=utf8 COMMENT='投票信息存储表';

#
# Structure for table "gb_gbchange"
#

DROP TABLE IF EXISTS `gb_gbchange`;
CREATE TABLE `gb_gbchange` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `worknum` varchar(20) NOT NULL DEFAULT '' COMMENT '工号',
  `sex` varchar(20) NOT NULL DEFAULT '' COMMENT '性别',
  `img` varchar(255) NOT NULL DEFAULT '' COMMENT '一寸照',
  `birthday` varchar(20) NOT NULL DEFAULT '' COMMENT '出生日期',
  `nation` varchar(20) NOT NULL DEFAULT '' COMMENT '民族',
  `jiguan_p` varchar(20) NOT NULL DEFAULT '' COMMENT '籍贯省',
  `jiguan_c` varchar(20) NOT NULL DEFAULT '' COMMENT '籍贯市',
  `chushengdi_p` varchar(20) NOT NULL DEFAULT '' COMMENT '出生地省',
  `chushengdi_c` varchar(20) NOT NULL DEFAULT '' COMMENT '出生地市',
  `politics` varchar(50) NOT NULL DEFAULT '' COMMENT '政治面貌',
  `job` varchar(50) NOT NULL DEFAULT '' COMMENT '职务',
  `newjob` varchar(50) NOT NULL DEFAULT '' COMMENT '拟任职务',
  `oldjob` varchar(50) NOT NULL DEFAULT '' COMMENT '拟任职务',
  `jobtime` varchar(50) NOT NULL DEFAULT '' COMMENT '任现职时间',
  `ranktime` varchar(50) NOT NULL DEFAULT '' COMMENT '任现级时间',
  `alljobtime` varchar(50) NOT NULL DEFAULT '' COMMENT '工作时间',
  `joinpartytime` varchar(50) NOT NULL DEFAULT '' COMMENT '入党时间',
  `edubg` varchar(30) NOT NULL DEFAULT '' COMMENT '学历',
  `edubg_by` varchar(50) NOT NULL DEFAULT '' COMMENT '毕业院校系及专业',
  `degree` varchar(30) NOT NULL DEFAULT '' COMMENT '学位',
  `degree_by` varchar(50) NOT NULL DEFAULT '' COMMENT '毕业院校系及专业',
  `ptitle` varchar(50) NOT NULL DEFAULT '' COMMENT '职称',
  `health` varchar(50) NOT NULL DEFAULT '' COMMENT '健康状况',
  `specialjob` varchar(255) NOT NULL DEFAULT '' COMMENT '专业技术职务',
  `specialskill` varchar(255) NOT NULL DEFAULT '' COMMENT '熟悉专业有何专长',
  `curriculum_vitae` text NOT NULL COMMENT '简历',
  `jiangcheng` text NOT NULL COMMENT '奖惩情况',
  `niandukaohe` text NOT NULL COMMENT '年度考核结果',
  `renmianliyou` text NOT NULL COMMENT '任免理由',
  `chengbaodanwei` varchar(50) NOT NULL DEFAULT '' COMMENT '呈报单位',
  `shengpi` varchar(50) NOT NULL DEFAULT '' COMMENT '审批机关意见',
  `xingzheng` varchar(255) NOT NULL DEFAULT '' COMMENT '行政机关任免意见',
  `time` int(10) NOT NULL DEFAULT '0' COMMENT '时间',
  `cateid` mediumint(9) NOT NULL DEFAULT '0' COMMENT '所属栏目',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '类别',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='干部任免审批信息';

#
# Structure for table "gb_gbedu"
#

DROP TABLE IF EXISTS `gb_gbedu`;
CREATE TABLE `gb_gbedu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` varchar(30) NOT NULL DEFAULT '' COMMENT '用户工号',
  `qschool` varchar(50) DEFAULT NULL COMMENT '全日制毕业院校',
  `qzhuanye` varchar(40) DEFAULT NULL COMMENT '全日制专业',
  `qedubg` varchar(40) DEFAULT NULL COMMENT '全日制学历',
  `qdegree` varchar(40) DEFAULT NULL COMMENT '全日制学位',
  `zschool` varchar(50) DEFAULT NULL COMMENT '在职毕业院校',
  `zzhuanye` varchar(40) DEFAULT NULL COMMENT '在职专业',
  `zedubg` varchar(40) DEFAULT NULL COMMENT '在职学历',
  `zdegree` varchar(40) DEFAULT NULL COMMENT '在职学位',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='干部教育背景';

#
# Structure for table "gb_gbedu2"
#

DROP TABLE IF EXISTS `gb_gbedu2`;
CREATE TABLE `gb_gbedu2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` varchar(30) NOT NULL DEFAULT '' COMMENT '用户工号',
  `qschool` varchar(50) DEFAULT NULL COMMENT '全日制毕业院校',
  `qzhuanye` varchar(40) DEFAULT NULL COMMENT '全日制专业',
  `qedubg` varchar(40) DEFAULT NULL COMMENT '全日制学历',
  `qdegree` varchar(40) DEFAULT NULL COMMENT '全日制学位',
  `zschool` varchar(50) DEFAULT NULL COMMENT '在职毕业院校',
  `zzhuanye` varchar(40) DEFAULT NULL COMMENT '在职专业',
  `zedubg` varchar(40) DEFAULT NULL COMMENT '在职学历',
  `zdegree` varchar(40) DEFAULT NULL COMMENT '在职学位',
  `time` int(11) DEFAULT '0',
  `message` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='干部教育背景备份';

#
# Structure for table "gb_gbinf"
#

DROP TABLE IF EXISTS `gb_gbinf`;
CREATE TABLE `gb_gbinf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `sex` varchar(20) NOT NULL DEFAULT '' COMMENT '性别',
  `img` varchar(255) NOT NULL DEFAULT '' COMMENT '一寸照',
  `birthday` varchar(20) NOT NULL DEFAULT '' COMMENT '出生日期',
  `jiguan_p` varchar(20) NOT NULL DEFAULT '' COMMENT '籍贯省',
  `jiguan_c` varchar(20) NOT NULL DEFAULT '' COMMENT '籍贯市',
  `chushengdi_p` varchar(20) NOT NULL DEFAULT '' COMMENT '出生地省',
  `chushengdi_c` varchar(20) NOT NULL DEFAULT '' COMMENT '出生地市',
  `politics` varchar(50) NOT NULL DEFAULT '' COMMENT '政治面貌',
  `department` varchar(100) NOT NULL DEFAULT '' COMMENT '部门',
  `job` varchar(50) NOT NULL DEFAULT '' COMMENT '职务',
  `jobtime` varchar(50) NOT NULL DEFAULT '' COMMENT '任现职时间',
  `ranktime` varchar(50) NOT NULL DEFAULT '' COMMENT '任现级时间',
  `alljobtime` varchar(50) NOT NULL DEFAULT '' COMMENT '工作时间',
  `joinpartytime` varchar(50) NOT NULL DEFAULT '' COMMENT '入党时间',
  `edubg` varchar(30) NOT NULL DEFAULT '' COMMENT '学历',
  `degree` varchar(30) NOT NULL DEFAULT '' COMMENT '学位',
  `ptitle` varchar(50) NOT NULL DEFAULT '' COMMENT '职称',
  `health` varchar(50) NOT NULL DEFAULT '' COMMENT '健康状况',
  `specialjob` varchar(255) NOT NULL DEFAULT '' COMMENT '专业技术职务',
  `specialskill` varchar(255) NOT NULL DEFAULT '' COMMENT '熟悉专业有何专长',
  `time` int(10) NOT NULL DEFAULT '0' COMMENT '时间',
  `cateid` mediumint(9) NOT NULL DEFAULT '0' COMMENT '所属栏目',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='干部信息';

#
# Structure for table "gb_homeb"
#

DROP TABLE IF EXISTS `gb_homeb`;
CREATE TABLE `gb_homeb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` varchar(30) NOT NULL DEFAULT '' COMMENT '工号',
  `relation` varchar(30) DEFAULT NULL COMMENT '称谓',
  `name` varchar(30) DEFAULT NULL COMMENT '姓名',
  `birthday` varchar(20) DEFAULT NULL COMMENT '出生日期',
  `party` varchar(30) DEFAULT NULL COMMENT '政治面貌',
  `workplace` varchar(40) DEFAULT NULL COMMENT '工作岗位',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=162 DEFAULT CHARSET=utf8 COMMENT='家庭背景';

#
# Structure for table "gb_homeb2"
#

DROP TABLE IF EXISTS `gb_homeb2`;
CREATE TABLE `gb_homeb2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` varchar(30) NOT NULL DEFAULT '' COMMENT '工号',
  `relation` varchar(30) DEFAULT NULL COMMENT '称谓',
  `name` varchar(30) DEFAULT NULL COMMENT '姓名',
  `birthday` varchar(20) DEFAULT NULL COMMENT '出生日期',
  `party` varchar(30) DEFAULT NULL COMMENT '政治面貌',
  `workplace` varchar(40) DEFAULT NULL COMMENT '工作岗位',
  `time` int(11) DEFAULT '0',
  `message` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='家庭背景备份';

#
# Structure for table "gb_jianli"
#

DROP TABLE IF EXISTS `gb_jianli`;
CREATE TABLE `gb_jianli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` varchar(30) NOT NULL DEFAULT '' COMMENT '工号',
  `starttime` varchar(30) DEFAULT NULL COMMENT '起始时间',
  `endtime` varchar(30) DEFAULT NULL COMMENT '截止时间',
  `information` mediumtext COMMENT '详细信息',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=253 DEFAULT CHARSET=utf8 COMMENT='中层干部简历';

#
# Structure for table "gb_jianli2"
#

DROP TABLE IF EXISTS `gb_jianli2`;
CREATE TABLE `gb_jianli2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` varchar(30) NOT NULL DEFAULT '' COMMENT '工号',
  `starttime` varchar(30) DEFAULT NULL COMMENT '起始时间',
  `endtime` varchar(30) DEFAULT NULL COMMENT '截止时间',
  `information` mediumtext COMMENT '详细信息',
  `time` int(11) NOT NULL DEFAULT '0',
  `message` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='中层干部简历备份';

#
# Structure for table "gb_login"
#

DROP TABLE IF EXISTS `gb_login`;
CREATE TABLE `gb_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `worknum` varchar(30) DEFAULT NULL COMMENT '工号',
  `random` varchar(80) DEFAULT NULL COMMENT '随机值',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '时间',
  `ip` varchar(255) DEFAULT NULL COMMENT '用户ip',
  `area` varchar(255) DEFAULT NULL COMMENT '地点',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2751 DEFAULT CHARSET=utf8 COMMENT='登录记录';

#
# Structure for table "gb_message"
#

DROP TABLE IF EXISTS `gb_message`;
CREATE TABLE `gb_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL COMMENT '标题',
  `text` mediumtext COMMENT '文本',
  `date` int(11) DEFAULT NULL COMMENT '日期',
  `worknum` varchar(255) NOT NULL DEFAULT '0' COMMENT '对象工号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COMMENT='消息发布';

#
# Structure for table "gb_test"
#

DROP TABLE IF EXISTS `gb_test`;
CREATE TABLE `gb_test` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `sampid` int(11) NOT NULL,
  `A` float NOT NULL,
  `B` float NOT NULL,
  `C` float NOT NULL,
  `D` float NOT NULL,
  `E` float NOT NULL,
  `F` float NOT NULL,
  `uptime` datetime NOT NULL,
  `sampcate` int(10) NOT NULL,
  `upuser` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=388 DEFAULT CHARSET=utf8;

#
# Structure for table "gb_cha"
#

DROP VIEW IF EXISTS `gb_cha`;
CREATE VIEW `gb_cha` AS 
  select `gb_admin`.`worknum` AS `worknum`,`gb_admin`.`name` AS `name`,`gb_admin`.`type` AS `type`,`gb_admin`.`cateid` AS `cateid`,`gb_article`.`adminid` AS `adminid`,`gb_article`.`sex` AS `sex`,`gb_article`.`img` AS `img`,`gb_article`.`nation` AS `nation`,`gb_article`.`birthday` AS `birthday`,`gb_article`.`jiguan_p` AS `jiguan_p`,`gb_article`.`jiguan_c` AS `jiguan_c`,`gb_article`.`chushengdi_p` AS `chushengdi_p`,`gb_article`.`chushengdi_c` AS `chushengdi_c`,`gb_article`.`politics` AS `politics`,`gb_article`.`job` AS `job`,`gb_article`.`zhiji` AS `zhiji`,`gb_article`.`jobtime` AS `jobtime`,`gb_article`.`ranktime` AS `ranktime`,`gb_article`.`alljobtime` AS `alljobtime`,`gb_article`.`joinpartytime` AS `joinpartytime`,`gb_article`.`edubg` AS `edubg`,`gb_article`.`degree` AS `degree`,`gb_article`.`ptitle` AS `ptitle`,`gb_article`.`health` AS `health`,`gb_article`.`jiangcheng` AS `jiangcheng`,`gb_article`.`jieguo` AS `jieguo`,`gb_article`.`specialjob` AS `specialjob`,`gb_article`.`specialskill` AS `specialskill`,`gb_article`.`try` AS `try`,`gb_article`.`time` AS `time`,`gb_article`.`sort` AS `sort` from (`gb_admin` join `gb_article`) where (`gb_admin`.`worknum` = `gb_article`.`adminid`);

#
# Structure for table "gb_view_yonghu"
#

DROP VIEW IF EXISTS `gb_view_yonghu`;
CREATE VIEW `gb_view_yonghu` AS 
  select `gb_admin`.`worknum` AS `worknum`,`gb_admin`.`name` AS `name`,`gb_admin`.`type` AS `type`,`gb_cate`.`catename` AS `catename`,`gb_cate`.`id` AS `cateid`,`gb_cate`.`keywords` AS `keywords`,`gb_cate`.`keywords2` AS `keywords2` from (`gb_admin` join `gb_cate`) where (`gb_admin`.`cateid` = `gb_cate`.`id`);

#
# Structure for table "gb_view_checktable"
#

DROP VIEW IF EXISTS `gb_view_checktable`;
CREATE VIEW `gb_view_checktable` AS 
  select `a`.`id` AS `id`,`b`.`worknum` AS `worknum`,`d1`.`name` AS `name`,`c`.`worknum` AS `beworknum`,`d2`.`name` AS `bename`,`d2`.`cateid` AS `cateid`,`j`.`job` AS `job` from (((((`gb_checktable` `a` join `gb_check` `b`) join `gb_bechecked` `c`) join `gb_view_yonghu` `d1`) join `gb_view_yonghu` `d2`) join `gb_article` `j`) where ((`a`.`id` = `b`.`sumid`) and (`a`.`id` = `c`.`sumid`) and (`d1`.`worknum` = `b`.`worknum`) and (`d2`.`worknum` = `c`.`worknum`) and (`j`.`adminid` = `c`.`worknum`));
