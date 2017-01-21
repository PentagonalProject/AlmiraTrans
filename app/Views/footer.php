<?php
use PentagonalProject\AlmiraTrans\Template;

if (!isset($this) || ! $this instanceof Template) {
    return;
}
?>
  </div>
  <!-- .wrap -->
  <script type="text/javascript">
    /* Write Javascript Assets Preload
     -------------------------------------- */
    var keyNameJs,
        jsBody = typeof jsBody == 'object' ? jsBody : {};
    for (keyNameJs in jsBody) {
        try {
            document.write('<script src="'+jsBody[keyNameJs]+'" type="text\/javascript" ><\/script>');
        } catch (err) {
        }
    }
  </script>
</body>
</html>