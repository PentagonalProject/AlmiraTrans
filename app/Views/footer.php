<?php
use PentagonalProject\AlmiraTrans\Template;

if (!isset($this) || ! $this instanceof Template) {
    return;
}
?>
  </div>
  <!-- .wrap -->
  <!--
    // javascript
  -->
  <script type="text/javascript" async>
    var keyNameJs,
        jsBody = typeof jsBody == 'object' ? jsBody : {};

    for (keyNameJs in jsBody) {
        try {
            document.write('<script src="'+ jsBody[keyNameJs] +'" type="text/javascript"><\/script>');
        } catch (err) {}
    }
  </script>
</body>
</html>