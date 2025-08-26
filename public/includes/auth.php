<?php
function password_hash_safe($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

function password_verify_safe($password, $hash) {
    return password_verify($password, $hash);
}
?>
