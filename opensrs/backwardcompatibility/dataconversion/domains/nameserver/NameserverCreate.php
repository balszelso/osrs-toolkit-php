<?php

namespace opensrs\backwardcompatibility\dataconversion\domains\nameserver;

use opensrs\backwardcompatibility\dataconversion\DataConversion;

class NameserverCreate extends DataConversion
{
    // New structure for API calls handled by
    // the toolkit.
    //
    // index: field name
    // value: location of data to map to this
    //		  field from the original structure
    //
    // example 1:
    //    "cookie" => 'data->cookie'
    //	this will map ->data->cookie in the
    //	original object to ->cookie in the
    //  new format
    //
    // example 2:
    //	  ['attributes']['domain'] = 'data->domain'
    //  this will map ->data->domain in the original
    //  to ->attributes->domain in the new format
    protected $newStructure = array(
        'cookie' => 'data->cookie',

        'attributes' => array(
            'add_to_all_registry' => 'data->add_to_all_registry',
            'domain' => 'data->domain',
            'ipaddress' => 'data->ipaddress',
            'ipv6' => 'data->ipv6',
            'name' => 'data->name',
            ),
        );

    public function convertDataObject($dataObject, $newStructure = null)
    {
        $p = new parent();

        if (is_null($newStructure)) {
            $newStructure = $this->newStructure;
        }

        $newDataObject = $p->convertDataObject($dataObject, $newStructure);

        if(isset($newDataObject->attributes->add_to_all_registry)){
            $newDataObject->attributes->add_to_all_registry = explode(
                ',',
                $newDataObject->attributes->add_to_all_registry
            );
        }

        return $newDataObject;
    }
}
