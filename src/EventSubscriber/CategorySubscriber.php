<?php
namespace App\EventSubscriber;

use App\Repository\CategoryRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class CategorySubscriber implements EventSubscriberInterface
{
    private $categoryRepository;
    private $twig;

    public function __construct(CategoryRepository $categoryRepository, Environment $twig)
    {
        $this->categoryRepository = $categoryRepository;
        $this->twig = $twig;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event)
    {
        $categories = $this->categoryRepository->findAll();
        $this->twig->addGlobal('categories', $categories);
    }
}
