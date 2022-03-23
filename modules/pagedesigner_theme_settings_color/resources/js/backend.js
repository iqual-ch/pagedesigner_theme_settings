(function ($, Drupal) {
  $('[data-background-color]').each(function(){
    $(this).css('background-color', $(this).data('background-color'));
  });

  $(document).ready(function(){
    Object.keys(drupalSettings.pagedesigner_theme_settings.color.definitions).forEach(function(key){
      let colorDefinition = drupalSettings.pagedesigner_theme_settings.color.definitions[key];
      document.documentElement.style.setProperty(colorDefinition.scss_var.replace('$', '--'), colorDefinition.value);
    });
  });

})(jQuery, Drupal);
