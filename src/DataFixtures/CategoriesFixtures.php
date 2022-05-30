<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{
    private $counter = 1;

    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
        $this->createCategory('Informatique', $manager);
        $this->createCategory('Ordinateurs portables', $manager);
        $this->createCategory('Ecrans', $manager);
        $this->createCategory('Souris', $manager);
        $this->createCategory('Mode', $manager);
        $this->createCategory('Homme', $manager);
        $this->createCategory('Femme', $manager);
        $this->createCategory('Enfant', $manager);
                
        $manager->flush();
    }

    public function createCategory(string $name, ObjectManager $manager)
    {
        $category = new Categories();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $manager->persist($category);

        $this->addReference('cat-'.$this->counter, $category);
        $this->counter++;

        return $category;
    }
}
