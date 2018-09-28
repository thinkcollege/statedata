<?php
class report {
	const TREND = 'trend', SUMMARY = 'summary', STEP_FINAL = 0, STEP_FIRST = 1, STEP_COUNTY = 2,
		STEP_PROVIDER = 3, MAX_STEP = 3; // report::MAX_STEP should always equal the highest number step.
	
	protected $_step = 1, $_nextStep = 1, $type = 0, $_js = true, $serviceCode = '', $outcome = '',
		$timeframe = '', $region = '', $county = '', $provider = '', $gender = '', $fsc = '',
		$cps = -2, $casl = '', $esl = '', $ageStart = 0, $ageEnd = 0, $residenceType = '', $summary = 0,
		$residenceTypes = array('All Residency Settings' => 0, 'Lives in Own Home' => 1, 'Lives with Family	' => 2, 'Small Group Setting ' => 3, 'Facility' => 4, 'Other' => 5, 'Homeless' => 6, 'Unknown' => 7),
		$regions = null, $counties = null, $providers = null, $filters = null, $serviceCodes = null, $legend = '';
	
	public function __construct($type, $init = false) {
		global $msgs, $t;
		$this->setType($type);
		
		if ($init == true) {
			$msgs[] = 'Creating base report:' . (microtime(true) - $t);
			$rs = fQuery('SELECT c.Code AS `Value`, c.`Value` AS `Option` FROM ' . TABLE_CODE_LOOKUP . ' c
						   WHERE c.`grouping` = \'DV\' AND EXISTS (SELECT 1 FROM ' . TABLE_BILLING . ' WHERE ServiceCode = c.Code LIMIT 0,1) ORDER BY `Option`');
			$this->serviceCodes = $rs->toSelect('serviceCode', 'Select Service Type');
			$msgs[] = 'Created Service Code Select:' . (microtime(true) - $t);
			
			$rs = fQuery('SELECT cl.`Value` AS `Option`, cl.`Code` AS `Value` FROM ' . TABLE_CODE_LOOKUP . ' cl
						   WHERE cl.Code RLIKE \'RG0[1-6]\' AND EXISTS (SELECT 1 FROM ' . TABLE_BILLING . ' WHERE RegionCode = cl.Code LIMIT 0,1) ORDER BY cl.`Value`');
			$this->regions = $rs->toSelect('region', 'All Regions');
			$msgs[] = 'Determined Regions:' . (microtime(true) - $t);
			
			$rs = fQuery('SELECT cl.`Value` AS `Option`, cl.`Code` AS `Value`,
								 (SELECT RegionCode FROM ' . TABLE_BILLING . ' WHERE CountyCode = cl.Code LIMIT 0,1) AS `Grouping`
							FROM ' . TABLE_CODE_LOOKUP . ' cl
			 			   WHERE cl.`grouping` = \'CY\' AND EXISTS (SELECT 1 FROM ' . TABLE_BILLING . ' WHERE CountyCode = cl.`Code` LIMIT 0,1) ORDER BY `Grouping`, `Option`');
			$counties = array('all' => array('All Counties' => 0));
			while ($row = $rs->fetchAssoc()) {
				if (!has_value($counties, $row['Grouping'])) {
					$counties[$row['Grouping']]['All Counties'] = 0;
				}
				$counties[$row['Grouping']][$row['Option']] = $row['Value'];
				$counties['all'][$row['Option']] = $row['Value'];
			}
			uksort($counties['all'], 'geoSort');
			$this->counties = $counties;
			$msgs[] = 'Determined Counties:' . (microtime(true) - $t);
			
			$rs = fQuery('SELECT DISTINCT p.`Number` AS `Value`, p.`Name` AS `Option`, `b`.`RegionCode`, `b`.`CountyCode`
							FROM ' . TABLE_PROVIDER . ' p LEFT JOIN ' . TABLE_BILLING . ' b ON b.`ProviderNumber` = `p`.`number`
						ORDER BY RegionCode, CountyCode, p.Name');
			$providers = array('all' => array('all' => array('All Providers' => 0)));
			while ($row = $rs->fetchAssoc()) {
				if (!has_value($providers, $row['RegionCode'])) {
					$providers[$row['RegionCode']] = array('all' => array('All Providers' => 0));
				}
				if (!has_value($providers[$row['RegionCode']], $row['CountyCode'])) {
					$providers[$row['RegionCode']][$row['CountyCode']] = array('All Providers' => 0);
				}
				if (!has_value($providers['all'], $row['CountyCode'])) {
					$providers['all'][$row['CountyCode']] = array('All Providers' => 0);
				}
				$providers[$row['RegionCode']][$row['CountyCode']][$row['Option']] = (empty($providers[$row['RegionCode']][$row['CountyCode']][$row['Option']]) ? '' : $providers[$row['RegionCode']][$row['CountyCode']][$row['Option']] . ',') . $row['Value'];
				$providers[$row['RegionCode']]['all'][$row['Option']] = (empty($providers[$row['RegionCode']]['all'][$row['Option']]) ? '' : $providers[$row['RegionCode']]['all'][$row['Option']] . ',') . $row['Value'];
				$providers['all'][$row['CountyCode']][$row['Option']] = (empty($providers['all'][$row['CountyCode']][$row['Option']]) ? '' : $providers['all'][$row['CountyCode']][$row['Option']] . ',') . $row['Value'];
				$providers['all']['all'][$row['Option']] = (empty($providers['all']['all'][$row['Option']]) ? '' : $providers['all']['all'][$row['Option']] . ',') . $row['Value'];
			}
			foreach($providers as $region => $counties) {
				uksort($providers[$region]['all'], 'geoSort');
			}
			$this->providers = $providers;
			
			$msgs[] = 'Determined Providers:'  . (microtime(true) - $t);
			$this->filters = $this->filters();
			$msgs[] = 'Created Filters:' . (microtime(true) - $t);
		}
	}	
		
	public function process() {
		if (has_value($_REQUEST, 'restart')) {
			$this->serviceCode = $this->outcome = $this->timeframe = $this->region = $this->county = ''; 
			$this->provider = $this->gender = $this->fsc = $this->casl = $this->esl = '';
			$this->ageStart = $this->ageEnd = $this->residenceType = $this->summary = '';
			$this->cps = -2;
			$this->setStep(self::STEP_FIRST);
			$tags = array('regions', 'counties', 'providers', 'filters', 'serviceCodes');
			foreach ($tags as $tag) {
				if (($this->$tag) instanceof select) {
					$this->$tag->clearSelected();
				} else if (($this->$tag) instanceof Tag) {
					$this->$tag->walk(array('select', 'clearSelected'));
				}
			}
			header('Location: ./?report=' . $this->getType());
			exit;
		}
		$cUser = user::getInstance();
		if (has_value($_REQUEST, 'serviceCode')) {
			$this->setActivity($_REQUEST['serviceCode']);
		} else if ($this->getType() == self::TREND && $this->getActivity() == '') {
			error('Please select a service type.');
		}
		if (has_value($_REQUEST, 'outcome')) {
			$this->setOutcome($_REQUEST['outcome']);
		} else if ($this->getType() == self::TREND && $this->getOutcome() == '') {
			error('Please select an outcome.');
		}
		if (has_value($_REQUEST, 't')) {
			$this->setTimeframe($_REQUEST['t']);
		}
		if (has_value($_REQUEST, 'summary')) {
			$this->setSummary($_REQUEST['summary']);
		} else if ($this->getType() == self::SUMMARY && $this->getSummary() == '') {
			error('Please selected a summary.');
		}
		
		if (has_value($_REQUEST, 't')
			&& ((has_value($_REQUEST, 'serviceCode') && has_value($_REQUEST, 'outcome'))
				|| has_value($_REQUEST, 'summary'))) {
			$this->setNextStep(self::STEP_COUNTY);
		}
		if ($cUser->getRegion() != '') {
			$this->setRegion($cUser->getRegion(), self::STEP_COUNTY);
		} else if (has_value($_REQUEST, 'region')) {
			$this->setRegion($_REQUEST['region'], self::STEP_COUNTY);
		} 
		if ($cUser->getCounty() != '' && $this->getStep() > self::STEP_FIRST) {
			$this->setCounty($cUser->getCounty(), self::STEP_PROVIDER);
		} else if (has_value($_REQUEST, 'county') && (!has_value($_REQUEST, 'nojs', 1) || !has_value($_REQUEST, 'region'))) {
			$this->setCounty($_REQUEST['county'], self::STEP_PROVIDER);
		}
		if ($cUser->getProvider() != '' && $this->getStep() > self::STEP_FIRST) {
			$this->setProvider($cUser->getProvider(), self::STEP_FINAL);
		} else if (has_value($_REQUEST, 'provider') && (!has_value($_REQUEST, 'nojs', 1) || !has_value($_REQUEST, 'county'))) {
			$this->setProvider($_REQUEST['provider'], self::STEP_FINAL);
		}
		if (has_value($_REQUEST, 'gender')) {
			$this->setGender($_REQUEST['gender']);
		}
		if (has_value($_REQUEST, 'fsc')) {
			$this->setFundingSource($_REQUEST['fsc']);
		}
		
		if (has_value($_REQUEST, 'cps')) {
			$this->setCognitivePreformanceScore($_REQUEST['cps']);
		}
		
		if (has_value($_REQUEST, 'casl')) {
			$this->setCommunityAccessSupportLevel($_REQUEST['casl']);
		}
		
		if (has_value($_REQUEST, 'esl')) {
			$this->setEmploymentSupportLevel($_REQUEST['esl']);
		}
		if (has_value($_REQUEST, 'ag')) {
			$this->setAgeGroup($_REQUEST['ag']);
		}
		if (has_value($_REQUEST, 'rt')) {
			$this->setResidenceType($_REQUEST['rt']);
		}
		if (has_value($_REQUEST, 'graph')) {
			$this->region =		$this->region != ''				? $this->region : 'all';
			$this->county =		$this->county != ''				? $this->county : 'all';
			$this->provider =	$this->provider != ''			? $this->provider : 'all';
			$this->gender =		$this->gender != ''				? $this->gender : 'all';
			$this->fsc =		$this->fsc != ''				? $this->fsc : 'all';
			$this->cps = 		$this->cps >= 0 && $this->cps < 7 ? $this->cps : -1;
			$this->casl = 		$this->casl != '' 				? $this->casl : 'all';
			$this->esl = 		$this->esl != ''				? $this->esl : 'all';
			$this->ageStart = 	$this->ageStart != ''			? $this->ageStart : 0;
			$this->ageEnd = 	$this->ageEnd != ''				? $this->ageEnd : 0;
			$this->residenceType = $this->residenceType != ''	? $this->residenceType : 0;
			$this->setNextStep(self::STEP_FINAL);
		}
		
		if (!hasError()) {
			$this->setStep($this->getNextStep());
		}
	}
	
	protected function setNextStep($step) {
		if ($step >= 0 && $step <= self::MAX_STEP && !hasError()) {
			$this->_nextStep = $step;
		}
	}
	
	public function getNextStep() {
		return $this->_nextStep;
	}
	
	public function getStep() {
		return $this->_step;
	}
	
	private function setStep($step) {
		if ($step >= 0 && $step <= self::MAX_STEP) {
			$this->_step = $step;
		}
	}
	
	public function getType() {
		return $this->type;
	}
	
	public function setType($type) {
		if (self::validType($type)) {
			$this->type = $type;
		}
	}
	
	static public function validType($type) {
		return in_array($type, self::getTypes());
	}
	
	static public function getTypes() {
		return array(self::TREND, self::SUMMARY);
	}
		
	public function getLegend() {
		return $this->legend;
	}
	
	
	public function make($displayOnly = false) {
		global $msgs, $t;
		$content = '';
		$this->generateHeading();
		$msgs[] = 'Generated heading:' . (microtime(true) - $t);
		$cUser = user::getInstance();
		$geo = new label('Region: ', 'region');
		if ($cUser->getRegion() != '') {
			$geo .= $this->regions;
		} else if ($this->getRegion() == 'all' && has_value($_REQUEST, 'nojs', 1)) {
			$geo .= ' All Regions';
		} else if ($this->getRegion() != '' && has_value($_REQUEST, 'nojs', 1)) {
			$geo .= getVar('SELECT cl.`Value` FROM ' . TABLE_CODE_LOOKUP . ' cl WHERE cl.Code = \'' . $this->getRegion() . '\'');
		} else {
			$geo .= $this->regions->copy();
		}
		$msgs[] = 'Generated Region:' . (microtime(true) - $t);
		if ($cUser->getCounty() != '') {
			$geo .= ', ' . new label('County:', 'county') . $this->counties;
		} else if ($this->getCounty() == 'all' && has_value($_REQUEST, 'nojs', 1)) {
			$geo .= ', ' . new label('County:', 'county') . ' All Counties';
		} else if ($this->getCounty() != '' && has_value($_REQUEST, 'nojs', 1)) {
			$geo .= ', ' . new label('County:', 'county') . getVar('SELECT cl.Value FROM ' . TABLE_CODE_LOOKUP . ' cl WHERE cl.Code = \'' . $this->getCounty() . '\'');
		} else if ($this->getRegion() != '') {
			$geo .= ', ' . new label('County:', 'county') . (is_array($this->counties) ?  select::fromArray($this->counties[$this->getRegion()], 'county', 'county') : $this->counties);
		} else {
			$geo .= ', ' . new label('County:', 'county') . new select('county', 'county', 1, false, false);
		}
		$msgs[] = 'Generated counties:' . (microtime(true) - $t);
		if ($this->getCounty() != '' && $cUser->getProvider() != '') {
			$geo .= ', ' . new label('Provider:', 'provider') . $this->providers;
		} else if ($this->getCounty() != '') {
			$geo .= ', ' . new label('Provider:', 'provider') . (is_array($this->providers) ? select::fromArray($this->providers[$this->getRegion()][$this->getCounty()], 'provider', 'provider') : $this->providers);
		} else {
			$geo .= ', ' . new label('Provider:', 'provider') . new select('provider', 'provider', 1, false, false);
		}
		$geo .= new br();
		$msgs[] = 'Generated providers:' . (microtime(true) - $t);
		if ($this->getType() == self::TREND && $this->getStep() == self::STEP_FIRST) {
			$sc = $this->serviceCodes;
			$sc->setSelected($this->serviceCode);
			$fs = new fieldset();
			$fs->add(new legend('Outcomes'), new input(0, input::HIDDEN, 'outcome'),
				new input(OUTCOME_GROSS_PAY, input::RADIO, 'outcome', 'outcome1'),
				new label('Gross Pay', 'outcome1'), new br(),
				new input(OUTCOME_HOURS_PAID, input::RADIO, 'outcome', 'outcome2'),
				new label('Hours Paid', 'outcome2'), new br(),
				new input(OUTCOME_TOTAL_SUPPORT, input::RADIO, 'outcome', 'outcome3'),
				new label('Total Hours of Support', 'outcome3'), new br(),
				new input(OUTCOME_JOB_PREP, input::RADIO, 'outcome', 'outcome4'),
				new label('Job Preparation Hours', 'outcome4'), new br(),
				new input(OUTCOME_JOB_DEV, input::RADIO, 'outcome', 'outcome5'),
				new label('Job Development Hours', 'outcome5'), new br(),
				new input(OUTCOME_JOB_COACHING, input::RADIO, 'outcome', 'outcome6'),
				new label('Job Coaching Hours', 'outcome6'), new br(),
				new input(OUTCOME_RECORD_KEEPING, input::RADIO, 'outcome', 'outcome7'),
				new label('Record Keeping Hours', 'outcome7'));
			$msgs[] = 'Generated outcomes:' . (microtime(true) - $t);
			
			$timeframe = 'From: ' . select::fromArray(array('Month' => 0, 'Jan - Q1' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr - Q2' => 4, 'May' => 5, 'Jun' => 6, 'Jul - Q3' => 7, 'Aug' => 8, 'Sep' => 9, 'Oct - Q4' => 10, 'Nov' => 11, 'Dec' => 12), 'tm', 't[m]');
			$rs = fQuery('SELECT DISTINCT YEAR(`ServiceYearMonth`) AS `Value` FROM ' . TABLE_BILLING . ' ORDER BY `Value` DESC');
			$years = $rs->toSelect('ty');
			$years->setName('t[y]');
			$timeframe .= ' ' . $years . ' for ' . select::fromArray(array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24), 'td', 't[d]') . ' ' . select::fromArray(array('Select Unit' => 0, 'Month(s)' => 'm', 'Quarter(s)' => 'q', 'Year(s)' => 'y'), 'tu', 't[u]');
			$msgs[] = 'Generated timeframe:' . (microtime(true) - $t);
			
			$content = $sc . ' ' . $timeframe . ' ' . $fs . $geo . $this->filters;
			$msgs[] = 'Generated content:' . (microtime(true) - $t);
			
		} else if ($this->getType() == self::SUMMARY && $this->getStep() == self::STEP_FIRST) {
			$rs = fQuery('SELECT DISTINCT YEAR(ServiceYearMonth) AS `Value` FROM ' . TABLE_BILLING . ' ORDER BY `Value` DESC');
			$years = $rs->toSelect('ty');
			$years->setName('t[y]');
			$timeframe = 'From: ' . select::fromArray(array('Month' => 0, 'Jan - Q1' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr - Q2' => 4, 'May' => 5, 'Jun' => 6, 'Jul - Q3' => 7, 'Aug' => 8, 'Sep' => 9, 'Oct - Q4' => 10, 'Nov' => 11, 'Dec' => 12), 'tm', 't[m]')
				. ' ' . $years . new input(1, input::HIDDEN, 't[d]', 'td') . new input('m', input::HIDDEN, 't[u]', 'tu');
			$msgs[] = 'Generated timeframe:' . (microtime(true) - $t);
			
			$summary = new fieldset();
			$summary->add(new legend('Summary of'), new input(1, input::RADIO, 'summary', 'summary1'), ' ',
				new label('Hours of Participation by Activity.', 'summary1'), new br(),
				new input(2, input::RADIO, 'summary', 'summary2'), ' ', new label('Wages by Activity.', 'summary2'), new br(),
				new input(3, input::RADIO, 'summary', 'summary3'), ' ', new label('Supports Provided by Activity.', 'summary3'));
			$msgs[] = 'Generated options:' . (microtime(true) - $t);
			$content = $timeframe . new br() . $summary . $geo . $this->filters;
			$msgs[] = 'Generated content:' . (microtime(true) - $t);
			
		} else if ($this->getStep() == self::STEP_COUNTY || $this->getStep() == self::STEP_PROVIDER) {
			$content = $geo . $this->filters;
		} else if ($this->getStep() == self::STEP_FINAL) {
			$sql = $this->generateQuery();
			$rs = fQuery($sql);
			if ($rs->queriedRows() > 0) {
				$graph = $this->generateGraph($rs);
				$filterSettings = $this->generateFilterSettings($displayOnly);
				$content = $this->getType() == self::TREND ? $graph . $filterSettings . $rs->toTable('Results', '', 1, '', 'clear') : $rs->toTable('Results', '', 1, '', 'clear') . $filterSettings;
			} else {
				$content = new p('There is no data for the options you have selected.', 'error');
			}
		}
		if (!$displayOnly) {
			$content = ($this->getStep() != self::STEP_FINAL ? '<form action="./?' . $_SERVER['QUERY_STRING'] . '" method="post">' : '') . $content . '<br />'
				. ($this->getStep() != self::STEP_FINAL && $this->getStep() != self::MAX_STEP && is_array($this->counties) ? '<noscript><input type="submit" value="Narrow Geographic Sample" /><input type="hidden" name="nojs" value="1" /></noscript> ' : '')
				. ($this->getStep() != self::STEP_FINAL ? '<input type="submit" name="graph" value="Generate Report" /></form> ' : '')
				. ($this->getStep() != self::STEP_FIRST ? '<form action="./?' . $_SERVER['QUERY_STRING'] . '" method="post"><button type="submit" name="restart" value="1">Start Over</button></form>' : '')
				. ($this->getStep() == self::STEP_FINAL ? '<br />&dagger; Due to the small number of cases for this period data is not being reported. Displaying data could reveal personally identifiable information' : '');
		}
		return $content;
	}
	
	public function exportCSV() {
		$this->generateHeading();
		header('Content-disposition: attachment; filename=' . str_replace(' ', '_', strtolower($this->getLegend())) . '.csv');
		header('Content-type: text/csv');
		$rs = fQuery($this->generateQuery());
		$rs->replaceWith('&dagger;', 'x');
		$first = true;
		while ($row = $rs->fetchAssoc()) {
			if ($first) {
				$keys = array_keys($row);
				array_walk($keys, 'CSVEscape');
				print implode(',', $keys) . "\n";
				$first = false;
			}
			array_walk($row, 'CSVEscape');
			print implode(',', $row) . "\n";
		}
		$footnote = 'x indicates the number of cases for this data point is so low, displaying data could reveal personally identifiable information.';
		CSVEscape($footnote);
		print "$footnote\n";
	}
	
	protected function filters() {
		global $msgs, $t;
		if ($this->filters !== null) {
			return $this->filters;
		}
		$gender = select::fromArray(array('All' => 'all', 'Male' => 'GNMA', 'Female' => 'GNFE', 'Unknown' => 'N/A'), 'gender', 'gender');
		$gender->setSelected($this->getGender() != '' ? $this->getGender() : (isset($_POST['gender']) ? $_POST['gender'] : 'all'));
		$gLabel = new label('Gender:', $gender);
		$msgs[] = 'Created Gender: ' . (microtime(true) - $t);
		
		$rs = fQuery('SELECT cl.`Code` AS `Value`, cl.`Value` AS `Option` FROM ' . TABLE_CODE_LOOKUP . ' cl
					   WHERE cl.`grouping` = \'FS\' AND EXISTS (SELECT 1 FROM ' . TABLE_BILLING . ' WHERE FundSourceCode = cl.`Code` LIMIT 0,1)
				--	ORDER BY cl.`Code`');
		$fsc = $rs->toSelect('fsc', 'All Sources');
		$fscLabel = new label('Funding Source:', $fsc);
		$msgs[] = 'Created Funding Source: ' . (microtime(true) - $t);
		
		$cps = select::fromArray(array('All Scores' => -1, 0,1,2,3,4,5,6), 'cps', 'cps');
		$cps->setSelected($this->getCognitivePerformanceScore() > -2 ? $this->getCognitivePerformanceScore() : (isset($_POST[$cps->getName()]) ? $_POST[$cps->getName()] : -1));
		$cpsLabel = new label('Cognitive Performance Score:', $cps);
		$msgs[] = 'Created Cognitive Performance Score: ' . (microtime(true) - $t);
		
		$caslSel = $this->getCommunityAccessSupportLevel() != '' ? $this->getCommunityAccessSupportLevel() : (isset($_POST['casl']) ? $_POST['casl'] : '');
		$rs = fQuery('SELECT cl.`code` AS `Value`, cl.`Value` AS `Option` FROM ' . TABLE_CODE_LOOKUP . ' cl
					   WHERE cl.`grouping` = \'DL\' AND EXISTS (SELECT 1 FROM ' . TABLE_BILLING . ' WHERE CommunityAccessSupportLevelCode = cl.`Code` LIMIT 0,1)
					ORDER BY CASE cl.`Code` WHEN \'DL06\' THEN 0 WHEN \'DL07\' THEN 1 ELSE 2 END');
		$casl = $rs->toSelect('casl', 'All levels');
		$caslLabel = new label('Community Access Support Level:', $casl);
		$msgs[] = 'Created Community Access Support Level: ' . (microtime(true) - $t);
		
		$eslSel = $this->getEmploymentSupportLevel() != '' ? $this->getEmploymentSupportLevel() : (isset($_POST['esl']) ? $_POST['esl'] : '');
		$esl = $casl->copy(); #toSelect('esl', 'All Levels');
		$esl->setName('esl');
		$esl->setId('esl');
		$eslLabel = new Label('Employment Support Level:', $esl);
		$msgs[] = 'Created Employment Support Level: ' . (microtime(true) - $t);
			
		$maxAge = getVar('SELECT YEAR(FROM_DAYS(DATEDIFF(CURDATE(), MIN(ClientDOB)))) FROM ' . TABLE_BILLING);
		$msgs[] = 'Created Got Max Age: ' . (microtime(true) - $t);
		
		$ages = array('All' => 0);
		for ($i = 16; $i <= $maxAge; $i++) {
			$ages[] = $i;
		}
		$msgs[] = 'Created Ages Array: ' . (microtime(true) - $t);
		
		$agS = select::fromArray($ages, 'ags', 'ag[start]');
		#$agE = $agS->copy();
		#$agE->setName('age[end]');
		#$agE->setId('age');
		$agE = select::fromArray($ages, 'age', 'ag[end]');
		$agSLabel = new label('from: ', $agS);
		$agELabel = new label(' to ', $agE);
		$msgs[] = 'Created Age Select: ' . (microtime(true) - $t);
		
		$rt = select::fromArray($this->residenceTypes, 'rt', 'rt');
		$rtLabel = new label('Residence Type:', $rt);
		$msgs[] = 'Created Residency Type: ' . (microtime(true) - $t);
		
		$filters = new div('','','filters');
		$filters->add($gLabel, $gender, new br(), $fscLabel, $fsc, new br(), $cpsLabel, $cps,
			new br(), $caslLabel, $casl, new br(), $eslLabel, $esl, new br(), 'Age Range ',
			$agSLabel, $agS, $agELabel, $agE, new br(), $rtLabel, $rt);
		return $filters;
	}
	
	public function makeTimeFrameClause($tf) {
		if (!has_value($tf, 'u', '/^[mqy]$/', COMP_REGEX)) {
			error('Unknown unit.');
			return;
		}
		if (!has_value($tf, 'y', 0, COMP_GT) || $tf['y'] > date('Y')) {
			error('Invalid Year.');
			return;
		}
		if (!has_value($tf, 'd', 0, COMP_GT)) {
			error('Invalid duration.');
			return;
		}
		if (!has_value($tf, 'm', 0, COMP_GT) || $tf['m'] > 12) {
			error('Unknown month.');
			return;
		}
		
		$tf['d']	= intval($tf['d']) > 0 ? intval($tf['d']) - 1: 0;
		$tf['y']	= intval($tf['y']);
		$tf['m']	= intval($tf['m']);
		$date		= "'{$tf['y']}-" . ($tf['m'] < 10 ? '0' : '') . "{$tf['m']}-01'";
		$cDate		= date("'Y-m-01'");
		switch ($tf['u']) {
			case 'q':	$tf['u'] = 'QUARTER';	break;
			case 'y':	$tf['u'] = 'YEAR';		break;
			default:	$tf['u'] = 'MONTH';		break;
		}
		return " `ServiceYearMonth` BETWEEN $date AND DATE_ADD($date, INTERVAL {$tf['d']} {$tf['u']})"
			 . " AND `ServiceYearMonth` <= DATE_ADD($cDate, INTERVAL -" . DATA_RELEASE_DELAY . " MONTH) ";
	}
	
	protected function generateQuery() {
		$where = $this->makeTimeFrameClause($this->timeframe);
		if ($this->ageStart > 0 && $this->ageEnd > 0) {
			$where .= ' AND ClientDOB BETWEEN \'' . $this->timeframe['y'] . '-' . $this->timeframe['m']
					. '-01\' - INTERVAL ' . $this->ageEnd . ' YEAR AND \'' . $this->timeframe['y']
					. '-' . $this->timeframe['m'] . '-01\' - INTERVAL ' . $this->ageStart . ' YEAR';  
		} else if ($this->ageStart > 0) {
			$where .= ' AND ClientDOB < \'' . $this->timeframe['y'] . '-' . $this->timeframe['m']
					. ' =01\' - INTERVAL ' . $this->ageStart . ' YEAR';
		} else if ($this->ageEnd > 0) {
			$where .= ' AND ClientDOB > \'' . $this->timeframe['y'] . '-' . $this->timeframe['m']
					. ' =01\' - INTERVAL ' . $this->ageEnd . ' YEAR';
		}
		switch ($this->residenceType) {
			case 1:	$where .= ' AND ClientResidentTypeCode IN (\'RI01\', \'RI06\', \'RI10\', \'RI11\', \'RI14\', \'RI36\', \'RI42\', \'RI52\')';	break;
			case 2: $where .= ' AND ClientResidentTypeCode IN (\'RI02\', \'RI03\')';	break;
			case 3: $where .= ' AND ClientResidentTypeCode IN (\'RI05\', \'RI07\', \'RI09\', \'RI13\', \'RI15\', \'RI16\', \'RI17\', \'RI27\', \'RI28\', \'RI35\', \'RI40\', \'RI41\', \'RI51\', \'RI53\', \'RIHO\', \'RIMH\')';	break;
			case 4: $where .= ' AND ClientResidentTypeCode IN (\'RI04\', \'RI12\', \'RI21\', \'RI22\', \'RI23\', \'RI24\', \'RI25\', \'RI26\', \'RI30\', \'RI31\', \'RI34\', \'RI39\', \'RISA\')';	break;
			case 5: $where .= ' AND ClientResidentTypeCode = \'RI32\'';	break;
			case 6: $where .= ' AND ClientResidentTypeCode = \'RI38\'';	break;
			case 7: $where .= ' AND ClientResidentTypeCode IN (\'RI29\', \'RI33\', \'RICA\')';	break;
		}
		$where .= ($this->getRegion() != 'all'					? ' AND RegionCode = \'' . e($this->region) . '\'' : '')
				. ($this->getCounty() != 'all'					? ' AND CountyCode = \'' . e($this->county) . '\'' : '')
				. ($this->getProvider() != 'all'				? ' AND ProviderNumber IN (\'' . str_replace(',', "','", e($this->provider)) . '\')' : '')
				. ($this->getGender() != 'all'					? ' AND ClientGender = \'' . e($this->gender) . '\'' : '')
				. ($this->getFundingSource() != 'all'			? ' AND FundSourceCode = \'' . e($this->fsc) . '\'' : '')
				. ($this->getCognitivePerformanceScore() != -1	? ' AND CognitivePreformanceScore = ' . floatval($this->cps) : '')
				. ($this->getCommunityAccessSupportLevel() != 'all'	? ' AND CommunityAccessSupportLevelCode = \'' . e($this->casl) . '\'' : '')
				. ($this->getEmploymentSupportLevel() != 'all'	? ' AND EmploymentSupportLevelCode = \'' . e($this->getEmploymentSupportLevel()) . '\'' : '')
				. ($this->getType() == self::TREND 				? ' AND serviceCode = \'' . e($this->getActivity()) . "'" : '');
			
		$join = $this->getType() == self::SUMMARY ? 'INNER JOIN ' . TABLE_CODE_LOOKUP . ' cl ON cl.`Code` = b.`ServiceCode`' : '';
		$sql = 'SELECT ' . $this->generateColumns() . ' FROM '. TABLE_BILLING . ' b ' . $join . ' WHERE '. $where . ' GROUP BY b.ServiceCode';
		if ($this->getType() == self::TREND) {
			$sql .= ' UNION SELECT ' . $this->generateNColumns() . ' FROM '. TABLE_BILLING . ' b ' . $join . ' WHERE '. $where . ' GROUP BY b.ServiceCode';
		}
		return $sql;
	}
	
	protected function generateColumns() {
		$ret = '';
		if ($this->getType() == self::TREND) {
			switch ($this->outcome) {
				case OUTCOME_GROSS_PAY:		 $col = 'b.`GrossWages`';			break;
				case OUTCOME_HOURS_PAID:	 $col = 'b.`HoursPaid`';			break;
				case OUTCOME_TOTAL_SUPPORT:	 $col = 'b.`TotalHoursOfSupport`';	break;
				case OUTCOME_JOB_PREP:		 $col = 'b.`JobPrepHours`';			break;
				case OUTCOME_JOB_DEV:		 $col = 'b.`JobDevelopmentHours`';	break;
				case OUTCOME_JOB_COACHING:	 $col = 'b.`JobCoachingHours`';		break;
				case OUTCOME_RECORD_KEEPING: $col = 'b.`RecordKeepingHours`';	break;
			}
			$tf = $this->getTimeFrame();
			$ret = "'Avg.' AS ``";
			$date = "'{$tf['y']}" . ($tf['m'] < 10 ? '0' : '') . $tf['m'] . "'";
			$step = $tf['u'] == 'y' ? 12 : ($tf['u'] == 'q' ? 3 : 1);
			$stepsPerYear = 12 / $step;
			$spStepNormal = ceil(date('m', mktime(0,0,0,$tf['m'],1,$tf['y']))/$step);
			for ($i = 0; $i < $tf['d']; $i++) {
				$clause = "DATE_FORMAT(ServiceYearMonth, '%Y%m') BETWEEN PERIOD_ADD($date, $i * $step) AND PERIOD_ADD($date, (($i + 1) * $step) - 1) AND $col > 0";
				$ret .= ", IF(COUNT(DISTINCT IF($clause, b.ClientID, NULL)) NOT BETWEEN 1 AND " . MIN_ALLOWED_RECORDS . ", FORMAT(AVG(IF($clause, $col, NULL)), 2), '&dagger;') AS `";
				$inc = $spStepNormal + ($i % $stepsPerYear); 		// Take the starting point normalized for the sep size + Number of steps left in a year, hence % instead of /.
				$inc -= $inc > $stepsPerYear ? $stepsPerYear : 0;	// If the quarter calculated is in the previous year add 4.
				switch ($tf['u']) {
					case 'y':	$ret .= date('M. y', mktime(0, 0, 0, $tf['m'], 1, $tf['y'])) . ' to ' . date('M. y`', mktime(0,0,0, $tf['m']  + (($i + 1) * $step) - 1, 1, $tf['y'])); break;
					case 'q':	$ret .= 'Q' . $inc . ' ' . ($tf['y'] + floor(($spStepNormal + $i - 1) / $stepsPerYear)) . '`';	break;
					case 'm':	$ret .= date('M. y`', mktime(0,0,0, $tf['m'] + $i, 1, $tf['y']));				break;
				}
			}
		} else if ($this->summary == 1) {
			$ret = 'cl.Value AS `Activity`, COUNT(DISTINCT b.ClientID) AS `# Served`,
					COUNT(DISTINCT IF(b.HoursPaid > 0, b.ClientID, NULL)) AS `# Served' . "\n" . 'w/ Paid Hours`,'
				 . 'IF(COUNT(DISTINCT IF(b.HoursPaid > 0, b.ClientID, NULL)) NOT BETWEEN 1 AND ' . MIN_ALLOWED_RECORDS . ', FORMAT(AVG(IF(b.HoursPaid > 0, b.HoursPaid, NULL)), 2), \'&dagger;\')  AS `Avg. Hours Paid`,'
				 . 'COUNT(DISTINCT IF(HoursPaid/(DAY(LAST_DAY(ServiceYearMonth))/7) > 20, b.ClientID, NULL)) AS `# > 20 hours/week`';
		} else if ($this->summary == 2) {
			$ret = 'cl.Value AS `Activity`, COUNT(DISTINCT b.ClientID) AS `# Served`,
					COUNT(DISTINCT IF(b.GrossWages > 0, b.ClientID, NULL)) AS `# Served' . "\n" . 'w/ Gross Wages > 0`,
					IF(COUNT(DISTINCT IF(b.GrossWages > 0, b.ClientID, NULL)) NOT BETWEEN 1 AND ' . MIN_ALLOWED_RECORDS . ', FORMAT(AVG(IF(b.GrossWages > 0, b.GrossWages, NULL)), 2), \'&dagger;\') AS `Avg. Gross Wages`';
		} else if ($this->summary == 3) {
			$ret = 'cl.Value AS `Activity`,
					COUNT(DISTINCT IF(b.`TotalHoursOfSupport` > 0 OR b.`JobPrepHours` > 0 OR b.`JobDevelopmentHours` > 0 OR b.`JobCoachingHours` > 0 OR b.`RecordKeepingHours` > 0, b.ClientID, NULL)) AS `# Served`,
					IF(COUNT(DISTINCT IF(b.`TotalHoursOfSupport` > 0 OR b.`JobPrepHours` > 0 OR b.`JobDevelopmentHours` > 0 OR b.`JobCoachingHours` > 0 OR b.`RecordKeepingHours` > 0, b.ClientID, NULL)) NOT BETWEEN 1 AND ' . MIN_ALLOWED_RECORDS . ', FORMAT(AVG(IF(b.`TotalHoursOfSupport` > 0, TotalHoursOfSupport, NULL)), 2), \'&dagger;\') AS `Total Hours`,
					COUNT(DISTINCT IF(b.`JobPrepHours` > 0, b.ClientID, NULL)) AS `# provided' . "\n" . 'Job Prep`,
				 	IF(COUNT(DISTINCT IF(b.`JobPrepHours` > 0, b.ClientID, NULL)) NOT BETWEEN 1 AND ' . MIN_ALLOWED_RECORDS . ', FORMAT(AVG(IF(b.`JobPrepHours` > 0, b.`JobPrepHours`, NULL)), 2), \'&dagger;\') AS `Avg. Hours of' . "\n" . 'Job Prep`,
				 	COUNT(DISTINCT IF(b.`JobDevelopmentHours` > 0, b.ClientID, NULL)) AS `# provided' . "\n" . 'Job Development`,
				 	IF(COUNT(DISTINCT IF(b.`JobDevelopmentHours` > 0, b.ClientID, NULL)) NOT BETWEEN 1 AND ' . MIN_ALLOWED_RECORDS . ', FORMAT(AVG(IF(b.`JobDevelopmentHours` > 0, b.`JobDevelopmentHours`, NULL)), 2), \'&dagger;\') AS `Avg.  Hours of' . "\n" . 'Job Development`,
					COUNT(DISTINCT IF(b.`JobCoachingHours` > 0, b.ClientID, NULL)) AS `# provided' . "\n" . 'Job Coaching`,
				 	IF(COUNT(DISTINCT IF(b.`JobCoachingHours` > 0, b.ClientID, NULL)) NOT BETWEEN 1 AND ' . MIN_ALLOWED_RECORDS . ', FORMAT(AVG(IF(b.`JobCoachingHours` > 0, b.`JobCoachingHours`, NULL)), 2), \'&dagger;\') AS `Avg.  Hours of' . "\n" . 'Job Coaching`,
				 	COUNT(DISTINCT IF(b.`RecordKeepingHours` > 0, b.ClientID, NULL)) AS `# provided' . "\n" . 'Record Keeping`,
				 	IF(COUNT(DISTINCT IF(b.`RecordKeepingHours` > 0, b.ClientID, NULL)) NOT BETWEEN 1 AND ' . MIN_ALLOWED_RECORDS . ', FORMAT(AVG(IF(b.`RecordKeepingHours` > 0, b.`RecordKeepingHours`, NULL)), 2), \'&dagger;\') AS `Avg. Hours of' . "\n" . 'Record Keeping`';
		} else {
			$ret = 1;
		}
		return $ret;
	}
	
	protected function generateNColumns() {
		$ret = '';
		if ($this->getType() == self::TREND) {
			switch ($this->outcome) {
				case OUTCOME_GROSS_PAY:		 $col = 'b.`GrossWages`';			break;
				case OUTCOME_HOURS_PAID:	 $col = 'b.`HoursPaid`';			break;
				case OUTCOME_TOTAL_SUPPORT:	 $col = 'b.`TotalHoursOfSupport`';	break;
				case OUTCOME_JOB_PREP:		 $col = 'b.`JobPrepHours`';			break;
				case OUTCOME_JOB_DEV:		 $col = 'b.`JobDevelopmentHours`';	break;
				case OUTCOME_JOB_COACHING:	 $col = 'b.`JobCoachingHours`';		break;
				case OUTCOME_RECORD_KEEPING: $col = 'b.`RecordKeepingHours`';	break;
			}
			$tf = $this->getTimeFrame();
			$ret = "'N'";
			$date = "'{$tf['y']}" . ($tf['m'] < 10 ? '0' : '') . $tf['m'] . "'";
			$step = $tf['u'] == 'y' ? 12 : ($tf['u'] == 'q' ? 3 : 1);
			for ($i = 0; $i < $tf['d']; $i++) {
				$ret .= ", COUNT(DISTINCT IF($col > 0 AND DATE_FORMAT(ServiceYearMonth, '%Y%m') BETWEEN PERIOD_ADD($date, $i * $step) AND PERIOD_ADD($date, (($i + 1) * $step) - 1), b.`ClientID`, NULL))";
			}
		}
		return $ret;
	}
	
	protected function generateHeading() {
		$tf = $this->getTimeFrame();
		if ($this->getStep() != self::STEP_FINAL) {
			$heading = ($this->getType() == self::TREND ? 'Trend' : 'Summary') . ' Report - Step: ' . $this->getStep();
		} else if ($this->getType() == self::TREND) {
			$heading = 'Avg. ';
			switch ($this->outcome) {
				case OUTCOME_GROSS_PAY:		 $heading .= 'Gross Wages';				break;
				case OUTCOME_HOURS_PAID:	 $heading .= 'Hours Paid';				break;
				case OUTCOME_TOTAL_SUPPORT:	 $heading .= 'Total Hours of Support';	break;
				case OUTCOME_JOB_PREP:		 $heading .= 'Job Preparation Hours';	break;
				case OUTCOME_JOB_DEV:		 $heading .= 'Job Development Hours';	break;
				case OUTCOME_JOB_COACHING:	 $heading .= 'Job Coaching Hours';		break;
				case OUTCOME_RECORD_KEEPING: $heading .= 'Record Keeping Hours';	break;
			}
			$heading .= ' for ' . getVar('SELECT Value FROM ' . TABLE_CODE_LOOKUP . ' WHERE Code = \'' . e($this->serviceCode) . '\'') . ' from ';
			if ($tf['u'] == 'q') {
				$heading .= 'Q' . ceil($tf['m'] / 3) . ' ' . $tf['y'] . ' to Q' . (ceil($tf['m'] / 3) + (($tf['d'] - 1) % 4)) . '  ' . ($tf['y'] + floor((ceil($tf['m'] / 3) + $tf['d']) / 4));
			} else {
				$step = $tf['u'] == 'y' ? 12 : 1;
				$heading .= date('M. y', mktime(0,0,0,$tf['m'],1,$tf['y']))
				. ' to ' . date('M. y', mktime(0,0,0,$tf['m'] + ($tf['d'] * $step) - 1,1,$tf['y']));
			}
		} else if ($this->getType() == self::SUMMARY) {
			switch ($this->summary) {
				case 1:	$heading = 'Hours Paid per Activity';			break;
				case 2:	$heading = 'Gross Wages per Activity';			break;
				case 3:	$heading = 'Supports Provided per Activity';	break;
			}
			$heading .= ' for ';
			switch ($tf['u']) {
				case 'y':	$heading .= date('F Y', mktime(0,0,0,$tf['m'], 1, $tf['y'])) . ' to ' . date('F Y', mktime(0,0,0,$tf['m'] - 1, 1, $tf['y'] + 1));	break;	
				case 'q':	$heading .= 'Q' . $m[2] . ' ' . $m[1];							break;
				case 'm':	$heading .= date('F Y', mktime(0,0,0,$tf['m'], 1, $tf['y']));	break;
			}
		}
		$this->legend = $heading;
	}
	
	protected function generateFilterSettings($displayOnly = false) {
		$query = 'SELECT cl.Value FROM ' . TABLE_CODE_LOOKUP . ' cl WHERE cl.Code = \'';
		
		$gender = 'Gender: ' . ($this->gender != 'all' && $this->gender != 'N/A' ? getVar($query . e($this->gender) . '\'') : ($this->gender == 'all' ? 'All.' : 'Unknown'));
		$fsc = 'Funding Source Code: ' . ($this->fsc != 'all' ? getVar($query . e($this->fsc) . '\'') : 'All.');
		$cps = 'Cognitive Performance Score: ' . ($this->cps != -1 ? $cps : 'All.');
		$casl = 'Community Access Support Level: ' . ($this->casl != 'all' ? getVar($query . e($this->casl) . '\'') : 'All.');	
		$esl = 'Employment Support Level: ' . ($this->esl != 'all' ? getVar($query . e($this->esl) . '\'') : 'All.');
		$region = 'Region: ' . ($this->region != 'all' ? getVar($query . e($this->region) . '\'') : 'All regions.');
		$county = 'County: ' . ($this->county != 'all' ? getVar($query . e($this->county) . '\'') : 'All counties.');
		$provider = 'Provider: ' . ($this->provider != 'all'
			? getVar('SELECT `Name` FROM ' . TABLE_PROVIDER . ' WHERE `Number` = \'' . e($this->provider) . '\' LIMIT 0,1') : 'All providers.');
		
		$ageGroup = 'Age Group from: ' . ($this->ageStart > 0 ? $this->ageStart : 'all') . ' to ' . ($this->ageEnd ? $this->ageEnd : 'all');
		$residenceType = 'Residence Type: ';
		foreach ($this->residenceTypes as $key => $val) {
			if ($val == $this->residenceType) {
				$residenceType .= $key;
				break;
			}
		}
		$save = '';
		if (!$displayOnly) {
			/*if ($_REQUEST['report'] == 0) {
				$save = '<form action="./?' . $_SERVER['QUERY_STRING'] . '" method="post"><p>Save these report settings for future quick access from the home page:<br />'
					  . '<label for="title">Title:</label> <input type="text" id="title" name="title" value="' . $this->getLegend() . '" size="40">'
					  . ' <input type="submit" name="save" value="Save"></p></form>';
			}*/
			$save .= '<form action="./?' . $_SERVER['QUERY_STRING'] . '" method="post"><p>E-mail this report:<br /><label for="to">To:</label> '
				  . '<input type="text" id="to" name="to" size="40" value="' . (has_value($_POST, 'to') && hasError() ? htmlentities($_POST['to'], ENT_COMPAT, 'UTF-8') : '') .	'" /> '
				  . '<input type="submit" name="email" value="Send" /></p></form>';
		}
		$save .= '<p><noscript>To print this report go to the File menu and select print</noscript><script type="text/javascript">document.write(\'<a href="#" onclick="javascript:window.print();">Print this Report.</a>\');</script> | <a href="./?ajax=downloadReport">Download a CSV file of this report</a>.</p>';
		
		return '<div class="float-left"><strong>Filter Settings</strong><br />' . $region . ' '
			. $county . ' ' . $provider . '<br />' . $gender . '<br />' . $fsc . '<br />'
			. $cps . '<br />' . $casl . '<br />' . $esl . '<br />' . $ageGroup . '<br />'
			. $residenceType . $save . '</div>';   
	}
	
	protected function generateGraph($rs) {
		if ($this->getType() != self::TREND) {
			return '';
		}
		$series = $cats = '';
		$axis = 'Avg.';
		if ($rs->queriedRows() > 0) {
			$rs->seek();
			$row = $rs->fetchAssoc();
			#print_r($row);
			$legend = $this->getLegend();
			$cats = 'graph.setCategories(';
			$series = "graph.SetSeries((CLR_9900CC)" . $legend . ';';
			$sep = '';
			foreach ($row as $col => $val) {
				if ($col == '') {
					continue;
				}
				$cats .= $sep . $col;
				$series .= $sep . (isFloat($val) ? $val : 0);
				$sep = ';';
			}
			$cats .= ')';
			$series .= ')';
		}
		$title = 'main.title(' . $legend
			   . ")main.AddPCXML(<Textbox Name='title' Top='0' Left='0' Width='615' Height='24'><Properties AutoWidth='False' HJustification='Center' LeftMargin='5' RightMargin='5' FillColor='#BACBDB' Font='Size:14; Style:Bold Italic; Color:#5C656A;'/>"
			   . "<Text>$legend</Text></Textbox>)";
		$axis = "main.AddPCXML(<Textbox Name='axis1' Top='120' Left='10' Width='75' Height='70'>"
			  . "<Properties BorderType='None' AutoWidth='True' HJustification='Center' LeftMargin='5' RightMargin='5' FillColor='#ffffff' Font='Size:10; Style:Bold; Color:black;' />"
			  . "<Text>$axis</Text></Textbox>)";
		$categoryLabelFont = "graph.AddPCXML(<CategoryScale LimitLabelLength='False' MaxLengthRotatedText='10' StaggerLabels='False' RotateLabels='-45' LowOuterLine='Color:#7f7f7f;' HighOuterLine='Color:#7f7f7f;' MajorTick='Visible:False;' MinorTick='Size:Large;' MajorGrid='Color:#7f7f7f;'  Font='Size:12; Style:Bold Italic; Color:#3366ff;' MinorFont='Size:10;' />)";
		
		$myImage = new CordaEmbedder();
		$myImage->externalServerAddress = "69.20.125.203:8080";
		$myImage->internalCommPortAddress = "69.20.125.203:8081";
		$myImage->appearanceFile = "apfiles/waddd.pcxml";
		$myImage->userAgent = $_SERVER['HTTP_USER_AGENT'];
		#$myImage->width = 540;
		#$myImage->height = 330;
		$myImage->returnDescriptiveLink = true;
		$myImage->language = "EN";
		$myImage->pcScript = $cats . $series . $title . $axis . $categoryLabelFont;
		#$myImage->outputType = "JPG";
		#return '<div class="float-left">' . htmlentities($myImage->pcScript, ENT_COMPAT, 'UTF-8') . '</div>';
		return '<div class="float-left">' . preg_replace('#<(no)?script.*</\1?script>#sUi', '', $myImage->getEmbeddingHTML()) . '</div>';
	}
	
	
	public function save($title) {
		if (strlen($title) === 0) {
			error('Please provide a name to save the report.');
			return false;
		}
		if ($this->getStep() == self::STEP_FINAL) {
			$query = 'INSERT INTO ' . TABLE_USER_REPORT . ' (`UserID`, `Title`, `Type`, `ServiceCode`, `Outcome`, `Summary`, `Timeframe`, `Region`, `County`, `Provider`, `Gender`, `FSC`, `CPS`, `CASL`, `ESL`, `AgeGroup`, `ResidencyType`)
					   VALUES (' . user::getInstance()->getID() . ', \'' . e($title) . '\', \'' . e($this->type)
						. '\', \'' . e($this->serviceCode) . '\', \'' . e($this->outcome) . '\', \'' . e($this->summary)
						. '\', \'' . e(json_encode($this->timeframe)) . '\', \'' . e($this->region) . '\', \''
						. e($this->county) . '\', \'' . e($this->provider) . '\', \'' . e($this->gender)
						. '\', \'' . e($this->fsc) . '\', \'' . e($this->cps) . '\', \'' . e($this->casl)
						. '\', \'' . e($this->esl) . '\', \'' . e($this->ageGroup) . '\', \''
						. e($this->residencyType) . '\')';
			$rs = fQuery($query);
			if ($rs->affectedRows() == 0) {
				error('Unable to save report.');	
			} else {
				header('Location: ./?report=' . $rs->insert_id(), true, 301);
			}
		}
		return true;
	}
	
	static public function getSavedReport($id) {
		$id = intval($id);
		if ($id <= 0) {
			error('Invalid report ID.');
			return;
		}
		$rs = fQuery('SELECT `type`, `serviceCode`, `outcome`, `summary`, `timeframe`, `region`,
							 `county`, `provider`, `gender`, `fsc`, `cps`, `casl`, `esl`, `ageGroup`,
							 `residencyType`
						FROM ' . TABLE_USER_REPORT . ' WHERE UserID = ' . user::getInstance()->getID() . ' AND ReportID = ' . $id);
		if ($rs->queriedRows() == 0) {
			error('Unknown report: '. $id . '.');
			return;
		}
		$row = $rs->fetchAssoc();
		$rpt = has_value($_SESSION, 'baseReport') && $_SESSION['baseReport'] instanceof report ? $_SESSION['baseReport']->copy() : new self($row['type']);
		foreach ($row as $var => $val) {
			$rpt->$var = $var == 'timeframe' ? get_object_vars(json_decode($val)) : $val;
		}
		$rpt->setStep(self::STEP_FINAL);
		return $rpt;
	}
	
	static public function getSavedReports() {
		$rs = fQuery('SELECT ReportID,Title,Type FROM ' . TABLE_USER_REPORT . ' WHERE UserID = ' . user::getInstance()->getID() . ' ORDER BY type,title');
		if ($rs->queriedRows() == 0) {
			return '';
		}
		$l = $g = new ul('', 'saved');
		$lastType = '';
		while ($rpt = $rs->fetchAssoc()) {
			if ($rpt['Type'] != $lastType) {
				$l->add(new li($rpt['Type'] == self::TREND ? 'Trend Reports:' : 'Summary Reports'));
				$g = new ul();
				$l->last()->add($g);
				$lastType = $rpt['Type'];
			}
			$g->add(new li(new a($rpt['Title'], './?report=' . $rpt['ReportID'])));
			$g->last()->add(new a('delete', './?action=delete&report=' . $rpt['ReportID'], 'delete'));
		}
		return new h2('Saved Reports') . $l;
	}
	
	static public function deleteSavedReport($id) {
		$id = intval($id);
		if ($id == 0) {
			error('Invalid Report ID.');
			return;
		}
		$rs = fQuery('DELETE FROM ' . TABLE_USER_REPORT . ' WHERE UserID = ' . user::getInstance()->getID() . ' AND ReportID = ' . $id);
		return $rs->affectedRows() > 0;
	}
	
	
	public function setActivity($activity) {
		preg_match('/^DV\d{2}$/', $activity, $m);
		if (count($m) > 0) {
			$ret = getVar('SELECT 1 FROM ' . TABLE_BILLING . ' WHERE ServiceCode = \'' . e($m[0]) . '\' LIMIT 0,1');
			if ($ret != 1) {
				error('Unknown Service Type.');
			} else {
				$this->serviceCode = $m[0];
			}
		} else {
			error('Please select a Service Type.');
		}
	}
	
	public function setOutcome($outcome) {
		$outcome = intval($outcome);
		if ($outcome === 0) {
			error('Please select an outcome.');
		} else if (!in_array($outcome, array(OUTCOME_GROSS_PAY, OUTCOME_HOURS_PAID, OUTCOME_TOTAL_SUPPORT, OUTCOME_JOB_PREP, OUTCOME_JOB_DEV, OUTCOME_JOB_COACHING, OUTCOME_RECORD_KEEPING))) {
			error('Unknown outcome.');
		} else if (in_array($outcome, array(OUTCOME_JOB_PREP, OUTCOME_JOB_DEV, OUTCOME_JOB_COACHING, OUTCOME_RECORD_KEEPING)) && $this->getActivity() != 'DV29' && $this->getActivity() != 'DV38') {
			error('This service outcome can only be select when the <em>Indvidual Employment</em> Service Type is selected.');
		} else {
			$this->outcome = $outcome;
		}
	}
	
	public function setTimeframe($tf) {
		if (!has_value($tf, 'm') || $tf['m'] < 1 || $tf['m'] > 12
			|| !has_value($tf, 'y') || $tf['y'] < 2005 || $tf['y'] > date('Y')
			|| ($this->getType() == self::TREND && (!has_value($tf, 'd', 0, COMP_GT) || !has_value($tf, 'u', '/^[mqy]$/', COMP_REGEX)))) {
			error('Please select a time frame.');
			return;
		}
		$tf['m'] = $tf['u'] == 'q' ? intval($tf['m']) - ((intval($tf['m']) - 1)  % 3) : intval($tf['m']);
		
		if (mktime(0,0,0, $tf['m'], 1, $tf['y']) > mktime(0,0,0, date('m') - DATA_RELEASE_DELAY, 1)) {
			error('Records for this time frame are not available yet.');
		} else {
			$rs = fQuery('SELECT 1 FROM ' . TABLE_BILLING . ' WHERE ' . $this->makeTimeFrameClause($tf). ' LIMIT 0,1');
		 	if ($rs->queriedRows() == 0) {
				error('There are no records for this time frame.');
			} else {
				$this->timeframe = $tf;
			}
		}
	}
	
	public function setSummary($summary) {
		$summary = intval($summary);
		if ($summary > 0 && $summary < 4) {
			$this->summary = $summary;
		} else {
			error('Unknown Summary report.');
		}
	}
	
	public function setRegion($region, $step) {
		preg_match(REGEX_REGION_CODE, $region, $m);
		if (count($m) > 0) {
			$ret = getVar('SELECT 1 FROM ' . TABLE_BILLING . ' WHERE `RegionCode` = \'' . e($m[0]) . '\' LIMIT 0,1');
			if ($ret != 1) {
				error('There are no records with this region for your current criteria.');
			} else {
				$this->region = $m[0];
				$this->setNextStep(hasError() ? $this->getStep() : $step);
			}
		} else if ($region == '0') {
			$this->region = 'all';
			$this->setNextStep(hasError() ? $this->getStep() : $step);
		} else {
			error('Unknown region.');
		}
	}
	
	public function setCounty($county, $step) {
		preg_match(REGEX_COUNTY_CODE, $county, $m);
		if (count($m) > 0) {
			$regionCode = $this->region != 'all' ? 'RegionCode = \'' . e($this->region) . '\'' : '1';
			$ret = getVar('SELECT 1 FROM ' . TABLE_BILLING . ' WHERE CountyCode = \'' . e($m[0])
					   . '\' AND ' . $regionCode . ' LIMIT 0,1');
			if ($ret != 1) {
				error('There are no records with this county code for your current criteria.');
			} else {
				$this->county = $m[0];
				$this->setNextStep(hasError() ? $this->getStep() : $step);
			}
		} else if ($county == '0') {
			$this->county = 'all';
			$this->setNextStep(hasError() ? $this->getStep() : $step);
		} else {
			error('Unknown county code.');
		}
	}
	
	public function setProvider($provider, $step) {
		preg_match(REGEX_PROVIDER_NUMBER, $provider, $m);
		if (count($m) > 0) {
			$regionCode = $this->region != 'all' ? '`RegionCode` = \'' . e($this->region) . '\'' : '1';
			$countyCode = $this->county != 'all' ? '`CountyCode` = \'' . e($this->county) . '\'' : '1';
			$rs = fQuery('SELECT DISTINCT `ProviderNumber` FROM ' . TABLE_BILLING . ' WHERE `ProviderNumber` IN (\'' . str_replace(',', "','", e($m[0]))
					   . '\') AND ' . $regionCode . ' AND ' . $countyCode . ' ');
			if ($rs->queriedRows() == 0) {
				error('There are no records with this provider for your current criteria.');
			} else {
				$provider = '';
				while ($row = $rs->fetchArray()) {
					$provider .= (empty($provider) ? '' : ',') . $row[0];
				}					
				$this->provider = $provider;
				$this->setNextStep(hasError() ? $this->getStep() : $step);
			}
		} else if ($provider == '0') {
			$this->provider = 'all';
			$this->setNextStep(hasError() ? $this->getStep() : $step);
		} else {
			error('Unknown provider.');
		}
	}
	
	public function setGender($gender) {
		preg_match('#^(?:GN(?:MA|FE)|all|N/A)$#', $gender, $m);
		if (count($m) > 0) {
			$this->gender = $m[0];
		} else {
			error('Invalid Gender selection.');
		}
	}
	
	public function setFundingSource($fsc) {
		preg_match('/^[a-z0-9+]{1,3}$/i', $fsc, $m);
			if (count($m) > 0) {
				if ($m[0] == '0') {
					$this->fsc = 'all';
				} else {
					$ret = getVar('SELECT 1 FROM ' . TABLE_BILLING . ' WHERE `FundSourceCode` = \'' . e($fsc) . '\' LIMIT 0,1');
					if ($ret == 1) {
						$this->fsc = $m[0];
					} else {
						error('There are no records with this Funding Source.');
					}
				}
			} else {
				error('Invalid Funding Source.');
			}
	}
	
	public function setCognitivePreformanceScore($cps) {
		if (isFloat($cps)) {
				$cps = floatval($cps);
				if ($cps >= -1 && $cps <= 6) {
					$this->cps = $cps;
				} else {
					error('Coginitive Preformance Score out of the range of acceptable values, -1 - 6 inclusive.');
				}
			} else {
				error('Invalid Coginitive Preformance Score.');
			}
	}
	
	public function setCommunityAccessSupportLevel($casl) {
		preg_match('/^(?:0|DL0\d)$/', $casl, $m);
		if (count($m) > 0 && $m[0] === '0') {
			$this->casl = 'all';
		} else if (count($m) > 0) {
			$ret = getVar('SELECT 1 FROM ' . TABLE_BILLING . ' WHERE `CommunityAccessSupportLevelCode` = \'' . e($m[0]) . '\' LIMIT 0,1');
			if ($ret == 1) {
				$this->casl = $m[0];
			} else {
				error('There are no records with this Community Access Support Level.');
			}
		} else {
			error('Invalid Community Access Suport Level.');
		}
	}
	
	public function setEmploymentSupportLevel($esl) {
		preg_match('/^(?:0|DL0\d)$/', $esl, $m);
		if (count($m) > 0 && $m[0] == '0') {
			$this->esl = 'all';
		} else if (count($m) > 0) {
			$ret = getVar('SELECT 1 FROM ' . TABLE_BILLING . ' WHERE `EmploymentSupportLevelCode` = \'' . e($m[0]) . '\' LIMIT 0,1');
			if ($ret == 1) {
				$this->esl = $m[0];
			} else {
				error('There are no records with this Employment Support Level.');
			}
		}
	}
	
	public function setAgeGroup($ag) {
		if (!has_value($ag, 'start', 0, COMP_GE) || !has_value($ag, 'end', 0, COMP_GE)) {
			error('Start age or end age missing.');
		} else if ($ag['start'] > $ag['end'] && $ag['end'] != 0) {
			error('The start age is greater than the end age.');
		} else {
			$this->ageStart = intval($ag['start']);
			$this->ageEnd = intval($ag['end']);
		}
	}
	
	public function setResidenceType($rt) {
		$rt = intval($_REQUEST['rt']);
		if (in_array($rt, $this->residenceTypes)) {
			$this->residenceType = $rt;
		} else {
			error('Unknown Residence Ty;e.');
		}
	}	

	public function getActivity() {
		return $this->serviceCode;
	}
	
	public function getOutcome() {
		return $this->outcome;
	}
	
	public function getTimeFrame() {
		return $this->timeframe;
	}
	
	public function getSummary() {
		return $this->summary;
	}
	
	public function getRegion() {
		return $this->region;
	}
	
	public function getCounty() {
		return $this->county;
	}
	
	public function getProvider() {
		return $this->provider;
	}
	
	public function getGender() {
		return $this->gender;
	}
	
	public function getFundingSource() {
		return $this->fsc;
	}
	
	public function getCognitivePerformanceScore() {
		return $this->cps;
	}
	
	public function getCommunityAccessSupportLevel() {
		return $this->casl;
	}
	
	public function getEmploymentSupportLevel() {
		return $this->esl;
	}
	
	public function getAgeGroup() {
		return $this->ageGroup;
	}
	
	public function getResidenceType() {
		return $this->residenceType;
	}
	
	/**
	 * Copy the current report ot make a complete seperate report.
	 * @return report
	 */
	public function copy() {
		$vars = get_object_vars($this);
		$rpt = new report(0, false);
		foreach ($vars as $var => $val) {
			if ($val instanceof Tag) {
				$rpt->$var = $val->copy();
				$rpt->$var->walk(array('select', 'clearSelected'));
			} else {
				$rpt->$var = $val;
			}
		}
		return $rpt;
	}
	
	public function getRegions() {
		return $this->regions;
	}
	
	public function getCountiesInRegion($r) {
		return has_value($this->counties, $r) ? $this->counties[$r] : array();
	}
	
	public function getProvidersInRegionCounty($r, $c) {
		return has_value($this->providers, $r) && has_value($this->providers[$r], $c) ? $this->providers[$r][$c] : array();
	}
	
	public function lastUpdated() {
		return getVar('SELECT MAX(`ServerYearMonth`) FROM ' . TABLE_BILLING);
	}
}
