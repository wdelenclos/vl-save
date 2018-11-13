<?php


/* Static Class for Color Value manipulation */

class HSLColorLibrary {
	
	static function rgb2hsl($var_r, $var_g, $var_b) {
		// convert RGB to percentages
		$var_r = $var_r/255;
		$var_g = $var_g/255;
		$var_b = $var_b/255;
	
	  $var_min = min($var_r,$var_g,$var_b);
	  $var_max = max($var_r,$var_g,$var_b);
	  $del_max = $var_max - $var_min;
	  $l = ($var_max + $var_min) / 2;
	  if ($del_max == 0) {
		  $h = 0;
		  $s = 0;
	  }
	  else {
			if ($l < 0.5) 
			{ 
				$s = $del_max / ($var_max + $var_min); 
			}
			else 
			{ 
				$s = $del_max / (2 - $var_max - $var_min); 
			}
			$del_r = ((($var_max - $var_r) / 6) + ($del_max / 2)) / $del_max;
			$del_g = ((($var_max - $var_g) / 6) + ($del_max / 2)) / $del_max;
			$del_b = ((($var_max - $var_b) / 6) + ($del_max / 2)) / $del_max;
			if ($var_r == $var_max) 
			{
				$h = $del_b - $del_g;
			}
			elseif ($var_g == $var_max)  
			{ 
				$h = (1 / 3) + $del_r - $del_b; 
			}
			elseif ($var_b == $var_max)
			{
				$h = (2 / 3) + $del_g - $del_r; 
			}
			if ($h < 0) $h += 1;
			if ($h > 1) $h -= 1;
	  }
	  return array('h'=>$h,'s'=>$s,'l'=>$l);
	}
	
	
	static function hsl2rgb($h2,$s2,$l2) {
		// Input is HSL value of complementary colour, held in $h2, $s, $l as fractions of 1
		// Output is RGB in normal 255 255 255 format, held in $r, $g, $b
		// Hue is converted using function hue_2_rgb, shown at the end of this code
		if ($s2 == 0) {
			$r = $l2 * 255;
			$g = $l2 * 255;
			$b = $l2 * 255;
		}
		else {
			if ($l2 < 0.5) { $var_2 = $l2 * (1 + $s2); }
			else { $var_2 = ($l2 + $s2) - ($s2 * $l2); }
			$var_1 = 2 * $l2 - $var_2;
			$r = round(255 * self::hue_2_rgb($var_1,$var_2,$h2 + (1 / 3)));
			$g = round(255 * self::hue_2_rgb($var_1,$var_2,$h2));
			$b = round(255 * self::hue_2_rgb($var_1,$var_2,$h2 - (1 / 3)));
		}
	  return array('r' => $r, 'g' => $g, 'b' => $b);
	}
	
	static function hue_2_rgb($v1,$v2,$vh) {
		// Function to convert hue to RGB, called from above
		if ($vh < 0) { $vh += 1; };
		if ($vh > 1) { $vh -= 1; };
		if ((6 * $vh) < 1) { return ($v1 + ($v2 - $v1) * 6 * $vh); };
		if ((2 * $vh) < 1) { return ($v2); };
		if ((3 * $vh) < 2) { return ($v1 + ($v2 - $v1) * ((2 / 3 - $vh) * 6)); };
		return ($v1);
	}
	
	static function get_light_color($hexcolor, $lightness = 0.97) 
	{
	  // $r, $g and $b are the three decimal fractions to be input to our RGB-to-HSL conversion routine
	  $r = hexdec(substr($hexcolor,0,2));
	  $g = hexdec(substr($hexcolor,2,2));
	  $b = hexdec(substr($hexcolor,4,2));
	
		$hsl = self::rgb2hsl($r, $g, $b);
	
		// get ligther color
		$hsl['l'] = $lightness;
	
		$rgb = self::hsl2rgb($hsl['h'], $hsl['s'], $hsl['l']);
	
	  $rhex = str_pad(dechex($rgb['r']), 2, "0", STR_PAD_LEFT);
	  $ghex = str_pad(dechex($rgb['g']), 2, "0", STR_PAD_LEFT);
	  $bhex = str_pad(dechex($rgb['b']), 2, "0", STR_PAD_LEFT);
		return $rhex.$ghex.$bhex;
	}		

}

?>