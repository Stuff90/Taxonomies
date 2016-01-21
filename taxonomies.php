<?php
    /**
    * Plugin Name: Taxonomies
    * Plugin URI: http://ileotech.com/
    * Description: Taxonomies creation tool
    * Version: 1.0
    * Author: Simon BERNARD for Ileotech
    * Author URI: http://ileotech.com/
    * License: All rights reserved to Ileotech
    */


	/**
	* --------------------------------------------------------------------
	* Taxonomy
	* Allow to register taxonomies simply by setting data to an object
	* --------------------------------------------------------------------
	*/

	class Taxonomy
	{
        private $language = 'default';

        private $i18n = array(
            'default' => array(
                'search'  => 'Search',
                'all'     => 'All',
                'parent'  => 'Parent',
                'edit'    => 'Edit',
                'update'  => 'Update',
                'add-new' => 'Add new',
                'new'     => 'New',
                'name'    => 'Name'
            )
        );

        public function setI18n( $language , $key , $value = null ) {
            if( !array_key_exists($language , $this->i18n )) {
                $this->i18n[$language] = $this->i18n['default'];
            }

            if( gettype($key) === 'string' && !is_null($value)) {
                $this->i18n[$language][$key] = $value;
            }

            if ( gettype($key) === 'array') {
                $this->i18n[$language] = array_merge( $this->i18n[$language] , $key );
            }

            return $this;
        }

        public function setLanguage( $theLanguage ) {
            $this->language = $theLanguage;
        }

		public function setSlug( $slug )	 { $this->slug = $slug; return $this; }
		public function setTarget( $target ) { $this->target = $target; return $this; }

		public function isHierarchical( $hierarchy ) { $this->isHierarchical = $hierarchy; return $this; }

		public function setName( $name )						{ $this->name = $name; return $this; }
		public function setEditItem( $editItem )				{ $this->editItem = $editItem; return $this; }
		public function setMenuName( $menuName )				{ $this->menuName = $menuName; return $this; }
		public function setAllItems( $allItems )				{ $this->allItems = $allItems; return $this; }
		public function setSearchItem( $searchItem )			{ $this->searchItem = $searchItem; return $this; }
		public function setParentItem( $parentItem )			{ $this->parentItem = $parentItem; return $this; }
		public function setAddNewItem( $addNewItem )			{ $this->addNewItem = $addNewItem; return $this; }
		public function setUpdateItem( $updateItem )			{ $this->updateItem = $updateItem; return $this; }
		public function setNewItemName( $newItemName )			{ $this->newItemName = $newItemName; return $this; }
		public function setSingularName( $singularName )		{ $this->singularName = $singularName; return $this; }
		public function setParentItemColon( $parentItemColon )	{ $this->parentItemColon = $parentItemColon; return $this; }

		public function setRewriteSlug( $rewriteSlug )	 { $this->rewriteSlug = $rewriteSlug; return $this; }
		public function setRewriteFront( $rewriteFront ) { $this->rewriteFront = $rewriteFront; return $this; }


		public function register(){
			if( !$this->slug ){
				throw new Exception('"slug" must be set ! Please use setSlug( $value );');
				return;
			}
			if( !$this->target ){
				throw new Exception('"target" must be set ! Please use setTarget( $value );');
				return;
			}
			if( !$this->name ){
				throw new Exception('"name" must be set ! Please use setName( $value );');
				return;
			}
			if( !$this->singularName ){
				throw new Exception('"singularName" must be set ! Please use setSingularName( $value );');
				return;
			}
			if( !$this->isHierarchical ){
				throw new Exception('"isHierarchical" must be set ! Please use setIsHierarchical( $value );');
				return;
			}
			if( !$this->i18n[$this->language] ){
				throw new Exception('The laguage you defined has not been set');
				return;
			}


			$args = array(
                'hierarchical'  => $this->isHierarchical,
                'labels'        => array(
                    'name'              => _x( $this->name, 'taxonomy general name' ),
                    'singular_name'     => _x( $this->singularName , 'taxonomy singular name' ),
                    'search_items'      =>  __( isset($this->searchItem) ? $this->searchItem : $this->i18n[$this->language]['search'] . ' ' . $this->name ),
                    'all_items'         => __( isset($this->allItem) ? $this->allItem : $this->i18n[$this->language]['all'] .' ' . $this->name ),
                    'parent_item'       => __(  isset($this->parentItem) ? $this->parentItem : $this->i18n[$this->language]['parent'] . ' ' . $this->singularName),
                    'parent_item_colon' => __(  isset($this->parentItem) ? $this->parentItem : $this->i18n[$this->language]['parent'] . ' ' . $this->singularName ),
                    'edit_item'         => __(  isset($this->editItem) ? $this->editItem : $this->i18n[$this->language]['edit'] . ' ' . $this->singularName  ),
                    'update_item'       => __(  isset($this->updateItem) ? $this->updateItem : $this->i18n[$this->language]['update'] . ' ' . $this->singularName  ),
                    'add_new_item'      => __(  isset($this->addNewItem) ? $this->addNewItem : $this->i18n[$this->language]['add-new'] . ' ' . $this->singularName  ),
                    'new_item_name'     => __(  isset($this->newItemName) ? $this->newItemName : $this->i18n[$this->language]['new'] . ' ' . $this->singularName . ' ' . $this->i18n[$this->language]['name'] ),
                    'menu_name'         => __(  isset($this->menuName) ? $this->menuName : $this->name  ),
                ),
                'rewrite' => array(
                    'slug'          => isset($this->rewriteSlug) ? $this->rewriteSlug : $this->slug,
                    'with_front'    => isset($this->rewriteFront) ? $this->rewriteFront : false,
                    'hierarchical'  => $this->isHierarchical
                )
            );

			register_taxonomy($this->slug, $this->target , $args);
		}

	}

/*
	function registerCustomTaxonomies() {
		$filterTaxonomy = new Taxonomy();
		$filterTaxonomy
			->setSlug( 'taxo-code' )
			->setName( 'Taxonomy Name' )
			->setSingularName( 'Taxonomy Name Sing' )
			->setTarget(array( 'post' , 'page'))
			->isHierarchical( true )
			->register();
		}

	add_action( 'init', 'registerCustomTaxonomies', 0 );

*/

?>