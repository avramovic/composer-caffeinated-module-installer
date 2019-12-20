<?php

namespace Avram\ComposerCaffeinateedModuleInstaller;

use Composer\Installers\BaseInstaller;

class InstallerHelper extends BaseInstaller
{

    function getLocations()
    {
        // it will be looking for a key of FALSE, which evaluates to 0, i.e. the first element
        // that element value being false signals the installer to use the default path
        return array(false);
    }

    protected function templatePath($path, array $vars = array())
    {
        if (strpos($path, '{') !== false) {
            extract($vars);
            preg_match_all('@\{\$([A-Za-z0-9_]*)\}@i', $path, $matches);
            if (!empty($matches[1])) {
                foreach ($matches[1] as $var) {

                    $underscored = str_replace(['-', '_'], ' ', $$var);
                    $ucwords     = ucwords($underscored);
                    $final       = str_replace(' ', '', $ucwords);

                    $path = str_replace('{$'.$var.'}', $final, $path);
                }
            }
        }

        return $path;
    }

}
