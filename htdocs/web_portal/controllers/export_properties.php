<?php
/*______________________________________________________
 *======================================================
 * File: export_properties.php
 * Author: Tom Byrne
 * Description: Outputs an objects properties in a .prop style
 *              Accepts object type, and id
 *
 *
 * License information
 *
 * Copyright 2015 STFC
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

function export() {

    require_once __DIR__.'/../../../lib/Gocdb_Services/Factory.php';
    require_once __DIR__.'/../components/Get_User_Principle.php';
    $params = array();
    $parentType = isset($_REQUEST['parent_type']) ? $_REQUEST['parent_type'] : null;
    $parentId = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
    switch($parentType){
        case "Service" :
            $service = \Factory::getServiceService()->getService($parentId);
            $params['properties'] = $service->getServiceProperties();
            break;
        case "EndpointLocation" :
            $endpoint = \Factory::getServiceService()->getEndpoint($parentId);
            $params['properties'] = $endpoint->getEndpointProperties();
            break;
        case "Site" :
            $site = \Factory::getSiteService()->getSite($parentId);
            $params['properties'] = $site->getSiteProperties();
            break;
        case "ServiceGroup" :
            $serviceGroup = \Factory::getServiceGroupService()->getServiceGroup($parentId);
            $params['properties'] = $serviceGroup->getServiceGroupProperties();
            break;
    }

    //The "true" as the 4th arg tells show_view not to draw the header and sidebar
    show_view('exportProperties.php', $params, null, true);

}





?>