<?php 
$property = $params['prop'];
$serviceGroup = $params['serviceGroup'];
?>

<div class="rightPageContainer">
	<h1 class="Success">Delete Service Group Property</h1><br/>
    <p>
	Are you sure you want to delete:<br/><br/>
	Property name: <b><?php echo $property->getKeyName();?><br/></b>
	Property value: <b><?php echo $property->getKeyValue();?><br/></b>
    </p>
    <p>
        Are you sure you wish to continue?
    </p>
    
    <form class="inputForm" method="post" action="index.php?Page_Type=Delete_Service_Group_Property&propertyid=<?php echo $property->getId();?>&id=<?php echo $serviceGroup->getId();?>" name="RemoveServiceGroupProperty">
        <input class="input_input_hidden" type="hidden" name="UserConfirmed" value="true" />
        <input type="submit" value="Remove this service group property from GOCDB" class="input_button">
    </form>

</div>