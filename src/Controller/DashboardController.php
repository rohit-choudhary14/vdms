<?php
namespace App\Controller;

use App\Controller\AppController;

class DashboardController extends AppController
{
    public function index()
    {
        // Load models
        $this->loadModel('Vehicles');
        $this->loadModel('Drivers');
        $this->loadModel('Insurance');
        $this->loadModel('Maintenance');

        $totalVehicles = $this->Vehicles->find()->count();
        $activeVehicles = $this->Vehicles->find()->where(['status' => 'Active'])->count();
        $idleVehicles = $this->Vehicles->find()->where(['status !=' => 'Active'])->count();
        $totalDrivers = $this->Drivers->find()->count();

        // alerts: insurance expiry within next 30 days
        $today = date('Y-m-d');
        $next30 = date('Y-m-d', strtotime('+30 days'));
        $insuranceDue = $this->Insurance->find()->where(['expiry_date <=' => $next30, 'expiry_date >=' => $today])->count();

        $this->set(compact('totalVehicles','activeVehicles','idleVehicles','totalDrivers','insuranceDue'));
    }
}
