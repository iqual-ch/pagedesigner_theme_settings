<?php

namespace Drupal\pagedesigner_theme_settings\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the theme setting configuration entity.
 *
 * @ConfigEntityType(
 *   id = "theme_settings",
 *   label = @Translation("Theme Settings"),
 *   handlers = {
 *     "storage" = "Drupal\Core\Config\Entity\ConfigEntityStorage",
 *     "form" = {
 *       "default" = "Drupal\pagedesigner_theme_settings\Form\ThemeSettingsForm",
 *       "edit" = "Drupal\pagedesigner_theme_settings\Form\ThemeSettingsForm",
 *       "delete" = "Drupal\pagedesigner_theme_settings\Form\ThemeSettingsFormDelete"
 *     },
 *     "list_builder" = "Drupal\pagedesigner_theme_settings\ThemeSettingsListBuilder"
 *   },
 *   admin_permission = "administer pagedesigner theme settings",
 *   config_prefix = "theme_settings",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "target_file",
 *     "style_definitions_containers",
 *   },
 *   links = {
 *     "add-form" = "/admin/appearance/pagedesigner-theme-settings/add",
 *     "edit-form" = "/admin/appearance/pagedesigner-theme-settings/{theme_settings}/edit",
 *     "delete-form" = "/admin/appearance/pagedesigner-theme-settings/{theme_settings}/delete",
 *     "clone-form" = "/admin/appearance/pagedesigner-theme-settings/{theme_settings}/clone",
 *   }
 * )
 */
class ThemeSettings extends ConfigEntityBase {

  /**
   * Theme settings machine name.
   *
   * @var string
   */
  public $id;

  /**
   * Theme settings human readable name.
   *
   * @var string
   */
  public $label;

  /**
   * Path to store resulting scss file.
   *
   * @var string
   */
  public $target_file;

  /**
   * Theme settings style definitions containers.
   *
   * @var array
   */
  public $style_definitions_containers = [];

  /**
   * {@inheritdoc}
   */
  public function label() {
    if (!$label = $this->get('label')) {
      $label = $this->id();
    }
    return $label;
  }

  /**
   * Compile a SCSS file from all given definitions.
   */
  public function generateScssFile() {
    // Collect all definitions and write a file.
    $scss = "/////////////////////////////////////////////////////////////////////////////////////////////" . "\n";
    $scss .= '// Automatically created SCSS file. Creation date: ' . date("Y-m-d H:i:s") . "\n";
    $scss .= "/////////////////////////////////////////////////////////////////////////////////////////////" . "\n" . "\n";

    $manager = \Drupal::service('plugin.manager.pagedesigner_theme_settings.style_definition_container');
    $containers = $manager->getDefinitions();

    array_multisort(array_map(function ($element) {
      return $element['weight'];
    }, $containers), SORT_ASC, $containers);

    foreach ($containers as $container) {
      $containerPlugin = $manager->createInstance($container['id']);
      $scss .= $containerPlugin->getScss($this->style_definitions_containers[$container['id']]);
    }

    file_put_contents($this->target_file, $scss);
  }

  /**
   * Get a style definitions by its id.
   *
   * @param string $id
   *   Unique ID of the definition.
   * @param string $containerId
   *   Unique ID of the definition's container.
   *
   * @return array
   *   The style definition.
   */
  public function getDefinitionById(string $containerId, string $id) {
    return $this->searchByField($this->get('style_definitions_containers')[$containerId], 'id', $id);
  }

  /**
   * Search array recursivley by field name and value.
   *
   * @param array $array
   *   Array to be search.
   * @param string $field
   *   Field name.
   * @param string $value
   *   Field value.
   *
   * @return array|bool
   *   Array with the given field value or false.
   */
  private function searchByField(array $array, string $field, string $value) {
    $result = NULL;
    foreach ($array as $arrayKey => $arrayElement) {
      if (isset($arrayElement[$field]) && $arrayElement[$field] == $value) {
        $result = $arrayElement;
      }
      if ($result) {
        break;
      }
      if (is_array($arrayElement)) {
        $result = $this->searchByField($arrayElement, $field, $value);
      }
    }
    return $result;
  }

  /**
   * Set a style definitions by its id.
   *
   * @param string $id
   *   Unique ID of the definition.
   * @param array $value
   *   Array of values to be stored.
   *
   * @return bool
   *   Whether the operation was successful or not.
   */
  public function setDefinitionById(string $id, array $value) {
    $definitions = $this->get('style_definitions_containers');
    $this->replaceByField($definitions, 'id', $id, $value);
    $this->set('style_definitions_containers', $definitions);
    return $this->save();
  }

  /**
   * Search array recursivley by field name and value.
   *
   * @param array $array
   *   Array to be search.
   * @param string $field
   *   Field name.
   * @param string $value
   *   Field value.
   * @param array $newValue
   *   New field value to be stores.
   *
   * @return array|bool
   *   Array with the given field value or false.
   */
  private function replaceByField(array &$array, string $field, string $value, array $newValue) {
    $result = FALSE;
    foreach ($array as $arrayKey => $arrayElement) {
      if (isset($arrayElement[$field]) && $arrayElement[$field] == $value) {
        $array[$arrayKey] = $newValue + $array[$arrayKey];
        $result = TRUE;
      }
      if ($result) {
        break;
      }
      if (is_array($arrayElement)) {
        $result = $this->replaceByField($array[$arrayKey], $field, $value, $newValue);
      }
    }
    return $result;
  }

}
