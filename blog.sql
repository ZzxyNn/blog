#Sql for blog


#
# Structure for table "admin"
#

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `auth_key` varchar(32) NOT NULL COMMENT '自动登录key',
  `password_hash` varchar(255) NOT NULL COMMENT '加密密码',
  `password_reset_token` varchar(255) DEFAULT NULL COMMENT '重置密码token',
  `email_validate_token` varchar(255) DEFAULT NULL COMMENT '邮箱验证token',
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `status` smallint(6) NOT NULL DEFAULT '10' COMMENT '状态',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='管理员表';

#
# Data for table "admin"
#

INSERT INTO `admin` VALUES (1,'zzxy','59_zWQ21zNB4HAqNyz1YHuvCirIcwsvT','$2y$13$NVjOhbmJ4KNLJjyyWyCmiuMhtul2u3T9Zc4hIwvF72U37xcwtg08u',NULL,NULL,'1234567@google.com',10,1486959420,1492431165),(5,'xnnxnn','x4-w9-wUM7K78tebxAGaWoAdpqZnXJrf','$2y$13$ygCgzmtovmsBnupxvmyHPO2cbnY1km5Yggzsj/LMs4/WVPQ.BYHnW',NULL,NULL,'1234@qq.com',10,1492429363,1492431001);

#
# Structure for table "auth_rule"
#

DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Data for table "auth_rule"
#


#
# Structure for table "auth_item"
#

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Data for table "auth_item"
#

INSERT INTO `auth_item` VALUES ('admin',1,'系统管理员',NULL,NULL,1492511185,1492511185),('createPost',2,'新增文章',NULL,NULL,1492511184,1492511184),('deletePost',2,'删除文章',NULL,NULL,1492511185,1492511185),('postAdmin',1,'文章管理员',NULL,NULL,1492511185,1492511185),('postOperator',1,'文章操作员',NULL,NULL,1492511185,1492511185),('updatePost',2,'修改文章',NULL,NULL,1492511184,1492511184);

#
# Structure for table "auth_item_child"
#

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Data for table "auth_item_child"
#

INSERT INTO `auth_item_child` VALUES ('admin','postAdmin'),('admin','postOperator'),('postAdmin','createPost'),('postAdmin','deletePost'),('postAdmin','updatePost'),('postOperator','deletePost');

#
# Structure for table "auth_assignment"
#

DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Data for table "auth_assignment"
#

INSERT INTO `auth_assignment` VALUES ('admin','1',1492511185),('postAdmin','3',1492511185),('postOperator','4',1492511185);

#
# Structure for table "cats"
#

DROP TABLE IF EXISTS `cats`;
CREATE TABLE `cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `cat_name` varchar(255) DEFAULT NULL COMMENT '分类名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='分类表';

#
# Data for table "cats"
#

INSERT INTO `cats` VALUES (1,'技术'),(2,'翻译'),(3,'转载'),(4,'提问'),(5,'娱乐'),(6,'资源');

#
# Structure for table "feeds"
#

DROP TABLE IF EXISTS `feeds`;
CREATE TABLE `feeds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `content` varchar(255) NOT NULL COMMENT '内容',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COMMENT='聊天信息表';

#
# Data for table "feeds"
#

/*!40000 ALTER TABLE `feeds` DISABLE KEYS */;
INSERT INTO `feeds` VALUES (38,1,'很简洁的博客',1489622305),(40,1,'这个博客好好看啊',1489641201),(41,1,'希望文章能多一点',1489641677),(42,1,'ChinaNo1',1489641688),(43,1,'多来一点干货吧',1489641708),(44,3,'我发布了一个泰国电影的文章',1489745562);
/*!40000 ALTER TABLE `feeds` ENABLE KEYS */;

#
# Structure for table "migration"
#

DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "migration"
#

INSERT INTO `migration` VALUES ('m000000_000000_base',1492505364),('m140506_102106_rbac_init',1492505376);

#
# Structure for table "post_extends"
#

DROP TABLE IF EXISTS `post_extends`;
CREATE TABLE `post_extends` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `post_id` int(11) DEFAULT NULL COMMENT '文章id',
  `browser` int(11) DEFAULT '0' COMMENT '浏览量',
  `collect` int(11) DEFAULT '0' COMMENT '收藏量',
  `praise` int(11) DEFAULT '0' COMMENT '点赞',
  `comment` int(11) DEFAULT '0' COMMENT '评论',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COMMENT='文章扩展表';

#
# Data for table "post_extends"
#

INSERT INTO `post_extends` VALUES (38,33,9,0,0,0),(39,34,11,0,0,0),(40,28,7,0,0,0),(41,32,11,0,0,0),(42,2,11,0,0,0),(43,1,29,0,0,0),(44,35,22,0,0,0),(45,36,32,0,0,0);

#
# Structure for table "post_tags"
#

DROP TABLE IF EXISTS `post_tags`;
CREATE TABLE `post_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `post_id` int(11) DEFAULT NULL COMMENT '文章ID',
  `tag_id` int(11) DEFAULT NULL COMMENT '标签ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_id` (`post_id`,`tag_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='文章和标签关系表';

#
# Data for table "post_tags"
#

INSERT INTO `post_tags` VALUES (1,32,41),(2,32,42),(3,33,43),(4,33,41),(5,33,1),(6,34,44),(7,34,45),(8,35,46),(9,36,47),(10,36,48),(11,36,49);

#
# Structure for table "posts"
#

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `summary` varchar(255) DEFAULT NULL COMMENT '摘要',
  `content` text COMMENT '内容',
  `label_img` varchar(255) DEFAULT NULL COMMENT '标签图',
  `cat_id` int(11) DEFAULT NULL COMMENT '分类id',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `user_name` varchar(255) DEFAULT NULL COMMENT '用户名',
  `is_valid` tinyint(1) DEFAULT '0' COMMENT '是否有效：0-未发布 1-已发布',
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_cat_valid` (`cat_id`,`is_valid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='文章主表';

#
# Data for table "posts"
#

INSERT INTO `posts` VALUES (1,'测试文章1','这里是测试文章的内容：123123123123456789456123asd1saf安抚45a6sf请我r1z56fas1安抚as5f4231652112 快结婚离婚1克讲话稿 1','<p>这里是测试文章的内容：123123123123456789456123asd1saf安抚45a6sf请我r1z56fas1安抚as5f4231652112 快结婚离婚1克讲话稿 1绿卡刚好1刘克军 i5lk1j3h恐龙计划51离开家好3加快好了快及回来空间5好了快接</p>','/image/20170222/1487753612101176.jpg',1,1,'zxy',1,1487753649,1492340353),(2,'测试文章2','这里是测试文章的内容：;;;;民政部定于2017年2月21日15时举行例行新闻发布会，介绍中办国办印发的《关于加强乡镇政府服务能力建设的意见》有关情况，解读民政部等部门近日印发的《','<p>这里是测试文章的内容：</p><p><span style=\"color: rgb(43, 43, 43); font-family: SimSun;\">&nbsp;&nbsp;&nbsp;&nbsp;民政部定于2017年2月21日15时举行例行新闻发布会，介绍中办国办印发的《关于加强乡镇政府服务能力建设的意见》有关情况，解读民政部等部门近日印发的《关于进一步加强医疗救助与城乡居民大病保险有效衔接的通知》，并答记者问。</span></p><p><span style=\"color: rgb(43, 43, 43); font-family: SimSun;\">&nbsp;&nbsp;&nbsp;&nbsp;记者：在方便困难群众看病就医方面，《通知》有什么新的规定和措施？如何避免重复报销和超费用报销？</span></p><p><span style=\"color: rgb(43, 43, 43); font-family: SimSun;\"><span style=\"color: rgb(43, 43, 43); font-family: SimSun;\">&nbsp;&nbsp;&nbsp;&nbsp;</span></span></p><p><span style=\"color: rgb(43, 43, 43); font-family: SimSun;\"><span style=\"color: rgb(43, 43, 43); font-family: SimSun;\">&nbsp;&nbsp;&nbsp;&nbsp;蒋玮表示，近年来，民政部门针对困难群众就医难以垫付医疗费用，不敢去医院看病、不敢住院的实际困难，和相关部门一起积极推动“一站式”即时结算服务，方便他们看病就医。所谓“一站式”即时结算，就是说困难群众到我们的医保和医疗救助定点医院看病以后住院结算费用的时候，他只需要支付他个人自付的这一部分就可以了，基本医保报的这些，包括医疗救助应该给他救助的部分，自动的在医院的结算平台上进行了费用的结算，个人只需要缴纳自付费用。这样以来就打消了需要自己垫资较高的住院费用的顾虑。目前全国已经有93%的地区开展了医疗救助“一站式”即时结算服务。　</span></span></p>','/image/20170222/1487754100895061.jpg',5,1,'zxy',1,1487754174,1487754174),(28,'测试文章3','测试内容：包括 MVC，DAO/ActiveRecord，I18N/L10N，缓存，身份验证和基于角色的访问控制，脚手架，测试等，可显著缩短开发时间。','<p><span style=\"color: rgb(51, 51, 51); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Hiragino Sans GB&quot;, &quot;Hiragino Sans GB W3&quot;, &quot;WenQuanYi Micro Hei&quot;, &quot;Microsoft YaHei UI&quot;, &quot;Microsoft YaHei&quot;, sans-serif; font-size: 14px; background-color: rgb(252, 252, 252);\">测试内容：包括 MVC，DAO/ActiveRecord，I18N/L10N，缓存，身份验证和基于角色的访问控制，脚手架，测试等，可显著缩短开发时间。</span></p>','/image/20170222/1487773929559499.jpg',6,1,'zxy',1,1487773931,1487773931),(32,'测试文章4','测试内容：yii2-admin在群里看到有人安装完后，不知道该怎么使用,这里就不说安装了，只介绍一下怎么用，大神绕道：1、代码中新添加的控制器会出现在方法，会在下图左侧出现，点击绿','<p>测试内容：</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(51, 51, 51); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Hiragino Sans GB&quot;, &quot;Hiragino Sans GB W3&quot;, &quot;WenQuanYi Micro Hei&quot;, &quot;Microsoft YaHei UI&quot;, &quot;Microsoft YaHei&quot;, sans-serif; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\">yii2-admin在群里看到有人安装完后，不知道该怎么使用,这里就不说安装了，只介绍一下怎么用，大神绕道：</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(51, 51, 51); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Hiragino Sans GB&quot;, &quot;Hiragino Sans GB W3&quot;, &quot;WenQuanYi Micro Hei&quot;, &quot;Microsoft YaHei UI&quot;, &quot;Microsoft YaHei&quot;, sans-serif; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\">1、代码中新添加的控制器会出现在方法，会在下图左侧出现，点击绿色移动到右边</p><p><br/></p>','/image/20170222/1487775740752453.jpg',6,1,'zxy',1,1487775751,1487775751),(33,'测试文章5','测试内容：村上春树（1949年1月12日—），日本现代小说家，生于京都伏见区。毕业于早稻田大学第一文学部演剧科。 ','<p>测试内容：</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(51, 51, 51); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Hiragino Sans GB&quot;, &quot;Hiragino Sans GB W3&quot;, &quot;WenQuanYi Micro Hei&quot;, &quot;Microsoft YaHei UI&quot;, &quot;Microsoft YaHei&quot;, sans-serif; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\">村上春树（1949年1月12日-），日本现代小说家，生于京都伏见区。毕业于早稻田大学第一文学部演剧科。 村上春树29岁开始写作，第一部作品《且听风吟》即获得日本群像新人奖，1987年第五部长篇小说《挪威的森林》上市至2010年在日本畅销一千万册，国内简体版到2004年销售总量786万，引起“村上现象”。 其作品风格深受欧美作家的影响，基调轻盈，少有日本战后阴郁沉重的文字气息，被称作第一个纯正的“二战后时期作家”，并被誉为日本80年代的文学旗手，其作品在世界范围内具有广泛知名度。 2017年2月24日，村上春树出版两卷本长篇小说《骑士团长杀人事件》，小说上卷命名为“念头显露篇”，下卷命名为“隐喻改变篇”。\n\n因提及南京大屠杀，日本作家村上春树的新作--《刺杀骑士团长》(上下册)遭到右翼人士的攻击，还有人在推特上发起了“不买村上春树运动”。尽管如此，这本书上市3天就位居综合销售排行榜榜首，目前已加印至130万册。</p><p><br/></p>','/image/20170222/1487775811596592.jpg',3,1,'zxy',1,1487775824,1487775824),(34,'测试文章6','主流LNMP运行环境PHP依赖管理工具高性能PHP Yii2.0框架第三方组件','<ul class=\"clearfix ul1 list-paddingleft-2\" style=\"list-style-type: none;\"><li><p>主流LNMP运行环境</p></li><li><p>PHP依赖管理工具</p></li><li><p>高性能PHP Yii2.0框架</p></li><li><p>第三方组件</p></li></ul><p><br/></p>','/image/20170307/1488862884135141.jpg',4,1,'zxy',1,1488862924,1488862924),(35,'测试文章7','测试内容：1、女儿：要是生妈妈时是双胞胎，那我就有两个妈妈是吗？爸爸：不是。妈妈就一个。女儿：那另外一个咋办？2、厨房的砂锅咕嘟咕嘟，冒出奇异的香气。突然看见我家小姑娘搬出小凳子，','<p>测试内容：</p><ul style=\"list-style-type: none;\" class=\" list-paddingleft-2\"><span id=\"text110\" style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); line-height: 28px;\"><p style=\"margin-top: 0px; margin-bottom: 20px; padding: 0px;\">1、女儿：要是生妈妈时是双胞胎，那我就有两个妈妈是吗？<br style=\"margin: 0px; padding: 0px;\"/>爸爸：不是。妈妈就一个。<br style=\"margin: 0px; padding: 0px;\"/>女儿：那另外一个咋办？</p><p style=\"margin-top: 0px; margin-bottom: 20px; padding: 0px;\">2、厨房的砂锅咕嘟咕嘟，冒出奇异的香气。突然看见我家小姑娘搬出小凳子，乖乖的坐在门口，左手拿个小碗，右手拿个小勺子，满心期待。<br style=\"margin: 0px; padding: 0px;\"/>真不忍心告诉她，锅里熬的是中药。</p><p style=\"margin-top: 0px; margin-bottom: 20px; padding: 0px;\">3、弟弟今天来我家，我倒了杯温水，对4岁多的儿子说：去，给你舅舅端杯水。<br style=\"margin: 0px; padding: 0px;\"/>他端着杯子送到弟弟手里送，不小心把水洒弟弟裤子上了。。。<br style=\"margin: 0px; padding: 0px;\"/>清理完后，我对他说：水太少了，在倒点去。<br style=\"margin: 0px; padding: 0px;\"/>然后他把剩下半杯水也倒在他舅舅裤子上了。。。</p><p style=\"margin-top: 0px; margin-bottom: 20px; padding: 0px;\">4、因为婚姻老大难，家里人都看我不顺眼，每天横挑鼻子竖挑眼，忍无可忍就要离家出走。<br style=\"margin: 0px; padding: 0px;\"/>小侄子抱着我大腿，哭着说：“二叔你不能走！！！！！！你走了，他们没人骂，就该骂我了！！！”</p><p style=\"margin-top: 0px; margin-bottom: 20px; padding: 0px;\">5、妹妹在唱小兔子乖乖，到最后一句，她唱的是：不开不开我不开，妈妈没回来，回来也不开～<br style=\"margin: 0px; padding: 0px;\"/>然后我问她：为什么妈妈回来也不开呢？<br style=\"margin: 0px; padding: 0px;\"/>她：你是不是傻，妈妈有钥匙呀！</p></span></ul><p><br/></p>','/image/20170317/1489739558458374.jpg',5,1,'zxy',1,1489739582,1489739582),(36,'你好，陌生人','跟前女友相处八年的dak （德·辰塔维·塔纳西维饰演）因为女友想结婚但是自己觉得没有能力照顾好女友而拒绝结婚，导致分手。被一帮好友醉醺醺地送往了独自去韩国旅行之路。官方剧照(13张','<p><br/></p><p>跟前女友相处八年的dak （<em>德·辰塔维·塔纳西维饰演</em>）因为女友想结婚但是自己觉得没有能力照顾好女友而拒绝结婚，导致分手。被一帮好友醉醺醺地送往了独自去韩国旅行之路。<a class=\"lemma-album layout-right nslog:10000206\" title=\"官方剧照\" href=\"http://baike.baidu.com/pic/%E4%BD%A0%E5%A5%BD%EF%BC%8C%E9%99%8C%E7%94%9F%E4%BA%BA/6184/3119976/5fdf8db1cb134954b5c13e75574e9258d0094ac0?fr=lemma&ct=cover\" target=\"_blank\" nslog-type=\"10000206\" style=\"color: rgb(19, 110, 194); text-decoration: none; display: block; width: 222px; border-bottom: 0px; margin: 10px 0px; position: relative; float: right; clear: right;\"></a></p><p><a class=\"lemma-album layout-right nslog:10000206\" title=\"官方剧照\" href=\"http://baike.baidu.com/pic/%E4%BD%A0%E5%A5%BD%EF%BC%8C%E9%99%8C%E7%94%9F%E4%BA%BA/6184/3119976/5fdf8db1cb134954b5c13e75574e9258d0094ac0?fr=lemma&ct=cover\" target=\"_blank\" nslog-type=\"10000206\" style=\"color: rgb(19, 110, 194); text-decoration: none; display: block; width: 222px; border-bottom: 0px; margin: 10px 0px; position: relative; float: right; clear: right;\">官方剧照<span class=\"number\" style=\"display: inline; color: gray;\">(13张)</span></a></p><p></p><p>因为跟男友相处被男友束缚的may（<em>努娜·能提妲·索彭饰演</em>）独自一个人到韩国。两位爱情失意的人在韩国不期而遇。困窘的dak接受了来自泰国同胞的may的帮助，就是这样的缘分，让两个年轻人走到一起，相互鼓励，相互帮助，慢慢产生了情愫，后期dak的前女友来找dak 要结婚，但是此时的dak已经爱上了may，两个人都回到泰国，彼此没有留下姓名，觉得如果知道了对方的姓名，就会顾及对方的感受，就这样一年以后，通过电台节目，dak表达了对may 的思念，may 激动地流下了热泪。<span style=\"font-size: 12px; line-height: 0; position: relative; vertical-align: baseline; top: -0.5em; margin-left: 2px; color: rgb(51, 102, 204); cursor: default; padding: 0px 2px;\">[1]</span><a style=\"color: rgb(19, 110, 194); position: relative; top: -50px; font-size: 0px; line-height: 0;\" name=\"ref_[1]_5397875\"></a>&nbsp;</p><p><br/></p><p>角色介绍：</p><ul class=\" list-paddingleft-2\"><li><p><span class=\"item-value\">旺财</span></p><p><span class=\"item-key\" style=\"margin: 0px 6px 0px 0px; color: rgb(153, 153, 153);\">演员</span><span class=\"item-value\">&nbsp;德·辰塔维·塔纳西维</span></p></li><li class=\"role-description\"><p>被朋友灌醉后直接送上了去韩国的路。抵达后十分窘迫，没钱没衣服还因醉酒错过了跟随旅行团旅行。因为女友即将嫁给别人旺财失恋伤心中，在异国他乡陷入窘境。幸亏几次偶遇善良的女主，得到女主的帮助。之后两人开始结伴在韩国旅游。渐渐地两人越走越近。</p></li></ul><p><br/></p><ul class=\" list-paddingleft-2\"><li><p><span class=\"item-value\">梅</span></p><p><span class=\"item-key\" style=\"margin: 0px 6px 0px 0px; color: rgb(153, 153, 153);\">演员</span><span class=\"item-value\">&nbsp;努娜·能提妲·索彭</span></p></li><li class=\"role-description\"><p>因为感情不顺瞒着男友独自来到韩国旅行散心，遇到了困窘的男主。忍不住不去给泰国同胞送去关怀，进而两人旅途中慢慢地感情发生了变化。过程有争吵有中了赌局的亢奋，最后因旺财的前女友找来韩国而匆匆分开，回国后和旺财做回了陌生人。</p></li></ul><p><br/></p><ul class=\" list-paddingleft-2\"><li><p><span class=\"item-value\">桂小姐</span></p><p><span class=\"item-key\" style=\"margin: 0px 6px 0px 0px; color: rgb(153, 153, 153);\">演员</span><span class=\"item-value\">&nbsp;Zcongkold</span></p></li><li class=\"role-description\"><p>男主的恋人女友，因以为她要嫁给别人所以男主才伤心买醉，进而来到韩国。片尾的明信片让桂找到了韩国，与男主重逢。</p></li></ul><p><br/></p><ul class=\" list-paddingleft-2\"><li><p><span class=\"item-value\">小苗</span></p><p><span class=\"item-key\" style=\"margin: 0px 6px 0px 0px; color: rgb(153, 153, 153);\">演员</span><span class=\"item-value\">&nbsp;Varathaya</span></p></li><li class=\"role-description\"><p>梅的闺蜜好友，共同瞒着梅的男友，说是两人结伴同去的韩国。其实是梅独自一人前往。影片最后梅回到韩国和小苗一起看SMAP的表演，看完后开车途中听到了男主旺财在电台嘉宾热线讲述了这段韩国陌生人旅行的故事。</p></li></ul><p><br/></p>','/image/20170317/1489745423214040.jpg',5,3,'zzxy',1,1489745510,1489745510);

#
# Structure for table "tags"
#

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `tag_name` varchar(255) DEFAULT NULL COMMENT '标签名称',
  `post_num` int(11) DEFAULT '0' COMMENT '关联文章数',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag_name` (`tag_name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COMMENT='标签表';

#
# Data for table "tags"
#

INSERT INTO `tags` VALUES (1,'yii2.0',2),(2,'框架',1),(41,'资源',2),(42,'福利',1),(43,'转载',1),(44,'技术',1),(45,'玄学',1),(46,'幽默',1),(47,'泰国',1),(48,'爱情',1),(49,'电影',1);

#
# Structure for table "user"
#

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `auth_key` varchar(32) NOT NULL COMMENT '自动登录key',
  `password_hash` varchar(255) NOT NULL COMMENT '加密密码',
  `password_reset_token` varchar(255) DEFAULT NULL COMMENT '重置密码token',
  `email_validate_token` varchar(255) DEFAULT NULL COMMENT '邮箱验证token',
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `role` smallint(6) NOT NULL DEFAULT '10' COMMENT '角色等级',
  `status` smallint(6) NOT NULL DEFAULT '10' COMMENT '状态',
  `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
  `vip_lv` int(11) DEFAULT '0' COMMENT 'vip等级',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='会员表';

#
# Data for table "user"
#

INSERT INTO `user` VALUES (1,'zxy','59_zWQ21zNB4HAqNyz1YHuvCirIcwsvT','$2y$13$NVjOhbmJ4KNLJjyyWyCmiuMhtul2u3T9Zc4hIwvF72U37xcwtg08u',NULL,NULL,'123456@google.com',10,10,'/statics/images/avatar/day4.jpg',0,1486959420,1490342322),(3,'zzxy','k5nNrYXR53Qat1u2YAuFKilHL2mi8RYE','$2y$13$S157VXwaUKI377uX77cVhuqV4SauNpIf3fpMsr2Q/5X7CQGYvCKtq',NULL,NULL,'1123456@google.com',10,10,'/statics/images/avatar/dem.jpg',0,1489745210,1489745210),(4,'xnnxnn','h9ep1ub24e5BPC6t99rVafxBn9GvBb_O','$2y$13$nyZ59e91.cVxu2tICrbPMO9VPDMOEQ99alx409SGnyxDhTbcY1PaG',NULL,NULL,'xnn@qq.com',10,10,'/images/20170321/1490093967133635.jpg',0,1490093986,1490093986),(5,'test','LaOG67-hr1B3UUo8-fGv5WFM_-hrVzDQ','$2y$13$oKZv3wLDsG0OHip3I8EiOu/sMZy2wfNF2nAMQBhalRLQ2M/UQE69C',NULL,NULL,'test@google.com',10,10,'',0,1490177727,1490177727);
