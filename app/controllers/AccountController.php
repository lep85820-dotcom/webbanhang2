<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');

class AccountController {
    private $accountModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    function register(){
        include_once 'app/views/account/register.php';
    }

    public function login() {
        include_once 'app/views/account/login.php';
    }

    function save(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $errors = [];

            if(empty($username)) {
                $errors['username'] = "Vui long nhap userName!";
            }
            if(empty($fullName)) {
                $errors['fullname'] = "Vui long nhap fullName!";
            }
            if(empty($password)) {
                $errors['password'] = "Vui long nhap password!";
            }
            if($password != $confirmPassword) {
                $errors['confirmPass'] = "Mat khau va xac nhan chua dung";
            }

            //kiểm tra username đã được đăng ký chưa?
            $account = $this->accountModel->getAccountByUsername($username);
            if($account) {
                $errors['account'] = "Tai khoan nay da co nguoi dang ky!";
            }

            if(count($errors) > 0){
                include_once 'app/views/account/register.php';
            }else{
                $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                $result = $this->accountModel->save($username, $fullName, $password);
                if($result) {
                    header('Location: /webbanhang/account/login');
                }
            }
        }
    }

    function logout(){
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        header('Location: /webbanhang/product');
    }

    public function checkLogin(){
        // Kiểm tra xem liệu form đã được submit
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $account = $this->accountModel->getAccountByUserName($username);
            
            if ($account) {
                $pwd_hashed = $account->password;
                //check mat khau
                if (password_verify($password, $pwd_hashed)) {
                    session_start();
                    // $_SESSION['user_id'] = $account->id;
                    $_SESSION['user_role'] = $account->role;
                    $_SESSION['username'] = $account->username;
                    $_SESSION['provider'] = 'local';
                    header('Location: /webbanhang/product');
                    exit;
                } else {
                    echo "Password incorrect.";
                }
            } else {
                echo "Bao loi khong tim thay tai khoan";
            }
        }
    }

    public function googleLogin() {
        require_once('app/config/social.php');
        $url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
            'client_id' => GOOGLE_CLIENT_ID,
            'redirect_uri' => GOOGLE_REDIRECT_URI,
            'response_type' => 'code',
            'scope' => 'email profile',
            'access_type' => 'online'
        ]);
        header("Location: $url");
        exit;
    }

    public function googleCallback() {
        require_once('app/config/social.php');
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            // 1. Get access token
            $token_url = 'https://oauth2.googleapis.com/token';
            $data = [
                'code' => $code,
                'client_id' => GOOGLE_CLIENT_ID,
                'client_secret' => GOOGLE_CLIENT_SECRET,
                'redirect_uri' => GOOGLE_REDIRECT_URI,
                'grant_type' => 'authorization_code'
            ];
            
            $options = [
                'http' => [
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data),
                    'ignore_errors' => true
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false
                ]
            ];
            $context = stream_context_create($options);
            $response = @file_get_contents($token_url, false, $context);
            if ($response) {
                $token_data = json_decode($response, true);
                if (isset($token_data['access_token'])) {
                    // 2. Get user info
                    $user_info_url = 'https://www.googleapis.com/oauth2/v2/userinfo';
                    $opts = [
                        'http' => [
                            'header' => "Authorization: Bearer " . $token_data['access_token']
                        ],
                        'ssl' => [
                            'verify_peer' => false,
                            'verify_peer_name' => false
                        ]
                    ];
                    $user_context = stream_context_create($opts);
                    $user_response = @file_get_contents($user_info_url, false, $user_context);
                    if ($user_response) {
                        $user = json_decode($user_response, true);
                        $this->handleSocialLogin($user['email'], $user['id'], 'google');
                        return;
                    }
                } else {
                    echo "Token Error: " . htmlspecialchars($response);
                    return;
                }
            } else {
                echo "Failed to contact Google API.";
                return;
            }
        }
        echo "Google Login Failed. No code parameter.";
    }

    public function githubLogin() {
        require_once('app/config/social.php');
        $url = "https://github.com/login/oauth/authorize?" . http_build_query([
            'client_id' => GITHUB_CLIENT_ID,
            'redirect_uri' => GITHUB_REDIRECT_URI,
            'scope' => 'user:email'
        ]);
        header("Location: $url");
        exit;
    }

    public function githubCallback() {
        require_once('app/config/social.php');
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            // 1. Get access token
            $token_url = 'https://github.com/login/oauth/access_token';
            $data = [
                'client_id' => GITHUB_CLIENT_ID,
                'client_secret' => GITHUB_CLIENT_SECRET,
                'code' => $code,
                'redirect_uri' => GITHUB_REDIRECT_URI
            ];
            
            $options = [
                'http' => [
                    'header' => "Content-type: application/x-www-form-urlencoded\r\nAccept: application/json\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data),
                    'ignore_errors' => true
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false
                ]
            ];
            $context = stream_context_create($options);
            $response = @file_get_contents($token_url, false, $context);
            
            if ($response) {
                $token_data = json_decode($response, true);
                if (isset($token_data['access_token'])) {
                    // 2. Get user info
                    $user_info_url = 'https://api.github.com/user';
                    $opts = [
                        'http' => [
                            'header' => "Authorization: Bearer " . $token_data['access_token'] . "\r\nUser-Agent: WebBanHangApp\r\n",
                            'ignore_errors' => true
                        ],
                        'ssl' => [
                            'verify_peer' => false,
                            'verify_peer_name' => false
                        ]
                    ];
                    $user_context = stream_context_create($opts);
                    $user_response = @file_get_contents($user_info_url, false, $user_context);
                    
                    if ($user_response) {
                        $user = json_decode($user_response, true);
                        
                        $email = $user['email'] ?? null;
                        if (!$email) {
                            // Fetch emails
                            $emails_url = 'https://api.github.com/user/emails';
                            $emails_response = @file_get_contents($emails_url, false, $user_context);
                            if ($emails_response) {
                                $emails = json_decode($emails_response, true);
                                foreach ($emails as $em) {
                                    if ($em['primary'] && $em['verified']) {
                                        $email = $em['email'];
                                        break;
                                    }
                                }
                            }
                        }
                        
                        if ($email) {
                            $this->handleSocialLogin($email, $user['id'], 'github');
                            return;
                        } else {
                            echo "GitHub User Info Error: Could not extract email.";
                            return;
                        }
                    }
                } else {
                    echo "GitHub Token Error: " . htmlspecialchars($response);
                    return;
                }
            } else {
                echo "Failed to contact GitHub API.";
                return;
            }
        }
        echo "GitHub Login Failed. No code parameter.";
    }

    private function handleSocialLogin($email, $social_id, $provider) {
        $account = null;
        if ($provider === 'google') {
            $account = $this->accountModel->getAccountByGoogleId($social_id);
        } else if ($provider === 'github') {
            $account = $this->accountModel->getAccountByGithubId($social_id);
        }

        if (!$account) {
            $account = $this->accountModel->getAccountByEmail($email);
            if (!$account) {
                // Register new user
                $username = explode('@', $email)[0] . '_' . rand(1000, 9999);
                $google_id = $provider === 'google' ? $social_id : null;
                $github_id = $provider === 'github' ? $social_id : null;
                
                $this->accountModel->createSocialAccount($username, $email, $google_id, $github_id);
                $account = $this->accountModel->getAccountByEmail($email);
            }
        }

        if ($account) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user_role'] = $account->role;
            $_SESSION['username'] = $account->username;
            $_SESSION['provider'] = $provider;
            header('Location: /webbanhang/product');
            exit;
        } else {
            echo "Failed to create or login social account.";
        }
    }
}
?>
