<?php

namespace App\Controller\admin;

use App\Repository\admin\DashboardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class AdminDashboardController extends AbstractController
{
    public function __construct(
        private DashboardRepository $dashboardRepository
    ) {}

    #[Route('/api/dashboard', name: 'api_dashboard', methods: ['GET'])]
    public function apiDashboard(): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $data = $this->dashboardRepository->getDashboardData();

        return $this->json($data);
    }
}
