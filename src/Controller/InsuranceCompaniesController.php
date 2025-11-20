<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * InsuranceCompanies Controller
 *
 * @property \App\Model\Table\InsuranceCompaniesTable $InsuranceCompanies
 *
 * @method \App\Model\Entity\InsuranceCompany[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InsuranceCompaniesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $insuranceCompanies = $this->paginate($this->InsuranceCompanies);

        $this->set(compact('insuranceCompanies'));
    }

    /**
     * View method
     *
     * @param string|null $id Insurance Company id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $insuranceCompany = $this->InsuranceCompanies->get($id, [
            'contain' => [],
        ]);

        $this->set('insuranceCompany', $insuranceCompany);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $insuranceCompany = $this->InsuranceCompanies->newEntity();
        if ($this->request->is('post')) {
            $insuranceCompany = $this->InsuranceCompanies->patchEntity($insuranceCompany, $this->request->getData());
            if ($this->InsuranceCompanies->save($insuranceCompany)) {
                $this->Flash->success(__('The insurance company has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The insurance company could not be saved. Please, try again.'));
        }
        $this->set(compact('insuranceCompany'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Insurance Company id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $insuranceCompany = $this->InsuranceCompanies->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $insuranceCompany = $this->InsuranceCompanies->patchEntity($insuranceCompany, $this->request->getData());
          
            if ($this->InsuranceCompanies->save($insuranceCompany)) {
                $this->Flash->success(__('The insurance company has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The insurance company could not be saved. Please, try again.'));
        }

        
        $this->set(compact('insuranceCompany'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Insurance Company id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $insuranceCompany = $this->InsuranceCompanies->get($id);
        if ($this->InsuranceCompanies->delete($insuranceCompany)) {
            $this->Flash->success(__('The insurance company has been deleted.'));
        } else {
            $this->Flash->error(__('The insurance company could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
     public function getDetails($id = null)
    {
        $this->autoRender = false;
        $this->response = $this->response->withType('application/json');

        if (!$id) {
            return $this->response->withStringBody(json_encode(['success' => false]));
        }

        $company = $this->InsuranceCompanies->find()
            ->select(['contact_number', 'address', 'insurer_name'])
            ->where(['id' => $id])
            ->first();

        if ($company) {
            return $this->response->withStringBody(json_encode([
                'success' => true,
                'data' => [
                    'contact_number' => $company->contact_number,
                    'address' => $company->address,
                    'insurer_name' => $company->insurer_name,

                ]
            ]));
        }

        return $this->response->withStringBody(json_encode(['success' => false]));
    }
}
