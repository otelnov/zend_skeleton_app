<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->_helper->redirector('login');

    }

    public function loginAction()
    {
		if (Zend_Auth::getInstance()->hasIdentity()) {
			$this->_helper->redirector('index', 'index');
		}
		$form = new Application_Form_Login();
		$this->view->form = $form;
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
			if ($form->isValid($formData)) {
				$authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
				$authAdapter->setTableName('users')
							->setIdentityColumn('username')
							->setCredentialColumn('password');
				$username = $this->getRequest()->getPost('username');
				$password = $this->getRequest()->getPost('password');

				$authAdapter->setIdentity($username)
							->setCredential($password);

				$auth = Zend_Auth::getInstance();

				$result = $auth->authenticate($authAdapter);

				if ($result->isValid()) {
					//if($this->getRequest()->getPost('rememberme') == true){
    					Zend_Session::rememberMe(7776000);
    				//}
					$identity = $authAdapter->getResultRowObject();
					$authStorage = $auth->getStorage();
					$authStorage->write($identity);
					$this->_helper->redirector('index', 'index');
				} else {
					$this->view->errMessage = 'Вы ввели неверное имя пользователя или неверный пароль';
				}
			}
		}
    }

    public function logoutAction()
	{
		Zend_Auth::getInstance()->clearIdentity();
		Zend_Session::forgetMe();
    	Zend_Session::expireSessionCookie();
		$this->_helper->redirector('index', 'index');
	}


}





