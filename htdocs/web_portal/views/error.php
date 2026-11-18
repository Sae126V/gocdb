<div class="rightPageContainer">
    <h1>Error</h1>
    <br />
    <?php
    $msg = (string) $params;

    if(strpos($msg, 'DOCSVN.SERV_KEYPAIRS') || strpos($msg, 'DOCSVN.SITE_KEYPAIRS')){
        echo "A key value pair already exists with this keyname and keyvalue.";
    }else{
        xecho($msg);
    }

    ?>
</div>
