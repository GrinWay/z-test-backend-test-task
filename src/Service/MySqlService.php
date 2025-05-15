<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class MySqlService
{
    public function __construct(
        public readonly SerializerInterface       $serializer,
        public readonly EntityManagerInterface    $em,
        public readonly PropertyAccessorInterface $pa,

        #[Autowire(env: 'resolve:APP_DATABASE_USER')]
        public readonly string                    $dbUser,

        #[Autowire(env: 'resolve:APP_DATABASE_NAME')]
        public readonly string                    $dbName,
    )
    {
    }

    public function importCSV(string $path, string $tableName): void
    {
        Validation::createCallable(
            new Assert\File(
                mimeTypes: [
                    'text/csv',
                ],
            ),
        )($path);

        if (!$this->em->getConnection()->createSchemaManager()->tablesExist([$tableName])) {
            throw new \InvalidArgumentException(\sprintf('Table "%s" does not exist.', $tableName));
        }

        $allMetadata = $this->em->getMetadataFactory()->getAllMetadata();
        $entityFQCN = null;
        foreach ($allMetadata as $metadata) {
            if ($metadata->getTableName() === $tableName) {
                $entityFQCN = $metadata->getName(); // fully qualified class name
                break;
            }
        }

        $dataCollection = $this->serializer->decode(
            \file_get_contents($path),
            'csv',
        );
        foreach ($dataCollection as $data) {
            $id = $data['id'] ?? null;
            if (null !== $id && null !== $this->em->find($entityFQCN, $id)) {
                // Entity with this "id" already exists, skip
                continue;
            }

            $entity = $this->serializer->denormalize(
                $data,
                $entityFQCN,
                'csv',
                context: [
                    'groups' => [
                        'Tender',
                    ],
                    AbstractNormalizer::CALLBACKS => [
                        'createdAt' => static function ($data, $fqcn, $prop, $format, $context) {
                            if (SerializerService::isNullString($data)) {
                                return null;
                            }
                            return $data;
                        },
                        'updatedAt' => static function ($data, $fqcn, $prop, $format, $context) {
                            if (SerializerService::isNullString($data)) {
                                return null;
                            }
                            return $data;
                        },
                    ],
                ],
            );
            $this->em->persist($entity);
        }
        $this->em->flush();
    }
}
