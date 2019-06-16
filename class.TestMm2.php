<?php
class TestMm2 {
	public function get_interface($plugin_name){
		$args['plugin_name'] = $plugin_name;
		include( plugin_dir_path( __FILE__ ) . 'views/interface.php');
	}

	public function add_bookmark($post_id) {
		if(empty($this::get_user_bookmarks())){
			update_user_meta( get_current_user_id(), 'bookmarks', [$post_id] );
			return array('status' => 1, 'added' => 'first');
		} else {
			$bookmarks = TestMm2::get_user_bookmarks();
			//$this->remove_bookmark($post_id);
			//return var_dump($bookmarks[0]);
			if(!in_array($post_id, $bookmarks[0])){
				$bookmarks[0][] = $post_id;
				update_user_meta( get_current_user_id(), 'bookmarks', $bookmarks[0] );
				//$this->remove_bookmark($post_id);
				return array('status' => 1, 'added' => 'second');
			} else {
				$this->remove_bookmark($post_id);
				return array('status' => 0, 'added' => 'deleted');
			}
			
			
		}
		//$this->remove_bookmark($post_id);
	}

	public static function get_user_bookmarks() {
		return get_user_meta( get_current_user_id(), 'bookmarks', false );
	}

	private function remove_bookmark($post_id) {
		//update_user_meta( get_current_user_id(), 'bookmarks', '' );
		$bookmarks = TestMm2::get_user_bookmarks();
		//array_search($post_id, $bookmarks[0]);
		unset($bookmarks[0][array_search($post_id, $bookmarks[0])]);
		update_user_meta( get_current_user_id(), 'bookmarks', $bookmarks[0]);
		//$bookmarks = get_user_meta( get_current_user_id(), 'bookmarks', false );
	}

	public static function is_bookmark($post_id) {
		$bookmarks = TestMm2::get_user_bookmarks();
		return in_array($post_id, $bookmarks[0]);
	}
	/* Основной метод генеррирования постов для блога */
	// public function fill_blog($args) {
	// 	$response;
	// 	if($this->is_file_correct($args[0])){
	// 		$posts = $this->structuring_table($args);
	// 		foreach ($posts as $post => $post_content) {
	// 			$post_data;
	// 			foreach ($post_content as $key => $value) {
	// 				foreach ($value as $k => $v) {
	// 					$post_data[$k] = $v;
	// 				}
	// 			}
	// 			$response[$post] = $this->create_post($post_data['post_name'], $post_data['post_content'], $post_data['post_categories'], $post_data['post_date']);				
	// 		}
	// 		if(in_array(false, $response)){
	// 			$response['code'] = 203;
	// 			$response['bad_posts'] = implode(", ", array_keys($response, false));
	// 		} else {
	// 			$response['code'] = 200;
	// 		};
	// 		return $response;
	// 	} else {
	// 		return ['code' => 204];
	// 	}
	// }
	// /* Данный метод проверяет наличие ключевых полей в таблице */
	// public function is_file_correct($arr) {
	// 	if(!in_array('post_name', $arr) || !in_array('post_content', $arr) || 
	// 		!in_array('post_categories', $arr) || !in_array('post_date', $arr)){
	// 		return false;
	// 	}else {
	// 		return true;
	// 	}
	// }
	// /* Данный метод создан для приведения соответствия данных постах согласно их заголовкам. */
	// public function structuring_table($arr){
	// 	$right_array = array();
	// 	$iterator = 0;
	// 	foreach ($arr as $post_key => $post) {
	// 		if ($post_key == 0){
	// 			continue ;
	// 		}
	// 		foreach ($post as $key => $value) {
	// 			$right_array[$iterator][$key] = [$arr[0][$key] => $value];
	// 		}
	// 		$iterator ++;
	// 	}	
	// 	return $right_array;	
	// }
	// /* Метод создающий отдельный пост */
	// private function create_post($post_name, $post_content, $post_categories, $post_date){
	// 	if(empty($post_name) || empty($post_content)){
	// 		return false;
	// 	}
	// 	$post_categories = $this->get_post_categories($post_categories);
	// 	$categories = count($post_categories) > 3 ? array_slice($post_categories, 0, 3) : $post_categories;
	// 	$post_data = array(
	// 		'post_title'    => wp_strip_all_tags( $post_name ),
	// 		'post_content'  => $post_content,
	// 		'post_status'   => 'publish',
	// 		'post_type'		=> 'post',
	// 		'post_author'   => 1,
	// 		'post_category' => empty($categories) ? 'default_category' : $categories,
	// 		'post_date'     => $this->check_post_date($post_date),
	// 	);
	// 	// Вставляем запись в базу данных
	// 	$post_id = wp_insert_post( $post_data ); 
	// 	return $post_id;
	// }
	// /* Метод, который возвращает список категорий, которые были объявленны в админке и указаны в файле */
	// private function get_post_categories($a_categories) {
	// 	$a_categories = explode(",", $a_categories);
	// 	$categories = array();
	// 	foreach ($a_categories as $key => $value) {
	// 		if(get_category_by_slug($value)){
	// 			array_push($categories, get_category_by_slug($value)->cat_ID);
	// 		}
	// 	}
	// 	return $categories;
	// }
	// /* Метод, который возвращает дату создания поста(сли оно было указано верно) или же укажет текущую дату*/
	// private function check_post_date($date) {
	// 	$d = explode('.', $date)[0];
	// 	$m = explode('.', $date)[1];
	// 	$y = explode('.', $date)[2];
	// 	if(wp_checkdate($m, $d, $y, $date)) {
	// 		return $y . "-" . $m . "-" . $d;
	// 	} else {
	// 		return date('Y-m-d');
	// 	}
	// }
}