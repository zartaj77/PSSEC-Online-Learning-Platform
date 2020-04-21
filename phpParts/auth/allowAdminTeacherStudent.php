<?
if($session_role=="admin" || $session_role=="teacher" || $session_role=="student"){
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