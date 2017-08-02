<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('element'))
{
    function convert_money($money)
    {
        $negative = false;
        if($money < 0) {
            $negative = true;
            $money = $money*(-1);
        }
        
        $decimal = '00';
        if(strpos($money, '.')) {
            $decimal = $money - floor($money);
            $decimal = number_format($decimal, 2);
            $decimal = explode('.', $decimal)[1];
            $money = floor($money);
        }
        
        $digits = array();
        $m = $money;
        if($m == 0){
            return 0.00;
        }
        while($m > 0) {
            $digits[] = $m%10;
            $m = (int)($m/10);
        }
        
        $money_str = '';
        
        $comma_after = array(3,5,7,9);
        foreach($digits as $key => $digit) {
            if(in_array($key, $comma_after)) {
                $money_str = ','.$money_str;
            }

            $money_str = $digit.$money_str;
        }
        
        if($negative) {
            $money_str = '-'.$money_str;
        }
        return $money_str;
    }
}