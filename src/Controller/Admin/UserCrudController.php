<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // Add this line for the `id` field
            IdField::new('id')->setLabel('User ID'),
    
            TextField::new('name')->setLabel('Name'),
            EmailField::new('email')->setLabel('Email'),
            TextEditorField::new('address')->setLabel('Address'),
            TextField::new('phone')->setLabel('Phone'),
            TextField::new('gender')->setLabel('Gender'),
            TextField::new('password')
                ->setLabel('Password')
                ->setFormTypeOption('attr', ['type' => 'password']) // Render as a password field in forms
                ->onlyOnForms(),
        ];
    }
}
