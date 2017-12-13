<h2 class="content__main-heading">Регистрация аккаунта</h2>

          <form class="form" action="index.html" method="post">
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

            <div class="form__row">
              <label class="form__label" for="password">Пароль <sup>*</sup></label>

              <input class="form__input" type="password" name="password" id="password" value="" placeholder="Введите пароль">
            </div>
            
            <input  type='hidden' name='action' value='register'>

            <div class="form__row">
              <label class="form__label" for="name">Имя <sup>*</sup></label>

              <input class="form__input" type="password" name="name" id="name" value="" placeholder="Введите пароль">
            </div>

            <div class="form__row form__row--controls">
            <?php
            if (in_array('email', $errors) || in_array('password', $errors) || in_array('name', $errors)) {//THE WORD
                echo "<p class='error-message'>Пожалуйста, исправьте ошибки в форме</p>";
            }
            ?>

              <input class="button" type="submit" name="" value="Зарегистрироваться">
            </div>
          </form>