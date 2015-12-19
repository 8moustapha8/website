<?php
/**
 * Created by PhpStorm.
 * User: Work
 * Date: 2015/08/07
 * Time: 20:23
 */

namespace Db\Core;


use Db\Json\JFeatureType;
use Db\Json\JGeneralRestriction;

class Store {
    public $Id;
    public $Name;
    public $IsMajor;
    public $Allocation;

    public static function CREATE(\Store $store) {
        $that = new Store();
        $that->Id = $store->getStoreId();
        $that->Name = $store->getStoreName();
        $that->IsMajor = $store->getIsMajor();
        if(!is_null($store->getAllocation())) {
            $that->Allocation = $store->getAllocation() * 0.01;
        } else {
            $that->Allocation = 10 * 0.01;
        }
        return $that;
    }
}

class Category {
    public $Id;
    public $Name;
    public $Store = array();
    public function Category(){}

    public static function CREATE(\StoreCategory $cat) {
        $that = new Category();
        $that->Id = $cat->getStoreCategoryId();
        $that->Name = $cat->getName();
        foreach($cat->getStores() as $item) {
            array_push($that->Store, Store::CREATE($item));
        }
        return $that;
    }
}



class RewardCategory {
    public $Id;
    public $Name;
    public $SubCategory;
    public $Description;

    public static function CREATE(\RewardCategory $cat) {
        if(strtolower($cat->getName()) == "none") return null;
        $mine = new RewardCategory();
        $mine->Id =$cat->getRewardCategoryId();
        $mine->Name = $cat->getName();
        $mine->Description = $cat->getDescription();
        $mine->SubCategory = $cat->getSubcategory();
        return $mine;
    }

}

class Scene {
    public $Id;
    public $Name;
    public $RewardTypes = array();
    public $Stores = array();

    public function Scene(){}

    public static function CREATE(\Scene $scene)
    {
        $that = new Scene();
        $that->Name = $scene->getName();
        $that->Id = $scene->getSceneId();
        foreach($scene->getMapSceneStoreCategories() as $item) {
            $that->Stores=array_merge($that->Stores,  Category::CREATE($item->getStoreCategory())->Store);
        }

        foreach($scene->getMapSceneRewcats() as $item) {
            array_push($that->RewardTypes,  RewardCategory::CREATE($item->getRewardCategory()));
        }

        return $that;
    }

    public static function CREATE_INCLUDING_PERSONA(\Scene $scene)
    {
        $that = Scene::CREATE($scene);
        $that->Persona = array();

        foreach($scene->getMapPersonaScenes() as $map) {
            array_push($that->Persona, Persona::CREATE($map->getPersona()));
        }

        return $that;
    }
}

class Restriction {
    public $FeatureRestriction = array();
    public $GeneralRestriction = array();

    public function Restriction(){}

    public static function CREATE(\Persona $persona)
    {
        $that = new Restriction();
        foreach($persona->getMapPersonaFeatureConstraints() as $item) {
            $feat = JFeatureType::CREATE_FROM_DB($item->getCardFeatureType());
            $feat->Negative = $item->getNegative();
            array_push($that->FeatureRestriction,  $feat);
        }

        foreach($persona->getPersonaRestrictions() as $item) {
            array_push($that->GeneralRestriction,  JGeneralRestriction::CREATE_FROM_DB($item)->getRestriction());
        }

        return $that;
    }
}



class Persona {
    public $Id;
    public $Identifier;
    public $Name;
    public $Restriction;
    public $DefaultSpend;
    public $Sorting;
    public $RewardCategory;

    public function Persona(){}

    public static function CREATE(\Persona $pers) {
        $that = new Persona();
        $that->Id = $pers->getPersonaId();
        $that->Identifier = $pers->getIdentifier();
        $that->Name= $pers->getName();
        $that->Restriction = Restriction::CREATE($pers);
        $that->DefaultSpend = $pers->getDefaultSpend();
        $that->Sorting = $pers->getSorting();
        $that->RewardCategory = RewardCategory::CREATE($pers->getRewardCategory());
        return $that;
    }

    public static function CREATE_INCLUDING_SCENES(\Persona $pers) {
        $that = Persona::CREATE($pers);
        $that->Scene = array();
        foreach ($pers->getMapPersonaScenes() as $pms) {
            array_push($that->Scene, Scene::CREATE($pms->getScene()));
        }
        return $that;
    }
}


class SceneMapping {
    public $Scene = array();

    public function SceneMapping(){}

    public static function CREATE(){
        $map = new SceneMapping();
        foreach((new \SceneQuery())->find() as $scene)
        {
            array_push($map->Scene, Scene::CREATE_INCLUDING_PERSONA($scene) );
        }
        return $map;
    }
}


class PersonaMapping {
    public $Persona = array();

    public function PersonaMapping(){}

    public static function CREATE(){
        $map = new PersonaMapping();
        foreach((new \PersonaQuery())->find() as $pers)
        {
            array_push($map->Persona, Persona::CREATE_INCLUDING_SCENES($pers) );
        }
        return $map;
    }

    public static function CREATESCENEMAPPING(){
        return SceneMapping::CREATE();
    }
}
