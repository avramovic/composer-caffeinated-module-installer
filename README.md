# Composer Caffeinated Module Installer

The `composer-caffeinated-module-installer` is a plugin for [Composer](https://getcomposer.org/) that allows
caffeinated/modules module to be installed to a directory other than the default `vendor/` directory within
the repo on a package type basis. This plugin extends the [`composer/installers`](https://github.com/composer/installers)
plugin to allow any arbitrary package type to be handled by their custom installer and specified explicitly in the
`"installer-paths"` mapping in the `"extra"` data property.

`composer/installers` has a finite set of supported package types and we recognize the need for
any arbitrary package type to be installed to a specific directory other than `vendor/`. This plugin
allows additional package types to be handled by `composer/installers`, benefiting from their explicit install path
mapping and token replacement of package properties.

## How to Use
Add `avram/composer-caffeinated-module-installer` as a dependency of your project.
```sh
composer require avram/composer-caffeinated-module-installer
```
`composer/installers` is a dependency of this plugin and will be automatically required as well.

To support additional package types, add an array of these types in the `"extra"` property in your `composer.json`:
```
	"extra": {
		"installer-types": ["module"]
	}
```
Then, you can add mappings for packages of these types in the same way that you would add package types
that are supported by [`composer/installers`](https://github.com/composer/installers#custom-install-paths):
```
  "extra": {
    "installer-types": ["module"],
    "installer-paths": {
      "app/Modules/{$name}/": ["type:module"]
    }
  }
```
By default, packages that do not specify a `type` will be considered type `library`. Adding support for this type
allows any of these packages to be placed in a different install path. In other words, your modules should have type `module`.

If a type has been added to `"installer-types"`, the plugin will attempt to find an explicit installer path in the mapping.
If there is no match either by name or by type, the default installer path for all packages will be used instead. This package will call ucwords on name after replacing all underscores and dashes with space (and then remove the space), so for `your-awesome-package` the folder will be `your/install/path/YourAwesomePackage`, because caffeinated/modules like studly case :)

Please see the README for [`composer/installers`](https://github.com/composer/installers) to see the supported
syntax for package and type matching as well as the supported replacement tokens in the path (e.g. `{$name}`).
