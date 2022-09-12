<script>

  <?php if($this->session->flashdata('success')){ ?>
    console.log('<?php echo $this->session->flashdata('success'); ?>');

  <?php }else if($this->session->flashdata('error')){  ?>

  <?php }else if($this->session->flashdata('warning')){  ?>

  <?php }else if($this->session->flashdata('info')){  ?>

  <?php } ?>

</script>
