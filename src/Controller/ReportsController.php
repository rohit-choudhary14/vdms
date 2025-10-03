<?php
namespace App\Controller;

use App\Controller\AppController;

use Dompdf\Dompdf;
use Dompdf\Options;

class ReportsController extends AppController
{
    public function index()
    {
        $this->loadModel('Drivers');
        $this->loadModel('Vehicles');

        $drivers = $this->Drivers->find('list', [
            'keyField' => 'driver_code',
            'valueField' => 'name'
        ])->toArray();

        $vehicles = $this->Vehicles->find('list', [
            'keyField' => 'vehicle_code',
            'valueField' => 'registration_no'
        ])->toArray();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $reportType = $data['report_type'];
            $output = $data['output'];

            if ($reportType === 'driver') {
                $id = $data['driver_code'] ?: null;
                if (!$id) {
                    $this->Flash->error("Please select a driver.");
                    return $this->redirect($this->referer());
                }
                if ($output === 'view') {
                    return $this->redirect(['action' => 'driverReport', $id]);
                } elseif ($output === 'pdf') {
                    return $this->redirect(['action' => 'driverReportPdf', $id]);
                } elseif ($output === 'excel') {
                    return $this->redirect(['action' => 'driverReportExcel', $id]);
                }
            } elseif ($reportType === 'vehicle') {
                $id = $data['vehicle_code'] ?: null;
                if (!$id) {
                    $this->Flash->error("Please select a vehicle.");
                    return $this->redirect($this->referer());
                }
                if ($output === 'view') {
                    return $this->redirect(['action' => 'vehicleReport', $id]);
                } elseif ($output === 'pdf') {
                    return $this->redirect(['action' => 'vehicleReportPdf', $id]);
                }
            } else {
                $this->Flash->error("Please select a report type.");
                return $this->redirect($this->referer());
            }
        }

        $this->set(compact('drivers', 'vehicles'));
    }

    public function driverReport($driverId)
    {
        $this->loadModel('Drivers');
        $this->loadModel('Fuel');
        $this->loadModel('Accidents');
        $this->loadModel('DriverAssignments');
        
        $driver = $this->Drivers->find()
            ->where(['driver_code' => $driverId])
            ->firstOrFail();
      
        $fuelLogs = $this->Fuel->find()
            ->contain(['Vehicles'])
            ->where(['Fuel.driver_code' => $driverId])
            ->order(['Fuel.refuel_date' => 'DESC'])
            ->toArray();

        $accidents = $this->Accidents->find()
            ->contain(['Vehicles'])
            ->where(['Accidents.driver_code' => $driverId])
            ->order(['Accidents.date_time' => 'DESC'])
            ->toArray();

        $this->set(compact('driver', 'fuelLogs', 'accidents'));
    }

    public function driverReportPdf($driverId = null)
    {
        if (!$driverId) {
            $this->Flash->error("Driver ID missing!");
            return $this->redirect(['action' => 'index']);
        }

        // Fetch report data
        $this->driverReport($driverId);

        // Render the view into HTML
        $this->viewBuilder()->enableAutoLayout(false);
        $html = $this->render('driver_report')->body();

        // Configure Dompdf
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Stream the PDF to browser
        $filename = "DriverReport_$driverId.pdf";
        $dompdf->stream($filename, ["Attachment" => true]);

        return $this->response->withType('pdf');
    }



    public function vehicleReport($vehicleId)
    {
        $this->loadModel('Vehicles');
        $this->loadModel('Fuel');
        $this->loadModel('Maintenance');
        $this->loadModel('Insurance');
        $this->loadModel('Accidents');
        $vehicle = $this->Vehicles->find()
                ->where(['vehicle_code' => $vehicleId])
                ->first();
      
        $fuelLogs = $this->Fuel->find()
            ->contain(['Drivers'])
            ->where(['Fuel.vehicle_code' => $vehicleId])
            ->order(['Fuel.refuel_date' => 'DESC'])
            ->toArray();

        $maintenance = $this->Maintenance->find()
            ->where(['vehicle_code' => $vehicleId])
            ->order(['service_date' => 'DESC'])
            ->toArray();

        $insurance = $this->Insurance->find()
            ->where(['vehicle_code' => $vehicleId])
            ->order(['expiry_date' => 'DESC'])
            ->toArray();

        $accidents = $this->Accidents->find()
            ->where(['vehicle_code' => $vehicleId])
            ->order(['date_time' => 'DESC'])
            ->toArray();

        $this->set(compact('vehicle', 'fuelLogs', 'maintenance', 'insurance', 'accidents'));
    }

    public function vehicleReportPdf($vehicleId = null)
    {
        if (!$vehicleId) {
            $this->Flash->error("Vehicle ID missing!");
            return $this->redirect(['action' => 'index']);
        }

        $this->vehicleReport($vehicleId);

        $this->viewBuilder()->enableAutoLayout(false);
        $html = $this->render('vehicle_report')->body();

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = "VehicleReport_$vehicleId.pdf";
        $dompdf->stream($filename, ["Attachment" => true]);

        return $this->response->withType('pdf');
    }

}
