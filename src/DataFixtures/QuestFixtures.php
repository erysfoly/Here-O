<?php

namespace App\DataFixtures;

use App\Entity\Quest;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuestFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $quest = new Quest();
            $quest->setTitle("Quête $i");
            $quest->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean at viverra libero. Donec tincidunt turpis neque, ut volutpat urna varius at. Fusce quis arcu diam. Donec arcu risus, dictum at felis vel, dapibus vehicula arcu. Fusce aliquam ullamcorper nibh, non dapibus risus tempus nec. Aenean semper arcu vulputate feugiat convallis. Etiam aliquet rutrum nisl. Praesent porta convallis volutpat. Integer dolor erat, suscipit eu accumsan vitae, dictum ut est. Nulla euismod tempor leo, a imperdiet orci euismod a. In faucibus mi a dui porttitor dignissim. Integer massa erat, fermentum non tincidunt non, aliquet a massa. Nulla eu mauris cursus, ornare velit ut, tempor augue.");
            $quest->setAuthor("Auteur $i");

            $date = new \DateTime();
            $date->add(new \DateInterval("P".$i*$i."D"));
            $quest->setDate($date);


            $quest->setPlace("Lieu $i");
            $quest->setMaxPeopleNumber($i * $i);

            $manager->persist($quest);
        }

        $manager->flush();
    }
}
