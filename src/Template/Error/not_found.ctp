<?php
$this->assign('title', '404 - Page Not Found');
?>

<div style="max-width:600px; margin:100px auto; text-align:center; font-family:sans-serif;">
    <h1 style="font-size:64px; color:#17a2b8;">404</h1>
    <h2>Page Not Found</h2>
    <p>Sorry, the page you are looking for does not exist.</p>
    <p><a href="<?= $this->Url->build('/') ?>" style="color:#007bff; text-decoration:none;">Return to homepage</a></p>
</div>
