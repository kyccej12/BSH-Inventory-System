<?php
	//ini_set("display_errors","On");
	require_once "initDB.php";
	class _init extends myDB {
	
		public $pageNum;
		public $cpass;
		public $exception;
		
		public function _toHrs($_x) {
			return ROUND($_x / 3600,2);
		}
		
		public function renew_timestamp($key,$time) {
			$v = parent::dbquery("update active_sessions set timestamp = '$time' where sessid = '$key';");
			if($v) { return true; }
		}
		
		function getUname($uid) {
			list($name) = parent::getArray("select fullname from user_info where emp_id = '$uid';");
		
			echo $name;
			
		}
		
		function validateKey() {
			$tcur = time();
			
			list($_sess) = parent::getArray("select count(*) from active_sessions where sessid = '$_SESSION[authkey]';");
			if($_sess > 0) {
				list($tstamp) = parent::getArray("select `timestamp` from active_sessions where sessid = '$_SESSION[authkey]';");
				$life = $tcur - $tstamp;
				if($life > 7200) {
					$this->exception = 2;
					unset($_SESSION['userid']);
					unset($_SESSION['authkey']);
					unset($_SESSION['branchid']);
					unset($_SESSION['company']);
					session_destroy();
					parent::dbquery("delete from active_sessions where sessid = '$_SESSION[authkey]';");
				} else {
					if($this->renew_timestamp($_SESSION['authkey'],$tcur) == true) { $this->exception = 0; } else { $this->exception = 3; }
					list($this->cpass) = parent::getArray("select require_change_pass from user_info where emp_id = '$_SESSION[userid]';");
				}
			} else {
				$this->exception = 4;
			}
		}
		
		function generateRandomString($length = 32) {
			return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
		}
		
		function loginError($exception) {
			switch($exception) {
				case "3": echo "There was an error while trying to renew your session. Please contact technical team to resolve this issue."; break;
				case "4": echo "Invalid Session Detected!"; break;
			}
		}
		
		function trailer($module,$action) {
			parent::dbquery("insert ignore into traillog (user_id,`timestamp`,ipaddress,module,`action`) values ('$_SESSION[userid]',now(),'$_SERVER[REMOTE_ADDR]','$module','".mysql_real_escape_string($action)."');");
		}
		
		function initBackground($i) {
			if($i%2==0){ $bgC = "#ededed"; } else { $bgC = "#ffffff"; }
			return $bgC;
		}
				
		function _structInput($a,$b,$c,$d,$e,$f) {
			
			echo "<tr>
					<td width=$b><span class=\"spandix-l\">$a :</span></td>
					<td>
						<input type=\"text\" id=\"$c\" class=\"$d\" style=\"$e\" value = \"$f\" />
					</td>
				</tr>
				<tr><td height=4></td></tr>";
			
		}
		
		function _structMonths($a,$b,$c) {
			$string =  '<tr>
						<td width=35%><span class="spandix-l">Month :</span></td>
						<td>
							<select id="'.$a.'" name="'.$a.'"  class="'.$c.'" style="'.$b.'">
								<option value="01">January</option>
								<option value="02">February</option>
								<option value="03">March</option>
								<option value="04">April</option>
								<option value="05">May</option>
								<option value="06">June</option>
								<option value="07">July</option>
								<option value="08">August</option>
								<option value="09">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
							</select>
						</td>
					</tr>
					<tr><td height=4></td></tr>
			    ';
				
			echo $string;
		}
		
		function _structYear($a,$b,$c,$d,$e) {
			echo '<tr>
					<td width='.$b.' valign=top><span class="spandix-l">'.$a.' :</span></td>
					<td>
						<select id="'.$c.'" class="'.$d.'" '.$e.'>';
							$cy = date('Y');
							for($x=$cy;$x>=2018;$x--){
								echo "<option value=$x>$x</option>";
							}							
					echo '</select>
					</td>
				</tr>
				<tr><td height=4></td></tr>';
		}
		
				function _month($dig) {
			switch($dig) {
				case "01": return "January"; break; case "02": return "February"; break; case "03": return "March"; break; case "04": return "April"; break;
				case "05": return "May"; break; case "06": return "June"; break; case "07": return "July"; break; case "08": return "August"; break;
				case "09": return "September"; break; case "10": return "October"; break; case "11": return "November"; break; case "12": return "December"; break;
			}
		}
		
		function getContactName($id) {
			list($cname) = parent::getArray("select tradename from contact_info where file_id = '$id';");
			return $cname;
		}
		
		function identUnit($abbrv) {
			list($unit) = parent::getArray("select UCASE(description) from options_units where unit = '$abbrv';");
			return $unit;
		}

		function formatDate($date) {
			$date = explode("/",$date);
			return $date[2]."-".$date[0]."-".$date[1];
		}
		
		function formatDigit($dig) {
			return preg_replace('/,/','',$dig);
		}

		function inWords($number) {
			$hyphen      = ' ';
			$conjunction = ' ';
			$separator   = ' ';
			$negative    = 'negative ';
			$decimal     = ' point ';
			$dictionary  = array(
				0                   => 'zero',
				1                   => 'one',
				2                   => 'two',
				3                   => 'three',
				4                   => 'four',
				5                   => 'five',
				6                   => 'six',
				7                   => 'seven',
				8                   => 'eight',
				9                   => 'nine',
				10                  => 'ten',
				11                  => 'eleven',
				12                  => 'twelve',
				13                  => 'thirteen',
				14                  => 'fourteen',
				15                  => 'fifteen',
				16                  => 'sixteen',
				17                  => 'seventeen',
				18                  => 'eighteen',
				19                  => 'nineteen',
				20                  => 'twenty',
				30                  => 'thirty',
				40                  => 'forty',
				50                  => 'fifty',
				60                  => 'sixty',
				70                  => 'seventy',
				80                  => 'eighty',
				90                  => 'ninety',
				100                 => 'hundred',
				1000                => 'thousand',
				1000000             => 'million',
				1000000000          => 'billion',
				1000000000000       => 'trillion',
				1000000000000000    => 'quadrillion',
				1000000000000000000 => 'quintillion'
			);
			
			if (!is_numeric($number)) {
				return false;
			}
			
			if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
				// overflow
				trigger_error(
					'inWords only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
					E_USER_WARNING
				);
				return false;
			}

			if ($number < 0) {
				return $negative . self::inWords(abs($number));
			}
			
			$string = $fraction = null;
			
			if (strpos($number, '.') !== false) {
				list($number, $fraction) = explode('.', $number);
			}
			
			switch (true) {
				case $number < 21:
					$string = $dictionary[$number];
					break;
				case $number < 100:
					$tens   = ((int) ($number / 10)) * 10;
					$units  = $number % 10;
					$string = $dictionary[$tens];
					if ($units) {
						$string .= $hyphen . $dictionary[$units];
					}
					break;
				case $number < 1000:
					$hundreds  = $number / 100;
					$remainder = $number % 100;
					$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
					if ($remainder) {
						$string .= $conjunction . self::inWords($remainder);
					}
					break;
				default:
					$baseUnit = pow(1000, floor(log($number, 1000)));
					$numBaseUnits = (int) ($number / $baseUnit);
					$remainder = $number % $baseUnit;
					$string = self::inWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
					if ($remainder) {
						$string .= $remainder < 100 ? $conjunction : $separator;
						$string .= self::inWords($remainder);
					}
					break;
			}
			
			if (null !== $fraction && is_numeric($fraction)) {
				$string .= $decimal;
				$words = array();
				foreach (str_split((string) $fraction) as $number) {
					$words[] = $dictionary[$number];
				}
				$string .= implode(' ', $words);
			}
			
			return strtoupper($string);
		}
		
		function formatNumber($num, $dec) {
			if($num=='') { $num = 0; }
			if($num < 0) {
				return '('.number_format(abs($num),$dec).')';
			} else {
				return number_format($num,$dec);
			}
		}
		
		 function convert2Short($n) {
			$n = (0+str_replace(",", "", $n));
			if (!is_numeric($n)) return false;
			
			if($n < 0) { $xn = $n * -1; } else { $xn = $n; }
			
			if ($xn > 1000000000000) $xn = round(($xn/1000000000000), 2).'T';
			elseif ($xn > 1000000000) $xn = round(($xn/1000000000), 2).'B';
			elseif ($xn > 1000000) $xn = round(($xn/1000000), 2).'M';
			elseif ($xn > 1000) $xn = round(($xn/1000), 2).'K';
			
			if($n < 0) {
				return '('.$xn.')';
			} else { return $xn; }

		}
		
	}
?>