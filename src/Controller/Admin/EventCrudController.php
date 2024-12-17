<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField; // Add this for nbr_guests_max

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureFields(string $pageName): iterable
    {       
        
        
        return [
            TextField::new('name')->setLabel('Event Name'),  // Display event name
            TextField::new('place')->setLabel('Place'),
            TextField::new('city')->setLabel('City'),
            TextField::new('country')->setLabel('Country'),
            IntegerField::new('price')->setLabel('price')->setRequired(true),
            
            // Make sure that `nbr_guests_max` is an integer and is required
            IntegerField::new('nbr_guests_max')->setLabel('Max Guests')->setRequired(true), // Mark as required field
            IntegerField::new('longitude')->setLabel('Longitude')->setRequired(true),
            IntegerField::new('latitude')->setLabel('latitude')->setRequired(true),


            // Display associated users using AssociationField
            AssociationField::new('users')->setLabel('Users')
                ->formatValue(function ($value) {
                    // Check if $value is a collection of User entities
                    if ($value instanceof \Doctrine\Common\Collections\Collection) {
                        // Return the names of the users as a comma-separated string
                        return implode(', ', $value->map(function($user) {
                            return $user->__toString(); // Assuming your User entity has a __toString method
                        })->toArray());
                 }
                    return ''; // Get string representation of the user
                }),
            ImageField::new('img_path')
                ->setLabel('Image Path')
                ->setUploadDir('public/assets/images/EventPageImages/Events')  // Relative path from the public directory
                ->setBasePath('assets/images/EventPageImages/Events')  // Path for accessing the image via the browser
                ->setRequired(true),
            DateTimeField::new('date_debut')->setLabel('Start Date'),  // Display event start date
            DateTimeField::new('date_fin')->setLabel('End Date'),  // Display event end date
        ];
    }
}
