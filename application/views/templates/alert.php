<script>

  <?php if($this->session->flashdata('success')){ ?>
    console.log('<?php echo $this->session->flashdata('success'); ?>');

    // new PNotify({
    //     title: "PNotify",
    //     type: "info",
    //     text: "Welcome. Try hovering over me. You can click things behind me, because I'm non-blocking.",
    //     nonblock: {
    //       nonblock: true
    //     },
    //     addclass: 'dark',
    //     styling: 'bootstrap3',
    //     hide: false,
    //     before_close: function(PNotify) {
    //     PNotify.update({
    //       title: PNotify.options.title + " - Enjoy your Stay",
    //       before_close: null
    //     });

    //     PNotify.queueRemove();

    //     return false;
    //     }
    //   });







  <?php }else if($this->session->flashdata('error')){  ?>

  <?php }else if($this->session->flashdata('warning')){  ?>

  <?php }else if($this->session->flashdata('info')){  ?>

  <?php } ?>

</script>
