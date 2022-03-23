(function ($, Drupal) {

  $(document).ready(function(){


    let cssRules = [];
    Object.keys(drupalSettings.pagedesigner_theme_settings.typography.definitions).forEach(function(id){
      let definition = drupalSettings.pagedesigner_theme_settings.typography.definitions[id];
      let cssRule = {
        selectors: ['#' + id],
        style: definition.style,
      };
      if ('color' in cssRule.style) {
        cssRule.style.color = 'var(' + cssRule.style.color.replace('$', '--') + ')';
      }
      cssRules.push(cssRule);

      if (definition.hasOwnProperty('breakpoints')) {
        Object.keys(definition.breakpoints).forEach(function(mediaText){
          cssRule = {
            selectors: ['#' + id],
            mediaText: mediaText,
            style: definition.breakpoints[mediaText],
          }
          if ('color' in cssRule.style) {
            cssRule.style.color = 'var(' + cssRule.style.color.replace('$', '--') + ')';
          }

          cssRules.push(cssRule);
        });
      }

      if (definition.hasOwnProperty('pseudo')) {
        Object.keys(definition.pseudo).forEach(function(pseudoSelector){
          let subDefinition = definition.pseudo[pseudoSelector];
          cssRule = {
            selectors: ['#' + id + pseudoSelector],
            style: subDefinition.style,
          }
          if ('color' in cssRule.style) {
            cssRule.style.color = 'var(' + cssRule.style.color.replace('$', '--') + ')';
          }
          cssRules.push(cssRule);
          if (subDefinition.hasOwnProperty('breakpoints')) {
            Object.keys(subDefinition.breakpoints).forEach(function(mediaText){
              cssRule = {
                selectors: ['#' + id + pseudoSelector],
                mediaText: mediaText,
                style: subDefinition.breakpoints[mediaText],
              }
              if ('color' in cssRule.style) {
                cssRule.style.color = 'var(' + cssRule.style.color.replace('$', '--') + ')';
              }
              cssRules.push(cssRule);
            });
          }
        });
      }
    });

    var editor = grapesjs.init({
      height: '600px',
      showOffsets: 1,
      noticeOnUnload: 0,
      multipleSelection: false,
      avoidInlineStyle: true,
      fromElement: true,
      container: '.pts-definition-group-typography_definition',
      style: cssRules,
      showToolbar: 0,
      domComponents: {
        wrapper: {
          components: [],
          badgable: false,
          copyable: false,
          droppable: false,
          highlightable: false,
          hoverable: false,
          selectable: false,
          editable: false,
          propagate: ['editable', 'dropable'],
        }
      },
      storageManager: {
        autoload: 0,
      },
      selectorManager: {
        states: [
          { name: 'hover', label: 'hover' },
          { name: 'active', label: 'active' },
          { name: 'focus', label: 'focus' },
          { name: ':before', label: '::before' },
          { name: ':after', label: '::after' },
        ],
      },
      deviceManager: {
        devices: [
          {
            name: 'Desktop',
            key: 'large',
            width: ''
          },
          {
            name: 'Tablet',
            width: '769px',
            key: 'medium',
            widthMedia: '992px'
          },
          {
            name: 'Mobile portrait',
            key: 'small',
            width: '320px',
            widthMedia: '767px'
          }
        ]
      },
      canvas: {
        styles: [
          '/modules/custom/pagedesigner_theme_settings/modules/pagedesigner_theme_settings_typography/resources/css/backend.css'
        ],
      },
      plugins: ['grapesjs-pd-base'],
      colorPicker: { appendTo: 'parent', offset: { top: 26, left: -166, }, },
    });

    window.editor = editor;

    $(editor.Canvas.getDocument().querySelectorAll("body")).on('click', 'a.pts-edit-typography', function (e) {
      window.location.href = $(this).attr('href');
    });

    Object.keys(drupalSettings.pagedesigner_theme_settings.color.definitions).forEach(function(key){
      let colorDefinition = drupalSettings.pagedesigner_theme_settings.color.definitions[key];
      editor.Canvas.getDocument().documentElement.style.setProperty(colorDefinition.scss_var.replace('$', '--'), colorDefinition.value);
    });


  })
})(jQuery, Drupal);
