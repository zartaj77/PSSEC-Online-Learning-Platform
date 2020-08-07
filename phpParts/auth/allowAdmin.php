<?
if($session_role=="admin"){
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