<?php
//---Universal API ------------
//---created by Alex Petrenko
//---http://petrenkodesign.com
//---petrenkodesign@gmail.com
//-----------------------------
class secfun {
  
  public function jencode($data) {
    $result = json_encode($data);
    //$result = $this->encrypt($result, PASSPHRASE);
    $result = base64_encode($result);
    return $result;
  }
  public function jdecode($data) {
    $result = base64_encode($data);
    $result = $this->decrypt($result, PASSPHRASE);
    $result = json_decode($result);
    return $result;
  }
  
  protected function encrypt($string, $key) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $key, utf8_encode($string), MCRYPT_MODE_ECB, $iv);
    return $encrypted_string;
  }

  protected function decrypt($string, $key) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $key, $string, MCRYPT_MODE_ECB, $iv);
    return $decrypted_string;
  }
  
}
?>
