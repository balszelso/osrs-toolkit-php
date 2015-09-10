<?php

namespace opensrs\domains\provisioning;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data -
 */

class ProvisioningUpdateAllInfo extends Base {
	private $_dataObject;
	private $_formatHolder = "";
	public $resultFullRaw;
	public $resultRaw;
	public $resultFullFormatted;
	public $resultFormatted;

	public function __construct( $formatString, $dataObject ) {
		parent::__construct();
		$this->_dataObject = $dataObject;
		$this->_formatHolder = $formatString;
		$this->_validateObject();
	}

	public function __destruct() {
		parent::__destruct();
	}

	// Validate the object
	private function _validateObject() {
		// Command required values
		if(
			!isset( $this->_dataObject->data->domain ) ||
			$this->_dataObject->data->domain  == ""
		) {
			throw new Exception( "oSRS Error - domain is not defined." );
		}

		// Check that the full contact set is there
		if(
			!isset( $this->_dataObject->data->owner_contact ) ||
			$this->_dataObject->data->owner_contact  == ""
		) {
			throw new Exception( "oSRS Error - owner_contact is not defined." );
		} else {
			if( !$this->_allRequired("owner_contact" )) {
				throw new Exception( "oSRS Error - Incorrect call." );
			}

		}
		if(
			!isset( $this->_dataObject->data->admin_contact ) ||
			$this->_dataObject->data->admin_contact  == ""
		) {
			throw new Exception( "oSRS Error - admin_contact is not defined." );
		} else {
			if( !$this->_allRequired("admin_contact" )) {
				throw new Exception( "oSRS Error - Incorrect call." );
			}

		}
		if(
			!isset( $this->_dataObject->data->tech_contact ) ||
			$this->_dataObject->data->tech_contact  == ""
		) {
			throw new Exception( "oSRS Error - tech_contact in is not defined." );
		} else {
			if( !$this->_allRequired("tech_contact" )) {
				throw new Exception( "oSRS Error - Incorrect call." );
			}
		}
		if(
			!isset( $this->_dataObject->data->billing_contact ) ||
			$this->_dataObject->data->billing_contact  == ""
		) {
				throw new Exception( "oSRS Error - billing_contact is not defined." );
		} else {
			if( !$this->_allRequired("billing_contact" )) {
				throw new Exception( "oSRS Error - Incorrect call." );
			}
		}

		//Check Nameserver Values
		if(
			!isset( $this->_dataObject->data->nameserver_names ) ||
			$this->_dataObject->data->nameserver_names  == ""
		) {
			throw new Exception( "oSRS Error - The function requires at least one nameserver is provided." );
		}

		//Check there are the samenumber of Nameserver IP values are there are  Nameserver Name values
		if(
			isset( $this->_dataObject->data->nameserver_ips ) &&
			$this->_dataObject->data->nameserver_ips  != ""
		) {
			if(
				count( explode(",",$this->_dataObject->data->nameserver_ips )) !=
				count( explode(",",$this->_dataObject->data->nameserver_names ))
			) {
				throw new Exception( "oSRS Error - The function requires the same number of Nameserver IP addresses as Nameserver names if you are defining Nameserver IP addresses." );
				$allPassed = false;
			}
		}


		// Execute the command
		$this->_processRequest();
	}


	private function _allRequired( $contact ) {
		// Check Contact information
		$reqPers = array( "first_name", "last_name", "org_name", "address1", "city", "state", "country", "postal_code", "phone", "email", "lang_pref" );
		for( $i = 0; $i < count($reqPers); $i++ ) {
			if(
				!isset($this->_dataObject->data->$contact->{$reqPers[$i]}) ||
				$this->_dataObject->data->$contact->{$reqPers[$i]} == ""
			) {
				throw new Exception( "oSRS Error -  ". $reqPers[$i] ." is not defined in $contact contact set." );
			}
		}

		return true;
	}

	// Post validation functions
	private function _processRequest() {

	$cmd = array(
			'protocol' => 'XCP',
			'action' => 'update_all_info',
			'object' => 'domain',
			'domain' => $this->_dataObject->data->domain,
			'attributes' => array(
				'domain' =>$this->_dataObject->data->domain,
				'nameserver_list' => array(),
				'contact_set' => array(
						'owner' => array(
							"first_name" => $this->_dataObject->data->owner_contact->first_name,
							"last_name" => $this->_dataObject->data->owner_contact->last_name,
							"org_name" => $this->_dataObject->data->owner_contact->org_name,
							"address1" => $this->_dataObject->data->owner_contact->address1,
							"address2" => $this->_dataObject->data->owner_contact->address2,
							"address3" => $this->_dataObject->data->owner_contact->address3,
							"city" => $this->_dataObject->data->owner_contact->city,
							"state" => $this->_dataObject->data->owner_contact->state,
							"postal_code" => $this->_dataObject->data->owner_contact->postal_code,
							"country" => $this->_dataObject->data->owner_contact->country,
							"phone" => $this->_dataObject->data->owner_contact->phone,
							"fax" => $this->_dataObject->data->owner_contact->fax,
							"email" => $this->_dataObject->data->owner_contact->email,
							"lang_pref" => $this->_dataObject->data->owner_contact->lang_pref
							),

						'admin' => array(
							"first_name" => $this->_dataObject->data->admin_contact->first_name,
							"last_name" => $this->_dataObject->data->admin_contact->last_name,
							"org_name" => $this->_dataObject->data->admin_contact->org_name,
							"address1" => $this->_dataObject->data->admin_contact->address1,
							"address2" => $this->_dataObject->data->admin_contact->address2,
							"address3" => $this->_dataObject->data->admin_contact->address3,
							"city" => $this->_dataObject->data->admin_contact->city,
							"state" => $this->_dataObject->data->admin_contact->state,
							"postal_code" => $this->_dataObject->data->admin_contact->postal_code,
							"country" => $this->_dataObject->data->admin_contact->country,
							"phone" => $this->_dataObject->data->admin_contact->phone,
							"fax" => $this->_dataObject->data->admin_contact->fax,
							"email" => $this->_dataObject->data->admin_contact->email,
							"lang_pref" => $this->_dataObject->data->admin_contact->lang_pref
							),

						'tech' => array(
							"first_name" => $this->_dataObject->data->tech_contact->first_name,
							"last_name" => $this->_dataObject->data->tech_contact->last_name,
							"org_name" => $this->_dataObject->data->tech_contact->org_name,
							"address1" => $this->_dataObject->data->tech_contact->address1,
							"address2" => $this->_dataObject->data->tech_contact->address2,
							"address3" => $this->_dataObject->data->tech_contact->address3,
							"city" => $this->_dataObject->data->tech_contact->city,
							"state" => $this->_dataObject->data->tech_contact->state,
							"postal_code" => $this->_dataObject->data->tech_contact->postal_code,
							"country" => $this->_dataObject->data->tech_contact->country,
							"phone" => $this->_dataObject->data->tech_contact->phone,
							"fax" => $this->_dataObject->data->tech_contact->fax,
							"email" => $this->_dataObject->data->tech_contact->email,
							"lang_pref" => $this->_dataObject->data->tech_contact->lang_pref
							),
						'billing' => array(
							"first_name" => $this->_dataObject->data->billing_contact->first_name,
							"last_name" => $this->_dataObject->data->billing_contact->last_name,
							"org_name" => $this->_dataObject->data->billing_contact->org_name,
							"address1" => $this->_dataObject->data->billing_contact->address1,
							"address2" => $this->_dataObject->data->billing_contact->address2,
							"address3" => $this->_dataObject->data->billing_contact->address3,
							"city" => $this->_dataObject->data->billing_contact->city,
							"state" => $this->_dataObject->data->billing_contact->state,
							"postal_code" => $this->_dataObject->data->billing_contact->postal_code,
							"country" => $this->_dataObject->data->billing_contact->country,
							"phone" => $this->_dataObject->data->billing_contact->phone,
							"fax" => $this->_dataObject->data->billing_contact->fax,
							"email" => $this->_dataObject->data->billing_contact->email,
							"lang_pref" => $this->_dataObject->data->billing_contact->lang_pref
							)
						)
				)

		);

		// Command optional values
		if(
			isset( $this->_dataObject->data->nameserver_names ) &&
			$this->_dataObject->data->nameserver_names != ""
		) {

			$nameServers=explode( ",",$this->_dataObject->data->nameserver_names );

    			if(
    				isset( $this->_dataObject->data->nameserver_ips ) &&
    				$this->_dataObject->data->nameserver_ips != ""
				) {
					$ipAddresses=explode( ",",$this->_dataObject->data->nameserver_ips );
				}

			$i=0;

			foreach( $nameServers as $nameServer ) {
				$cmd['attributes']['nameserver_list'][$i]['fqdn'] = $nameServer;

				if( isset($ipAddresses[$i] )) {
					$cmd['attributes']['nameserver_list'][$i]['ipaddress'] = $ipAddresses[$i];
				}

				$i++;
			}


		}

		// Flip Array to XML
		$xmlCMD = $this->_opsHandler->encode( $cmd );
		// Send XML
		$XMLresult = $this->send_cmd( $xmlCMD );
		// Flip XML to Array
		$arrayResult = $this->_opsHandler->decode( $XMLresult );

		// Results
		$this->resultFullRaw = $arrayResult;
		$this->resultRaw = $arrayResult;
		$this->resultFullFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultFullRaw );
		$this->resultFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultRaw );
	}
}
