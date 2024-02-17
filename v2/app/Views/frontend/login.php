<main class="form-signin surface text-center">
  <img src="<?php echo base_url('public/logo.png', env('protocol')); ?>" style="width: 240px;">
  <form class="content p-4 needs-validation m-auto" action="<?php echo base_url($locale . '/validate_login', env('protocol')) ?>" method="POST" novalidate>
    <h4 class="mb-3 fw-normal"><?php echo lang('General.login') ?></h4>
    <md-outlined-text-field name="userName" label="<?php echo lang('General.username') ?>" value="" error-text="Username not available">
    </md-outlined-text-field>
    <md-outlined-text-field type="password" name="password" autocomplete label="<?php echo lang('General.password') ?>" value="" error-text="Username not available">
    </md-outlined-text-field>
    <md-filled-button type="submit"><?php echo lang('General.login') ?></md-filled-button>
  </form>
</main>

<style>
  form {
    width: fit-content;
    min-width: 20rem;
  }

  form>* {
    display: block;
    margin: 0.5rem auto;
    width: fit-content;
  }
</style>