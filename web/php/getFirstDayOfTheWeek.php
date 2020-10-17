<?php
function getFirstDayOfTheWeek($today) {
    return date('Y-m-d',strtotime($today."last Monday"));
}