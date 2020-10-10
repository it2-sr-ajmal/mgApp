<?php
namespace App\Traits;
use App;
trait ReviewTrait{
	/**
	 * product review and ratings
	*/
	function rating()
	{
		return $this->getReviews->avg('pr_rating');
	}
	/**
	* total active review count 
	*/
	function totalReviewCount()
	{
		return $this->getReviews->count();
	}
	
	/**
	* active product quality rating count
	*/
	function qualityRateCount($limit=0)
	{
		return $this->getReviews->filter(function($item) use($limit){
			                if($limit > 0){
								return ($item->quality_rating == $limit);
							}
							return ($item->quality_rating > $limit);
							
						})->count();
	}
	/**
	* active product quality rating average
	*/
	function qualityRateAvg()
	{
		return $this->getReviews->filter(function($item){
							return ($item->quality_rating >0);
						})->avg('quality_rating');
	}
	
	/**
	* active product value for money rating count
	*/
	function valueForMoneyCount($limit=0)
	{
		 return $this->getReviews->filter(function($item) use($limit){
			                        if($limit > 0){
										return ($item->value_for_money_rating == $limit);
									}
									return ($item->value_for_money_rating > $limit);
								})->count();
	}
	/**
	* active product value for money rating average
	*/
	function valueForMoneyAvg()
	{
		 return $this->getReviews->filter(function($item){
									return ($item->value_for_money_rating >0);
								})->avg('value_for_money_rating');
	}
	/**
	* active product freshness rating count
	*/
	function freshnessRatingCount($limit=0)
	{
		
		return $this->getReviews->filter(function($item) use($limit){
			                        if($limit > 0){
										return ($item->freshness_rating == $limit);
									}
									return ($item->freshness_rating > $limit);
								})->count();
	}
	/**
	* active product freshness rating average
	*/
	function freshnessRatingAvg()
	{
		return $this->getReviews->filter(function($item){
									return ($item->freshness_rating > 0);
								})->avg('freshness_rating');
	}
	/**
	* active product packaging rating count
	*/
	function packagingRatingCount($limit=0)
	{
		return $this->getReviews->filter(function($item) use($limit){
			                        if($limit > 0){
										return ($item->packaging_rating == $limit);
									}
									return ($item->packaging_rating > $limit);
								})->count();
		
	}
	/**
	* active product packaging rating average
	*/
	function packagingRatingAvg()
	{
		return $this->getReviews->filter(function($item){
									return ($item->packaging_rating >0);
								})->avg('packaging_rating');
		
	}
	
	/**
	* active product delivery time rating count
	*/
	
	function deliverytimeRatingCount($limit=0)
	{
		
		return $this->getReviews->filter(function($item) use($limit){
			                        if($limit > 0){
										return ($item->deliverytime_rating == $limit);
									}
									return ($item->deliverytime_rating > $limit);
								})->count();
	}
	/**
	* active product delivery time rating average
	*/
	function deliverytimeRatingAvg()
	{
		
		return $this->getReviews->filter(function($item){
									return ($item->deliverytime_rating >0);
								})->avg('deliverytime_rating');
	}
	/**
	* total rating count including quality, value for money,freshness, packaging and delivery time
	*/
	function totalRatingCount()
	{
		return $this->qualityRateCount() + $this->valueForMoneyCount() + $this->freshnessRatingCount() + $this->packagingRatingCount() + $this->deliverytimeRatingCount();
		
	}
	/**
	* total individual rate count
	*/
	function totalFiveStartRatingCount()
	{
		return $this->qualityRateCount(5) + $this->valueForMoneyCount(5) + $this->freshnessRatingCount(5) + $this->packagingRatingCount(5) + $this->deliverytimeRatingCount(5);
		
	}
	function totalFourStartRatingCount()
	{
		return $this->qualityRateCount(4) + $this->valueForMoneyCount(4) + $this->freshnessRatingCount(4) + $this->packagingRatingCount(4) + $this->deliverytimeRatingCount(4);
		
	}
	function totalThreeStartRatingCount()
	{
		return $this->qualityRateCount(3) + $this->valueForMoneyCount(3) + $this->freshnessRatingCount(3) + $this->packagingRatingCount(3) + $this->deliverytimeRatingCount(3);
		
	}
	function totalTwoStartRatingCount()
	{
		return $this->qualityRateCount(2) + $this->valueForMoneyCount(2) + $this->freshnessRatingCount(2) + $this->packagingRatingCount(2) + $this->deliverytimeRatingCount(2);
		
	}
	function totalOneStartRatingCount()
	{
		return $this->qualityRateCount(1) + $this->valueForMoneyCount(1) + $this->freshnessRatingCount(1) + $this->packagingRatingCount(1) + $this->deliverytimeRatingCount(1);
		
	}
	
}