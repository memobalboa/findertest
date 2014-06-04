<?php

namespace FinderTest\Blackjack;

class UnknownNonNumericCardException extends \Exception {}
class NumericCardOutOfBoundsException extends \Exception {}

/**
 * @author guillermo
 */
class BlackjackScoreCalculator {
    
    
    public function calculateScore($cardA, $cardB) 
    { 
        $aNumericValue = $this->getCardNumericValue($cardA);
        $bNumericValue = $this->getCardNumericValue($cardB);
        return $aNumericValue + $bNumericValue;
    }
    
    
    private function getCardNumericValue($card) { 
        if(is_numeric($card)) { 
            if(in_array($card, range(2, 10))) {
                return $card;
            } else {
                throw new NumericCardOutOfBoundsException("The card '$card' is out of bounds, bounds are 2..10 inclusive");
            }
        } else {
            $uppercaseCard = strtoupper($card);
            $validNonNumericCards = array(
                'A' => 11, 
                'K' => 10, 
                'Q' => 10, 
                'J' => 10
            );
            if(isset($validNonNumericCards[$uppercaseCard])) { 
                return $validNonNumericCards[$uppercaseCard];
            } else {
                throw new UnknownNonNumericCardException("The non-numeric card '$card' is not valid");
            }
        }
    }
    
}
