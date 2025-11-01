<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InsuranceCompany $insuranceCompany
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Insurance Companies'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="insuranceCompanies form large-9 medium-8 columns content">
    <?= $this->Form->create($insuranceCompany) ?>
    <fieldset>
        <legend><?= __('Add Insurance Company') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('contact_number');
            echo $this->Form->control('email');
            echo $this->Form->control('address');
            echo $this->Form->control('website');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
