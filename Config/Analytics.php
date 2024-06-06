<?php 
namespace PhpCupcakes\Config;

class Analytics {

public static function Google() {
    ?>
<!--paste your google analytics code here-->
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-CPP1CGXHRC"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-CPP1CGXHRC');
</script>
<?php
}
}