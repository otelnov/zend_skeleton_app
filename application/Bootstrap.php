<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAcl()
    {
        $acl = new Zend_Acl();
        $acl->addResource('index');
        $acl->addResource('add', 'index');
        $acl->addResource('edit', 'index');
        $acl->addResource('delete', 'index');
        
		$acl->addResource('error');
        
		$acl->addResource('auth');
        $acl->addResource('login', 'auth');
        $acl->addResource('logout', 'auth');
		
        $acl->addRole('guest');
        $acl->addRole('user', 'guest');
        $acl->addRole('admin', 'user');
        
        $acl->allow('guest', 'index', array('index'));
        $acl->allow('guest', 'auth', array('index', 'login', 'logout'));
        
		$acl->allow('user', 'index', array('add', 'edit'));
        $acl->allow('user', 'error');
		
        $acl->allow('admin', 'index', array('add', 'edit', 'delete'));
        $acl->allow('admin', 'error');
        
        $fc = Zend_Controller_Front::getInstance();
        $fc->registerPlugin(new Application_Plugin_AccessCheck($acl, Zend_Auth::getInstance()));
    }

}

