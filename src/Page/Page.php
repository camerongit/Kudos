<?php
namespace CamHobbs\Kudos\Page;

abstract class Page extends \CamHobbs\Kudos\Core\CoreComponent
{
    private $title;
    private $layout;

    protected $data = array();

    protected static $VIEWS_DIR;
    protected static $LAYOUT_DIR;

    protected function __construct(\CamHobbs\Kudos\Core\Core $hook, $title = null, $layout = null)
    {
        parent::__construct($hook);

        if($title === null) {
          $title = \substr(\get_class($this), -4);
        }
        $this->title = $title;
        $this->layout = ($layout === null) ? "layout" : $layout;

        self::$VIEWS_DIR = $this->getPageDir("views_dir");
        self::$LAYOUT_DIR = $this->getPageDir("layout_dir");
    }

    function __set($name, $value)
    {
      if($name === "title" || $name === "layout") {
        throw new Exception("Title/layout must be set in the constructor.");
      }
    }

    private function getPageDir($key)
    {
        if (\array_key_exists($key, (array) $this->hook->config)) {
            return $this->hook->config[$key];
        }
        return "";
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
