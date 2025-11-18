<div class="container-fluid vh-100">
    <div class="row h-100">
        <!-- Left Side: Image -->
        <div class="col-md-6 d-none d-md-block p-0">
            <div class="h-100 w-100" style="background: url('/img/driver-management.jpg') center center / cover no-repeat;"></div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <div class="card shadow-lg p-4 w-75">
                <!-- Card Header -->
                <div class="text-center mb-4">
                    <h2 class="font-weight-bold"><i class="fas fa-user-circle"></i> Login</h2>
                </div>

                <!-- Flash Messages -->
                <?= $this->Flash->render() ?>

                <!-- Login Form -->
                <?= $this->Form->create(null, ['class' => 'needs-validation', 'novalidate' => true]) ?>

                <div class="form-group">
                    <?= $this->Form->control('username', [
                        'class' => 'form-control form-control-lg shadow-sm',
                        'placeholder' => 'Enter username',
                        'label' => false,
                        'required' => true
                    ]) ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->control('password', [
                        'type' => 'password',
                        'class' => 'form-control form-control-lg shadow-sm',
                        'placeholder' => 'Enter password',
                        'label' => false,
                        'required' => true
                    ]) ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->button('<i class="fas fa-sign-in-alt"></i> Login', [
                        'escape' => false,
                        'class' => 'btn btn-primary btn-lg btn-block shadow-sm'
                    ]) ?>
                </div>

                <?= $this->Form->end() ?>

                <div class="text-center mt-2">
                    <a href="/users/forgotPassword" class="text-muted small">Forgot Password?</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS & CSS -->
<?= $this->Html->script([
    'https://code.jquery.com/jquery-3.5.1.slim.min.js',
    'https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js'
]) ?>
<?= $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css') ?>
