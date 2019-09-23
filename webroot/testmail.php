<?php
$txt = "First line of text\nSecond line of text";

// Use wordwrap() if lines are longer than 70 characters
$txt = wordwrap($txt,70);

// Send email
mail("dave@winthehunt.com","My subject",$txt);
?> 