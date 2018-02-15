<?php

namespace Jh\Shipping;
/**
 * Class ShippingDates
 * @package Jh\Shipping
 */
class ShippingDates implements ShippingDatesInterface
{
    const DAY_PROMISE = 3;
    const DELIVERY_DAYS = array(WeekDays::Monday, WeekDays::Tuesday, WeekDays::Wednesday, WeekDays::Thursday, WeekDays::Friday);
    const DISPATCH_DAYS = self::DELIVERY_DAYS;
    
    /**
    * Method calculateDeliveryDate
    * @param orderDate
    * @return deliveryDate
    */
    public function calculateDeliveryDate(\DateTime $orderDate){
        $i = 0;

        //add to date until it can be dispatched.
        while(!in_array($orderDate->format('w'), self::DISPATCH_DAYS)){
            $orderDate->modify("+1 day");
        }
        //time to attempt delivery
        while( $i < self::DAY_PROMISE ){
            $orderDate->modify("+1 day");
            //if it is possible to deliver then add one to counter until 3 days has gone by
            if( in_array($orderDate->format('w'), self::DELIVERY_DAYS) ){
                $i++;
            }
        }
        return $orderDate;
    }

}
//Enumerate weekdays.
abstract class WeekDays {
    const Sunday = 0;
    const Monday = 1;
    const Tuesday = 2;
    const Wednesday = 3;
    const Thursday = 4;
    const Friday = 5;
    const Saturday = 6;
}
