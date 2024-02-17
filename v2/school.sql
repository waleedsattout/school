CREATE TABLE `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `name` longtext NOT NULL,
  `arabic` longtext NOT NULL,
  `sections` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

CREATE TABLE `students` (
  `id` int(11) NOT NULL DEFAULT 0,
  `firstName` longtext CHARACTER SET utf8 NOT NULL,
  `lastName` longtext CHARACTER SET utf8 NOT NULL,
  `fatherName` longtext CHARACTER SET utf8 NOT NULL,
  `motherName` longtext CHARACTER SET utf8 NOT NULL,
  `dob` longtext CHARACTER SET utf8 NOT NULL,
  `class` varchar(3) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `section` longtext CHARACTER SET utf8 NOT NULL,
  `behav` longtext CHARACTER SET utf8 NOT NULL DEFAULT '0-0',
  `avg` int(11) NOT NULL DEFAULT 0,
  `rank` int(11) NOT NULL DEFAULT 0,
  `absent` longtext CHARACTER SET utf8 NOT NULL DEFAULT '0,0-0,0',
  `hide` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `subjectsmarks_c10` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studentID` int(11) NOT NULL,
  `religon` longtext DEFAULT '0,0,0,0-0,0,0,0',
  `watanea` longtext DEFAULT '0,0,0,0-0,0,0,0',
  `arabk` longtext DEFAULT '0,0,0,0-0,0,0,0',
  `eng` longtext DEFAULT '0,0,0,0-0,0,0,0',
  `reada` longtext DEFAULT '0,0,0,0-0,0,0,0',
  `mohasba` longtext DEFAULT '0,0,0,0-0,0,0,0',
  `edara` longtext DEFAULT '0,0,0,0-0,0,0,0',
  `kanon` longtext DEFAULT '0,0,0,0-0,0,0,0',
  `malea` longtext DEFAULT '0,0,0,0-0,0,0,0',
  `ehsaa` longtext DEFAULT '0,0,0,0-0,0,0,0',
  `hasob` longtext DEFAULT '0,0,0,0-0,0,0,0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

CREATE TABLE `subjects_c10` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `arabic` longtext NOT NULL,
  `tutor` longtext NOT NULL,
  `max` int(11) NOT NULL,
  `min` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `sem` int(11) NOT NULL DEFAULT 1,
  `header` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` longtext NOT NULL,
  `password` longtext NOT NULL,
  `role` int(11) NOT NULL,
  `access` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;



-- thie is some dummy data, you can delete them.

LOCK TABLES `classes` WRITE;
SET autocommit=0;
INSERT INTO `classes` VALUES (6,10,'c10','الأول الثانوي التجاري','3');
UNLOCK TABLES;
COMMIT;

LOCK TABLES `settings` WRITE;
SET autocommit=0;
INSERT INTO `settings` VALUES (1,'date','2023-2024'),(2,'showFasel2','0'),(3,'actualAttendance1','87'),(4,'actualAttendance2','81');
UNLOCK TABLES;
COMMIT;

LOCK TABLES `subjectsmarks_c10` WRITE;
SET autocommit=0;
INSERT INTO `subjectsmarks_c10` VALUES (1,1001,'50,50,85,175-0,0,0,0','45,45,95,100-0,0,0,0','100,100,186,354-0,0,0,0','65,65,85,155-0,0,0,0','50,50,100,200-0,0,0,0','150,150,150,270-0,0,0,0','90,90,100,200-0,0,0,0','75,75,90,270-0,0,0,0','80,80,130,200-0,0,0,0','75,70,160,310-0,0,0,0','100,100,140,400-0,0,0,0');
UNLOCK TABLES;
COMMIT;

LOCK TABLES `subjects_c10` WRITE;
SET autocommit=0;
INSERT INTO `subjects_c10` VALUES (1,'religon','التربية الدينية','منى',200,80,0,1,'مواد الثقافة العامة'),(2,'watanea','التربية الوطنية','زينب',200,80,0,1,'مواد الثقافة العامة'),(3,'arabk','اللغة العربية','فريدة',400,160,0,1,'مواد الثقافة العامة'),(4,'eng','اللغة الانكليزية','هبة',400,160,0,1,'مواد الثقافة العامة'),(5,'reada','التربية الرياضية','صالحة',200,80,0,1,'مواد الثقافة العامة'),(6,'mohasba','أساسيات المحاسبة','نادر',600,300,0,2,'مواد المهنية التخصصية'),(7,'edara','مبادئ الادارة والسكرتاريا','نادر',400,200,0,2,'مواد المهنية التخصصية'),(8,'kanon','مبادئ القانون المدني والتجاري','نور الدين',300,150,0,2,'مواد المهنية التخصصية'),(9,'malea','الرياضيات المالية','نادر',400,200,0,2,'مواد المهنية التخصصية'),(10,'ehsaa','الاحصاء','أحمد',400,200,0,2,'مواد المهنية التخصصية'),(11,'hasob','تطبيقات الحاسب في العلوم التجارية','مصطفى',400,200,0,2,'مواد المهنية التخصصية');
UNLOCK TABLES;
COMMIT;
