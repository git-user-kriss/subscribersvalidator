<?php
/**
 * @category    Scandiweb
 * @package     Scandiweb\SubscribersValidator
 * @author      Krists Miculis <info@scandiweb.com>
 * @copyright   Copyright (c) 2022 Scandiweb, Inc (https://scandiweb.com)
 * @license     http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */

namespace Scandiweb\SubscribersValidator\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Scandiweb\SubscribersValidator\Helper\NewsletterSubscribers;
use Scandiweb\SubscribersValidator\Logger\SuspiciousEmailsLogger;
use SMTPValidateEmail\Validator as SmtpEmailValidator;

/**
 * Class SubscribersValidation
 * @package Scandiweb\SubscribersValidator\Console
 */
class SubscribersValidation extends Command
{
    const CLI_COMMAND_NAME = 'subscribers:validation';
    const CLI_COMMAND_DESCRIPTION = 'Checks if all subscribers has the correct e-mail';

    /**
     * @var NewsletterSubscribers
     */
    protected NewsletterSubscribers $newsletterSubscribers;

    /**
     * @var SuspiciousEmailsLogger
     */
    protected SuspiciousEmailsLogger $suspiciousEmailsLogger;

    /**
     * SubscribersValidation constructor.
     * @param NewsletterSubscribers $newsletterSubscribers
     * @param SuspiciousEmailsLogger $suspiciousEmailsLogger
     * @param string|null $name
     */
    public function __construct(
        NewsletterSubscribers $newsletterSubscribers,
        SuspiciousEmailsLogger $suspiciousEmailsLogger,
        string $name = null
    ) {
        parent::__construct($name);

        $this->newsletterSubscribers = $newsletterSubscribers;
        $this->suspiciousEmailsLogger = $suspiciousEmailsLogger;
    }

    /**
     * Configuration
     */
    protected function configure()
    {
        $this->setName(self::CLI_COMMAND_NAME);
        $this->setDescription(self::CLI_COMMAND_DESCRIPTION);

        parent::configure();
    }

    /**
     * Function get all newsletter subscribers e-mail address
     * Then validate e-mail addresses
     * And write validation failed e-mails to the log file
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $emails = [];
        $suspiciousEmails = [];
        $outputMessage = 'Completed no suspicious emails detected';

        try {
            $allSubscribers = $this->newsletterSubscribers->getAllNewsletterSubscribersData();

            foreach ($allSubscribers as $subscriber) {
                $emails[] = $subscriber->getSubscriberEmail();
            }

            $sender = 'krists.miculis+email-validation@scandiweb.com';
            $validator = new SmtpEmailValidator($emails, $sender);
            $validationResults = $validator->validate();

            foreach ($validationResults as $email => $status) {
                if (is_bool($status) && !$status) {
                    $suspiciousEmails[] = $email;
                }
            }

            if ($suspiciousEmails) {
                $this->suspiciousEmailsLogger->info('Suspicious emails list', $suspiciousEmails);
                $outputMessage = 'Completed suspicious emails write in suspicious-emails.log file';
            }

            $output->writeln($outputMessage);
        } catch (\Exception $e) {
            $output->writeln('Execution failed');
            $output->writeln($e->getMessage());
        }
    }
}