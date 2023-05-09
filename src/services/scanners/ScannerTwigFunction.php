<?php

namespace dmstr\lajax\translatemanager\services\scanners;

use lajax\translatemanager\services\scanners\ScannerPhpFunction;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Console;
use yii\helpers\FileHelper;

/**
 * Class for processing twig files.
 *
 * Language elements detected in twig files:
 * "t" functions:
 *
 * ~~~
 * t('category of language element', 'language element');
 * t('category of language element', 'language element {replace}', ['replace' => 'String']);
 * t('category of language element', "language element");
 * t('category of language element', "language element {replace}", ['replace' => 'String']);
 * ~~~
 *
 * @author Hamzah Algabri <h.algabri@herzogkommunikation.de>
 *
 * @since 1.0
 */
class ScannerTwigFunction extends ScannerPhpFunction
{
    /**
     * Extension of Twig files.
     */
    const EXTENSION = '*.twig';

    /**
     * @var array Array to store path to project files.
     */
    protected static $files = ['*.twig' => []];

    /**
     * @var array Twig translate function.
     */
    public $twigTranslators = [' t'];

    /**
     * Start scanning Twig files.
     *
     * @param string $route
     * @param array $params
     * @inheritdoc
     */
    public function run($route, $params = [])
    {
        $this->scanner->stdout('Detect TwigFunction - BEGIN', Console::FG_CYAN);
        foreach (self::$files[static::EXTENSION] as $file) {
            if ($this->containsTranslator($this->twigTranslators, $file)) {
                $this->extractMessages($file, [
                    'translator' => $this->twigTranslators,
                    'begin' => '(',
                    'end' => ')',
                ]);
            }
        }

        $this->scanner->stdout('Detect TwigFunction - END', Console::FG_CYAN);
    }

    /**
     * Using static instead of self.
     */
    protected function initFiles()
    {
        if (!empty(static::$files[static::EXTENSION]) || !in_array(static::EXTENSION, $this->module->patterns)) {
            return;
        }
        static::$files[static::EXTENSION] = [];

        foreach ($this->_getRoots() as $root) {
            $root = realpath($root);
            Yii::trace('Scanning ' . static::EXTENSION . " files for language elements in: $root", 'translatemanager');

            $files = FileHelper::findFiles($root, [
                'except' => $this->module->ignoredItems,
                'only' => [static::EXTENSION],
            ]);

            static::$files[static::EXTENSION] = array_merge(static::$files[static::EXTENSION], $files);
        }

        static::$files[static::EXTENSION] = array_unique(static::$files[static::EXTENSION]);
    }

    /**
     * Override method because base-method is private.
     */
    private function _getRoots()
    {
        $directories = [];

        if (is_string($this->module->root)) {
            $root = Yii::getAlias($this->module->root);
            if ($this->module->scanRootParentDirectory) {
                $root = dirname($root);
            }

            $directories[] = $root;
        } elseif (is_array($this->module->root)) {
            foreach ($this->module->root as $root) {
                $directories[] = Yii::getAlias($root);
            }
        } else {
            throw new InvalidConfigException('Invalid `root` option value!');
        }

        return $directories;
    }
}

