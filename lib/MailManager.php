<?php
class MailManager
{
  #-----------------------------------------------------------------------------
  public function registrationMail($p_email, $p_name, $p_token)
  {
    $subject = 'Aktywacja konta';

    $message = '<html>
                  <head>
                    <title>Aktywacja konta</title>
                  </head>
                  <body>
                    <h1>Witaj '.$p_name.'</h1>

                    <p>
                    Aby aktywowac Twoje konto prosimy o kliknięcie w ten <a href="http://localhost/Karol/active.php?token='.$p_token.'">link</a>
                    </p>

                  </body>
                </html>';

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <Loftowa>' . "\r\n";

    if (!mail($p_email,$subject,$message,$headers))
    {
      echo '<div class="message message-error">Wysłanie wiadomości nie powidoło się. Skontaktuj się z administratorem systemu.</div>';
    }
  }
  #-----------------------------------------------------------------------------
  public function forgotMail($p_email, $p_password)
  {
    $subject = 'Reset hasła';

    $message = '<html>
                  <head>
                    <title>Reset hasła</title>
                  </head>
                  <body>
                    <h1>Twoje hasło zostało zmienione</h1>

                    <p>
                    Twoje nowe hasło to <strong>'.$p_password.'</strong>
                    </p>

                  </body>
                </html>';

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <Loftowa>' . "\r\n";

    if (!mail($p_email,$subject,$message,$headers))
    {
      echo '<div class="message message-error">Wysłanie wiadomości nie powidoło się. Skontaktuj się z administratorem systemu.</div>';
    }
  }
  #-----------------------------------------------------------------------------
  public function loginMail ($p_email)
  {
    $subject = 'Pomyślne logowanie w serwise Loftowa';

    $message = '<html>
                  <head>
                    <title>Aktywacja konta</title>
                  </head>
                  <body>
                    <h1>Pomyślne logowwanie w serwisie Loftowa</h1>

                    <p>
                    Nasz system wykrył logowanie Twojego konta. Jeżeli to nie byłeś Ty zmień zresetuj hasło.
                    </p>

                  </body>
                </html>';

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <Loftowa>' . "\r\n";

    if (!mail($p_email,$subject,$message,$headers))
    {
      echo '<div class="message message-error">Wysłanie wiadomości nie powidoło się. Skontaktuj się z administratorem systemu.</div>';
    }
  }
  #-----------------------------------------------------------------------------
  public function reservationMail ($p_email, $number, $date, $start, $end)
  {
    $subject = 'Pomyślna rezerwacja stolika';

    $message = '<html>
                  <head>
                    <title>Rezerwacja stolika</title>
                  </head>
                  <body>
                    <h1>Pomyślnie zarezerwowano stolik w restauracji Loftowa</h1>

                    <table>
                      <tr>
                        <td>Numer stolika</td>
                        <td>'.$number.'</td>
                      </tr>
                      <tr>
                        <td>Data rezerwacji</td>
                        <td>'.$date.'</td>
                      </tr>
                      <tr>
                        <td>Godzina rozpoczęcia</td>
                        <td>'.$start.'</td>
                      </tr>
                      <tr>
                        <td>Godzina zakończenia</td>
                        <td>'.$end.'</td>
                      </tr>
                    </table>
                  </body>
                </html>';

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <Loftowa>' . "\r\n";

    if (!mail($p_email,$subject,$message,$headers))
    {
      echo '<div class="message message-error">Wysłanie wiadomości nie powidoło się. Skontaktuj się z administratorem systemu.</div>';
    }
  }
  #-----------------------------------------------------------------------------
}
?>
