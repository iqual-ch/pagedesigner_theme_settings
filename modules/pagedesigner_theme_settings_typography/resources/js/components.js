
(function ($, Drupal) {
  Drupal.behaviors.pts_init_base_components = {
    attach: function (context, settings) {
      $(document).on('pagedesigner-init-base-components', function (e, editor) {
        const defaultSettings = {
          defaults: {
            editable: false,
            draggable: false,
            droppable: false,
            badgable: false,
            stylable: false,
            highlightable: false,
            copyable: false,
            resizable: false,
            removable: false,
            hoverable: false,
            selectable: false,
          }
        };

        // lock components for editing etc.
        editor.DomComponents.getTypes().forEach(function (componentType) {
          editor.DomComponents.addType(componentType.id, {
            model: defaultSettings
          });
        });

        editor.DomComponents.addType('editable', {
          model: {
            defaults: {
              badgable: true,
              stylable: true,
              highlightable: true,
              hoverable: true,
              selectable: true,
            }
          }
        });

        // Add devices buttons
        const panelDevices = editor.Panels.addPanel({ id: 'devices-c' });
        panelDevices.get('buttons').add([{
          id: 'set-device-desktop',
          command: 'set-device-desktop',
          className: 'fas fa-desktop',
          active: 1,
          attributes: { title: Drupal.t('Desktop') }
        }, {
          id: 'set-device-tablet',
          command: 'set-device-tablet',
          className: 'fas fa-tablet-alt',
          attributes: { title: Drupal.t('Tablet') }
        }, {
          id: 'set-device-mobile',
          command: 'set-device-mobile',
          className: 'fas fa-mobile-alt',
          attributes: { title: Drupal.t('Mobile') }
        }]);

        editor.Commands.add('set-device-desktop', editor => {
          editor.setDevice('Desktop');
          $('[data-responsive-options]').find('label').removeClass('gjs-pn-active');
          $('[data-responsive-options]').find('label[data-device="' + editor.getDevice() + '"]').addClass('gjs-pn-active')
        });
        editor.Commands.add('set-device-tablet', editor => {
          editor.setDevice('Tablet');
          $('[data-responsive-options]').find('label').removeClass('gjs-pn-active');
          $('[data-responsive-options]').find('label[data-device="' + editor.getDevice() + '"]').addClass('gjs-pn-active')
        });
        editor.Commands.add('set-device-mobile', editor => {
          editor.setDevice('Mobile portrait');
          $('[data-responsive-options]').find('label').removeClass('gjs-pn-active');
          $('[data-responsive-options]').find('label[data-device="' + editor.getDevice() + '"]').addClass('gjs-pn-active')
        });

        editor.Panels.removePanel('options');
        // // editor.Panels.removePanel('views');

        // editor.on('component:selected', (component, sender) => {
        //   editor.runCommand('open-sm')
        // });

      });
    }
  }
})(jQuery, Drupal);
