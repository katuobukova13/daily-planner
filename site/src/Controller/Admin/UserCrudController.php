<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Request;

class UserCrudController extends AbstractCrudController
{
    public $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function configureFields(string $pageName): iterable
    {
        $roles = ['ROLE_ADMIN', 'ROLE_USER'];
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('email'),
            ChoiceField::new('roles')
                ->setChoices(array_combine($roles, $roles))
                ->allowMultipleChoices()
                ->renderExpanded()
                ->renderAsBadges(),
            BooleanField::new('enabled'),
        ];
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): \EasyCorp\Bundle\EasyAdminBundle\Config\Actions
    {
        $viewInvoice = Action::new('deleteTasks')
            ->linkToCrudAction('deleteTasks')
            ->setIcon('fas fa-trash');

        return parent::configureActions($actions)
            ->add(Crud::PAGE_INDEX, $viewInvoice)
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT);
    }

    public function deleteTasks(AdminContext $context, EntityManagerInterface $entityManager, Request $request)
    {
        $userId = $context->getRequest()->get('entityId');

        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->find($userId);

        $tasks = $user->getTask()->toArray();

        $uri = $request->headers->get('referer');

        foreach ($tasks as $task) {
            $entityManager->remove($task);
        }

        $entityManager->flush();

        $this->addFlash('success', 'Tasks deleted successfully.');

        return $this->redirect($uri);
    }

}
