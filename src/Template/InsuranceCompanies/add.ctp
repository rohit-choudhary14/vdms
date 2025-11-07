<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InsuranceCompany $insuranceCompany
 */
?>

<div class="mt-5">
    <?= $this->Html->link(
        '<i class="fas fa-arrow-left me-1"></i> Back to List',
        ['action' => 'index'],
        ['class' => 'btn btn-outline-dark', 'escape' => false]
    ) ?>
</div>

<div class="card shadow-sm mb-4 mt-3">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0"><i class="fas fa-building me-2"></i>Add Insurance Company</h5>
    </div>

    <div class="card-body">
        <?= $this->Form->create($insuranceCompany, [
            'class' => 'row g-4 needs-validation',
            'novalidate' => true
        ]) ?>

        <!-- Company Name -->
        <div class="col-md-6">
            <?= $this->Form->control('name', [
                'label' => 'Company Name',
                'class' => 'form-control',
                'placeholder' => 'Enter company name',
                'required' => true,
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Contact Number -->
        <div class="col-md-6">
            <?= $this->Form->control('contact_number', [
                'label' => 'Contact Number',
                'class' => 'form-control',
                'type' => 'tel',
                'maxlength' => 10,
                'pattern' => '\d{10}',
                'placeholder' => 'Enter 10-digit number',
                'required' => true,
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Email -->
        <div class="col-md-6">
            <?= $this->Form->control('email', [
                'label' => 'Email ID',
                'class' => 'form-control',
                'type' => 'email',
                'placeholder' => 'Enter valid email address',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Website -->
        <div class="col-md-6">
            <?= $this->Form->control('website', [
                'label' => 'Website',
                'class' => 'form-control',
                'placeholder' => 'https://example.com'
            ]) ?>
        </div>

        <!-- Address -->
        <div class="col-md-12">
            <?= $this->Form->control('address', [
                'label' => 'Full Address',
                'rows' => 3,
                'class' => 'form-control',
                'placeholder' => 'Enter company address',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Status -->
        <div class="col-md-6">
            <?= $this->Form->control('status', [
                'label' => 'Status',
                'options' => [
                    'Active' => 'Active',
                    'Inactive' => 'Inactive'
                ],
                'class' => 'form-select form-control',
                'empty' => 'Select Status',
                'required' => true,
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Submit -->
        <div class="col-12 text-end mt-3">
            <?= $this->Form->button('<i class="fas fa-save"></i> Save Company', [
                'escape' => false,
                'class' => 'btn btn-success px-5 btn-lg shadow-sm'
            ]) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>
