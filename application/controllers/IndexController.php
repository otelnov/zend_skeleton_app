<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $itemsModel = new Application_Model_DbTable_Items();
		$this->view->items = $itemsModel->fetchAll();

    }
	
	public function addAction()
	{
		$form = new Application_Form_Item();
		$form->submit->setLabel('Add');
		$this->view->form = $form;

		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
			if ($form->isValid($formData)) {
				$itemsModel = new Application_Model_DbTable_Items();
				$data = $form->getValues();
				$itemsModel->addItem($data);
				
				$this->_helper->redirector('index');
			} else {
				$form->populate($formData);
			}
		}
	}
	
	public function editAction()
	{
		$form = new Application_Form_Item();
		$form->submit->setLabel('Save');
		$this->view->form = $form;

		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
			if ($form->isValid($formData)) {
				$id = (int)$form->getValue('id');
				$data = $form->getValues();
				$itemsModel = new Application_Model_DbTable_Items();
				$itemsModel->updateItem($id, $data);
				$this->_helper->redirector('index');
			} else {
				$form->populate($formData);
			}
		} else {
			$id = $this->_getParam('id', 0);
			if ($id > 0) {
				$itemsModel = new Application_Model_DbTable_Items();
				$form->populate($itemsModel->getItem($id));
			}
		}
	}
	
	public function deleteAction()
	{
		if ($this->getRequest()->isPost()) {
			$del = $this->getRequest()->getPost('del');
			if ($del == 'Yes') {
				$id = $this->getRequest()->getPost('id');
				$itemsModel = new Application_Model_DbTable_Items();
				$itemsModel->deleteItem($id);
			}

			$this->_helper->redirector('index');
		} else {
			$id = $this->_getParam('id');
			$itemsModel = new Application_Model_DbTable_Items();
			$this->view->item = $itemsModel->getItem($id);
		}
	}


}

