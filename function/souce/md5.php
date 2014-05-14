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
 * MD5
 *
 * MD5 สำรอง
 *
 * @package Name
 * @subpackage function
 * @category souce
 * @author phoomin , atoms18
 */
class MD5 {
    public function generate($string) {
        $a = "67452301";
        $b = "efcdab89";
        $c = "98badcfe";
        $d = "10325476";
        
        $A = $a;
        $B = $b;
        $C = $c;
        $D = $d;
        $words = $this->_ConvertToArray($string);
        for ($i = 0; $i <= count($words) / 16 - 1; $i++) {
            $a = $A;
            $b = $B;
            $c = $C;
            $d = $D;
            
            /* ROUND 1 */
            $this->_FF($A, $B, $C, $D, $words[0 + ($i * 16) ], 7, "d76aa478");
            $this->_FF($D, $A, $B, $C, $words[1 + ($i * 16) ], 12, "e8c7b756");
            $this->_FF($C, $D, $A, $B, $words[2 + ($i * 16) ], 17, "242070db");
            $this->_FF($B, $C, $D, $A, $words[3 + ($i * 16) ], 22, "c1bdceee");
            $this->_FF($A, $B, $C, $D, $words[4 + ($i * 16) ], 7, "f57c0faf");
            $this->_FF($D, $A, $B, $C, $words[5 + ($i * 16) ], 12, "4787c62a");
            $this->_FF($C, $D, $A, $B, $words[6 + ($i * 16) ], 17, "a8304613");
            $this->_FF($B, $C, $D, $A, $words[7 + ($i * 16) ], 22, "fd469501");
            $this->_FF($A, $B, $C, $D, $words[8 + ($i * 16) ], 7, "698098d8");
            $this->_FF($D, $A, $B, $C, $words[9 + ($i * 16) ], 12, "8b44f7af");
            $this->_FF($C, $D, $A, $B, $words[10 + ($i * 16) ], 17, "ffff5bb1");
            $this->_FF($B, $C, $D, $A, $words[11 + ($i * 16) ], 22, "895cd7be");
            $this->_FF($A, $B, $C, $D, $words[12 + ($i * 16) ], 7, "6b901122");
            $this->_FF($D, $A, $B, $C, $words[13 + ($i * 16) ], 12, "fd987193");
            $this->_FF($C, $D, $A, $B, $words[14 + ($i * 16) ], 17, "a679438e");
            $this->_FF($B, $C, $D, $A, $words[15 + ($i * 16) ], 22, "49b40821");
            
            /* ROUND 2 */
            $this->_GG($A, $B, $C, $D, $words[1 + ($i * 16) ], 5, "f61e2562");
            $this->_GG($D, $A, $B, $C, $words[6 + ($i * 16) ], 9, "c040b340");
            $this->_GG($C, $D, $A, $B, $words[11 + ($i * 16) ], 14, "265e5a51");
            $this->_GG($B, $C, $D, $A, $words[0 + ($i * 16) ], 20, "e9b6c7aa");
            $this->_GG($A, $B, $C, $D, $words[5 + ($i * 16) ], 5, "d62f105d");
            $this->_GG($D, $A, $B, $C, $words[10 + ($i * 16) ], 9, "2441453");
            $this->_GG($C, $D, $A, $B, $words[15 + ($i * 16) ], 14, "d8a1e681");
            $this->_GG($B, $C, $D, $A, $words[4 + ($i * 16) ], 20, "e7d3fbc8");
            $this->_GG($A, $B, $C, $D, $words[9 + ($i * 16) ], 5, "21e1cde6");
            $this->_GG($D, $A, $B, $C, $words[14 + ($i * 16) ], 9, "c33707d6");
            $this->_GG($C, $D, $A, $B, $words[3 + ($i * 16) ], 14, "f4d50d87");
            $this->_GG($B, $C, $D, $A, $words[8 + ($i * 16) ], 20, "455a14ed");
            $this->_GG($A, $B, $C, $D, $words[13 + ($i * 16) ], 5, "a9e3e905");
            $this->_GG($D, $A, $B, $C, $words[2 + ($i * 16) ], 9, "fcefa3f8");
            $this->_GG($C, $D, $A, $B, $words[7 + ($i * 16) ], 14, "676f02d9");
            $this->_GG($B, $C, $D, $A, $words[12 + ($i * 16) ], 20, "8d2a4c8a");
            
            /* ROUND 3 */
            $this->_HH($A, $B, $C, $D, $words[5 + ($i * 16) ], 4, "fffa3942");
            $this->_HH($D, $A, $B, $C, $words[8 + ($i * 16) ], 11, "8771f681");
            $this->_HH($C, $D, $A, $B, $words[11 + ($i * 16) ], 16, "6d9d6122");
            $this->_HH($B, $C, $D, $A, $words[14 + ($i * 16) ], 23, "fde5380c");
            $this->_HH($A, $B, $C, $D, $words[1 + ($i * 16) ], 4, "a4beea44");
            $this->_HH($D, $A, $B, $C, $words[4 + ($i * 16) ], 11, "4bdecfa9");
            $this->_HH($C, $D, $A, $B, $words[7 + ($i * 16) ], 16, "f6bb4b60");
            $this->_HH($B, $C, $D, $A, $words[10 + ($i * 16) ], 23, "bebfbc70");
            $this->_HH($A, $B, $C, $D, $words[13 + ($i * 16) ], 4, "289b7ec6");
            $this->_HH($D, $A, $B, $C, $words[0 + ($i * 16) ], 11, "eaa127fa");
            $this->_HH($C, $D, $A, $B, $words[3 + ($i * 16) ], 16, "d4ef3085");
            $this->_HH($B, $C, $D, $A, $words[6 + ($i * 16) ], 23, "4881d05");
            $this->_HH($A, $B, $C, $D, $words[9 + ($i * 16) ], 4, "d9d4d039");
            $this->_HH($D, $A, $B, $C, $words[12 + ($i * 16) ], 11, "e6db99e5");
            $this->_HH($C, $D, $A, $B, $words[15 + ($i * 16) ], 16, "1fa27cf8");
            $this->_HH($B, $C, $D, $A, $words[2 + ($i * 16) ], 23, "c4ac5665");
            
            /* ROUND 4 */
            $this->_II($A, $B, $C, $D, $words[0 + ($i * 16) ], 6, "f4292244");
            $this->_II($D, $A, $B, $C, $words[7 + ($i * 16) ], 10, "432aff97");
            $this->_II($C, $D, $A, $B, $words[14 + ($i * 16) ], 15, "ab9423a7");
            $this->_II($B, $C, $D, $A, $words[5 + ($i * 16) ], 21, "fc93a039");
            $this->_II($A, $B, $C, $D, $words[12 + ($i * 16) ], 6, "655b59c3");
            $this->_II($D, $A, $B, $C, $words[3 + ($i * 16) ], 10, "8f0ccc92");
            $this->_II($C, $D, $A, $B, $words[10 + ($i * 16) ], 15, "ffeff47d");
            $this->_II($B, $C, $D, $A, $words[1 + ($i * 16) ], 21, "85845dd1");
            $this->_II($A, $B, $C, $D, $words[8 + ($i * 16) ], 6, "6fa87e4f");
            $this->_II($D, $A, $B, $C, $words[15 + ($i * 16) ], 10, "fe2ce6e0");
            $this->_II($C, $D, $A, $B, $words[6 + ($i * 16) ], 15, "a3014314");
            $this->_II($B, $C, $D, $A, $words[13 + ($i * 16) ], 21, "4e0811a1");
            $this->_II($A, $B, $C, $D, $words[4 + ($i * 16) ], 6, "f7537e82");
            $this->_II($D, $A, $B, $C, $words[11 + ($i * 16) ], 10, "bd3af235");
            $this->_II($C, $D, $A, $B, $words[2 + ($i * 16) ], 15, "2ad7d2bb");
            $this->_II($B, $C, $D, $A, $words[9 + ($i * 16) ], 21, "eb86d391");
            
            $A = $this->_AddUnsigned($this->_hexdec2($A), $this->_hexdec2($a));
            $B = $this->_AddUnsigned($this->_hexdec2($B), $this->_hexdec2($b));
            $C = $this->_AddUnsigned($this->_hexdec2($C), $this->_hexdec2($c));
            $D = $this->_AddUnsigned($this->_hexdec2($D), $this->_hexdec2($d));
        }
        
        $MD5 = $this->_WordToHex($A).$this->_WordToHex($B).$this->_WordToHex($C).$this->_WordToHex($D);
        return $MD5;
    }

    private function _WordToHex($lValue) {
        $WordToHexValue = "";
        for ($lCount = 0; $lCount <= 3; $lCount++) {
            $lByte = ($this->_hexdec2($lValue) >> ($lCount * 8)) & 255;
            $C = dechex($lByte);
            $WordToHexValue .= (strlen($C) == '1') ? "0".dechex($lByte):dechex($lByte);
        }
        return $WordToHexValue;
    }

    private function _F($X, $Y, $Z) {
        $X = $this->_hexdec2($X);
        $Y = $this->_hexdec2($Y);
        $Z = $this->_hexdec2($Z);
        $calc = (($X & $Y) | ((~$X) & $Z));
        return $calc;
    }

    private function _G($X, $Y, $Z) {
        $X = $this->_hexdec2($X);
        $Y = $this->_hexdec2($Y);
        $Z = $this->_hexdec2($Z);
        $calc = (($X & $Z) | ($Y & (~$Z)));
        return $calc;
    }

    private function _H($X, $Y, $Z) {
        $X = $this->_hexdec2($X);
        $Y = $this->_hexdec2($Y);
        $Z = $this->_hexdec2($Z);
        $calc = ($X ^ $Y ^ $Z);
        return $calc;
    }

    private function _I($X, $Y, $Z) {
        $X = $this->_hexdec2($X);
        $Y = $this->_hexdec2($Y);
        $Z = $this->_hexdec2($Z);
        $calc = ($Y ^ ($X | (~$Z)));
        return $calc;
    }

    private function _AddUnsigned($lX, $lY) {
        $lX8 = ($lX & 0x80000000);
        $lY8 = ($lY & 0x80000000);
        $lX4 = ($lX & 0x40000000);
        $lY4 = ($lY & 0x40000000);
        $lResult = ($lX & 0x3FFFFFFF) + ($lY & 0x3FFFFFFF);
        if ($lX4 & $lY4) {
            $res = ($lResult ^ 0x80000000 ^ $lX8 ^ $lY8);
            if ($res < 0) return '-'.dechex(abs($res));
            else return dechex($res);
        }
        if ($lX4 | $lY4) {
            if ($lResult & 0x40000000) {
                $res = ($lResult ^ 0xC0000000 ^ $lX8 ^ $lY8);
                if ($res < 0) return '-'.dechex(abs($res));
                else return dechex($res);
            } else {
                $res = ($lResult ^ 0x40000000 ^ $lX8 ^ $lY8);
                if ($res < 0) return '-'.dechex(abs($res));
                else return dechex($res);
            }
        } else {
            $res = ($lResult ^ $lX8 ^ $lY8);
            if ($res < 0) return '-'.dechex(abs($res));
            else return dechex($res);
        }
    }

    private function _hexdec2($hex, $debug = false) {
        if (substr($hex, 0, 1) == "-") {
            return doubleval('-'.hexdec("0x".str_replace("-", "", $hex)));
        }
        return hexdec("0x".$hex);
    }

    private function _FF(&$A, $B, $C, $D, $M, $s, $t) {
        $Level1 = $this->_hexdec2($this->_AddUnsigned($this->_F($B, $C, $D), bindec($M)));
        $level2 = $this->_hexdec2($this->_AddUnsigned($Level1, $this->_hexdec2($t)));
        $A = $this->_hexdec2($this->_AddUnsigned($this->_hexdec2($A), $level2));
        $A = $this->_rotate($A, $s);
        $A = $this->_AddUnsigned($A, $this->_hexdec2($B));
    }

    private function _GG(&$A, $B, $C, $D, $M, $s, $t) {
        $Level1 = $this->_hexdec2($this->_AddUnsigned($this->_G($B, $C, $D), bindec($M)));
        $level2 = $this->_hexdec2($this->_AddUnsigned($Level1, $this->_hexdec2($t)));
        $A = $this->_hexdec2($this->_AddUnsigned($this->_hexdec2($A), $level2));
        $A = $this->_rotate($A, $s);
        $A = $this->_AddUnsigned($A, $this->_hexdec2($B));
    }

    private function _HH(&$A, $B, $C, $D, $M, $s, $t) {
        $Level1 = $this->_hexdec2($this->_AddUnsigned($this->_H($B, $C, $D), bindec($M)));
        $level2 = $this->_hexdec2($this->_AddUnsigned($Level1, $this->_hexdec2($t)));
        $A = $this->_hexdec2($this->_AddUnsigned($this->_hexdec2($A), $level2));
        $A = $this->_rotate($A, $s);
        $A = $this->_AddUnsigned($A, $this->_hexdec2($B));
    }

    private function _II(&$A, $B, $C, $D, $M, $s, $t) {
        $Level1 = $this->_hexdec2($this->_AddUnsigned($this->_I($B, $C, $D), bindec($M)));
        $level2 = $this->_hexdec2($this->_AddUnsigned($Level1, $this->_hexdec2($t)));
        $A = $this->_hexdec2($this->_AddUnsigned($this->_hexdec2($A), $level2));
        $A = $this->_rotate($A, $s);
        $A = $this->_AddUnsigned($A, $this->_hexdec2($B));
    }

    private function _rotate($decimal, $bits, $debug = false) {
        return (($decimal << $bits) | $this->_shiftright($decimal, (32 - $bits)) & 0xffffffff);
    }

    private function _shiftright($decimal, $right) {
        if ($decimal < 0) {
            $res = decbin($decimal >> $right);
            for ($i = 0; $i < $right; $i++) {
                $res[$i] = "";
            }
            return bindec($res);
        } else {
            return ($decimal >> $right);
        }
    }

    private function _ConvertToArray($string) {
        $lWordCount;
        $lMessageLength = strlen($string);
        $lNumberOfWords_temp1 = $lMessageLength + 8;
        $lNumberOfWords_temp2 = ($lNumberOfWords_temp1 - ($lNumberOfWords_temp1 % 64)) / 64;
        $lNumberOfWords = ($lNumberOfWords_temp2 + 1) * 16;
        $lWordArray = Array("");
        $lBytePosition = 0;
        $lByteCount = 0;
        while ($lByteCount < $lMessageLength) {
            $lWordCount = ($lByteCount - ($lByteCount % 4)) / 4;
            $lBytePosition = ($lByteCount % 4) * 8;
            if (!isset($lWordArray[$lWordCount])) $lWordArray[$lWordCount] = 0;
            $lWordArray[$lWordCount] = ($lWordArray[$lWordCount] | (ord($string[$lByteCount]) << $lBytePosition));
            $lByteCount++;
        }
        $lWordCount = ($lByteCount - ($lByteCount % 4)) / 4;
        $lBytePosition = ($lByteCount % 4) * 8;
        if (!isset($lWordArray[$lWordCount])) $lWordArray[$lWordCount] = 0;
        $lWordArray[$lWordCount] = $lWordArray[$lWordCount] | (0x80 << $lBytePosition);
        $lWordArray[$lNumberOfWords - 2] = $lMessageLength << 3;
        $lWordArray[$lNumberOfWords - 1] = $lMessageLength >> 29;
        for ($i = 0; $i < $lNumberOfWords; $i++) {
            if (isset($lWordArray[$i])) $lWordArray[$i] = decbin($lWordArray[$i]);
            else $lWordArray[$i] = '0';
        }
        return $lWordArray;
    }
}
?>