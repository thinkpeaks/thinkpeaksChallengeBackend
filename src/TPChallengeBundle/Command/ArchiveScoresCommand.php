<?php
/**
 * Created by PhpStorm.
 * User: Dimitri
 * Date: 04/04/2019
 * Time: 15:13
 */

namespace App\TPChallengeBundle\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;


class ArchiveScoresCommand extends  ContainerAwareCommand
{


    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'tpchallenge:archive-score';

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Archive all scores.')
            ->setHelp('This command allows you to archive existing scores... no flag, no options just the command');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln('Whoa!');

        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->getEntityManager();

        $queryBuilder = $em->createQueryBuilder();


        $query=$queryBuilder
            ->update('TPChallengeBundle\Entity\Score', 's')
            ->set('s.isArchived', true)
            ->getQuery();
        ;

        $query->execute();

        $output->writeln('Al scores have been archived!');

    }
}
