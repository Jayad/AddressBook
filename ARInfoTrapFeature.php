Index: ARInfoTrapFeature.php
===================================================================
--- ARInfoTrapFeature.php	(revision 287961)
+++ ARInfoTrapFeature.php	(working copy)
@@ -109,6 +109,25 @@
 				}
 			}
 		}
+		// Read mobile number for AddressBook Entry		
+		$this->_outputData['addressBook'] = array();
+		$addressBookEntry = array();
+		$addressBookEntry = $this->_glue->getAllABImportedMobileNumbers();
+		csp_log_debug(__method__, 'Commchannels available from AddressBook field', $addressBookEntry);
+		if(is_array($addressBookEntry)){
+		//We need only the first Mobile Number from mbr_ar_data, considering that we are saving in array format
+			foreach($addressBookEntry as $value => $mobilearray){
+				//Need to read the first mobile Number saved in mbr_ar_data
+			 //  if($type == CommChanMgmtUtil::MOBILE_TYPE){//Will change the function name once Mridul provides the details
+	//No CommChanMgmtUtil::MOBILE_TYPE check is required here since Mriduls code will be taking care of the check to send only Mobile Number
+				$this->_outputData['addressBook'] = mobileUtils::extractPhoneNumber(key($mobilearray));
+				$this->_outputdata['AddCountryCode'] = mobileUtils::extractCountryCode(key($mobilearray));
+				if($this->_outputdata['AddCountryCode'] == ' ')
+					$this->_outputdata['AddCountryCode'] = mobileUtils::getCountryCode(strtoupper($this->_user->get('intl')));
+		//Defaulting the country code for the users intl, user can select in review page for saving
+			//	}Not required since its only sending Mobile number
+			}
+		}
 
 		// load questions
 		$this->_outputData['PWQs'] = array();
@@ -135,7 +154,7 @@
 			if ($this->_glue->getSuppRegTrapName() === ARINFO_AEA_TRAPNAME) 
 			{
 				$this->_outputData['showAEAOnlyFlow']=true;
-			} else if ($this->_glue->getSuppRegTrapName() === ARINFO_MOBILE_TRAPNAME)
+			} else if ($this->_glue->getSuppRegTrapName() === ARINFO_MOBILE_TRAPNAME || $this->_glue->getSuppregTrapName() === ARINFO_MOBILE_ABI_TRAPNAME)
 			{
 				$this->_outputData['showMOBILEOnlyFlow']=true;
 			}
@@ -228,7 +247,7 @@
 					}
 				}
                                else{
-                                     if($this->_glue->getSuppRegTrapName() == ARINFO_MOBILE_TRAPNAME)
+                                     if(($this->_glue->getSuppRegTrapName() == ARINFO_MOBILE_TRAPNAME) || ($this->_glue->getSuppRegTrapName()) === ARINFO_MOBILE_ABI_TRAPNAME)
                                      {
                                       csp_log_debug(__METHOD__, 'User entered nothing in Mobile Number field -- Error for Mobile Trap');
                                                  throw new yrespException( $this->_yresp, 76057) ;
@@ -292,7 +311,7 @@
 		}else{ //Feature = ARInfoTrapList; Flow = ARInfoTrapStart 
 			if($this->_glue->getSuppRegTrapName() == ARINFO_AEA_TRAPNAME) {
 					$this->_outputData['showAEAOnlyFlow']=true;
-			} else if ($this->_glue->getSuppRegTrapName() == ARINFO_MOBILE_TRAPNAME) {
+			} else if (($this->_glue->getSuppRegTrapName() == ARINFO_MOBILE_TRAPNAME) || ($this->_glue->getSuppRegTrapName() === ARINFO_MOBILE_ABI_TRAPNAME)) {
 					$this->_outputData['showMOBILEOnlyFlow']=true;
 			} 	
 			// DEFER Event - Required only for arinfo trap and not for aea/mobile traps
