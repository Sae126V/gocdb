<?php
/*______________________________________________________
 *======================================================
 * File: view_services.php
 * Author: James McCarthy
 * Description: Retrieves and draws a select list for services with nested endpoints from a given site
 *
 * License information
 *
 * Copyright 2009 STFC
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 /*====================================================== */
use Doctrine\Common\Collections\ArrayCollection;
use Exception;

function getServiceandEndpointList()
{
    require_once __DIR__ . '/../utils.php';
    require_once __DIR__ . '/../../../web_portal/components/Get_User_Principle.php';

    $params = [];
    $identifier = Get_User_Principle();
    $user = \Factory::getUserService()->getUserByPrinciple($identifier);
    $params['portalIsReadOnly'] = portalIsReadOnlyAndUserIsNotAdmin($user);
    $siteIDs = $_REQUEST['site_id'];

    if (empty($siteIDs)) {
        throw new Exception("Please select at least one site.");
    }

    $services = new ArrayCollection();

    foreach ($siteIDs as $value) {
        $site = \Factory::getSiteService()->getSite($value);
        $services[$value] = $site->getServices();
    }

    $params['services'] = $services;

    show_view("downtime/view_nested_endpoints_list.php", $params, null, true);
}

/**
 * This is a secondary function to handle the rendering of
 * `Edit_Downtime_view_endpoint_tree` page when editing the downtime.
 */
function editDowntimePopulateEndpointTree()
{
    require_once __DIR__ . '/../utils.php';
    require_once __DIR__ . '/../../../web_portal/components/Get_User_Principle.php';

    $params = [];
    $identifier = Get_User_Principle();
    $user = \Factory::getUserService()->getUserByPrinciple($identifier);
    $params['portalIsReadOnly'] = portalIsReadOnlyAndUserIsNotAdmin($user);
    $siteIDs = $_REQUEST['site_id'];

    if (empty($_REQUEST['site_id'])) {
        throw new Exception("Please select at least one site.");
    }
    if (!isset($_REQUEST['dt_id']) || !is_numeric($_REQUEST['dt_id'])) {
        throw new Exception("A downtime id must be specified");
    }

    $services = new ArrayCollection();

    foreach ($siteIDs as $value) {
        $site = \Factory::getSiteService()->getSite($value);
        $services[$value] = $site->getServices();
    }

    $params['services'] = $services;
    $downtime = \Factory::getDowntimeService()->getDowntime($_REQUEST['dt_id']);
    $params['downtime'] = $downtime;

    show_view(
        "downtime/downtime_edit_view_nested_endpoints_list.php",
        $params,
        null,
        true
    );
}
