<?php

function constPrint(){
    return config('constants');
}
function FGC($label){
    return config('constants.'.$label);

}
function getMonthName($index){
    
    if($index < 1 || $index > 12) {
        return 'Invalid Month Index';
    }
    $months=[1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December'];
    return $months[$index];
} 

function array_to_object($array) {
  $obj = new stdClass;
  foreach($array as $k => $v) {
     if(strlen($k)) {
        if(is_array($v)) {
           $obj->{$k} = array_to_object($v); //RECURSION
        } else {
           $obj->{$k} = $v;
        }
     }
  }
  return $obj;
} 

function get_user_profile_image($farmUser){
	
	$image_url = htmlAsset('images/person01.jpg');
	
	if(!isset($farmUser->owner)) return $image_url;
	/*if(file_exists('storage/uploads/user/'.$farmUser->owner->user_avatar)){
		$image_url = asset('storage/uploads/user/'.$farmUser->owner->user_avatar);
	}*/
	
	return $image_url;
	
}

function get_time_slot_array($startTime , $endTime , $slotDuration){ //$slotDuration in minutes
    $slotDuration = (int) $slotDuration;
    $totalTimeSlots = array();
    $interval = 'PT'.$slotDuration.'M';
    $period = new \DatePeriod(  new \DateTime($startTime),  new \DateInterval($interval), new \DateTime($endTime) );
    foreach ($period as $time) {
        $totalTimeSlots[$time->format("H:i")] = $time->format("h:i A");
    }

    return $totalTimeSlots;
}
    
function pr($arr) {
    print_r($arr);
}

function pre($arr) {
	if(Config::get('app.debug')){
		echo "<pre>";
		print_r($arr);
		exit();
	}
}


function replace_relative_urls($baseURL, $str) { //Only use under live domain
    $result = preg_replace('/(\.\.\/)*\1/', $baseURL, $str);
    return $result;
}



function limitText($text, $limit = 65) {
    if (strlen($text) < $limit) {
        return $text;
    }
    $stringCut = substr($text, 0, $limit);
    $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '...';
    return $string;
}


function highlight_text($text, $keyword) {
    return preg_replace("~\p{L}*?" . preg_quote($keyword) . "\p{L}*~ui", "<span class='highlight'><b>$0</b></span>", $text);
}

function getTranslatedMonthNames(){
	$translatedMonth=[];
	$short = $full = '';
	for($month=1;$month<=12;$month++){
		$full.= (empty($full)) ? Lang::get('months.'.$month) : ','.Lang::get('months.'.$month);
		$short.= (empty($short)) ? Lang::get('months.'.$month.'_short') : ','.Lang::get('months.'.$month.'_short');
	}
	$translatedMonth['full'] = explode(',',$full);
	$translatedMonth['short'] = explode(',',$short);
	
	
	return $translatedMonth;
}

function getPlUploadControlWithoutLabel($controlName, $allowedMimes=['jpg','jpeg','png'], $uploadType=null, $btnLabel='Select File', $validationMsg , $required = false){
   
    $controlHTML = '<div class = "noLabelFU uploadControlWrapper">'.
        '<input type = "file" class = "form-control uploaderProfile" data-allowed="'.(implode(",", $allowedMimes)).'" data-type="'.$uploadType.'" title = "'.$validationMsg.'" id = "'.$controlName.'_file" name = "'.$controlName.'_file" '.(($required==true)?" required ":'').' />'.
        '<div class = "choose">'.
            '<div class = "choose-btn">'.$btnLabel.'</div>'.
            '<div class = "choose-file uploadFileName"></div>'.
            '<div class = "uploadPercentage"></div>'.
            '<div class = "uploadProgressWrapper">'.
            '<div class = "uploadProgress" ></div>'.
        '</div>'.
    '</div>'.
    '<input class = "filename" type="hidden" id="'.$controlName.'" value="" name="'.$controlName.'" placeholder="">'.
    '<input class = "original_name" type="hidden" id="'.$controlName.'_tmp" value="" name="'.$controlName.'_tmp" placeholder="">'.
    '</div>';
    return $controlHTML;
}

function getMultiPlUploadControl($label, $controlName, $allowedMimes=['jpg','jpeg','png'], $uploadType=null, $btnLabel='Select File', $validationMsg, $required = false, $oldFileName="",$postType){
    // pre($label);
	$imagePreview = '';
    $postBasePath = 'storage/app/public/post/';
    if(!empty($oldFileName) && File::exists($postBasePath.$oldFileName) && $uploadType=="image"){
        $imagePreview = '<div class="uploadPreview"><div class="upImgWrapper"><span class="delUploadImage" data-name="'.$oldFileName.'"><i class="fa fa-times-circle"></i></span><img src="'.asset($postBasePath.$oldFileName).'" class="uploadPreview"/></div><div class="clearfix"></div></div>';
    }else{
        if(!empty($oldFileName) && File::exists($postBasePath.$oldFileName)){
        $imagePreview = '<div class="uploadPreview"><div class="upImgWrapper"><span class="delUploadImage" data-name="'.$oldFileName.'"><i class="fa fa-times-circle"></i></span><a target="_blank" href="'.asset($postBasePath.$oldFileName).'" class="uploadPreview">'.$oldFileName.'</a></div><div class="clearfix"></div></div>';
       } 
    }
   
    if (empty($allowedMimes)) {
        $allowedMimes = ['jpg', 'jpeg', 'png'];
    }
    $controlHTML = '<label class = "fl-start">'.$label.'<em class = "mandatory">*</em></label>'.$imagePreview.
    '<div class = "uploadControlWrapper input_parent">'.
        '<input type = "file" class = "form-control multiuploader" data-slug="'.$postType.'" data-allowed="'.(implode(",", $allowedMimes)).'" data-type="'.$uploadType.'" title = "'.$validationMsg.'" id = "'.$controlName.'_file" name = "'.$controlName.'_file" '.(($required==true)?" required ":'').' />'.
        '<div class = "choose">'.
            '<div class = "choose-btn">'.$btnLabel.'</div>'.
            '<div class = "choose-file uploadFileName"></div>'.
            '<div class = "uploadPercentage"></div>'.
            '<div class = "uploadProgressWrapper">'.
            '<div class = "uploadProgress" ></div>'.
        '</div>'.
    '</div>'.
    '</div>';
    return $controlHTML;
}

function getSinglePlUploadControl($label, $controlName, $allowedMimes=['jpg','jpeg','png'], $uploadType=null, $btnLabel='Select File', $validationMsg, $required = false, $oldFileName="",$postType, $postBasePath=null){
    // pre($label);
	$imagePreview = '';
    $postBasePath = (!empty($postBasePath))?$postBasePath:'storage/post/';
   
   
    if(!empty($oldFileName) && File::exists($postBasePath.$oldFileName) && $uploadType=="image"){
        $imagePreview = '<div class="uploadPreview"><div class="upImgWrapper"><span class="delUploadImage" data-name="'.$oldFileName.'"><i class="fa fa-times-circle"></i></span><img src="'.asset($postBasePath.$oldFileName).'" class="uploadPreview"/></div><div class="clearfix"></div></div>';
    }else{
        if(!empty($oldFileName) && File::exists($postBasePath.$oldFileName)){
        $imagePreview = '<div class="uploadPreview"><div class="upImgWrapper"><span class="delUploadImage" data-name="'.$oldFileName.'"><i class="fa fa-times-circle"></i></span><a target="_blank" href="'.asset($postBasePath.$oldFileName).'" class="uploadPreview">'.$oldFileName.'</a></div><div class="clearfix"></div></div>';
       } 
    }
   
    
   
    if (empty($allowedMimes)) {
        $allowedMimes = ['jpg', 'jpeg', 'png'];
    }
	
	$dimensions  = \Config::get('pgsimagedimensions');
	
	$width = $height = false;
	$dimensionStr = '';
	
	if(!empty($dimensions[$controlName.'_file'])){
		if(!empty($dimensions[$controlName.'_file']['large'])){
			$width = $dimensions[$controlName.'_file']['large']['width'];
			$height = $dimensions[$controlName.'_file']['large']['height'];
		}
		
	}
	
	if(!empty($width)){
		$dimensionStr = ' <strong class="imageDims">['.$width.'px X '.$height.'px] </strong>';
	}
	$requiredText="";
	if($required==true){
		$requiredText='<em>*</em>';
	}
	// pre($label);
    $controlHTML = '<label class = "col-form-label fl-start">'.$label.$dimensionStr.$requiredText.'</label>'.$imagePreview.
    '<div class = "uploadControlWrapper input_parent">'.
        '<input type = "file" class = "form-control singleuploader" data-slug="'.$postType.'" data-allowed="'.(implode(",", $allowedMimes)).'" data-type="'.$uploadType.'" title = "'.$validationMsg.'" id = "'.$controlName.'_file" name = "'.$controlName.'_file" '.(($required==true)?" required ":'').' />'.
        '<div class = "choose">'.
            '<div class = "choose-btn">'.$btnLabel.'</div>'.
            '<div class = "choose-file uploadFileName"></div>'.
            '<div class = "uploadPercentage"></div>'.
            '<div class = "uploadProgressWrapper">'.
            '<div class = "uploadProgress" ></div>'.
        '</div>'.
    '</div>'.
    '<input class = "filename" type="hidden" id="'.$controlName.'" value="'.((!empty($oldFileName))?$oldFileName:'').'" name="meta[text]['.$controlName.']" placeholder="">'.
    '<input class = "original_name" type="hidden" id="'.$controlName.'_tmp" value="" name="'.$controlName.'_tmp" placeholder="">'.
    '</div>';
    return $controlHTML;
}
function getPlUploadControl($label, $controlName, $allowedMimes=['jpg','jpeg','png'], $uploadType=null, $btnLabel='Select File', $validationMsg, $required = false, $oldFileName="",$postType, $postBasePath=null){
    // pre($label);
	$required =(!empty($oldFileName))?false:$required;
	$imagePreview = '';
    $postBasePath = (!empty($postBasePath))?$postBasePath:'storage/post/';
    if(!empty($oldFileName) && File::exists($postBasePath.$oldFileName) && $uploadType=="image"){
        $imagePreview = '<div class="uploadPreview img_uploaded"><div class="upImgWrapper"><span class="delUploadImage" data-name="'.$oldFileName.'"><i class="fa fa-times-circle"></i></span><img src="'.asset($postBasePath.$oldFileName).'" class="uploadPreview"/></div><div class="clearfix"></div></div>';
    }else{
        if(!empty($oldFileName) && File::exists($postBasePath.$oldFileName)){
        $imagePreview = '<div class="uploadPreview img_uploaded"><div class="upImgWrapper"><span class="delUploadImage" data-name="'.$oldFileName.'"><i class="fa fa-times-circle"></i></span><a target="_blank" href="'.asset($postBasePath.$oldFileName).'" class="uploadPreview">'.$oldFileName.'</a></div><div class="clearfix"></div></div>';
       } 
    }
   
    if (empty($allowedMimes)) {
        $allowedMimes = ['jpg', 'jpeg', 'png'];
    }
	
	$dimensions  = \Config::get('pgsimagedimensions');
	
	$width = $height = false;
	$dimensionStr = '';
	
	if(!empty($dimensions[$controlName.'_file'])){
		if(!empty($dimensions[$controlName.'_file']['large']['width'])){
			$width = $dimensions[$controlName.'_file']['large']['width'];
			$height = $dimensions[$controlName.'_file']['large']['height'];
		}
	}
	
	if(!empty($width)){
		$dimensionStr = ' <strong class="imageDims">['.$width.'px X '.$height.'px] </strong>';
	}
	$requiredText="";
	if($required==true){
		$requiredText='<em>*</em>';
	}
	// pre($label);
    $controlHTML = '<label class = "col-form-label fl-start">'.$label.$dimensionStr.$requiredText.'</label>'.$imagePreview.
    '<div class = "uploadControlWrapper input_parent">'.
        '<input type = "file" class = "form-control singleuploader" data-slug="'.$postType.'" data-allowed="'.(implode(",", $allowedMimes)).'" data-type="'.$uploadType.'" title = "'.$validationMsg.'" id = "'.$controlName.'_file" name = "'.$controlName.'_file" '.(($required==true)?" required ":'').' />'.
        '<div class = "choose">'.
            '<div class = "choose-btn">'.$btnLabel.'</div>'.
            '<div class = "choose-file uploadFileName"></div>'.
            '<div class = "uploadPercentage"></div>'.
            '<div class = "uploadProgressWrapper">'.
            '<div class = "uploadProgress" ></div>'.
        '</div>'.
    '</div>'.
    '<input class = "filename" type="hidden" id="'.$controlName.'" value="'.((!empty($oldFileName))?$oldFileName:'').'" name="'.$controlName.'" placeholder="">'.
    '<input class = "original_name" type="hidden" id="'.$controlName.'_tmp" value="" name="'.$controlName.'_tmp" placeholder="">'.
    '</div>';
    return $controlHTML;
}

 function getYoutubeVideoID($url){
    
    $videoID = false;
    if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
        $videoID = $id[1];
    } else if (preg_match('/youtube\.com\/watch\?.*&v=([^\&\?\/]+)/', $url, $id)) {
        $mediaID = $id[1];
    } else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id)) {
        $videoID = $id[1];
    } else if (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $id)) {
        $videoID = $id[1];
    } else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
        $videoID = $id[1];
    } else if (preg_match('/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/', $url, $id)) {
        $videoID = $id[1];
    }
    return $videoID;
}



function is_rtl( $string ) {
    $rtl_chars_pattern = '/[\x{0590}-\x{05ff}\x{0600}-\x{06ff}]/u';
    return preg_match($rtl_chars_pattern, $string);
}

function dateWithLang($obj,$prop){

       $returnVal=$date="";
       if(is_object($obj)){
        $returnVal = (isset($obj->{$prop}))?$obj->{$prop}:'';
       }elseif(is_array($obj)){
          $returnVal = (isset($obj[$prop]))?$obj[$prop]:'';
       }

       if(!empty($returnVal)){

                            
          $date='<span>'.date('d ',strtotime($returnVal))."</span><span>".Lang::get("messages.".date('M',strtotime($returnVal)))." ".date('Y',strtotime($returnVal)).'</span>';

       }
	   
       return $date;
}

function printDateDay($obj,$prop){

       $returnVal="";
       if(is_object($obj)){
        $returnVal = (isset($obj->{$prop}))?$obj->{$prop}:'';
       }elseif(is_array($obj)){
          $returnVal = (isset($obj[$prop]))?$obj[$prop]:'';
       }
        return date('d ',strtotime($returnVal));

}

function printDateMonthYear($obj,$prop){

       $returnVal="";
       if(is_object($obj)){
        $returnVal = (isset($obj->{$prop}))?$obj->{$prop}:'';
       }elseif(is_array($obj)){
          $returnVal = (isset($obj[$prop]))?$obj[$prop]:'';
       }
        return Lang::get("messages.".date('M',strtotime($returnVal)))." ".date('Y',strtotime($returnVal));

}

function displaySplitDate($returnVal,$d){      
       if(!empty($returnVal)){         
          $date=date($d,strtotime($returnVal));
			if($d=='M'){
				$date=Lang::get("messages.".date('M',strtotime($returnVal)));			
			}
       }	   
       return $date;
}

function displayDateTime($dateTime){
     $dateTimeTemp =  DateTime::createFromFormat('Y-m-d H:i:s', $dateTime);
     if(!$dateTimeTemp) return $dateTime;
     
     if($dateTimeTemp->format('H:i:s') == "00:00:00"){
        return $dateTimeTemp->format('Y-m-d');
    } 
    return $dateTimeTemp->format('Y-m-d h:i A'); 
}


function getPaginationSerial($obj){
    if(!isset($obj)) return 1;
    try{
        return ($obj->currentpage()-1)* $obj->perpage()+1;
    }catch(\Exception $ex){
        return 1;
    }
}


function getAppConfig($label){
    return \Config::get('constants.'.$label);
}

function getFileSize($bytes){
    if ($bytes >= 1073741824){
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }elseif ($bytes >= 1048576){
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}

function getFrontendAsset($path,$root=false){
    return ($root)?asset('assets/frontend/'.$path):asset('assets/frontend/dist/'.$path);
}

function getStorageAsset($path){
    return asset('public/storage/uploads/'.$path);
}

function adminPrefix(){
    return \Config::get('app.admin_prefix').'/';
}

function ap($path){
    return \Config::get('app.admin_prefix').'/'.$path;
}

function apa($path,$queryString = false){
	$url = URL::to(\Config::get('app.admin_prefix').'/'.$path);
	if($queryString){
		$qs = request()->query(); /* DONOT USE request()->all() , Will load post data too */
		if (count($qs)){

			foreach($qs as $key => $value){
				$qs[$key] = sprintf('%s=%s',$key, urlencode($value));
			}
			$url = sprintf('%s?%s', $url, implode('&', $qs));
		}
	}
    return $url;
}

function get_admin_menu_active_class($currentURI, $slugArr) {

    $className = '';
    $listArr = $slugArr;
    if (!is_array($listArr)) {
        $listArr = [$slugArr];
    }
	$allQueryArr = request()->query();
	
	if($allQueryArr){
		foreach($allQueryArr  as $key => $val){
			$str = $key.'='.$val;
			$currentURI = str_replace($str,'',$currentURI);
			$currentURI = str_replace('&','',$currentURI);
		}
		$currentURI = str_replace('?','',$currentURI);
	}
//dd($currentURI);
    $URLParts = explode("/", $currentURI);
    if (!empty($URLParts)) {
        foreach ($URLParts as $Uparts) {
            if (in_array($Uparts, $listArr)) {
                $className = 'active';
            }
        }
    }

    if (in_array('seo', $URLParts)) {
        return null;
    }
    // pre($URLParts);
    return $className;
}

function getHumanReadbleFormat($date){
	$instance = $date->diff(new DateTime(date('Y-m-d H:i:s')));
	$returnText = '';
	if($instance->y >0){
		$returnText = $instance->y.' '.Lang::get('messages.years');
	}
	else if($instance->m >0){
		$returnText = $instance->m.' '.Lang::get('messages.months');
	}
	else if($instance->d >0){
		$returnText = $instance->d.' '.Lang::get('messages.days');
	}
	else if($instance->h >0){
		$returnText = $instance->h.' '.Lang::get('messages.hours');
	}
	else if($instance->i >0){
		$returnText = $instance->i.' '.Lang::get('messages.minutes');
	}
	else if($instance->s >=0){
		$returnText = $instance->s.' '.Lang::get('messages.seconds');
	}
	return $returnText;
}

function htmlAsset($fileName){
    return asset('assets/frontend/dist/'.$fileName);
}

function lang($str){
	if (\Lang::has('messages.'.$str)) {
        return Lang::get('messages.'.$str);

	} else {

	   return ucfirst(str_replace('_',' ',$str));

    }
    
}


function getCategoryWisePosts($postsCollections,$fieldName){
    
	$splitedArray=[];
    foreach($postsCollections as $post){
       if(!empty($post->getData($fieldName))){
           $splitedArray[$post->getData($fieldName)][]=$post;
       }
	}
	return $splitedArray;
}

function getGalleryItemsByType($galCollection,$type){
	$filterArray=[];
    foreach($galCollection as $galItem){
          if($galItem->gallery_image_type == 1){
            $filterArray[] = $galItem;
          }
	}
	return $filterArray;
}
function youtubeImage($videoID){
	return "//img.youtube.com/vi/".$videoID."/sddefault.jpg";
}
function youtubeEmbedUrl($videoID){
	return "//www.youtube.com/embed/".$videoID."&autoplay=1&rel=0&controls=1&showinfo=1";
}

function getAgeFromDob($userDob){
    //Create a DateTime object using the user's date of birth.
    $dob = new \DateTime($userDob);
     
    //We need to compare the user's date of birth with today's date.
    $now = new \DateTime();
     
    //Calculate the time difference between the two dates.
    $difference = $now->diff($dob);
     
    //Get the difference in years, as we are looking for the user's age.
    return $difference->y;
}

function getDaysFromInterval($fromDate, $toDate, $resultFormat ='Y-m-d'){
    $res = array();    
    try{
        $intervalDays = new \DatePeriod(
         new \DateTime($fromDate),
         new \DateInterval('P1D'),
         new \DateTime($toDate)
        );
        
        $fromDate = \DateTime::createFromFormat($resultFormat, $fromDate);
        if(!empty($fromDate)){
            $res[] = $fromDate->format($resultFormat);
        }
        
        foreach($intervalDays as $day){
         $res[] =  $day->format($resultFormat);
        }
       
        $lastDate = \DateTime::createFromFormat($resultFormat, $toDate);

        if(!empty($lastDate)){
            $res[] = $lastDate->format($resultFormat);
        }
         
    }catch(\Exception $ex){
        return false;
    }
    return $res;


}

function _age($fomart='m/d/Y',$date) {
    $birthDate =date($format,strtotime($date));
    //explode the date to get month, day and year
    $birthDate =
            explode("/",
            $birthDate);
    //get age from date or birthdate
   return $age =
            (date("md",
                    date("U",
                            mktime(0,
                                    0,
                                    0,
                                    $birthDate[0],
                                    $birthDate[1],
                                    $birthDate[2]))) >
            date("md")
            ? ((date("Y") -
            $birthDate[2]) -
            1)
            : (date("Y") -
            $birthDate[2]));
}

/*
 The below function return day name and day of week as key
*/
function generateWeekDays($startDay='Sunday'){
    $timestamp = strtotime('next '.$startDay);
    $days = array();
    for ($i = 0; $i < 7; $i++) {
        $dayName = strftime('%A', $timestamp);
        $days[date('w',$timestamp)] = $dayName;
        $timestamp = strtotime('+1 day', $timestamp);
    }
   return $days;
}

function getAdminStatusIcon($status,$link=''){
	$link = ($link) ? ' href="'.$link.'"' : '';
    $iconStr = '<a '.$link.'><i class="fa fa-check-circle"></i></a>';
    if($status ==2){
        $iconStr = '<a '.$link.'><i class="fa fa-times-circle"></i></a>';
    }else if($status == 3){
		 $iconStr = '<a '.$link.'><i class="fas fa-clock"></i></a>';
	}
    return $iconStr;
}

function getAdminActionIcons($buttons,$postType,$item){
	$str = '';
    if($buttons['edit'] || $buttons['delete'] ){
		$str.='<td class="manage text-center">';
			
			if($buttons['edit'] ){
				$url = route('post_edit',[$postType,$item->post_id]);
		        $str.='<a href="'.$url.'"  title="edit" class="btn btn-outline-success btn-sm">Edit</a>';				
			}
			if($buttons['delete'] ){
				$url = route('post_delete',[$postType,$item->post_id]);
    			$str.='<a class="deleteRecord" href="'.$url.'"  title="delete" class="btn btn-outline-danger btn-sm" >Remove</a>';				
			}
			
		$str.='</td>';
	}
	return $str;
}

function displayAdminUploadedThumb($fieldVal,$path){
    
    if(empty($fieldVal)) return '';
    
    return '<div class="admin-upload-thumb"><img src="'.asset($path.'/'.$fieldVal).'"/></div>';
    
}

function is_between_times($startTime, $endTime, $timeToCheck){
    return $timeToCheck->greaterThanOrEqualTo($startTime) && $timeToCheck->lessThan($endTime);
}

function urlWithQueryStr($path = null, $secure = null)
{
    $url = app('url')->to($path, $secure);
	$qs = request()->all();
    if (count($qs)){

        foreach($qs as $key => $value){
            $qs[$key] = sprintf('%s=%s',$key, urlencode($value));
        }
        $url = sprintf('%s?%s', $url, implode('&', $qs));
    }
    return $url;
}

function isFrontendUserLoggedIn(){
	if(Auth::user() && @Auth::user()->is_backend_user == 2){
		return true;
	}
	return false;
}

function removeBrTagFromString($str){
    return str_replace('<br>','',$str);
}

function adjust_title_with_br($title,$lang,$removeThe=true){
	if($lang=='en' && $removeThe == true){
		$title = trim(str_replace('the','',strtolower($title)));
	}
	$title = str_replace('|','<br/>',$title);
	return $title;
}

function adjust_title_without_pipe($title,$lang,$removeThe=true){
	if($lang=='en' && $removeThe == true){
		$title = trim(str_replace('the','',strtolower($title)));
	}
	$title = str_replace('|','',$title);
	return $title;
}

function isDatePast($date){
	return (strtotime(date('Y-m-d')) > strtotime(date('Y-m-d',strtotime($date))));
}

function getWebsiteLogo(){
	$logo = ''; 
	if(file_exists('./assets/logo/logo.png')){
		$logo = 'logo.png';
	}elseif(file_exists('./assets/logo/logo.jpg')){
		$logo = 'logo.jpg';
	}else{
		$logo = 'logo.svg';
	}
	return asset('assets/logo/'.$logo);
}


function getResourceAttachmentPlUploadControl($label, $controlName, $allowedMimes=['jpg','jpeg','png'], $uploadType=null, $btnLabel='Select File', $validationMsg, $required = false, $oldFileName="",$resourceID=null){
    $imagePreview = '';

    if(!empty($oldFileName) && File::exists('storage/app/post/uploads/'.$oldFileName) && $uploadType=="image"){
        $imagePreview = '<div class="uploadPreview"><div class="upImgWrapper"><span class="delUploadImage" data-name="'.$oldFileName.'"><i class="fa fa-times-circle"></i></span><img src="'.asset('storage/app/post/uploads/'.$oldFileName).'" class="uploadPreview"/></div><div class="clearfix"></div></div>';
    }else{
        if(!empty($oldFileName) && File::exists('storage/app/post/uploads/'.$oldFileName)){
        $imagePreview = '<div class="uploadPreview"><div class="upImgWrapper"><span class="delUploadImage" data-name="'.$oldFileName.'"><i class="fa fa-times-circle"></i></span><a target="_blank" href="'.asset('storage/app/post/uploads/'.$oldFileName).'" class="uploadPreview">'.$oldFileName.'</a></div><div class="clearfix"></div></div>';
       } 
    }
   
    if (empty($allowedMimes)) {
        $allowedMimes = ['jpg', 'jpeg', 'png'];
    }
    $controlHTML = '<label class = "fl-start">'.$label.'<em class = "mandatory">*</em></label>'.$imagePreview.
    '<div class = "uploadControlWrapper input_parent">'.
        '<input type = "file" class = "form-control custom_uploader" data-allowed="'.(implode(",", $allowedMimes)).'" data-type="'.$uploadType.'" title = "'.$validationMsg.'" data-id="'.$resourceID.'" id = "'.$controlName.'_file" name = "'.$controlName.'_file" />'.
        '<div class = "choose">'.
            '<div class = "choose-btn">'.$btnLabel.'</div>'.
            '<div class = "choose-file uploadFileName"></div>'.
            '<div class = "uploadPercentage"></div>'.
            '<div class = "uploadProgressWrapper">'.
            '<div class = "uploadProgress" ></div>'.
        '</div>'.
    '</div>'.
    '</div>';
    return $controlHTML;
}

function showMediaItem($data){
	
	switch($data->pm_file_type){
		case 'image/jpeg':
		case 'image/svg+xml':
		case 'image/png':
		case 'image/gif':
			$dispElement = '<a data-fancybox rel="gallery" class="fancybox" href="'.asset('storage/app/public/post/'.$data->pm_file_hash).'"><img src="'.asset('storage/app/public/post/'.$data->pm_file_hash).'" alt="" class="img-fluid imageCenter "></a>';
		break;
		
		
		case 'application/pdf':
			$dispElement = 	'<span class="fa-stack fa-lg">'.
								'<i class="fa fa-square fa-stack-2x text-primary"></i>'.
								'<i class="fa fa-file-pdf fa-stack-1x fa-inverse"></i>'.
							'</span>';
		break;
		case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
			$dispElement = 	'<span class="fa-stack fa-lg">'.
								'<i class="fa fa-square fa-stack-2x text-primary"></i>'.
								'<i class="fa fa-file-word fa-stack-1x fa-inverse"></i>'.
							'</span>';
		break;
		default:
			// pre($data->pm_media_type);
			if($data->pm_media_type == 'video'){
			
				$dispElement = '<a data-fancybox rel="gallery" class="fancybox iframe" href="https://www.youtube.com/embed/'.$data->pm_name.'">';
				if(!empty($data->fileName)){
					$dispElement .= '<img src="'.asset('storage/app/public/post/'.$data->pm_file_hash).'" alt="" class="img-fluid imageCenter ">';
				}else{
					$dispElement .= '<img src="https://img.youtube.com/vi/'.$data->pm_name.'/hqdefault.jpg" alt="" class="img-fluid imageCenter ">';
				}
				$dispElement .= '<span class="far fa-play-circle playIcon"></span></a>';
			}else{
				$dispElement = 	'<span class="fa-stack fa-lg">'.
									'<i class="fa fa-square fa-stack-2x text-primary"></i>'.
									'<i class="fa fa-file fa-stack-1x fa-inverse"></i>'.
								'</span>';
			}
		break;
	}
	$inputName = ($data->pm_media_type == 'video')?'video':'gallery_file';
	
	return '<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 custCardWrapper'.(($data->pm_media_type == "video")?" YTVideo ":'').'"><div class="card card-figure has-hoverable">'.
					'<div class="topControls">'.
						'<a class="downloadImage" href="'.apa("post_media_download").'/'.$data->pm_id .'">'.
							'<span><i class="fas fa-download "></i></span>'.
						'</a>'.
						'<div class="text-center">'.
							'<select name="mediaLang[]" class="cardLang">'.
								'<option value="">In Both</option>'.
								'<option '.(($data->pm_lang =='ar')?' selected ':'').' value="ar">Arabic</option>'.
								'<option  '.(($data->pm_lang =='en')?' selected ':'').' value="en">English</option>'.  
							'</select>'. 
						'</div>'+
						'<a href="#" class="btn btn-reset text-muted delUploadImage" title="Delete" data-id="'.$data->pm_id .'">'. 
							'<span class="fas fa-times-circle"></span>'.
						'</a>'.
					'</div>'.
					'<figcaption class="figure-caption">'.
						'<div>'.
							'<input data-id="'. $data->pm_id .'" type="text" class="form-control mediaInput source" placeholder="Source English" value="'.$data->pm_source.'" name="source[]">'.
						'</div>'.
						'<div>'.
							'<input data-id="'. $data->pm_id .'" type="text" class="form-control mediaInput sourceAR" placeholder="Source Arabic" value="'.$data->pm_source_arabic.'"  dir="rtl" name="sourceAR[]">'.
						'</div>'.
					'</figcaption>'.
					'<figure class="figure">'.
						'<div class="figure-attachment adjustImage">'.
						
							'<input type="hidden" name="postMedia['.$inputName.'][]" value="'. $data->pm_id .'">'.
							$dispElement.
						'</div>'.
					'</figure>'.
					'<figcaption class="figure-caption">'.
						'<div>'.
							'<input data-id="'. $data->pm_id .'" type="text" class="form-control engTitle" placeholder="English Title" value="'.$data->pm_title.'" name="engTitle[]">'.
						'</div>'.
						'<div>'.
							'<input data-id="'. $data->pm_id .'" type="text" class="form-control arTitle" placeholder="Arabic Title" value="'.$data->pm_title_arabic.'"  dir="rtl" name="arTitle[]">'.
						'</div>'.
					'</figcaption>'.
				'</div>'.
			'</div>';
	
}

function get_months_duration($startTime , $endTime){
    $to = \Carbon\Carbon::createFromFormat('Y-m-d', $startTime);
    $from = \Carbon\Carbon::createFromFormat('Y-m-d', $endTime);
    return $diff_in_months = $to->diffInMonths($from);
}
function date_convert($date){
    return $date = date("j F Y", strtotime($date));
}
function get_profile_image($user_image){
	
	$image_url = htmlAsset('images/user-avatar.jpg');
    if(File::exists(storage_path('app/public/uploads/user/small/'.$user_image)) && !empty($user_image)){
		$image_url = asset('storage/uploads/user/small/'.$user_image);
	}
	
	return $image_url;
	
}

function get_profile_large_image($user_image){
	
	$image_url = htmlAsset('images/person01.jpg');
    if(File::exists(storage_path('app/public/uploads/user/large/'.$user_image)) && !empty($user_image)){
		$image_url = asset('storage/uploads/user/large/'.$user_image);
	}
	
	return $image_url;
	
}
function get_farm_image($farm_image){
        
    if(File::exists(storage_path('app/public/uploads/farm/image/small/'.$farm_image)) && !empty($farm_image)){
		$image_url = asset('storage/uploads/farm/image/small/'.$farm_image);	
    }
    else {
        $image_url = htmlAsset('images/farm_default.jpg');
    }
		
	return $image_url;
	
}
function get_farm_large_image($farm_image){
		
    if(File::exists(storage_path('app/public/uploads/farm/image/large/'.$farm_image)) && !empty($farm_image)){
		$image_url = asset('storage/uploads/farm/image/large/'.$farm_image);	
    }
    else {
        $image_url = htmlAsset('images/farm_default_large.jpg');
    }	
	return $image_url;
	
}
function get_crop_image($crop_image,$type="image"){
		
	$image_url = asset('storage/uploads/agriculture/'.$type.'/'.$crop_image);
	return $image_url;
	
}
function cropGalleryImage($crop_image,$type="large"){
		
	$image_url = asset('storage/uploads/gallery/'.$type.'/'.$crop_image);
	return $image_url;
	
}


function toAcre($area_val,$area_unit){
	
	$acre = 0;
	if($area_unit == 'M2')
	{
		$acre = $area_val * 0.000247105;
	}
	if($area_unit == 'Feet')
	{
		$acre = $area_val * 0.00002295684;
	}
    //$acre = number_format((float)$acre, 1, '.', '');
    $acre = round($acre,4);
	if($area_unit == 'Acre')
	{
		$acre = $area_val;
	}
	
	
	return $acre.' acre';
}

function getAcronym($string){
	preg_match_all("/[A-Z]/", ucwords(strtolower($string)), $matches);
	// pre($matches);
	return implode('',$matches[0]);
}
function pad_left($value,$count) {
	
	return str_pad($value,$count,0,STR_PAD_LEFT);
}
function getUploadImage($fileName){
	
	if(Storage::disk('local')->has('/public/uploads/default_uploads/'.$fileName)){
		$file = asset('storage/uploads/default_uploads/'.$fileName);
	}else{
		$file = asset('assets/images/small_gallery1.jpg');
	}
	return $file;
}
function calculateFgCommission($minAmout,$percentage,$customerPrice){
	 $commission=$customerPrice*($percentage/100);
	 return ($commission > $minAmout)?$commission:$minAmout;
}

function getMonthList(){
    $monthArr = [];
    for($m=1; $m<=12; ++$m){
        $monthArr[] =  date('F', mktime(0, 0, 0, $m, 1));
    }
    return $monthArr;
}
function PP($fileName){
	
	$file = asset('assets/defaults/no-image.svg');
	
	if(empty($fileName)) return $file;
	$thumb = null;
	if( app("Jenssegers\Agent\Agent")->isMobile() || app("Jenssegers\Agent\Agent")->isTablet()){
		$thumb = PT($fileName);
		if(!empty($thumb)) return $thumb;
	} 
	
	if(Storage::disk('local')->has('/public/post/large/'.$fileName)){
		$file = asset('storage/post/large/'.$fileName);
	}else if(Storage::disk('local')->has('/public/post/'.$fileName)){
		$file = asset('storage/post/'.$fileName);
	}	
	return $file;
}
function PB($fileName){
	
	$file = asset('assets/defaults/no-image.svg');
	
	if(empty($fileName)) return $file;
	$thumb = null;
	if(Storage::disk('local')->has('/public/post/'.$fileName)){
		$file = asset('storage/post/'.$fileName);
	}else if(Storage::disk('local')->has('/public/post/large/'.$fileName)){
		$file = asset('storage/post/large/'.$fileName);
	}else if(Storage::disk('local')->has('/public/post/'.$fileName)){
		$file = asset('storage/post/'.$fileName);
	}	
	return $file;
}

function PT($fileName){
	$file = asset('assets/defaults/no-image.svg');
	
	if(Storage::disk('local')->has('/public/post/thumb/'.$fileName)){
		$file = asset('storage/post/thumb/'.$fileName);
	}else if(Storage::disk('local')->has('public/post/'.$fileName)){
		$file = asset('storage/post/'.$fileName);
	}	
	return $file;
	
}
function encloseWordSpan($sentence){
	return '<span>'.implode('</span><span>',explode(' ',$sentence)).'</span>';
}

function formatCurrency($from,$to,$amount){
	$fmt = new NumberFormatter($from, NumberFormatter::CURRENCY);
	return $fmt->formatCurrency($amount, $to);
	
}

function deliverableEmirateHTML($emirateList){
	$str = '';
	$lastEmirate = array_splice($emirateList, -1, 1);
	$str .= '<strong>'.implode('</strong>,<strong> ',array_map('ucfirst',$emirateList) ).'</strong>';
	$str .= ' '.lang('and').' <strong>'.ucfirst($lastEmirate[0]).'</strong>';
	return str_replace('-',' ',$str);
} 

function count_recursive($array)
{
	if (!is_array($array)) {
		return 1;
	}

	$count = 0;
	foreach ($array as $sub_array) {
		$count += count_recursive($sub_array);
	}

	return $count;
}

function formatAmount($price)
{   
    //return round($price,2);
	return number_format(round($price,2), 2, '.', '');
}

function numberFormatK($num) {

  if($num>=1000) {

        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];

        return $x_display;
  }
  return $num;
}

function documentPopupType($file){
	$type = pathinfo($file, PATHINFO_EXTENSION);
	return ($type=="pdf")?'data-type=iframe':'';
	
}
function unitAbbreviation($unit){
	$unitArr=[
	   'gram'=>'g',
	   'kilogram'=>'kg',
	   'piece'=>'piece',
	   'ton'=>'t',
	   'lbs'=>'lbs',
	   'ounce'=>'oz',
	   'stone'=>'st',
	   'liter'=>'l',
	   'milliliter'=>'ml',
	];
	
	return (isset($unitArr[$unit]))?$unitArr[$unit]:$unit;
}
function strParagaraph($text)
{
	
	$text = Str::lower($text);
	return sentence_case($text);
	
}
function sentence_case($string) {
    $sentences = preg_split('/([.?!]+)/', $string, -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
    $new_string = '';
    foreach ($sentences as $key => $sentence) {
        $new_string .= ($key & 1) == 0?
            ucfirst(strtolower(trim($sentence))) :
            $sentence.' ';
    }
    return trim($new_string);
}

function reformatDeliveryPincodesForPopUp($collection){
    $result = [];
    foreach($collection as $item){
        $result[$item['countryId']]['countryId']=$item['countryId'];
        $result[$item['countryId']]['deliveryLocation']=$item['deliveryLocation'];
        $result[$item['countryId']]['countryName']=$item['countryName'];
        $result[$item['countryId']]['countryISO']=$item['countryISO'];
        $result[$item['countryId']]['homeDeliveryCharge']=$item['homeDeliveryCharge'];
        $result[$item['countryId']]['provideFreeDeliveryAboveAmt']=$item['provideFreeDeliveryAboveAmt'];
        $result[$item['countryId']]['minBulkDeliveryPrice']=$item['minBulkDeliveryPrice'];
        // $result[$item['countryId']]['pincodeStr']=$item['pincodeStr'];
        $result[$item['countryId']]['fdc_currency']=$item['fdc_currency'];
        $result[$item['countryId']]['enterDeliveryCharge']=$item['enterDeliveryCharge'];
        $result[$item['countryId']]['enterMinFreeAmt']=$item['enterMinFreeAmt'];
        
        foreach($item['pincodes'] as $pincode){
			$result[$item['countryId']]['pincodes'][$pincode->fdp_slug]=$pincode->fdp_pincode_or_location;	
			
        }
    }

    return collect($result);
} 
function formatRating($number)
{   
	return round($number,2);
}
function ratingPercentage($count,$total)
{
	$percentage= ($count > 0)? ($count/$total)*100 :0;
	return round($percentage,2);
}
	
?>