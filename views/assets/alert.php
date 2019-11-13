<?php if(!is_null($_SESSION['success'])) {?>
    <div class="alert alert-success alert-dismissible fade show" style="margin-top: 10px" role="alert">
        <?= $_SESSION['success'] ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } if(!is_null($_SESSION['error'])) {?>
    <div class="alert alert-danger alert-dismissible fade show" style="margin-top: 10px" role="alert">
        <?= $_SESSION['error'] ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } unset($_SESSION['error']); unset($_SESSION['success']);?>