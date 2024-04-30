<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Management Asset</title>

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css"> -->
    <!-- <link rel="stylesheet" href="assets/../assets/model-login.css"> -->
    <style>

@import url('https://rsms.me/inter/inter.css');

@font-face {
font-family: 'Inter';
src:
/* url('fonts/Inter-Black.ttf') format('truetype'), */
/* url('fonts/Inter-Bold.ttf') format('truetype'), */
/* url('fonts/Inter-ExtraBold.ttf') format('truetype'), */
/* url('fonts/Inter-ExtraLight.ttf') format('truetype'), */
/* url('fonts/Inter-Light.ttf') format('truetype'), */
url('/assets/fonts/Inter-Medium.ttf') format('truetype'),
url('/assetsfonts/Inter-Regular.ttf') format('truetype'),
url('/assetsfonts/Inter-SemiBold.ttf') format('truetype'),
url('/assetsfonts/Inter-Thin.ttf') format('truetype'),
url('/assetsfonts/Inter-VariableFont_slnt,wght.ttf') format('truetype');

font-weight: 900;

/* Tambahkan format-font lain jika Anda menyertakan format lainnya */
}



  /* ANIMASI MASUK */

  @keyframes transitionIn {
    from{
        opacity: 0;
        /* transform: rotateX(-10deg); */
        padding: 20px;
    }

    to{
        opacity: 1;
        /* transform: rotateX(0); */
        padding: 0px;
    }

  }



  /* ANIMASI MASUK SELESAI */

body {

  animation: transitionIn 0.55s;
    background-color: #31689c;
    font-size: 1.6rem;
    color: #2b3e51;
    background-image: url("/assets/image/guptdi.jpeg");
    background-size: cover;

    background-repeat: no-repeat;
    background-size: 1427px 795px;
    background-position: -60px;
    display: flex;
    justify-content: center;
    align-items: center;

  }
  #login-form-wrap {
    /* background-color: #fff; */
      background-color: whitesmoke;
    width: fit-content;
    opacity: 0.95;
    margin: 30px auto;
    text-align: center;
    padding: 20px 30px 20px 30px;
    border-radius: 1rem;
    box-shadow: 0px 30px 50px 0px rgba(0, 0, 0, 0.2);
    margin-top: 70px;
  }

  label{
    font-size: 16px;
  }



    </style>

    <link rel="stylesheet" href="/assets/Bootstrap/css/bootstrap.min.css">
</head>
<body>
    <form method="post" action="/loginrequest">
      @csrf
      <div class="wrapper-login" style="font-family: 'Inter';">



        <div id="login-form-wrap">

          <div class="logo-home">
            <img src="assets/image/logoptdicrop.png" alt="LOGO" width="120px">
          </div>

          <h4 class="ps-3 pt-3 pe-3">Management Asset</h4>
          <h6 class="pb-3">Learning Center</h6>
          <div>

            <table>
                <div class="form-group">
                <tr>
                    <td style="padding: 10px;">Username</td>
                    <td>
                        <input class="form-control mb-2" type="text" id="username" name="username" placeholder="Username" required>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;">Password</td>
                    <td>
                        <input class="form-control mb-2" type="password" id="password" name="password" placeholder="Password" required></td>
                </tr>

                @if(session()->has('Login Gagal'))
        <div class="alert bg-danger text-light alert-dismissible fade show">
          {{ session('Login Gagal') }}
          <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="close"></button>
        </div>
      @endif
            </div>
            </table>





          </div>



            <button type="submit" id="login" class="btn btn-success m-2">
                Login
            </button>


          <div id="create-account-wrap">
            <p style="color: black;">Belum Memiliki Akun ? <a href=register/register-siswa.php?page=dash>Daftar disini</a><p>
          </div>
        </div>

      </div>
    </form>
</body>
</html>
