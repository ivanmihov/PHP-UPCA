<?php
/*
 * Simple UPC-A Number Generator
 *
 * @author Ivan Mihov (mihovim@gmail.com)
 *
 *
 * UPC-A: 
 *	1st digit - code type
 *	2nd - 6th digit - Manufacturer code
 *	7th - 11th digit - Product code
 *	12th digit - check digit
 *
 *	Suppose that you want to find the check digit of UPC-A number 72641217542.
 *	
 *	1. From the right to the left, start with odd position, assign the odd/even position to each digit.
 *	2. Sum all digits in odd position and multiply the result by 3: (7+6+1+1+5+2)*3=66
 *	3. Sum all digits in even position: (2+4+2+7+4)=19
 *	4. Sum the results of step three and four: 66+19=85
 *	5. Divide the result of step four by 10. The check digit is the number which adds the remainder to 10. 
 *     In our case, divide 85 by 10 we get the remainder 5. The check digit then is the result of 10-5=5. 
 *     If there is no remainder then the check digit equals zero.
 */

?>

<?php
function UPCA() {

	$odd_sum = $even_sum = 0;
	
	/* 
	 * First UPC-A digit
	 * 0	Regular UPC codes
	 * 1	Reserved
	 * 2	Weight items marked at the store
	 * 3	National Drug/Health-related code
	 * 4	No format restrictions, in-store use on non-food items
	 * 5	Coupons
	 * 6	Reserved
	 * 7	Regular UPC codes
	 * 8	Reserved
	 * 9	Reserved
	 */
	$digits[1] = 0;
	
	// Manufacturer 5 digit code
	$digits[2] = 9;
	$digits[3] = 9;
	$digits[4] = 9;
	$digits[5] = 9;
	$digits[6] = 9;
	
	// Fill the rest 5 digits (product code) with random values
	for ($i = 7; $i < 12; $i++) {
		$digits[$i] = rand(0,9);
	}
	
	// Loop to sum the digits with odd and even positions
	for ($j = 1; $j < 12; $j++) {
		if($j % 2 == 0) {
			//sum the digits with even position
	                $even_sum += $digits[$j];
		}
	        else {
			//sum the digits with odd position
	                $odd_sum += $digits[$j];
		}
	}
	
	// Multiply the odd sum by 3
	$odd_sum = (3 * $odd_sum);
	
	// Add the odd and even sums
	$total_sum = $odd_sum + $even_sum;
	
	// Devide the total sum by 10 and get the remainder
	$result = $total_sum % 10;
	
	// If the result is 0, this is the check digit, else
	// subtract the result from 10 and use this as the check digit
	if( $result == 0 ) {
		$check_digit = 0;
	} else {
		$check_digit = 10 - $result;
	}
	
	// Set the check digit as the last barcode digit
	$digits[$j] = $check_digit;

	// Create the UPC code
    $upca = array('upca' => implode('',$digits));

    return json_encode($upca);
}

echo UPCA();

?>
