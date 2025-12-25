<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  Schemaorg.recipe
 *
 * @copyright   (C) 2023 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Plugin\Schemaorg\Videoobject\Extension;

use Joomla\CMS\Event\Plugin\System\Schemaorg\BeforeCompileHeadEvent;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Schemaorg\SchemaorgPluginTrait;
use Joomla\CMS\Schemaorg\SchemaorgPrepareDateTrait;
use Joomla\CMS\Schemaorg\SchemaorgPrepareDurationTrait;
use Joomla\Event\Priority;
use Joomla\Event\SubscriberInterface;
use Joomla\CMS\Language\Text;
//use Joomla\CMS\Factory;


// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Schemaorg Plugin
 *
 * @since  5.0.0
 */

 
final class Videoobject extends CMSPlugin implements SubscriberInterface
{

 use SchemaorgPluginTrait;
 use SchemaorgPrepareDateTrait;

    /**
     * Load the language file on instantiation.
     *
     * @var    boolean
     * @since  5.0.0
     */
    protected $autoloadLanguage = true;

    /**
     * The name of the schema form
     *
     * @var   string
     * @since 5.0.0
     */
    protected $pluginName = 'VideoObject';
    
      /**
     * Returns an array of events this subscriber will listen to.
     *
     * @return  array
     *
     * @since   5.0.0
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'onSchemaPrepareForm'       => 'onSchemaPrepareForm',
            'onSchemaBeforeCompileHead' => ['onSchemaBeforeCompileHead', Priority::BELOW_NORMAL],
        ];
    }
    
    public function onSchemaBeforeCompileHead(BeforeCompileHeadEvent $event): void
    {
        $schema = $event->getSchema();

        $graph = $schema->get('@graph');
        
        foreach ($graph as &$entry) {
            if (!isset($entry['@type']) || $entry['@type'] !== 'VideoObject')
            {
                continue;
            }

            if (!empty($entry['uploadDate'])) {
                $entry['uploadDate'] = $this->prepareDate($entry['uploadDate']);
            }
            
            //Factory::getApplication()->enqueueMessage("test".$entry['testvar']);
		// We are rendering the Q/A in the HTML document here
        }

    	$schema->set('@graph', $graph);
	}

}
