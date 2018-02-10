<?php
namespace CamHobbs\Kudos\Page;

use CamHobbs\Kudos\Core\Core;
use CamHobbs\Kudos\Interfaces\DBEntity;

abstract class Page
{
    private $title;
    private $layout;
    private $store;

    protected static $VIEWS_DIR;
    protected static $LAYOUT_DIR;

    protected function __construct(array $coreConfig, $title = null, $layout = null)
    {
      $this->coreConfig = $coreConfig;

      if($title === null) {
        $title = \substr(\get_class($this), -4);
      }
      $this->title = $title;
      $this->layout = ($layout === null) ? "layout" : $layout;

      self::$VIEWS_DIR = $this->getPageDir("views_dir");
      self::$LAYOUT_DIR = $this->getPageDir("layout_dir");
    }

    function getCoreConfig()
    {
      return $this->coreConfig;
    }

    protected function setStore(DBEntity $entity)
    {
      $this->store = $entity;
    }

    protected function getStore()
    {
      return $this->store;
    }

    private function getPageDir($key)
    {
        if (\array_key_exists($key, $this->coreConfig)) {
            return $this->coreConfig[$key];
        }
        return \get_include_path() . "/" . \explode("_", $key)[0] . "/";
    }

    protected static function getDefaultViewsDir()
    {
        return self::$VIEWS_DIR;
    }

    protected static function getDefaultLayoutDir()
    {
        return self::$LAYOUT_DIR;
    }

    protected function display()
    {
        \ob_start();
        include static::$VIEWS_DIR . \strtolower($this->title) . '.php';

        $contents = \ob_get_clean();

        include static::$LAYOUT_DIR . \strtolower($this->layout) . '.php';
    }

    abstract function view();
}
