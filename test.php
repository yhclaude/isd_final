<?php

	class PageData {
		public $id;
		public $fields;
		public $createdTime;
	}

	class Res {
		public $data;
		public $code;
		public $offset;
	}

	class Field {
		public $log_id;
		public $user_id;
		public $user_name;
		public $working_machine;
		public $start_time;
		public $end_time;
	}

	$pageData = new PageData();
	$res = new Res();
	$field = new Field();
	$data = array();
	$fieldData = array();

	$field -> log_id = 6;
	$field -> user_id = 1;
	$field -> user_name = "staffA";
	$field -> working_machine = "3d printer";
	$field -> start_time = "12\/5\/2018 17:21";
	$field -> end_time = "12\/5\/2018 18:21";

	$pageData -> id = "recGj9iDau1OtXjr4";
	$pageData -> fields = $field;
	$pageData -> createdTime = "2018-12-05T23:21:28.000Z";

	for ($x=0; $x<10; $x++) {
		$data[] = $pageData;	
	}
	
	$res -> data = $data;
	$res -> code = 200;
	$res -> offset = "itrtai8qEHKxUvSkE\/recGj9iDau1OtXjr4";
	$json =json_encode($res);

	if ($_GET['pageNumber'] > 0 && $_GET['pageNumber'] < 10) {
		echo $json;
	} else {
		$res1 = new Res();
		$res1 -> data = 111;
		$res1 -> code = 400;
		$res1 -> offset = "itrtai8qEHKxUvSkE\/recGj9iDau1OtXjr4";
		$json1 =json_encode($res1);
		echo $json1;
	}

	
?>