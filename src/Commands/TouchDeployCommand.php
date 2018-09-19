<?php

namespace Tlr\Frb\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tlr\Frb\Commands\AbstractEnvironmentCommand;
use Tlr\Frb\Config;
use Tlr\Frb\Tasks\Batch\CheckGitSetup;
use Tlr\Frb\Tasks\Batch\Deploy;
use Tlr\Frb\Tasks\Notification;

class TouchDeployCommand extends AbstractEnvironmentCommand
{
    /**
     * Command Title
     *
     * @var string
     */
    protected $title = 'Deploy (Touch)';

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('deploy:touch')
            ->setDescription('Deploy to the given environment')
            ->addEnvironmentArgument()
        ;
    }

    /**
     * Execute the command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return void
     */
    protected function handle(Config $config, InputInterface $input, OutputInterface $output)
    {
        $this->task(CheckGitSetup::class)->run($config);
        $this->task(Deploy::class)->touch($config);

        $this->task(Notification::class)->success($config, 'Code deployed!');
    }
}
