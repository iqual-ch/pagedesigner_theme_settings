<?php

namespace Drupal\pagedesigner_theme_settings;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides the color plugin manager.
 */
class StyleDefinitionPluginManager extends DefaultPluginManager {

  /**
   * Seetings for color plugin manager.
   *
   * @var array
   */
  protected $settings;

  /**
   * Constructor for ColorPluginManager objects.
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
      'Plugin/StyleDefinition',
      $namespaces,
      $module_handler,
      'Drupal\pagedesigner_theme_settings\StyleDefinitionPluginInterface',
      'Drupal\pagedesigner_theme_settings\Annotation\StyleDefinitionPlugin'
    );
    $this->alterInfo('pagedesigner_theme_settings_plugin_info');
    $this->setCacheBackend($cache_backend, 'pagedesigner_theme_settings_plugins');
  }

  /**
   * Load plugin definitons filtered by the gorup field.
   *
   * @param string $group
   *   The group to be filtered.
   *
   * @return array
   *   Array of plugin definitions.
   */
  public function getDefinitionsByGroup(string $group) {
    return array_filter($this->getDefinitions(), function ($element) use ($group) {
      return $element['group'] == $group;
    }, ARRAY_FILTER_USE_BOTH);
  }

}
