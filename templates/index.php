<h2 class="content__main-heading">Список задач</h2>
<form class="search-form" action="index.html" method="post">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">
    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
        <a href="/" class="tasks-switch__item">Повестка дня</a>
        <a href="/" class="tasks-switch__item">Завтра</a>
        <a href="/" class="tasks-switch__item">Просроченные</a>
    </nav>
    <label class="checkbox">
        <a href='?show_completed=<?=$show_complete_tasks?>'>
        <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
        <?php 
        $state="";
        if($show_complete_tasks) {
            $state=" checked";
        };
        echo "<input class='checkbox__input visually-hidden' type='checkbox'$state>";
        ?>
        <!-- <input class="checkbox__input visually-hidden" type="checkbox">-->
            <span class="checkbox__text">Показывать выполненные</span>
        </a>
    </label>
</div>
<table class='tasks'>
<!--показывать следующий тег <tr/>, если переменная равна единице-->
<?php foreach ($tasks as $task):?> 
    <?php
    $taskClass = "";
    if ($task['completed']) {
    $taskClass = ' task--completed';
    } else {
        if (deadlineCheck($task['deadline'])) {
            $taskClass = ' task--important';
        }
    }
    ?>
    <?php if (!$task['completed'] || $show_complete_tasks) :?>
    <tr class='tasks__item task<?php echo $taskClass?>'>
        <td class='task__select'>
            <label class='checkbox task__checkbox'>
                <input class='checkbox__input visually-hidden' type='checkbox' checked>
                <span class='checkbox__text'><?=htmlspecialchars($task['task']);?></span>
            </label>
        </td>
        <td class='task__file'><?=htmlspecialchars($task['fileName'])?></td>
        <td class='task__date'><?php echo $task['deadline']?></td>
    </tr>
    <?php endif; ?>
<?endforeach?>
</table>