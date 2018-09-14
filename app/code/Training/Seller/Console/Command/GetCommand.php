<?php

namespace Training\Seller\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Training\Seller\Api\SellerRepositoryInterface;

class GetCommand extends Command
{
    /**
     * Id argument
     */
    const OPTION_ID = 'id';

    /**
     * @var SellerRepositoryInterface
     */
    protected $sellerRepository;

    /**
     * @param SellerRepositoryInterface $sellerRepository
     * @param string|null               $name
     */
    public function __construct(
        SellerRepositoryInterface $sellerRepository,
        $name = null
    ) {
        $this->sellerRepository = $sellerRepository;
        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('training:seller:get')
            ->setDescription('Display seller name')
            ->setDefinition([
                new InputOption(
                    self::OPTION_ID,
                    '-i',
                    InputOption::VALUE_REQUIRED,
                    'Seller id'
                ),

            ]);

        parent::configure();
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings("PMD.UnusedFormalParameter")
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sellerId = $input->getOption(self::OPTION_ID);

        if (is_null($sellerId)) {
            throw new \InvalidArgumentException('Argument ' . self::OPTION_ID . ' is missing.');
        }

        $seller = $this->sellerRepository->getById((integer) $sellerId);

        $output->writeln('<info>' .  $seller->getName() . '</info>');

        return 0;
    }
}