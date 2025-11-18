<h2>Welcome to Dashboard</h2>
<p>Hello, <?= h($user['username']) ?>!</p>

<?= $this->Html->link('Logout', ['action' => 'logout']) ?>
