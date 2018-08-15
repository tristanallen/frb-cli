<?php

namespace Tlr\Frb\Tasks;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class AbstractTask
{
    /**
     * The command instance
     *
     * @var Symfony\Component\Console\Command\Command
     */
    protected $command;

    /**
     * The input interface
     *
     * @var InputInterface
     */
    protected $input;

    /**
     * The output interface
     *
     * @var Symfony\Component\Console\Output\OutputInterface
     */
    protected $output;

    /**
     * The "section" name for the task.
     *
     * Should be overridden
     *
     * @var string
     */
    protected $section;

    public function __construct(Command $command, InputInterface $input, OutputInterface $output)
    {
        $this->command = $command;
        $this->input   = $input;
        $this->output  = $output;
    }

    /**
     * Write some progress to stdout
     *
     * @param  string $message
     * @return Tlr\Frb\Tasks\AbstractTask
     */
    public function progress(string $message) : AbstractTask
    {
        $this->output->writeLn(
            $this->command->getHelper('formatter')
                ->formatSection($this->section, $message)
        );

        return $this;
    }


    /**
     * Log the full process output
     *
     * @param  Process $output
     * @return Tlr\Frb\Tasks\AbstractTask
     */
    public function log(Process $output) : AbstractTask
    {
        // @todo - send output to log
        $this->output->writeLn(
            $this->command->getHelper('formatter')
                ->formatSection(':::LOG:::', $output->getOutput())
        );

        return $this;
    }
}
