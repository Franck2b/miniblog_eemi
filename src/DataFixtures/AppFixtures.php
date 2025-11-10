<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private SluggerInterface $slugger
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@miniblog.com');
        $admin->setFirstName('Admin');
        $admin->setLastName('Administrator');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
        $manager->persist($admin);

        $users = [];
        $userNames = [
            ['John', 'Musk', 'john.musk@example.com'],
            ['Sarah', 'Bradley', 'sarah.bradley@example.com'],
            ['Damian', 'Type', 'damian.type@example.com'],
            ['Tesla', 'Motors', 'tesla.motors@example.com'],
            ['Wade', 'Morris', 'wade.morris@example.com'],
            ['Zev', 'Klein', 'zev.klein@example.com'],
        ];

        foreach ($userNames as [$firstName, $lastName, $email]) {
            $user = new User();
            $user->setEmail($email);
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password123'));
            $manager->persist($user);
            $users[] = $user;
        }

        $articlesData = [
            [
                'title' => 'Porsche the German Luxury Sports Cars',
                'content' => 'Porsche designed and produced the first Volkswagen Beetle and has won 24 hours of Le Mans 19 times. The company is renowned for its high-performance sports cars, SUVs, and sedans.

Porsche\'s history dates back to 1948 when the first car bearing the Porsche name, the 356, was built. Since then, the brand has become synonymous with performance, luxury, and engineering excellence.

The iconic 911 has been in production since 1963 and remains one of the most recognizable sports cars in the world. With its distinctive silhouette and rear-engine layout, the 911 has evolved through multiple generations while maintaining its core identity.

Today, Porsche continues to innovate with electric vehicles like the Taycan, while staying true to its sports car heritage with models like the 718 Cayman, Boxster, and of course, the legendary 911.',
                'category' => 'Luxury',
                'image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70',
            ],
            [
                'title' => 'Aircraft Engine Technology in Modern Cars',
                'content' => 'BMW began as an aircraft engine manufacturer and now produces high-performance engines that push the boundaries of automotive engineering.

The connection between aviation and automotive engineering runs deeper than most people realize. Many technologies we take for granted in modern cars have their origins in aircraft design.

Turbocharging, for instance, was first developed for aircraft engines to maintain power at high altitudes. Today, turbocharged engines are standard in performance cars, providing impressive power outputs from smaller, more efficient engines.

Materials science has also benefited from aerospace innovation. Carbon fiber, titanium, and advanced aluminum alloys originally developed for aircraft are now commonplace in high-performance vehicles, reducing weight while increasing strength and safety.',
                'category' => 'Presentation',
                'image' => 'https://images.unsplash.com/photo-1542362567-b07e54358753',
            ],
            [
                'title' => 'Affordable and Reliable: The Rise of Kia',
                'content' => 'Kia is a subsidiary of Hyundai Motor Company and has been responsible for commitment to affordability, reliability, and innovative design.

Over the past two decades, Kia has transformed from a budget brand to a respected manufacturer producing vehicles that compete with established luxury marques. This transformation didn\'t happen overnight but was the result of strategic investments in design, quality, and technology.

The hiring of Peter Schreyer as Chief Design Officer in 2006 marked a turning point for Kia. His influence is visible in every modern Kia vehicle, with the signature "tiger nose" grille becoming one of the most recognizable design elements in the automotive world.

Models like the Telluride, Stinger, and EV6 have won numerous awards and changed public perception of the brand. Kia\'s industry-leading warranty program demonstrates confidence in their vehicles\' reliability and has helped attract customers who might otherwise have chosen more established brands.',
                'category' => 'Affordable',
                'image' => 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738',
            ],
            [
                'title' => 'A Car Engine Converts Fuel into Motion',
                'content' => 'It operates on the four-stroke cycle: intake, compression, combustion, and exhaust. This fundamental process has powered automobiles for over a century.

The internal combustion engine is a marvel of engineering that has evolved continuously since its invention in the late 19th century. Understanding how it works helps appreciate the complexity and precision required in modern engine design.

During the intake stroke, the piston moves down and a mixture of air and fuel is drawn into the cylinder. The compression stroke then compresses this mixture, raising its temperature and pressure. At the top of the compression stroke, the spark plug ignites the mixture, causing a controlled explosion that drives the piston down in the power stroke. Finally, the exhaust stroke expels the spent gases.

Modern engines include sophisticated technologies like variable valve timing, direct fuel injection, and cylinder deactivation to maximize efficiency and minimize emissions while delivering impressive performance.',
                'category' => 'Engine',
                'image' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3',
            ],
            [
                'title' => 'The Iconic American Sports Car: Ford Mustang',
                'content' => 'Introduced in 1964, it became an instant American icon with over 22,000 cars sold on its first day. The Mustang created the "pony car" class of American muscle cars.

The Ford Mustang\'s debut at the 1964 World\'s Fair in New York was nothing short of spectacular. Designed to appeal to young buyers, the Mustang offered sporty styling and performance at an affordable price point, a combination that proved irresistible.

Over its nearly 60-year production run, the Mustang has evolved through multiple generations, each reflecting the design trends and performance expectations of its era. From the classic fastback silhouette of the 1960s to the modern retro-inspired design of current models, the Mustang has maintained its essential character while adapting to changing times.

The Mustang has appeared in countless movies and TV shows, cementing its status as a cultural icon. Whether it\'s Steve McQueen\'s green fastback in Bullitt or the customized Eleanor from Gone in 60 Seconds, the Mustang represents freedom, performance, and American automotive passion.',
                'category' => 'Sports',
                'image' => 'https://images.unsplash.com/photo-1584345604476-8ec5f5a441e7',
            ],
            [
                'title' => 'Modern Cars Use LED Lights for Safety',
                'content' => 'Car lights are crucial for safety and visibility. Headlights provide illumination, while taillights enhance visibility and communicate intentions to other drivers.

The evolution of automotive lighting has been dramatic. From the acetylene lamps of the early 1900s to today\'s adaptive LED matrix headlights, lighting technology has transformed both aesthetically and functionally.

LED technology has revolutionized automotive lighting. LEDs are more energy-efficient, last longer, and can be configured in innovative ways impossible with traditional bulbs. Modern premium vehicles feature adaptive headlights that can selectively dim individual LEDs to avoid dazzling oncoming traffic while maintaining maximum illumination elsewhere.

Beyond headlights, LED technology has enabled creative exterior design and improved communication between vehicles. Sequential turn signals, animated welcome sequences, and customizable interior ambient lighting are all made possible by LED technology.',
                'category' => 'Research',
                'image' => 'https://images.unsplash.com/photo-1617886322207-d81466783f22',
            ],
            [
                'title' => '15 Secrets About Taillights You Need to Know',
                'content' => 'They are used to make the vehicle visible to other drivers, in low-light conditions. Brake lights signal when the vehicle is slowing down, preventing rear-end collisions.

Taillights serve multiple critical safety functions. Red lights indicate the vehicle\'s presence and position, brake lights warn following traffic of deceleration, turn signals communicate directional intentions, and reverse lights illuminate the area behind the vehicle and warn others of rearward movement.

The legal requirements for taillights vary by jurisdiction but generally specify brightness, color, positioning, and functionality. Modern vehicles often exceed these minimum requirements with advanced lighting systems that improve visibility and safety.

Some interesting taillight facts: The center high-mounted stop light (CHMSL) became mandatory in North America in 1986 after studies showed it reduced rear-end collisions by 50%. LED taillights illuminate 200 milliseconds faster than incandescent bulbs, giving following drivers additional reaction time at highway speeds.',
                'category' => 'Assurance',
                'image' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d',
            ],
            [
                'title' => 'Crucial for Safety and Visibility: Car Lights',
                'content' => 'Modern cars commonly use LED lights due to their efficiency and durability. Additionally, cars use LED lights for their long lifespans and low energy consumption.

The transition from halogen to LED lighting in the automotive industry represents a significant technological advancement. While halogen bulbs served the industry well for decades, LEDs offer numerous advantages that make them the clear choice for modern vehicles.

Energy efficiency is a major benefit. LED headlights consume approximately 70% less energy than halogen bulbs, reducing the load on the vehicle\'s electrical system and improving fuel efficiency. This is particularly important for electric vehicles where every watt counts toward driving range.

Durability is another key advantage. Quality LED headlights can last 20,000 hours or more, potentially outlasting the vehicle itself. This eliminates the need for bulb replacements and reduces maintenance costs and environmental waste.

The design flexibility offered by LEDs has also influenced automotive styling. The compact size of LEDs allows designers to create sleeker, more aerodynamic front-end designs and distinctive lighting signatures that help establish brand identity.',
                'category' => 'Engine',
                'image' => 'https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2',
            ],
            [
                'title' => 'Meet the Coolest Classic and Vintage Cars',
                'content' => 'They have a classic or vintage look and are valued for their unique design and historical significance. Classic cars represent automotive history and craftsmanship.

The definition of a "classic car" varies, but generally refers to vehicles at least 20-25 years old that have historical interest. Vintage cars typically refer to vehicles manufactured between 1919 and 1930, while antique cars predate 1919.

Classic cars offer a tangible connection to automotive history. Each era of car design reflects the technology, aesthetics, and social values of its time. Driving a classic car is like taking a time machine back to when that vehicle was new.

The classic car market has evolved into a serious investment sector. Rare models from prestigious manufacturers can sell for millions at auction. The 1962 Ferrari 250 GTO, for example, holds the record for the most expensive car ever sold at auction, fetching $48.4 million in 2018.

Maintaining classic cars requires dedication, knowledge, and often specialized parts. The classic car community is passionate and supportive, with clubs, forums, and events bringing enthusiasts together to share their love of automotive history.',
                'category' => 'Classic',
                'image' => 'https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2',
            ],
            [
                'title' => 'Electric Revolution: The Future of Automotive',
                'content' => 'Electric vehicles are transforming the automotive industry. With zero emissions, instant torque, and lower operating costs, EVs represent the future of personal transportation.

The electric vehicle revolution is accelerating rapidly. Major manufacturers have announced plans to electrify their entire lineups within the next decade, signaling the end of the internal combustion engine\'s dominance.

Battery technology is the key enabler of this transformation. Modern lithium-ion batteries offer ranges exceeding 300 miles on a single charge, with some models approaching 500 miles. Charging infrastructure is expanding globally, with fast-charging stations capable of adding 200 miles of range in just 20 minutes.

Electric vehicles offer unique benefits beyond environmental considerations. The instant torque delivery of electric motors provides exhilarating acceleration that rivals or exceeds high-performance gasoline vehicles. Many EVs can accelerate from 0-60 mph in under 3 seconds.

The reduced complexity of electric powertrains means fewer parts that can fail, potentially reducing maintenance costs significantly. There are no oil changes, transmission services, or spark plug replacements required.',
                'category' => 'Experts',
                'image' => 'https://images.unsplash.com/photo-1560958089-b8a1929cea89',
            ],
            [
                'title' => 'Autonomous Driving: Cars That Drive Themselves',
                'content' => 'Self-driving technology is progressing rapidly. Using sensors, cameras, and artificial intelligence, autonomous vehicles promise to revolutionize transportation and improve road safety.

Autonomous driving technology has advanced dramatically in recent years. What once seemed like science fiction is becoming reality, with several companies testing fully autonomous vehicles on public roads.

The Society of Automotive Engineers defines six levels of driving automation, from Level 0 (no automation) to Level 5 (full automation in all conditions). Most commercially available systems today operate at Level 2, providing driver assistance but requiring constant human supervision.

The potential benefits of autonomous vehicles are enormous. Traffic accidents, 94% of which are caused by human error according to the NHTSA, could be dramatically reduced. Autonomous vehicles could provide mobility to those unable to drive, reduce traffic congestion through coordinated driving, and allow passengers to be productive during their commute.

However, significant challenges remain. Autonomous systems must be able to handle edge cases and unpredictable situations that human drivers navigate intuitively. Legal and ethical questions about liability in accidents involving autonomous vehicles must be resolved.',
                'category' => 'Research',
                'image' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2',
            ],
            [
                'title' => 'Supercar Performance: Engineering Excellence',
                'content' => 'Supercars represent the pinnacle of automotive performance and engineering. These extreme machines combine cutting-edge technology, exotic materials, and stunning design.

Supercars occupy a special place in automotive culture. They push the boundaries of what\'s possible, serving as rolling laboratories for technologies that eventually trickle down to mainstream vehicles.

Performance figures for modern supercars are staggering. Many can accelerate from 0-60 mph in under 3 seconds and reach top speeds exceeding 200 mph. The Bugatti Chiron Super Sport 300+ became the first production car to exceed 300 mph, reaching 304.773 mph in 2019.

Achieving these performance levels requires extensive use of lightweight materials like carbon fiber, advanced aerodynamics, and powerful engines or electric motors. Active aerodynamic elements adjust automatically to optimize downforce or reduce drag depending on speed and driving conditions.

The exclusivity and limited production of supercars make them highly collectible. Many sell out before production begins, and values often appreciate over time, making them alternative investments as well as automotive art.',
                'category' => 'Customer Success',
                'image' => 'https://images.unsplash.com/photo-1583121274602-3e2820c69888',
            ],
        ];

        $articles = [];
        foreach ($articlesData as $index => $data) {
            $article = new Article();
            $article->setTitle($data['title']);
            $article->setSlug(strtolower($this->slugger->slug($data['title'])));
            $article->setContent($data['content']);
            $article->setCategory($data['category']);
            $article->setImage($data['image']);
            $article->setAuthor($index === 0 ? $admin : $users[array_rand($users)]);
            
            $createdAt = new \DateTimeImmutable('-' . rand(1, 60) . ' days');
            $article->setCreatedAt($createdAt);
            
            $manager->persist($article);
            $articles[] = $article;
        }

        $commentTexts = [
            'Great article! Very informative and well written.',
            'I completely agree with your points. Thanks for sharing!',
            'This is exactly what I was looking for. Excellent explanation.',
            'Interesting perspective. I learned something new today.',
            'Well researched and presented. Keep up the good work!',
            'Amazing content! Looking forward to more articles like this.',
            'This really helped me understand the topic better.',
            'Fantastic read! Sharing this with my friends.',
            'Very detailed and comprehensive. Thank you!',
            'Love your writing style. Please write more on this topic!',
        ];

        foreach ($articles as $article) {
            $numComments = rand(2, 5);
            for ($i = 0; $i < $numComments; $i++) {
                $comment = new Comment();
                $comment->setContent($commentTexts[array_rand($commentTexts)]);
                $comment->setArticle($article);
                $comment->setAuthor($users[array_rand($users)]);
                
                $articleDate = $article->getCreatedAt();
                $commentDate = $articleDate->modify('+' . rand(1, 10) . ' days');
                $comment->setCreatedAt($commentDate);
                
                $manager->persist($comment);
            }
        }

        $manager->flush();
    }
}
