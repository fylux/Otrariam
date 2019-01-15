<nav>

    <ul id="center_nav">

    <li id="menu_logo"><a href="index.php"><img src="img/elementos/logos/logo.png" id="logo"></a></li>

    <li id="menu_login">
            
            <div id="login"><p>Iniciar sesión</p></div>

            <!--Login-->
            <form class="form-1" id="form_login" name="form_login" method="post" action="procesa_login.php">
                <p class="field">
            <input type="text" placeholder="Usuario" maxlength="30" name="nombre" required>
                    <i class="icon-user"></i>
                </p>
                <p class="field">
            <input type="password" placeholder="Contraseña" maxlength="30" name="password" required/>
                    <i class="icon-lock"></i>
                </p>       
                <p class="submit">
            <button type="submit" name="submit"><i class="icon-arrow-right icon-large"></i></button>
                </p>

                <!--<p class="recordar">
                    <input type="checkbox"> No cerrar sesión
                </p>-->
            </form>

    </li>

    <li style="float:left;margin-left:150px;margin-top:15px;">
            <a href="https://twitter.com/Otrariam" data-size="large" class="twitter-follow-button" data-show-count="false" data-lang="es">Sigue a @Otrariam</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    </li>   

    <a href="https://github.com/Flash-back/Otrariam" target="_blank" title="Descargar código fuente">
        <li id="menu_github">
            <i class="icon-github"></i>
        </li>
    </a>

    </ul><!--center_nav-->

</nav>
