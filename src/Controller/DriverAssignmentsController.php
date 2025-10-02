<?php
namespace App\Controller;

use App\Controller\AppController;

class DriverAssignmentsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('Drivers');
        $this->loadModel('Vehicles');
    }

    // List all assignments
    public function index()
    {
        $assignments = $this->Paginator->paginate(
            $this->DriverAssignments->find()
                ->contain(['Drivers', 'Vehicles'])
                ->order(['start_date' => 'DESC'])
        );
        $this->set(compact('assignments'));
    }

    // Add assignment
    public function add()
    {
        $assignment = $this->DriverAssignments->newEntity();

        if ($this->request->is('post')) {
            $assignment = $this->DriverAssignments->patchEntity($assignment, $this->request->getData());
            if ($this->DriverAssignments->save($assignment)) {
                $this->Flash->success('Driver assignment saved successfully.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Please fix errors and try again.');
        }

        $drivers = $this->Drivers->find('list');
        $vehicles = $this->Vehicles->find('list');
        $this->set(compact('assignment', 'drivers', 'vehicles'));
    }

    // Edit assignment
    public function edit($id = null)
    {
        $assignment = $this->DriverAssignments->get($id);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $assignment = $this->DriverAssignments->patchEntity($assignment, $this->request->getData());
            if ($this->DriverAssignments->save($assignment)) {
                $this->Flash->success('Driver assignment updated successfully.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Please fix errors and try again.');
        }

        $drivers = $this->Drivers->find('list');
        $vehicles = $this->Vehicles->find('list');
        $this->set(compact('assignment', 'drivers', 'vehicles'));
    }

    // Delete assignment
    public function delete($id = null)
    {
        $this->request->allowMethod(['post','delete']);
        $assignment = $this->DriverAssignments->get($id);
        if ($this->DriverAssignments->delete($assignment)) {
            $this->Flash->success('Driver assignment deleted.');
        } else {
            $this->Flash->error('Unable to delete driver assignment.');
        }
        return $this->redirect(['action' => 'index']);
    }

    // View assignment details
    public function view($id = null)
    {
        $assignment = $this->DriverAssignments->get($id, ['contain'=>['Drivers','Vehicles']]);
        $this->set(compact('assignment'));
    }
}
