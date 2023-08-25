<?php

namespace App\Service;

use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Serializer;

class SerializerService implements SerializerInterface
{
  public function serialize($data, $format, array $context = [])
  {
  }
  public function deserialize($data, $type, $format, array $context = [])
  {
  }
  public function normalize($object, $format = null, $context = array())
  {
    $normalizer = $this->getNormalizers();
    $serializer = new Serializer($normalizer, [new JsonEncoder(), new CsvEncoder()]);

    return $serializer->normalize($object, $format, $context);
  }


  private function getNormalizers()
  {
    $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
    $normalizer = new PropertyNormalizer($classMetadataFactory);
    return [
      new DateTimeNormalizer(['datetime_format' => 'Y-m-d H:i:s']), $normalizer
    ];
  }
}
