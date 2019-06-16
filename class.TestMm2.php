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
			if(!in_array($post_id, $bookmarks[0])){
				$bookmarks[0][] = $post_id;
				update_user_meta( get_current_user_id(), 'bookmarks', $bookmarks[0] );
				return array('status' => 1, 'added' => 'second');
			} else {
				$this->remove_bookmark($post_id);
				return array('status' => 0, 'added' => 'deleted');
			}			
		}
	}

	public static function get_user_bookmarks() {
		return get_user_meta( get_current_user_id(), 'bookmarks', false );
	}

	public function remove_bookmark($post_id) {
		$bookmarks = TestMm2::get_user_bookmarks();
		unset($bookmarks[0][array_search($post_id, $bookmarks[0])]);
		update_user_meta( get_current_user_id(), 'bookmarks', $bookmarks[0]);
	}

	public static function is_bookmark($post_id) {
		$bookmarks = TestMm2::get_user_bookmarks();
		return in_array($post_id, $bookmarks[0]);
	}
}