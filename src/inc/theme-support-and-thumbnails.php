<?php
// необходимые поддержки темой
add_theme_support('title-tag');
add_theme_support('post-thumbnails');

// удаление ненужных миниатюр
add_filter('intermediate_image_sizes', function ($sizes) {
	// размеры которые нужно удалить
	return array_diff($sizes, [
		'medium',
		'medium_large',
		'large',
		'1536x1536',
		'2048x2048',
	]);
});

add_image_size('card_thumbnail', 300, 0, true);