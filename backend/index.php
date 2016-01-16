<?php
require_once 'vendor/autoload.php';
/*
require_once  'generated-classes\CardPointSystem.php';
require_once 'generated-classes\CardPointSystemQuery.php';
*/
require_once 'Db/Db.php';
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 2/19/2015
 * Time: 9:17 PM
 */

//Instantiate a Slim application:

$app = new \Slim\Slim(array(
    'debug' => true
));
$app->getLog()->setEnabled(true);
$app->getLog()->setLevel(\Slim\Log::DEBUG);
$GLOBALS['LOG'] = $app->getLog();


require_once 'requests/crud/frontend.php';

$app->get('/display/issuers', function () use ($app) {
    // query database for all cards

    $db = new \Db\Db();
    $cards = $db->GetIssuersForDisplay();
    // send response header for JSON content type
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    // return JSON-encoded response body with query results
    echo json_encode($cards);
});
$app->get('/display/affiliates', function () use ($app) {
    // query database for all cards

    $db = new \Db\Db();
    $cards = $db->GetAffiliatesForDisplay();
    // send response header for JSON content type
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    // return JSON-encoded response body with query results
    echo json_encode($cards);
});
$app->get('/display/stores', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $jTableResult = array();

    try {
        $jTableResult['data'] = $db->GetStoresForDisplay();
    } catch (\Exception $ex) {
        $jTableResult['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($jTableResult);
});
/*RewardTypes*/
$app->get('/display/reward/type/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetRewardTypeForDisplay()));
});
/*RewardCategories*/
$app->get('/display/reward/category/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetRewardCategoryForDisplay()));
});



$app->get('/display/creditcards', function () use ($app) {
    // query database for all cards

    $db = new \Db\Db();
    $cards = $db->GetCreditCardForDisplay();
    // send response header for JSON content type
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $jTableResult = array();
    //$jTableResult['Result'] = "OK";
    $jTableResult['data'] = $cards;
    // return JSON-encoded response body with query results
    #echo json_encode($cards[0]);
    echo json_encode($jTableResult);
});

$app->get('/crud/creditcards/by/id', function () use ($app) {
    // query database for all cards

    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $jTableResult = array();

    try {
        $jTableResult['data'] = $db->GetCreditCardById($app->request()->get('Id'));
    } catch(\Exception $ex) {
        $jTableResult['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($jTableResult);
});
$app->post('/crud/creditcards/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreateCreditCard($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/creditcards/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');


    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdateCreditCard($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->delete('/crud/creditcards/delete', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $request->delete('id');
    $jTableResult = array();
    //TODO handle errors
    foreach($ids as $id)
    {
        $app->getLog()->debug("Deleting credit card " . $id);
        $jTableResult['row'] = $db->DeleteCreditCard($id);
    }

    echo json_encode($jTableResult);
});



/*Reward types*/
$app->get('/crud/reward/type/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetRewardTypeForCrud()));
});
$app->delete('/crud/reward/type/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();
    //TODO handle errors
    foreach($ids as $id) {
        $app->getLog()->debug("/crud/reward/type/delete: Deleting point system " . $id);
        //TODO delete should handle also all dependent data
        $jTableResult['row'] = $db->DeleteRewardTypeForCrud($id);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/reward/type/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreateRewardTypeForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/reward/type/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');


    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdateRewardTypeForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->get('/crud/reward/type/by/id', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetRewardTypeById($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});

/*Reward categories*/
$app->get('/crud/reward/category/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Category', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetRewardCategoryForCrud()));
});
$app->delete('/crud/reward/category/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Category', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();
    //TODO handle errors
    foreach($ids as $id) {
        $app->getLog()->debug("/crud/reward/category/delete: Deleting point system " . $id);
        //TODO delete should handle also all dependent data
        $jTableResult['row'] = $db->DeleteRewardCategoryForCrud($id);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/reward/category/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Category', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreateRewardCategoryForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/reward/category/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Category', 'application/json;charset=utf-8');


    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdateRewardCategoryForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->get('/crud/reward/category/by/id', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Category', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetRewardCategoryById($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});


/*PointSystems*/
$app->get('/crud/pointsystem/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetPointSystemForCrud()));
});
$app->delete('/crud/pointsystem/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();
    //TODO handle errors
    foreach($ids as $id) {
        $app->getLog()->debug("/crud/pointsystem/delete: Deleting point system " . $id);
        //TODO delete should handle also all dependent data
        $jTableResult['row'] = $db->DeletePointSystemForCrud($id);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/pointsystem/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreatePointSystemForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/pointsystem/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');


    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdatePointSystemForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->get('/crud/pointsystem/by/creditcard', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetPointSystemForCard($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});
$app->get('/crud/pointsystem/by/id', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetPointSystemById($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});


/*PointAcquisitions*/
$app->get('/crud/pointacquisition/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetPointAcquisitionForCrud()));
});
$app->delete('/crud/pointacquisition/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();
    //TODO handle errors
    foreach($ids as $id) {
        $app->getLog()->debug("/crud/PointAcquisition/delete: Deleting point system " . $id);
        //TODO delete should handle also all dependent data
        $jTableResult['row'] = $db->DeletePointAcquisitionForCrud($id);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/pointacquisition/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreatePointAcquisitionForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/pointacquisition/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');


    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdatePointAcquisitionForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->get('/crud/pointacquisition/by/id', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetPointAcquisitionById($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});
$app->get('/crud/pointacquisition/by/pointsystem', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetPointAcquisitionByPointSystemId($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});



/*PointUsages*/
$app->get('/crud/pointusage/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetPointUsageForCrud()));
});
$app->delete('/crud/pointusage/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();
    //TODO handle errors
    foreach($ids as $id) {
        $app->getLog()->debug("/crud/PointUsage/delete: Deleting point system " . $id);
        //TODO delete should handle also all dependent data
        $jTableResult['row'] = $db->DeletePointUsageForCrud($id);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/pointusage/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreatePointUsageForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/pointusage/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');


    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdatePointUsageForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->get('/crud/pointusage/by/id', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetPointUsageById($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});
$app->get('/crud/pointusage/by/pointsystem', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetPointUsageByPointSystemId($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});


/*Rewards*/
$app->get('/crud/reward/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetRewardForCrud()));
});
$app->delete('/crud/reward/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();
    //TODO handle errors
    foreach($ids as $id) {
        $app->getLog()->debug("/crud/Reward/delete: Deleting point system " . $id);
        //TODO delete should handle also all dependent data
        $jTableResult['row'] = $db->DeleteRewardForCrud($id);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/reward/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreateRewardForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/reward/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');


    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdateRewardForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->get('/crud/reward/by/id', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetRewardById($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});
$app->get('/crud/reward/by/pointsystem', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetRewardByPointSystemId($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});


/*PointSystemMapping*/
$app->get('/crud/creditcard/pointsystem/mapping/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetCardPointSystemMappingForCrud()));
});
$app->delete('/crud/creditcard/pointsystem/mapping/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();
    //TODO handle errors
    foreach($ids as $id) {
        $app->getLog()->debug("/crud/pointsystem/delete: Deleting point system " . $id);
        //TODO delete should handle also all dependent data
        $jTableResult['row'] = $db->DeleteCardPointSystemMappingForCrud($id);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/creditcard/pointsystem/mapping/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreateCardPointSystemMappingForCrud($request->post('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/creditcard/pointsystem/mapping/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');


    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdateCardPointSystemMappingForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->get('/crud/creditcard/pointsystem/mapping/by/creditcard', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetCardPointSystemMappingForCard($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});
$app->get('/crud/creditcard/pointsystem/mapping/by/pointsystem', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetCardPointSystemMappingForPointSystem($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});



/*Issuers*/
$app->get('/crud/issuer/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetIssuerForCrud()));
});
$app->delete('/crud/issuer/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();
    //TODO handle errors
    foreach($ids as $id) {
        $app->getLog()->debug("Deleting credit card " . $id);
        $jTableResult['row'] = $db->DeleteIssuerForCrud($id);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/issuer/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreateIssuerForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/issuer/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');


    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdateIssuerForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});

/*Affiliates*/
$app->get('/crud/affiliate/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetAffiliatesForCrud()));
});
$app->delete('/crud/affiliate/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();
    //TODO handle errors
    foreach($ids as $id)
    {
        $app->getLog()->debug("Deleting credit card " . $id);
        $jTableResult['row'] = $db->DeleteAffiliatesForCrud($id);
    }

    echo json_encode($jTableResult);
});
$app->post('/crud/affiliate/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreateAffiliatesForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/affiliate/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');


    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdateAffiliatesForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});

/*InsuranceType*/
$app->get('/crud/insurance/type/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetInsuranceTypeForCrud()));
});
$app->delete('/crud/insurance/type/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();
    //TODO handle errors
    foreach($ids as $id) {
        $app->getLog()->debug("Deleting credit card " . $id);
        $jTableResult['row'] = $db->DeleteInsuranceTypeForCrud($id);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/insurance/type/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreateInsuranceTypeForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/insurance/type/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');


    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdateInsuranceTypeForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});

/*FeatureType*/
$app->get('/crud/feature/type/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetFeatureTypeForCrud()));
});
$app->delete('/crud/feature/type/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();
    //TODO handle errors
    foreach($ids as $id) {
        $app->getLog()->debug("Deleting feature type card " . $id);
        $jTableResult['row'] = $db->DeleteFeatureTypeForCrud($id);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/feature/type/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreateFeatureTypeForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/feature/type/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');


    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdateFeatureTypeForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});

/*Feature*/
$app->get('/crud/feature/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetFeatureForCrud()));
});
$app->delete('/crud/feature/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();
    //TODO handle errors
    foreach($ids as $id) {
        $app->getLog()->debug("Deleting feature type card " . $id);
        $jTableResult['row'] = $db->DeleteFeatureForCrud($id);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/feature/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreateFeatureForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/feature/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');


    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdateFeatureForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});

/*Feature*/
$app->get('/crud/feature/by/creditcard', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetFeaturesForCard($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});
$app->delete('/crud/feature/by/creditcard/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();

    //TODO handle errors
    foreach($ids as $id) {
        $app->getLog()->debug("Deleting feature type card " . $id);
        $jTableResult['row'] = $db->DeleteFeatureForCrud($id);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/feature/by/creditcard/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $data = $request->put('data');
        $jTableResult['row'] = $db->CreateFeatureForCard($data);
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/feature/by/creditcard/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdateFeatureForCard($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});

/*description */
$app->get('/crud/description/by/creditcard', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetDescriptionsForCard($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});
$app->delete('/crud/description/by/creditcard/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();

    //TODO handle errors
    foreach($ids as $id) {
        $app->getLog()->debug("Deleting feature type card " . $id);
        $jTableResult['row'] = $db->DeleteDescriptionForCrud($id);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/description/by/creditcard/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $data = $request->put('data');
        $jTableResult['row'] = $db->CreateDescriptionForCrud($data);
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/description/by/creditcard/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdateDescriptionForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});

/*Campaign*/
$app->get('/crud/campaign/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetCampaignForCrud()));
});
$app->get('/crud/campaign/by/creditcard', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetCampaignForCard($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});
$app->delete('/crud/campaign/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();
    //TODO handle errors
    foreach($ids as $id) {
        $app->getLog()->debug("Deleting credit card " . $id);
        $jTableResult['row'] = $db->DeleteCampaignForCrud($id);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/campaign/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreateCampaignForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/campaign/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');


    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdateCampaignForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});

/*Discount*/
$app->get('/crud/discount/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetDiscountForCrud()));
});
$app->get('/crud/discount/by/creditcard', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetDiscountForCard($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});
$app->delete('/crud/discount/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();
    //TODO handle errors
    foreach($ids as $id) {
        $app->getLog()->debug("Deleting credit card " . $id);
        $jTableResult['row'] = $db->DeleteDiscountForCrud($id);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/discount/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreateDiscountForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/discount/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');


    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdateDiscountForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});

/*Point Mapping*/
/*
$app->get('/crud/pointmapping/by/creditcard', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetPointMappingForCard($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});
$app->delete('/crud/pointmapping/by/creditcard/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();
    try {
        foreach($ids as $id) {
            $app->getLog()->debug("Deleting credit card " . $id);
            //throw new \Exception("don:t support delete");
            $jTableResult['row'] = $db->DeletePointMappingForCard($id);
        }
    } catch(\Exception $ex) {
        $jTableResult['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/pointmapping/by/creditcard/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreatePointMappingForCard($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/pointmapping/by/creditcard/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');


    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdatePointMappingForCard($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
*/



/*Store*/
$app->get('/crud/store/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetStoresForCrud()));
});
$app->delete('/crud/store/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();
    //TODO handle errors
    foreach($ids as $id) {
        $app->getLog()->debug("Deleting credit card " . $id);
        $jTableResult['row'] = $db->DeleteStoreForCrud($id);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/store/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreateStoreForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/store/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $id = $app->request()->put('id');
    if(!\Db\Utility\FieldUtils::ID_IS_DEFINED($id)) throw new Exception("No id found");

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdateStoreForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});

/*Insurance*/
$app->get('/crud/insurance/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetInsuranceForCrud()));
});
$app->get('/crud/insurance/by/creditcard', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetInsuranceForCard($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});
$app->delete('/crud/insurance/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();
    //TODO handle errors
    foreach($ids as $id) {
        $app->getLog()->debug("Deleting credit card " . $id);
        $jTableResult['row'] = $db->DeleteInsuranceForCrud($id);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/insurance/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreateInsuranceForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/insurance/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $id = $app->request()->put('id');
    if(!\Db\Utility\FieldUtils::ID_IS_DEFINED($id)) throw new Exception("No id found");

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdateInsuranceForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});

/*Interest*/
$app->get('/crud/interest/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetInterestForCrud()));
});
$app->get('/crud/interest/by/creditcard', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetInterestForCard($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});
$app->delete('/crud/interest/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();
    //TODO handle errors
    foreach($ids as $id) {
        $app->getLog()->debug("Deleting credit card " . $id);
        $jTableResult['row'] = $db->DeleteInterestForCrud($id);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/interest/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreateInterestForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/interest/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $id = $app->request()->put('id');
    if(!\Db\Utility\FieldUtils::ID_IS_DEFINED($id)) throw new Exception("No id found");

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdateInterestForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});

/*Fee*/
$app->get('/crud/fee/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetFeeForCrud()));
});
$app->get('/crud/fee/by/creditcard', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetFeeForCard($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});
$app->delete('/crud/fee/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();
    //TODO handle errors
    foreach($ids as $id) {
        $app->getLog()->debug("Deleting credit card " . $id);
        $jTableResult['row'] = $db->DeleteFeeForCrud($id);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/fee/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreateFeeForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/fee/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $id = $app->request()->put('id');
    if(!\Db\Utility\FieldUtils::ID_IS_DEFINED($id)) throw new Exception("No id found");

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdateFeeForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});

/*Unit*/
$app->get('/crud/unit/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetUnitForCrud()));
});
$app->delete('/crud/unit/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();
    //TODO handle errors
    foreach($ids as $id) {
        $app->getLog()->debug("/crud/unit/delete: Deleting point system " . $id);
        //TODO delete should handle also all dependent data
        $jTableResult['row'] = $db->DeleteUnitForCrud($id);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/unit/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreateUnitForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/unit/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');


    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdateUnitForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->get('/crud/unit/by/id', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetUnitById($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});


/* StoreCategory */
$app->get('/crud/storecategory/all', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    echo json_encode(array('data'=> $db->GetStoreCategoryForCrud()));
});
$app->delete('/crud/storecategory/delete', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $ids = $app->request()->delete('id');
    $jTableResult = array();
    //TODO handle errors
    foreach($ids as $id) {
        $app->getLog()->debug("/crud/StoreCategory/delete: Deleting point system " . $id);
        //TODO delete should handle also all dependent data
        $jTableResult['row'] = $db->DeleteStoreCategoryForCrud($id);
    }
    echo json_encode($jTableResult);
});
$app->post('/crud/storecategory/create', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->CreateStoreCategoryForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->put('/crud/storecategory/update', function () use ($app) {
    $db = new \Db\Db();
    $request = $app->request();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');


    $jTableResult = array();
    try {
        $jTableResult['row'] = $db->UpdateStoreCategoryForCrud($request->put('data'));
    } catch(\Exception $e) {
        $jTableResult['error'] = $e->getMessage();
        $app->getLog()->error($e);
    }

    echo json_encode($jTableResult);
});
$app->get('/crud/storecategory/by/id', function () use ($app) {
    $db = new \Db\Db();
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');

    $result = array();
    try {
        $result['data'] = $db->GetStoreCategoryById($app->request()->get('Id'));
    } catch (\Exception $ex) {
        $result['error'] = $ex->getMessage();
        $app->getLog()->error($ex);
    }

    echo json_encode($result);
});

require_once 'requests/crud/persona.php';
require_once 'requests/crud/restrictions.php';
require_once 'requests/crud/payment_type.php';

//Run the Slim application:
$app->run();
