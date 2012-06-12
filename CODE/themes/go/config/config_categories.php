<?php 
return array(
		Category::TYPE_STATICPAGE=>array(
			'form'=>'_form',
			'max_rank'=>3,
			'code'=>'staticPage',
			'class'=>'StaticPage',
			'label'=>'Danh mục các trang tĩnh'				
		),
		Category::TYPE_NEWS=>array(
			'form'=>'_form',
			'max_rank'=>3,
			'code'=>'news',
			'class'=>'News',
			'label'=>'Danh mục tin tức-sự kiện'	
		),
		Category::TYPE_PRODUCT=>array(
			'form'=>'_form',
			'max_rank'=>3,
			'code'=>'product',
			'class'=>'Product',
			'label'=>'Danh mục sản phẩm'	
		),
		Category::TYPE_MANUFACTURER=>array(
			'form'=>'_form',
			'max_rank'=>3,
			'code'=>'manufacturer',
			'class'=>'Manufacturer',
			'label'=>'Danh mục nhà sản xuất'	
		),
		Category::TYPE_ALBUM=>array(
			'form'=>'_form',
			'max_rank'=>3,
			'code'=>'album',
			'class'=>'Album',
			'label'=>'Danh mục album'
		),
		Category::TYPE_GALLERYVIDEO=>array(
			'form'=>'_form',
			'max_rank'=>3,
			'code'=>'galleryVideo',
			'class'=>'GalleryVideo',
			'label'=>'Danh mục video'
		),
		Category::TYPE_KEYWORD=>array(
			'form'=>'_form_keyword',
			'max_rank'=>3,
			'code'=>'keyword',
			'class'=>'Keyword',
			'label'=>'Danh mục keyword'
		),
		Category::TYPE_QA=>array(
			'form'=>'_form',
			'max_rank'=>3,
			'code'=>'qA',
			'class'=>'QA',
			'label'=>'Danh mục hỏi đáp'
		),
		Category::TYPE_SUPPORT=>array(
			'form'=>'_form',
			'max_rank'=>3,
			'code'=>'support',
			'class'=>'Support',
			'label'=>'Danh mục tư vấn viên'
		),
		Category::TYPE_RECRUITMENT=>array(
			'form'=>'_form',
			'max_rank'=>3,
			'code'=>'recruitment',
			'class'=>'Recruitment',
			'label'=>'Danh mục tuyển dụng'
		),
		Category::TYPE_APP=>array(
			'form'=>'_form',
			'max_rank'=>3,
			'code'=>'app',
			'class'=>'App',
			'label'=>'Danh mục bài viết về ứng dụng của sản phẩm'
		)
	);