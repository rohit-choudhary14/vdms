<nav aria-label="Page navigation">
  <?= $this->Paginator->first('<<') ?>
  <?= $this->Paginator->prev('<') ?>
  <?= $this->Paginator->numbers() ?>
  <?= $this->Paginator->next('>') ?>
  <?= $this->Paginator->last('>>') ?>
</nav>
