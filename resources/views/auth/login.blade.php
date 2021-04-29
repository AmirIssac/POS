

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="{{asset('css/login.css')}}">
</head>
<body>
    
    <div class="container">
        <div class="screen">
            <div class="screen__content">
                <form method="POST" action="{{ route('login') }}" class="login">
                    @csrf
                    <div class="login__field">
                        <i class="login__icon fas fa-user"></i>
    
                        <input id="email" type="email" name="email" class="login__input" placeholder="اسم الحساب">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                    <div class="login__field">
                        <i class="login__icon fas fa-lock"></i>
                        <input id="password" type="password" name="password" class="login__input" placeholder="كلمة المرور">
                        @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div>
                    <button type="submit" class="button login__submit">
                        <span class="button__text">تسجيل الدخول</span>
                        <i class="button__icon fas fa-chevron-right"></i>
                    </button>				
                </form>
               
            </div>
            <div class="screen__background">
                <span class="screen__background__shape screen__background__shape4"></span>
                <span class="screen__background__shape screen__background__shape3"></span>		
                <span class="screen__background__shape screen__background__shape2"></span>
                <span class="screen__background__shape screen__background__shape1"></span>
            </div>		
        </div>
    </div>
</body>
</html>