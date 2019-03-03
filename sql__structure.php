<?php
//============== STRUCTURE =====================================================
$err=0;
$dbLink=mysqli_connect($_SESSION[PGMK]['server'],$_SESSION[PGMK]['user'],$_SESSION[PGMK]['password'],$_SESSION[PGMK]['appkey']);
if(!$dbLink){
 $err=1;
 header('Location: '.BNF.'?errormessage='.urlencode(__LINE__ . ' I cannot connect to the local database server') );
 exit();
};
mysqli_set_charset( $dbLink , 'utf8mb4' );
if($err==0){

 $sql='CREATE TABLE `tdo_tbl__css` (
   `fld_id_css` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
   `fld_name_css` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\' COMMENT \'{"showDeleteField":true}\',
   `fld_active_css` tinyint(4) NOT NULL DEFAULT \'0\' COMMENT \'{"param":"yorno"}\',
   `fld_color_back_css` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT \'{"subtype":"webcolor"}\',
   `fld_color_text_css` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT \'{"subtype":"webcolor"}\',
   `fld_json_css` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `fld_tsupd_css` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_tscrt_css` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_cntupd_css` bigint(20) unsigned NOT NULL DEFAULT \'0\',
   PRIMARY KEY (`fld_id_css`),
   UNIQUE KEY `k_name` (`fld_name_css`)
 ) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode('I cannot create the table tdo_tbl__css'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $sql='CREATE TABLE `tdo_tbl__groups` (
   `fld_id_groups` bigint(20) NOT NULL AUTO_INCREMENT,
   `fld_name_groups` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\' COMMENT \'{"showDeleteField":true}\',
   `fld_parent_id_groups` bigint(20) NOT NULL DEFAULT \'1\',
   `fld_isactive_groups` tinyint(4) NOT NULL DEFAULT \'1\' COMMENT \'{"param":"yorno"}\',
   `fld_tsupd_groups` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_tscrt_groups` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_cntupd_groups` bigint(20) NOT NULL DEFAULT \'0\',
   PRIMARY KEY (`fld_id_groups`),
   UNIQUE KEY `key_1_groups` (`fld_name_groups`,`fld_parent_id_groups`) USING BTREE,
   KEY `fk_group` (`fld_parent_id_groups`)
 ) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode('I cannot create the table tdo_tbl__groups'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $sql='CREATE TABLE `tdo_tbl__grpspgs` (
   `fld_id_grpspgs` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
   `fld_group_id_grpspgs` bigint(20) NOT NULL DEFAULT \'0\',
   `fld_page_id_grpspgs` bigint(20) NOT NULL DEFAULT \'0\',
   `fld_is_menu_grpspgs` tinyint(4) NOT NULL DEFAULT \'0\' COMMENT \'{"param":"yorno"}\',
   `fld_menu_order_grpspgs` int(11) NOT NULL DEFAULT \'0\',
   `fld_tscrt_grpspgs` datetime NOT NULL DEFAULT \'2000-01-01 00:00:00\',
   `fld_tsupd_grpspgs` datetime NOT NULL DEFAULT \'2000-01-01 00:00:00\',
   `fld_cntupd_grpspgs` bigint(20) NOT NULL DEFAULT \'0\',
   PRIMARY KEY (`fld_id_grpspgs`),
   UNIQUE KEY `k_grppag` (`fld_group_id_grpspgs`,`fld_page_id_grpspgs`),
   KEY `fk_page_of_grppgs` (`fld_page_id_grpspgs`)
 ) ENGINE=MyISAM AUTO_INCREMENT=147 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode('I cannot create the table tdo_tbl__grpspgs'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $sql='CREATE TABLE `tdo_tbl__langvalues` (
   `fld_id_lngVals` bigint(20) NOT NULL AUTO_INCREMENT,
   `fld_key_lngVals` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\',
   `fld_lang_lngVals` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\',
   `fld_page_id_lngVals` bigint(20) unsigned DEFAULT NULL,
   `fld_value_lngVals` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `fld_type_lngVals` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'page\',
   `fld_tsupd_lngVals` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_tscrt_lngVals` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_cntupd_lngVals` int(11) NOT NULL DEFAULT \'0\',
   PRIMARY KEY (`fld_id_lngVals`),
   UNIQUE KEY `k_page_key_lang` (`fld_key_lngVals`,`fld_lang_lngVals`,`fld_page_id_lngVals`,`fld_type_lngVals`) USING BTREE
 ) ENGINE=MyISAM AUTO_INCREMENT=2236 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode('I cannot create the table tdo_tbl__langvalues'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $sql='CREATE TABLE `tdo_tbl__log` (
   `fld_timstp_log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   `fld_sql_log` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `fld_bnf_log` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
   `fld_line_log` int(11) NOT NULL DEFAULT \'0\',
   `fld_user_id_log` bigint(20) unsigned NOT NULL DEFAULT \'0\',
   `fld_typ_log` enum(\'1\',\'2\',\'3\') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'1\' COMMENT \'{"comment":"1:sql, 2 error , 3 information"}\'
 ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode('I cannot create the table tdo_tbl__log'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $sql='CREATE TABLE `tdo_tbl__pages` (
   `fld_id_pages` bigint(20) NOT NULL AUTO_INCREMENT,
   `fld_name_pages` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\' COMMENT \'{"showDeleteField":true}\',
   `fld_menu_pages` tinyint(4) NOT NULL DEFAULT \'0\' COMMENT \'{"param":"yorno"}\',
   `fld_isajax_pages` tinyint(4) NOT NULL DEFAULT \'0\' COMMENT \'{"param":"yorno"}\',
   `fld_isremote_pages` tinyint(4) NOT NULL DEFAULT \'1\' COMMENT \'{"param":"yorno"}\',
   `fld_isuser_pages` tinyint(4) NOT NULL DEFAULT \'1\' COMMENT \'{"param":"yorno"}\',
   `fld_localadmin_pages` tinyint(4) NOT NULL DEFAULT \'0\' COMMENT \'{"param":"yorno"}\',
   `fld_isaction_pages` tinyint(4) NOT NULL DEFAULT \'0\' COMMENT \'{"param":"yorno"}\',
   `fld_parent_pages` bigint(20) unsigned NOT NULL DEFAULT \'0\',
   `fld_tsupd_pages` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_tscrt_pages` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_cntupd_pages` bigint(20) NOT NULL DEFAULT \'0\',
   PRIMARY KEY (`fld_id_pages`),
   UNIQUE KEY `k_pages1` (`fld_name_pages`)
 ) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode('I cannot create the table tdo_tbl__pages'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $sql='CREATE TABLE `tdo_tbl__paramnames` (
   `fld_id_parnams` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
   `fld_key_parnams` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\' COMMENT \'{"showDeleteField":true}\',
   `fld_label_parnams` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\',
   `fld_comment_parnams` text COLLATE utf8mb4_unicode_ci,
   `fld_json_parnams` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `fld_order_parnams` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `fld_isuser_parnams` tinyint(4) NOT NULL DEFAULT \'0\' COMMENT \'{"param":"yorno"}\',
   `fld_tscrt_parnams` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_tsupd_parnams` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_cntupd_parnams` bigint(20) NOT NULL DEFAULT \'0\',
   PRIMARY KEY (`fld_id_parnams`),
   UNIQUE KEY `k_keyparnams` (`fld_key_parnams`)
 ) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode('I cannot create the table tdo_tbl__paramnames'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $sql='CREATE TABLE `tdo_tbl__paramrules` (
   `fld_id_parrules` bigint(20) NOT NULL AUTO_INCREMENT,
   `fld_name_parrules` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\' COMMENT \'{"showDeleteField":true}\',
   `fld_id_param_parrules` bigint(20) unsigned NOT NULL,
   `fld_tsupd_parrules` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_tscrt_parrules` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_cntupd_parrules` bigint(20) unsigned NOT NULL DEFAULT \'0\',
   PRIMARY KEY (`fld_id_parrules`),
   UNIQUE KEY `k_name_id_param` (`fld_name_parrules`,`fld_id_param_parrules`)
 ) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode('I cannot create the table tdo_tbl__paramrules'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $sql='CREATE TABLE `tdo_tbl__paramvalues` (
   `fld_id_parvals` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
   `fld_id_parname_parvals` bigint(20) NOT NULL DEFAULT \'0\',
   `fld_json_parvals` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `fld_tscrt_parvals` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_tsupd_parvals` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   PRIMARY KEY (`fld_id_parvals`)
 ) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode('I cannot create the table tdo_tbl__paramvalues'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $sql='CREATE TABLE `tdo_tbl__tablelinks` (
   `fld_id_pglnks` bigint(20) NOT NULL AUTO_INCREMENT,
   `fld_parent_table_id_pglnks` bigint(20) unsigned NOT NULL DEFAULT \'0\',
   `fld_parent_field_pglnks` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\',
   `fld_parent_field_display_pglnks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\',
   `fld_children_table_id_pglnks` bigint(20) unsigned NOT NULL DEFAULT \'0\',
   `fld_child_field_pglnks` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\',
   `fld_link_mandatory_pglnks` tinyint(4) NOT NULL DEFAULT \'1\' COMMENT \'{"param":"yorno"}\',
   `fld_tsupd_pglnks` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_tscrt_pglnks` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_cntupd_pglnks` int(11) NOT NULL DEFAULT \'0\',
   PRIMARY KEY (`fld_id_pglnks`)
 ) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode('I cannot create the table tdo_tbl__tablelinks'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $sql='CREATE TABLE `tdo_tbl__tables` (
   `fld_id_tables` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
   `fld_id_server_tables` int(11) NOT NULL DEFAULT \'0\',
   `fld_name_tables` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\' COMMENT \'{"showDeleteField":true}\',
   `fld_system_tables` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'0\' COMMENT \'{"param":"yorno"}\',
   `fld_tsupd_tables` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_tscrt_tables` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_cntupd_tables` int(11) NOT NULL DEFAULT \'0\',
   PRIMARY KEY (`fld_id_tables`)
 ) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode('I cannot create the table tdo_tbl__tables'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $sql='CREATE TABLE `tdo_tbl__users` (
   `fld_id_users` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
   `fld_login_users` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\' COMMENT \'{"showDeleteField":true}\',
   `fld_email_users` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\' COMMENT \'{"tests":{"email":true}}\',
   `fld_loginisemail_users` tinyint(4) NOT NULL DEFAULT \'0\' COMMENT \'{"param":"yorno"}\',
   `fld_password_users` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\',
   `fld_group_id_users` bigint(20) NOT NULL DEFAULT \'1\',
   `fld_active_users` tinyint(4) NOT NULL DEFAULT \'1\' COMMENT \'{"param":"yorno"}\',
   `fld_translate_users` tinyint(4) NOT NULL DEFAULT \'0\' COMMENT \'{"param":"yorno"}\',
   `fld_firstname_users` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\',
   `fld_lastname_users` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\',
   `fld_tsupd_users` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_tscrt_users` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_cntupd_users` bigint(20) NOT NULL DEFAULT \'0\',
   PRIMARY KEY (`fld_id_users`),
   UNIQUE KEY `key_fld_login_users` (`fld_login_users`) USING BTREE,
   KEY `fk_id` (`fld_group_id_users`)
 ) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode('I cannot create the table tdo_tbl__users'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $sql='CREATE TABLE `tdo_tbl__zztests` (
   `fld_id_zztests` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
   `fld_yorno1_zztests` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT \'{"param":"yorno","unsetPossible":true,"showDeleteField":true}\',
   `fld_visited_countries_zztests` set(\'FR\',\'US\',\'GB\',\'BE\',\'KO\',\'ES\',\'JP\',\'CA\') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT \'{"param":"country","set":true}\',
   `fld_country1_zztests` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'FR\' COMMENT \'{"param":"country","dropDown":"true","unsetPossible":true}\',
   `fld_title32_zztests` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\' COMMENT \'{"showDeleteField":true}\',
   `fld_id_parent_zztests` bigint(20) unsigned DEFAULT NULL,
   `fld_date1_zztests` date DEFAULT \'1000-01-01\',
   `fld_time1_zztests` time DEFAULT \'00:00:00\',
   `fld_dttim1_zztests` datetime DEFAULT \'1000-01-01 00:00:00\',
   `fld_color1_zztests` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT \'{"subtype":"webcolor"}\',
   `fld_email1_zztests` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT \'{"tests":{"email":true}}\',
   `fld_zipnum1_zztests` decimal(5,0) NOT NULL DEFAULT \'0\',
   `fld_tsupd_zztests` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_tscrt_zztests` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_cntupd_zztests` bigint(20) unsigned NOT NULL DEFAULT \'0\',
   PRIMARY KEY (`fld_id_zztests`),
   UNIQUE KEY `k_title32` (`fld_title32_zztests`)
 ) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode('I cannot create the table tdo_tbl__zztests'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $sql='CREATE TABLE `tdo_tbl_todos` (
   `fld_id_todos` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
   `fld_priority_todos` int(2) unsigned zerofill NOT NULL DEFAULT \'00\',
   `fld_id_user_todos` bigint(20) unsigned NOT NULL DEFAULT \'0\',
   `fld_title_todos` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'todo\' COMMENT \'{"showDeleteField":true}\',
   `fld_comment_todos` text COLLATE utf8mb4_unicode_ci,
   `fld_tsupd_todos` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_tscrt_todos` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_cntupd_todos` int(11) NOT NULL DEFAULT \'0\',
   PRIMARY KEY (`fld_id_todos`),
   KEY `k_user` (`fld_id_user_todos`)
 ) ENGINE=MyISAM AUTO_INCREMENT=150 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode('I cannot create the table tdo_tbl_todos'.mysqli_error($dbLink) ) );
  exit();
 }
}
if($err==0){

 $sql='CREATE TABLE `tdo_tbl_uploadeddocs` (
   `fld_id_uploadedDocs` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
   `fld_name_uploadedDocs` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\' COMMENT \'{"showDeleteField":true}\',
   `fld_originalName_uploadedDocs` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\',
   `fld_isPicture_uploadedDocs` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT \'{"param":"yorno","unsetPossible":false}\',
   `fld_pictureWidth_uploadedDocs` bigint(20) unsigned NOT NULL DEFAULT \'0\',
   `fld_pictureHeight_uploadedDocs` bigint(20) unsigned NOT NULL DEFAULT \'0\',
   `fld_documentType_uploadedDocs` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
   `fld_pictureWeight_uploadedDocs` bigint(20) unsigned NOT NULL DEFAULT \'0\',
   `fld_path_uploadedDocs` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\',
   `fld_tsupd_uploadedDocs` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_tscrt_uploadedDocs` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
   `fld_cntupd_uploadedDocs` bigint(20) unsigned NOT NULL DEFAULT \'0\',
   PRIMARY KEY (`fld_id_uploadedDocs`)
 ) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
 if(!($result=mysqli_query($dbLink,$sql))){
  $err=1;
  header('Location: '.BNF.'?errormessage='.urlencode('I cannot create the table tdo_tbl_uploadeddocs'.mysqli_error($dbLink) ) );
  exit();
 }
}
