<?php
$validation = \Config\Services::validation();
?>
<?=$this->include('include/flash')?>
<div>
    <form action="" method="post">
        <div>
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Enter campaign name">
            <div><?=$validation->getError('name') != ''? $validation->getError('name')  :''?></div>
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>