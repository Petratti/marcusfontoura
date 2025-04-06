<?php
$loaderTipo = "default";
//$loaderTipo = "gif";
?>

<?php if($loaderTipo == "default"): ?>
    <div class="loader" style="width:100%;height:100%;position:fixed;top:0;left:0;z-index:999999;background:white;">
        <div class="d-flex justify-content-center flex-wrap" style="width:100%;height:100%;">
            <div class="spinner-grow text-secondary m-auto" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
<?php elseif($loaderTipo == "gif"): ?>
    <div class="loader" style="width:100%;height:100%;position:fixed;top:0;left:0;z-index:999999;background:url('<?php echo get_template_directory_uri(); ?>/assets/images/loader.gif') no-repeat center #FFFFFF;"></div>
<?php endif; ?>
