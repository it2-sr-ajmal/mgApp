<?php
namespace App\Traits;
use App;

trait CustomCategoryTrait {
	
	/**
		* function returns Array()
		* used to render data-attributes automatically except specified here.
		* NOTE : some attributes are already hard coded like : data-slug 
	**/
	function _getAttribsToIgnore(){
		return [
			"category_id",
			"category_parent_id",
			"category_title",
			"category_title_arabic",
			"category_slug",
			"category_image",
			"category_icon",
			"category_created_at",
			"category_updated_at",
			"category_created_by",
			"category_updated_by",
			"deleted_at",
			"category_status"
		];
	}
	
	
	
	/**
     * Add Generate Anchor Element with attributes
     *
     * @param mixed $attr
     * @param mixed $value
     *
     * @return object (instance)
     */
	function anchorString($dataObj ,$li,$extra = ''){
		die('asd');
		$allStr = '';
		
		$href = '#'. $dataObj['category_slug'];

		if(!empty($this->optionAnchorAttr)){
			$attrStr = ' ';
			foreach($this->optionAnchorAttr as $liAttr => $anchorAttrVal){
				if(isset($dataObj[$anchorAttrVal])){
					$anchorAttrVal = ($liAttr == 'data-href') ? $href : $dataObj[$anchorAttrVal];
				}
				$attrStr .= $liAttr.'="'.$anchorAttrVal.'" ';
			}
			$allStr.= $attrStr;
			
		}
	
		if(!empty($dataObj)){
			$allStr.='aria-title="'.$this->getDataByLang($dataObj,'category_title').'"';
			if(strpos($allStr,'class')){
				$allStr = str_replace('class="','class="scroll ',$allStr);
			}
		}

		$iconIdom = (isset($li['data-icon-class'])) ? '<i class="'.$li['data-icon-class'].'"></i>' : '';
		return "\n\t".'<a '.$allStr.' href="'.$href.'">'.$iconIdom.$li['label'].'</a>';
		
	}
	
	/**
		* Get Menu Variable data based on App language
	**/
	
	function _getDataByLang($dataObj,$key){
		
		$val = '';
		if(\App::getLocale() == 'en'){
			$val = $dataObj[$key];
		}elseif(isset($dataObj[$key.'_arabic'])){
			$val = $dataObj[$key.'_arabic'];
		}elseif(isset($dataObj[$key.'_ar'])){
			$val = $dataObj[$key.'_ar'];
		}
		return $val;
		
	}	
	
	function _getMenuTitleForAdmin($dataObj,$key){
		
		$val = $dataObj[$key];
		if(isset($dataObj[$key.'_arabic'])){
			$val .= ' | <span dir="rtl">'.$dataObj[$key.'_arabic'].'</span>';
		}elseif(isset($dataObj[$key.'_ar'])){
			$val .= ' | <span dir="rtl">'.$dataObj[$key.'_ar'].'</span>';
		}
		return $val;
		
	}
	
	/**
		* Merge All the atrtibute Strings (ul,li,a)
		* @return Array
	**/
	function _getAllAttrString($dataObj,$li,$extra,$hasChild){
		
		$allAttrStr = '';
		$submenuSpan = '';
		
		$allAttrStr.= $this->_getUlLiAttribs($dataObj);
		$allAttrStr.= $this->_getAnchorAttribs($li);
		
		
		$allAttrStr = str_replace('class="','class="'.$extra.' ',$allAttrStr);
		
		if($hasChild){
			$allAttrStr = str_replace('class="','class="dropdown smallMenu has-submenu '.$extra,$allAttrStr);
			$submenuSpan = "\n".' <span class="arrow-submenu"></span> ';
		}
		
		return [$allAttrStr,$submenuSpan];
	}
	
	
	function openLi($dataObj,array $li, $extra = '',$hasChild=false)
    {
	    // pre($dataObj);
		
		$anchorString = $this->anchorString($dataObj,$li, $extra);
		
		list($allAttrStr,$submenuSpan) = $this->_getAllAttrString($dataObj,$li,$extra,$hasChild);
		
        return "\n".'<li '.$allAttrStr.'>'.$submenuSpan.$anchorString."\n";
    }
	/**
		* Get UL Attributes
		* @return String
	**/
	private function _getUlLiAttribs($dataObj){

		$attrStr = ' ';
		if(!empty($this->optionLiAttr)){
			
			foreach($this->optionLiAttr as $liAttr => $liAttrVal){
				if(isset($dataObj[$liAttrVal])){
					$liAttrVal = $dataObj[$liAttrVal];
				}
				$attrStr .= $liAttr.'="'.$liAttrVal.'" ';
			}			

		}
		return 	$attrStr;
	}
	
	/**
		* Get a Attributes
		* @return String
	**/
	private function _getAnchorAttribs($li){
		
		$attrStr = ' ';
		if(!empty($li)){
			$attrStr = '';
			$anchorAttrToIgnore = ['label','href'];
			foreach($li as $liAttr => $liAttrVal){
				
				if(in_array($liAttr,$anchorAttrToIgnore)){
					continue;
				}
				$attrStr .= $liAttr.'="'.$liAttrVal.'" ';
			}
		}
		return $attrStr;
	}
	
}
?>
