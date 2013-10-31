<?php
	$_SERVER['NO_CHECK'] = 1;
	require_once('../init/init.php');

	$sql ="SELECT access_name FROM ACCESS limit 1 ";
	$result = $codeAnt->db->getOne($sql);
	print_r($result);
	
	
	$sql = "insert into `LOGS` set `who`=?, `who_role_id`=?, `who_username`=?, `where`=?, `what`=?, `when`=now() ";
	
	$arr = Array(
		Array('黑野兽1','1','ronalfei1','北京1','写程序1'),
		Array('黑野兽2','2','ronalfei2','北京2','写程序2'),
		Array('黑野兽3','3','ronalfei3','北京3','写程序3'),
		Array('黑野兽4','4','ronalfei4','北京4','写程序4'),
		Array('黑野兽5','5','ronalfei5','北京5','写程序5'),
		Array('黑野兽6','6','ronalfei6','北京6','写程序6'),
		Array('黑野兽7','7','ronalfei7','北京7','写程序7'),
		Array('黑野兽8','8','ronalfei8','北京8','写程序8'),
		Array('黑野兽9','9','ronalfei9','北京9','写程序9'),
		Array('黑野兽10','10','ronalfei10','北京10','写程序10'),
		Array('黑野兽11','11','ronalfei11','北京11','写程序11'),
		Array('黑野兽12','12','ronalfei12','北京12','写程序12'),
		Array('黑野兽13','13','ronalfei13','北京13','写程序13'),
		Array('黑野兽14','14','ronalfei14','北京14','写程序14'),
		Array('黑野兽15','15','ronalfei15','北京15','写程序15'),
		Array('黑野兽16','16','ronalfei16','北京16','写程序16'),
		Array('黑野兽17','17','ronalfei17','北京17','写程序17'),
		Array('黑野兽18','18','ronalfei18','北京18','写程序18'),
		Array('黑野兽19','19','ronalfei19','北京19','写程序19'),
		Array('黑野兽20','20','ronalfei20','北京20','写程序20'),
		Array('黑野兽21','21','ronalfei21','北京21','写程序21'),
		Array('黑野兽22','22','ronalfei22','北京22','写程序22'),
		Array('黑野兽23','23','ronalfei23','北京23','写程序23'),
		Array('黑野兽24','24','ronalfei24','北京24','写程序24'),
	);
	
	
	$codeAnt->db->preparExec($sql,'sisss',$arr);
	
	$codeAnt->debug->displayProfile();
?>
