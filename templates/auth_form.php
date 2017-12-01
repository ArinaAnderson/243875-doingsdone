<div class="modal" >
    <button class="modal__close" type="button" name="button">Закрыть</button>

    <h2 class="modal__heading">Вход на сайт</h2>

    <form class="form" action="/index.php" method="post">
      <div class="form__row">
        <label class="form__label" for="email">E-mail <sup>*</sup></label>

        <input class='form__input
        <?php 
        if (in_array('email', $errors)) {
            echo $mistakeClass;
        }
        ?>'
        type="text" name="email" id="email" value="" placeholder="Введите e-mail">
       
        <?php
        if (in_array('email', $errors)) {
            echo "<p class='form__message'>E-mail введён некорректно</p>";
        }
        ?>
      </div>

      <input  type='hidden' name='action' value='login'>

      <div class="form__row">
        <label class="form__label" for="password">Пароль <sup>*</sup></label>
        <input class='form__input
        <?php 
        if (in_array('password', $errors)) {
            echo $mistakeClass;
        }
        ?>'
        ' type="password" name="password" id="password" value="" placeholder="Введите пароль">
        <?php
        if (in_array('wrong_password', $errors)) {
            echo "<p class='form__message'>Такой пароль не найден</p>";
        }
        ?>
      </div>
      
      <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Войти">
      </div>
    </form>
</div>