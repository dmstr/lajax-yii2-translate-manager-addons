<?php
/**
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2020 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dmstr\lajax\translatemanager\widgets;


use lajax\translatemanager\widgets\ToggleTranslate;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

class ToggleTranslateLink extends ToggleTranslate
{
    public $frontendTranslationAsset = false;

    public $options = [];

    public function init()
    {
        parent::init();
        $this->options['id'] = 'toggle-translate';
        $this->options['data'] = [
            'language' => \Yii::$app->language,
            'url' => \Yii::$app->urlManager->createUrl(self::DIALOG_URL)
        ];

        $this->template = Html::a(FA::icon(FA::_LANGUAGE),
            'javascript:void(0);',
            $this->options
        ) . Html::tag('div', '', ['id' => 'translate-manager-div']);

        $this->view->registerCss(<<<CSS
span.language-item.translatable {
    outline:1px solid red;cursor:pointer;
}
CSS
);
    }

}