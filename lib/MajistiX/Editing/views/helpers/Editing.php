<?php

namespace MajistiX\Editing\View\Helper;

use Majisti\Application\Locales,
    MajistiX\Editing\Model\Content,
    MajistiX\Editing\View\Editor;

/**
 * @desc InPlaceEditing view helper. Renders the default in place content editor
 * setup in the configuration. Check documentation for more information on how
 * to configure an in place editor.
 *
 * @author Majisti
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Editing extends \Majisti\View\Helper\AbstractHelper
{
    /**
     * @desc Renders content based on storage key.
     *
     * @param string $key The storage key
     * @param array $options the options
     * @param string $initialContent The initial content
     */
    public function helper($key, $options = array(),
        $initialContent = null)
    {
        $provider = Editor\Provider::getInstance();

        /* @var $model Content */
        $model = $key instanceof Content
               ? $key
               : $this->getModel($key);

        if( null !== $initialContent && 0 === strlen($model->getContent()) ) {
            $model->setContent($initialContent);
        }

        $display = $provider->createEditorDisplay($model, $options);

        return $display->render();
    }

    /**
     * @return \MajistiX\Model\Editing\InPlace
     */
    protected function getModel($key)
    {
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = \Zend_Registry::get('Doctrine_EntityManager');

        $repo = $em->getRepository(
            'MajistiX\Editing\Model\Content');
        $model = $repo->findOrCreate($key,
            \Zend_Registry::get('Zend_Locale'));

        return $model;
    }
}