<?php
class TestMm2 {
	/*This method includes file with admin-page interface*/
	public function get_interface($plugin_name){
		$args['plugin_name'] = $plugin_name;
		include( plugin_dir_path( __FILE__ ) . 'views/interface.php');
	}
	/*This method creates users meta "bookmarks" if new value not exists and updates users meta if new value exists. If new value is unique, it will be added, if it's not unique, this value will be removed from array. Returns status => 1 if meta added of updated, of status => 0 if value was removed.*/
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
	/*This method returns array with users meta 'bookmarks'*/
	public static function get_user_bookmarks() {
		return get_user_meta( get_current_user_id(), 'bookmarks', false );
	}
	/*This method removes value from users meta 'bookmark' */
	public function remove_bookmark($post_id) {
		$bookmarks = TestMm2::get_user_bookmarks();
		unset($bookmarks[0][array_search($post_id, $bookmarks[0])]);
		update_user_meta( get_current_user_id(), 'bookmarks', $bookmarks[0]);
	}
	/*This method returns 'true' if value is already exists in users meta 'bookmarks', and returns 
	'false' if it doesn't.*/
	public static function is_bookmark($post_id) {
		$bookmarks = TestMm2::get_user_bookmarks();
		return in_array($post_id, $bookmarks[0]);
	}
}