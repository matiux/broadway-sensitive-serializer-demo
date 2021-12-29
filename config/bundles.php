<?php

declare(strict_types=1);

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Broadway\Bundle\BroadwayBundle\BroadwayBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => true],
    Matiux\Broadway\SensitiveSerializer\Bundle\SensitiveSerializerBundle\BroadwaySensitiveSerializerBundle::class => ['all' => true],
];
