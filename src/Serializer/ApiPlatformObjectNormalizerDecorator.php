<?php

namespace App\Serializer;

use ApiPlatform\Metadata\IriConverterInterface;
use ApiPlatform\Metadata\Property\Factory\PropertyMetadataFactoryInterface;
use ApiPlatform\Metadata\Property\Factory\PropertyNameCollectionFactoryInterface;
use ApiPlatform\Metadata\Resource\Factory\ResourceMetadataCollectionFactoryInterface;
use ApiPlatform\Metadata\ResourceAccessCheckerInterface;
use ApiPlatform\Metadata\ResourceClassResolverInterface;
use ApiPlatform\Serializer\ItemNormalizer;
use ApiPlatform\Serializer\TagCollectorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

#[AutoconfigureTag('serializer.normalizer', ['priority' => 0])]
class ApiPlatformObjectNormalizerDecorator extends ItemNormalizer
{
    public function __construct(PropertyNameCollectionFactoryInterface $propertyNameCollectionFactory, PropertyMetadataFactoryInterface $propertyMetadataFactory, IriConverterInterface $iriConverter, ResourceClassResolverInterface $resourceClassResolver, ?PropertyAccessorInterface $propertyAccessor = null, #[Autowire('@serializer.name_converter.camel_case_to_snake_case')] ?NameConverterInterface $nameConverter = null, ?ClassMetadataFactoryInterface $classMetadataFactory = null, ?LoggerInterface $logger = null, ?ResourceMetadataCollectionFactoryInterface $resourceMetadataFactory = null, ?ResourceAccessCheckerInterface $resourceAccessChecker = null, array $defaultContext = [], ?TagCollectorInterface $tagCollector = null)
    {
        parent::__construct(
            $propertyNameCollectionFactory,
            $propertyMetadataFactory,
            $iriConverter,
            $resourceClassResolver,
            $propertyAccessor,
            $nameConverter,
            $classMetadataFactory,
            $logger,
            $resourceMetadataFactory,
            $resourceAccessChecker,
            $defaultContext,
            $tagCollector,
        );
    }

    protected function getAllowedAttributes(object|string $classOrObject, array $context, bool $attributesAsString = false): array|bool
    {
        $attributes = parent::getAllowedAttributes($classOrObject, $context, $attributesAsString);
        if (\is_array($attributes) && !\in_array('id', $attributes, true)) {
            $attributes[] = 'id';
        }
        return $attributes;
    }
}
