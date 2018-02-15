<?php
declare(strict_types=1);
namespace CamHobbs\Kudos\Page;

use CamHobbs\Kudos\Core\App;
use CamHobbs\Kudos\Interfaces\DBEntity;

abstract class Page
{
    private $title;
    private $layout;
    private $coreConfig;

    private $store;

    protected static $VIEWS_DIR;
    protected static $LAYOUT_DIR;

    protected function __construct(App $app, string $title, ?string $layout)
    {
      $this->coreConfig = $app->getConfig();

      if($title === null) {
        $title = \substr(\get_class($this), -4);
      }
      $this->title = $title;
      $this->layout = ($layout === null) ? "layout" : $layout;

      self::$VIEWS_DIR = $this->getPageDir("views_dir");
      self::$LAYOUT_DIR = $this->getPageDir("layout_dir");
    }

    function getCoreConfig(): array
    {
      return $this->coreConfig;
    }

    protected function setStore(DBEntity $entity): void
    {
      $this->store = $entity;
    }

    protected function getStore(): DBEntity
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

    protected function display(): void
    {
        \ob_start();
        include static::$VIEWS_DIR . \strtolower($this->title) . '.php';

        $contents = \htmlentities(\ob_get_clean());
        
        include static::$LAYOUT_DIR . \strtolower($this->layout) . '.php';
    }

    abstract function view(): void;
}
