<?php
$session =  session();
$success = $session->getFlashdata('success');
$error = $session->getFlashdata('error');

if($success != '') : ?>
<div class="success">
    <?=$success?>
</div>
<?php endif;

if($error != '') : ?>
<div class="error">
    <?=$error?>
</div>
<?php endif; ?>