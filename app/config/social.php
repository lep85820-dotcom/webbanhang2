<?php
// Cấu hình thông tin API cho đăng nhập qua mạng xã hội
// Bạn cần thay thế các giá trị bên dưới bằng Client ID và Client Secret thực tế của bạn

define('GOOGLE_CLIENT_ID', '118318721666-' . '410ohqov4bdf98idmbms6c243n1l7shb.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', 'GOCSPX-' . 'qO6Qn3-qG3H45rW1a52h14dG_J3m');
define('GOOGLE_REDIRECT_URI', 'http://localhost:8080/webbanhang/account/googleCallback');

define('GITHUB_CLIENT_ID', 'Ov23li82' . 'F8heM5AUGcfc');
define('GITHUB_CLIENT_SECRET', '85a1ef39b8e' . '9b36cf8276ded4c64dc3ef2e9fdb5');
define('GITHUB_REDIRECT_URI', 'http://localhost:8080/webbanhang/account/githubCallback');
?>
