<?php
    signIn($_POST);
    require "public/include/head.php";
?>
    <div class="offset-lg-3 offset-2 col-lg-6 col-10 mt-5 bg-grey ml-auto mr-auto padding_login">
        <h2>Créer un compte</h2>
        <form action="#" method="post" id="signin">
            <div class="form-group">
                <label for="username">Nom d'utilisateur : </label>
                <input type="text" class="form-control" placeholder="Nom d'utilisateur" name="username" id="username"
                       required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe : </label>
                <input type="password" class="form-control" placeholder="Nom d'utilisateur" name="password"
                       id="password" required>
            </div>
            <?= csrfInput() ?>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
<?php
    require "public/include/footer.php";

