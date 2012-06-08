<?php

class ProductController extends Controller {
	/**
	 * Displays all product
	 */
	public function actionIndex() {
			$criteria = new CDbCriteria ();
			$criteria->compare ( 'status', Product::STATUS_ACTIVE );
			$criteria->order = 'id desc';
			$list_product = new CActiveDataProvider ( 'Product', array ('pagination' => array ('pageSize' => Setting::s ( 'PRODUCT_PAGE_SIZE','Product' ) ), 'criteria' => $criteria ) );
			$this->render ( 'list-product', array ('list_product' => $list_product ) );
	}
	/**
	 * Displays a category product
	 */
	public function actionList($cat_alias) {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'alias', $cat_alias );
		$criteria->compare('type',Category::TYPE_PRODUCT);
		$cat = Category::model ()->find( $criteria );
		if (isset ( $cat )) {
			$child_categories = $cat->child_nodes;
			$list_child_id = array ();
			//Set itself
			$list_child_id [] = $cat->id;
			foreach ( $child_categories as $id => $child_cat ) {
				$list_child_id [] = $id;
			}
			$criteria = new CDbCriteria ();
			$criteria->addInCondition ( 'catid', $list_child_id );
			$criteria->compare ( 'status', Product::STATUS_ACTIVE );
			$criteria->order = 'id desc';
			$list_product = new CActiveDataProvider ( 'Product', array ('pagination' => array ('pageSize' => Setting::s ( 'PRODUCT_PAGE_SIZE','Product' ) ), 'criteria' => $criteria ) );
			$this->render ( 'list-product', array ('cat' => $cat, 'list_product' => $list_product ) );
		}
	}
	/**
	 * Displays product
	 */
	public function actionView($cat_alias, $product_alias) {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'alias', $cat_alias );
		$criteria->compare('type',Category::TYPE_PRODUCT);
		$cat = Category::model ()->find( $criteria );
		if (isset ( $cat )) {
		$criteria = new CDbCriteria ();
		if (isset ( $cat ))
			$criteria->compare ( 'catid', $cat->id );
		$criteria->compare ( 'alias', $product_alias );
		$product = Product::model ()->find ( $criteria );
		if (isset ( $product )) {
			$product->visits=$product->visits+1;
			$product->save();
			$this->render ( 'product', array ('cat' => $cat, 'product' => $product ) );
		}
		}
	}
}
