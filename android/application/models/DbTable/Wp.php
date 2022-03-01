<?php

class Application_Model_DbTable_Wp extends Zend_Db_Table_Abstract
{

    protected $_name = 'wp_posts';
    
    public function getNavMenuItems() {
        
        $menu_items = array();
        
        $select = $this->select()
                ->from('wp_terms')
                ->join('wp_term_taxonomy', 'wp_terms.term_id = wp_term_taxonomy.term_taxonomy_id')
                ->join('wp_term_relationships', 'wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id')
                ->join('wp_posts', 'wp_term_relationships.object_id = wp_posts.ID')
				
                ->join('wp_postmeta', 'wp_postmeta.post_id = wp_posts.ID')
				
                ->where('wp_terms.name = ?', 'main')
		
				
               ->where('wp_postmeta.meta_key = ?', '_menu_item_menu_item_parent')
			  
                ->order('wp_posts.menu_order ASC');
        
        $select->setIntegrityCheck(FALSE);
		
		//echo $select;
                
        $stmt = $select->query();
        
        $menu = $stmt->fetchAll();
        
       /* if (count($menu) > 0) {
            
            foreach ($menu as $k => $v) {
                
                $select = $this->select()
                        ->from('wp_postmeta')
                        ->where('post_id = ?', $v['ID']);
                
                $select->setIntegrityCheck(FALSE);
                
                $postmeta = $select->query()->fetchAll();
                
                if (count($postmeta) > 0) {
                    
                    foreach ($postmeta as $pm) {
					
					if ($pm['meta_key'] == '_menu_item_menu_item_parent') {
                            $menu[$k]['parent'] = $pm['meta_value'];
                        }
                        
                        if ($pm['meta_key'] == '_menu_item_object_id') {
                            
                            $object_id = $pm['meta_value'];

                            $select = $this->select()
                                    ->from('wp_posts')
                                    ->where('ID = ?', $object_id);

                            $menu_items = $select->query()->fetchAll();

                            if (count($menu_items) > 0) {

                                foreach ($menu_items as $menu_item) {
                                    $menu[$k] = $menu_item;
                                }

                            }
                            
                        }
                        
                        if ($pm['meta_key'] == '_menu_item_url') {
                            $menu[$k]['_menu_item_url'] = $pm['meta_value'];
                        }
						
						
                    }
                    
                }
				
				
                        
                
            }
            
        }*/
        
        return $menu;
    }

}

