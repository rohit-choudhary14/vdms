<?php
use Cake\Core\Configure;

$this->assign('title', '400 - Bad Request');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= h($this->fetch('title')) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #f8f9fc;
            color: #343a40;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .error-container {
            max-width: 600px;
            margin: 100px auto;
            text-align: center;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .error-code {
            font-size: 64px;
            font-weight: 700;
            color: #ffc107; /* Yellow tone for 400 errors */
        }
        .error-message {
            font-size: 20px;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .error-description {
            font-size: 16px;
            color: #6c757d;
        }
        .home-button {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 24px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.2s ease;
        }
       
        .debug-info {
            margin-top: 40px;
            text-align: left;
            font-size: 14px;
            color: #856404;
            background-color: #fff3cd;
            padding: 15px;
            border-left: 4px solid #ffc107;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">400</div>
        <div class="error-message">Bad Request</div>
        <div class="error-description">
            The request was invalid or missing required information.<br>
            Please check the URL or contact support if the issue persists.
        </div>
        <a href="<?= $this->Url->build('/') ?>" class="home-button">Go to Homepage</a>

        <?php if (Configure::read('debug')): ?>
            <div class="debug-info">
                <strong>Debug Info:</strong><br>
                <?= h($message) ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
