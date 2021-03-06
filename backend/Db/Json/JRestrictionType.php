<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 3/19/2015
 * Time: 9:57 PM
 */

namespace Db\Json;
use Db\Utility\FieldUtils;
use Db\Utility\ArrayUtils;


class JRestrictionType extends JObjectRoot implements JSONInterface, JObjectifiable {
    public $RestrictionTypeId;
    public $Name;
    public $Display;
    public $Description;
    public $Path;
    public $UpdateTime;
    public $UpdateUser;

    public function JRestrictionType(){
        return $this;
    }

    public static function CREATE_FROM_DB(\RestrictionType $item)
    {
        $mine = new JRestrictionType();
        $mine->RestrictionTypeId = $item->getRestrictionTypeId();
        $mine->Name = $item->getName();
        $mine->Display = $item->getDisplay();
        $mine->Description = $item->getDescription();
        $mine->Path = $item->getPath();
        $mine->UpdateTime = $item->getUpdateTime()->format(\DateTime::ISO8601);
        $mine->UpdateUser = $item->getUpdateUser();
        return $mine;
    }

    public static function CREATE_FROM_ARRAY(array $data)
    {
        $mine = new JRestrictionType();
        if(ArrayUtils::KEY_EXISTS($data,'RestrictionTypeId'))  {
            $db = (new \RestrictionTypeQuery())->findPk($data["RestrictionTypeId"]);
            if(!is_null($db)) {
                    $mine = JRestrictionType::CREATE_FROM_DB( $db );
            } else {
                $mine->RestrictionTypeId = $data['RestrictionTypeId'];
            }
        }
        if(ArrayUtils::KEY_EXISTS($data,'Name')) $mine->Name = $data['Name'];
        if(ArrayUtils::KEY_EXISTS($data,'Description')) $mine->Description = $data['Description'];
        if(ArrayUtils::KEY_EXISTS($data,'Path')) $mine->Path = $data['Path'];
        if(ArrayUtils::KEY_EXISTS($data,'Display')) $mine->Display = $data['Display'];
        $mine->UpdateTime = new \DateTime();
        if(ArrayUtils::KEY_EXISTS($data,'UpdateUser')) $mine->UpdateUser = $data['UpdateUser'];

        return $mine;

    }

    public function saveToDb() {
        return $this->toDB()->save() > 0;
    }

    public function toDB()
    {
        $is = new \RestrictionType();
        return $this->updateDB($is);
    }

    public function updateDB(\RestrictionType &$item)
    {
        if(FieldUtils::ID_IS_DEFINED($this->RestrictionTypeId)) $item->setRestrictionTypeId($this->RestrictionTypeId);

        if(FieldUtils::STRING_IS_DEFINED($this->Description)) $item->setDescription($this->Description);
        if(FieldUtils::STRING_IS_DEFINED($this->Path)) $item->setPath($this->Path);
        if(FieldUtils::STRING_IS_DEFINED($this->Display)) $item->setDisplay($this->Display);
        if(FieldUtils::STRING_IS_DEFINED($this->Name)) $item->setName($this->Name);
        $item->setUpdateTime(new \DateTime());
        if(FieldUtils::STRING_IS_DEFINED($this->UpdateUser)) $item->setUpdateUser($this->UpdateUser);
        return $item;
    }

    public function getLabel() {
        return $this->Name;
    }

    public function getValue()
    {
        return $this->RestrictionTypeId;
    }

}