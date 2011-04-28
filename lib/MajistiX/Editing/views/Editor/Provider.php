<?php

namespace MajistiX\Editing\View\Editor;

use MajistiX\Editing\Model\Content;

class Provider
{
    static protected $_instance;

    protected $_view;

    protected $_role = 'guest';

    protected $_editor;

    protected $_acl;

    protected function __construct()
    {}

    /**
     *
     * @return Provider
     */
    static public function getInstance()
    {
        if( null === static::$_instance ) {
            static::$_instance = new self();
        }

        return static::$_instance;
    }

    public function getView()
    {
        return $this->_view;
    }

    /**
     *
     * @param \Zend_View $view
     * @return Provider
     */
    public function setView(\Zend_View $view)
    {
        $this->_view = $view;

        return $this;
    }

    public function setAcl(\Zend_Acl $acl)
    {
        $this->_acl = $acl;
    }

    public function getAcl()
    {
        if ( null === $this->_acl ) {
            $this->_acl = new \Zend_Acl();
        }

        return $this->_acl;
    }

    /**
     *
     * @param <type> $editor
     * @return Provider
     */
    public function setEditor($editor, $options = null)
    {
        if( !($editor instanceof IEditor) ) {
            $editor = __NAMESPACE__ . '\\' . (string) $editor . '\Renderer';
        }

        $editor = new $editor();

        $this->loadPublicFiles($editor, $options);

        $this->_editor = $editor;

        return $this;
    }

    protected function loadPublicFiles(IEditor $editor, $options = null)
    {
        $view = $this->getView();
        $view->publicFiles($editor->getPublicFiles($options));
    }

    /**
     *
     * @return IEditor The editor
     */
    public function getEditor()
    {
        return $this->_editor;
    }

    public function setRole($role)
    {
        $this->_role = $role;
    }

    public function getRole()
    {
        return $this->_role;
    }

    public function createEditorDisplay(Content $model, $options = array())
    {
        $editor = $this->getEditor();

        if( is_string($options) ) {
            $editor->preset($options);
        } else {
            $editor->setOptions($options);
        }

        return new Display($model, $editor, $this->getView(), $this->getAcl(),
            $this->getRole());
    }
}