<?php
return array (
					'role'=>array(
						'manager_operation' => array ('type' => Role::TYPE_OPERATION),
						'manager_task' => array ('type' => Role::TYPE_TASK),
						'manager_role' => array ('type' => Role::TYPE_ROLE),
					),
					'news' => array (
						'manager_category' => array ('type' => Category::TYPE_NEWS),
					),
					'staticPage' => array (
						'manager_category' => array ('type' => Category::TYPE_STATICPAGE),
					),
					'product' => array (
						'manager_category' => array ('type' => Category::TYPE_PRODUCT ),
						'manufacturer'=>array('type'=>Category::TYPE_MANUFACTURER)
					),	
					'album' => array (
						'manager_category' => array ('type' => Category::TYPE_ALBUM),
					),
					'qa' => array (
						'manager_category' => array ('type' => Category::TYPE_QA),
					),
					'support' => array (
						'manager_category' => array ('type' => Category::TYPE_SUPPORT),
					),
					'recruitment' => array (
						'manager_category' => array ('type' => Category::TYPE_RECRUITMENT),
					),
					'keyword' => array (
						'manager_category' => array ('type' => Category::TYPE_KEYWORD),
					),
					'galleryVideo' => array (
						'manager_category' => array ('type' => Category::TYPE_GALLERYVIDEO),
					),	
					'app' => array (
						'manager_category' => array ('type' => Category::TYPE_APP),
					),		
			);