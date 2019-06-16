<?php
	$bookmarks = TestMm2::get_user_bookmarks()[0];
 ?>
<h1><?= $args['plugin_name'] ?></h1>
<div id="Bookmarks">
	<h2>Your posts bookmarks</h2>
	<?php foreach ($bookmarks as $key => $id) : 
		$post = get_post( $id );
		$empty_image = '<img width="100" height="100" src="' . plugin_dir_url(__FILE__) . '../adds/img/image-placeholder.png'  . '" class="attachment-100x100 size-100x100 image-placeholder" alt="">';
		$image = empty(get_the_post_thumbnail( $id, 'thumbnail')) ? $empty_image : get_the_post_thumbnail( $id, array(100, 100));
		if(empty(get_post_field('post_content', $id))){
			$content = 'No content';
		} else if(strlen(get_post_field('post_content', $id)) >= 100){
			$content = substr(get_post_field('post_content', $id), 0, 100) . '...';
		} else {
			$content = get_post_field('post_content', $id);
		}
 		if(strlen(get_the_title( $post )) >= 30){
			$title = substr(get_the_title( $post ), 0, 30) . '...';
		} else {
			$title = get_the_title( $post );
		}
		?>
		<div class="bookmark-block" >
			<a href="<?= get_permalink( $post ) ?>"">
				<?= $image ?>
				<h3 class="post-title"><?= $title ?></h3>
				<div class="post-description"><?= $content ?></div>
			</a>
			<i class="fa fa-times remove-bookmark" aria-hidden="true"></i>
		</div>
	<?php endforeach; ?>
	<p class="error"></p>
</form>