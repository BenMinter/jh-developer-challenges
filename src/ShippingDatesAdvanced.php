<?php

namespace Jh\Shipping;
/**
 * Class ShippingDates
 * @package Jh\Shipping
 */
class ShippingDatesAdvanced implements ShippingDatesInterface
{
    const DAY_PROMISE = 3;
    const TIME_CUTOFF = 17; //24 hour time
    const DELIVERY_DAYS = array(WeekDays::Monday, WeekDays::Tuesday, WeekDays::Wednesday, WeekDays::Thursday, WeekDays::Friday);
    const DISPATCH_DAYS = self::DELIVERY_DAYS;

    /**
    * Method calculateDeliveryDate with cutoff on time.
    * @param orderDate
    * @return deliveryDate
    */

    public function calculateDeliveryDate(\DateTime $orderDate){
        $i = 0;

        //if before time cutoff and a dispatchable day -> dispatch
        if($orderDate->format("G") < self::TIME_CUTOFF ){
            if(in_array($orderDate->format('w'), self::DISPATCH_DAYS)){
                $i++;
            }
        }

        //if not dispatched go past sat and sun
        do{
            $orderDate->modify("+1 day");
        }while(!in_array($orderDate->format('w'), self::DISPATCH_DAYS));

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
