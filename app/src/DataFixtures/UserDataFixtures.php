<?php
/**
 * UserData fixtures.
 */

namespace App\DataFixtures;

use App\Entity\UserData;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class UserFixtures.
 */
class UserDataFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
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
            if($i < 3) {
                $userdata->setUser($this->getReference('users_'.$i));
            }
            else {
                $userdata->setUser($this->getReference('admins_'.($i-3)));
            }

            return $userdata;
        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array Array of dependencies
     */
    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}