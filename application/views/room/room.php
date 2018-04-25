
<script>
  window.onload = function() {
  for (var i=0; i<9; i++) {
    document.getElementById('game').innerHTML+='<a href="/room/move/' + i + '"><div class="block" id="' + i + '"></div></a>';
    }

    var allblock = document.getElementsByClassName('block');
    <?php foreach ($moves as $move) : ?>
    for (var i=0; i<9; i++) {
      if(i == <?php echo $move['cell'] ?>) {
        if(<?php echo $move['sign'] ?> == '0') {
          allblock[i].innerHTML = '0';
        }
        else {
          allblock[i].innerHTML = 'x';
        }
      }
    }
   <?php endforeach; ?> 
  }
</script>



<div id="timer"><script>window.setInterval(countdown, 500);</script></div>
<div id="timer_2"><script>window.setInterval(move_countdown, 500);</script></div>

<div id="game"></div>

<a href="/room/exit/">Выйти</a>