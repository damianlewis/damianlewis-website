<?php

use System\Classes\PluginManager;

abstract class CommonPluginTestCase extends PluginTestCase
{
    protected $plugins;

    /**
     * Ensure that the plugin under test is refreshed.
     * The PluginTestCase->runPluginRefreshCommand() method doesn't always clear the plugin's database tables.
     */
    public function setUp()
    {
        parent::setUp();

        $pluginManager = PluginManager::instance();

        foreach ($this->plugins as $plugin) {
            $pluginManager->refreshPlugin($plugin);
        }

        $pluginManager->bootAll(true);
        $pluginManager->registerAll(true);
    }
}
