<?php

namespace OpenSRS\mail;

use OpenSRS\mail\SetDomainBlockList;
/**
 * @group mail
 * @group MailSetDomainBlockList
 */
class SetDomainBlockListTest extends \PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'attributes' => array(
            'admin_username' => '',
            'admin_password' => '',
            'admin_domain' => '',
            'domain' => '',
            'list' => '',
            ),
        );

    /**
     * Valid submission should complete with no
     * exception thrown
     *
     * @return void
     *
     * @group validsubmission
     */
    public function testValidSubmission() {
        $data = json_decode( json_encode($this->validSubmission ) );

        $data->attributes->admin_username = 'phptest' . time();
        $data->attributes->admin_password = 'password1234';
        $data->attributes->admin_domain = 'mail.phptest' . time() . '.com';
        $data->attributes->domain = 'new-' . $data->attributes->admin_domain;
        $data->attributes->list = "phptest" . time();

        $ns = new SetDomainBlockList( 'array', $data );

        $this->assertTrue( $ns instanceof SetDomainBlockList );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing admin_username' => array('admin_username'),
            'missing admin_password' => array('admin_password'),
            'missing admin_domain' => array('admin_domain'),
            'missing domain' => array('domain'),
            'missing list' => array('list'),
            );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @dataProvider submissionFields
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing( $field, $parent = 'attributes', $message = null ) {
        $data = json_decode( json_encode($this->validSubmission ) );

        $data->attributes->admin_username = 'phptest' . time();
        $data->attributes->admin_password = 'password1234';
        $data->attributes->admin_domain = 'mail.phptest' . time() . '.com';
        $data->attributes->domain = 'new-' . $data->attributes->admin_domain;
        $data->attributes->list = "phptest" . time();
        
        if(is_null($message)){
          $this->setExpectedExceptionRegExp(
              'OpenSRS\Exception',
              "/$field.*not defined/"
              );
        }
        else {
          $this->setExpectedExceptionRegExp(
              'OpenSRS\Exception',
              "/$message/"
              );
        }



        // clear field being tested
        if(is_null($parent)){
            unset( $data->$field );
        }
        else{
            unset( $data->$parent->$field );
        }

        $ns = new SetDomainBlockList( 'array', $data );
    }
}