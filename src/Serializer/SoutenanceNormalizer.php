<?php

 namespace App\Serializer;

 use App\Entity\Etudiant;
 use App\Entity\Institut;
 use App\Entity\Soutenance;
 use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
 use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
 use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
 use Vich\UploaderBundle\Storage\StorageInterface;

 class SoutenanceNormalizer implements ContextAwareNormalizerInterface , NormalizerAwareInterface
 {
     use NormalizerAwareTrait;
     private const ALREADY_CALLED = 'AppUserNormalizerAlreadyCalled';

     public function __construct(private StorageInterface $storage){

     }
     public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool

     {
         return !isset($context[self::ALREADY_CALLED]) && $data instanceof Soutenance;
         // TODO: Implement supportsNormalization() method.
     }

     /**
      * @param Soutenance $object
      */
     public function normalize(mixed $object, string $format = null, array $context = [])
     {
         $object->setFileUrl($this->storage->resolveUri($object,'vichFile'));
         $context[self::ALREADY_CALLED]=true;
         return $this->normalizer->normalize($object,$format,$context);
         // TODO: Implement normalize() method.
     }
 }