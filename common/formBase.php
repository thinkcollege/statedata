<?php
/*
 class: functions
 purpose: useful functions
 */
class formBase extends mre_base{

	const validate_function_name = 'ValidateForm';

	protected function formBase () {}

	/**
	 * This function is a fancy way of returning null.
	 * 
	 * @return null
	 */
	private function getFullUrl() {
		return $full_url;
	}

	static function date_db_to_form($date, $delimiter = "/") {
		return substr($date, 5, 2).$delimiter.substr($date, 8, 2);
	}

	static function datetime_to_string($datetime, $format = 'm/d/y') {
		$string = "";
		$months = array('01' => "January", '02' => "February", '03' => "March", '04' => "April", '05' => "May", '06' => "June", '07' => "July", '08' => "August", '09' => "September", 10 => "October", 11 => "November", 12 => "December");
		switch ($format) {
			case 'm-d':
				$string = substr($datetime, 5, 2).'/'.substr($datetime, 8, 2);
				break;
			case 'm':
				$string = $months[substr($datetime, 5, 2)];
				break;
			default:
				if (strpos($datetime,"/") !== false) {
					if (strpos($datetime, "/") == 4) {
						$string = substr($datetime, 5, 2).'/'.substr($datetime, 8, 2).'/'.substr($datetime, 0, 4);
					} else {
						$string = $datetime;
					}
				} else {
					$string = substr($datetime, 5, 2).'/'.substr($datetime, 8, 2).'/'.substr($datetime, 0, 4);
				}
				if ($string == "//") {
					$string = "";
				}
				break;
		}
		return $string;
	}

	static function string_to_datetime($datetime, $format='y-m-d') {
		if ($datetime == "") {
			return "";
		}

		switch ($format) {
			case 'm-d':
				$string = substr($datetime, 5, 2).'/'.substr($datetime, 8, 2);
				break;
			case 'm':
				$string = $months[substr($datetime, 5, 2)];
				break;
			default:
				$string = substr($datetime, 6, 4).'-'.substr($datetime, 0, 2).'-'.substr($datetime, 3, 2);
				break;
		}
		return $string;
	}

	static function datetime_to_time($datetime) {
		$hour = substr($datetime, 11, 2);
		if ($hour > 12) {
			$hour = $hour - 12;
			$ampm = 'PM';
		} else {
			$ampm = 'AM';
		}
		if ($hour == '00') {
			$hour = '12';
		}
		if (substr($datetime, 11, 2) < 12) {
			$ampm = 'AM';
		} else {
			$ampm = 'PM';
		}
		$string = $hour.substr($datetime, 13, 3).' '.$ampm;
		return $string;
	}

	static function date_array_to_string($array) {
		write_debug("in date_array_to_string");
		if (has_value('mday', $array)) {
			return str_pad($array['mon'], 2, "0", STR_PAD_LEFT).'/'.str_pad($array['mday'], 2, "0", STR_PAD_LEFT).'/'.$array['year'];
		} else {
			return str_pad($array['mon'], 2, "0", STR_PAD_LEFT).'/'.$array['year'];
		}
	}

	static function build_date_picker ($varname, $value = '', $showsTime = "false",  $container_styles = '', $on_change = '') {
		
		if ($on_change != '') {
			$on_change = "onchange=\"". $on_change ."\"";
		}
		$html = <<<DATEPICKER
		<div id="container_$varname" style="$container_styles">
		<input type="text" name="$varname" id="$varname" value="$value" size="17" $on_change />&nbsp;<img id="trigger_$varname" style="cursor: pointer; vertical-align: middle" src="/images/icons/icon_calendar.gif" alt="Date" /></div><script type="text/javascript">
		document.getElementById("trigger_$varname").disabled = false;
		Calendar.setup({
		inputField : "$varname",
		ifFormat : "%m/%d/%Y",
		daFormat : "%m/%d/%Y",
		button : "trigger_$varname",
		showsTime : $showsTime
    });
  </script>
DATEPICKER;
		return $html;
	}

	static function build_hours_select($var, $value) {
		if ($value > 12) {
			$value = $value - 12;
		}
		$select_box .= NEWLINE.'<select name="'.$var.'_hours" id="hours">';
		// $select_box .= '<option value="">Choose Hour</option>';
		for ($option = 1; $option <= 12; $option++) {
			$select_box .= NEWLINE.'<option value="' . $option . '" ';
			if ($option == $value) {
				$select_box .= '  selected ';
			}
			$select_box .= '>'.str_pad($option, 2, "0", STR_PAD_LEFT).'</option>';
		}
		return $select_box . '</select>';
	}

	static function build_minutes_select($var, $value) {
		$select_box .= '<select name="'.$var.'_minutes" id="minutes">';
		for($option = 0; $option <= 45; $option += 15) {
			$select_box .= '<option value="' . $option . '" ';
			if ($option == $value) {
				$select_box .= ' selected ';
			}
			$select_box .= '>'.str_pad($option, 2, "0", STR_PAD_LEFT).'</option>';
		}
		return $select_box . '</select>';
	}

	static function build_form_field ($field, $wrapped = '1', $mode = 'edit', $client_id = '0') {
		$result = "";
		$value = (has_value('value', $field)) ? $field['value'] : '';

		if (has_value('onload', $field) && $mode == "edit") {
			$result .= "<script>Event.observe(window, 'load', {$field["onload"]});</script>";
		}
		$required = (has_value('required', $field) && $field['required'] == 'true')
			? "<span class='required'>* </span>" : '';
		if ($field['type'] == 'threaded_date') {
			if (strlen($current_record_array[$field['sub_field']['varname']]) > 0) {
				$sub_values = $current_record_array[$field['sub_field']['varname']];
			} elseif (isset($field['sub_field']['default'])) {
				$sub_values = $field['default']['sub_field'];
			} else {
				$sub_values = '';
			}
		} else {
			$sub_values = '';
		}
		$class = (isset($field['hide']) && $mode == "edit") ? ' class="hide" ' : ' ';
		
		if ($mode == "edit") {
			$start_tag = (has_value('start_tag_edit', $field)) ? $field['start_tag_edit'] : ' ';
			$end_tag = (has_value('end_tag_edit', $field)) ? $field['end_tag_edit'] : ' ';
		} else {
			$start_tag = (has_value('start_tag_details', $field)) ? $field['start_tag_details'] : ' ';
			$end_tag = (has_value('end_tag_details', $field)) ? $field['end_tag_details'] : ' ';
		}
		if ($field['type'] != 'hidden' && $field['type'] != 'button') {
			$label = (isset($field['label'])) ? $field['label'] : $field['name'];
			$label = ($mode != 'edit') ? str_replace('*',"", $label) : $label;
		}
		switch ($field['type']) {
			case 'textbox':
				if ($mode == "edit") {
					$result .= '<label id="lbl_'.$field['varname'].'" for="'.$field['varname'].'"'.$class.' class="desc">'. $required . $label.' </label><br/><textarea name="'.$field['varname'].'" id="'.$field['varname'].'" rows="'.$field['rows'].'" cols="'.$field['cols'].'">'.$value.'</textarea>'.NEWLINE;
				} else {
					$result .= '<label id="lbl_'.$field['varname'].'" for="'.$field['varname'].'"'.$class.' class="desc">'.$label.' </label><div class="answer">'.$value."</div>".NEWLINE;
				}
				break;
			case 'hidden':
				$result .= '<input type="hidden" name="'.$field['varname'].'" id="'.$field['varname'].'" value="'.$value.'" />'.NEWLINE;
				break;
			case 'static':
				$result .= '<label id="lbl_'.$field['varname'].'" for="'.$field['varname'].'">'.$label.' </label> <input type="hidden" name="'.$field['varname'].'" value="'.$value.'" />'.$current_record_array[$field['disp_var']].NEWLINE;
				break;
			case 'checkbox':
				if ($mode == "edit") {
					$result .= '<input type="checkbox" name="'.$field['varname'].'" id="'.$field['varname'].'" value="'.$field['value'].'"';
					if ($value == $field['value']) {
						$result .= ' CHECKED ';
					}
					$result .= '/> <label id="lbl_'.$field['varname'].'" class="checkbox" for="'.$field['varname'].'">'.$label.' </label> '.NEWLINE;
				} else {
					$result .= '<label  for="'.$field['varname'].'">'.$label.' </label><div class="answer">'.$field['value']."</div>".NEWLINE;
				}
				break;
			case 'checkboxwithother':
				$other_field = $field['varname'].'_text';
				if (array_key_exists($other_field, $current_record_array)) {
					$val_other = $current_record_array[$other_field];
				} else {
					$val_other = '';
				}
				$result .= '<input type="checkbox" name="checkbox'.$field['varname'].'" id="checkbox'.$field['varname'].'" value="'.$field['value'].'"';

				if ($value != '') {
					$result .= ' CHECKED ';
				}
				$result .= '/> <label id="lbl_'.$field['varname'].'" class="checkbox" for="checkbox'.$field['varname'].'">'.$label.' </label> '.NEWLINE.'<input type="text" name="'.$other_field.'" id="'.$other_field.'" value="'.$val_other.'" size = "'.$field['size'].'" maxlength="'.$field['maxlength'].'" /><br />'.NEWLINE;
				break;

			case 'select':
				if ($mode == "edit") {
					if ($label != "") {
						$result .= '<label id="lbl_'.$field['varname'].'" for="'.$field['varname'].'">'.$required . $label.' </label>'.NEWLINE.TABBREAK.'<br/>';
					}
					if (has_value('ShowHeadering', $field)) {
						$ShowHeading = $field["ShowHeading"];
					} else {
						$ShowHeading = 1;
					}
					$result .= formBase::build_db_to_select($field, $value, $ShowHeading);
				} else {
					if ($label != "") {
						$result .= '<label id="lbl_'.$field['varname'].'" for="'.$field['varname'].'">'.$label.' </label>';
					}
					$result .= '<div class="answer">'.$value."</div>".NEWLINE.TABBREAK;
				}
				break;

				//need to finish this one then do the javascript validation
			case 'checkbox_from_table':
				if ($mode == "edit") {
					$result .= '<label id="lbl_' . $field['varname'] . '" for="' . $field['varname']
					. '">' . $required . $label . ' </label>' . NEWLINE . TABBREAK . '<br/>'
					. formBase::build_db_to_checkbox($field, $client_id);
				} else {
					$result .= '<label id="lbl_'.$field['varname'].'" for="'.$field['varname'].'">'.$label.' </label><div class="answer">'.$value."</div>".NEWLINE.TABBREAK;
				}
				break;

			case 'radio':
				$result .= '<label id="lbl_'.$field['varname'].'" class="desc">'.$label.' </label><span>';
				foreach ($field['options'] as $option => $val) {
					$result .= TABBREAK.'<input type="radio" name="'.$field['varname'].'" id="'.$field['varname'].$value.'" class="field radio" value="'.$value.'"';
					if ($value == $val)	{
						$result .= ' CHECKED ';
					}
					$result .= '/> <label  class="choice" for="'.$field['varname'].$value.'">'.$option.'</label>'.NEWLINE;
				}
				$result .= '</span>';
				break;

			case 'radiowithother':
				$other_field = $field['varname'].'_text';
				$val_other = (has_value($other_field, $current_record_array)) ? $current_record_array[$other_field] : '';
				$result .= '<label id="lbl_'.$field['varname'].'" class="desc">'.$label.' </label><span>';
				$num_opts = count($field['options']);
				$curr_opt = 1;
				foreach ($field['options'] as $option => $val) {
					$result .= TABBREAK.'<input type="radio" name="'.$field['varname'].'" id="'.$field['varname'].$value.'" class="field radio"  value="'.$value.'"';
					if ($value == $val) {
						$result .= ' CHECKED ';
					}
					$result .= '/><label  class="choice" for="'.$field['varname'].$value.'">'.$option.'</label>';
					if ($curr_opt == $num_opts) {
						$result .= ' <input type="text" name="'.$other_field.'" id="'.$other_field.'" value="'.$val_other.'" size = "'.$field['size'].'" maxlength="'.$field['maxlength'].'" class="field text"/>';
					}
					$curr_opt++;
				}
				$result .= '</span>'.NEWLINE;
				break;

			case 'selectwithother':
				$other_field = $field['varname'].'1';
				$val_other = (has_value($other_field, $current_record_array)) ? $current_record_array[$other_field] : '';
				$result .= '<label id="lbl_'.$field['varname'].'" for="'.$field['varname'].'">'.$label.' </label> '.NEWLINE.TABBREAK.'<select name="'.$field['varname'].'" id="'.$field['varname'].'">'.NEWLINE;
				foreach ($field['options'] as $option => $val) {
					$result .= TABBREAK.'<option value="'.$value.'" ';
					if ($value == $val) {
						$result .= 'SELECTED';
					}
					$result .= '>'.$option.'</option>'.NEWLINE;
				}
				$result .= TABBREAK.'</select>'.NEWLINE.'<br /><input type="text" name="'.$other_field.'" id="'.$other_field.'" value="'.$val_other.'" size = "'.$field['size'].'" />'.NEWLINE;
				break;

			case 'selectwithdesc':
				$other_field = $field['varname'].'_desc';
				$val_other = (has_value($other_field, $current_record_array)) ? $current_record_array[$other_field] : '';
				$result .= '<label id="lbl_'.$field['varname'].'" for="'.$field['varname'].'">'.$label.' </label> '.NEWLINE.TABBREAK.'<select name="'.$field['varname'].'" id="'.$field['varname'].'">'.NEWLINE;
				foreach ($field['options'] as $option => $val) {
					$result .= TABBREAK.'<option value="'.$value.'" ';
					if ($value == $val) {
						$result .= 'SELECTED';
					}
					$result .= '>'.$option.'</option>'.NEWLINE;
				}
				$result .= TABBREAK.'</select>'.NEWLINE.'<br /><label for="'.$other_field.'">Describe: </label> <textarea name="'.$other_field.'" rows="'.$field['rows'].'" cols="'.$field['cols'].'">'.$val_other.'</textarea>'.NEWLINE;
				break;
				
			case 'date':
				if ($mode == "edit") {
					if (strlen($value) < 2) {
						$value = formBase::date_array_to_string(getdate());
					} else if (!strpos($value,"/")) {
						$value = substr($value, 5, 2).'/'.substr($value, 8, 2).'/'.substr($value, 0, 4);
					} else {
						$value = formBase::datetime_to_string($value);
					}
					$result .= '<label id="lbl_'.$field['varname'].'" for="'.$field['varname'].'">'.$required . $label.' </label>  <br/>'. formBase::build_date_picker($field['varname'], $value).NEWLINE;
					if (has_value('name_time', $field)) {
						$result .= $end_tag.$start_tag.'<label for="'.$field['varname'].'_time">'.$field['name_time'].' </label>  '.formBase::build_hours_select($field['varname'],substr($value, 11, 2)).' : '.build_minutes_select($field['varname'],substr($value, 13, 2)).NEWLINE;
					}
				} else {
					write_debug("not in date_array_to_string");
					$result .= '<label id="lbl_'.$field['varname'].'" for="'.$field['varname'].'">'.$label.' </label>';
					if (strstr($value,"/")) {
						$result .= '<div class="answer">'. formBase::datetime_to_string($value) .'</div>'.NEWLINE;
					} else {
						$result .= '<div class="answer">'.substr($value, 5, 2).'/'.substr($value, 8, 2).'/'.substr($value, 0, 4)."</div>".NEWLINE;
					}
				}
				break;

			case 'title':
				$result .= ''.$label.''.NEWLINE;
				break;
			case "password":
				if ($mode == "edit") {
					$fieldsize = (has_value('size', $field)) ? ' size="'.$field['size'].'" ' : '';
					$max = (has_value('max', $field)) ? ' maxlength="'.$field['max'].'" ' : '';
					$result .= '<label id="lbl_'.$field['varname'].'" for="'.$field['varname'].'"'.$class
						 	 . ' class="desc">'.$label.'</label> <div><input type="password" name="'.$field['varname'].'" id="'.$field['varname'].'" value="'.$value.'"'.$fieldsize.$max.' class="field text medium"/></div>'.NEWLINE.'';
				} else {
					$result .= '<label id="lbl_'.$field['varname'].'" for="'.$field['varname'].'"'.$class.' class="desc">'.$label.'</label>'.NEWLINE.TABBREAK.'<div class="answer">'.$value.'</div>'.NEWLINE.'';
				}
				break;
			case "file":
				if ($mode == "edit") {
					$fieldsize = (has_value('size', $field)) ? ' size="'.$field['size'].'" ' : '';
					$max = (has_value('max', $field)) ? ' maxlength="'.$field['max'].'" ' : '';
					$result .= '<label id="lbl_' . $field['varname'] . '" for="' . $field['varname'] . '" class="desc' . $class . '">' . $label . '</label> ' . '<div><input type="file" name="' . $field['varname'] . '" id="'	. $field['varname'] . '" value="' . $value . '"' . $fieldsize . $max . ' class="field text medium" /></div>';
				}
				break;
			case "button":
				$result .= $this->build_button($field["text"], $field["js_action"]);
				break;
			default:
				if ($mode == "edit") {
					$fieldsize = (isset($field['size'])) ? ' size="'.$field['size'].'" ' : '';
					$max = (isset($field['max'])) ? ' maxlength="'.$field['max'].'" ' : '';
					$result .= '<label id="lbl_'.$field['varname'].'" for="'.$field['varname'].'"'.$class.' class="desc">'.$required . $label.'</label> <div><input type="text" name="'.$field['varname'].'" id="'.$field['varname'].'" value="'.$value.'"'.$fieldsize.$max.' class="field text medium"/></div>'.NEWLINE.'';
				} else {
					$result .= '<label id="lbl_'.$field['varname'].'" for="'.$field['varname'].'"'.$class.' class="desc">'.$label.'</label>'.NEWLINE.TABBREAK.'<div class="answer">'.$value.'</div>'.NEWLINE.'';
				}
				break;
		}
		if ($wrapped == "1") {
			$result = "<div class='formrow'>".$result."</div>";
		}
		return $start_tag . $result . $end_tag;
	}

	static function build_select($fieldname, $options, $value = "") {
		if (is_array($options)) {
			$select_box = '<select name="'.$fieldname.'" id="'.$fieldname.'">';
			foreach ($options as $option => $val) {
				$select_box .= '<option value="'.$option.'" ';
				if ($option == $value || ($option == "" && $value == "")) {
					$select_box .= 'SELECTED';
				}
				$select_box .= '>'.$val.'</option>';
			}
			$select_box .= '</select>';
		} else {
			$select_box = ' <br /><textarea name="'.$fieldname.'" id="'.$fieldname.'" rows="6" cols="40"></textarea>';
		}
		return $select_box;
	}

	/**
	 * Gather options from a table in the database and generate a valid HTML select box.
	 *
	 * @todo find all calls to this function.
	 * @param array $field
	 * @param mixed $value
	 * @param int $showHeading
	 * @param string $query
	 * @return string
	 */
	static function build_db_to_select ($field, $value = '', $showHeading = 1, $query = '') {
		$select_box = '<select name="'.$field['varname'].'" id="'.$field['varname'].'"';
		if (has_value("onchange", $field)) {
			$select_box .= ' onchange="' . $field['onchange'] . '" ';
		}
		if (has_value("size", $field)) {
			$select_box .= ' size="' . $field['size'] . '" ';
		}
		$select_box .= '>';
		
		$database = Database::getDatabase();
		if ($query == "") {
			$value = intval($value);
			$query = "SELECT id AS Val, value AS Opt, IF($value = id, ' selected=\"selected\"', '') AS Selected
						FROM {$field['lookup']} ";
			if (has_value("luorderby", $field)) {
				$query .= "order by " . $field['luorderby'];
			} else {
				$query .= "order by sort_order, value";
			}
		}
		$results = $database->query($query);

		if ($showHeading == 1) {
			//$html = $html . "<option value=ALL>ALL</option>";
			$select_box .= "<option value='0'>Please select</option>";
		} else if ($showHeading != "") {
			$select_box .= $showHeading;
		}
		while (($row = $database->fetch_assoc($results)) != null) {
			if (!isset($row['Val'])) {
				throw new Exception('Query did not follow build_db_to_select() req!');
			}
			$select_box .= '<option value="'.$row['Val'].'"'.$row['Selected'] . '>'.$row['Opt'].'</option>';
		}

		return $select_box . "</select>".NEWLINE;
	}

	/**
	 * Enter description here...
	 *
	 * @todo Find all calls to this function.
	 * @param array $field
	 * @param int $client_id
	 */
	static function build_db_to_checkbox($field, $client_id = 0) {
		$check_box = "";
		$database = Database::getDatabase();
		$query = "SELECT tLu.id AS Val, tLu.value AS Opt, IF(tStr.lu_id  > 0, ' checked=\"checked\"', '') AS Checked
					FROM {$field["lookup"]} tLu
			   LEFT JOIN {$field['storage']} tStr ON tStr.lu_id = tLu.id AND tStr.client_id = $client_id";
		/**
		 * hacky
		 * if we need to keep the history of the selected check boxes, just select the most recent ones
		 * it will be saved with a date and this will be used as the most recent values
		 * so query to get the most recent date, then query again with this value as the limit
		 * 
		 * Hack Update:
		 * I've combined the 3 quries into 1.  The part above replaces the inner for
		 * loop from below while the part in the if block below replaces the whole if block.
		 */
		if (has_value('keephistory', $field) && $field["keephistory"] == "yes") {
			$query .= " AND tStr.{$field['limitfield']} = (SELECT {$field['limitfield']} FROM {$field['storage']} {$field["groupby"]} ORDER BY  {$field["orderby"]} LIMIT 0,1)";
			/*write_debug("*** " . $query);
			$storage_results = $database->query($query);
			if ($database->num_rows($storage_results) > 0) {
				$limit = $database->fetch_result($storage_results, 0, $field["limitfield"]);
			}
			$query = "SELECT * FROM ".$field["storage"]." WHERE client_id = '$client_id' and ".$field["limitfield"]." = '". $limit ."'";*/
		}
		if (has_value("luorderby", $field)) {
			$query .= " ORDER BY tLu." . $field["luorderby"];
		} else {
			$query .= " ORDER BY tLu.sort_order, tLu.value";
		}
		$results = $database->query($query);

		while (($row = $database->fetch_assoc($results)) != null) {
			$check_box .= '<input type="checkbox" name="'.$field["varname"].'[]" id="'.$field["varname"].'_'.$row['Val'].'" value="'.$row['Val'].'"'.$row['Checked']
						. ' /><label for="'.$field["varname"].'_'.$row['Val'].'" style="padding-left:5px;font-weight:normal">'.$row['Opt'].'</label><br/>'.NEWLINE;
		}
		return $check_box;
	}

	static function build_button($text = 'Submit', $js_action = '', $wrap = 1) {
		if ($js_action == '') {
			$js_action = 'document.forms[0].submit();';
		}
		if ($wrap == 1) {
			return <<<BUTTON
			<div class="buttonrow"><input type="button" name="action" value="$text" onclick="$js_action" /></div>
BUTTON;
		} else {
			return <<<BUTTON
			<input type="button" name="action" value="$text" onclick="$js_action" />
BUTTON;
		}
	}

	static function build_required_fields_JS($req_flds) {
		write_debug("build_required_fields_JS");
		$js = "<script type=\"text/javascript\">function ".formBase::validate_function_name."(){ var focus = false; var msg = '';".NEWLINE;
		$focus = "";
		foreach($req_flds as $field) {
			$error_class_js = '$("lbl_'.$field['varname'].'").addClassName("error");';
			if ($focus == "") {
				$focus = '$("'. $field["varname"] .'").focus(); focus = true; ';
			}
			switch ($field['type']) {
				case 'select':
					$js .= 'if ($("'. $field["varname"] .'").selectedIndex == 0 ) {msg +="\\n' . $field["name"] . ' is required."; '. $error_class_js .'}' .NEWLINE;
					break;
				case 'textbox':
				case 'date':
				case "password":
				case "text":
					$js .= 'if (!$("'. $field["varname"] .'").present() ) {msg +="\\n' . $field["name"] . ' is required."; '. $error_class_js .'}' .NEWLINE;

					break;
				case 'checkbox_from_table':
					$database = Database::getDatabase();
					$chbxQuery = "Select * from ". $field["lookup"];

					$fields = $database->query($chbxQuery );
					$js .= "var " . $field["varname"] ."Checked = false;";
					for ($result = 0; $result < $database->num_rows($fields); $result++) {
						$tempfield = $database->fetch_result($fields,$result,"id");

						if ($focus == '$("'. $field["varname"] .'").focus(); focus = true; ') {
							$focus = '$("'. $field["varname"] .'_'. $tempfield .'").focus(); focus = true; ';
						}
						$js .= 'try{'.NEWLINE;
						$js .= 'if ($("'. $field["varname"] .'_'. $tempfield .'").present()) { '. $field["varname"] .'Checked = true;}'.NEWLINE;
						$js .= '} catch (e) {';

						$js .=  '}'.NEWLINE;
					}
					$js .= 'if (' . $field["varname"] .'Checked != true){ msg +="\\n' . $field["name"] . ' is required."; '. $error_class_js .'}'.NEWLINE;
					break;
			}
		}
		//custom_validation defined in
		$js .= 'msg += custom_validation(focus);'.NEWLINE;

		$js .= 'if (msg =="") { '.$focus .NEWLINE .'; $("form1").submit();} else { alert(msg); return false}'.NEWLINE;
		$js .= '} </script>';

		return $js;
	}

	static function get_lookup_text($table, $id) {
		$database = Database::getDatabase();
		if (intval($id) == 0) {
			return false;
		}
		$query = "select * from " . $table ." where id = '".$id ."'";
		$results = $database->query($query);
		$val = "";
		if ($database->num_rows($results) > 0) {
			$val = $database->fetch_result($results,0,'value');
		}
		return $val;
	}
}?>