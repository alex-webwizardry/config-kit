<?php
declare(strict_types=1);

namespace WebWizardry\Config\Composer;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Factory;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Plugin\PluginEvents;
use Composer\Script\ScriptEvents;
use Composer\Script\Event;
use Composer\Plugin\CommandEvent;
use WebWizardry\Config\Collector\ConfigCollector;

class EventHandler implements PluginInterface, EventSubscriberInterface
{
    private bool $runOnAutoloadDump = false;

    public static function getSubscribedEvents()
    {
        return [
            PluginEvents::COMMAND => 'onCommand',
            ScriptEvents::POST_AUTOLOAD_DUMP => 'onPostAutoloadDump',
            ScriptEvents::POST_INSTALL_CMD => 'onPostUpdateCommandDump',
            ScriptEvents::POST_UPDATE_CMD => 'onPostUpdateCommandDump',
        ];
    }

    public function activate(Composer $composer, IOInterface $io)
    {
        // TODO: Implement activate() method.
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
        // TODO: Implement deactivate() method.
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
        // TODO: Implement uninstall() method.
    }

    public function onCommand(CommandEvent $event): void
    {
        if ($event->getCommandName() === 'dump-autoload') {
            $this->runOnAutoloadDump = true;
        }
    }

    public function onPostUpdateCommandDump(Event $event): void
    {
        $this->processConfigs($event->getComposer());
    }

    /**
     * @throws Exception
     */
    public function onPostAutoloadDump(Event $event): void
    {
        if ($this->runOnAutoloadDump) {
            $this->processConfigs($event->getComposer());
        }
    }

    private function processConfigs(Composer $composer): void
    {
        (new ConfigCollector(realpath(dirname(Factory::getComposerFile())), $composer))->run();
    }
}