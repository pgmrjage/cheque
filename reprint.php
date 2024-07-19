<?php
require "database.php";

function amountToWords($number) {
    // Array of words for numbers 0 to 19
    $words = array(
        0 => 'Zero', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 
        5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 
        14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen', 
        18 => 'Eighteen', 19 => 'Nineteen'
    );

    // Array of words for tens multiples
    $words_tens = array(
        2 => 'Twenty', 3 => 'Thirty', 4 => 'Forty', 5 => 'Fifty', 
        6 => 'Sixty', 7 => 'Seventy', 8 => 'Eighty', 9 => 'Ninety'
    );

    // Scale words (thousand, million, billion, etc.)
    $scale = array('', 'Thousand', 'Million', 'Billion', 'Trillion');

    // Check if number is zero
    if ($number == 0) {
        return 'Zero Pesos Only';
    }

    // Split the number into the integer part and the decimal part
    $parts = explode(".", number_format($number, 2, ".", ""));
    $integer_part = $parts[0];
    $decimal_part = isset($parts[1]) ? $parts[1] : '00';

    // Break the integer part into groups of three digits
    $chunks = array_reverse(str_split(str_pad($integer_part, ceil(strlen($integer_part)/3)*3, '0', STR_PAD_LEFT), 3));

    // Initialize result array for integer part
    $result_integer = array();

    // Iterate over each chunk
    foreach ($chunks as $key => $chunk) {
        // Initialize parts array
        $parts = array();

        // Split the chunk into hundreds, tens, and units
        $hundreds = floor($chunk / 100);
        $tens_units = $chunk % 100;

        // Convert hundreds place to words if greater than zero
        if ($hundreds > 0) {
            $parts[] = $words[$hundreds] . ' Hundred';
        }

        // Convert tens and units place to words if greater than zero
        if ($tens_units > 0) {
            if ($tens_units < 20) {
                $parts[] = $words[$tens_units];
            } else {
                $tens = floor($tens_units / 10);
                $units = $tens_units % 10;
                $parts[] = $words_tens[$tens];
                if ($units > 0) {
                    $parts[] = $words[$units];
                }
            }
        }

        // Append scale word if chunk is not zero
        if (count($parts) > 0) {
            $result_integer[] = implode(' ', $parts) . ' ' . $scale[$key];
        }
    }

    // Combine the result parts for integer part
    $integer_words = implode(' ', array_reverse($result_integer)) . ' Pesos Only';

    // Convert the decimal part to words
    $decimal_words = '';
    if ($decimal_part > 0) {
        if ($decimal_part < 20) {
            $decimal_words = $words[$decimal_part];
        } else {
            $tens = floor($decimal_part / 10);
            $units = $decimal_part % 10;
            $decimal_words = $words_tens[$tens];
            if ($units > 0) {
                $decimal_words .= ' ' . $words[$units];
            }
        }
        $decimal_words .= ' Centavos';
    }

    // Combine the integer and decimal parts
    if ($decimal_words) {
        return $integer_words . ' and ' . $decimal_words . ' Only';
    } else {
        return $integer_words . ' Only';
    }
}

