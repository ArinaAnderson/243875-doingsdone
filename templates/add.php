<div class="modal">
    <button class="modal__close" type="button" name="button" >Закрыть</button>

    <h2 class="modal__heading">Добавление задачи</h2>

    <form class="form"  action="/index.php" method="post" enctype="multipart/form-data">
        <div class="form__row">
            <label class="form__label" for="name">Название <sup>*</sup></label>
            <?php if (in_array('name', $errors)):?>
            <p class="form__message">
                <?=$errorMessage?>
            </p>
            <?php endif; ?>
            <input class='form__input
            <?php 
            if (in_array('name', $errors)) {
                echo $mistakeClass;
            }
            ?>'
            type="text" name="name" id="name" value="<?=$nameValue;?>" placeholder="Введите название">
        </div>

        <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>
            <?php if (in_array('project', $errors)):?>
            <p class="form__message">
                <?=$errorMessage?>
            </p>
            <?php endif; ?>
            <select class='form__input form__input--select
            <?php 
            if (in_array('project', $errors)) {
                echo $mistakeClass;
            }
            ?>'
            name="project" id="project">
                <?php foreach ($mainNavigation as $item):?>
                <?php if (!($item == 'Все')):?>
                <option value="<?=$item?>">
                    <?=$item?>  
                </option>
                <?php endif; ?>
                <?php endforeach?>
            </select>
        </div>
        
        <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>
            <?php if (in_array('date', $errors)):?>
            <p class="form__message">
                <?=$errorMessage?>
            </p>
            <?php endif; ?>
            <input class='form__input form__input--date
            <?php 
            if (in_array('date', $errors)) {
                echo $mistakeClass;
            }
            ?>'
            type="date" name="date" id="date" value="<?=$dateValue;?>" placeholder="Введите дату в формате ДД.ММ.ГГГГ">

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