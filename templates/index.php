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
        <a href='?show_completed=<?=!(intval($show_complete_tasks))?>'>
        <?php 
        $state="";
        if($show_complete_tasks) {
            $state=" checked";
        };
        echo "<input class='checkbox__input visually-hidden' type='checkbox'$state>";
        ?>
            <span class="checkbox__text">Показывать выполненные</span>
        </a>
    </label>
</div>
<table class='tasks'>
<?php foreach ($taskFiltered as $task):?> 
    <?php
    $taskClass = "";
    $taskId = $task['id'];
    if ($task['completed']) {
        $taskClass = ' task--completed';
        $checkedTask = 1;
        if (isset($_GET['complete_task'])) {
            $checkedTask = intval($_GET['complete_task']);
            $sqlComplete = "UPDATE tasks SET completed = '0' WHERE id = '$taskId'";
            $resultComplete = mysqli_query($link, $sqlComplete);
        }
    } else {
        $checkedTask = 0;
        if (isset($_GET['complete_task'])) {
            $checkedTask = intval($_GET['complete_task']);
            $sqlComplete = "UPDATE tasks SET completed = '1' WHERE id = '$taskId'";
            $resultComplete = mysqli_query($link, $sqlComplete);
        }
        if (deadlineCheck($task['deadline'])) {
            $taskClass = ' task--important';
        }
    }
    ?>

    <?php if (!$task['completed'] || $show_complete_tasks) :?>
    <tr class='tasks__item task<?php echo $taskClass?>'>
        <td class='task__select'>
            <label class='checkbox task__checkbox'>
                <input class='checkbox__input visually-hidden' name='completed-task' type='checkbox' 
                <?php
                if ($checkedTask) {
                    $taskChecked = ' checked';
                } else {
                    $taskChecked = '';
                }
                echo $taskChecked;
                ?>
                >
                <a href='?complete_task=<?=!(intval($checkedTask))?>'><span class='checkbox__text'><?=htmlspecialchars($task['name']);?></span></a>
            </label>
        </td>
        <td class='task__file'><?=htmlspecialchars($task['file'])?></td>
        <td class='task__date'><?php echo date('d.m.Y', strtotime($task['deadline']))?></td>
    </tr>
    <?php endif; ?>
<?endforeach?>
</table>