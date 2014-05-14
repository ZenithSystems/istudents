<?php
/**
 * Name
 *
 * โปรแกรม สารสนเทศ
 *
 * @package Name
 * @author phoomin , atoms18
 * @copyright Copyright (c) 2557 - 2558
 * @since Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * SHA256
 *
 * SHA256 สำรอง
 *
 * @package Name
 * @subpackage function
 * @category souce
 * @author phoomin , atoms18
 */
class SHA256 {
    public function generate($str) {
        $K = array(
            (int)0x428a2f98, (int)0x71374491, (int)0xb5c0fbcf, (int)0xe9b5dba5,
            (int)0x3956c25b, (int)0x59f111f1, (int)0x923f82a4, (int)0xab1c5ed5,
            (int)0xd807aa98, (int)0x12835b01, (int)0x243185be, (int)0x550c7dc3,
            (int)0x72be5d74, (int)0x80deb1fe, (int)0x9bdc06a7, (int)0xc19bf174,
            (int)0xe49b69c1, (int)0xefbe4786, (int)0x0fc19dc6, (int)0x240ca1cc,
            (int)0x2de92c6f, (int)0x4a7484aa, (int)0x5cb0a9dc, (int)0x76f988da,
            (int)0x983e5152, (int)0xa831c66d, (int)0xb00327c8, (int)0xbf597fc7,
            (int)0xc6e00bf3, (int)0xd5a79147, (int)0x06ca6351, (int)0x14292967,
            (int)0x27b70a85, (int)0x2e1b2138, (int)0x4d2c6dfc, (int)0x53380d13,
            (int)0x650a7354, (int)0x766a0abb, (int)0x81c2c92e, (int)0x92722c85,
            (int)0xa2bfe8a1, (int)0xa81a664b, (int)0xc24b8b70, (int)0xc76c51a3,
            (int)0xd192e819, (int)0xd6990624, (int)0xf40e3585, (int)0x106aa070,
            (int)0x19a4c116, (int)0x1e376c08, (int)0x2748774c, (int)0x34b0bcb5,
            (int)0x391c0cb3, (int)0x4ed8aa4a, (int)0x5b9cca4f, (int)0x682e6ff3,
            (int)0x748f82ee, (int)0x78a5636f, (int)0x84c87814, (int)0x8cc70208,
            (int)0x90befffa, (int)0xa4506ceb, (int)0xbef9a3f7, (int)0xc67178f2
        );
        $binStr = $this->_char_pad($str);
        $M = $this->_str_split($binStr, 64);
        $h[0] = (int)0x6a09e667;
        $h[1] = (int)0xbb67ae85;
        $h[2] = (int)0x3c6ef372;
        $h[3] = (int)0xa54ff53a;
        $h[4] = (int)0x510e527f;
        $h[5] = (int)0x9b05688c;
        $h[6] = (int)0x1f83d9ab;
        $h[7] = (int)0x5be0cd19;
        for($i = 0; $i < count($M); $i++) {
            $MI = $this->_int_split($M[$i]);
            $_a = (int)$h[0];
            $_b = (int)$h[1];
            $_c = (int)$h[2];
            $_d = (int)$h[3];
            $_e = (int)$h[4];
            $_f = (int)$h[5];
            $_g = (int)$h[6];
            $_h = (int)$h[7];
            unset($_s0);
            unset($_s1);
            unset($_T1);
            unset($_T2);
            $W = array();
            for($t = 0; $t < 16; $t++) {
                $W[$t] = $MI[$t];
                $_T1 = $this->_addmod2n($this->_addmod2n($this->_addmod2n($this->_addmod2n($_h, $this->_Sigma1($_e)), $this->_Ch($_e, $_f, $_g)), $K[$t]), $W[$t]);
                $_T2 = $this->_addmod2n($this->_Sigma0($_a), $this->_Maj($_a, $_b, $_c));
                $_h = $_g; $_g = $_f; $_f = $_e; $_e = $this->_addmod2n($_d, $_T1);
                $_d = $_c; $_c = $_b; $_b = $_a; $_a = $this->_addmod2n($_T1, $_T2);
            }
            for (; $t < 64; $t++) {
                $_s0 = $W[($t + 1) & 0x0F];
                $_s0 = $this->_sigma_0($_s0);
                $_s1 = $W[($t + 14) & 0x0F];
                $_s1 = $this->_sigma_1($_s1);
                $W[$t & 0xF] = $this->_addmod2n($this->_addmod2n($this->_addmod2n($W[$t & 0xF], $_s0), $_s1), $W[($t + 9) & 0x0F]);
                $_T1 = $this->_addmod2n($this->_addmod2n($this->_addmod2n($this->_addmod2n($_h, $this->_Sigma1($_e)), $this->_Ch($_e, $_f, $_g)), $K[$t]), $W[$t & 0xF]);
                $_T2 = $this->_addmod2n($this->_Sigma0($_a), $this->_Maj($_a, $_b, $_c));
                $_h = $_g; $_g = $_f; $_f = $_e; $_e = $this->_addmod2n($_d, $_T1);
                $_d = $_c; $_c = $_b; $_b = $_a; $_a = $this->_addmod2n($_T1, $_T2);
            }
            $h[0] = $this->_addmod2n($h[0], $_a);
            $h[1] = $this->_addmod2n($h[1], $_b);
            $h[2] = $this->_addmod2n($h[2], $_c);
            $h[3] = $this->_addmod2n($h[3], $_d);
            $h[4] = $this->_addmod2n($h[4], $_e);
            $h[5] = $this->_addmod2n($h[5], $_f);
            $h[6] = $this->_addmod2n($h[6], $_g);
            $h[7] = $this->_addmod2n($h[7], $_h);
        }
        $hexStr = sprintf("%08x%08x%08x%08x%08x%08x%08x%08x", $h[0], $h[1], $h[2], $h[3], $h[4], $h[5], $h[6], $h[7]);
        return $hexStr;
    }

    private function _str_split($string, $split_length = 1) {
        $sign = (($split_length < 0) ? -1:1);
        $strlen = strlen($string);
        $split_length = abs($split_length);
        if(($split_length == 0) || ($strlen == 0)) {
            $result = false;
        } else if($split_length >= $strlen) {
            $result[] = $string;
        } else {
            $length = $split_length;
            for($i = 0; $i < $strlen; $i++) {
                $i = (($sign < 0) ? $i + $length:$i);
                $result[] = substr($string, $sign * $i, $length);
                $i--;
                $i = (($sign < 0) ? $i:$i + $length);
                if(($i + $split_length) > ($strlen)) {
                    $length = $strlen - ($i + 1);
                } else {
                    $length = $split_length;
                }
            }
        }
        return $result;
    }

    private function _char_pad($str) {
        $tmpStr = $str;
        $l = strlen($tmpStr) * 8;
        $tmpStr .= "\x80";
        $k = (512 - (($l + 8 + 64) % 512)) / 8;
        $k += 4;
        for($x = 0; $x < $k; $x++) {
            $tmpStr .= "\0";
        }
        $tmpStr .= chr((($l >> 24) & 0xFF));
        $tmpStr .= chr((($l >> 16) & 0xFF));
        $tmpStr .= chr((($l >> 8) & 0xFF));
        $tmpStr .= chr(($l & 0xFF));
        return $tmpStr;
    }

    private function _addmod2n($x, $y, $n = 4294967296) {
        $mask = 0x80000000;
        if($x < 0) {
            $x &= 0x7FFFFFFF;
            $x = (float)$x + $mask;
        }
        if($y < 0) {
            $y &= 0x7FFFFFFF;
            $y = (float)$y + $mask;
        }
        $r = $x + $y;
        if($r >= $n) {
            while($r >= $n) {
                $r -= $n;
            }
        }
        return (int)$r;
    }

    private function _SHR($x, $n) {
        if($n >= 32) {
            return (int)0;
        }
        if($n <= 0) {
            return (int)$x;
        }
        $mask = 0x40000000;
        if($x < 0) {
            $x &= 0x7FFFFFFF;
            $mask = $mask >> ($n - 1);
            return ($x >> $n) | $mask;
        }
        return (int)$x >> (int)$n;
    }

    private function _int_split($input) {
        $l = strlen($input);
        if($l <= 0) {
            return (int)0;
        }
        if(($l % 4) != 0) {
            return false;
        }
        for($i = 0; $i < $l; $i += 4) {
            $int_build  = (ord($input[$i]) << 24);
            $int_build += (ord($input[$i+1]) << 16);
            $int_build += (ord($input[$i+2]) << 8);
            $int_build += (ord($input[$i+3]));
            $result[] = $int_build;
        }
        return $result;
    }

    private function _ROTR($x, $n) {
        return (int)($this->_SHR($x, $n) | ($x << (32 - $n)));
    }

    private function _Ch($x, $y, $z) {
        return ($x & $y) ^ ((~$x) & $z);
    }

    private function _Maj($x, $y, $z) {
        return ($x & $y) ^ ($x & $z) ^ ($y & $z);
    }

    private function _Sigma0($x) {
        return (int)($this->_ROTR($x, 2) ^ $this->_ROTR($x, 13) ^ $this->_ROTR($x, 22));
    }

    private function _Sigma1($x) {
        return (int)($this->_ROTR($x, 6) ^ $this->_ROTR($x, 11) ^ $this->_ROTR($x, 25));
    }

    private function _sigma_0($x) {
        return (int)($this->_ROTR($x, 7) ^ $this->_ROTR($x, 18) ^ $this->_SHR($x, 3));
    }

    private function _sigma_1($x) {
        return (int)($this->_ROTR($x, 17) ^ $this->_ROTR($x, 19) ^ $this->_SHR($x, 10));
    }
}
?>