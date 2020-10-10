$('body').on('change', '#expected_harvest_quantity_unit', function (e) {

        var unit = $(this).val();

        //update portion unit
        $('#portion_weight_unit').val(unit);
        if(unit == "piece"){
			$('#piece_weight').removeClass('hide');
			$('#approximate_weight').attr('required',true); 
			
		}else{
			$('#piece_weight').addClass('hide');
			$('#approximate_weight').removeAttr('required');
		}
        //if unit is piece then restric to change portion unit
        if (unit == "piece" || unit == "liter" || unit == "milliliter") {
			
            $('#portion_weight_unit option[value="'+unit+'"]').prop('disabled', '');
            $('#portion_weight_unit option[value!="'+unit+'"]').prop('disabled', 'disabled');
			if( unit == "liter" || unit == "milliliter"){
				 $('#portion_weight_unit option[value="milliliter"]').prop('disabled', '');
				 $('#portion_weight_unit option[value="liter"]').prop('disabled', '');
			}
        } else {
            $('#portion_weight_unit option[value!="piece"]').prop('disabled', '');
            $('#portion_weight_unit option[value="piece"]').prop('disabled', 'disabled');
            $('#portion_weight_unit option[value="liter"]').prop('disabled', 'disabled');
            $('#portion_weight_unit option[value="milliliter"]').prop('disabled', 'disabled');
        }

        //refresh select box
        // $('#portion_weight_unit').selectric('refresh');
		// HarvestCalendar.initCalender();
});