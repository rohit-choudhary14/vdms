<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InsuranceCompany[]|\Cake\Collection\CollectionInterface $insuranceCompanies
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Insurance Company'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="insuranceCompanies index large-9 medium-8 columns content">
    <h3><?= __('Insurance Companies') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('contact_number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('website') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($insuranceCompanies as $insuranceCompany): ?>
            <tr>
                <td><?= $this->Number->format($insuranceCompany->id) ?></td>
                <td><?= h($insuranceCompany->name) ?></td>
                <td><?= h($insuranceCompany->contact_number) ?></td>
                <td><?= h($insuranceCompany->email) ?></td>
                <td><?= h($insuranceCompany->website) ?></td>
                <td><?= h($insuranceCompany->status) ?></td>
                <td><?= h($insuranceCompany->created) ?></td>
                <td><?= h($insuranceCompany->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $insuranceCompany->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $insuranceCompany->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $insuranceCompany->id], ['confirm' => __('Are you sure you want to delete # {0}?', $insuranceCompany->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
