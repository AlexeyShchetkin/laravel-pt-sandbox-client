<?php

namespace AlexeyShchetkin\PtSandboxClient\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class SymfonySerializerServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->app->singleton(SerializerInterface::class, function () {
            $encoders = [new XmlEncoder(), new JsonEncoder()];
            $extractor = new PropertyInfoExtractor([], [new PhpDocExtractor(), new ReflectionExtractor()]);
            $normalizers = [new DateTimeNormalizer(), new ArrayDenormalizer(), new ObjectNormalizer(null, null, null, $extractor)];
            return new Serializer($normalizers, $encoders);
        });
    }
}
