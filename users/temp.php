<?php
error_reporting(E_ALL);
	ini_set('display_errors', 'On');
/*** *** *** *** *** ***
* @package Quadodo Login Script
* @file    admincp.php
* @start   July 26th, 2007
* @author  Douglas Rennehan
* @license http://www.opensource.org/licenses/gpl-license.php
* @version 2.0.0
* @link    http://www.quadodo.com
*** *** *** *** *** ***
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*** *** *** *** *** ***
* Comments are always before the code they are commenting.
*** *** *** *** *** ***/

define('QUADODO_IN_SYSTEM', true);
require_once('includes/header.php');
echo "1<br>";
$array = array();
$array[] = "aditus_jd,ZRgXtaEh,43905";
$array[] = "advancewithvac_jd,pekFzgm4,44003";
$array[] = "advocatesinc_jd,exnk2yAx,43906";
$array[] = "alternativesnet_jd,FynDxfCQ,43908";
$array[] = "altsupports_jd,ttW7zkM9,43907";
$array[] = "amegoinc_jd,u4GrdgTR,43909";
$array[] = "americantrain_jd,DAZRbWWH,43910";
$array[] = "arcsouthshore_jd,NPrd2BnD,43994";
$array[] = "attleboro_jd,M2gB3jL9,43916";
$array[] = "attleboroent_jd,JnQjsnCy,43916";
$array[] = "autismserve_jd,gS7FHvtQ,43917";
$array[] = "bamsi_jd,E4XGxzP9,43927";
$array[] = "barrypricectr_jd,N2nUp4Eg,43918";
$array[] = "baycove_jd,nHq8NnYq,43934";
$array[] = "bc_jd,vYVcTBnH,43924";
$array[] = "berkhills_jd,rEEUmXTE,50002";
$array[] = "bestbuddies_jd,4a5YKunF,43922";
$array[] = "bettercomm_jd,vHazbhUe,43923";
$array[] = "bfair_jd,fRmQA3mh,43921";
$array[] = "bridgewell_jd,9tWhADXu,43925";
$array[] = "brockarc_jd,Rmfywcsf,43926";
$array[] = "capeabilities_jd,TMpfGyV9,43929";
$array[] = "ccworc_jd,LyRWsdQB,43932";
$array[] = "charlesriverctr_jd,kfjdQEwf,43936";
$array[] = "coletta_jd,K2f5zmTm,43930";
$array[] = "commcon_jd,dbNhKYaJ,43937";
$array[] = "comment_jd,bjq7YMRP,43938";
$array[] = "commop_jd,KBWLmWrX,43939";
$array[] = "coop_jd,dnGmYbX3,43941";
$array[] = "crcmass_jd,AhPBWrsd,43931";
$array[] = "cwsbos_jd,2j8PUt3v,43940";
$array[] = "deltaprojects_jd,q6UtBtCg,43942";
$array[] = "eliotchs_jd,rBAkFWuL,43945";
$array[] = "empresources_jd,N8cbLnKv,43911";
$array[] = "friendhome_jd,ASmCVcdA,50003";
$array[] = "gaamha_jd,cGXkYwLC,43947";
$array[] = "glec_jd,Nz6wyvkz,43950";
$array[] = "goodwillmass_jd,XV4cBkj2,43974";
$array[] = "growassoc_jd,6ZjCHbp6,43954";
$array[] = "gwarc_jd,bkyMyvca,43953";
$array[] = "gwmass_jd,4Dhcn4LS,43974";
$array[] = "halcyonctr_jd,hSBsHHvE,43919";
$array[] = "hmea_jd,gguykDcT,43955";
$array[] = "houseyawk_jd,JTHJgd7t,50006";
$array[] = "hru_jd,qGRsp8TX,43956";
$array[] = "ici_jd,PSQyU3Lz,43957";
$array[] = "ippi_jd,UCgfngJT,43958";
$array[] = "jri1_jd,bNHmBbum,43960";
$array[] = "jvsboston_jd,fvzAXtwM,43959";
$array[] = "kdc_jd,pZmS9Ln4,43961";
$array[] = "ledges_jd,AzRPNEwp,43962";
$array[] = "lifefocus_jd,huLCsmbW,43963";
$array[] = "lifestreaminc_jd,qEzzKRhW,43964";
$array[] = "lifeworksma_jd,XuN4xapR,43965";
$array[] = "mabcomm_jd,9hKbRSjA,43967";
$array[] = "mayinstitute_jd,ALFY3GWG,43969";
$array[] = "meccorp_jd,vhTYT96f,43971";
$array[] = "meridianassoc_jd,VqhqEVm4,43970";
$array[] = "microtek_jd,9SBg9NZh,43972";
$array[] = "minutemanarc_jd,AMzBMg2a,43973";
$array[] = "molife_jd,yaYCzhCr,43966";
$array[] = "nearc_jd,RKYsRsZw,43980";
$array[] = "necc_jd,wAKSs8Tp,43978";
$array[] = "nemgroup_jd,sb7tbsnJ,43976";
$array[] = "nevillage_jd,76tyfkXy,43979";
$array[] = "northsuffolk_jd,YtYuYH69,43981";
$array[] = "Nupat_jd,tUMehBgN,50007";
$array[] = "nycap_jd,7mdvKBMB,43948";
$array[] = "oppworks_jd,T8mbQ5RV,43952";
$array[] = "ourgoodwill_jd,EuwsXKUW,43949";
$array[] = "partserve_jd,K3kYAaRP,43983";
$array[] = "peopleincfr_jd,uERkSfbR,43984";
$array[] = "perkinschool_jd,Khd4d9yM,43943";
$array[] = "pluscompany_jd,bwxd3qHb,43985";
$array[] = "polusctr_jd,naZbdwtZ,43986";
$array[] = "prideinc_jd,7cErRjGV,43982";
$array[] = "regemp_jd,wbG2XtVV,43987";
$array[] = "rehabresinc_jd,k3yfJvHV,43988";
$array[] = "roadtoresp_jd,HUpFD55H,43990";
$array[] = "rsi_jd,75z7bLTV,43989";
$array[] = "servnetinc_jd,8kG7yX8U,50004";
$array[] = "sevenhillsc_jd,6s3KDSrP,43991";
$array[] = "sevenhillsf_jd,ZhDqJ5d5,43992";
$array[] = "smecollab_jd,U3aLXNZD,43993";
$array[] = "sowocore2_jd,AQ5hkF5V,50005";
$array[] = "sunshine_jd,35bFx5NW,43996";
$array[] = "thearcofgp_jd,j5UEarZD,43913";
$array[] = "theemarc_jd,WQsyHfG3,43944";
$array[] = "tillinc_jd,VEVc5bZJ,43997";
$array[] = "triangleinc_jd,wUV4gZkR,43998";
$array[] = "valleyEd_jd,ae8mLyHL,43999";
$array[] = "vinfen1_jd,5HVv85yq,44000";
$array[] = "vinfengate_jd,hg64DJKP,44001";
$array[] = "wearewci_jd,TPN9t4e4,44005";
$array[] = "workoppctr_jd,Sc6WWKvu,44008";
$array[] = "wscinc_jd,DVdhgAAy,44004";
$array[] = "test_frank,DVdhgAAy,44004";
foreach ($array as $i => $value) {
    $parts = explode(",",$value);
	echo "adding " . $parts[0] . ", " . $parts[1] . ", " . agnes.zalewska@umb.edu . ", " . $parts[2] . "<br/>";
	//$qls->User->insert_registration_data($parts[0], $parts[1], "agnes.zalewska@umb.edu", $parts[2]);
	echo "done<br/>";
}



?>