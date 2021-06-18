<?php
/**
 * UserData fixtures.
 */

namespace App\DataFixtures;

use App\Entity\UserData;
use Doctrine\Persistence\ObjectManager;

/**
 * Class UserFixtures.
 */
class UserDataFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(6, 'userdata', function ($i) {
            $userdata = new UserData();
            $userdata->setFirstname($this->faker->firstName);
            $userdata->setLastname($this->faker->lastName);

            return $userdata;
        });


        $manager->flush();
    }
}