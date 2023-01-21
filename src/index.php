<?php

if(
  $_SERVER['REQUEST_METHOD'] === 'POST' &
  isset($_POST['server']) &&
  isset($_POST['port']) &&
  isset($_POST['fromName']) &&
  isset($_POST['fromEmail']) &&
  isset($_POST['to']) &&
  isset($_POST['subject']) &&
  isset($_POST['contentType']) &&
  isset($_POST['content'])
){
  include_once __DIR__ . '/sendmail.php';
  die;
}

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

?>
<!doctype html>
<html lang="es">
  <head>
    <title>SMTP Tester Tool</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/mail.svg" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.1/css/all.min.css" integrity="sha256-rx5u3IdaOCszi7Jb18XD9HSn8bNiEgAqWJbdBvIYYyU=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" integrity="sha256-X7rrn44l1+AUO65h1LGALBbOc5C5bOstSYsNlv9MhT8=" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  </head>
  <style>
    * {
      color: #fff !important;
    }
    input, select, textarea {
      color: #fff !important;
      background-color:#0f111a !important;
    }
  </style>
  <body x-data="alpineData()" style="background-color:#0f111a !important;">

    <style>
      .noselect {
        -webkit-touch-callout: none; /* iOS Safari */
          -webkit-user-select: none; /* Safari */
          -khtml-user-select: none; /* Konqueror HTML */
            -moz-user-select: none; /* Old versions of Firefox */
              -ms-user-select: none; /* Internet Explorer/Edge */
                  user-select: none; /* Non-prefixed version, currently
                                        supported by Chrome, Edge, Opera and Firefox */
      }
    </style>

    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom animate__animated animate__fadeInDown noselect" style="background-color: #252a40 !important;">
      <div class="container">
        <a class="navbar-brand" href="#">
          <img src="img/mail.svg" alt="SMTP Tester">&nbsp;&nbsp;Nauf SMTP Tester
        </a>
      </div>
    </nav>

    <div id="resultAlert" class="my-3"></div>

    <form method="POST" action="<?php echo $actual_link; ?>" enctype="multipart/form-data" name="mailForm" id="mailForm">

      <div class="px-2 animate__animated animate__fadeIn animate__slow noselect">

        <div class="container my-3 bg-light rounded border p-3" style="background-color: #252a40 !important;">
          <h4>SMTP Details</h4>

          <hr class="my-3">

            <div class="row">
              <div class="col-12 col-md-6">

                <div class="form-group form-check">
                  <input type="checkbox" class="form-check-input" id="tls" name="tls">
                  <label class="form-check-label" for="tls">Enable TLS Encryption</label>
                </div>

                <div class="form-group">
                  <label for="server">SMTP Server <span class="text-danger">*</span></label>
                  <input required type="text" class="form-control" name="server" id="server" placeholder="Enter your SMTP server">
                </div>

                <div class="form-group">
                  <label for="port">SMTP Port <span class="text-danger">*</span></label>
                  <input required type="number" class="form-control" name="port" id="port" placeholder="Enter your SMTP port" value="25">
                </div>

              </div>
              <div class="col-12 col-md-6">

                <div class="form-group form-check">
                  <input type="checkbox" class="form-check-input" id="auth" name="auth" x-model="auth">
                  <label class="form-check-label" for="auth">Enable SMTP Auth</label>
                </div>

                <div>
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input x-bind:disabled="!auth" type="text" class="form-control" name="username" id="username" placeholder="Enter the username">
                  </div>

                  <div class="form-group">
                    <label for="password">Password</label>
                    <input x-bind:disabled="!auth" type="password" class="form-control" name="password" id="password" placeholder="Enter the password">
                  </div>
                </div>

              </div>
            </div>

        </div>
      </div>

      <div class="px-2 animate__animated animate__fadeIn animate__slow noselect">
        <div class="container my-3 bg-light rounded border p-3" style="background-color: #252a40 !important;">
          <h4>Compose Email</h4>

          <hr class="my-3">

            <div class="row">
              <div class="col-12 col-md-6">

                <div class="form-group">
                  <label for="fromName">From Name <span class="text-danger">*</span></label>
                  <input required type="text" class="form-control" name="fromName" id="fromName" placeholder="Example" value="Example Jr.">
                </div>

                <div class="form-group">
                  <label for="fromEmail">From Email <span class="text-danger">*</span></label>
                  <input required type="email" class="form-control" name="fromEmail" id="fromEmail" placeholder="from@domain.com" value="from@domain.com">
                </div>

                <div class="form-group">
                  <label for="replyTo">Reply To</label>
                  <input type="email" class="form-control" name="replyTo" id="replyTo" placeholder="reply@example.com">
                </div>

              </div>
              <div class="col-12 col-md-6">

                <div class="form-group">
                  <label for="to">To Email <span class="text-danger">*</span></label>
                  <input required type="email" class="form-control" name="to" id="to" placeholder="to@example.com" value="to@example.com">
                </div>

                <div class="form-group">
                  <label for="cc">CC</label>
                  <input type="text" class="form-control" name="cc" id="cc" placeholder="cc@example.com">
                </div>

                <div class="form-group">
                  <label for="bcc">BCC</label>
                  <input type="text" class="form-control" name="bcc" id="bcc" placeholder="bcc@example.com">
                </div>

              </div>

              <div class="col-12 col-md-6">
                <div class="form-group">
                  <label for="subject">Subject <span class="text-danger">*</span></label>
                  <input required type="text" class="form-control" name="subject" id="subject" placeholder="A Nice Email Subject" value="I'm testing my SMTP server">
                </div>
              </div>

              <div class="col-12 col-md-6">
                <div class="form-group">
                  <label for="contentType">Content Type <span class="text-danger">*</span></label>
                  <select required id="contentType" name="contentType" class="form-control">
                    <option value="html" selected>HTML</option>
                    <option value="text">Plain Text</option>
                  </select>
                </div>
              </div>

              <div class="col-12">
                <div class="form-group">
                  <label for="content">Message <span class="text-danger">*</span></label>
                  <textarea required rows="6" class="form-control" name="content" id="content" placeholder="A Nice Message Content">This is a test message sent from <a href="https://github.com/naufkia/smtp-tester">SMTP Tester</a></textarea>
                </div>

                <div class="form-group">
                  <label for="attachment">Attachment</label>
                  <br>
                  <input type="file" style="background-color: #26293f !important;" name="attachment" id="attachment">
                </div>

                <button type="submit" form="mailForm" class="btn btn-primary btn-block" id="sendEmail" x-bind:disabled="loading">
                  Send Email <i class="fas fa-envelope" x-show="!loading"></i> <i class="fas fa-spinner fa-spin" x-show="loading"></i>
                </button>
              </div>

            </div>

        </div>
      </div>

    </form>

    <script>

      function alpineData() {
        return {
          auth: false,
          loading: false,
          switchLoading() {
            this.loading = !this.loading;
          }
        }
      }

      function showMessage(alertType, message){

        document.body.scrollTop = document.documentElement.scrollTop = 0;
        $('#resultAlert').html('<div class="container alert alert-' + alertType + ' animate__animated animate__fadeIn" role="alert">' + message + '</div>');
        var el = document.querySelectorAll('[x-data]')[0].__x.$data;
        el.switchLoading();

      }

      $(function(){
        $('#mailForm').submit(function(e){

          e.preventDefault();

          var el = document.querySelectorAll('[x-data]')[0].__x.$data;
          if(el.loading){
            console.log('Is loading');
            return;
          };

          el.switchLoading();

          var formData = $(this).serialize();
          var actionURL = $(this).attr('action');

          $.ajax({
            url:actionURL,
            method:"POST",
            data:formData,
            success:function(data){
              if(data.ok){
                showMessage('success', 'Message sent successfully!')
              }else{
                showMessage('danger', 'An error with code ' + data.code + ' ocurred: ' + data.error)
              }
            },
            error:function(data){
              if(data.ok){
                showMessage('success', 'Message sent successfully!')
              }else{
                showMessage('danger', 'An error with code ' + data.code + ' ocurred: ' + data.error)
              }
            }
          });

        });
      });

    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.1/js/fontawesome.min.js" integrity="sha256-TMRxGf3NaZhrxTfD8y/NGiyE4UXBA3udH1l+Co8JDVU=" crossorigin="anonymous"></script>
  </body>
</html>