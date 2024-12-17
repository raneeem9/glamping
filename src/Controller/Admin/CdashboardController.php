<?php
namespace App\Controller\Admin;

use App\Repository\BookingRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CdashboardController extends AbstractDashboardController
{
    private BookingRepository $bookingRepository;
    private UserRepository $userRepository;

    // Injecting repositories via the constructor
    public function __construct(BookingRepository $bookingRepository, UserRepository $userRepository)
    {
        $this->bookingRepository = $bookingRepository;
        $this->userRepository = $userRepository;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $stats = [
            'totalBookings' => $this->bookingRepository->count([]),
            'totalUsers' => $this->userRepository->count([]),
        ];
        
        return $this->render('admin/my_dashboard.html.twig', [
            'stats' => $stats,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Glamping');
    }

    public function configureMenuItems(): iterable
    {  
    yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
    yield MenuItem::linkToCrud('Bookings', 'fas fa-list', Booking::class) // This links to BookingCrudController
    ->setController(BookingCrudController::class); // Links to the BookingCrudController
    yield MenuItem::linkToCrud('Events', 'fas fa-calendar', Event::class)
    ->setController(EventCrudController::class);  // Links to the EventCrudController
    yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class) // Ensure UserCrudController is used here
    ->setController(UserCrudController::class);   // Links to the UserCrudController
    
    }
}
