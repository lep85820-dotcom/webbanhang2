<?php include 'app/views/shares/header.php'; ?>
<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <form action="/webbanhang/account/checklogin" method="post">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                <p class="text-white-50 mb-5">Please enter your login and password!</p>
                                
                                <div class="form-outline form-white mb-4 text-start">
                                    <label class="form-label" for="username">UserName</label>
                                    <input type="text" id="username" name="username" class="form-control form-control-lg" />
                                </div>
                                
                                <div class="form-outline form-white mb-4 text-start">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control form-control-lg" />
                                </div>
                                
                                <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#!">Forgot password?</a></p>
                                
                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                                
                                <hr class="my-4" style="border-top: 1px solid #666;">
                                <p class="text-white-50">Hoặc đăng nhập bằng:</p>
                                <div class="d-grid gap-3 mt-4 pt-1">
                                    <a href="/webbanhang/account/googleLogin" class="btn btn-danger btn-lg text-white" style="background-color: #dd4b39; border: none;">
                                        <i class="fab fa-google me-2"></i> Đăng nhập bằng Google
                                    </a>
                                    <a href="/webbanhang/account/githubLogin" class="btn btn-dark btn-lg text-white" style="background-color: #333; border: none;">
                                        <i class="fab fa-github me-2"></i> Đăng nhập bằng GitHub
                                    </a>
                                </div>
                            </div>
                            
                            <div>
                                <p class="mb-0">Don't have an account? <a href="/webbanhang/account/register" class="text-white-50 fw-bold">Sign Up</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'app/views/shares/footer.php'; ?>
