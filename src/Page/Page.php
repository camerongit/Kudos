<?php
namespace CamHobbs\Kudos\Page;

abstract class Page extends \CamHobbs\Kudos\Core\CoreComponent
{
    private $title;
    private $layout;
    private $store;

    protected static $VIEWS_DIR;
    protected static $LAYOUT_DIR;

    protected function __construct(\CamHobbs\Kudos\Core\Core $hook, string $title = null, string $layout = null)
    {
        parent::__construct($hook);

        if($title === null) {
          $title = \substr(\get_class($this), -4);
        }
        $this->title = $title;
        $this->layout = ($layout === null) ? "layout" : $layout;

        self::$VIEWS_DIR = $this->getPageDir("views_dir", $hook->getConfig());
        self::$LAYOUT_DIR = $this->getPageDir("layout_dir", $hook->getConfig());
    }

    function __set($name, $value)
    {
      if($name === "title" || $name === "layout") {
        throw new Exception("Title/layout must be set in the constructor.");
      }
    }

    protected function setStore(\CamHobbs\Kudos\Interfaces\DBEntity $entity)
    {
      $this->store = $entity;
    }

    protected function getStore()
    {
      return $this->store;
    }

    private function getPageDir(string $key, array $config)
    {
        if (\array_key_exists($key, $config)) {
            return $config[$key];
        }
        return \get_include_path() . \explode($key, "_")[0] . "/";
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
