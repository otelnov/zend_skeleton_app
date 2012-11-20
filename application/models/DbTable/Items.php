<?php

class Application_Model_DbTable_Items extends Zend_Db_Table_Abstract
{

    protected $_name = 'items';

	/*
	 * =========GET==============
	 */
    public function getItem($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if(!$row) {
            throw new Exception("Нет записи с id - $id");
        }
        return $row->toArray();
    }

	/*
	 * ==========ADD===============
	 */
	
    public function addItem($data)
    {
//        $data = array(
//            'director' => $director,
//            'title' => $title,
//        );
		
        $this->insert($data);
    }
    
	/*
	 * =======UPDATE===============
	 */
    public  function updateItem($id, $data)
    {
//        $data = array(
//            'director' => $director,
//            'title' => $title,
//        );

        $this->update($data, 'id = ' . (int)$id);
    }
    
	/*
	 * ==========DELETE===============
	 */
    public function deleteItem($id)
    {
        $this->delete('id = ' . (int)$id);
    }

}

