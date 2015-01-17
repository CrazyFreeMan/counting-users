<?php
/**
 * Counting Users API
 *
 * @package Counting Users
 * @author CrazyFreeMan
 * @copyright Copyright (c) CrazyFreeMan 2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

	require_once cot_langfile('countingusers', 'plug');

	function get_count_of_user() {
			
		global  $cfg;

		if($cfg['plugin']['countingusers']['cache_db'] == 1){ //Если включен кеш запроса
			$result = check_cache(); //получить кеш
		} else {
			$result = get_data(); // получить данньіе если не включено кеширование
		}
		return $result; //возврат данньіх
	}

	//Проверка наличие кеша
	function check_cache() {
		global $cfg, $db, $cache;
	
			// получаем из кеша 
			$result = $cache->db->get('counter_user', 'countingusers');
			if (is_null($result))
			{
			    // кеш пуст, надо обновить			    
				$result = get_data(); //получить данньіе
				if(is_numeric($cfg['plugin']['countingusers']['cache_db_ttl']))
			    $cache->db->store('counter_user', $result, 'countingusers', $cfg['plugin']['countingusers']['cache_db_ttl']);	    
			}		
		return $result;
	}

	//получение данніх с БД
	function get_data(){

		global $cfg;
				//Если включен подсчет пользователей
			if ($cfg['plugin']['countingusers']['count_usr'] == 1)
			{
				$count_usr = str_replace(' ', '', $cfg['plugin']['countingusers']['user_maingrp_count']);
				$count_usr = explode(',', $count_usr);
				
					foreach ($count_usr as $key => $value) {
						if(is_numeric($value)){
							$result["USR"][$value] = get_usrs_count($value);
							}
						}
			}
				//Если включен подсчет проектов
			if ($cfg['plugin']['countingusers']['count_prj'] == 1)
			{

				$count_prj = str_replace(' ', '', $cfg['plugin']['countingusers']['projects_item_state']);

				if($cfg['plugin']['countingusers']['projects_item_state'] == '0'){
						$result["PRJ"][$cfg['plugin']['countingusers']['projects_item_state']] = get_prjs_count($cfg['plugin']['countingusers']['projects_item_state']);
					
				}else {
					$count_prj = explode(',', $count_prj);
					foreach ($count_prj as $key => $value) {
						if(is_numeric($value)){
						$result["PRJ"][$value] =get_prjs_count($value);
							}
						}
				}

			}

			return $result;
			/*		TODO когдато	
			$result["fr_users"] = $db->query("SELECT COUNT(*) FROM $db_users WHERE user_maingrp>=4")->fetchColumn();
			;*/

	}
	function get_usrs_count($grp_id){
		global $db, $db_users;
		return $db->query("SELECT COUNT(*) FROM $db_users WHERE user_maingrp=".$grp_id."")->fetchColumn();		 
	}

	function get_prjs_count($prjs_status_id){
		global $db, $db_projects;
		return $db->query("SELECT COUNT(*) FROM $db_projects WHERE item_state=".$prjs_status_id."")->fetchColumn();
	}