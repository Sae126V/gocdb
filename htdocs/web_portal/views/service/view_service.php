<?php
$se = $params['se'];
$parentSiteName = $se->getParentSite()->getName();
$serviceProperties = $se->getServiceProperties();
$seId = $se->getId();
$configService = \Factory::getConfigService();
?>
<div class="rightPageContainer rounded">
    <div style="float: left; text-align: center;">
        <img src="img/service.png" class="pageLogo" />
    </div>
    <div style="float: left; width: 50em;">
        <h1 style="float: left; margin-left: 0em;"><?php echo 'Service: '.$se->getHostname() ?> - <?php echo $se->getServiceType()-> getName() ?></h1>
        <span style="clear: both; float: left; padding-bottom: 0.4em;"><?php echo $se->getDescription() ?></span>
    </div>

    <!--  Edit link -->
    <!--  only show this link if we're in read / write mode -->
    <?php if(!$params['portalIsReadOnly']): ?>
        <div style="float: right;">
            <div style="float: right; margin-left: 2em;">
                <a href="index.php?Page_Type=Edit_Service&id=<?php echo $se->getId() ?>">
                    <img src="img/pencil.png" height="25px" style="float: right;" />
                    <br />
                    <br />
                    <span>Edit</span>
                </a>
            </div>
            <div style="float: right;">
                <script type="text/javascript" src="javascript/confirm.js"></script>
                <a onclick="return confirmSubmit()"
                    href="index.php?Page_Type=Delete_Service&id=<?php echo $se->getId() ?>">
                    <img src="img/cross.png" height="25px" style="float: right; margin-right: 0.4em;" />
                    <br />
                    <br />
                    <span>Delete</span>
                </a>
            </div>
        </div>
    <?php endif; ?>

    <!-- System and Grid Information -->
    <div style="float: left; width: 100%; margin-top: 2em;">
        <!--  System -->
        <div class="tableContainer rounded" style="width: 55%; float: left;">
            <span class="header" style="vertical-align:middle; float: left; padding-top: 0.9em; padding-left: 1em;">System</span>
            <img src="img/server.png" class="titleIcon"/>
            <table style="clear: both; width: 100%;">
                <tr class="site_table_row_1">
                    <td class="site_table">Host name</td><td class="site_table"><?php echo $se->getHostName() ?></td>
                </tr>
                <tr class="site_table_row_2">
                    <td class="site_table">IP Address</td><td class="site_table"><?php echo $se->getIpAddress() ?></td>
                </tr>
                <tr class="site_table_row_1">
                    <td class="site_table">IP v6 Address</td><td class="site_table"><?php echo $se->getIpV6Address() ?></td>
                </tr>	
                <tr class="site_table_row_2">
                    <td class="site_table">Operating System</td><td class="site_table"><?php echo $se->getOperatingSystem() ?></td>
                </tr>
                <tr class="site_table_row_1">
                    <td class="site_table">Architecture</td><td class="site_table"><?php echo $se->getArchitecture()?></td>
                </tr>
                <tr class="site_table_row_2">
                    <td class="site_table">Contact E-Mail</td><td class="site_table"><?php echo $se->getEmail() ?></td>
                </tr>
            </table>
        </div>

        <!--  Grid Information -->
        <div class="tableContainer rounded" style="width: 42%; float: right;">
            <span class="header" style="vertical-align:middle; float: left; padding-top: 0.9em; padding-left: 1em;">Grid Information</span>
            <img src="img/grid.png" class="titleIcon"/>
            <table style="width: 100%; word-wrap:break-word;
              table-layout: fixed;">
                <tr class="site_table_row_1">
                    <td class="site_table" style="width: 5em;">Host DN</td><td class="site_table">
                    	<div style="word-wrap: break-word;">
                    			<?php echo $se->getDn() ?>
                    	</div>
                   	</td>
                </tr>
                <tr class="site_table_row_2">
					<td class="site_table">URL</td><td class="site_table"><?php echo $se->getUrl() ?></td>
                </tr>
                <tr class="site_table_row_1">
                    <td class="site_table">Parent Site</td>
					<td class="site_table">
						<a href="index.php?Page_Type=Site&id=<?php echo $se->getParentSite()->getId() ?>">
							<?php echo $se->getParentSite()->getShortName(); ?>
						</a>
					</td>
                </tr>
				<!-- scope: remove this for a non-scoping version of view_service -->
                <tr class="site_table_row_2">
                    <td class="site_table"><a href="index.php?Page_Type=Scope_Help" style="word-wrap: normal">Scope(s)</a></td>
                    <td class="site_table">
                        <?php $count = 0;
                              $numScopes = sizeof($params['Scopes']);
                        foreach ($params['Scopes'] as $scopeName => $sharedWithParent){ ?>
                            <?php if($sharedWithParent): ?>
                                <span>
                                    <?php echo $scopeName; if(++$count!=$numScopes){echo", ";}?>
                                </span>
                            <?php else: ?>
                                <span title="Info - The parent site <?php echo $parentSiteName ?> does not share this scope" style="color:mediumvioletred;">
                                     <?php echo $scopeName . 
                                "</span>".//Echoed span required to prevent space before comma
                                "<span>";
                                    if(++$count!=$numScopes){echo", ";}?>
                                </span>
                            <?php endif; ?>
                        <?php } ?>
                    </td>
                </tr>

            </table>
        </div>
    </div>

    <!-- Project Data and hosting Service Groups -->
    <div style="float: left; width: 100%; margin-top: 3em;">
        <!--  Project Data -->
        <div class="tableContainer rounded" style="width: 55%; float: left;">
            <span class="header" style="vertical-align:middle; float: left; padding-top: 0.9em; padding-left: 1em;">Project Data</span>
            <img src="img/project.png" class="titleIcon"/>
            <table style="clear: both; width: 100%;">
                <tr class="site_table_row_1">
                    <td class="site_table">Production Level</td>
					<td class="site_table">
					<?php
					switch($se->getProduction() ) {
							case true:
								?>
								<img src="img/tick.png" height="22px" style="vertical-align: middle;" />
								<?php
								break;
							case false:
								?>
								<img src="img/cross.png" height="22px" style="vertical-align: middle;" />
								<?php
								break;
						}
					?>
					</td>
                </tr>
                <tr class="site_table_row_2">
                    <td class="site_table">Beta</td><td class="site_table">
					<?php
					switch($se->getBeta()) {
							case true:
								?>
								<img src="img/tick.png" height="22px" style="vertical-align: middle;" />
								<?php
								break;
							case false:
								?>
								<img src="img/cross.png" height="22px" style="vertical-align: middle;" />
								<?php
								break;
							default:
								?>
								<img src="img/cross.png" height="22px" style="vertical-align: middle;" />
								<?php
								break;
						}
					?>
					</td>
                </tr>
                <tr class="site_table_row_1">
                    <td class="site_table">Monitored</td><td class="site_table">
					<?php
					switch($se->getMonitored()) {
							case true:
								?>
								<img src="img/tick.png" height="22px" style="vertical-align: middle;" />
								<?php
								break;
							case false:
								?>
								<img src="img/cross.png" height="22px" style="vertical-align: middle;" />
								<?php
								break;
						}
					?>
					</td>
                </tr>
            </table>
        </div>

        <!-- Service Groups -->
        <div class="tableContainer rounded" style="width: 42%; float: right;">
            <span class="header" style="vertical-align:middle; float: left; padding-top: 0.9em; padding-left: 1em;">Service Groups this Service Belongs To</span>
            <img src="img/virtualSite.png" class="titleIcon"/>
            <table style="clear: both; width: 100%;">
                <?php
                    $num = 1;
                    foreach($params['sGroups'] as $sg) {
                ?>
                <tr class="site_table_row_<?php echo $num; ?>">
                    <td class="site_table">
                        <a href="index.php?Page_Type=Service_Group&id=<?php echo $sg->getId()?>">
                            <?php echo $sg->getName() ?>
                        </a>
                    </td>
                </tr>
                <?php
                        if($num == 1) { $num = 2; } else { $num = 1; }
                    }
                ?>
            </table>
        </div>
    </div>
    
     <!-- Service Endpoints -->
    <div class="tableContainer" style="width: 99.5%; float: left; margin-top: 3em; margin-right: 10px;">
        <span class="header" style="vertical-align:middle; float: left; padding-top: 0.9em; padding-left: 1em;">
            Service Endpoints 
            <a href="#" id="serviceEndpointLink" data-toggle="tooltip" data-placement="right" 
                title="A Service may define optional Endpoint objects which 
                model network locations for different service-functionalities 
                that can't be described by the main ServiceType and URL alone.">(endpoints?)</a>
        </span>        
        <img src="img/serviceEndpoint.png" class="titleIcon"/>
        <table style="clear: both; width: 100%;">
            <tr class="site_table_row_1">
                <th class="site_table">Name</th>
                <th class="site_table">URL</th>
                <th class="site_table">Interface Name</th>
                <?php if(!$params['portalIsReadOnly']): ?>
                <th class="site_table" >Edit</th>  
                <th class="site_table" >Remove</th>  
                <?php endif; ?>              
            </tr>
            <?php
            $num = 2;
            foreach($se->getEndpointLocations() as $endpoint) {
	            ?>
                                
	            <tr class="site_table_row_<?php echo $num ?>">
	                <td style="width: 30%;"class="site_table">
                        <a href="index.php?Page_Type=View_Service_Endpoint&id=<?php echo $endpoint->getId() ?>">
                            <?php echo $endpoint->getName() ?>
                        </a> 
                    </td>
	                <td style="width: 30%;"class="site_table"><?php echo $endpoint->getUrl(); ?></td>
	                <td style="width: 30%;"class="site_table"><?php echo $endpoint->getInterfaceName(); ?></td>
	                <?php if(!$params['portalIsReadOnly']): ?>	                
	               	<td style="width: 10%;"align = "center"class="site_table"><a href="index.php?Page_Type=Edit_Service_Endpoint&endpointid=<?php echo $endpoint->getId();?>&serviceid=<?php echo $seId;?>"><img height="25px" src="img/pencil.png"/></a></td>
	                <td style="width: 10%;"align = "center"class="site_table"><a href="index.php?Page_Type=Delete_Service_Endpoint&endpointid=<?php echo $endpoint->getId();?>&serviceid=<?php echo $seId;?>"><img height="25px" src="img/cross.png"/></a></td>
	                <?php endif; ?>
	            </tr>
	            <?php
	            if($num == 1) { $num = 2; } else { $num = 1; }
            }
            ?>
        </table>
        <!--  only show this link if we're in read / write mode -->
		<?php if(!$params['portalIsReadOnly']): ?>
            <!-- Add new Service Endpoint -->
            <a href="index.php?Page_Type=Add_Service_Endpoint&se=<?php echo $se->getId();?>">
                <img src="img/add.png" height="50px" style="float: left; padding-top: 0.9em; padding-left: 1.2em; padding-bottom: 0.9em;"/>
                <span class="header" style="vertical-align:middle; float: left; padding-top: 1.1em; padding-left: 1em; padding-bottom: 0.9em;">
                        Add Endpoint
                </span>
            </a>
		<?php endif; ?>
    </div>
    
   
    
    <!--  Service Properties -->
    <div class="tableContainer" style="width: 99.5%; float: left; margin-top: 3em; margin-right: 10px;">
        <span class="header" style="vertical-align:middle; float: left; padding-top: 0.9em; padding-left: 1em;">
            Service Extension Properties
            <a href="#" id="extensionsLink" data-toggle="tooltip" data-placement="right" 
                title="A Service may define optional extension properties to define custom key-value pairs.  
                Extension properties can be used for fine-grained resource selection in the PI.">
                (extensions?)
            </a>
        </span>        
        <img src="img/keypair.png" height="25px" style="float: right; padding-right: 1em; padding-top: 0.5em; padding-bottom: 0.5em;" />
        <table style="clear: both; width: 100%;">
            <tr class="site_table_row_1">
                <th class="site_table">Name</th>
                <th class="site_table" >Value</th>  
                <?php if(!$params['portalIsReadOnly']): ?>
                <th class="site_table" >Edit</th>  
                <th class="site_table" >Remove</th>  
                <?php endif; ?>              
            </tr>
            <?php
            $num = 2;
            foreach($serviceProperties as $sp) {
	            ?>

	            <tr class="site_table_row_<?php echo $num ?>">
	                <td style="width: 35%;"class="site_table"><?php echo $sp->getKeyName(); ?></td>
	                <td style="width: 35%;"class="site_table"><?php echo $sp->getKeyValue(); ?></td>
	                <?php if(!$params['portalIsReadOnly']): ?>	                
	               	<td style="width: 10%;"align = "center"class="site_table"><a href="index.php?Page_Type=Edit_Service_Property&propertyid=<?php echo $sp->getId();?>&serviceid=<?php echo $seId;?>"><img height="25px" src="img/pencil.png"/></a></td>
	                <td style="width: 10%;"align = "center"class="site_table"><a href="index.php?Page_Type=Delete_Service_Property&propertyid=<?php echo $sp->getId();?>&serviceid=<?php echo $seId;?>"><img height="25px" src="img/cross.png"/></a></td>
	                <?php endif; ?>
	            </tr>
	            <?php
	            if($num == 1) { $num = 2; } else { $num = 1; }
            }
            ?>
        </table>
        <!--  only show this link if we're in read / write mode -->
		<?php if(!$params['portalIsReadOnly']): ?>
            <!-- Add new Service Property -->
            <a href="index.php?Page_Type=Add_Service_Property&se=<?php echo $se->getId();?>">
                <img src="img/add.png" height="50px" style="float: left; padding-top: 0.9em; padding-left: 1.2em; padding-bottom: 0.9em;"/>
                <span class="header" style="vertical-align:middle; float: left; padding-top: 1.1em; padding-left: 1em; padding-bottom: 0.9em;">
                        Add Property
                </span>
            </a>
		<?php endif; ?>
    </div>
    
        <!--  Downtimes -->
    <div class="listContainer rounded" style="width: 99.5%; float: left; margin-top: 3em; margin-right: 10px;">
        <span class="header" style="vertical-align:middle; float: left; padding-top: 0.9em; padding-left: 1em;">Recent Downtimes</span>
        <a href="index.php?Page_Type=SE_Downtimes&id=<?php echo $se->getId(); ?>" style="vertical-align:middle; float: left; padding-top: 1.3em; padding-left: 1em; font-size: 0.8em;">(View all Downtimes)</a>
        <img src="img/down_arrow.png" height="25px" style="float: right; padding-right: 1em; padding-top: 0.5em; padding-bottom: 0.5em;" />
        <table style="clear: both; width: 100%;">
            <tr class="site_table_row_1">
                <th class="site_table">Description</th>
                <th class="site_table">From</th>
                <th class="site_table">To</th>

            </tr>
            <?php
            $num = 2;
            foreach($params['Downtimes'] as $d) {
            ?>

            <tr class="site_table_row_<?php echo $num ?>">
                <td class="site_table">
                	<a style="padding-right: 1em;" href="index.php?Page_Type=Downtime&id=<?php echo $d->getId() ?>">
                		<?php echo $d->getDescription() ?>
                	</a>
                </td>
                <td class="site_table"><?php echo $d->getStartDate()->format($d::DATE_FORMAT) ?></td>
                <td class="site_table"><?php echo $d->getEndDate()->format($d::DATE_FORMAT) ?></td>
            </tr>
            <?php
                if($num == 1) { $num = 2; } else { $num = 1; }
            }
            ?>
        </table>
        <!--  only show this link if we're in read / write mode -->
		<?php if(!$params['portalIsReadOnly']): ?>
            <!-- Add new Downtime Link -->
            <a href="index.php?Page_Type=Add_Downtime&se=<?php echo $se->getId();?>">
                <img src="img/add.png" height="50px" style="float: left; padding-top: 0.9em; padding-left: 1.2em; padding-bottom: 0.9em;"/>
                <span class="header" style="vertical-align:middle; float: left; padding-top: 1.1em; padding-left: 1em; padding-bottom: 0.9em;">
                        Add Downtime
                </span>
            </a>
		<?php endif; ?>
    </div>
    
</div>

 <script type="text/javascript">
    $(document).ready(function() {
        $('#serviceEndpointLink').tooltip();
        $('#extensionsLink').tooltip(); 
    }); 
</script>
    