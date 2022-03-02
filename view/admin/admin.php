<?php
    require "public/include/head.php";
?>

    <div class="container mt-5 pt-5">
        <div class="row">
            <a href='<?= ROOT ?>admin/new-grid' class='offset-lg-1 col-lg-4 col-10 bloc btn btn-primary'>
                <span class='bloc-text'>Insérer une grille</span>
            </a>
            <a href="<?= ROOT ?>admin/grid" class="offset-lg-2 col-lg-4 col-10 bloc btn btn-primary">
                <span class="bloc-text">Jouer</span>
            </a>
        </div>
    </div>

<?php
    require "public/include/footer.php";
