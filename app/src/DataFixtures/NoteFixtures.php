<?php
/**
 * Note fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Note;
use App\Entity\Tags;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class NoteFixtures.
 */
class NoteFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(50, 'notes', function ($i) {
            $note = new Note();
            $note->setTitle($this->faker->sentence);
            $note->setComment($this->faker->paragraph(5));
            $note->setTags($this->getRandomReference('tags'));
            $note->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $note->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));

            return $note;
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
        return [TagsFixtures::class];
    }
}