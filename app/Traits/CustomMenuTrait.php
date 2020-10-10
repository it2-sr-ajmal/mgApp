<?php
namespace App\Traits;
use App;

trait CustomMenuTrait {
	
	/**
		* function returns Array()
		* used to render data-attributes automatically except specified here.
		* NOTE : some attributes are already hard coded like : data-slug 
	**/
	function _getAttribsToIgnore(){
		return [
			'mm_id',
			'mm_parent_id',
			'mm_slug',
			'mm_title',
			'mm_title_arabic',
			'mm_large_title',
			'mm_large_title_arabic',
			'mm_show_in_main_menu',
			'mm_show_in_mobile_menu',
			'mm_show_in_footer_menu',
			'mm_is_hash_link',
			'mm_is_hash_link_in_home_only',
			'mm_priority',
			'mm_created_at',
			'mm_updated_at',
			'mm_created_by',
			'mm_updated_by',
			'mm_status'
		];
	}
	
	
    /**
     * Add attribute to <ul> element.
     *
     * @param mixed $attr
     * @param mixed $value
     *
     * @return object (instance)
     */
    public function liAttr($attr, $value = '')
    {
		// pre($attr);
        if (func_num_args() > 1) {
            $this->optionLiAttr[$attr] = $value;
        } elseif (is_array($attr)) {
            $this->optionLiAttr = $attr;
        }else if (is_callable($attr)) {
            $this->optionLiAttr['callback'] = $attr;
        }

        return $this;
    }
    
	/**
     * Add attribute to <ul> element.
     *
     * @param mixed $attr
     * @param mixed $value
     *
     * @return object (instance)
     */
	 
    public function anchorAttr($attr, $value = '')
    {
        if (func_num_args() > 1) {
            $this->optionAnchorAttr[$attr] = $value;
        } elseif (is_array($attr)) {
            $this->optionAnchorAttr = $attr;
        }else if (is_callable($attr)) {
            $this->optionAnchorAttr['callback'] = $attr;
        }

        return $this;
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
		
		$allStr = '';

		$href = ((request()->route()->getName() == 'home' && $dataObj['mm_is_hash_link_in_home_only'] == 1) || ($dataObj['mm_is_hash_link'] == 1 ))  ? '#'. $dataObj['mm_slug'] : $li['href'];
		
		if(!empty($this->optionAnchorAttr)){
			$attrStr = ' ';
			foreach($this->optionAnchorAttr as $liAttr => $liAttrVal){
				if(isset($dataObj[$liAttrVal])){
					$liAttrVal = $dataObj[$liAttrVal];
				}
				$attrStr .= $liAttr.'="'.$liAttrVal.'" ';
			}
			$allStr.= $attrStr;
			
		}
	
		if(!empty($dataObj)){
			$allStr.='aria-title="'.$this->getDataByLang($dataObj,'mm_title').'"';
			if(strpos($allStr,'class')){
				if( (request()->route()->getName() == 'home' && $dataObj['mm_is_hash_link_in_home_only'] == 1) || ($dataObj['mm_is_hash_link'] == 1 ) ){
					$allStr = str_replace('class="','class="scroll ',$allStr);
				}
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
	
	/**
		* Merge All the atrtibute Strings (ul,li,a)
		* @return Array
	**/
	function _getAllAttrString($dataObj,$li,$extra,$hasChild){
		
		$allAttrStr = '';
		$submenuSpan = '';
		
		$allAttrStr.= $this->_getUlAttribs($dataObj);
		$allAttrStr.= $this->_getAnchorAttribs($li);
		
		
		
		$allAttrStr = str_replace('class="','class="'.$extra.' ',$allAttrStr);
		
		if($hasChild){
			$allAttrStr = str_replace('class="','class="dropdown smallMenu has-submenu '.$extra,$allAttrStr);
			$submenuSpan = "\n".' <span class="arrow-submenu"></span> ';
		}
		
		return [$allAttrStr,$submenuSpan];
	}
	
	/**
		* Get UL Attributes
		* @return String
	**/
	private function _getUlAttribs($dataObj){
		
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
