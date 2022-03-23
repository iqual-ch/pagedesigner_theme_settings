# # Pagedesigner Theme Settings (work in progress - don't use it yet)

... because barrio settings are sooooo 2021!
 modular and expendable system that should replace the barrio settingsnd. The module's output is single - or a set of - SCSS files that can be included anywhere. Therefore' the settings are no longer bound to specific theme.

There are several submodules which all cover different stylings. Each modules provides Symfony plugins that take care of the UI, the storage and the compilation of the settings to a SCSS file.

## Submodules:

### color
Define and group as many colors as needed to properly represent the design.
ToDo:
- [ ] Move colors from group to another
- [ ] Provide color selector in PD

### typography
Define as many font styles as need to represent the design using grapesJS. Per font style, one can define the name of the SCSS mixin, as well as its CSS selectors.
Todo
- [ ] Save font style from grapesJS.
- [ ] Add fontyourface typo to PD
- [ ] grapesJS cleanup.
- [ ] Integrate font style in CKEditor.
- [ ] Allow compilation of CSS selectors into a separate file.

### components
Style & create different variations of each component

### gird
Grid settings
