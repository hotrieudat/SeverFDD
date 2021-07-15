<?php
require_once 'Smarty/SmartyBC.class.php';
require_once 'Zend/View/Interface.php';
require_once 'Zend/View/Helper/Placeholder.php';

class Zend_View_Smarty implements Zend_View_Interface
{
    protected $_view;

    public function __construct($params = array())
    {
        $this->_view = new SmartyBC();
        $this->_view->default_modifiers = array('escape:"html"');
        $this->_view->php_handling = 0;
        foreach ($params as $key => $value) {
            $this->_view->$key = $value;
        }
    }

    public function setBasePath($path, $prefix = 'Zend_View')
    {
        $this->_view->template_dir = $path . '/templates/';
        $this->_view->compile_dir = $path . '/templates_c/';
        $this->_view->config_dir = $path . '/configs/';
        $this->_view->cache_dir = $path . '/cache/';
        $this->_view->addPluginsDir($path . '/plugins/');
    }

    public function addBasePath($path, $prefix = 'Zend_View')
    {
        return $this->setBasePath($path, $prefix);
    }

    public function getScriptPaths()
    {
        if (is_array($this->_view->template_dir)) {
            return $this->_view->template_dir;
        } else {
            return array($this->_view->template_dir);
        }
    }

    public function setScriptPath($path)
    {
        return $this->setBasePath($path);
    }

    public function addScriptPath($path)
    {
        return $this->setBasePath($path);
    }

    public function __get($key)
    {
        return $this->_view->get_template_vars($key);
    }

    public function __set($key, $value)
    {
        $this->_view->assign($key, $value);
    }

    public function __isset($key)
    {
        return ($this->_view->get_template_vars($key) != NULL);
    }

    public function __unset($key)
    {
        $this->_view->clear_assign($key);
    }

    public function assign($spec, $value = NULL)
    {
        if (is_array($spec)) {
            $this->_view->assign($spec);
        } else {
            $this->_view->assign($spec, $value);
        }
    }

    public function clearVars()
    {
        $this->_view->clear_all_assign();
    }

    public function render($name)
    {

        $holder = new Zend_View_Helper_Placeholder();
        $data = $holder->placeholder('Zend_Layout')->getArrayCopy();
        if (isset($data['content'])) {
            $this->_view->assign('content', $data['content']);
        }
        return $this->_view->fetch($name);
    }

    public function getEngine()
    {
        return $this->_view;
    }
}