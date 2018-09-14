<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */

namespace Training\Seller\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Training\Seller\Cron\Logger as CronLogger;

/**
 * GetCommand
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2018 Smile
 */
class CronLoggerCommand extends Command
{
    /**
     * @var CronLogger
     */
    protected $cronLogger;

    /**
     * @param CronLogger  $cronLogger
     * @param string|null $name
     */
    public function __construct(CronLogger $cronLogger, $name = null)
    {
        parent::__construct($name);

        $this->cronLogger = $cronLogger;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('training:seller:cron:logger')
            ->setDescription('Launch  the cron logger');

        parent::configure();
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings("PMD.UnusedFormalParameter")
     */

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Cron - Begin</info>');

        $this->cronLogger->execute();

        $output->writeln('<info>Cron - End</info>');

        return 0;
    }
}
