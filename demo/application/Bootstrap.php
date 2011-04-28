<?php

namespace MajistiT\Application;

/**
 * @desc The application's bootstrap
 *
 * @author Majisti
 */
class Bootstrap extends \Majisti\Application\Bootstrap
{
    /*
     * (non-phpDoc) 
     * @see Inherited documentation.
     */
    protected function _bootstrap($resource = null)
    {
        parent::_bootstrap($resource);

        require_once 'vendor/phpquery/lib/phpQuery.php';
        \phpQuery::newDocumentXHTML();
    }

    /*
     * (non-phpDoc) 
     * @see Inherited documentation.
     */
    public function run()
    {
        /* short tags for view scripts */
        $this->getResource('view')->setUseStreamWrapper(true);

        $front = $this->getResource('FrontController');
        $front->registerPlugin(new \MajistiT\Plugin\Main());

        $acl = new \Zend_Acl();
        $acl->addRole('guest')
            ->addRole('member', 'guest');
        $acl->addResource('majisti-editing-content');
        $acl->allow('member', 'majisti-editing-content', 'edit');

        $auth = \Zend_Auth::getInstance();
        $role = $auth->hasIdentity()
            ? 'member'
            : 'guest';
        $provider = \MajistiX\Editing\View\Editor\Provider::getInstance();
        $provider->setRole($role);
        $provider->setAcl($acl);

        parent::run();
    }
}
