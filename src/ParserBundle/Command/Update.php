<?php

namespace ParserBundle\Command;

use Exception;
use ParserBundle\Internal\Service\ServiceInterface;
use ParserBundle\Internal\Transformer\Request\TransformerInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Update extends Command
{
    use LoggerAwareTrait;

    /**
     * @var ServiceInterface
     */
    private $service;

    /**
     * @var TransformerInterface
     */
    private $transformer;

    /**
     * @param ServiceInterface $service
     * @param TransformerInterface $transformer
     * @param LoggerInterface $logger
     */
    public function __construct(
        ServiceInterface $service,
        TransformerInterface $transformer,
        LoggerInterface $logger
    ) {
        parent::__construct();

        $this->setLogger($logger);
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('parser:update')
            ->setDescription('Updating')
            ->addArgument('key', InputArgument::REQUIRED, 'Which parser needs to be updated?')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->logger->info('Transforming input to internalRequest');
            $request = $this->transformer->transform($input->getArgument('key'));

            $this->service->behave($request);
        } catch (Exception $e) {
            $this->logger->error(
                'An error occurred while parsing',
                [
                    'exception' => $e,
                ]
            );

            return 1;
        }

        $this->logger->info('Update completed');
        $output->writeln([
            '================',
            'Update completed!',
            '================',
            '',
        ]);

        return 0;
    }
}
