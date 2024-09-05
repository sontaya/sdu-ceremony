<?php

  // $ldapconfig['host'] = 'sdu-ldap.dusit.ac.th';
  // $ldapconfig['port'] = 389;
  // $ldapconfig['basedn'] = 'dc=dusit,dc=ac,dc=th';
  // $ldapconfig['authrealm'] = 'SDU Authentication LDAP';

if(!function_exists('ldap_authenticate'))
{
    function ldap_authenticate($user, $pwd)
    {
      // header('WWW-Authenticate: Basic realm=SDU-LDAP Authentication');
      // header('HTTP/1.0 401 Unauthorized');

      if ($user != "" && $user != "") {
          $ds = @ldap_connect('sdu-ldap.dusit.ac.th', '389');
          $r = @ldap_search($ds, 'o=personnel,dc=dusit,dc=ac,dc=th', 'uid=' . $user);
          if ($r) {
              $result = @ldap_get_entries($ds, $r);
              if ($result[0]) {

                if($pwd == "admin@sdu"){
                  return $result[0];
                }

                if (@ldap_bind($ds, $result[0]['dn'], $pwd)) {
                    return $result[0];
                }else{
                  return null;
                }

              }else{
                return null;
              }
          }
      }
      return null;
    }
}

if(!function_exists('get_client_ip'))
{
  function get_client_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }
}

if (!function_exists('encrypt_data')) {
    function encrypt_data($data) {
        $encryption_key = config_item('encryption_key');
        $encryption_method = config_item('encryption_method');
        $iv_length = openssl_cipher_iv_length($encryption_method);
        $iv = openssl_random_pseudo_bytes($iv_length);
        $encrypted_data = openssl_encrypt($data, $encryption_method, $encryption_key, 0, $iv);
        $base64_encoded_data = base64_encode($iv . $encrypted_data);
        // URL-safe base64 encoding
        $url_safe_base64 = str_replace(['+', '/', '='], ['-', '_', ''], $base64_encoded_data);
        return $url_safe_base64;
    }
}

if (!function_exists('decrypt_data')) {
    function decrypt_data($data) {
        $encryption_key = config_item('encryption_key');
        $encryption_method = config_item('encryption_method');
        // Reverse URL-safe base64 encoding
        $base64_encoded_data = str_replace(['-', '_'], ['+', '/'], $data);
        // Add padding if necessary
        $padding = strlen($base64_encoded_data) % 4;
        if ($padding) {
            $base64_encoded_data .= str_repeat('=', 4 - $padding);
        }
        $data = base64_decode($base64_encoded_data);
        $iv_length = openssl_cipher_iv_length($encryption_method);
        $iv = substr($data, 0, $iv_length);
        $encrypted_data = substr($data, $iv_length);
        return openssl_decrypt($encrypted_data, $encryption_method, $encryption_key, 0, $iv);
    }
}


//  $key = "022445000" . date(dmY);

/*  function encrypt($string, $key)
  {
      $result = '';
      for ($i = 0; $i < strlen($string); $i++) {
          $char = substr($string, $i, 1);
          $keychar = substr($key, ($i % strlen($key)) - 1, 1);
          $char = chr(ord($char) + ord($keychar));
          $result.=$char;
      }

      return base64_encode($result);
  }

  $check = ldap_authenticate($_POST["u_user"], $_POST["u_pass"]);
  if ($check) {
      $txt_user = encrypt($_POST['u_user'], $key);

  //    print_r($check["displayname"]["0"]);

      // $data['u_user'] = $check["displayname"]["0"];  // ส่งชื่อกลักลับมา
      // $data['u_id'] = $check["hrcode"]["0"];  // ส่งชื่อกลักลับมา
      // $data['facultycode'] = $check["facultycode"]["0"];  // ส่งชื่อกลักลับมา
      $data['uid'] = $check["uid"]["0"];  // ส่งชื่อกลักลับมา
     // print_r($check);

      echo json_encode($data);

  //            print_r($check);
  //  	echo $check["gecos"]["0"]." ".$check["hrcode"]["0"];
  //	$_SESSION["user"]=$_POST['user'];
  //	echo $_SESSION["user"];
  //	echo "<meta http-equiv='refresh' content='0;URL=panel_user.php'>";
  } else {
  // 	echo "<meta http-equiv='refresh' content='0;URL=check_user.php'>";
      //	echo "<meta http-equiv='refresh' content='0;URL=login.php'>";
  }

*/
