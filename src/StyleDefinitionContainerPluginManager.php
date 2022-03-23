<?php

namespace Drupal\pagedesigner_theme_settings;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides style definition container plugin manager.
 */
class StyleDefinitionContainerPluginManager extends DefaultPluginManager {

  /**
   * Seetings for style definition plugin manager.
   *
   * @var array
   */
  protected $settings;

  /**
   * Constructor for StyleDefinitionContainerPluginManager objects.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct(
      'Plugin/StyleDefinitionContainer',
      $namespaces,
      $module_handler,
      'Drupal\pagedesigner_theme_settings\StyleDefinitionContainerPluginInterface',
      'Drupal\pagedesigner_theme_settings\Annotation\StyleDefinitionContainerPlugin'
    );
    $this->alterInfo('pagedesigner_theme_settings_style_definition_container_plugin_info');
    $this->setCacheBackend($cache_backend, 'pagedesigner_theme_settings_style_definition_container_plugins');
  }

}
