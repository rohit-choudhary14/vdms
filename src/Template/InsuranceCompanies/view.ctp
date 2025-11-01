<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InsuranceCompany $insuranceCompany
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Insurance Company'), ['action' => 'edit', $insuranceCompany->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Insurance Company'), ['action' => 'delete', $insuranceCompany->id], ['confirm' => __('Are you sure you want to delete # {0}?', $insuranceCompany->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Insurance Companies'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Insurance Company'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="insuranceCompanies view large-9 medium-8 columns content">
    <h3><?= h($insuranceCompany->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($insuranceCompany->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Contact Number') ?></th>
            <td><?= h($insuranceCompany->contact_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($insuranceCompany->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Website') ?></th>
            <td><?= h($insuranceCompany->website) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($insuranceCompany->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($insuranceCompany->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($insuranceCompany->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($insuranceCompany->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Address') ?></h4>
        <?= $this->Text->autoParagraph(h($insuranceCompany->address)); ?>
    </div>
</div>
