<div class="modal">
    <button class="modal__close" type="button" name="button" enctype="multipart/form-data">Закрыть</button>

    <h2 class="modal__heading">Добавление задачи</h2>

    <form class="form"  action="../index.php" method="post">
        <div class="form__row">
            <label class="form__label" for="name">Название <sup>*</sup></label>
            <p class="form__message">
                <?=$errorMessageArray['name']?>
            </p>
            <input class="form__input<?=$mistakeClassArray['name']?>" type="text" name="name" id="name" value="" placeholder="Введите название">
        </div>

        <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>
            <p class="form__message">
                <?=$errorMessage?>
            </p>
            <p class="form__message">
                <?=$errorMessageArray['project']?>
            </p>
            <select class="form__input form__input--select<?=$mistakeClassArray['project']?>" name="project" id="project">
                <?php foreach ($mainNavigation as $item):?>
                <option value="">
                    <?php
                    if (!($item == 'Все')) {
                        echo $item;
                    }
                    ?>   
                </option>
                <?php endforeach?>
            </select>
        </div>

        <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>
            <p class="form__message">
                <?=$errorMessageArray['date']?>
            </p>
            <input class="form__input form__input--date<?=$mistakeClassArray['date']?>" type="date" name="date" id="date" value="" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
        </div>

        <div class="form__row">
            <label class="form__label" for="preview">Файл</label>

            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="preview" id="preview" value="">

                <label class="button button--transparent" for="preview">
                    <span>Выберите файл</span>
                </label>
            </div>
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
        </div>
    </form>
</div>