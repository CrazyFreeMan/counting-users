<?php
/* ====================
[BEGIN_COT_EXT]
Name=Counting Users
Code=Counting Users
Description=Подсчет и отображение количества пользователей и проектов для Фриланс биржи
Version=0.2
Date=2014-jun-16
Author=CrazyFreeMan
Copyright=(c) CrazyFreeMan
Notes=BSD License
Auth_guests=R
Lock_guests=W12345A
Auth_members=R
Lock_members=W12345A
Requires_modules=users, projects
[END_COT_EXT]
  
[BEGIN_COT_EXT_CONFIG]
count_usr=01:radio:0,1:1
user_maingrp_count=02:string::4,7
count_prj=03:radio:0,1:1
projects_item_state=04:string::0
cache_db=05:radio:0,1:0
cache_db_ttl=06:string::3600
[END_COT_EXT_CONFIG]
 
==================== */
?>