<?php
namespace App\Traits;
use App;
trait CalendarTrait   {
    /**
     * Constructor
     */
    public function __construct(){     
        $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
    }
     
    /********************* PROPERTY ********************/  
    private $dayLabels = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
     
    private $currentYear=0;
     
    private $currentMonth=0;
     
    private $currentDay=0;
     
    private $currentDate=null;
     
    private $daysInMonth=0;
     
    private $naviHref= null;
	
    private $month= null;
    private $day= null;
     
    /********************* PUBLIC **********************/  
        
    /**
    * print out the calendar
    */
    public function showCalendar($lang,$events,$checkingDate) {
		
        $this->data['year']  = date('Y',strtotime($checkingDate));
         
        $this->data['month'] = date('m',strtotime($checkingDate));
		
        $this->data['day'] = null;
         
        if(null==$this->data['year'] && request()->get('year')){
 
            $this->data['year'] = request()->get('year');
         
        }else if(null==$this->data['year']){
 
            $this->data['year'] = date("Y",time());  
         
        }          
         
        if(null==$this->data['month'] && request()->get('month')){
 
            $this->data['month'] = request()->get('month');
         
        }else if(null==$this->data['month']){
 
            $this->data['month'] = date("m",time());
         
        }  
		
        if(null==$this->day && request()->get('day')){
 
            $this->data['day'] = request()->get('day');
         
        }else if(null==$this->day){
 
            $this->data['day'] = date("d");
         
        }         
		//pre($this->data['year'].'-'.$this->data['month']);
		$todayObj = \DateTime::createFromFormat('Y-m-d', $this->data['year'].'-'.$this->data['month'].'-'.$this->data['day']);
		
		$this->data['active_day'] = $todayObj->format('Y-m-d');
         
        $this->currentYear = $this->data['year'];
         
        $this->currentMonth = $this->data['month'];
         
        $this->daysInMonth = $this->_daysInMonth();  
		
		$weeksInMonth = $this->_weeksInMonth();
		
		$days = '';
		
		if(!empty($weeksInMonth)){

			for( $i=0; $i<$weeksInMonth; $i++ ){
				 
				for($j=1;$j<=7;$j++){
					$days .= $this->_showDay( ($i*7+$j) , $events);
				}
			}
		}
		
		$this->data['events'] = $events;
		$this->data['days'] = $days;
		
		$this->data['currentDay'] = request()->get('day');
		
		$this->data['labels'] = $this->_createLabels();
        $content= \View::make('frontend.calendar.calendar_section',$this->data)->render(); 
        return $content;   
    }
     
    /********************* PRIVATE **********************/ 
    /**
    * create the li element for ul
    */
    private function _showDay($cellNumber,$events){
        
        if($this->currentDay==0){
             
            $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));
            if(intval($cellNumber) == intval($firstDayOfTheWeek)){
                 
                $this->currentDay=1;
                 
            }
        }
         
        if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){
            
            $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));
            
             $cellContent = $this->currentDay ;
             
            $this->currentDay++;   
             
        }else{
			
            $this->currentDate =null;
 
            $cellContent=null;
        }
       $productCount=(isset($events[$cellContent]['total']))?$events[$cellContent]['total']:0;    
       $eventDom = (array_key_exists($cellContent,$events)) ? $productCount:-1;
	   $price=(($this->currentDate > date('Y-m-d')) && array_key_exists($cellContent,$events) && isset($events[$cellContent]['price']))?$events[$cellContent]['price']:'';
		/* $multiCount=($eventDom >= 0)?'data-mult='.numberFormatK($eventDom):'';
		$toolTip = ($eventDom >= 0)?'data-tooltip-content=#pre_book_'.$cellContent:'';
		$selected=($eventDom >= 0)?' selected':'';
		$multiple=(($this->currentDate > date('Y-m-d')) && $eventDom >= 0 && $events[$cellContent]['total'] >= 0)?'multiple_ tooltip-top':'';
		$outofStock = ($eventDom == 0)?' sold_out_stock ':'';
		$id = ($this->currentDate) ? 'li-'.$this->currentDate : 'li-'.rand();
		$pastDay = ($this->currentDate < date('Y-m-d')) ? ' pastDay ': '';
		$anchor = ($cellContent) ? '<li data-date="'.$this->currentDate.'" id="'.$id.'" class=" '.$pastDay.$multiple.$selected.$outofStock.'" '.$toolTip.' ><span '.$multiCount.'>'.$cellContent.'</span></li>' : '<li data-date="'.$this->currentDate.'" id="'.$id.'" ></li>'; 
		
		
		$class = ($cellNumber%7 == 1 ? ' start ' : ($cellNumber%7 == 0 ? ' end ':' ')).($cellContent==null ? 'mask' : '');
		$class.=($cellContent == $this->data['day']) ? ' active ' : '';
        
		return $anchor; */
		
		$multiCount=($eventDom >= 0)?'data-mult='.numberFormatK($eventDom):'';
		$packLeft=(($this->currentDate > date('Y-m-d')) && $eventDom >= 0)?'<span class="packs_c"><strong class="dayStock"> '.numberFormatK($eventDom).'</strong>'.lang('left').'</span> ':'';
		$toolTip = ($eventDom >= 0)?'data-tooltip-content=#pre_book_'.$cellContent:'';
		$selected=($eventDom >= 0 && $events[$cellContent]['harvestDay'])?' h_date selected':'';
		$multiple=(($this->currentDate > date('Y-m-d')) && $eventDom >= 0 && $productCount >= 0 && $events[$cellContent]['selling_type']=="retail")?'multiple_ tooltip-top':'';
		$outofStock = ($eventDom == 0)?' sold_out_stock ':'';
		$packLeft = ($eventDom == 0)?'<span class="packs_c">Sold Out</span> ':$packLeft;
		$id = ($this->currentDate) ? 'li-'.$this->currentDate : 'li-'.rand();
		$pastDay = ($this->currentDate < date('Y-m-d')) ? ' pastDays ': '';
		
		
		$class = ($cellNumber%7 == 1 ? ' start ' : ($cellNumber%7 == 0 ? ' end ':' ')).($cellContent==null ? 'mask' : '');
		$class.=($cellContent == $this->data['day']) ? ' active ' : '';
		$class.=($eventDom <= 5 && $eventDom > 0) ? ' highlight_ ' : '';
		$anchor = ($cellContent) ? '<li data-date="'.$this->currentDate.'" id="'.$id.'" class=" '.$class.$pastDay.$multiple.$selected.$outofStock.'" '.$toolTip.' ><span class="date_n" >'.$cellContent.'</span>'.$price.$packLeft.'</li>' : '<li data-date="'.$this->currentDate.'" id="'.$id.'" ></li>'; 
		return $anchor;
		
    }
     
    /**
    * create navigation
    */
    private function _createNavi(){
         
        $nextMonth = $this->currentMonth==12 ? 1:intval($this->currentMonth)+1;
         
        $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;
         
        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
         
        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;
         
        return
            '<div class="header">'.
                '<a class="prev" href="'.$this->naviHref.'?month='.sprintf('%02d',$preMonth).'&year='.$preYear.'">Prev</a>'.
                    '<span class="title">'.date('Y M',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</span>'.
                '<a class="next" href="'.$this->naviHref.'?month='.sprintf("%02d", $nextMonth).'&year='.$nextYear.'">Next</a>'.
            '</div>';
    }
         
    /**
    * create calendar week labels
    */
    private function _createLabels(){  
                 
        $content='';
         
        foreach($this->dayLabels as $index=>$label){
             
            $content.='<li class="'.($label==6?'end title':'start title').' title">'.$label.'</li>';
 
        }
         
        return $content;
    }
     
     
     
    /**
    * calculate number of weeks in a particular month
    */
    private function _weeksInMonth(){
         
        if( null==($this->data['year']) ) {
            $this->data['year'] =  date("Y",time()); 
        }
         
        if(null==($this->data['month'])) {
            $this->data['month'] = date("m",time());
        }
         
        // find number of days in this month
        $daysInMonths = $this->_daysInMonth();
         
        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
         
        $this->monthEndingDay= date('N',strtotime($this->data['year'].'-'.$this->data['month'].'-'.$daysInMonths));
         
        $this->monthStartDay = date('N',strtotime($this->data['year'].'-'.$this->data['month'].'-01'));
         
        if($this->monthEndingDay<$this->monthStartDay){
             
            $numOfweeks++;
         
        }
         
        return $numOfweeks;
    }
 
    /**
    * calculate number of days in a particular month
    */
    private function _daysInMonth(){
         
        if(null==($this->data['year']))
            $this->data['year'] =  date("Y",time()); 
 
        if(null==($this->data['month']))
            $this->data['month'] = date("m",time());
             
        return date('t',strtotime($this->data['year'].'-'.$this->data['month'].'-01'));
    }
     /**
    * print out the calendar
    */
    public function showListingCalendar($lang,$events,$checkingDate) {
		
        $this->data['year']  = date('Y',strtotime($checkingDate));
         
        $this->data['month'] = date('m',strtotime($checkingDate));
		
        $this->data['day'] = null;
         
        if(null==$this->data['year'] && request()->get('year')){
 
            $this->data['year'] = request()->get('year');
         
        }else if(null==$this->data['year']){
 
            $this->data['year'] = date("Y",time());  
         
        }          
         
        if(null==$this->data['month'] && request()->get('month')){
 
            $this->data['month'] = request()->get('month');
         
        }else if(null==$this->data['month']){
 
            $this->data['month'] = date("m",time());
         
        }  
		
        if(null==$this->day && request()->get('day')){
 
            $this->data['day'] = request()->get('day');
         
        }else if(null==$this->day){
 
            $this->data['day'] = date("d");
         
        }         
		//pre($this->data['year'].'-'.$this->data['month']);
		$todayObj = \DateTime::createFromFormat('Y-m-d', $this->data['year'].'-'.$this->data['month'].'-'.$this->data['day']);
		
		$this->data['active_day'] = $todayObj->format('Y-m-d');
         
        $this->currentYear = $this->data['year'];
         
        $this->currentMonth = $this->data['month'];
         
        $this->daysInMonth = $this->_daysInMonth();  
		
		$weeksInMonth = $this->_weeksInMonth();
		
		$days = '';
		
		if(!empty($weeksInMonth)){

			for( $i=0; $i<$weeksInMonth; $i++ ){
				 
				for($j=1;$j<=7;$j++){
					$days .= $this->_showListingDay( ($i*7+$j) , $events);
				}
			}
		}
		//pre($events);
		$this->data['events'] = $events;
		$this->data['days'] = $days;
		
		$this->data['currentDay'] = request()->get('day');
		
		$this->data['labels'] = $this->_createLabels();
        $content= \View::make('frontend.farm.farm_listing.calendar.calendar_section',$this->data)->render(); 
        return $content;   
    }
	
	
    /********************* PRIVATE **********************/ 
    /**
    * create the li element for ul
    */
    private function _showListingDay($cellNumber,$events){
        
        if($this->currentDay==0){
             
            $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));
            if(intval($cellNumber) == intval($firstDayOfTheWeek)){
                 
                $this->currentDay=1;
                 
            }
        }
         
        if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){
            
            $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));
            
             $cellContent = $this->currentDay ;
             
            $this->currentDay++;   
             
        }else{
			
            $this->currentDate =null;
 
            $cellContent=null;
        }
            
        $eventDom = (array_key_exists($cellContent,$events)) ? $events[$cellContent]['total']:-1;
	    $price=(($this->currentDate > date('Y-m-d')) && array_key_exists($cellContent,$events) && $events[$cellContent]['price'])?$events[$cellContent]['price']:'';
		$packLeft=(($this->currentDate > date('Y-m-d')) && $eventDom > 0)?'<span class="packs_c"><strong class="dayStock"> '.numberFormatK($eventDom).'</strong> packs</span> ':'';
		
		$toolTip = 'data-tooltip-content=#harvest_edit_'.$this->currentDate;
		$toolTipClaass = ' ';
		$selected=($eventDom > 0 )?' selected':'';
		$multiple=(($this->currentDate > date('Y-m-d')) && $eventDom > 0 && $events[$cellContent]['total'] > 0)?'multiple_ ':'';
		
		$id = ($this->currentDate) ? 'li-'.$this->currentDate : 'li-'.rand();
		$pastDay = ($this->currentDate <= date('Y-m-d')) ? ' pastDays mask': '';
		$class = ($cellNumber%7 == 1 ? ' start ' : ($cellNumber%7 == 0 ? ' end ':' '));
		$class.=($cellContent == $this->data['day']) ? ' active ' : '';
		
		$anchor = ($cellContent) ? '<li data-date="'.$this->currentDate.'" id="'.$id.'" class=" '.$class.$toolTipClaass.$pastDay.$multiple.$selected.'" '.$toolTip.' ><span class="date_n">'.$cellContent.'</span>'.$price.$packLeft.'</li>' : '<li data-date="'.$this->currentDate.'" id="'.$id.'" class="mask" ></li>';  
		
		
		
        
		return $anchor;
		
    } 
}