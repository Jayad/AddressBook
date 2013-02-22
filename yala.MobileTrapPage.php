Index: yala.MobileTrapPage.php
===================================================================
--- yala.MobileTrapPage.php	(revision 287772)
+++ yala.MobileTrapPage.php	(working copy)
@@ -40,15 +40,13 @@
 		$isARMobileCollectionFlow = false;
 
 		$isAddressBookCollecionFlow = false; //true only for importing contact details from AddressBook
-		$isAddressBookCollecionFlow =array_key_exists('ab', $this->_data) ? true : false;
+		$isAddressBookCollecionFlow = (($this->_data['sr_trapname']) == 'arinfo_mobile_abi') ? true : false;
 		$isABookCollecionFlow = false;
 	
                 $aMobileEligibleCountry = array();  
 		if($isMobileCollectionFlow) {
 			$isARMobileCollectionFlow = ($this->_data['chn'] === 'ar') ? true : false;
 		} 
-		elseif ($isAddressBookCollecionFlow){
-			$isABookCollecionFlow = ($this->_data['ab'] === 'yes') ? true ; false;
 		else {
 			if(strlen(AgingGlueUtils::getEligibleCountryForMobileList())>0){
 				$aMobileEligibleCountry = explode(',', AgingGlueUtils::getEligibleCountryForMobileList());
@@ -57,8 +55,12 @@
 				}
 			}
 		}
-                $mobile = ($this->_data['commChannels'] && array_key_exists('MOBILE', $this->_data['commChannels'])) ? $this->_data['commChannels']['MOBILE'] : '';
- 
+
+		if($isAddressBookCollecionFlow) {
+			$mobile = $this->_data['addressBook'];}
+		else {
+                	$mobile = ($this->_data['commChannels'] && array_key_exists('MOBILE', $this->_data['commChannels'])) ? $this->_data['commChannels']['MOBILE'] : '';
+ 		}
 		$emailError = false;
 		$mobileError = false;
 		$genericError = false;
@@ -136,8 +138,10 @@
 		$suppreg_status = $this->_data['sr_type'];
 		if(empty($suppreg_status)) {
                 	$pageName = ($this->_data['commChannels'] && array_key_exists('MOBILE', $this->_data['commChannels'])) ? 'suppreg_mobile_review' : 'suppreg_mobile_missing';
-
-		} else {
+		}
+		elseif($isAddressBookCollecionFlow)
+			$pageName = 'suppreg_mobile_review';//For AddressBook collection, making the page as review case
+		else {
 			switch($suppreg_status) {
 				case 6: //MISSING STATUS
 					$pageName = 'suppreg_mobile_missing';
@@ -372,7 +376,6 @@
     <input type="hidden" name="tn" value="<?php echo $this->_data['sr_trapname'];?>">
     <input type="hidden" name="st" value="<?php echo $this->_data['sr_type'];?>">
     <input type="hidden" name="chn" value="<?php echo $this->_data['chn'];?>">
-    <input type="hidden" name="ab" value="<?php echo $this->_data['ab'];?>">
              </form>
  		</div>
  	</div>
