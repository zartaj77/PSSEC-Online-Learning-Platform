<?
if($session_role=="admin" || $session_role=="teacher"){
    1;
}
else{
    ?>
        <script type="text/javascript">
            window.location = "./?access-denied=1";
        </script>
    <?
}
?>