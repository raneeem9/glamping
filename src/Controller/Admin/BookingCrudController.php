<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class BookingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Booking::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Bookings')
            ->setSearchFields(['id', 'idEvent.name', 'idUser.name']) // Adjust based on actual entity properties
            ->setDefaultSort(['Date' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setLabel('Booking ID'),

            // Use AssociationField for the id_event association
            AssociationField::new('id_event')
                ->setLabel('Event')
                ->setRequired(true)
                ->formatValue(function ($value) {
                    // Customize the value display, e.g., show event name
                    return $value ? $value->getName() : ''; // Return the name of the event
                }),

            AssociationField::new('id_user') // Use the correct property name as per your entity
                ->setLabel('User')
                ->setRequired(true)
                ->formatValue(function ($value) {
                    // Customize the value display, e.g., show user name
                    return $value ? $value->getName() : ''; // Return the name of the user
                }),

            IntegerField::new('nbr_guests')
                ->setLabel('Number of Guests')
                ->setRequired(true),

            DateTimeField::new('Date')
                ->setLabel('Booking Date')
                ->setRequired(true),
        ];
    }
}
