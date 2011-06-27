<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\DoctrineBundle\DoctrineBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Acme\DemoBundle\AcmeDemoBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }
        
        //$bundles[] = new Vivacom\CmsBundle\CmsBundle();
        //$bundles[] = new Cypress\CompassGemBundle\CypressCompassGemBundle();
        $bundles[] = new Symfony\Bundle\DoctrineFixturesBundle\DoctrineFixturesBundle();
        //$bundles[] = new Cypress\BlogBundle\CypressBlogBundle();
        $bundles[] = new Cypress\AssetsGalleryBundle\AssetsGalleryBundle();
        $bundles[] = new Avalanche\Bundle\ImagineBundle\AvalancheImagineBundle();
        $bundles[] = new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle();
        
        //$bundles[] = new Propel\PropelBundle\PropelBundle();
        //$bundles[] = new FOS\UserBundle\FOSUserBundle();
        
        // Admin bundle deps
        $bundles[] = new Sonata\jQueryBundle\SonatajQueryBundle();
        $bundles[] = new Sonata\BluePrintBundle\SonataBluePrintBundle();
        //$bundles[] = new Sonata\AdminBundle\SonataAdminBundle();
        $bundles[] = new Knplabs\Bundle\MenuBundle\KnplabsMenuBundle();
        
        //$bundles[] = new Liip\HelloBundle\LiipHelloBundle();
        //$bundles[] = new FOS\RestBundle\FOSRestBundle();
        //$bundles[] = new FOS\FacebookBundle\FOSFacebookBundle();

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
