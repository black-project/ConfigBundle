<?php
/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ConfigBundle\Command;

use Black\Bundle\ConfigBundle\Model\ConfigManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InstallConfigCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('black:config:install')
            ->setDescription('Create needed object for your orm/odm');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager  = $this->getManager();
        $output->writeln('<comment>First step: Create general parameter</comment>');

        $result   = $this->createGeneral($manager, $input, $output);
        $output->writeln($result);

        $result   = $this->createMail($manager, $input, $output);
        $output->writeln($result);


        $manager->flush();

    }

    private function createGeneral(ConfigManagerInterface $manager, InputInterface $input, OutputInterface $output)
    {
        if ($manager->findPropertyByName('General')) {
            return '<error>The property general already exist!</error>';
        }

        $object = $manager->createInstance();
        $value  = array();

        $dialog = $this->getHelperSet()->get('dialog');

        $validator = function ($value) {
            if ('' === trim($value)) {
                throw new \Exception('The value can not be empty');
            }

            return $value;
        };

        $siteName = $dialog->askAndValidate(
            $output,
            'Name of your website? ',
            $validator
        );

        $value += array('site_name' => $siteName);

        $siteBaseline = $dialog->askAndValidate(
            $output,
            'Baseline of your website? ',
            $validator
        );

        $value += array('site_baseline' => $siteBaseline);

        $siteUrl = $dialog->askAndValidate(
            $output,
            'Url of your website? ',
            $validator
        );

        $value += array('site_url' => $siteUrl);

        $siteFooter = $dialog->askAndValidate(
            $output,
            'Footer of your website? ',
            $validator
        );

        $value += array('site_footer' => $siteFooter);

        $object
            ->setName('General')
            ->setValue($value)
            ->setProtected(true);

        $manager->persist($object);

        $output->writeln('<comment>Don\'t forget to add your logo!</comment>');

        return '<info>The property General was created!</info>';
    }

    private function createMail(ConfigManagerInterface $manager, InputInterface $input, OutputInterface $output)
    {
        if ($manager->findPropertyByName('Mail')) {
            return '<error>The property mail already exist!</error>';
        }

        $object = $manager->createInstance();
        $value  = array();

        $dialog = $this->getHelperSet()->get('dialog');

        $validator = function ($value) {
            if ('' === trim($value)) {
                throw new \Exception('The value can not be empty');
            }

            return $value;
        };

        $mailRoot = $dialog->askAndValidate(
            $output,
            'Your administror mail? ',
            $validator
        );

        $value += array('mail_root' => $mailRoot);

        $mailNoReply = $dialog->askAndValidate(
            $output,
            'Your no-reply mail? ',
            $validator
        );

        $value += array('mail_noreply' => $mailNoReply);

        $object
            ->setName('Mail')
            ->setValue($value)
            ->setProtected(true);

        $manager->persist($object);
        $output->writeln('<comment>Don\'t forget to complete your settings (subject and content for mails)!</comment>');

        return '<info>The property mail was created!</info>';
    }

    private function getManager()
    {
        return $this->getContainer()->get('black_config.manager.config');
    }
}
