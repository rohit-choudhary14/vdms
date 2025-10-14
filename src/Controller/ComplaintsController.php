<?php
namespace App\Controller;

use App\Controller\AppController;

class ComplaintsController extends AppController
{
   public function index()
{
    $complaints = $this->Complaints->find('all');
    $this->set(compact('complaints'));
}
}
