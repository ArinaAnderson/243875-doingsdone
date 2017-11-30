<div class="modal" >
    <button class="modal__close" type="button" name="button">Закрыть</button>

    <h2 class="modal__heading">Вход на сайт</h2>

    <form class="form" action="/index.php" method="post">
      <div class="form__row">
        <label class="form__label" for="email">E-mail <sup>*</sup></label>

        <input class='form__input
        <?php 
        if (in_array('email', $errorsEnter)) {
            echo $mistakeClass;
        }
        ?>'
        type="text" name="email" id="email" value="" placeholder="Введите e-mail">
       
        <?php 
        if (in_array('email', $errorsEnter)) {
            echo "<p class='form__message'>E-mail введён некорректно</p>";
        }
        ?>
        <p class='form__message'>
            <?=$emailMessage;?>
        </p>
      </div>

      <div class="form__row">
        <label class="form__label" for="password">Пароль <sup>*</sup></label>
        <input class="form__input" type="password" name="password" id="password" value="" placeholder="Введите пароль">
       
        <p class='form__message'>
            <?=$passwordMessage;?>
        </p>
      </div>

      <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Войти">
      </div>
    </form>
</div>