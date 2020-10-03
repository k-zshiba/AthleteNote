<?php
function h($str){
    return htmlspecialchars($str,ENT_QUOTES|ENT_HTML5,'UTF-8');
}