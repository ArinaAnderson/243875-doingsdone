﻿                <h2 class="content__main-heading">Список задач</h2>

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
                        <a href="/">
                            <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
                            <?php 
                              $state="";

                              if($show_complete_tasks) {$state=" checked";}

                              echo "<input class='checkbox__input visually-hidden' type='checkbox'$state>";
                            ?>
                         <!-- <input class="checkbox__input visually-hidden" type="checkbox">-->
                            <span class="checkbox__text">Показывать выполненные</span>
                        </a>
                    </label>
                </div>
                
                <table class='tasks'>
                    <!--показывать следующий тег <tr/>, если переменная равна единице-->
                    <?php foreach ($tasks as $valueTask):?> 
                        <?php
                        $taskDeadlineTs = strtotime((string)$valueTask['deadline']);
                        $daysUntilDeadline = round(($taskDeadlineTs-time())/(3600*24), 0, PHP_ROUND_HALF_DOWN);
                        $taskClass = "";

                        if ($valueTask['completed']) {
                            $taskClass = ' task--completed';
                        } else {
                            if ((!empty($valueTask['deadline'])) && ($daysUntilDeadline <= 0)) {
                                    $taskClass = ' task--important';
                            }
                        }
                        ?>

                    <?php if (!$valueTask['completed'] || $show_complete_tasks) :?>
                           
                    <tr class='tasks__item task<?php echo $taskClass?>'>
                        <td class='task__select'>
                            <label class='checkbox task__checkbox'>
                                <input class='checkbox__input visually-hidden' type='checkbox' checked>
                                <span class='checkbox__text'><?php echo $valueTask['task']?></span>
                            </label>
                        </td>
                        <td class='task__file'></td>
                        <td class='task__date'><?php echo $valueTask['deadline']?></td>
                    </tr>
                    <?php endif; ?>
                    <?endforeach?>
                </table>