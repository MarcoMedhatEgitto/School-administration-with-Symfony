<?php

namespace App\Controller\Admin;

use App\Entity\Classroom;
use App\Entity\Student;
use App\Entity\Level;
use App\Entity\Activity;
use App\Entity\EvaluationItem;
use App\Entity\Evaluation;
use App\Entity\EvaluationModel;
use App\Entity\Criteria;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CrudController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(ClassroomCrudController::class)->generateUrl();

        return $this->redirect($url);


        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Scuola')
            ->setFaviconPath('https://th.bing.com/th?id=OIP.g5LGE3TG1FOFLjxQ338iuwHaHa&w=250&h=250&c=8&rs=1&qlt=90&o=6&dpr=1.3&pid=3.1&rm=2');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Back to the website', 'fas fa-home', 'main_page');
        yield MenuItem::linkToCrud('Classrooms', 'fa-solid fa-landmark', Classroom::class);
        yield MenuItem::linkToCrud('Students', 'fa-solid fa-user', Student::class);
        yield MenuItem::linkToCrud('Evaluation_levels', 'fa-solid fa-layer-group', Level::class);
        yield MenuItem::linkToCrud('Evaluation_criteria', 'fa-solid fa-table-list', Criteria::class);
        yield MenuItem::linkToCrud('Evaluation_model', 'fa-solid fa-code-compare', EvaluationModel::class);
        yield MenuItem::linkToCrud('Activity', 'fa-solid fa-people-roof', Activity::class);
        yield MenuItem::linkToCrud('Evaluation_item', 'fa-solid fa-table', EvaluationItem::class);
        yield MenuItem::linkToCrud('Evaluation', 'fa-solid fa-chart-line', Evaluation::class);
    }
}
