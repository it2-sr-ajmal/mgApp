<?php

namespace App\Rules;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Rule;
use PhpUnitsOfMeasure\PhysicalQuantity\Mass;
use PhpUnitsOfMeasure\PhysicalQuantity\Volume;

class UnitValidation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
	protected $requestData;
    public function __construct($request)
    {
       $this->requestData=$request;
	   //pre($this->requestData);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
		
		
        $unit1=$this->requestData['expected_harvest_quantity_unit'];
	    $unit2=$this->requestData['portion_weight_unit'];
	    $quantity1=$this->requestData['expected_harvest_quantity'];
	    $quantity2=$this->requestData['portion_sale_weight'];
		
		try{
			if($unit1=="piece"){
				return ($quantity1 >= $quantity2);
			}
			
			if($unit1=="liter" || $unit2=="liter" || $unit1=="milliliter" || $unit2=="milliliter"){
				$large  = new Volume($quantity1, $unit1);
				$largeMass = $large->toUnit('milliliter');
				
				$small  = new Volume($quantity2, $unit2);
				$smallMass = $small->toUnit('milliliter');
			}else{
				//convert total quantity into gram
				$large = new Mass($quantity1, $unit1);
				$largeMass = $large->toUnit('g');
				
				//convert small quantity into gram
				$small = new Mass($quantity2, $unit2);
				$smallMass = $small->toUnit('g');
			}
			
			//checking
			$status = ($largeMass >= $smallMass);
			
			//return response
			return $status;
		}catch(\Exception $e){
			
			return false;
		} 
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Must be less than Total harvest Quantity";
    }
}
