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
        $this->loadModel('DriverAssignments');
        $this->loadModel('Insurance');
        $this->loadModel('Maintenance');

        // Dashboard stats
        $totalVehicles = $this->Vehicles->find()->count();
        $activeVehicles = $this->Vehicles->find()->where(['status' => 'Active'])->count();
        $idleVehicles = $this->Vehicles->find()->where(['status !=' => 'Active'])->count();
        $totalDrivers = $this->Drivers->find()->count();

        // Alerts: insurance expiry within next 30 days
        $today = date('Y-m-d');
        $next30 = date('Y-m-d', strtotime('+30 days'));
        $insuranceDue = $this->Insurance->find()
            ->where(['expiry_date <=' => $next30, 'expiry_date >=' => $today])
            ->count();

        $registrationDue = $this->Vehicles->find()
            ->where([
                'registration_to <=' => $next30,
                'registration_to >=' => $today
            ])
            ->count();
        // Service & Maintenance due within next 30 days
        $serviceDue = $this->Maintenance->find()
            ->where([
                'next_service_due <=' => $next30,
                'next_service_due >=' => $today
            ])
            ->count();
            $overdueServices = $this->Maintenance->find()
    ->where(['next_service_due <' => $today])
    ->count();

        // Alerts: pending driver approvals (status = 'Pending' in drivers table)
        $pendingDriverApprovals = $this->Drivers->find()
            ->where(['status' => 'Pending'])
            ->count();

        // Recent Vehicle Activity (existing code)
        $recentVehicles = $this->Vehicles->find()
            ->select([
                // 'Vehicles.vehicle_id',
                'Vehicles.vehicle_code',
                'Vehicles.vehicle_type_id',
                'Vehicles.fuel_type',
                'Vehicles.status',
                'Vehicles.modified'
            ])
            ->contain([
                'DriverAssignments' => function ($q) {
                    return $q->contain(['Drivers'])
                        ->where(['DriverAssignments.end_date IS' => null]);
                }
            ])
            ->order(['Vehicles.modified' => 'DESC'])
            ->limit(10)
            ->all();

        // Pass to view
        $this->set(compact(
            'totalVehicles',
            'activeVehicles',
            'idleVehicles',
            'totalDrivers',
            'insuranceDue',
            'registrationDue',
            'pendingDriverApprovals',
             'serviceDue',
             'overdueServices',
            'recentVehicles'
        ));
    }
}
