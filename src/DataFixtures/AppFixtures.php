<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\CategoryGroup;
use App\Entity\Comment;
use App\Entity\Discussion;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $admin = new User;
        $admin->setPseudo('Admin');
        $admin->setEmail('admin@admin.fr');
        $admin->setPassword('Admin*12');
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setAvatar('goku.jpg');

        $manager->persist($admin);

        for ($g = 0; $g < 2; $g++) {
            $groupe = new CategoryGroup;
            $groupe->setName($faker->words(3, true));

            $manager->persist($groupe);

            for ($c = 0; $c < rand(3, 5); $c++) {
                $category = new Category;
                $category->setName($faker->words(3, true));
                $category->setSlug($faker->slug(3));
                $category->setCategoryGroup($groupe);

                $manager->persist($category);

                for ($u = 0; $u < 2; $u++) {
                    $user = new User;
                    $user->setPseudo($faker->firstName);
                    $user->setEmail($faker->email);
                    $user->setPassword('Azerty+24');
                    $user->setAvatar('om.png');

                    $manager->persist($user);

                    for ($d = 0; $d < rand(1, 4); $d++) {
                        $discussion = new Discussion;
                        $discussion->setName($faker->words(3, true));
                        $discussion->setSlug($faker->slug(3));
                        $discussion->setUser($user);
                        $discussion->setCategory($category);
                        $discussion->setContent($faker->paragraph);

                        $manager->persist($discussion);

                        for ($com = 0; $com < rand(4, 8); $com++) {
                            $comment = new Comment;
                            $comment->setContent($faker->paragraph);
                            $comment->setDiscussion($discussion);
                            $comment->setUser($user);

                            $manager->persist($comment);
                        }
                    }
                }
            }
        }


        $manager->flush();
    }
}
